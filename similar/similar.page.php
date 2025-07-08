<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=page.tags
Tags=page.tpl:{SIMILAR_PAGES}
[END_COT_EXT]
==================== */

// Проверка на прямой доступ к файлу
defined('COT_CODE') or die('Wrong URL.');

// Подключение языкового файла плагина
require_once cot_langfile('similar');

// Получение лимита похожих записей из настроек плагина
$limit = Cot::$cfg['plugin']['similar']['max_sim'];

// Очистка заголовка текущей страницы от спецсимволов для безопасного поиска
$title = preg_replace('#[^\p{L}0-9\-_ ]#u', ' ', $pag['page_title']);

// Инициализация шаблона плагина
$t1 = new XTemplate(cot_tplfile('similar', 'plug'));

// Увеличенный лимит записей для предварительного поиска (в 3 раза больше основного лимита)
$l3 = $limit * 3;

// Выполнение запроса на поиск похожих страниц по заголовку (fulltext search)
$sql_sim = Cot::$db->query("
	SELECT p.*, u.*
	FROM {$db_pages} AS p
	LEFT JOIN {$db_users} AS u ON u.user_id = p.page_ownerid
	WHERE (p.page_state = 0 OR p.page_state = 2)
		AND p.page_id != ?
		AND MATCH (p.page_title) AGAINST (?) > ?
	LIMIT ?
", [$pag['page_id'], $title, Cot::$cfg['plugin']['similar']['relev'], $l3]);

// Проверка, есть ли результаты
if ($sql_sim->rowCount() > 0)
{
	// Инициализация массивов для трёх уровней релевантности: та же подкатегория, та же категория, весь сайт
	$samesubcat = [];
	$samecat = [];
	$samesite = [];

	// Получение всех результатов в массив
	$results = $sql_sim->fetchAll();

	// Разделение найденных страниц по релевантности
	foreach ($results as $row)
	{
		if ($row['page_cat'] === $pag['page_cat']) {
			// Точно та же подкатегория
			$samesubcat[] = $row;
		}
		elseif (str_starts_with(Cot::$structure['page'][$pag['page_cat']]['path'], Cot::$structure['page'][$row['page_cat']]['path'])) {
			// Общая родительская категория
			$samecat[] = $row;
		}
		else {
			// Остальные страницы
			$samesite[] = $row;
		}
	}

	// Инициализация индексов
	$i = 1; // Номер текущей похожей страницы
	$j = 0; // Индекс в текущем списке
	$k = 1; // 1 - samesubcat, 2 - samecat, 3 - samesite

	// Заполнение шаблона пока не достигнут лимит
	while ($i <= $limit)
	{
		// Если список текущего уровня закончился — переход на следующий
		if ($k === 1 && $j >= count($samesubcat)) {
			$k = 2;
			$j = 0;
		}
		if ($k === 2 && $j >= count($samecat)) {
			$k = 3;
			$j = 0;
		}
		if ($k === 3 && $j >= count($samesite)) {
			break;
		}

		// Получение текущей записи
		$row = match($k) {
			1 => $samesubcat[$j],
			2 => $samecat[$j],
			default => $samesite[$j],
		};

		// Формирование URL страницы (по алиасу или ID)
		$row['page_pageurl'] = empty($row['page_alias'])
			? cot_url('page', ['c' => $row['page_cat'], 'id' => $row['page_id']])
			: cot_url('page', ['c' => $row['page_cat'], 'al' => $row['page_alias']]);

		// Назначение порядкового номера
		$t1->assign('SIMILAR_ROW_NUMBER', $i);

		// Назначение тэгов страницы
		$t1->assign(cot_generate_pagetags(
			$row,
			'SIMILAR_ROW_',
			0,
			Cot::$usr['isadmin'],
			Cot::$cfg['homebreadcrumb'],
			'',
			$row['page_pageurl']
		));
		$t1->assign('SIMILAR_ROW_TEXT_CUT_STRIP', cot_string_truncate(htmlspecialchars(strip_tags($row['page_text']), ENT_QUOTES, 'UTF-8'), 120, false));
		// Назначение информации о владельце страницы
		$t1->assign('SIMILAR_ROW_OWNER', cot_build_user($row['page_ownerid'], $row['user_name']));
		$t1->assign(cot_generate_usertags($row, 'SIMILAR_ROW_OWNER_'));

		// Увеличение счётчиков
		$i++;
		$j++;

		// Парсинг строки в шаблоне
		$t1->parse('MAIN.SIMILAR_ROW');
	}

	// Финальный парсинг и сборка HTML
	$t1->parse('MAIN');
	$plugin_out = $t1->text('MAIN');
}
else
{
	// Если похожих страниц не найдено — парсим блок NOTFOUND
	$t1->parse('NOTFOUND');
	$plugin_out = $t1->text('NOTFOUND');
}

// Назначаем финальный HTML в основной шаблон страницы
$t->assign('SIMILAR_PAGES', $plugin_out);

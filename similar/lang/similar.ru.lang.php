<?php
defined('COT_CODE') or die('Wrong URL.');

/**
 * Plugin Config
 */

$L['cfg_max_sim'] = 'Макс. похожих страниц для показа';
$L['cfg_max_sim_hint'] = 'максимальное количество похожих страниц (по умолчанию 5)';
$L['cfg_relev'] = 'Строгость релевантности';
$L['cfg_relev_hint'] = 'минимальный порог релевантности';

/**
 * Plugin Title & Subtitle
 */
$L['info_name'] = 'Similar pages';
$L['info_desc'] = 'На странице статьи, выводит ревалентные, похожие страницы, если они есть';
$L['info_notes'] = 'adapted to Cotonti 0.9.26 beta, php >= 8.3+ & Bootstrap 5.3 by <a href="https://github.com/webitproff" target="_blank"><span class="text-primary-emphasis fw-bold">webitproff</span></a>. В page.tpl после комментариев добавить <code>{SIMILAR_PAGES}</code>';

/**
 * Plugin Body
 */

$L['Similar_pages'] = 'Похожие страницы';
$L['Similar_notfound'] = 'Похожих страниц не найдено';

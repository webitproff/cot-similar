# Similar Pages Plugin for Cotonti v0.9.26

## Purpose

The Similar Pages plugin displays a block of similar pages (articles) based on the title of the current page, ranked by relevance:

- Pages from the same subcategory
- Pages from the same parent category
- Other pages across the entire site
- Somewhat useful for SEO


<img src="https://raw.githubusercontent.com/webitproff/cot-similar/refs/heads/main/cot-similar-00.jpg" alt="Cotonti CMF">

<img src="https://raw.githubusercontent.com/webitproff/cot-similar/refs/heads/main/cot-similar.jpg" alt="Cotonti CMF">


## Features

- Uses MySQL full-text search on the `page_title` field
- Caching and templating via XTemplate
- Supports compatibility with PHP 8.3

## Plugin Components

- `similar/similar.page.php` — Main plugin handler, connects to the `page.tags` hook to integrate its tags with the Pages module
- `similar/tpl/similar.tpl` — Template for displaying similar pages
- `similar/lang/similar.ru.lang.php` — Russian language file
- `similar/lang/similar.en.lang.php` — English language file
- `similar/similar.setup.php` — Plugin installation file and configuration
- `similar/setup/similar.install.sql` — Database installation query:

```sql
ALTER TABLE `cot_pages` ADD FULLTEXT `page_title_fulltext` (`page_title`);
```

- `similar/setup/similar.uninstall.sql` — Database uninstallation query:

```sql
ALTER TABLE `cot_pages` DROP INDEX `page_title_fulltext`;
```

## Installation Instructions

1. Download the plugin and unzip the archive on your PC.
2. Upload the `similar` folder to the `plugins` directory of your Cotonti site.
3. Install the plugin in the Cotonti admin panel:
   - Go to Control Panel → Extensions → Similar Pages → Click "Install"
   - Then click "Configuration" and set your desired settings, for example:
     - Max similar pages to display: 3
     - Relevance strictness: 5
     - Max title length: 120
4. Installation is complete.

## Template Integration (Required)

1. In your theme, locate the `page.tpl` template, for example:  
   [https://github.com/webitproff/cot_2waydeal_build/tree/master/public_html/themes/2waydeal/modules/page](https://github.com/webitproff/cot_2waydeal_build/tree/master/public_html/themes/2waydeal/modules/page)

   Insert the following where you want the similar pages block to appear (e.g., after comments):

   ```html
   <!-- IF {PHP|cot_plugin_active('similar')} --> 
   {SIMILAR_PAGES}
   <!-- ENDIF -->
   ```

2. Customize the `similar.tpl` template to your liking. Example:

   ```html
   <!-- BEGIN: MAIN -->
   <div class="col-12">
       <h4 class="mb-3">{PHP.L.Similar_pages}</h4>
       <div class="list-group mb-3">
           <!-- BEGIN: SIMILAR_ROW -->
           <div class="list-group-item list-group-item-action">
               <div class="align-items-center">
                   <div class="col-12">
                       <a href="{SIMILAR_ROW_URL}" class="fw-bold text-decoration-none">{SIMILAR_ROW_TITLE}</a>
                       <div class="text-muted small">
                           {SIMILAR_ROW_NUMBER} {SIMILAR_ROW_TEXT_CUT_STRIP}
                       </div>					
                       <div class="text-muted small">
                           {SIMILAR_ROW_CAT_PATH_SHORT} • {SIMILAR_ROW_CREATED} {SIMILAR_ROW_OWNER}
                       </div>
                   </div>
               </div>
           </div>
           <!-- END: SIMILAR_ROW -->
       </div>
   </div>
   <!-- END: MAIN -->

   <!-- BEGIN: NOTFOUND -->
   <div class="col-12">
       <div class="alert alert-info" role="alert">
           {PHP.L.Similar_notfound}
       </div>
   </div>
   <!-- END: NOTFOUND -->
   ```

## Tag Reference for `similar.tpl`

1. `{SIMILAR_ROW_TITLE}` - Page title, generated via `cot_generate_pagetags`
2. `{SIMILAR_ROW_URL}` - Page URL, generated via `cot_generate_pagetags`
3. `{SIMILAR_ROW_NUMBER}` - Sequential number of the page in the list, local tag from `similar.page.php`
4. `{SIMILAR_ROW_TEXT_CUT_STRIP}` - Truncated text, stripped of HTML, local tag from `similar.page.php`
5. `{SIMILAR_ROW_CAT_PATH_SHORT}` - Page category, generated via `cot_generate_pagetags`
6. `{SIMILAR_ROW_CREATED}` - Page publication date, generated via `cot_generate_pagetags`
7. `{SIMILAR_ROW_OWNER}` - Page owner (not author, but the user who published it), generated via `cot_generate_pagetags`

When designing the similar pages list in `similar.tpl`, you can add any tags for pages and users supported by `cot_generate_pagetags` and `cot_generate_usertags`.

## Requirements

- Cotonti Siena v0.9.26
- PHP 8.1 – 8.3
- MySQL 8.0+ with FULLTEXT support for InnoDB

## Tips

- Works best if page titles contain meaningful keywords (not too short).
- The plugin can be adapted for other entities (e.g., similar products, blogs, etc.).

## Credits

Plugin rewritten and adapted by [webitproff](https://github.com/webitproff)  
July 08, 2025

---

# Плагин Similar Pages (Похожие страницы) для Cotonti

## Назначение

Плагин выводит блок похожих страниц (статей) на основе заголовка текущей страницы, с ранжированием по релевантности:

- Страницы из той же подкатегории
- Страницы из той же родительской категории
- Прочие страницы по всему сайту
- В какой-то мере полезен для SEO

## Использует

- Fulltext-поиск MySQL по полю `page_title`
- Кеширование и шаблоный через XTemplate
- Поддерживает совместимость с PHP 8.3

## Состав плагина

- `similar/similar.page.php` — основной обработчик плагина, подключается к хуку `page.tags` для подключения своих тегов к модулю Pages
- `similar/tpl/similar.tpl` — шаблон вывода похожих страниц
- `similar/lang/similar.ru.lang.php` — языковой файл RU
- `similar/lang/similar.en.lang.php` — языковой файл EN
- `similar/similar.setup.php` — установочный файл плагина и конфигурация
- `similar/setup/similar.install.sql` — запрос установки в БД:

```sql
ALTER TABLE `cot_pages` ADD FULLTEXT `page_title_fulltext` (`page_title`);
```

- `similar/setup/similar.uninstall.sql` — запрос удаления в БД:

```sql
ALTER TABLE `cot_pages` DROP INDEX `page_title_fulltext`;
```

## Инструкция по установке

1. Скачать плагин и распаковать архив на своем ПК.
2. Папку `similar` закачать в `plugins` своего сайта на Cotonti.
3. Установить плагин в админке Cotonti:
   - Панель управления → Расширения → Similar Pages → Нажмите "Установить"
   - После этого нажмите "Конфигурация" и установите свои настройки, например:
     - Макс. похожих страниц для показа: 3
     - Строгость релевантности: 5
     - Макс. длина заголовка: 120
4. Установка завершена.

## Подключение плагина в шаблонах (обязательно)

1. В своей теме найдите шаблон `page.tpl`, например:  
   [https://github.com/webitproff/cot_2waydeal_build/tree/master/public_html/themes/2waydeal/modules/page](https://github.com/webitproff/cot_2waydeal_build/tree/master/public_html/themes/2waydeal/modules/page)

   Вставьте там, где вы хотите видеть блок похожих статей (можно после комментариев):

   ```html
   <!-- IF {PHP|cot_plugin_active('similar')} --> 
   {SIMILAR_PAGES}
   <!-- ENDIF -->
   ```

2. Настройте шаблон `similar.tpl` по своему вкусу. Пример:

   ```html
   <!-- BEGIN: MAIN -->
   <div class="col-12">
       <h4 class="mb-3">{PHP.L.Similar_pages}</h4>
       <div class="list-group mb-3">
           <!-- BEGIN: SIMILAR_ROW -->
           <div class="list-group-item list-group-item-action">
               <div class="align-items-center">
                   <div class="col-12">
                       <a href="{SIMILAR_ROW_URL}" class="fw-bold text-decoration-none">{SIMILAR_ROW_TITLE}</a>
                       <div class="text-muted small">
                           {SIMILAR_ROW_NUMBER} {SIMILAR_ROW_TEXT_CUT_STRIP}
                       </div>					
                       <div class="text-muted small">
                           {SIMILAR_ROW_CAT_PATH_SHORT} • {SIMILAR_ROW_CREATED} {SIMILAR_ROW_OWNER}
                       </div>
                   </div>
               </div>
           </div>
           <!-- END: SIMILAR_ROW -->
       </div>
   </div>
   <!-- END: MAIN -->

   <!-- BEGIN: NOTFOUND -->
   <div class="col-12">
       <div class="alert alert-info" role="alert">
           {PHP.L.Similar_notfound}
       </div>
   </div>
   <!-- END: NOTFOUND -->
   ```

## Справка по тегам в шаблоне `similar.tpl`

1. `{SIMILAR_ROW_TITLE}` - заголовок статьи, генерируется через `cot_generate_pagetags`
2. `{SIMILAR_ROW_URL}` - URL статьи, генерируется через `cot_generate_pagetags`
3. `{SIMILAR_ROW_NUMBER}` - Порядковый номер статьи в списке, локальный тег из `similar.page.php`
4. `{SIMILAR_ROW_TEXT_CUT_STRIP}` - Усеченный текст, очищенный от HTML, локальный тег из `similar.page.php`
5. `{SIMILAR_ROW_CAT_PATH_SHORT}` - Категория статьи, генерируется через `cot_generate_pagetags`
6. `{SIMILAR_ROW_CREATED}` - Дата публикации статьи, генерируется через `cot_generate_pagetags`
7. `{SIMILAR_ROW_OWNER}` - Владелец статьи (не автор, а тот, кто её опубликовал), генерируется через `cot_generate_pagetags`

При построении макета списков похожих страниц в `similar.tpl` вы можете добавлять любые теги для статей и пользователей, поддерживаемые функциями `cot_generate_pagetags` и `cot_generate_usertags`.

## Требования

- Cotonti Siena v0.9.26
- PHP 8.1 – 8.3
- MySQL 8.0+ с поддержкой FULLTEXT по InnoDB

## Советы

- Работает лучше, если заголовки страниц содержат ключевые слова (не слишком короткие).
- Можно адаптировать плагин для других сущностей (например, похожие товары, блоги и т.д.).

## Автор

Плагин переписал и адаптировал [webitproff](https://github.com/webitproff)  
08 июля 2025 г.

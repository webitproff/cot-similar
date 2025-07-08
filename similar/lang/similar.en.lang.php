<?php
// Проверяем, что скрипт выполняется в контексте Cotonti, иначе завершаем выполнение
defined('COT_CODE') or die('Wrong URL.');

/**
 * Plugin Config
 */

$L['cfg_max_sim'] = 'Max similar pages to display';
$L['cfg_max_sim_hint'] = 'Maximum number of similar pages (default is 5)';
$L['cfg_relev'] = 'Relevance strictness';
$L['cfg_relev_hint'] = 'Minimum relevance threshold';

/**
 * Plugin Title & Subtitle
 */
$L['info_name'] = 'Similar pages';
$L['info_desc'] = 'Displays relevant, similar pages on an article page if they exist';
$L['info_notes'] = 'Adapted to Cotonti 0.9.26 beta, PHP >= 8.3+ & Bootstrap 5.3 by <a href="https://github.com/webitproff" target="_blank"><span class="text-primary-emphasis fw-bold">webitproff</span></a>. In page.tpl, after comments, add <code>{SIMILAR_PAGES}</code>';

/**
 * Plugin Body
 */

$L['Similar_pages'] = 'Similar pages';
$L['Similar_notfound'] = 'No similar pages found';
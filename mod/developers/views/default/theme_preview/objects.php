<?php
/**
 * CSS Objects: list, module, image_block, table, messages
 */

echo elgg_view_module('info', 'Modules (.elgg-module)', elgg_view('theme_preview/objects/modules'));

echo elgg_view_module('info', 'Image Block (.elgg-image-block)', elgg_view('theme_preview/objects/image_block'));

echo elgg_view_module('info', 'List (.elgg-list)', elgg_view('theme_preview/objects/list'));

echo elgg_view_module('info', 'Table (.elgg-table)', elgg_view('theme_preview/objects/table'));

echo elgg_view_module('info', 'Messages (.elgg-message)', elgg_view('theme_preview/objects/messages'));

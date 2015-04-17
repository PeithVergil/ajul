<?php namespace Ajul\Admin;

// Prevent direct access.
if (!defined('ABSPATH'))
    exit;

// Register custom CSS and JS files.
require(AJUL_PLUGIN_DIR . 'lib/Admin/scripts.php');

/**
 * Register custom AJAX handlers.
 */
new Ajax\Destinations();

/**
 * Add custom meta boxes.
 */
new Metabox\Destinations();
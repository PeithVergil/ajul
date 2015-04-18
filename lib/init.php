<?php namespace Ajul;

// Prevent direct access.
if (!defined('ABSPATH'))
    exit;

/**
 * The activation hook.
 */
function activate() {
}

register_activation_hook(__FILE__, 'Ajul\activate');

/**
 * The deactivation hook.
 */
function deactivate() {
}

register_deactivation_hook(__FILE__, 'Ajul\deactivate');

/**
 * Loads the translation data for WordPress
 *
 * @since 1.0
 */
function load_textdomain() {
    load_plugin_textdomain(AJUL_I18N, false, AJUL_PLUGIN_DIR . 'lang/');
}

add_action('plugins_loaded', 'Ajul\load_textdomain');

if (is_admin()) {
    /**
     * Initialize the admin.
     */
    require(AJUL_PLUGIN_DIR . 'lib/Admin/init.php');
}

/**
 * Register custom shortcodes.
 */
require(AJUL_PLUGIN_DIR . 'lib/shortcodes.php');

/**
 * API functions.
 */
require(AJUL_PLUGIN_DIR . 'lib/functions.php');

/**
 * Register custom CSS and JS files.
 */
require(AJUL_PLUGIN_DIR . 'lib/scripts.php');

/**
 * Register custom post types.
 */
require(AJUL_PLUGIN_DIR . 'lib/types.php');

/**
 * Register custom AJAX handlers.
 */
require(AJUL_PLUGIN_DIR . 'lib/ajax.php');
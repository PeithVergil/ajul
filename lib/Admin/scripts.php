<?php namespace Ajul\Admin;

// Prevent direct access.
if (!defined('ABSPATH'))
    exit;

/**
 * Register admin CSS files.
 *
 * @since 0.1
 */
function register_styles() {
    wp_register_style('ajul-edit', AJUL_PLUGIN_URL . 'assets/css/ajul-edit.css', array('wp-jquery-ui-dialog'), AJUL_PLUGIN_VERSION);
}

add_action('admin_enqueue_scripts', 'Ajul\Admin\register_styles');

/**
 * Register admin JS files.
 *
 * @since 0.1
 */
function register_scripts() {
    wp_register_script('ajul-common', AJUL_PLUGIN_URL . 'assets/js/ajul-common.js', array(
        'jquery-ui-button',
        'jquery-ui-dialog',
        'backbone'
    ), AJUL_PLUGIN_VERSION, true);

    wp_register_script('ajul-edit', AJUL_PLUGIN_URL . 'assets/js/ajul-edit.js', array(
        'ajul-common'
    ), AJUL_PLUGIN_VERSION, true);
}

add_action('admin_enqueue_scripts', 'Ajul\Admin\register_scripts');
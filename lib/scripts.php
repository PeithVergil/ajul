<?php namespace Ajul;

/**
 * Register CSS files.
 *
 * @since 0.1
 */
function register_styles() {
    $ajulEditDependencies = array(
        'wp-jquery-ui-dialog'
    );

    wp_register_style('ajul-edit', AJUL_PLUGIN_URL . 'assets/css/ajul-edit.css', $ajulEditDependencies, AJUL_PLUGIN_VERSION);
}

add_action('admin_enqueue_scripts', 'Ajul\register_styles');

/**
 * Register JS files.
 *
 * @since 0.1
 */
function register_scripts() {
    $ajulEditDependencies = array(
        'jquery-ui-button',
        'jquery-ui-dialog',
        'backbone'
    );

    wp_register_script('ajul-edit', AJUL_PLUGIN_URL . 'assets/js/ajul-edit.js', $ajulEditDependencies, AJUL_PLUGIN_VERSION, true);
}

add_action('admin_enqueue_scripts', 'Ajul\register_scripts');
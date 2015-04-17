<?php namespace Ajul;

/**
 * Register admin CSS files.
 *
 * @since 0.1
 */
function register_admin_styles() {
    wp_register_style('ajul-edit', AJUL_PLUGIN_URL . 'assets/css/ajul-edit.css', array('wp-jquery-ui-dialog'), AJUL_PLUGIN_VERSION);
}

add_action('admin_enqueue_scripts', 'Ajul\register_admin_styles');

/**
 * Register admin JS files.
 *
 * @since 0.1
 */
function register_admin_scripts() {
    wp_register_script('ajul-common', AJUL_PLUGIN_URL . 'assets/js/ajul-common.js', array(
        'jquery-ui-button',
        'jquery-ui-dialog',
        'backbone'
    ), AJUL_PLUGIN_VERSION, true);

    wp_register_script('ajul-edit', AJUL_PLUGIN_URL . 'assets/js/ajul-edit.js', array(
        'ajul-common'
    ), AJUL_PLUGIN_VERSION, true);
}

add_action('admin_enqueue_scripts', 'Ajul\register_admin_scripts');

/**
 * Register front-end CSS files.
 *
 * @since 0.1
 */
function register_styles() {
    wp_register_style('hopscotch', AJUL_PLUGIN_URL . 'assets/css/lib/hopscotch.css', array(), AJUL_PLUGIN_VERSION);

    wp_register_style('ajul-tour', AJUL_PLUGIN_URL . 'assets/css/ajul-tour.css', array('hopscotch'), AJUL_PLUGIN_VERSION);
}

add_action('wp_enqueue_scripts', 'Ajul\register_styles');

/**
 * Register front-end JS files.
 *
 * @since 0.1
 */
function register_scripts() {
    wp_register_script('hopscotch', AJUL_PLUGIN_URL . 'assets/js/lib/hopscotch.js', array('jquery'), AJUL_PLUGIN_VERSION, true);

    wp_register_script('ajul-tour', AJUL_PLUGIN_URL . 'assets/js/ajul-tour.js', array('hopscotch'), AJUL_PLUGIN_VERSION, true);
}

add_action('wp_enqueue_scripts', 'Ajul\register_scripts');
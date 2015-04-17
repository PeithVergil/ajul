<?php namespace Ajul;

// Prevent direct access.
if (!defined('ABSPATH'))
    exit;

/**
 * Register the 'ajul' custom post type.
 */
function register_type_ajul() {
    register_post_type('ajul', array(
        'labels' => array(
            'name'          => __('Tours', AJUL_I18N),
            'singular_name' => __('Tour', AJUL_I18N),
            'menu_name'     => __('Ajul', AJUL_I18N),
            'add_new_item'  => __('Add New Tour', AJUL_I18N),
            'all_items'     => __('All Tours', AJUL_I18N)
        ),
        'supports' => array(
            'title'
        ),
        'public'       => false,
        'hierarchical' => false,
        'show_ui'      => true,
        'can_export'   => true,
        'rewrite'      => true,
        'menu_icon'    => AJUL_PLUGIN_URL . 'assets/images/icon.png',
    ));
}

add_action('init', 'Ajul\register_type_ajul');
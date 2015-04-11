<?php namespace Ajul;

/**
 * Register CSS files.
 *
 * @since 0.1
 */
function register_styles() {
    wp_register_style('jqueryui-smoothness', AJUL_PLUGIN_URL . 'assets/css/smoothness/jquery-ui.css', array(), '1.11.4');

    $ajulEditDependencies = array('jqueryui-smoothness');

    wp_register_style('ajul-edit', AJUL_PLUGIN_URL . 'assets/css/ajul-edit.css', $ajulEditDependencies, AJUL_PLUGIN_VERSION);
}

add_action('admin_enqueue_scripts', 'Ajul\register_styles');

/**
 * Register JS files.
 *
 * @since 0.1
 */
function register_scripts() {
    $ajulEditDependencies = array('jquery-ui-dialog', 'backbone');

    wp_register_script('ajul-edit', AJUL_PLUGIN_URL . 'assets/js/ajul-edit.js', $ajulEditDependencies, AJUL_PLUGIN_VERSION, true);

    wp_localize_script('ajul-edit', 'AjulSettings', array(
        'ajax' => admin_url('admin-ajax.php'),
        'texts' => array(
            'formCreateButton' => __('Create Destination', AJUL_I18N)
        ),
    ));
}

add_action('admin_enqueue_scripts', 'Ajul\register_scripts');
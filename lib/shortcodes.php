<?php namespace Ajul\Shortcodes;

// Prevent direct access.
if (!defined('ABSPATH'))
    exit;

/**
 * Register the [ajul-tour] shortcode.
 *
 * @param array $attributes The attributes attached to the shortcode.
 *
 * @since 0.1
 */
function ajul_tour($attributes) {
    if (empty($attributes['id'])) {
        _e('The "id" attribute is required.', AJUL_I18N);
        return;
    }

    $post = get_post($attributes['id']);

    if (!$post) {
        _e('Ajul tour not found.', AJUL_I18N);
        return;
    }

    $destinations = get_post_meta($post->ID, 'ajul_tour_destinations', true);

    if (empty($destinations)) {
        _e('No tour destinations.', AJUL_I18N);
        return;
    }

    wp_enqueue_style('ajul-tour');
    wp_enqueue_script('ajul-tour');

    wp_localize_script('ajul-tour', 'AjulTourSettings', array(
        'tourTitle' => $post->post_title,
        'tourName'  => $post->post_name,
        'steps'     => $destinations
    ));

    include (AJUL_PLUGIN_DIR . 'lib/templates/shortcode-ajul-tour.php');
}

add_shortcode('ajul-tour', 'Ajul\Shortcodes\ajul_tour');
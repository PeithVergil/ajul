<?php namespace Ajul\Shortcodes;

// Prevent direct access.
if (!defined('ABSPATH'))
    exit;

/**
 * Register the [ajul-tour] shortcode.
 *
 * @param array $atts The attributes attached to the shortcode.
 *
 * @since 0.1
 */
function ajul_tour($atts) {
    \Ajul\create_tour($atts);
}

add_shortcode('ajul-tour', 'Ajul\Shortcodes\ajul_tour');
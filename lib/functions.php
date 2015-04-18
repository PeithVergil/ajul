<?php namespace Ajul;

// Prevent direct access.
if (!defined('ABSPATH'))
    exit;

function create_tour($atts) {
    $attributes = shortcode_atts(array(
        'id'    => null,
        'text'  => __('Start Tour', AJUL_I18N),
        'start' => '0',
    ), $atts);

    if (empty($attributes['id'])): ?>
        <p><?php _e('The "id" attribute is required.', AJUL_I18N); ?></p>
        <?php
        return;
    endif;

    $post = get_post($attributes['id']);

    if (!$post): ?>
        <p><?php _e('Ajul tour not found.', AJUL_I18N); ?></p>
        <?php
        return;
    endif;

    $steps = get_post_meta($post->ID, 'ajul_tour_destinations', true);

    if (empty($steps)): ?>
        <p><?php _e('No tour destinations.', AJUL_I18N); ?></p>
        <?php
        return;
    endif;

    if ($attributes['start'] === '1')
        $start = true;
    else
        $start = false;

    wp_enqueue_style('ajul-tour');
    wp_enqueue_script('ajul-tour');

    wp_localize_script('ajul-tour', 'AjulTourSettings', array(
        'tourTitle' => $post->post_title,
        'tourName'  => $post->post_name,
        'steps'     => $steps,
        'start'     => $start,
    ));

    include (AJUL_PLUGIN_DIR . 'lib/templates/shortcode-ajul-tour.php');
}
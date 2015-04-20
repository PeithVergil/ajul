<?php namespace Ajul;

// Prevent direct access.
if (!defined('ABSPATH'))
    exit;

$_ajulToursCache = array();

function create_tour($atts) {
    $attributes = shortcode_atts(array(
        'id'    => null,
        'text'  => 'Start Tour',
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

    global $wp_scripts, $_ajulToursCache;

    // Empty out the previous data so we don't get
    // multiple data declarations in the front-end.
    $wp_scripts->add_data('ajul-tour', 'data', '' );

    $_ajulToursCache[$post->ID] = array(
        'id'    => $post->post_name,
        'steps' => $steps,
        'start' => $start,
    );

    wp_localize_script('ajul-tour', 'AjulTourSettings', array(
        'tours' => $_ajulToursCache
    ));

    include (AJUL_PLUGIN_DIR . 'lib/templates/shortcode-ajul-tour.php');
}
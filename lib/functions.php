<?php namespace Ajul;

// Prevent direct access.
if (!defined('ABSPATH'))
    exit;

$_ajulToursCache = array();

/**
 * Create a link that is used for starting the tour.
 *
 * @param array $options The attributes attached to the [ajul-tour] shortcode.
 *
 * @since 0.1
 */
function create_tour($options) {
    $attributes = shortcode_atts(array(
        'id'    => null,
        'text'  => null,
        'start' => '0',
    ), $options);

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

    if (empty($attributes['text']))
        $attributes['text'] = $post->post_title;

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
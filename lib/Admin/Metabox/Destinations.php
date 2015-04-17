<?php namespace Ajul\Admin\Metabox;

// Prevent direct access.
if (!defined('ABSPATH'))
    exit;

/**
 * Used for creating custom metaboxes.
 */
class Destinations extends Metabox {

    /**
     * Register action hooks.
     */
    public function __construct() {
        parent::__construct('ajul', __('Destinations', AJUL_I18N), 'ajul_nonce_destinations', 'ajul_action_destinations');
    }

    /**
     * Save custom meta data.
     *
     * @param int $post_id
     */
    public function save($post_id) {
    }

    /**
     * Render the custom metabox.
     *
     * @param $post WP_Post
     */
    public function render($post) {
        require(AJUL_PLUGIN_DIR . 'lib/templates/metabox-destinations.php');
    }

    /**
     * Load the necessary javascripts and stylesheets.
     */
    public function scripts() {
        $screen = get_current_screen();

        if ($screen->id === 'ajul') {
            global $post;

            wp_enqueue_style('ajul-edit');
            wp_enqueue_script('ajul-edit');

            wp_localize_script('ajul-edit', 'AjulSettings', array(
                'post' => $post->ID,
                'ajax' => admin_url('admin-ajax.php'),
                'texts' => array(
                    'formCreateTitle' => __('Create Destination', AJUL_I18N),
                    'formUpdateTitle' => __('Update Destination', AJUL_I18N),
                    'formSaveButton'  => __('Save', AJUL_I18N)
                ),
                'nonces' => array(
                    'destinationCreate' => wp_create_nonce(\Ajul\Ajax::DESTINATION_CREATE),
                    'destinationDelete' => wp_create_nonce(\Ajul\Ajax::DESTINATION_DELETE),
                ),
                'actions' => array(
                    'destinationCreate' => \Ajul\Ajax::DESTINATION_CREATE,
                    'destinationDelete' => \Ajul\Ajax::DESTINATION_DELETE,
                ),
                'destinations' => $this->get_destinations()
            ));
        }
    }

    private function get_destinations() {
        global $post;

        $destinations = get_post_meta($post->ID, 'ajul_tour_destinations', true);

        if (empty($destinations))
            return array();

        return $destinations;
    }

}
<?php namespace Ajul\Admin\Ajax;

// Prevent direct access.
if (!defined('ABSPATH'))
    exit;

/**
 * AJAX handlers for the destinations metabox.
 */
class Destinations extends \Ajul\Ajax\AjaxHandler {

    const CREATE = 'destination_create';
    const DELETE = 'destination_delete';

    /**
     * Register custom AJAX handlers.
     */
    function __construct() {
        add_action('wp_ajax_' . self::CREATE, array($this, 'destination_create'));
        add_action('wp_ajax_' . self::DELETE, array($this, 'destination_delete'));
    }

    /**
     * The AJAX handler for creating a new destination.
     */
    public function destination_create() {
        $this->verify_request(self::CREATE);

        $tour = get_post($_POST['post']);

        if (!$tour) {
            wp_send_json_error(array(
                'message' => __('Tour not found', AJUL_I18N)
            ));
        }

        $page = get_post($_POST['page']);

        if (!$page) {
            wp_send_json_error(array(
                'message' => __('Page not found', AJUL_I18N)
            ));
        }

        $destinations = get_post_meta($tour->ID, 'ajul_tour_destinations', true);

        if (empty($destinations)) {
            $destinations = array();
        }

        $destination = array(
            'page'      => $_POST['page'],
            'title'     => $_POST['title'],
            'target'    => $_POST['target'],
            'content'   => $_POST['content'],
            'placement' => $_POST['placement'],
        );

        // Just hash the values and use it as the ID.
        $destination = array_merge($destination, array(
            'id' => md5(serialize($destination))
        ));

        $destinations[] = $destination;

        $result = update_post_meta($tour->ID, 'ajul_tour_destinations', $destinations);

        if (!$result) {
            wp_send_json_error(array(
                'message' => __('Could not add destination', AJUL_I18N)
            ));
        }

        wp_send_json_success($destination);
    }

    /**
     * The AJAX handler for deleting a destination.
     */
    public function destination_delete() {
        $this->verify_request(self::DELETE);

        $tour = get_post($_POST['post']);

        if (!$tour) {
            wp_send_json_error(array(
                'message' => __('Tour not found', AJUL_I18N)
            ));
        }

        $destinations = get_post_meta($tour->ID, 'ajul_tour_destinations', true);

        if (!empty($destinations)) {
            $temp = array();

            foreach ($destinations as $destination) {
                if ($destination['id'] === $_POST['id'])
                    continue;
                $temp[] = $destination;
            }

            update_post_meta($tour->ID, 'ajul_tour_destinations', $temp);
        }

        wp_send_json_success();
    }
}
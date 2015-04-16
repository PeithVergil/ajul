<?php namespace Ajul;

// Prevent direct access.
if (!defined('ABSPATH'))
    exit;

/**
 * Register custom AJAX handlers.
 */
class Ajax {

    const DESTINATION_CREATE = 'destination_create';
    const DESTINATION_DELETE = 'destination_delete';

    /**
     * Register custom AJAX handlers.
     */
    function __construct() {
        add_action('wp_ajax_' . self::DESTINATION_CREATE, array($this, 'destination_create'));
        add_action('wp_ajax_' . self::DESTINATION_DELETE, array($this, 'destination_delete'));
    }

    /**
     * The AJAX handler for creating a new destination.
     */
    public function destination_create() {
        $this->verify_request(self::DESTINATION_CREATE);

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
            'page'    => $_POST['page'],
            'title'   => $_POST['title'],
            'content' => $_POST['content'],
            'element' => $_POST['element'],
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
        $this->verify_request(self::DESTINATION_DELETE);

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

    /**
     * Verify the nonce token that came with the request.
     *
     * @param string $action The action string that is used to register an AJAX handler.
     */
    private function verify_request($action) {
        if (!wp_verify_nonce($_REQUEST['nonce'], $action)) {
            wp_send_json_error(array(
                'message' => __('Invalid request', AJUL_I18N)
            ));
        }
    }
}
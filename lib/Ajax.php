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

        $post = get_post($_POST['post']);

        if (!$post) {
            wp_send_json_error(array(
                'message' => __('Post not found', AJUL_I18N)
            ));
        }

        wp_send_json_success($_POST);
    }

    /**
     * The AJAX handler for deleting a destination.
     */
    public function destination_delete() {
        $this->verify_request(self::DESTINATION_DELETE);
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
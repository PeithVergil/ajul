<?php namespace Ajul\Ajax;

// Prevent direct access.
if (!defined('ABSPATH'))
    exit;

/**
 * The base AJAX handler.
 */
class AjaxHandler {

    /**
     * Verify the nonce token that came with the request.
     *
     * @param string $action The action string that is used to register an AJAX handler.
     */
    protected function verify_request($action) {
        if (!wp_verify_nonce($_REQUEST['nonce'], $action)) {
            wp_send_json_error(array(
                'message' => __('Invalid request', AJUL_I18N)
            ));
        }
    }
}
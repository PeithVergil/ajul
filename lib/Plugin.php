<?php namespace Ajul;

// Prevent direct access.
if (!defined('ABSPATH'))
    exit;

/**
 * The plugin's main class.
 */
class Plugin {

    function __construct() {
        // The plugin has been activated.
        register_activation_hook(__FILE__, array($this, 'activate'));

        // The plugin has been deactivated.
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }

    /**
     * The activation hook.
     */
    public function activate() {
    }

    /**
     * The deactivation hook.
     */
    public function deactivate() {
    }
}
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

        // Setup the text domain.
        add_action('plugins_loaded', array($this, 'textdomain'));

        // Register custom CSS and JS files.
        require(AJUL_PLUGIN_DIR . 'lib/scripts.php');

        // Add custom AJAX handlers.
        new Ajax();

        // Register custom post types.
        require(AJUL_PLUGIN_DIR . 'lib/types.php');

        // Add custom meta boxes.
        new Metabox\Destinations();

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

    /**
     * Loads the translation data for WordPress
     *
     * @since 1.0
     */
    public function textdomain() {
        load_plugin_textdomain(AJUL_I18N, false, AJUL_PLUGIN_DIR . 'lang/');
    }
}
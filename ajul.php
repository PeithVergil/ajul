<?php

/*
 * Plugin Name: WP Ajul
 *
 * Description: Create a guided tour around your site.
 *
 * Version:     0.1
 *
 * Author:      Peith Vergil
 * Author URI:  http://viajero.me
 *
 * Text Domain: ajul
 */

// Prevent direct access.
if (!defined('ABSPATH'))
    exit;

if (!defined('AJUL_PLUGIN_DIR'))
    define('AJUL_PLUGIN_DIR', plugin_dir_path(__FILE__));

if (!defined('AJUL_PLUGIN_URL'))
    define('AJUL_PLUGIN_URL', plugin_dir_url(__FILE__));

if (!defined('AJUL_I18N'))
    define('AJUL_I18N', 'ajul');

require AJUL_PLUGIN_DIR . 'vendor/autoload.php';

/**
 * Initialize the plugin.
 */
$ajul = new Ajul\Plugin();
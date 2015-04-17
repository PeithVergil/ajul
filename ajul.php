<?php

/*
 * Plugin Name: Ajul
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

if (!defined('AJUL_PLUGIN_VERSION'))
    define('AJUL_PLUGIN_VERSION', '0.1');

if (!defined('AJUL_PLUGIN_DIR'))
    define('AJUL_PLUGIN_DIR', plugin_dir_path(__FILE__));

if (!defined('AJUL_PLUGIN_URL'))
    define('AJUL_PLUGIN_URL', plugin_dir_url(__FILE__));

if (!defined('AJUL_I18N'))
    define('AJUL_I18N', 'ajul');

/**
 * The class auto loader.
 */
require(AJUL_PLUGIN_DIR . 'vendor/autoload.php');

/**
 * Initialize the plugin.
 */
require(AJUL_PLUGIN_DIR . 'lib/init.php');
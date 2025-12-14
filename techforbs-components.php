<?php
/**
 * Plugin Name: TechForbs Components Manager
 * Description: Comprehensive plugin for managing all site components (Hero Section, Menus, etc.) without ACF
 * Version: 1.0.0
 * Author: TechForbs
 * Text Domain: techforbs-components
 * Domain Path: /languages
 * 
 * Plugin Structure:
 * - includes/settings.php       (Register all settings)
 * - includes/sections/          (Hero section logic)
 * - includes/api/               (REST API endpoints)
 * - assets/                     (CSS, JS, Images, Icons)
 */

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('TECHFORBS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('TECHFORBS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('TECHFORBS_PLUGIN_VERSION', '1.0.0');

/**
 * ============================================================================
 * LOAD PLUGIN FILES
 * ============================================================================
 */

// Load settings and registration
require_once TECHFORBS_PLUGIN_DIR . 'includes/registration.php';

// Load hero section
require_once TECHFORBS_PLUGIN_DIR . 'includes/sections/hero.php';

// Load menus section
require_once TECHFORBS_PLUGIN_DIR . 'includes/sections/menus.php';

// Load homepage sections (Services, FAQ, etc.)
require_once TECHFORBS_PLUGIN_DIR . 'includes/sections/homepage-sections.php';

// Load REST API endpoints
require_once TECHFORBS_PLUGIN_DIR . 'includes/api/rest-api.php';

// Load admin functions
require_once TECHFORBS_PLUGIN_DIR . 'includes/admin.php';

/**
 * ============================================================================
 * ENQUEUE PLUGIN ASSETS
 * ============================================================================
 */

add_action('admin_enqueue_scripts', 'techforbs_enqueue_admin_assets');

function techforbs_enqueue_admin_assets($hook) {
    // Only load on TechForbs admin pages
    if (strpos($hook, 'techforbs') === false) {
        return;
    }

    // Enqueue admin CSS
    wp_enqueue_style(
        'techforbs-admin-css',
        TECHFORBS_PLUGIN_URL . 'assets/css/admin.css',
        [],
        TECHFORBS_PLUGIN_VERSION
    );

    // Enqueue admin JS
    wp_enqueue_script(
        'techforbs-admin-js',
        TECHFORBS_PLUGIN_URL . 'assets/js/admin.js',
        ['jquery'],
        TECHFORBS_PLUGIN_VERSION,
        true
    );
}

/**
 * ============================================================================
 * PLUGIN ACTIVATION & DEACTIVATION
 * ============================================================================
 */

register_activation_hook(__FILE__, 'techforbs_plugin_activate');
register_deactivation_hook(__FILE__, 'techforbs_plugin_deactivate');

function techforbs_plugin_activate() {
    // Call activation hooks from each section
    do_action('techforbs_activate');
}

function techforbs_plugin_deactivate() {
    // Call deactivation hooks from each section
    do_action('techforbs_deactivate');
}

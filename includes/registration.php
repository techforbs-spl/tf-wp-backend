<?php
/**
 * Registration & Initialization
 * 
 * Registers custom navigation menus and theme support
 */

if (!defined('ABSPATH')) {
    exit;
}


// Include ACF local field groups if present (registers local groups when ACF is active)
$acf_local_file = __DIR__ . '/acf-local-field-groups.php';
if (file_exists($acf_local_file)) {
    include_once $acf_local_file;
}

add_action('init', 'techforbs_register_menus_and_sidebars');
add_action('init', 'techforbs_register_all_settings');

/**
 * Register custom navigation menus
 */
function techforbs_register_menus_and_sidebars() {
    register_nav_menus([
        'primary' => __('Primary Menu (Header)', 'techforbs-components'),
        'secondary' => __('Secondary Menu (Footer)', 'techforbs-components'),
        'mobile' => __('Mobile Menu', 'techforbs-components'),
    ]);

    // Register theme support
    add_theme_support('html5', ['navigation-form']);
}

/**
 * Register all settings for hero section and other components
 */
function techforbs_register_all_settings() {
    $fields = [
        // Hero Section - Text Fields
        'hero_title' => 'string',
        'hero_subtitle' => 'string',
        'hero_badge_text' => 'string',

        // Hero Section - Color Fields
        'hero_gradient_1' => 'string',
        'hero_gradient_2' => 'string',
        'hero_gradient_3' => 'string',

        // Hero Section - JSON/Complex Fields
        'hero_platforms' => 'string',
        'hero_cta_primary' => 'string',
        'hero_cta_secondary' => 'string',
        'hero_stats' => 'string',
        'hero_exp_badge' => 'string',
        'hero_success_badge' => 'string',

        // Image Fields
        'hero_bg_image' => 'integer',
        'hero_right_image' => 'integer',
        
        // Logo Settings
        'site_logo' => 'integer',
    ];

    foreach ($fields as $field_name => $type) {
        $sanitize_callback = 'sanitize_text_field';
        
        if ($type === 'integer') {
            $sanitize_callback = 'absint';
        } elseif (strpos($field_name, 'gradient') !== false) {
            $sanitize_callback = 'sanitize_hex_color';
        }

        register_setting('site-settings', $field_name, [
            'type' => $type,
            'sanitize_callback' => $sanitize_callback,
            'show_in_rest' => true,
        ]);
    }
}

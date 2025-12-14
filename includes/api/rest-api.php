<?php
/**
 * REST API Endpoints
 * 
 * Provides REST API endpoints for frontend consumption
 * - /wp-json/techforbs/v1/hero-settings (GET)
 * - /wp-json/techforbs/v1/menus (GET)
 * - /wp-json/techforbs/v1/logo (GET)
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('rest_api_init', 'techforbs_register_component_rest_routes');

/**
 * Register all REST API routes
 */
function techforbs_register_component_rest_routes() {
    // Hero Settings Endpoint
    register_rest_route('techforbs/v1', '/hero-settings', [
        'methods' => 'GET',
        'callback' => 'techforbs_get_hero_settings',
        'permission_callback' => '__return_true',
    ]);

    // Menus Endpoint
    register_rest_route('techforbs/v1', '/menus', [
        'methods' => 'GET',
        'callback' => 'techforbs_get_menus',
        'permission_callback' => '__return_true',
    ]);

    // Logo Endpoint
    register_rest_route('techforbs/v1', '/logo', [
        'methods' => 'GET',
        'callback' => 'techforbs_get_logo',
        'permission_callback' => '__return_true',
    ]);

    // Footer Settings Endpoint
    register_rest_route('techforbs/v1', '/footer-settings', [
        'methods' => 'GET',
        'callback' => 'techforbs_get_footer_settings',
        'permission_callback' => '__return_true',
    ]);

    // Page Data Endpoint - returns per-page sections (from post meta) and SEO data
    register_rest_route('techforbs/v1', '/page-data', [
        'methods' => 'GET',
        'callback' => 'techforbs_get_page_data',
        'permission_callback' => '__return_true',
        'args' => [
            'id' => [ 'validate_callback' => 'is_numeric' ],
            'slug' => [],
            'path' => [],
        ],
    ]);
}

/**
 * GET /wp-json/techforbs/v1/hero-settings
 * Returns all hero section settings
 */
function techforbs_get_hero_settings() {
    return [
        'title' => get_option('hero_title'),
        'subtitle' => get_option('hero_subtitle'),
        'badge_text' => get_option('hero_badge_text'),
        'platforms' => json_decode(get_option('hero_platforms', '[]'), true),
        'cta_primary' => json_decode(get_option('hero_cta_primary', '{}'), true),
        'cta_secondary' => json_decode(get_option('hero_cta_secondary', '{}'), true),
        'stats' => json_decode(get_option('hero_stats', '[]'), true),
        'gradient_1' => get_option('hero_gradient_1'),
        'gradient_2' => get_option('hero_gradient_2'),
        'gradient_3' => get_option('hero_gradient_3'),
        'exp_badge' => json_decode(get_option('hero_exp_badge', '{}'), true),
        'success_badge' => json_decode(get_option('hero_success_badge', '{}'), true),
    ];
}

/**
 * GET /wp-json/techforbs/v1/menus
 * Returns all registered menus
 */
function techforbs_get_menus() {
    $locations = get_nav_menu_locations();
    $menus = [];

    foreach ($locations as $location => $menu_id) {
        $menu_items = wp_get_nav_menu_items($menu_id);
        $formatted_items = [];
        
        if ($menu_items) {
            foreach ($menu_items as $item) {
                $formatted_items[] = [
                    'ID' => $item->ID,
                    'title' => $item->title,
                    'url' => $item->url,
                    'target' => $item->target,
                    'description' => $item->description,
                ];
            }
        }
        
        $menus[$location] = $formatted_items;
    }

    return [
        'primary' => $menus['primary'] ?? [],
        'secondary' => $menus['secondary'] ?? [],
        'mobile' => $menus['mobile'] ?? [],
    ];
}

/**
 * GET /wp-json/techforbs/v1/logo
 * Returns logo URL and attachment data
 */
function techforbs_get_logo() {
    $logo_id = get_option('site_logo');
    
    // Default to custom_logo if site_logo is not set
    if (!$logo_id) {
        $logo_id = get_theme_mod('custom_logo');
    }

    if ($logo_id) {
        $logo_url = wp_get_attachment_url($logo_id);
        $logo_alt = get_post_meta($logo_id, '_wp_attachment_image_alt', true);
        
        return [
            'id' => $logo_id,
            'url' => $logo_url,
            'alt' => $logo_alt ?: 'TechForbs Logo',
            'width' => wp_get_attachment_image_src($logo_id, 'full')[1] ?? null,
            'height' => wp_get_attachment_image_src($logo_id, 'full')[2] ?? null,
            'topbar_text' => get_option('site_topbar_text', ''),
        ];
    }

    // Return default/placeholder if no logo
    return [
        'id' => null,
        'url' => null,
        'alt' => 'TechForbs',
        'width' => null,
        'height' => null,
        'message' => 'No logo uploaded. Upload via Settings > Logo or Theme Customize > Site Identity',
        'topbar_text' => get_option('site_topbar_text', ''),
    ];
}

/**
 * GET /wp-json/techforbs/v1/footer-settings
 * Returns all footer settings from site options
 */
function techforbs_get_footer_settings() {
    // Get ACF option fields (requires ACF Pro or free version)
    if (function_exists('get_field')) {
        return [
            'company_description' => get_field('footer_company_description', 'option') ?: 'Perfect IT Solutions for any Business & Startups',
            'email' => get_field('footer_email', 'option') ?: 'info@techforbs.com',
            'phone' => get_field('footer_phone', 'option') ?: '+91 971 401 9476',
            'services' => get_field('footer_services', 'option') ?: [],
            'company_links' => get_field('footer_company_links', 'option') ?: [],
            'legal_links' => get_field('footer_legal_links', 'option') ?: [],
            'social_links' => get_field('footer_social_links', 'option') ?: [],
            'copyright' => get_field('footer_copyright', 'option') ?: '© TechForbs. All rights reserved.',
        ];
    }

    // Fallback if ACF is not active
    return [
        'company_description' => 'Perfect IT Solutions for any Business & Startups',
        'email' => 'info@techforbs.com',
        'phone' => '+91 971 401 9476',
        'services' => [],
        'company_links' => [],
        'legal_links' => [],
        'social_links' => [],
        'copyright' => '© TechForbs. All rights reserved.',
    ];
}

/**
 * GET /wp-json/techforbs/v1/page-data
 * Returns page-level sections (stored in post meta) and basic post + Yoast SEO meta
 * Accepts `id`, `slug` or `path`. If `path` is empty string, returns front page data.
 */
function techforbs_get_page_data(\WP_REST_Request $request) {
    $params = $request->get_params();

    $post = null;

    if (!empty($params['id'])) {
        $post = get_post(absint($params['id']));
    } elseif (!empty($params['slug'])) {
        $posts = get_posts([ 'name' => sanitize_text_field($params['slug']), 'post_type' => ['page','post'], 'posts_per_page' => 1 ]);
        if (!empty($posts)) $post = $posts[0];
    } elseif (isset($params['path'])) {
        $path = trim($params['path'], '/');
        if ($path === '') {
            // front page
            $front_id = get_option('page_on_front');
            if ($front_id) $post = get_post($front_id);
        } else {
            $post = get_page_by_path($path, OBJECT, ['page','post']);
        }
    }

    if (!$post) {
        return new WP_Error('not_found', 'Page not found', [ 'status' => 404 ]);
    }

    // Basic post data
    $data = [
        'ID' => $post->ID,
        'title' => get_the_title($post),
        'slug' => $post->post_name,
        'link' => get_permalink($post),
        'excerpt' => apply_filters('the_excerpt', $post->post_excerpt),
        'content' => apply_filters('the_content', $post->post_content),
        'featured_media' => $post->post_thumbnail ? $post->post_thumbnail : null,
    ];

    // Sections stored in post meta (JSON or array)
    $sections_raw = get_post_meta($post->ID, 'techforbs_sections', true);
    $sections = [];
    if ($sections_raw) {
        if (is_string($sections_raw)) {
            $decoded = json_decode($sections_raw, true);
            $sections = $decoded ?: [];
        } elseif (is_array($sections_raw)) {
            $sections = $sections_raw;
        }
    }

    // Simple header override
    $header_style = get_post_meta($post->ID, 'techforbs_header_style', true) ?: '';
    $topbar_text = get_post_meta($post->ID, 'techforbs_topbar_text', true) ?: '';

    // Yoast SEO common meta (if Yoast is active these will often be set)
    $yoast = [
        'title' => get_post_meta($post->ID, '_yoast_wpseo_title', true),
        'meta_desc' => get_post_meta($post->ID, '_yoast_wpseo_metadesc', true),
        'canonical' => get_post_meta($post->ID, '_yoast_wpseo_canonical', true),
        'focuskw' => get_post_meta($post->ID, '_yoast_wpseo_focuskw', true),
    ];

    // If Yoast supplies a JSON head entry in postmeta, include it too
    $yoast_head_json = get_post_meta($post->ID, 'yoast_head_json', true);
    if ($yoast_head_json) {
        $yoast['head_json'] = is_string($yoast_head_json) ? json_decode($yoast_head_json, true) : $yoast_head_json;
    }

    // Featured image URL
    $feature = null;
    if (has_post_thumbnail($post)) {
        $thumb_id = get_post_thumbnail_id($post);
        $feature = [
            'id' => $thumb_id,
            'url' => wp_get_attachment_url($thumb_id),
        ];
    }

    // If ACF is available, and the page has the local 'Our Services' fields, append a services section
    if (function_exists('get_field')) {
        // Only append if sections do not already define a services section
        $has_services = false;
        foreach ($sections as $s) {
            if (isset($s['type']) && $s['type'] === 'services') { $has_services = true; break; }
        }

        $acf_items = get_field('items', $post->ID);
        if (!$has_services && is_array($acf_items) && count($acf_items) > 0) {
            $svc_items = [];
            foreach ($acf_items as $it) {
                $svc_items[] = [
                    'title' => sanitize_text_field($it['title'] ?? ''),
                    'description' => sanitize_textarea_field($it['description'] ?? ''),
                    'icon_name' => sanitize_text_field($it['icon_name'] ?? ''),
                    'color' => sanitize_text_field($it['color'] ?? ''),
                    'link' => esc_url_raw($it['link'] ?? ''),
                ];
            }

            $sections[] = [
                'type' => 'services',
                'id' => '',
                'header_style' => '',
                'settings' => [
                    'title' => sanitize_text_field(get_field('title', $post->ID) ?: ''),
                    'subtitle' => sanitize_text_field(get_field('subtitle', $post->ID) ?: ''),
                    'cards' => $svc_items,
                ],
            ];
        }
    }

    // If ACF is available, append Why Choose Us section if not already defined
    if (function_exists('get_field')) {
        $has_why_choose = false;
        foreach ($sections as $s) {
            if (isset($s['type']) && $s['type'] === 'why_choose_us') { $has_why_choose = true; break; }
        }

        $why_items = get_field('items', 'option') ? get_field('items', 'option') : get_field('items', $post->ID);
        if (!$has_why_choose && is_array($why_items) && count($why_items) > 0) {
            $why_feature_items = [];
            foreach ($why_items as $it) {
                $why_feature_items[] = [
                    'title' => sanitize_text_field($it['title'] ?? ''),
                    'description' => sanitize_textarea_field($it['description'] ?? ''),
                    'icon_name' => sanitize_text_field($it['icon_name'] ?? ''),
                    'color' => sanitize_text_field($it['color'] ?? ''),
                    'link' => esc_url_raw($it['link'] ?? ''),
                ];
            }

            $sections[] = [
                'type' => 'why_choose_us',
                'id' => '',
                'header_style' => '',
                'settings' => [
                    'title' => sanitize_text_field(get_field('title', $post->ID) ?: 'Why Choose Us') ?? '',
                    'subtitle' => sanitize_text_field(get_field('subtitle', $post->ID) ?: '') ?? '',
                    'items' => $why_feature_items,
                ],
            ];
        }
    }

    // If ACF is available, append Logos section if not already defined
    if (function_exists('get_field')) {
        $has_logos = false;
        foreach ($sections as $s) {
            if (isset($s['type']) && $s['type'] === 'logos') { $has_logos = true; break; }
        }

        $logos_items = get_field('logos', $post->ID);
        if (!$has_logos && is_array($logos_items) && count($logos_items) > 0) {
            $logos_arr = [];
            foreach ($logos_items as $logo) {
                $logos_arr[] = [
                    'name' => sanitize_text_field($logo['name'] ?? ''),
                    'logo_url' => esc_url_raw($logo['logo_url'] ?? ''),
                ];
            }

            $sections[] = [
                'type' => 'logos',
                'id' => '',
                'header_style' => '',
                'settings' => [
                    'title' => sanitize_text_field(get_field('title', $post->ID) ?: 'Trusted By 1000+ Companies') ?? '',
                    'subtitle' => sanitize_text_field(get_field('subtitle', $post->ID) ?: '') ?? '',
                    'logos' => $logos_arr,
                ],
            ];
        }
    }

    // If ACF is available, append Testimonials section if not already defined
    if (function_exists('get_field')) {
        $has_testimonials = false;
        foreach ($sections as $s) {
            if (isset($s['type']) && $s['type'] === 'testimonials') { $has_testimonials = true; break; }
        }

        $test_items = get_field('testimonials', $post->ID);
        if (!$has_testimonials && is_array($test_items) && count($test_items) > 0) {
            $tests = [];
            foreach ($test_items as $t) {
                $tests[] = [
                    'name' => sanitize_text_field($t['name'] ?? ''),
                    'role' => sanitize_text_field($t['role'] ?? ''),
                    'quote' => sanitize_textarea_field($t['quote'] ?? ''),
                    'avatar' => esc_url_raw($t['avatar'] ?? ''),
                ];
            }

            $sections[] = [
                'type' => 'testimonials',
                'id' => '',
                'header_style' => '',
                'settings' => [
                    'title' => sanitize_text_field(get_field('title', $post->ID) ?: 'Testimonials') ?? '',
                    'subtitle' => sanitize_text_field(get_field('subtitle', $post->ID) ?: '') ?? '',
                    'testimonials' => $tests,
                ],
            ];
        }
    }

    // If ACF is available, append FAQ section if not already defined
    if (function_exists('get_field')) {
        $has_faq = false;
        foreach ($sections as $s) {
            if (isset($s['type']) && $s['type'] === 'faq') { $has_faq = true; break; }
        }

        $faq_items = get_field('faqs', $post->ID);
        if (!$has_faq && is_array($faq_items) && count($faq_items) > 0) {
            $faq_arr = [];
            foreach ($faq_items as $f) {
                $faq_arr[] = [
                    'question' => sanitize_text_field($f['question'] ?? ''),
                    'answer' => apply_filters('the_content', $f['answer'] ?? ''),
                ];
            }

            $sections[] = [
                'type' => 'faq',
                'id' => '',
                'header_style' => '',
                'settings' => [
                    'title' => sanitize_text_field(get_field('title', $post->ID) ?: 'FAQ') ?? '',
                    'subtitle' => sanitize_text_field(get_field('subtitle', $post->ID) ?: '') ?? '',
                    'faqs' => $faq_arr,
                ],
            ];
        }
    }

    return [
        'post' => $data,
        'sections' => $sections,
        'header_style' => $header_style,
        'topbar_text' => $topbar_text,
        'yoast' => $yoast,
        'featured_image' => $feature,
    ];
}


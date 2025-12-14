<?php
/**
 * Register local ACF field groups for TechForbs plugin
 * This registers an "Our Services" field group (repeater) so editors can use ACF UI.
 * It only runs when ACF Pro (or ACF) is active.
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('init', function() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_techforbs_services',
        'title' => 'TechForbs - Our Services',
        'fields' => array(
            array(
                'key' => 'field_tf_services_title',
                'label' => 'Section Title',
                'name' => 'title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_tf_services_subtitle',
                'label' => 'Section Subtitle',
                'name' => 'subtitle',
                'type' => 'text',
            ),
            array(
                'key' => 'field_tf_services_items',
                'label' => 'Services',
                'name' => 'items',
                'type' => 'repeater',
                'button_label' => 'Add Service',
                'sub_fields' => array(
                    array(
                        'key' => 'field_tf_services_item_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_tf_services_item_description',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',
                    ),
                    array(
                        'key' => 'field_tf_services_item_icon',
                        'label' => 'Icon Name',
                        'name' => 'icon_name',
                        'type' => 'text',
                        'instructions' => 'Use icon component name (e.g. MdOutlineHeadset)',
                    ),
                    array(
                        'key' => 'field_tf_services_item_color',
                        'label' => 'Color',
                        'name' => 'color',
                        'type' => 'text',
                        'instructions' => 'Hex color, e.g. #00D4FF',
                    ),
                    array(
                        'key' => 'field_tf_services_item_link',
                        'label' => 'Link',
                        'name' => 'link',
                        'type' => 'url',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
            ),
        ),
    ));

    // Why Choose Us Field Group
    acf_add_local_field_group(array(
        'key' => 'group_techforbs_why_choose_us',
        'title' => 'TechForbs - Why Choose Us',
        'fields' => array(
            array(
                'key' => 'field_tf_why_title',
                'label' => 'Section Title',
                'name' => 'title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_tf_why_subtitle',
                'label' => 'Section Subtitle',
                'name' => 'subtitle',
                'type' => 'text',
            ),
            array(
                'key' => 'field_tf_why_items',
                'label' => 'Features',
                'name' => 'items',
                'type' => 'repeater',
                'button_label' => 'Add Feature',
                'sub_fields' => array(
                    array(
                        'key' => 'field_tf_why_item_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_tf_why_item_description',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',
                    ),
                    array(
                        'key' => 'field_tf_why_item_icon',
                        'label' => 'Icon Name',
                        'name' => 'icon_name',
                        'type' => 'text',
                        'instructions' => 'Use icon component name (e.g. FiAward, MdAutoAwesome)',
                    ),
                    array(
                        'key' => 'field_tf_why_item_color',
                        'label' => 'Color',
                        'name' => 'color',
                        'type' => 'text',
                        'instructions' => 'Hex color, e.g. #00D4FF',
                    ),
                    array(
                        'key' => 'field_tf_why_item_link',
                        'label' => 'Link',
                        'name' => 'link',
                        'type' => 'url',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
            ),
        ),
    ));

    // Logos Field Group
    acf_add_local_field_group(array(
        'key' => 'group_techforbs_logos',
        'title' => 'TechForbs - Logos',
        'fields' => array(
            array(
                'key' => 'field_tf_logos_title',
                'label' => 'Section Title',
                'name' => 'title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_tf_logos_subtitle',
                'label' => 'Section Subtitle',
                'name' => 'subtitle',
                'type' => 'text',
            ),
            array(
                'key' => 'field_tf_logos_items',
                'label' => 'Logos',
                'name' => 'logos',
                'type' => 'repeater',
                'button_label' => 'Add Logo',
                'sub_fields' => array(
                    array(
                        'key' => 'field_tf_logos_item_name',
                        'label' => 'Company Name',
                        'name' => 'name',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_tf_logos_item_url',
                        'label' => 'Logo Image',
                        'name' => 'logo_url',
                        'type' => 'image',
                        'return_format' => 'url',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
            ),
        ),
    ));
    
    // Testimonials Field Group
    acf_add_local_field_group(array(
        'key' => 'group_techforbs_testimonials',
        'title' => 'TechForbs - Testimonials',
        'fields' => array(
            array(
                'key' => 'field_tf_testimonials_title',
                'label' => 'Section Title',
                'name' => 'title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_tf_testimonials_subtitle',
                'label' => 'Section Subtitle',
                'name' => 'subtitle',
                'type' => 'text',
            ),
            array(
                'key' => 'field_tf_testimonials_items',
                'label' => 'Testimonials',
                'name' => 'testimonials',
                'type' => 'repeater',
                'button_label' => 'Add Testimonial',
                'sub_fields' => array(
                    array(
                        'key' => 'field_tf_testimonial_name',
                        'label' => 'Name',
                        'name' => 'name',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_tf_testimonial_role',
                        'label' => 'Role / Company',
                        'name' => 'role',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_tf_testimonial_quote',
                        'label' => 'Quote',
                        'name' => 'quote',
                        'type' => 'textarea',
                    ),
                    array(
                        'key' => 'field_tf_testimonial_avatar',
                        'label' => 'Avatar',
                        'name' => 'avatar',
                        'type' => 'image',
                        'return_format' => 'url',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
            ),
        ),
    ));

    // FAQ Field Group
    acf_add_local_field_group(array(
        'key' => 'group_techforbs_faq',
        'title' => 'TechForbs - FAQ',
        'fields' => array(
            array(
                'key' => 'field_tf_faq_title',
                'label' => 'Section Title',
                'name' => 'title',
                'type' => 'text',
            ),
            array(
                'key' => 'field_tf_faq_subtitle',
                'label' => 'Section Subtitle',
                'name' => 'subtitle',
                'type' => 'text',
            ),
            array(
                'key' => 'field_tf_faq_items',
                'label' => 'FAQ Items',
                'name' => 'faqs',
                'type' => 'repeater',
                'button_label' => 'Add FAQ',
                'sub_fields' => array(
                    array(
                        'key' => 'field_tf_faq_question',
                        'label' => 'Question',
                        'name' => 'question',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_tf_faq_answer',
                        'label' => 'Answer',
                        'name' => 'answer',
                        'type' => 'wysiwyg',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
            ),
        ),
    ));

    // Footer Settings Field Group (Site Options)
    acf_add_local_field_group(array(
        'key' => 'group_techforbs_footer',
        'title' => 'TechForbs - Footer Settings',
        'fields' => array(
            // Logo Section
            array(
                'key' => 'field_tf_footer_logo',
                'label' => 'Footer Logo',
                'name' => 'footer_logo',
                'type' => 'image',
                'return_format' => 'url',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_tf_footer_logo_width',
                'label' => 'Logo Width (px)',
                'name' => 'footer_logo_width',
                'type' => 'number',
                'default_value' => 150,
            ),
            // Company Info Section
            array(
                'key' => 'field_tf_footer_company_description',
                'label' => 'Company Description',
                'name' => 'footer_company_description',
                'type' => 'textarea',
            ),
            array(
                'key' => 'field_tf_footer_address',
                'label' => 'Address',
                'name' => 'footer_address',
                'type' => 'textarea',
            ),
            array(
                'key' => 'field_tf_footer_email',
                'label' => 'Email Address',
                'name' => 'footer_email',
                'type' => 'email',
            ),
            array(
                'key' => 'field_tf_footer_phone',
                'label' => 'Phone Number',
                'name' => 'footer_phone',
                'type' => 'text',
            ),
            // Get In Touch CTA
            array(
                'key' => 'field_tf_footer_cta_link',
                'label' => 'Get In Touch Button Link',
                'name' => 'footer_cta_link',
                'type' => 'url',
                'default_value' => '/contact',
            ),
            array(
                'key' => 'field_tf_footer_cta_text',
                'label' => 'Get In Touch Button Text',
                'name' => 'footer_cta_text',
                'type' => 'text',
                'default_value' => 'Get In Touch',
            ),
            // Services Links
            array(
                'key' => 'field_tf_footer_services',
                'label' => 'Services Links',
                'name' => 'footer_services',
                'type' => 'repeater',
                'button_label' => 'Add Service',
                'sub_fields' => array(
                    array(
                        'key' => 'field_tf_footer_service_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_tf_footer_service_url',
                        'label' => 'URL',
                        'name' => 'url',
                        'type' => 'url',
                    ),
                ),
            ),
            // Company Links
            array(
                'key' => 'field_tf_footer_company_links',
                'label' => 'Company Links',
                'name' => 'footer_company_links',
                'type' => 'repeater',
                'button_label' => 'Add Link',
                'sub_fields' => array(
                    array(
                        'key' => 'field_tf_footer_company_link_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_tf_footer_company_link_url',
                        'label' => 'URL',
                        'name' => 'url',
                        'type' => 'url',
                    ),
                ),
            ),
            // Legal Links
            array(
                'key' => 'field_tf_footer_legal_links',
                'label' => 'Legal Links',
                'name' => 'footer_legal_links',
                'type' => 'repeater',
                'button_label' => 'Add Legal Link',
                'sub_fields' => array(
                    array(
                        'key' => 'field_tf_footer_legal_link_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_tf_footer_legal_link_url',
                        'label' => 'URL',
                        'name' => 'url',
                        'type' => 'url',
                    ),
                ),
            ),
            // Social Links
            array(
                'key' => 'field_tf_footer_social_links',
                'label' => 'Social Media Links',
                'name' => 'footer_social_links',
                'type' => 'repeater',
                'button_label' => 'Add Social Link',
                'sub_fields' => array(
                    array(
                        'key' => 'field_tf_footer_social_platform',
                        'label' => 'Platform',
                        'name' => 'platform',
                        'type' => 'select',
                        'choices' => array(
                            'linkedin' => 'LinkedIn',
                            'twitter' => 'Twitter',
                            'github' => 'GitHub',
                            'facebook' => 'Facebook',
                            'instagram' => 'Instagram',
                        ),
                    ),
                    array(
                        'key' => 'field_tf_footer_social_url',
                        'label' => 'URL',
                        'name' => 'url',
                        'type' => 'url',
                    ),
                ),
            ),
            // Copyright
            array(
                'key' => 'field_tf_footer_copyright',
                'label' => 'Copyright Text',
                'name' => 'footer_copyright',
                'type' => 'text',
                'default_value' => '© TechForbs. All rights reserved.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'techforbs-settings',
                ),
            ),
        ),
    ));
});
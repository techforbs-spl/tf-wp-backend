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
});
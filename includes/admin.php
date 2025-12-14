<?php
/**
 * Admin Functions & Utilities
 */

if (!defined('ABSPATH')) {
    exit;
}

// Add logo upload to general settings
add_action('admin_init', 'techforbs_add_logo_setting');

function techforbs_add_logo_setting() {
    // Register setting for site logo
    register_setting('general', 'site_logo', [
        'type' => 'integer',
        'sanitize_callback' => 'absint',
        'show_in_rest' => true,
    ]);

    // Add field to general settings
    add_settings_field(
        'site_logo',
        'Site Logo',
        'techforbs_logo_upload_field',
        'general'
    );

    // Register setting for global topbar text
    register_setting('general', 'site_topbar_text', [
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'show_in_rest' => true,
    ]);

    add_settings_field(
        'site_topbar_text',
        'Topbar Text',
        'techforbs_site_topbar_field',
        'general'
    );
}

function techforbs_site_topbar_field() {
    $value = get_option('site_topbar_text', '');
    ?>
    <input type="text" name="site_topbar_text" value="<?php echo esc_attr($value); ?>" style="width:100%;max-width:480px;padding:6px;" />
    <p class="description">Text shown in the topbar. Leave empty to hide.</p>
    <?php
}

/**
 * Logo upload field HTML
 */
function techforbs_logo_upload_field() {
    $logo_id = get_option('site_logo');
    $logo_url = $logo_id ? wp_get_attachment_url($logo_id) : '';
    ?>
    <div style="margin: 10px 0;">
        <div id="logo-preview" style="margin-bottom: 15px;">
            <?php if ($logo_url): ?>
                <img src="<?php echo esc_url($logo_url); ?>" alt="Logo" style="max-width: 200px; max-height: 100px;">
            <?php endif; ?>
        </div>
        <input type="hidden" name="site_logo" id="site_logo" value="<?php echo absint($logo_id); ?>">
        <button type="button" id="logo-upload-btn" class="button button-primary">Upload/Select Logo</button>
        <?php if ($logo_id): ?>
            <button type="button" id="logo-remove-btn" class="button button-danger">Remove Logo</button>
        <?php endif; ?>
    </div>
    <p class="description">Upload your site logo. This will be used in the header and across the site.</p>

    <script>
        jQuery(function($) {
            var frame;
            var $logo_id = $('#site_logo');
            var $preview = $('#logo-preview');

            $('#logo-upload-btn').click(function(e) {
                e.preventDefault();
                
                if (frame) {
                    frame.open();
                    return;
                }

                frame = wp.media({
                    title: 'Select Logo',
                    button: { text: 'Use Logo' },
                    multiple: false,
                    library: { type: 'image' }
                });

                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    $logo_id.val(attachment.id);
                    
                    // Update preview
                    $preview.html('<img src="' + attachment.url + '" alt="Logo" style="max-width: 200px; max-height: 100px;">');
                    
                    // Show remove button
                    if (!$('#logo-remove-btn').length) {
                        $('#logo-upload-btn').after(' <button type="button" id="logo-remove-btn" class="button button-danger">Remove Logo</button>');
                    }
                });

                frame.open();
            });

            $(document).on('click', '#logo-remove-btn', function(e) {
                e.preventDefault();
                $logo_id.val('');
                $preview.html('');
                $(this).remove();
            });
        });
    </script>
    <?php
}

?>

<?php
// -----------------------------------------------------------------------------
// Page/Post Meta Box for TechForbs Sections
// -----------------------------------------------------------------------------

add_action('add_meta_boxes', 'techforbs_add_sections_meta_box');
function techforbs_add_sections_meta_box() {
    add_meta_box(
        'techforbs-sections',
        'TechForbs Sections',
        'techforbs_sections_meta_box_cb',
        ['page', 'post'],
        'normal',
        'high'
    );
}

function techforbs_sections_meta_box_cb($post) {
    wp_nonce_field('techforbs_sections_save', 'techforbs_sections_nonce');

    $sections = get_post_meta($post->ID, 'techforbs_sections', true);
    $sections_array = [];
    if ($sections) {
        if (is_array($sections)) {
            $sections_array = $sections;
        } elseif (is_string($sections)) {
            $decoded = json_decode($sections, true);
            $sections_array = is_array($decoded) ? $decoded : [];
        }
    }

    $header_style = get_post_meta($post->ID, 'techforbs_header_style', true) ?: 'auto';
    $topbar_text = get_post_meta($post->ID, 'techforbs_topbar_text', true) ?: '';
    ?>
    <div style="margin:8px 0;">
        <label style="display:block;margin-bottom:6px;font-weight:600;">Topbar Text</label>
        <input type="text" name="techforbs_topbar_text" value="<?php echo esc_attr($topbar_text); ?>" style="width:100%;padding:8px;" />

        <label style="display:block;margin:12px 0 6px;font-weight:600;">Header Style</label>
        <select name="techforbs_header_style" style="width:100%;padding:8px;">
            <option value="auto" <?php selected($header_style, 'auto'); ?>>Auto (default)</option>
            <option value="light" <?php selected($header_style, 'light'); ?>>Light (light text)</option>
            <option value="dark" <?php selected($header_style, 'dark'); ?>>Dark (dark text)</option>
        </select>

        <h3 style="margin-top:16px;">Page Sections</h3>
        <p class="description">Add, edit, and reorder sections for this page. Sections will appear on your site in the order shown below.</p>

        <!-- Hidden input to store the final JSON -->
        <input type="hidden" name="techforbs_sections_data" id="techforbs_sections_data" value="<?php echo esc_attr(json_encode($sections_array)); ?>">

        <!-- Sections repeater container -->
        <div id="techforbs-sections-container" style="margin-top:12px;">
            <?php foreach ($sections_array as $idx => $section): ?>
                <div class="tf-section-row" data-index="<?php echo absint($idx); ?>" style="border:1px solid #ddd;padding:12px;margin-bottom:8px;background:#f9f9f9;position:relative;">
                    <div style="display:flex;gap:8px;margin-bottom:10px;align-items:center;">
                        <select class="tf-section-type" style="flex:1;padding:6px;" onchange="TechForbsAdmin.updateSectionLabel(this);">
                            <option value="">-- Select Type --</option>
                            <option value="hero" <?php selected($section['type'], 'hero'); ?>>Hero</option>
                            <option value="services" <?php selected($section['type'], 'services'); ?>>Services</option>
                            <option value="why_choose_us" <?php selected($section['type'], 'why_choose_us'); ?>>Why Choose Us</option>
                            <option value="logos" <?php selected($section['type'], 'logos'); ?>>Logos</option>
                        </select>
                        <button type="button" class="button tf-remove-section" onclick="TechForbsAdmin.removeSection(this);">Remove</button>
                        <button type="button" class="button tf-move-up" onclick="TechForbsAdmin.moveUp(this);">↑</button>
                        <button type="button" class="button tf-move-down" onclick="TechForbsAdmin.moveDown(this);">↓</button>
                    </div>

                    <!-- Common fields (title, subtitle) -->
                    <div style="margin-bottom:8px;">
                        <label style="display:block;font-size:12px;margin-bottom:4px;">Title (optional)</label>
                        <input type="text" class="tf-field-title" value="<?php echo esc_attr($section['settings']['title'] ?? ''); ?>" style="width:100%;padding:6px;font-size:13px;" placeholder="Section title">
                    </div>
                    <div style="margin-bottom:8px;">
                        <label style="display:block;font-size:12px;margin-bottom:4px;">Subtitle (optional)</label>
                        <input type="text" class="tf-field-subtitle" value="<?php echo esc_attr($section['settings']['subtitle'] ?? ''); ?>" style="width:100%;padding:6px;font-size:13px;" placeholder="Section subtitle">
                    </div>

                    <!-- Why Choose Us Repeater Fields -->
                    <div class="tf-repeater-container" style="display:none;margin-top:12px;">
                        <label style="display:block;font-size:12px;margin-bottom:8px;font-weight:600;">Items (features / cards)</label>
                        <div class="tf-repeater-rows" style="background:#fff;border:1px solid #ddd;padding:8px;border-radius:3px;">
                                <?php 
                                $items = isset($section['settings']['items']) && is_array($section['settings']['items']) ? $section['settings']['items'] : [];
                                foreach ($items as $item_idx => $item): 
                                ?>
                                    <div class="tf-repeater-row" data-row-idx="<?php echo absint($item_idx); ?>" style="border:1px solid #e0e0e0;padding:8px;margin-bottom:8px;background:#fafafa;border-radius:3px;">
                                        <input type="text" class="tf-repeater-field-title" placeholder="Title" value="<?php echo esc_attr($item['title'] ?? ''); ?>" style="width:100%;padding:6px;margin-bottom:6px;font-size:12px;">
                                        <textarea class="tf-repeater-field-description" placeholder="Description" style="width:100%;padding:6px;margin-bottom:6px;font-size:12px;height:60px;"><?php echo esc_textarea($item['description'] ?? ''); ?></textarea>
                                        <input type="text" class="tf-repeater-field-color" placeholder="Color (e.g., #00D4FF)" value="<?php echo esc_attr($item['color'] ?? '#00D4FF'); ?>" style="width:48%;padding:6px;margin-bottom:6px;font-size:12px;display:inline-block;margin-right:4%;">
                                        <input type="text" class="tf-repeater-field-icon" placeholder="Icon (e.g., FiAward or MdOutlineHeadset)" value="<?php echo esc_attr($item['icon_name'] ?? ''); ?>" style="width:48%;padding:6px;margin-bottom:6px;font-size:12px;display:inline-block;">
                                        <input type="text" class="tf-repeater-field-link" placeholder="Link (optional)" value="<?php echo esc_attr($item['link'] ?? ''); ?>" style="width:100%;padding:6px;margin-top:6px;font-size:12px;">
                                        <button type="button" class="button button-small tf-repeater-remove" onclick="TechForbsAdmin.removeRepeaterRow(this);" style="font-size:11px;">Remove</button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <button type="button" class="button button-small tf-repeater-add" onclick="TechForbsAdmin.addRepeaterRow(this);" style="margin-top:8px;font-size:11px;">+ Add Feature</button>
                    </div>

                    <!-- Extra fields stored as JSON for this section's settings -->
                    <div style="display:none;" class="tf-section-extra-json">
                        <textarea class="tf-field-extra-json" style="width:100%;padding:6px;font-size:12px;font-family:monospace;height:100px;"><?php echo esc_textarea(json_encode($section['settings'] ?? [], JSON_PRETTY_PRINT)); ?></textarea>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <p style="margin-top:12px;">
            <button type="button" class="button button-primary" onclick="TechForbsAdmin.addSection();">+ Add Section</button>
        </p>
    </div>

    <style>
        .tf-section-row { border-left: 4px solid #0073aa; }
        .tf-section-row:hover { background: #f5f5f5; }
        .tf-controls { display:flex;gap:6px; }
        .tf-controls button { padding:4px 8px;font-size:12px; }
    </style>

    <script type="text/javascript">
        var TechForbsAdmin = {
            addSection: function() {
                var container = document.getElementById('techforbs-sections-container');
                var newIdx = container.children.length;
                var html = `
                    <div class="tf-section-row" data-index="${newIdx}" style="border:1px solid #ddd;padding:12px;margin-bottom:8px;background:#f9f9f9;position:relative;">
                        <div style="display:flex;gap:8px;margin-bottom:10px;align-items:center;">
                            <select class="tf-section-type" style="flex:1;padding:6px;" onchange="TechForbsAdmin.updateSectionLabel(this);">
                                <option value="">-- Select Type --</option>
                                <option value="hero">Hero</option>
                                <option value="services">Services</option>
                                <option value="why_choose_us">Why Choose Us</option>
                                <option value="logos">Logos</option>
                            </select>
                            <button type="button" class="button tf-remove-section" onclick="TechForbsAdmin.removeSection(this);">Remove</button>
                            <button type="button" class="button tf-move-up" onclick="TechForbsAdmin.moveUp(this);">↑</button>
                            <button type="button" class="button tf-move-down" onclick="TechForbsAdmin.moveDown(this);">↓</button>
                        </div>
                        <div style="margin-bottom:8px;">
                            <label style="display:block;font-size:12px;margin-bottom:4px;">Title (optional)</label>
                            <input type="text" class="tf-field-title" style="width:100%;padding:6px;font-size:13px;" placeholder="Section title">
                        </div>
                        <div style="margin-bottom:8px;">
                            <label style="display:block;font-size:12px;margin-bottom:4px;">Subtitle (optional)</label>
                            <input type="text" class="tf-field-subtitle" style="width:100%;padding:6px;font-size:13px;" placeholder="Section subtitle">
                        </div>
                        <div class="tf-repeater-container" style="display:none;margin-top:12px;">
                            <label style="display:block;font-size:12px;margin-bottom:8px;font-weight:600;">Features (Why Choose Us)</label>
                            <div class="tf-repeater-rows" style="background:#fff;border:1px solid #ddd;padding:8px;border-radius:3px;"></div>
                            <button type="button" class="button button-small tf-repeater-add" onclick="TechForbsAdmin.addRepeaterRow(this);" style="margin-top:8px;font-size:11px;">+ Add Feature</button>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', html);
            },
            removeSection: function(btn) {
                btn.closest('.tf-section-row').remove();
                TechForbsAdmin.serialize();
            },
            moveUp: function(btn) {
                var row = btn.closest('.tf-section-row');
                var prev = row.previousElementSibling;
                if (prev) row.parentNode.insertBefore(row, prev);
                TechForbsAdmin.serialize();
            },
            moveDown: function(btn) {
                var row = btn.closest('.tf-section-row');
                var next = row.nextElementSibling;
                if (next) row.parentNode.insertBefore(next, row);
                TechForbsAdmin.serialize();
            },
            updateSectionLabel: function(select) {
                var row = select.closest('.tf-section-row');
                var repeaterContainer = row.querySelector('.tf-repeater-container');
                var type = select.value;
                
                // Show repeater for "why_choose_us" and "services" sections
                if (repeaterContainer) {
                    repeaterContainer.style.display = (type === 'why_choose_us' || type === 'services') ? 'block' : 'none';
                }
                TechForbsAdmin.serialize();
            },
            addRepeaterRow: function(btn) {
                var container = btn.closest('.tf-repeater-container');
                var rows = container.querySelector('.tf-repeater-rows');
                var newIdx = rows.children.length;
                var html = `
                    <div class="tf-repeater-row" data-row-idx="${newIdx}" style="border:1px solid #e0e0e0;padding:8px;margin-bottom:8px;background:#fafafa;border-radius:3px;">
                        <input type="text" class="tf-repeater-field-title" placeholder="Title" style="width:100%;padding:6px;margin-bottom:6px;font-size:12px;">
                        <textarea class="tf-repeater-field-description" placeholder="Description" style="width:100%;padding:6px;margin-bottom:6px;font-size:12px;height:60px;"></textarea>
                        <input type="text" class="tf-repeater-field-color" placeholder="Color (e.g., #00D4FF)" value="#00D4FF" style="width:48%;padding:6px;margin-bottom:6px;font-size:12px;display:inline-block;margin-right:4%;">
                        <input type="text" class="tf-repeater-field-icon" placeholder="Icon (e.g., FiAward or MdOutlineHeadset)" style="width:48%;padding:6px;margin-bottom:6px;font-size:12px;display:inline-block;">
                        <input type="text" class="tf-repeater-field-link" placeholder="Link (optional)" style="width:100%;padding:6px;margin-top:6px;font-size:12px;">
                        <button type="button" class="button button-small tf-repeater-remove" onclick="TechForbsAdmin.removeRepeaterRow(this);" style="font-size:11px;">Remove</button>
                    </div>
                `;
                rows.insertAdjacentHTML('beforeend', html);
                TechForbsAdmin.serialize();
            },
            removeRepeaterRow: function(btn) {
                var row = btn.closest('.tf-repeater-row');
                row.remove();
                TechForbsAdmin.serialize();
            },
            serialize: function() {
                var container = document.getElementById('techforbs-sections-container');
                var rows = Array.from(container.querySelectorAll('.tf-section-row'));
                var sections = rows.map(row => {
                    var type = row.querySelector('.tf-section-type').value;
                    var title = row.querySelector('.tf-field-title').value;
                    var subtitle = row.querySelector('.tf-field-subtitle').value;
                    
                    var settings = {
                        title: title,
                        subtitle: subtitle
                    };
                    
                    // Handle repeater rows for "why_choose_us"
                            if (type === 'why_choose_us') {
                        var repeaterContainer = row.querySelector('.tf-repeater-container');
                        if (repeaterContainer) {
                            var repeaterRows = Array.from(repeaterContainer.querySelectorAll('.tf-repeater-row'));
                                    settings.items = repeaterRows.map(rrow => ({
                                        title: rrow.querySelector('.tf-repeater-field-title').value,
                                        description: rrow.querySelector('.tf-repeater-field-description').value,
                                        color: rrow.querySelector('.tf-repeater-field-color').value,
                                        icon_name: rrow.querySelector('.tf-repeater-field-icon').value,
                                        link: (rrow.querySelector('.tf-repeater-field-link') ? rrow.querySelector('.tf-repeater-field-link').value : '')
                                    }));
                        }
                    }
                    
                    return {
                        type: type,
                        id: '',
                        header_style: '',
                        settings: settings
                    };
                });
                document.getElementById('techforbs_sections_data').value = JSON.stringify(sections);
            }
        };

        // Serialize before form submit (classic editor)
        document.addEventListener('submit', function(e) {
            if (e.target.matches('form[id*="post"]')) {
                TechForbsAdmin.serialize();
            }
        });

        // Also serialize on any input/change within the sections container so values are kept up-to-date
        (function() {
            var container = document.getElementById('techforbs-sections-container');
            if (!container) return;

            // Initialize repeater visibility for existing rows
            Array.from(container.querySelectorAll('.tf-section-row')).forEach(function(row) {
                var sel = row.querySelector('.tf-section-type');
                if (sel) TechForbsAdmin.updateSectionLabel(sel);
            });

            // Serialize when editors interact with fields
            container.addEventListener('input', function() { TechForbsAdmin.serialize(); }, true);
            container.addEventListener('change', function() { TechForbsAdmin.serialize(); }, true);

            // Hook publish/save buttons (classic and Gutenberg)
            document.addEventListener('click', function(e) {
                var t = e.target;
                if (!t) return;
                if (t.id === 'publish' || t.id === 'save-post' || t.classList && t.classList.contains('editor-post-publish-button')) {
                    TechForbsAdmin.serialize();
                }
            });

            // Also serialize before window unload as a last resort
            window.addEventListener('beforeunload', function() { TechForbsAdmin.serialize(); });

            // If Gutenberg is available, subscribe to editor changes and serialize
            try {
                if (typeof wp !== 'undefined' && wp.data && wp.data.subscribe) {
                    var last = null;
                    wp.data.subscribe(function() {
                        // Call serialize periodically when editor state changes
                        // (keeps meta-box hidden input synced when Gutenberg saves via AJAX)
                        if (last === null) last = Date.now();
                        var now = Date.now();
                        if (now - last > 500) {
                            last = now;
                            TechForbsAdmin.serialize();
                        }
                    });
                }
            } catch (ex) {
                // ignore
            }
        })();
    </script>
    <?php
}

add_action('save_post', 'techforbs_sections_save');
function techforbs_sections_save($post_id) {
    if (!isset($_POST['techforbs_sections_nonce'])) return;
    if (!wp_verify_nonce($_POST['techforbs_sections_nonce'], 'techforbs_sections_save')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    // Use new repeater field (techforbs_sections_data) if present
    if (isset($_POST['techforbs_sections_data'])) {
        $raw = wp_unslash($_POST['techforbs_sections_data']);
        $decoded = json_decode($raw, true);
        
        if (is_array($decoded)) {
            // Sanitize each section
            $sanitized = [];
            foreach ($decoded as $section) {
                $sanitized[] = [
                    'type' => sanitize_text_field($section['type'] ?? ''),
                    'id' => sanitize_text_field($section['id'] ?? ''),
                    'header_style' => sanitize_text_field($section['header_style'] ?? ''),
                    'settings' => techforbs_sanitize_section_settings($section['settings'] ?? [])
                ];
            }
            update_post_meta($post_id, 'techforbs_sections', $sanitized);
        } else {
            delete_post_meta($post_id, 'techforbs_sections');
        }
    }
    // Fallback for legacy direct field
    elseif (isset($_POST['techforbs_sections'])) {
        $raw = wp_unslash($_POST['techforbs_sections']);
        $decoded = json_decode($raw, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            update_post_meta($post_id, 'techforbs_sections', $decoded);
        } else {
            update_post_meta($post_id, 'techforbs_sections', sanitize_textarea_field($raw));
        }
    }

    if (isset($_POST['techforbs_header_style'])) {
        update_post_meta($post_id, 'techforbs_header_style', sanitize_text_field($_POST['techforbs_header_style']));
    }

    if (isset($_POST['techforbs_topbar_text'])) {
        update_post_meta($post_id, 'techforbs_topbar_text', sanitize_text_field($_POST['techforbs_topbar_text']));
    }
}

/**
 * Sanitize section settings (deep sanitization for arrays)
 */
function techforbs_sanitize_section_settings($settings) {
    if (!is_array($settings)) return [];
    $safe = [];
    foreach ($settings as $key => $value) {
        $key = sanitize_key($key);
        if (is_array($value)) {
            $safe[$key] = techforbs_sanitize_section_settings($value);
        } elseif (is_string($value)) {
            $safe[$key] = sanitize_text_field($value);
        } else {
            $safe[$key] = $value;
        }
    }
    return $safe;
}

// Add TechForbs Settings Options Page for ACF
add_action('acf/init', 'techforbs_add_options_page');

function techforbs_add_options_page() {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page(array(
            'page_title' => 'TechForbs Settings',
            'menu_title' => 'TechForbs Settings',
            'menu_slug' => 'techforbs-settings',
            'capability' => 'manage_options',
            'redirect' => false,
            'position' => 30,
            'icon_url' => 'dashicons-admin-generic',
        ));
    }
}

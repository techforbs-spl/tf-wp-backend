<?php
/**
 * Hero Section Management
 * 
 * Handles hero section settings, admin pages, and form processing
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('admin_menu', 'techforbs_add_components_menu');
add_action('admin_init', 'techforbs_process_hero_form_data');
add_action('techforbs_activate', 'techforbs_hero_activate_defaults');

/**
 * Add TechForbs menu and submenus
 */
function techforbs_add_components_menu() {
    // Main menu for TechForbs Components
    add_menu_page(
        'TechForbs Components',
        'TechForbs',
        'manage_options',
        'techforbs-components',
        'techforbs_render_components_page',
        'dashicons-admin-generic',
        99
    );

    // Submenu: Hero Settings
    add_submenu_page(
        'techforbs-components',
        'Hero Section Settings',
        'Hero Settings',
        'manage_options',
        'hero-settings',
        'techforbs_render_hero_settings_page'
    );

    // Submenu: Menu Management
    add_submenu_page(
        'techforbs-components',
        'Menu Management',
        'Menu Management',
        'manage_options',
        'menu-settings',
        'techforbs_render_menu_settings_page'
    );
}

/**
 * Main Components Dashboard Page
 */
function techforbs_render_components_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Permission denied'));
    }
    ?>
    <div class="wrap">
        <h1>TechForbs Components Manager</h1>
        <p style="color: #666; font-size: 16px; margin: 20px 0;">
            Manage all site components from one place. Choose a section below to configure.
        </p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-top: 30px;">
            <!-- Hero Settings Card -->
            <div style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; background: #fff;">
                <h3 style="margin-top: 0;">🎨 Hero Section</h3>
                <p style="color: #666;">Configure your hero section content, colors, and buttons.</p>
                <a href="<?php echo admin_url('admin.php?page=hero-settings'); ?>" class="button button-primary">
                    Manage Hero Section
                </a>
            </div>

            <!-- Menu Settings Card -->
            <div style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; background: #fff;">
                <h3 style="margin-top: 0;">📋 Menus</h3>
                <p style="color: #666;">Manage navigation menus for header, footer, and mobile.</p>
                <a href="<?php echo admin_url('admin.php?page=menu-settings'); ?>" class="button button-primary">
                    Manage Menus
                </a>
            </div>

            <!-- REST API Card -->
            <div style="border: 1px solid #ddd; padding: 20px; border-radius: 8px; background: #f9f9f9;">
                <h3 style="margin-top: 0;">🔌 REST API</h3>
                <p style="color: #666;">All data is available via REST API endpoints.</p>
                <code style="background: #eee; padding: 10px; display: block; border-radius: 4px; margin-top: 10px;">
                    /wp-json/techforbs/v1/hero-settings
                </code>
            </div>
        </div>

        <div style="margin-top: 40px; padding: 20px; background: #f0f0f0; border-radius: 8px;">
            <h3>📚 Quick Links</h3>
            <ul>
                <li><a href="<?php echo admin_url('nav-menus.php'); ?>">WordPress Menu Manager</a></li>
                <li><a href="<?php echo admin_url('admin.php?page=hero-settings'); ?>">Configure Hero Section</a></li>
                <li><a href="<?php echo site_url('/wp-json/techforbs/v1/hero-settings'); ?>" target="_blank">View Hero Settings API</a></li>
                <li><a href="<?php echo site_url('/wp-json/techforbs/v1/menus'); ?>" target="_blank">View Menus API</a></li>
                <li><a href="<?php echo site_url('/wp-json/techforbs/v1/logo'); ?>" target="_blank">View Logo API</a></li>
            </ul>
        </div>
    </div>
    <?php
}

/**
 * Hero Settings Page
 */
function techforbs_render_hero_settings_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Permission denied'));
    }

    // Get existing values with defaults
    $hero_title = get_option('hero_title', 'Perfect IT Solutions For Your Business');
    $hero_subtitle = get_option('hero_subtitle', 'Delivering exceptional e-commerce and website solutions using Shopify, WooCommerce, and WordPress. From custom development to optimization, we craft scalable, user-friendly platforms that drive growth and success.');
    $hero_badge_text = get_option('hero_badge_text', 'Shopify, WooCommerce & WordPress');
    
    $cta_primary = json_decode(get_option('hero_cta_primary', '{"text":"Get Free Consultation","link":"/contact"}'), true);
    $cta_secondary = json_decode(get_option('hero_cta_secondary', '{"text":"Explore Services","link":"/services"}'), true);
    $exp_badge = json_decode(get_option('hero_exp_badge', '{"title":"Shopify Expert","description":"14+ years experience"}'), true);
    $success_badge = json_decode(get_option('hero_success_badge', '{"label":"Success Rate","value":"99.9%"}'), true);
    
    $hero_gradient_1 = get_option('hero_gradient_1', '#070b14');
    $hero_gradient_2 = get_option('hero_gradient_2', '#0c1322');
    $hero_gradient_3 = get_option('hero_gradient_3', '#070b14');

    $platforms = json_decode(get_option('hero_platforms', '[]'), true) ?: [];
    $stats = json_decode(get_option('hero_stats', '[]'), true) ?: [];
    ?>
    <div class="wrap">
        <h1>🎨 Hero Section Settings</h1>
        <p style="color: #666;">Configure all content for your hero section. All changes are automatically saved and available via REST API.</p>

        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php settings_fields('site-settings'); ?>

            <!-- Hero Content Section -->
            <div style="background: white; padding: 20px; margin-top: 20px; border-radius: 8px; border: 1px solid #ddd;">
                <h2>📝 Hero Content</h2>
                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="hero_title">Hero Title *</label></th>
                            <td>
                                <input 
                                    type="text" 
                                    name="hero_title" 
                                    id="hero_title" 
                                    value="<?php echo esc_attr($hero_title); ?>" 
                                    class="regular-text"
                                    required
                                />
                                <p class="description">Main headline text</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="hero_subtitle">Hero Subtitle *</label></th>
                            <td>
                                <textarea 
                                    name="hero_subtitle" 
                                    id="hero_subtitle" 
                                    rows="5" 
                                    class="large-text"
                                    required
                                ><?php echo esc_textarea($hero_subtitle); ?></textarea>
                                <p class="description">Description text below headline</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="hero_badge_text">Badge Text</label></th>
                            <td>
                                <input 
                                    type="text" 
                                    name="hero_badge_text" 
                                    id="hero_badge_text" 
                                    value="<?php echo esc_attr($hero_badge_text); ?>" 
                                    class="regular-text"
                                />
                                <p class="description">Top badge text (e.g., "Shopify, WooCommerce & WordPress")</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Colors Section -->
            <div style="background: white; padding: 20px; margin-top: 20px; border-radius: 8px; border: 1px solid #ddd;">
                <h2>🎨 Background Gradient Colors</h2>
                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row"><label for="hero_gradient_1">Primary Color</label></th>
                            <td>
                                <input 
                                    type="color" 
                                    name="hero_gradient_1" 
                                    id="hero_gradient_1" 
                                    value="<?php echo esc_attr($hero_gradient_1); ?>"
                                />
                                <p class="description">Top gradient color</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="hero_gradient_2">Secondary Color</label></th>
                            <td>
                                <input 
                                    type="color" 
                                    name="hero_gradient_2" 
                                    id="hero_gradient_2" 
                                    value="<?php echo esc_attr($hero_gradient_2); ?>"
                                />
                                <p class="description">Middle gradient color</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label for="hero_gradient_3">Tertiary Color</label></th>
                            <td>
                                <input 
                                    type="color" 
                                    name="hero_gradient_3" 
                                    id="hero_gradient_3" 
                                    value="<?php echo esc_attr($hero_gradient_3); ?>"
                                />
                                <p class="description">Bottom gradient color</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- CTA Buttons Section -->
            <div style="background: white; padding: 20px; margin-top: 20px; border-radius: 8px; border: 1px solid #ddd;">
                <h2>🔘 Call-to-Action Buttons</h2>
                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row"><label>Primary Button</label></th>
                            <td>
                                <input 
                                    type="text" 
                                    name="hero_cta_primary[text]" 
                                    value="<?php echo esc_attr($cta_primary['text'] ?? ''); ?>" 
                                    placeholder="Button Text" 
                                    class="regular-text" 
                                    style="width: 48%; margin-right: 2%;"
                                />
                                <input 
                                    type="url" 
                                    name="hero_cta_primary[link]" 
                                    value="<?php echo esc_attr($cta_primary['link'] ?? ''); ?>" 
                                    placeholder="Button Link" 
                                    class="regular-text" 
                                    style="width: 48%;"
                                />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Secondary Button</label></th>
                            <td>
                                <input 
                                    type="text" 
                                    name="hero_cta_secondary[text]" 
                                    value="<?php echo esc_attr($cta_secondary['text'] ?? ''); ?>" 
                                    placeholder="Button Text" 
                                    class="regular-text" 
                                    style="width: 48%; margin-right: 2%;"
                                />
                                <input 
                                    type="url" 
                                    name="hero_cta_secondary[link]" 
                                    value="<?php echo esc_attr($cta_secondary['link'] ?? ''); ?>" 
                                    placeholder="Button Link" 
                                    class="regular-text" 
                                    style="width: 48%;"
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Floating Badges Section -->
            <div style="background: white; padding: 20px; margin-top: 20px; border-radius: 8px; border: 1px solid #ddd;">
                <h2>✨ Floating Badges</h2>
                <table class="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row"><label>Experience Badge</label></th>
                            <td>
                                <input 
                                    type="text" 
                                    name="hero_exp_badge[title]" 
                                    value="<?php echo esc_attr($exp_badge['title'] ?? ''); ?>" 
                                    placeholder="Title" 
                                    class="regular-text" 
                                    style="width: 48%; margin-right: 2%;"
                                />
                                <input 
                                    type="text" 
                                    name="hero_exp_badge[description]" 
                                    value="<?php echo esc_attr($exp_badge['description'] ?? ''); ?>" 
                                    placeholder="Description" 
                                    class="regular-text" 
                                    style="width: 48%;"
                                />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><label>Success Rate Badge</label></th>
                            <td>
                                <input 
                                    type="text" 
                                    name="hero_success_badge[label]" 
                                    value="<?php echo esc_attr($success_badge['label'] ?? ''); ?>" 
                                    placeholder="Label" 
                                    class="regular-text" 
                                    style="width: 48%; margin-right: 2%;"
                                />
                                <input 
                                    type="text" 
                                    name="hero_success_badge[value]" 
                                    value="<?php echo esc_attr($success_badge['value'] ?? ''); ?>" 
                                    placeholder="Value" 
                                    class="regular-text" 
                                    style="width: 48%;"
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Statistics Section -->
            <div style="background: white; padding: 20px; margin-top: 20px; border-radius: 8px; border: 1px solid #ddd;">
                <h2>📊 Hero Statistics</h2>
                <p>Add key statistics to display in hero section</p>
                <div id="stats-container" style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
                    <?php foreach ($stats as $index => $stat): ?>
                        <div class="stat-row" style="margin-bottom: 10px; padding: 10px; background: white; border: 1px solid #ddd; border-radius: 3px;">
                            <input 
                                type="text" 
                                name="hero_stats[<?php echo $index; ?>][value]" 
                                placeholder="e.g., 14+" 
                                value="<?php echo esc_attr($stat['value'] ?? ''); ?>"
                                class="regular-text"
                                style="width: 30%; margin-right: 2%;"
                            />
                            <input 
                                type="text" 
                                name="hero_stats[<?php echo $index; ?>][label]" 
                                placeholder="e.g., Years of Experience" 
                                value="<?php echo esc_attr($stat['label'] ?? ''); ?>"
                                class="regular-text"
                                style="width: 60%; margin-right: 2%;"
                            />
                            <button type="button" class="button button-danger remove-stat">×</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button button-primary" id="add-stat">+ Add Statistic</button>
            </div>

            <!-- Platforms Section -->
            <div style="background: white; padding: 20px; margin-top: 20px; border-radius: 8px; border: 1px solid #ddd;">
                <h2>🛠️ Service Platforms</h2>
                <p>Add the platforms you offer (Shopify, WooCommerce, WordPress, etc.)</p>
                <div id="platforms-container" style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
                    <?php foreach ($platforms as $index => $platform): ?>
                        <div class="platform-row" style="margin-bottom: 10px; padding: 10px; background: white; border: 1px solid #ddd; border-radius: 3px;">
                            <input 
                                type="text" 
                                name="hero_platforms[<?php echo $index; ?>][name]" 
                                placeholder="e.g., Shopify" 
                                value="<?php echo esc_attr($platform['name'] ?? ''); ?>"
                                class="regular-text"
                                style="width: 30%; margin-right: 2%;"
                            />
                            <input 
                                type="text" 
                                name="hero_platforms[<?php echo $index; ?>][url]" 
                                placeholder="e.g., #shopify or /services" 
                                value="<?php echo esc_attr($platform['url'] ?? ''); ?>"
                                class="regular-text"
                                style="width: 60%; margin-right: 2%;"
                            />
                            <button type="button" class="button button-danger remove-platform">×</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button button-primary" id="add-platform">+ Add Platform</button>
            </div>

            <?php submit_button('Save Hero Settings'); ?>
        </form>
    </div>

    <script src="<?php echo TECHFORBS_PLUGIN_URL . 'assets/js/hero-admin.js'; ?>"></script>
    <?php
}

/**
 * Menu Management Settings Page
 */
function techforbs_render_menu_settings_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Permission denied'));
    }
    ?>
    <div class="wrap">
        <h1>📋 Menu Management</h1>
        <p style="color: #666;">Manage navigation menus for your website. Create menus in WordPress and assign them to menu locations.</p>

        <div style="background: white; padding: 20px; margin-top: 20px; border-radius: 8px; border: 1px solid #ddd;">
            <h2>Available Menu Locations</h2>
            <table class="wp-list-table widefat">
                <thead>
                    <tr>
                        <th>Menu Location</th>
                        <th>Description</th>
                        <th>Assigned Menu</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Primary Menu</strong></td>
                        <td>Main header navigation</td>
                        <td>
                            <?php 
                                $primary = get_nav_menu_locations()['primary'] ?? null;
                                echo $primary ? get_the_title($primary) : '<em>Not assigned</em>';
                            ?>
                        </td>
                        <td><a href="<?php echo admin_url('nav-menus.php'); ?>" class="button">Manage</a></td>
                    </tr>
                    <tr>
                        <td><strong>Secondary Menu</strong></td>
                        <td>Footer navigation</td>
                        <td>
                            <?php 
                                $secondary = get_nav_menu_locations()['secondary'] ?? null;
                                echo $secondary ? get_the_title($secondary) : '<em>Not assigned</em>';
                            ?>
                        </td>
                        <td><a href="<?php echo admin_url('nav-menus.php'); ?>" class="button">Manage</a></td>
                    </tr>
                    <tr>
                        <td><strong>Mobile Menu</strong></td>
                        <td>Mobile responsive menu</td>
                        <td>
                            <?php 
                                $mobile = get_nav_menu_locations()['mobile'] ?? null;
                                echo $mobile ? get_the_title($mobile) : '<em>Not assigned</em>';
                            ?>
                        </td>
                        <td><a href="<?php echo admin_url('nav-menus.php'); ?>" class="button">Manage</a></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="background: white; padding: 20px; margin-top: 20px; border-radius: 8px; border: 1px solid #ddd;">
            <h2>📌 Default Menu Items for Primary Menu</h2>
            <p style="color: #666;">These are the suggested menu items for the primary header navigation:</p>
            <table class="wp-list-table widefat">
                <thead>
                    <tr>
                        <th>Label</th>
                        <th>Link Type</th>
                        <th>URL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Shopify</td>
                        <td>Anchor</td>
                        <td>#shopify</td>
                    </tr>
                    <tr>
                        <td>WooCommerce</td>
                        <td>Anchor</td>
                        <td>#woocommerce</td>
                    </tr>
                    <tr>
                        <td>WordPress</td>
                        <td>Anchor</td>
                        <td>#wordpress</td>
                    </tr>
                    <tr>
                        <td>Services</td>
                        <td>Page</td>
                        <td>/services</td>
                    </tr>
                    <tr>
                        <td>Portfolio</td>
                        <td>Page</td>
                        <td>/projects</td>
                    </tr>
                    <tr>
                        <td>Blog</td>
                        <td>Page</td>
                        <td>/blog</td>
                    </tr>
                    <tr>
                        <td>Contact</td>
                        <td>Page</td>
                        <td>/contact</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="background: #f0f0f0; padding: 20px; margin-top: 20px; border-radius: 8px;">
            <h3>📚 Steps to Create a Menu:</h3>
            <ol>
                <li>Go to <a href="<?php echo admin_url('nav-menus.php'); ?>"><strong>Appearance > Menus</strong></a></li>
                <li>Click <strong>"Create a new menu"</strong></li>
                <li>Name it "Main Navigation"</li>
                <li>Add menu items from the list above</li>
                <li>Check <strong>"Display location"</strong> and select <strong>"Primary Menu"</strong></li>
                <li>Click <strong>"Save Menu"</strong></li>
            </ol>
        </div>
    </div>
    <?php
}

/**
 * Process hero form data
 */
function techforbs_process_hero_form_data() {
    if (!isset($_POST['option_page']) || $_POST['option_page'] !== 'site-settings') {
        return;
    }

    // Save CTA Primary
    if (isset($_POST['hero_cta_primary'])) {
        update_option('hero_cta_primary', json_encode(array_map('sanitize_text_field', $_POST['hero_cta_primary'])));
    }

    // Save CTA Secondary
    if (isset($_POST['hero_cta_secondary'])) {
        update_option('hero_cta_secondary', json_encode(array_map('sanitize_text_field', $_POST['hero_cta_secondary'])));
    }

    // Save Experience Badge
    if (isset($_POST['hero_exp_badge'])) {
        update_option('hero_exp_badge', json_encode(array_map('sanitize_text_field', $_POST['hero_exp_badge'])));
    }

    // Save Success Badge
    if (isset($_POST['hero_success_badge'])) {
        update_option('hero_success_badge', json_encode(array_map('sanitize_text_field', $_POST['hero_success_badge'])));
    }

    // Save Stats
    if (isset($_POST['hero_stats'])) {
        $stats = array_filter(array_values($_POST['hero_stats']), function($stat) {
            return !empty($stat['value']) && !empty($stat['label']);
        });
        update_option('hero_stats', json_encode($stats));
    }

    // Save Platforms
    if (isset($_POST['hero_platforms'])) {
        $platforms = array_filter(array_values($_POST['hero_platforms']), function($platform) {
            return !empty($platform['name']) && !empty($platform['url']);
        });
        update_option('hero_platforms', json_encode($platforms));
    }
}

/**
 * Set default values on plugin activation
 */
function techforbs_hero_activate_defaults() {
    if (!get_option('hero_title')) {
        update_option('hero_title', 'Perfect IT Solutions For Your Business');
    }
    if (!get_option('hero_subtitle')) {
        update_option('hero_subtitle', 'Delivering exceptional e-commerce and website solutions using Shopify, WooCommerce, and WordPress. From custom development to optimization, we craft scalable, user-friendly platforms that drive growth and success.');
    }
    if (!get_option('hero_badge_text')) {
        update_option('hero_badge_text', 'Shopify, WooCommerce & WordPress');
    }
    if (!get_option('hero_platforms')) {
        update_option('hero_platforms', json_encode([
            ['name' => 'Shopify', 'url' => '#shopify'],
            ['name' => 'WooCommerce', 'url' => '#woocommerce'],
            ['name' => 'WordPress', 'url' => '#wordpress'],
        ]));
    }
    if (!get_option('hero_stats')) {
        update_option('hero_stats', json_encode([
            ['value' => '14+', 'label' => 'Years of Experience'],
            ['value' => '100+', 'label' => 'Projects Completed'],
            ['value' => '12', 'label' => 'Countries Served'],
        ]));
    }
    if (!get_option('hero_cta_primary')) {
        update_option('hero_cta_primary', json_encode([
            'text' => 'Get Free Consultation',
            'link' => '/contact'
        ]));
    }
    if (!get_option('hero_cta_secondary')) {
        update_option('hero_cta_secondary', json_encode([
            'text' => 'Explore Services',
            'link' => '/services'
        ]));
    }
    if (!get_option('hero_exp_badge')) {
        update_option('hero_exp_badge', json_encode([
            'title' => 'Shopify Expert',
            'description' => '14+ years experience'
        ]));
    }
    if (!get_option('hero_success_badge')) {
        update_option('hero_success_badge', json_encode([
            'label' => 'Success Rate',
            'value' => '99.9%'
        ]));
    }
}

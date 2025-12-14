# TechForbs Components Plugin Structure

This folder contains the modular, well-organized TechForbs Components Manager plugin.

## Folder Structure

```
techforbs-components/
├── techforbs-components.php          # Main plugin file (loads all modules)
├── README.md                         # This file
├── includes/
│   ├── registration.php              # Settings & menu registration
│   ├── admin.php                     # Admin utilities & logo upload
│   ├── sections/
│   │   ├── hero.php                 # Hero section admin pages & logic
│   │   └── menus.php                # Menu-specific logic (future use)
│   └── api/
│       └── rest-api.php             # REST API endpoints
└── assets/
    ├── css/
    │   └── admin.css                # Admin panel styles
    ├── js/
    │   ├── admin.js                 # Admin JavaScript
    │   └── hero-admin.js            # Hero section specific JS
    ├── images/                      # Plugin images directory
    └── icons/                       # SVG icons directory
```

## File Descriptions

### Main Plugin File
- **techforbs-components.php** - Entry point. Loads all plugin files, registers assets, handles activation/deactivation.

### Core Files (includes/)
- **registration.php** - Registers all settings and menu locations
- **admin.php** - Admin utilities including logo upload functionality

### Sections (includes/sections/)
- **hero.php** - Complete hero section management:
  - Admin menu setup
  - Hero settings page with form
  - Menu management page
  - Form processing
  - Default values on activation

- **menus.php** - Reserved for menu-specific future enhancements

### API (includes/api/)
- **rest-api.php** - REST API endpoints:
  - `/wp-json/techforbs/v1/hero-settings` - Get hero section data
  - `/wp-json/techforbs/v1/menus` - Get menu data
  - `/wp-json/techforbs/v1/logo` - Get logo information

### Assets (assets/)
- **css/admin.css** - All admin panel styling (no inline CSS)
- **js/admin.js** - Reusable admin JavaScript utilities
- **js/hero-admin.js** - Hero section specific dynamic fields
- **images/** - For any plugin images
- **icons/** - For SVG icons

## How It Works

### 1. **Plugin Initialization**
When you upload and activate the plugin:
- `techforbs-components.php` loads all dependencies
- Menu locations are registered (primary, secondary, mobile)
- Settings are registered with WordPress
- Admin assets are enqueued
- Default values are set on first activation

### 2. **Admin Interface**
Three-level admin structure:
- **Main Dashboard** (TechForbs) - Overview with quick links
- **Hero Settings** (TechForbs > Hero Settings) - Configure hero section
- **Menu Management** (TechForbs > Menu Management) - View and manage menus

### 3. **REST API**
All data is immediately available via REST API:
```
GET /wp-json/techforbs/v1/hero-settings
GET /wp-json/techforbs/v1/menus
GET /wp-json/techforbs/v1/logo
```

### 4. **Logo Management**
Logo can be uploaded in two ways:
1. **Via Settings > Logo** (recommended) - Direct upload in general settings
2. **Via Theme Customize > Site Identity** - Standard WordPress method

Both methods sync to the same option: `site_logo`

API returns logo info at `/wp-json/techforbs/v1/logo`

## Constants

These are defined in `techforbs-components.php`:

```php
TECHFORBS_PLUGIN_DIR    // Full path to plugin directory
TECHFORBS_PLUGIN_URL    // Full URL to plugin directory
TECHFORBS_PLUGIN_VERSION // Current plugin version (1.0.0)
```

## Hooks & Actions

### Activation/Deactivation
```php
do_action('techforbs_activate');    // Runs on plugin activation
do_action('techforbs_deactivate');  // Runs on plugin deactivation
```

Specific sections hook in:
- `techforbs_hero_activate_defaults()` - Hero activation defaults

## Adding New Sections

To add a new component (e.g., Testimonials section):

### 1. Create Section File
Create `includes/sections/testimonials.php`

### 2. Create Admin Pages
```php
add_action('admin_menu', 'techforbs_add_testimonials_menu');

function techforbs_add_testimonials_menu() {
    add_submenu_page(
        'techforbs-components',
        'Testimonials',
        'Testimonials',
        'manage_options',
        'testimonials-settings',
        'techforbs_render_testimonials_page'
    );
}
```

### 3. Register Settings
```php
add_action('init', 'techforbs_register_testimonials_settings');

function techforbs_register_testimonials_settings() {
    register_setting('site-settings', 'testimonials_content', [
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'show_in_rest' => true,
    ]);
}
```

### 4. Create REST Endpoint
In `includes/api/rest-api.php`, add:
```php
register_rest_route('techforbs/v1', '/testimonials', [
    'methods' => 'GET',
    'callback' => 'techforbs_get_testimonials',
    'permission_callback' => '__return_true',
]);

function techforbs_get_testimonials() {
    return json_decode(get_option('testimonials_content', '[]'), true);
}
```

### 5. Load in Main File
In `techforbs-components.php`, add:
```php
require_once TECHFORBS_PLUGIN_DIR . 'includes/sections/testimonials.php';
```

## Asset Usage

### Adding CSS
```php
wp_enqueue_style('my-style', TECHFORBS_PLUGIN_URL . 'assets/css/my-style.css');
```

### Adding JavaScript
```php
wp_enqueue_script('my-script', TECHFORBS_PLUGIN_URL . 'assets/js/my-script.js');
```

### Adding Images
```php
<img src="<?php echo TECHFORBS_PLUGIN_URL . 'assets/images/image.png'; ?>" alt="">
```

## No Inline CSS/JS

This plugin follows best practices by NOT including inline CSS or JavaScript.  
All styles are in `assets/css/` and scripts in `assets/js/` for:
- Better performance
- Easier caching
- Maintainability
- CSP compliance

## Next.js Frontend Integration

See the main documentation for how to fetch data from these REST endpoints in Next.js components.

## Development Notes

- **No ACF Dependency** - Uses native WordPress functions only
- **Modular Design** - Easy to extend with new sections
- **REST API Ready** - All data available via REST for headless use
- **Admin-Only** - Only accessible with `manage_options` capability
- **Sanitized** - All inputs properly sanitized for security


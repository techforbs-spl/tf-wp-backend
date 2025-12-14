// TechForbs Admin JavaScript

jQuery(function($) {
    'use strict';

    // Dynamic Repeater Fields Manager
    let statsIndex = parseInt($('.stat-row').length);
    let platformsIndex = parseInt($('.platform-row').length);

    /**
     * Add new statistic
     */
    $('#add-stat').on('click', function(e) {
        e.preventDefault();
        const container = $('#stats-container');
        const html = `
            <div class="stat-row">
                <input 
                    type="text" 
                    name="hero_stats[${statsIndex}][value]" 
                    placeholder="e.g., 14+" 
                    class="regular-text" 
                />
                <input 
                    type="text" 
                    name="hero_stats[${statsIndex}][label]" 
                    placeholder="e.g., Years of Experience" 
                    class="regular-text" 
                />
                <button type="button" class="button button-danger remove-stat">×</button>
            </div>
        `;
        container.append(html);
        statsIndex++;
    });

    /**
     * Add new platform
     */
    $('#add-platform').on('click', function(e) {
        e.preventDefault();
        const container = $('#platforms-container');
        const html = `
            <div class="platform-row">
                <input 
                    type="text" 
                    name="hero_platforms[${platformsIndex}][name]" 
                    placeholder="e.g., Shopify" 
                    class="regular-text" 
                />
                <input 
                    type="text" 
                    name="hero_platforms[${platformsIndex}][url]" 
                    placeholder="e.g., #shopify or /services" 
                    class="regular-text" 
                />
                <button type="button" class="button button-danger remove-platform">×</button>
            </div>
        `;
        container.append(html);
        platformsIndex++;
    });

    /**
     * Remove stat row
     */
    $(document).on('click', '.remove-stat', function(e) {
        e.preventDefault();
        $(this).closest('.stat-row').remove();
    });

    /**
     * Remove platform row
     */
    $(document).on('click', '.remove-platform', function(e) {
        e.preventDefault();
        $(this).closest('.platform-row').remove();
    });

    /**
     * Show success message on form submit
     */
    $('form[action*="options.php"]').on('submit', function() {
        // WordPress handles this with its own mechanism
        // This is just a placeholder for future enhancements
    });
});

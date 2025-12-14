// JavaScript for hero admin page - handles dynamic fields
// This file is loaded from hero.php admin page

document.addEventListener('DOMContentLoaded', function() {
    let statsIndex = document.querySelectorAll('.stat-row').length;
    let platformsIndex = document.querySelectorAll('.platform-row').length;

    // Add Statistic
    document.getElementById('add-stat')?.addEventListener('click', function(e) {
        e.preventDefault();
        const container = document.getElementById('stats-container');
        const row = document.createElement('div');
        row.className = 'stat-row';
        row.style.cssText = 'margin-bottom: 10px; padding: 10px; background: white; border: 1px solid #ddd; border-radius: 3px;';
        row.innerHTML = `
            <input type="text" name="hero_stats[${statsIndex}][value]" placeholder="e.g., 14+" class="regular-text" style="width: 30%; margin-right: 2%;" />
            <input type="text" name="hero_stats[${statsIndex}][label]" placeholder="e.g., Years of Experience" class="regular-text" style="width: 60%; margin-right: 2%;" />
            <button type="button" class="button button-danger remove-stat">×</button>
        `;
        container.appendChild(row);
        statsIndex++;
        attachRemoveListeners();
    });

    // Add Platform
    document.getElementById('add-platform')?.addEventListener('click', function(e) {
        e.preventDefault();
        const container = document.getElementById('platforms-container');
        const row = document.createElement('div');
        row.className = 'platform-row';
        row.style.cssText = 'margin-bottom: 10px; padding: 10px; background: white; border: 1px solid #ddd; border-radius: 3px;';
        row.innerHTML = `
            <input type="text" name="hero_platforms[${platformsIndex}][name]" placeholder="e.g., Shopify" class="regular-text" style="width: 30%; margin-right: 2%;" />
            <input type="text" name="hero_platforms[${platformsIndex}][url]" placeholder="e.g., #shopify or /services" class="regular-text" style="width: 60%; margin-right: 2%;" />
            <button type="button" class="button button-danger remove-platform">×</button>
        `;
        container.appendChild(row);
        platformsIndex++;
        attachRemoveListeners();
    });

    function attachRemoveListeners() {
        document.querySelectorAll('.remove-stat').forEach(btn => {
            btn.onclick = function(e) {
                e.preventDefault();
                this.parentElement.remove();
            };
        });

        document.querySelectorAll('.remove-platform').forEach(btn => {
            btn.onclick = function(e) {
                e.preventDefault();
                this.parentElement.remove();
            };
        });
    }

    attachRemoveListeners();
});

<?php
/**
 * Homepage Sections - Renderable PHP Components
 * 
 * Provides PHP functions to render all homepage sections on WordPress pages.
 * Can be used via shortcodes like [techforbs_services], [techforbs_faq], etc.
 * Or called directly in page templates via: techforbs_render_services_section()
 */

if (!defined('ABSPATH')) {
    exit;
}

// Register all section shortcodes
add_action('init', 'techforbs_register_section_shortcodes');

/**
 * Register shortcodes for all sections
 */
function techforbs_register_section_shortcodes() {
    add_shortcode('techforbs_services', 'techforbs_render_services_section');
    add_shortcode('techforbs_why_choose', 'techforbs_render_why_choose_section');
    add_shortcode('techforbs_trusted_by', 'techforbs_render_trusted_by_section');
    add_shortcode('techforbs_projects', 'techforbs_render_projects_section');
    add_shortcode('techforbs_testimonials', 'techforbs_render_testimonials_section');
    add_shortcode('techforbs_faq', 'techforbs_render_faq_section');
    add_shortcode('techforbs_footer', 'techforbs_render_footer_section');
    add_shortcode('techforbs_page_sections', 'techforbs_render_page_sections');
}

/**
 * Render Services Section (6 service cards in 3-column grid)
 * Usage: [techforbs_services] or techforbs_render_services_section(['settings' => $data])
 */
function techforbs_render_services_section($atts = []) {
    // Allow passing settings programmatically
    $settings = isset($atts['settings']) && is_array($atts['settings']) ? $atts['settings'] : null;
    ob_start();
    ?>
    <section id="services" class="relative py-20 sm:py-24 lg:py-28 bg-gradient-to-b from-[#070b14] to-[#0a0e27] text-white overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-20 left-10 h-64 w-64 bg-blue-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 h-72 w-72 bg-cyan-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-12 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold mb-4 bg-gradient-to-r from-cyan-400 via-green-400 to-purple-400 bg-clip-text text-transparent">
                    <?php echo esc_html($settings['title'] ?? 'Our Services'); ?>
                </h2>
                <p class="text-white/70 text-lg max-w-2xl mx-auto">
                    <?php echo esc_html($settings['subtitle'] ?? 'Comprehensive solutions for your e-commerce and web development needs'); ?>
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                // Use provided cards or fallback to defaults
                $services = !empty($settings['cards']) ? $settings['cards'] : [
                    [
                        'title' => 'IT Consultation',
                        'description' => 'Expert strategic recommendations to optimize your technology infrastructure and drive business success.',
                        'color' => '#00D4FF',
                        'icon_class' => '🎯'
                    ],
                    [
                        'title' => 'Ecommerce Solutions',
                        'description' => 'We leverage WooCommerce and Shopify expertise to create robust, user-friendly online stores with seamless selling.',
                        'color' => '#8ef8c3',
                        'icon_class' => '🛍️'
                    ],
                    [
                        'title' => 'Website Development',
                        'description' => 'Tailor-made websites that captivate users, enhance online presence, and drive business growth.',
                        'color' => '#a7b5ff',
                        'icon_class' => '💻'
                    ],
                    [
                        'title' => 'UI/UX Design',
                        'description' => 'Exceptional user experiences combining aesthetics and user-centric digital interfaces.',
                        'color' => '#ff6b9d',
                        'icon_class' => '🎨'
                    ],
                    [
                        'title' => 'Website Optimization',
                        'description' => 'Maximize your website\'s potential with improved speed, usability, and online presence.',
                        'color' => '#ffd700',
                        'icon_class' => '⚡'
                    ],
                    [
                        'title' => 'Digital Marketing',
                        'description' => 'Strategic marketing solutions to increase visibility, drive traffic, and boost conversions.',
                        'color' => '#ff8c42',
                        'icon_class' => '📈'
                    ],
                ];

                foreach ($services as $service): ?>
                    <div class="group rounded-2xl border border-white/10 bg-white/5 backdrop-blur-sm p-8 hover:border-white/30 hover:bg-white/10 transition-all duration-300">
                        <div class="mb-4 text-4xl" style="color: <?php echo esc_attr($service['color']); ?>">
                            <?php echo esc_html($service['icon_class']); ?>
                        </div>
                        <h3 class="text-xl font-bold mb-3"><?php echo esc_html($service['title']); ?></h3>
                        <p class="text-white/70 text-sm leading-relaxed mb-4"><?php echo esc_html($service['description']); ?></p>
                        <a href="/services" class="inline-flex items-center gap-2 text-sm font-semibold transition-all hover:gap-3" style="color: <?php echo esc_attr($service['color']); ?>">
                            Learn More →
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}

/**
 * Render Why Choose Us Section (6 feature cards)
 * Usage: [techforbs_why_choose]
 */
function techforbs_render_why_choose_section($atts = []) {
    ob_start();
    ?>
    <section id="why-choose" class="relative py-20 sm:py-24 lg:py-28 bg-[#0a0e27] text-white overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-32 right-0 h-80 w-80 bg-purple-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-20 h-72 w-72 bg-blue-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-12 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold mb-4">Boost Your Business</h2>
                <p class="text-white/70 text-lg max-w-2xl mx-auto">
                    Here's why industry leaders choose TechForbs for their digital transformation
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                <?php
                $features = [
                    [
                        'title' => 'Proven Track Record',
                        'description' => '14+ years delivering exceptional results across diverse industries.',
                        'icon' => '✓'
                    ],
                    [
                        'title' => 'Tailored Solutions',
                        'description' => 'Custom approaches designed specifically for your unique business needs.',
                        'icon' => '🎯'
                    ],
                    [
                        'title' => 'Advanced Technologies',
                        'description' => 'We leverage cutting-edge tools and frameworks for optimal performance.',
                        'icon' => '🚀'
                    ],
                    [
                        'title' => '24/7 Support',
                        'description' => 'Round-the-clock assistance to keep your digital assets running smoothly.',
                        'icon' => '💬'
                    ],
                    [
                        'title' => 'Quality Assured',
                        'description' => '99.9% reliability backed by rigorous testing and best practices.',
                        'icon' => '✅'
                    ],
                    [
                        'title' => 'Dedicated Team',
                        'description' => 'Expert professionals committed to your success from start to finish.',
                        'icon' => '👥'
                    ],
                ];

                foreach ($features as $feature): ?>
                    <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-sm p-8 hover:border-cyan-400/30 hover:bg-cyan-400/5 transition-all duration-300">
                        <div class="text-3xl mb-4"><?php echo esc_html($feature['icon']); ?></div>
                        <h3 class="text-lg font-bold mb-3"><?php echo esc_html($feature['title']); ?></h3>
                        <p class="text-white/70 text-sm leading-relaxed"><?php echo esc_html($feature['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="flex justify-center">
                <a href="/contact" class="inline-block cta-gradient rounded-full px-8 py-3.5 font-semibold text-white hover:shadow-lg hover:shadow-cyan-500/20 transition-all">
                    Start Your Project Today
                </a>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}

/**
 * Render Trusted By Section (client logos + stats)
 * Usage: [techforbs_trusted_by]
 */
function techforbs_render_trusted_by_section($atts = []) {
    ob_start();
    ?>
    <section id="trusted-by" class="relative py-20 sm:py-24 lg:py-28 bg-gradient-to-b from-[#0a0e27] to-[#070b14] text-white overflow-hidden">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-12">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold mb-4">Trusted By Leading Businesses</h2>
                <p class="text-white/70 text-lg">Join 100+ companies that have transformed their digital presence with TechForbs</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-16">
                <?php
                $clients = [
                    ['initials' => 'CAR', 'name' => 'CarTech Solutions'],
                    ['initials' => 'WM', 'name' => 'WebMasters Inc'],
                    ['initials' => 'PK', 'name' => 'PackForce Global'],
                    ['initials' => 'DM', 'name' => 'Digital Motion'],
                    ['initials' => 'ES', 'name' => 'EcoStore'],
                    ['initials' => 'BW', 'name' => 'BuildWorks'],
                    ['initials' => 'CS', 'name' => 'CloudSync'],
                    ['initials' => 'FT', 'name' => 'FutureTrack'],
                    ['initials' => 'NK', 'name' => 'NexusKit'],
                    ['initials' => 'VE', 'name' => 'Velocity'],
                ];

                foreach ($clients as $client): ?>
                    <div class="flex items-center justify-center rounded-2xl border border-white/10 bg-white/5 backdrop-blur-sm p-6 hover:border-cyan-400/30 hover:bg-cyan-400/5 transition-all duration-300">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-gradient-to-br from-cyan-400 to-purple-400 text-white font-bold text-sm mb-2">
                                <?php echo esc_html($client['initials']); ?>
                            </div>
                            <p class="text-xs text-white/70"><?php echo esc_html($client['name']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php
                $stats = [
                    ['value' => '14+', 'label' => 'Years Experience'],
                    ['value' => '100+', 'label' => 'Projects Completed'],
                    ['value' => '24', 'label' => 'Happy Clients'],
                ];

                foreach ($stats as $stat): ?>
                    <div class="rounded-2xl bg-gradient-to-br from-cyan-500/10 to-purple-500/10 border border-white/10 p-8 text-center">
                        <div class="text-4xl font-bold mb-2"><?php echo esc_html($stat['value']); ?></div>
                        <p class="text-white/70"><?php echo esc_html($stat['label']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}

/**
 * Render Projects Section (4 portfolio projects)
 * Usage: [techforbs_projects]
 */
function techforbs_render_projects_section($atts = []) {
    ob_start();
    ?>
    <section id="projects" class="relative py-20 sm:py-24 lg:py-28 bg-[#0a0e27] text-white overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 left-1/4 h-80 w-80 bg-blue-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-1/4 h-72 w-72 bg-cyan-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-12 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold mb-4">Our Latest Projects</h2>
                <p class="text-white/70 text-lg max-w-2xl mx-auto">
                    Showcase of our recent work across e-commerce, WordPress, and web applications
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <?php
                $projects = [
                    ['title' => 'E-commerce Platform', 'category' => 'WooCommerce', 'image' => '📦'],
                    ['title' => 'Shopify Store Migration', 'category' => 'Shopify', 'image' => '🛒'],
                    ['title' => 'WordPress Website', 'category' => 'WordPress', 'image' => '🌐'],
                    ['title' => 'Mobile App', 'category' => 'Custom Development', 'image' => '📱'],
                ];

                foreach ($projects as $project): ?>
                    <div class="group rounded-2xl overflow-hidden border border-white/10 bg-white/5 backdrop-blur-sm hover:border-cyan-400/30 transition-all duration-300">
                        <div class="relative h-64 bg-gradient-to-br from-cyan-400/20 to-purple-400/20 flex items-center justify-center overflow-hidden">
                            <div class="text-6xl transform group-hover:scale-110 transition-transform duration-300">
                                <?php echo esc_html($project['image']); ?>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-between p-6">
                                <div>
                                    <div class="text-sm text-cyan-400 font-semibold mb-1"><?php echo esc_html($project['category']); ?></div>
                                    <div class="text-white font-bold"><?php echo esc_html($project['title']); ?></div>
                                </div>
                                <a href="/projects" class="text-cyan-400 hover:text-cyan-300">→</a>
                            </div>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-bold mb-2"><?php echo esc_html($project['title']); ?></h3>
                            <p class="text-sm text-white/60"><?php echo esc_html($project['category']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="flex justify-center mt-12">
                <a href="/projects" class="text-cyan-400 hover:text-cyan-300 font-semibold flex items-center gap-2">
                    View All Projects →
                </a>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}

/**
 * Render Testimonials Section (3 client testimonials)
 * Usage: [techforbs_testimonials]
 */
function techforbs_render_testimonials_section($atts = []) {
    ob_start();
    ?>
    <section id="testimonials" class="relative py-20 sm:py-24 lg:py-28 bg-gradient-to-b from-[#070b14] to-[#0a0e27] text-white overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-20 right-10 h-72 w-72 bg-purple-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 left-10 h-80 w-80 bg-cyan-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-12 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold mb-4">What Our Clients Say</h2>
                <p class="text-white/70 text-lg">Real feedback from businesses we've helped transform</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php
                $testimonials = [
                    [
                        'quote' => 'TechForbs transformed our e-commerce platform completely. Their attention to detail and expertise with WooCommerce was exceptional.',
                        'author' => 'Robert Whitehead',
                        'position' => 'CEO, Adeeva',
                        'rating' => 5
                    ],
                    [
                        'quote' => 'The Shopify migration was seamless. The team handled everything professionally and our sales increased by 45% in the first month.',
                        'author' => 'Robert Bajac',
                        'position' => 'Founder, Allmax',
                        'rating' => 5
                    ],
                    [
                        'quote' => 'Outstanding WordPress development and support. They built exactly what we needed for our academy platform.',
                        'author' => 'Dr. James Meschino',
                        'position' => 'Director, GIM Academy',
                        'rating' => 5
                    ],
                ];

                foreach ($testimonials as $testimonial): ?>
                    <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-sm p-8">
                        <div class="flex gap-1 mb-4">
                            <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
                                <span class="text-yellow-400">★</span>
                            <?php endfor; ?>
                        </div>
                        <p class="text-white/80 mb-6 leading-relaxed italic">"<?php echo esc_html($testimonial['quote']); ?>"</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-cyan-400 to-purple-400"></div>
                            <div>
                                <p class="font-semibold text-sm"><?php echo esc_html($testimonial['author']); ?></p>
                                <p class="text-white/60 text-xs"><?php echo esc_html($testimonial['position']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}

/**
 * Render FAQ Section (6 frequently asked questions)
 * Usage: [techforbs_faq]
 */
function techforbs_render_faq_section($atts = []) {
    ob_start();
    ?>
    <section id="faq" class="relative py-20 sm:py-24 lg:py-28 bg-[#0a0e27] text-white overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-32 left-0 h-80 w-80 bg-blue-500/5 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 h-72 w-72 bg-cyan-500/5 rounded-full blur-3xl"></div>
        </div>

        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-12 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-4xl sm:text-5xl font-bold mb-4">Frequently Asked Questions</h2>
                <p class="text-white/70 text-lg">Find answers to common questions about our services</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php
                $faqs = [
                    ['q' => 'What services do you offer?', 'a' => 'We provide comprehensive e-commerce solutions, website development, UI/UX design, WordPress optimization, digital marketing, and IT consultation tailored to your business needs.'],
                    ['q' => 'How long do projects typically take?', 'a' => 'Project timelines vary based on complexity and scope. We provide detailed estimates during the initial consultation and work within agreed deadlines.'],
                    ['q' => 'Do you handle complex projects?', 'a' => 'Yes, we specialize in complex e-commerce platforms, custom integrations, and enterprise-level solutions. Our team has extensive experience with challenging projects.'],
                    ['q' => 'What is your quality assurance process?', 'a' => 'We maintain a 99.9% reliability standard through rigorous testing, code reviews, and best practices. Every project undergoes comprehensive QA before launch.'],
                    ['q' => 'How do you ensure brand alignment?', 'a' => 'We work closely with you to understand your brand values, aesthetics, and goals. Regular communication ensures your vision is perfectly executed.'],
                    ['q' => 'What kind of ongoing support do you provide?', 'a' => 'We offer 24/7 support packages including maintenance, updates, monitoring, and optimization to keep your digital assets running smoothly.'],
                ];

                foreach ($faqs as $faq): ?>
                    <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-sm p-6 hover:border-white/20 transition-all">
                        <h3 class="font-bold text-white mb-3"><?php echo esc_html($faq['q']); ?></h3>
                        <p class="text-white/70 text-sm leading-relaxed"><?php echo esc_html($faq['a']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-12 text-center">
                <p class="text-white/70 mb-4">Still have questions?</p>
                <a href="/contact" class="inline-block cta-gradient rounded-full px-8 py-3.5 font-semibold text-white hover:shadow-lg hover:shadow-cyan-500/20 transition-all">
                    Get in Touch
                </a>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}

/**
 * Render Footer Section (site footer with links, contact, expertise)
 * Usage: [techforbs_footer]
 */
function techforbs_render_footer_section($atts = []) {
    ob_start();
    ?>
    <footer class="relative bg-gradient-to-b from-[#0a0e27] to-[#050810] text-white pt-20 pb-8 overflow-hidden border-t border-white/10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl -z-10"></div>
        <div class="absolute bottom-0 right-0 w-80 h-80 bg-cyan-500/5 rounded-full blur-3xl -z-10"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-12">
                <!-- Company Info -->
                <div>
                    <h4 class="font-bold mb-4 text-white">TechForbs</h4>
                    <p class="text-white/60 text-sm mb-4">Building exceptional digital solutions for e-commerce and web applications.</p>
                    <p class="text-white/60 text-sm">📍 Global</p>
                    <p class="text-white/60 text-sm">📧 info@techforbs.com</p>
                    <p class="text-white/60 text-sm">📞 +1 (555) 123-4567</p>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="font-bold mb-4 text-white">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="/services" class="text-white/60 hover:text-cyan-400 transition text-sm">Ecommerce</a></li>
                        <li><a href="/services" class="text-white/60 hover:text-cyan-400 transition text-sm">WordPress</a></li>
                        <li><a href="/services" class="text-white/60 hover:text-cyan-400 transition text-sm">Shopify</a></li>
                        <li><a href="/services" class="text-white/60 hover:text-cyan-400 transition text-sm">Web Development</a></li>
                        <li><a href="/services" class="text-white/60 hover:text-cyan-400 transition text-sm">UI/UX Design</a></li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold mb-4 text-white">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="/about" class="text-white/60 hover:text-cyan-400 transition text-sm">About Us</a></li>
                        <li><a href="/projects" class="text-white/60 hover:text-cyan-400 transition text-sm">Portfolio</a></li>
                        <li><a href="/blog" class="text-white/60 hover:text-cyan-400 transition text-sm">Blog</a></li>
                        <li><a href="/contact" class="text-white/60 hover:text-cyan-400 transition text-sm">Contact</a></li>
                    </ul>
                </div>

                <!-- Expertise -->
                <div>
                    <h4 class="font-bold mb-4 text-white">Expertise</h4>
                    <div class="flex flex-wrap gap-2">
                        <?php
                        $skills = ['WordPress', 'Shopify', 'WooCommerce', 'React', 'Next.js', 'PHP', 'JavaScript', 'UI/UX', 'SEO'];
                        foreach ($skills as $skill): ?>
                            <span class="bg-white/10 text-white/70 text-xs px-3 py-1.5 rounded-full hover:bg-cyan-400/20 hover:text-cyan-400 transition">
                                <?php echo esc_html($skill); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- CTA -->
                <div>
                    <h4 class="font-bold mb-4 text-white">Get Started</h4>
                    <p class="text-white/60 text-sm mb-4">Ready to transform your digital presence?</p>
                    <a href="/contact" class="inline-block cta-gradient rounded-full px-6 py-2.5 font-semibold text-white text-sm hover:shadow-lg hover:shadow-cyan-500/20 transition-all">
                        Contact Us
                    </a>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-white/10 pt-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-white/60">
                    <p>&copy; 2024 TechForbs. All rights reserved.</p>
                    <div class="flex gap-6 md:justify-end">
                        <a href="#" class="hover:text-cyan-400 transition">Privacy Policy</a>
                        <a href="#" class="hover:text-cyan-400 transition">Terms of Service</a>
                        <a href="#" class="hover:text-cyan-400 transition">Legal</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <?php
    return ob_get_clean();
}

/**
 * Shortcode: Render all saved page sections in order
 * Usage: [techforbs_page_sections]
 * 
 * This reads the `techforbs_sections` post meta for the current page/post
 * and renders each section by calling the appropriate renderer.
 */
function techforbs_render_page_sections($atts = []) {
    global $post;
    if (!$post || !($post instanceof WP_Post)) {
        return '';
    }

    $raw = get_post_meta($post->ID, 'techforbs_sections', true);
    $sections = [];
    if ($raw) {
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            $sections = is_array($decoded) ? $decoded : [];
        } elseif (is_array($raw)) {
            $sections = $raw;
        }
    }

    if (empty($sections)) {
        return '';
    }

    ob_start();
    foreach ($sections as $section) {
        $type = sanitize_text_field($section['type'] ?? '');
        $settings = isset($section['settings']) && is_array($section['settings']) ? $section['settings'] : [];

        // Call the appropriate renderer based on type
        switch ($type) {
            case 'services':
                echo techforbs_render_services_section(['settings' => $settings]);
                break;
            case 'projects':
                echo techforbs_render_projects_section(['settings' => $settings]);
                break;
            case 'faq':
                echo techforbs_render_faq_section(['settings' => $settings]);
                break;
            case 'testimonials':
                echo techforbs_render_testimonials_section(['settings' => $settings]);
                break;
            case 'trusted_by':
                echo techforbs_render_trusted_by_section(['settings' => $settings]);
                break;
            case 'why_choose':
                echo techforbs_render_why_choose_section(['settings' => $settings]);
                break;
            default:
                // Unknown type — skip or allow custom rendering
                break;
        }
    }
    return ob_get_clean();
}

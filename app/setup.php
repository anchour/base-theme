<?php

namespace App;

use Roots\Sage\Container;
use Roots\Sage\Assets\JsonManifest;
use Roots\Sage\Template\Blade;
use Roots\Sage\Template\BladeProvider;

/**
 * Theme assets
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('sage/main.css', asset_path('styles/main.css'), false, null);
    wp_enqueue_script('sage/main.js', asset_path('scripts/main.js'), ['jquery'], null, true);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}, 100);

/**
 * Theme setup
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from Soil when plugin is activated
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil', [
        'clean-up',
        'disable-asset-versioning',
        'disable-trackbacks',
        'nav-walker',
        'nice-search',
    ]);

    add_theme_support('theme-flex-modules', [
        'one-column-text',
        'two-column-text',
        'multi-column-text',
        'text-image-split',
        'team-members',
        'accordion',
    ]);

    /**
     * Enable plugins to manage the document title
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Register navigation menus
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage')
    ]);

    /**
     * Enable post thumbnails
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable HTML5 markup support
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    /**
     * Enable selective refresh for widgets in customizer
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Use main stylesheet for visual editor
     * @see resources/assets/styles/layouts/_tinymce.scss
     */
    add_editor_style(asset_path('styles/main.css'));
}, 20);

/**
 * Register sidebars
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ];
    register_sidebar([
        'name'          => __('Primary', 'sage'),
        'id'            => 'sidebar-primary'
    ] + $config);
    register_sidebar([
        'name'          => __('Footer', 'sage'),
        'id'            => 'sidebar-footer'
    ] + $config);
});

/**
 * Updates the `$post` variable on each iteration of the loop.
 * Note: updated value is only available for subsequently loaded views, such as partials
 */
add_action('the_post', function ($post) {
    sage('blade')->share('post', $post);
});

/**
 * Setup Sage options
 */
add_action('after_setup_theme', function () {
    /**
     * Add JsonManifest to Sage container
     */
    sage()->singleton('sage.assets', function () {
        return new JsonManifest(config('assets.manifest'), config('assets.uri'));
    });

    /**
     * Add Blade to Sage container
     */
    sage()->singleton('sage.blade', function (Container $app) {
        $cachePath = config('view.compiled');
        if (!file_exists($cachePath)) {
            wp_mkdir_p($cachePath);
        }
        (new BladeProvider($app))->register();
        return new Blade($app['view']);
    });

    /**
     * Create @asset() Blade directive
     */
    sage('blade')->compiler()->directive('asset', function ($asset) {
        return "<?= " . __NAMESPACE__ . "\\asset_path({$asset}); ?>";
    });

    /**
     * Create @assetContents() Blade directive - useful for inlining
     * contents of SVG files in our templates instead of using them
     * as background images.
     */
    sage('blade')->compiler()->directive('assetContents', function ($key) {
        return '<?= ' . __NAMESPACE__ . "\\output_asset_contents({$key}); ?>";
    });

    /**
     * Create @ifRows() Blade directive
     *
     * Used for have_rows() calls from ACF.
     */
    sage('blade')->compiler()->directive('ifRows', function ($name) {
        return "<?php if (have_rows({$name})): ?>";
    });

    /**
     * Create @rows() Blade directive
     *
     * Used for have_rows() calls from ACF.
     */
    sage('blade')->compiler()->directive('rows', function ($name) {
        return "<?php while (have_rows({$name})): the_row(); ?>";
    });

    /**
     * Create @row Blade directive. Simple alias to the_row();
     */
    sage('blade')->compiler()->directive('row', function ($name) {
        return "<?php the_row(); ?>";
    });

    /**
     * Create @row_index() Blade directive
     */
    sage('blade')->compiler()->directive('row_index', function () {
        return "<?= get_row_index(); ?>";
    });

    /**
     * Create @endrows Blade directive
     *
     * Ends `while` loop from @rows directive.
     */
    sage('blade')->compiler()->directive('endrows', function () {
        return "<?php endwhile; ?>";
    });

    /**
     * Create @field Blade directive
     */
    sage('blade')->compiler()->directive('field', function ($expression) {
        list($name, $type, $default) = explode(', ', $expression);

        $args = $name;

        if ($type) {
            $args .= ", $type";
        }

        $default ??= '';

        return "<?= get_field({$args}) ?: $default ?>";
    });

    /**
     * Create @subfield Blade directive
     */
    sage('blade')->compiler()->directive('subfield', function ($expression) {
        list($key, $default) = explode(', ', $expression);

        return "<?= get_sub_field({$key}) ?: $default ?>";
    });
});

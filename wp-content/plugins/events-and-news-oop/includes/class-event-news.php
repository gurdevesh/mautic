<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link              https://snotrainfotech.com/
 * @since             1.0.0
 *
 * @package           EventNews
 * @subpackage        EventNews/includes
 */
class Event_News {

    public function __construct() {
        // Do nothing.
    }

    /**
     * Include required classes and set the necessary hooks
     */
    public function initialize(){

        $this->load_dependencies();
        $this->define_public_hooks();
        $this->define_shortcodes();

    }

    /**
     * Load the required dependencies for this plugin.
     */
    private function load_dependencies() {
        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once EVENTNEWS_PLUGIN_DIR . 'includes/class-event-news-public.php';
        require_once EVENTNEWS_PLUGIN_DIR . 'includes/class-shortcode.php';

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     */
    private function define_public_hooks() {

        $plugin_public = new Event_News_Public();

        add_action( 'wp_enqueue_scripts', array( $plugin_public, 'enqueue_public_styles') );
        add_action( 'wp_enqueue_scripts', array( $plugin_public, 'enqueue_public_scripts') );

        add_action('init', array( $plugin_public, 'create_post_type') );
        add_action('init', array( $plugin_public, 'create_taxonomy') );
        add_action('init', array( $plugin_public, 'add_rewrite_rules') );

        add_action( 'pre_get_posts', array($plugin_public, 'pre_get_posts') );

        add_filter('template_include', array( $plugin_public, 'template_for_custom_post_type'), 999 );
        add_filter('theme_page_templates', array( $plugin_public, 'name_the_page_template'), 10, 4 );
        add_filter('page_template', array( $plugin_public, 'page_template_from_plugin') );
        add_filter('the_excerpt', array( $plugin_public, 'excerpt_with_read_more') );
        add_filter('excerpt_more', array( $plugin_public, 'modify_read_more') );

    }

    /**
     * Register all the shortcodes
     */
    private function define_shortcodes(){

        $shortcode = new Shortcode();

        add_shortcode('si_breadcrumbs', array( $shortcode, 'show_breadcrumbs') );
        add_shortcode('si_archive_filter', array( $shortcode, 'filter_archive_year_month') );
        add_shortcode('si_archive_filter_mobile', array( $shortcode, 'calendar_for_mobile') );

    }

}

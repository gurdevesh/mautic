<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link              https://snotrainfotech.com/
 * @since             1.0.0
 *
 * @package           EventNews
 * @subpackage        EventNews/includes
 */

class Event_News_Public {

    public function __construct() {
        // Do Nothing.
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     * Callback function on action 'wp_enqueue_scripts'
     **/
    public function enqueue_public_styles() {

        wp_enqueue_style( PLUGIN_NAME.'_style', EVENTNEWS_PLUGIN_URL . 'public/css/custom-public.css', array());
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     * Callback function on action 'wp_enqueue_scripts'
     **/
    public function enqueue_public_scripts() {

        wp_enqueue_script( PLUGIN_NAME.'_script', EVENTNEWS_PLUGIN_URL . 'public/js/custom-public.js',
            array( 'jquery' ),false, true );
    }


    /**
     * Create custom post type for News and Event
     * Callback function on action 'init'
     */
    function create_post_type(){

        register_post_type('news',
            array(
                'labels' => array(
                    'name' => __('News'),
                    'singular_name' => __('News'),
                    'menu_name' => __('News'),
                    'all_items' => __('All News'),
                    'view_item' => __('View News'),
                    'add_new_item' => __('Add New News'),
                    'add_new' => __('Add New'),
                    'edit_item' => __('Edit News'),
                    'update_item' => __('Update News'),
                    'search_items' => __('Search News'),
                    'not_found' => __('Not Found'),
                    'not_found_in_trash' => __('Not found in Trash'),
                ),
                'public' => true,
                'has_archive' => true,
                'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
                'rewrite' => array('slug' => 'news'), // custom slug
                'taxonomies' => array('')
            )
        );

        register_post_type('events',
            array(
                'labels' => array(
                    'name' => __('Events'),
                    'singular_name' => __('Events'),
                    'menu_name' => __('Events'),
                    'all_items' => __('All Events'),
                    'view_item' => __('View Events'),
                    'add_new_item' => __('Add New Events'),
                    'add_new' => __('Add New'),
                    'edit_item' => __('Edit Events'),
                    'update_item' => __('Update Events'),
                    'search_items' => __('Search Events'),
                    'not_found' => __('Not Found'),
                    'not_found_in_trash' => __('Not found in Trash'),
                ),
                'public' => true,
                'has_archive' => true,
                'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
                'rewrite' => array('slug' => 'si-events', 'with_front' => false), // custom slug
                'taxonomies' => array('')
            )
        );
    }

    /**
     * Create taxonomy for News and Event
     * Callback function on action 'init'
     */
    function create_taxonomy(){

        $labels = array(
            'name' => __('News Category', 'twentytwenty'),
            'singular_name' => __('News Category', 'twentytwenty'),
            'search_items' => __('Search Category'),
            'all_items' => __('All News Category'),
            'edit_item' => __('Edit News Category'),
            'update_item' => __('Update News Category'),
            'add_new_item' => __('Add News Category'),
            'new_item_name' => __('New News Category'),
            'menu_name' => __('News Category'),
        );

        register_taxonomy('news_type', array('news'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'news_type'),
        ));

        // Create taxonomy for Events
        $labels = array(
            'name' => __('Events Category', 'twentytwenty'),
            'singular_name' => __('Events Category', 'twentytwenty'),
            'search_items' => __('Search Category'),
            'all_items' => __('All Events Category'),
            'edit_item' => __('Edit Events Category'),
            'update_item' => __('Update Events Category'),
            'add_new_item' => __('Add Events Category'),
            'new_item_name' => __('New Events Category'),
            'menu_name' => __('Events Category'),
        );

        register_taxonomy('events_type', array('events'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array('slug' => 'events_type'),
        ));
    }

    /**
     * Register new urls for the functionality
     * Callback function on action 'init'
     */
    function add_rewrite_rules(){

        // Load the wordpress page with respective slug instead of loading custom post type
        add_rewrite_rule('news/?$','index.php?pagename=news', 'top');
        add_rewrite_rule('si-events/?$','index.php?pagename=si-events', 'top');

        // Customize the filter url with year month for custom post type News
        add_rewrite_rule(
            'news/([0-9]{4})/([0-9]{1,2})/?$',
            'index.php?post_type=news&year=$matches[1]&monthnum=$matches[2]',
            'top'
        );

        // Customize the filter url with year month for custom post type Event
        add_rewrite_rule(
            'si-events/([0-9]{4})/([0-9]{1,2})/?$',
            'index.php?post_type=events&year=$matches[1]&monthnum=$matches[2]',
            'top'
        );

        flush_rewrite_rules();
    }

    /**
     * Modify the main wordpress query
     * Use custom field 'date' while doing filter by year month
     * Callback function on filter 'pre_get_posts'
     *
     * @param $query WP_Query
     */
    function pre_get_posts($query){

        //Only alter query if custom variable is set.
        $month_str = $query->get('monthnum');
        $year_str = $query->get('year');
        if( !empty($month_str) ){

            $meta_query = $query->get('meta_query');
            if( empty($meta_query) )
                $meta_query = array();

            $month = new DateTime($year_str.'/'.$month_str.'/01');

            //Get posts with date between the first and last of given month
            if($query->get('post_type') == 'events'){
                $meta_query[] = array(
                    'key' => 'date',
                    'value' => array($month->format('Y-m-d').' 00:00:00',$month->format('Y-m-t'). ' 23:59:59'),
                    'compare' => 'BETWEEN',
                );
            }
            else if($query->get('post_type') == 'news'){
                $meta_query[] = array(
                    'key' => 'date',
                    'value' => array($month->format('Ymd'),$month->format('Ymt')),
                    'compare' => 'BETWEEN',
                    'type' => 'date',
                );
            }

            $query->set('meta_query',$meta_query);
            $query->set('year','');
            $query->set('monthnum','');
            $query->set('custom_month',$month_str);
            $query->set('custom_year',$year_str);

        }
    }

    /**
     * Template for single and archive page of News and Events from plugin path
     * Callback function on filter 'template_include'
     *
     * @param $template_path Path where to look for view files
     * @return string $template_path
     */
    function template_for_custom_post_type($template_path)
    {
        if (get_post_type() == 'events') {
            if (is_single()) {
                // checks if the file exists in the theme first,
                // otherwise serve the file from the plugin
                if ($theme_file = locate_template(array('single-events.php'))) {
                    $template_path = $theme_file;
                } else {
                    $template_path = EVENTNEWS_PLUGIN_DIR . 'public/views/single-events.php';
                }
            }
            if (is_archive()) {
                // checks if the file exists in the theme first,
                // otherwise serve the file from the plugin
                if ($theme_file = locate_template(array('archive-events.php'))) {
                    $template_path = $theme_file;
                } else {
                    $template_path = EVENTNEWS_PLUGIN_DIR . 'public/views/archive-events.php';
                }
            }
        }
        if (get_post_type() == 'news') {
            if (is_archive()) {
                // checks if the file exists in the theme first,
                // otherwise serve the file from the plugin
                if ($theme_file = locate_template(array('archive-news.php'))) {
                    $template_path = $theme_file;
                } else {
                    $template_path = EVENTNEWS_PLUGIN_DIR . 'public/views/archive-news.php';
                }
            }
            if (is_single()) {
                // checks if the file exists in the theme first,
                // otherwise serve the file from the plugin
                if ($theme_file = locate_template(array('single-news.php'))) {
                    $template_path = $theme_file;
                } else {
                    $template_path = EVENTNEWS_PLUGIN_DIR . 'public/views/single-news.php';
                }
            }
        }
        return $template_path;
    }

    /**
     * Add "Custom" template to page attribute template section.
     * Callback function on filter 'theme_page_templates'
     *
     * @param $post_templates Array of page templates
     * @param $wp_theme
     * @param $post
     * @param $post_type
     * @return mixed $post_templates Array of page templates
     */
    function name_the_page_template( $post_templates, $wp_theme, $post, $post_type ){

        $post_templates['archive-news.php'] = __('News Archive');
        $post_templates['archive-events.php'] = __('Events Archive');

        return $post_templates;

    }

    /**
     * Provide path to look for view files
     * Callback function on filter 'page_template'
     *
     * @param $page_template Template path
     * @return string $page_template Template path
     */
    function page_template_from_plugin( $page_template ){

        if ( get_page_template_slug() == 'archive-news.php' ) {
            $page_template = EVENTNEWS_PLUGIN_DIR . 'public/views/archive-news.php';
        }
        if ( get_page_template_slug() == 'archive-events.php' ) {

            $page_template = EVENTNEWS_PLUGIN_DIR . 'public/views/archive-events.php';
        }
        return $page_template;

    }

    /**
     * Display Read More link after excerpt
     * Callback function on filter 'the_excerpt'
     *
     * @param $excerpt Post excerpt
     * @return string $excerpt Post excerpt with read more link
     */
    function excerpt_with_read_more($excerpt){

        global $post;
        if(!empty($post->post_excerpt)){
            return '<p>'.$post->post_excerpt.' <a href="'. get_permalink($post->ID) . '">Read More <i class="fas fa-chevron-right"></i></a></p>';
        }
        return $excerpt;

    }

    /**
     * Modify the default Read More link
     * Callback function on filter 'excerpt_more'
     *
     * @param $more
     * @return string Modified Read More link
     */
    function modify_read_more($more){

        global $post;
        return ' <a href="'. get_permalink($post->ID) . '">' . 'Read More <i class="fas fa-chevron-right"></i>' . '</a>';

    }
}
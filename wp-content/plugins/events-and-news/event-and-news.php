<?php
/**
 * Plugin Name:       Events and News
 * Plugin URI:        https://snotrainfotech.com/
 * Description:       Manage events and news
 * Version:           1.0
 * Author:            snotrainfotech
 * Author URI:        https://snotrainfotech.com/
 * License:           GPL2
 */

// Make sure we don't expose any info if called directly
defined('ABSPATH') or die('No script kiddies please!');

// Store plugin directory.
define('EVENT_NEWS_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Create post type for News 
add_action('init', 'si_create_news_post_type');
function si_create_news_post_type()
{
    register_post_type('news',
        array(
            'labels' => array(
                'name' => __('News', 'twentytwenty'),
                'singular_name' => __('News', 'twentytwenty'),
                'menu_name' => __('News', 'twentytwenty'),
                'all_items' => __('All News', 'twentytwenty'),
                'view_item' => __('View News', 'twentytwenty'),
                'add_new_item' => __('Add New News', 'twentytwenty'),
                'add_new' => __('Add New', 'twentytwenty'),
                'edit_item' => __('Edit News', 'twentytwenty'),
                'update_item' => __('Update News', 'twentytwenty'),
                'search_items' => __('Search News', 'twentytwenty'),
                'not_found' => __('Not Found', 'twentytwenty'),
                'not_found_in_trash' => __('Not found in Trash', 'twentytwenty'),
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'news'), // my custom slug
            'taxonomies' => array('')
        )
    );
}

// Create taxonomy for News
add_action('init', 'si_create_news_taxonomy', 0);
function si_create_news_taxonomy()
{

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
}

// Create post type for Events 
add_action('init', 'si_create_events_post_type');
function si_create_events_post_type()
{
    register_post_type('events',
        array(
            'labels' => array(
                'name' => __('Events', 'twentytwenty'),
                'singular_name' => __('Events', 'twentytwenty'),
                'menu_name' => __('Events', 'twentytwenty'),
                'all_items' => __('All Events', 'twentytwenty'),
                'view_item' => __('View Events', 'twentytwenty'),
                'add_new_item' => __('Add New Events', 'twentytwenty'),
                'add_new' => __('Add New', 'twentytwenty'),
                'edit_item' => __('Edit Events', 'twentytwenty'),
                'update_item' => __('Update Events', 'twentytwenty'),
                'search_items' => __('Search Events', 'twentytwenty'),
                'not_found' => __('Not Found', 'twentytwenty'),
                'not_found_in_trash' => __('Not found in Trash', 'twentytwenty'),
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
            'rewrite' => array('slug' => 'events', 'with_front' => false), // my custom slug
            'taxonomies' => array('')
        )
    );
}

// Create taxonomy for Events
add_action('init', 'si_create_events_taxonomy', 0);
function si_create_events_taxonomy()
{
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

// Template for single and archive page of News and Events 
add_filter('template_include', 'si_include_template_function');
function si_include_template_function($template_path)
{
    if (get_post_type() == 'events') {
        if (is_single()) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ($theme_file = locate_template(array('single-events.php'))) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path(__FILE__) . '/single-events.php';
            }
        }
        if (is_archive()) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ($theme_file = locate_template(array('archive-events.php'))) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path(__FILE__) . '/archive-events.php';
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
                $template_path = plugin_dir_path(__FILE__) . '/archive-news.php';
            }
        }
        if (is_single()) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ($theme_file = locate_template(array('single-news.php'))) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path(__FILE__) . '/single-news.php';
            }
        }
    }
    return $template_path;
}

function wpbeginner_numeric_posts_nav()
{
    if (is_singular())
        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */
    if ($wp_query->max_num_pages <= 1)
        return;
    $paged = get_query_var('paged') ? absint(get_query_var('paged')) : 1;
    $max = intval($wp_query->max_num_pages);

    /** Add current page to the array */
    if ($paged >= 1)
        $links[] = $paged;

    /** Add the pages around the current page to the array */
    if ($paged >= 3) {
        $links[] = $paged - 1;
        $links[] = $paged - 2;
    }

    if (($paged + 2) <= $max) {
        $links[] = $paged + 2;
        $links[] = $paged + 1;
    }

    echo '<div class="navigation"><ul>' . "\n";

    /** Previous Post Link */
    if (get_previous_posts_link())
        printf('<li>%s</li>' . "\n", get_previous_posts_link());

    /** Link to first page, plus ellipses if necessary */
    if (!in_array(1, $links)) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link(1)), '1');

        if (!in_array(2, $links))
            echo '<li>…</li>';
    }

    /** Link to current page, plus 2 pages in either direction if necessary */
    sort($links);
    foreach ((array)$links as $link) {
        $class = $paged == $link ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($link)), $link);
    }

    /** Link to last page, plus ellipses if necessary */
    if (!in_array($max, $links)) {
        if (!in_array($max - 1, $links))
            echo '<li>…</li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf('<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url(get_pagenum_link($max)), $max);
    }

    /** Next Post Link */
    if (get_next_posts_link())
        printf('<li>%s</li>' . "\n", get_next_posts_link());

    echo '</ul></div>' . "\n";

}


function new_excerpt_more($excerpt ) {
    global $post;
    if(!empty($post->post_excerpt)){
        return '<p>'.$post->post_excerpt.' <a href="'. get_permalink($post->ID) . '">Read More</a></p>';
    }
    return $excerpt;
}
add_filter('the_excerpt', 'new_excerpt_more', 999);


function si_new_excerpt_more($more) {
    global $post;
    return ' <a href="'. get_permalink($post->ID) . '">' . 'Read More' . '</a>';
}
add_filter('excerpt_more', 'si_new_excerpt_more');

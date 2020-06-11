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
            'supports' => array('title', 'editor', 'excerpt', 'thumbnail'),
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
echo 'pagination';
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

function filter_archive_year_month($type){
    global $wpdb, $wp_locale;

    $sql_where = $wpdb->prepare( "WHERE p.post_type = %s AND p.post_status = 'publish' AND pm.meta_key = 'date'", $type );

    $query = "SELECT YEAR(pm.meta_value) AS year, MONTH(pm.meta_value) AS month from $wpdb->posts p left join $wpdb->postmeta pm on p.ID = pm.post_id $sql_where GROUP BY year,month ORDER BY YEAR(pm.meta_value) DESC";

    $results = $wpdb->get_results( $query );

    $year_array = array();
    foreach ($results as $each){
        $year_array[$each->year][] = $each->month;
    }

    $suffix = '?post_type='.$type;
    foreach ($year_array as $year => $month){
        $url = get_year_link( $year ).$suffix;
        ?>
        <ul>
            <lh><a href="<?php echo $url ?>"><?php echo $year ?></a></lh>
            <?php
            $month = asort($month);
            foreach($month as $each) {
                $url = get_month_link( $year, $each ).$suffix;
                ?>
                <li> <a href="<?php echo $url; ?>"><?php echo $wp_locale->get_month( $each ); ?></a> </li>
            <?php } ?>
        </ul>
    <?php }
}

add_action('init', function () {
    add_rewrite_rule('news/?$','index.php?pagename=news', 'top');
    add_rewrite_rule('events/?$','index.php?pagename=events', 'top');
    flush_rewrite_rules();
}, 1000);

//Load template from specific page
add_filter( 'page_template', 'wpa3396_page_template' );
function wpa3396_page_template( $page_template ){
    if ( get_page_template_slug() == 'archive-news.php' ) {
        $page_template = dirname( __FILE__ ) . '/archive-news.php';
    }
    if ( get_page_template_slug() == 'archive-events.php' ) {
        $page_template = dirname( __FILE__ ) . '/archive-events.php';
    }
    return $page_template;
}

/**
 * Add "Custom" template to page attirbute template section.
 */
add_filter( 'theme_page_templates', 'wpse_288589_add_template_to_select', 10, 4 );
function wpse_288589_add_template_to_select( $post_templates, $wp_theme, $post, $post_type ) {
    // Add custom template named template-custom.php to select dropdown
    $post_templates['archive-news.php'] = __('News Archive');
    $post_templates['archive-events.php'] = __('Events Archive');

    return $post_templates;
}
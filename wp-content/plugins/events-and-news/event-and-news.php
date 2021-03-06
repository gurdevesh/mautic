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
            'taxonomies' => array('post_tag'),
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
            <li >
                <a class="d-year" href="<?php echo $url ?>"><?php echo $year ?></a>
                <ul class="d-month">
                    <?php
                    foreach($month as $each) {
                        $url = get_month_link( $year, $each ).$suffix;
                        ?>
                        <li> <a href="<?php echo $url; ?>"><?php echo $wp_locale->get_month( $each ); ?></a> </li>
                    <?php } ?>
                </ul>
            </li>
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

function si_get_breadcrumbs()
{
    // Set variables for later use
    $home_link        = home_url('/');
    $home_text        = __( 'Home' );
    $link_before      = '<span typeof="v:Breadcrumb">';
    $link_after       = '</span>';
    $link_attr        = ' rel="v:url" property="v:title"';
    $link             = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
    $delimiter        = ' &raquo; ';              // Delimiter between crumbs
    $before           = '<span class="current">'; // Tag before the current crumb
    $after            = '</span>';                // Tag after the current crumb
    $page_addon       = '';                       // Adds the page number if the query is paged
    $breadcrumb_trail = '';
    $category_links   = '';

    /** 
     * Set our own $wp_the_query variable. Do not use the global variable version due to 
     * reliability
     */
    $wp_the_query   = $GLOBALS['wp_the_query'];
    $queried_object = $wp_the_query->get_queried_object();

    // Handle single post requests which includes single pages, posts and attatchments
    if ( is_singular() ) 
    {
        /** 
         * Set our own $post variable. Do not use the global variable version due to 
         * reliability. We will set $post_object variable to $GLOBALS['wp_the_query']
         */
        $post_object = sanitize_post( $queried_object );

        // Set variables 
        $title          = apply_filters( 'the_title', $post_object->post_title );
        $parent         = $post_object->post_parent;
        $post_type      = $post_object->post_type;
        $post_id        = $post_object->ID;
        $post_link      = $before . $title . $after;
        $parent_string  = '';
        $post_type_link = '';

        if ( 'post' === $post_type ) 
        {
            // Get the post categories
            $categories = get_the_category( $post_id );
            if ( $categories ) {
                // Lets grab the first category
                $category  = $categories[0];

                $category_links = get_category_parents( $category, true, $delimiter );
                $category_links = str_replace( '<a',   $link_before . '<a' . $link_attr, $category_links );
                $category_links = str_replace( '</a>', '</a>' . $link_after,             $category_links );
            }
        }

        if ( !in_array( $post_type, ['post', 'page', 'attachment'] ) )
        {
            $post_type_object = get_post_type_object( $post_type );
            $archive_link     = esc_url( get_post_type_archive_link( $post_type ) );

            $post_type_link   = sprintf( $link, $archive_link, $post_type_object->labels->singular_name );
        }

        // Get post parents if $parent !== 0
        if ( 0 !== $parent ) 
        {
            $parent_links = [];
            while ( $parent ) {
                $post_parent = get_post( $parent );

                $parent_links[] = sprintf( $link, esc_url( get_permalink( $post_parent->ID ) ), get_the_title( $post_parent->ID ) );

                $parent = $post_parent->post_parent;
            }

            $parent_links = array_reverse( $parent_links );

            $parent_string = implode( $delimiter, $parent_links );
        }

        // Lets build the breadcrumb trail
        if ( $parent_string ) {
            $breadcrumb_trail = $parent_string . $delimiter . $post_link;
        } else {
            $breadcrumb_trail = $post_link;
        }

        if ( $post_type_link )
            $breadcrumb_trail = $post_type_link . $delimiter . $breadcrumb_trail;

        if ( $category_links )
            $breadcrumb_trail = $category_links . $breadcrumb_trail;
    }

    // Handle archives which includes category-, tag-, taxonomy-, date-, custom post type archives and author archives
    if( is_archive() )
    {
        if (    is_category()
             || is_tag()
             || is_tax()
        ) {
            // Set the variables for this section
            $term_object        = get_term( $queried_object );
            $taxonomy           = $term_object->taxonomy;
            $term_id            = $term_object->term_id;
            $term_name          = $term_object->name;
            $term_parent        = $term_object->parent;
            $taxonomy_object    = get_taxonomy( $taxonomy );
            $current_term_link  = $before . $taxonomy_object->labels->singular_name . ': ' . $term_name . $after;
            $parent_term_string = '';

            if ( 0 !== $term_parent )
            {
                // Get all the current term ancestors
                $parent_term_links = [];
                while ( $term_parent ) {
                    $term = get_term( $term_parent, $taxonomy );

                    $parent_term_links[] = sprintf( $link, esc_url( get_term_link( $term ) ), $term->name );

                    $term_parent = $term->parent;
                }

                $parent_term_links  = array_reverse( $parent_term_links );
                $parent_term_string = implode( $delimiter, $parent_term_links );
            }

            if ( $parent_term_string ) {
                $breadcrumb_trail = $parent_term_string . $delimiter . $current_term_link;
            } else {
                $breadcrumb_trail = $current_term_link;
            }

        } elseif ( is_author() ) {

            $breadcrumb_trail = __( 'Author archive for ') .  $before . $queried_object->data->display_name . $after;

        } elseif ( is_date() ) {
            // Set default variables
            $year     = $wp_the_query->query_vars['year'];
            $monthnum = $wp_the_query->query_vars['monthnum'];
            $day      = $wp_the_query->query_vars['day'];

            // Get the month name if $monthnum has a value
            if ( $monthnum ) {
                $date_time  = DateTime::createFromFormat( '!m', $monthnum );
                $month_name = $date_time->format( 'F' );
            }

            if ( is_year() ) {

                $breadcrumb_trail = $before . $year . $after;

            } elseif( is_month() ) {

                $year_link        = sprintf( $link, esc_url( get_year_link( $year ) ), $year );

                $breadcrumb_trail = $year_link . $delimiter . $before . $month_name . $after;

            } elseif( is_day() ) {

                $year_link        = sprintf( $link, esc_url( get_year_link( $year ) ),             $year       );
                $month_link       = sprintf( $link, esc_url( get_month_link( $year, $monthnum ) ), $month_name );

                $breadcrumb_trail = $year_link . $delimiter . $month_link . $delimiter . $before . $day . $after;
            }

        } elseif ( is_post_type_archive() ) {

            $post_type        = $wp_the_query->query_vars['post_type'];
            $post_type_object = get_post_type_object( $post_type );

            $breadcrumb_trail = $before . $post_type_object->labels->singular_name . $after;

        }
    }   

    // Handle the search page
    if ( is_search() ) {
        $breadcrumb_trail = __( 'Search query for: ' ) . $before . get_search_query() . $after;
    }

    // Handle 404's
    if ( is_404() ) {
        $breadcrumb_trail = $before . __( 'Error 404' ) . $after;
    }

    // Handle paged pages
    if ( is_paged() ) {
        $current_page = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : get_query_var( 'page' );
        $page_addon   = $before . sprintf( __( ' ( Page %s )' ), number_format_i18n( $current_page ) ) . $after;
    }

    $breadcrumb_output_link  = '';
    $breadcrumb_output_link .= '<div class="breadcrumb">';
    if (    is_home()
         || is_front_page()
    ) {
        // Do not show breadcrumbs on page one of home and frontpage
        if ( is_paged() ) {
            $breadcrumb_output_link .= '<a href="' . $home_link . '">' . $home_text . '</a>';
            $breadcrumb_output_link .= $page_addon;
        }
    } else {
        $breadcrumb_output_link .= '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $home_text . '</a>';
        $breadcrumb_output_link .= $delimiter;
        $breadcrumb_output_link .= $breadcrumb_trail;
        $breadcrumb_output_link .= $page_addon;
    }
    $breadcrumb_output_link .= '</div><!-- .breadcrumbs -->';

    return $breadcrumb_output_link;
}

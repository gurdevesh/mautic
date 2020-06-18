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
     **/
    public function enqueue_public_styles() {

        wp_enqueue_style( PLUGIN_NAME.'_style', EVENTNEWS_PLUGIN_URL . 'public/css/custom-public.css', array());
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     **/
    public function enqueue_public_scripts() {

        wp_enqueue_script( PLUGIN_NAME.'_script', EVENTNEWS_PLUGIN_URL . 'public/js/custom-public.js', array( 'jquery' ) );
    }


    // Create post type for News

    function create_post_type()
    {
        // Create Custom Post Type for News
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
                'rewrite' => array('slug' => 'news'), // custom slug
                'taxonomies' => array('')
            )
        );

        // Create Custom Post Type for Events
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
                'rewrite' => array('slug' => 'events', 'with_front' => false), // custom slug
                'taxonomies' => array('')
            )
        );
    }


    function create_taxonomy()
    {
        // Create taxonomy for News
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

    // Template for single and archive page of News and Events
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

    function add_rewrite_rules() {
        add_rewrite_rule('news/?$','index.php?pagename=news', 'top');
        add_rewrite_rule('events/?$','index.php?pagename=events', 'top');

        add_rewrite_rule(
            'news/([0-9]{4})/([0-9]{1,2})/?$',
            'index.php?post_type=news&year=$matches[1]&monthnum=$matches[2]',
            'top'
        );

        add_rewrite_rule(
            'events/([0-9]{4})/([0-9]{1,2})/?$',
            'index.php?post_type=events&year=$matches[1]&monthnum=$matches[2]',
            'top'
        );

        flush_rewrite_rules();
    }

    //Load template from specific page
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
     * Add "Custom" template to page attirbute template section.
     */
    function name_the_page_template( $post_templates, $wp_theme, $post, $post_type ) {
        // Add custom template named template-custom.php to select dropdown
        $post_templates['archive-news.php'] = __('News Archive');
        $post_templates['archive-events.php'] = __('Events Archive');

        return $post_templates;
    }

    function excerpt_with_read_more($excerpt) {
        global $post;
        if(!empty($post->post_excerpt)){
            return '<p>'.$post->post_excerpt.' <a href="'. get_permalink($post->ID) . '">Read More</a></p>';
        }
        return $excerpt;
    }


    function modify_read_more($more) {
        global $post;
        return ' <a href="'. get_permalink($post->ID) . '">' . 'Read More' . '</a>';
    }

    function show_breadcrumbs()
    {
        // Set variables for later use
        //$home_link        = home_url('/');
        //$home_text        = __( 'Home' );
        $link_before      = '<span typeof="v:Breadcrumb">';
        $link_after       = '</span>';
        $link_attr        = ' rel="v:url" property="v:title"';
        $link             = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
        $delimiter        = ' / ';              // Delimiter between crumbs
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
        if (    is_home() || is_front_page()) {
            if ( is_paged() ) {
                // $breadcrumb_output_link .= '<a href="' . $home_link . '">' . $home_text . '</a>';
                // $breadcrumb_output_link .= $page_addon;
            }
        } else {
            //$breadcrumb_output_link .= '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $home_text . '</a>';
            //$breadcrumb_output_link .= $delimiter;
            $breadcrumb_output_link .= $breadcrumb_trail;
            $breadcrumb_output_link .= $page_addon;
        }
        $breadcrumb_output_link .= '</div><!-- .breadcrumbs -->';

        return $breadcrumb_output_link;
    }

    function filter_archive_year_month($attr){
        $type = $attr['type'];

        $month_str = get_query_var('custom_month');
        $year_str = get_query_var('custom_year');

        global $wpdb, $wp_locale;

        $sql_where = $wpdb->prepare( "WHERE p.post_type = %s AND p.post_status = 'publish' AND pm.meta_key = 'date'", $type );

        $query = "SELECT YEAR(pm.meta_value) AS year, MONTH(pm.meta_value) AS month from $wpdb->posts p left join $wpdb->postmeta pm on p.ID = pm.post_id $sql_where GROUP BY year,month ORDER BY YEAR(pm.meta_value) DESC";

        $results = $wpdb->get_results( $query );

        $year_array = array();
        foreach ($results as $each){
            $year_array[$each->year][] = $each->month;
        }
//        echo '<pre>';print_r($year_array);exit;
//        $suffix = '?post_type='.$type;
        $filter_html = ''; $i= 0;
        foreach ($year_array as $year => $month){
            $active = 'filter-inactive';
            if(empty($month_str)){
                if($i == 0){
                    $active = 'filter-active';
                }
            }
            else{
                if($year == $year_str){
                    $active = 'filter-active';
                }
            }


//            $url = get_year_link( $year ).$suffix;

            $filter_html .= '<ul class="filter '.$active.'">'
                    .'<li>'
                        .'<label class="d-year" data-year-name="'.$year.'"><strong>'.$year.'</strong></label>'
                        .'<ul class="d-month">';
                        foreach($month as $each) {
//                            $url = $type.'/'.get_month_link( $year, $each );
                            $url = get_site_url().'/'.$type.'/'.$year.'/'.$each.'/';
                            $current_month = '';
                            if($year == $year_str && $each == $month_str){
                                $current_month = 'active';
                            }
                            $filter_html .= '<li class="'.$current_month.'"> <a  data-year-name="'.$each.'" href="'.$url.'">'.$wp_locale->get_month( $each ).'</a> </li>';
                         }
            $filter_html .= '</ul>'
                .'</li>'
            .'</ul>';
            $i++;
         }

        return $filter_html;
    }

    function calendar_for_mobile($attr){
        $type = $attr['type'];

        $month_str = get_query_var('custom_month');
        $year_str = get_query_var('custom_year');

        global $wpdb, $wp_locale;

        $sql_where = $wpdb->prepare( "WHERE p.post_type = %s AND p.post_status = 'publish' AND pm.meta_key = 'date'", $type );

        $query = "SELECT YEAR(pm.meta_value) AS year, MONTH(pm.meta_value) AS month from $wpdb->posts p left join $wpdb->postmeta pm on p.ID = pm.post_id $sql_where GROUP BY year,month ORDER BY YEAR(pm.meta_value) DESC";

        $results = $wpdb->get_results( $query );

        $year_array = array();
//        $first = 0;
        foreach ($results as $each){
//            if($first == 0){
//                $first_year = $each->year;
//            }
            $year_array[$each->year][] = $each->month;
//            $first = 1;
        }

//        $prefix = 'news'.$type;
        $filter_html = ''; $i= 0;

        $month_name_array = array(
            'JAN',
            'FEB',
            'MAR',
            'APR',
            'MAY',
            'JUN',
            'JUL',
            'AUG',
            'SEP',
            'OCT',
            'NOV',
            'DEC'
        );

        if(empty($month_str)){
            $year_str = 'Year';
            $month_short = 'Month';
            $current_month_text = $month_short.' '.$year_str;
        }
        else{
            $month_name = $wp_locale->get_month( $month_str );
            $month_short = $month_name_array[($month_str-1)];
            $current_month_text = $month_name.' '.$year_str;
        }

        $filter_html = '<div class="current-year-month">'
				            .'<a href="#"><i class="far fa-calendar-minus"></i>'
                                .'<label class="year-month" data-year="'.$year_str.'" data-month="'.$month_short.'">'
                                .$current_month_text
                                .'</label>'
				            .'<i class="fas fa-chevron-down"></i></a>'
				        .'</div>'; //.current-year-month ends



        $filter_html .= '<div class="calender-wrap">';

        $i = 1; $count_years = count($year_array);
        foreach ($year_array as $this_year => $this_month){
            $prev = $next = ''; // disable prev and next button on first and last div respectively
            if($i == 1){
                $prev = 'disabled';
            }
            else if($i == $count_years){
                $next = 'disabled';
            }

            $filter_html .= '<div class="year-month-wrap" data-year="'.$this_year.'">'
            .'<div class="year-wrap">'
            .'<div class="current-year">'
            .$this_year
            .'</div>'
            .'<div class="year-next-prev">'
            .'<span '.$prev.' class="prev-year"> <i class="fas fa-chevron-up"></i> </span>'
            .'<span '.$next.' class="next-year"> <i class="fas fa-chevron-down"></i> </span>'
            .'</div>'
            .'</div>'; // .year-wrap ends

            $filter_html .= '<div class="months-wrap">';
            foreach ($month_name_array as $key => $each_month){
                $disabled = $month_url = $active = '';
                if(!in_array(($key+1), $this_month)){ // if posts does not exists for this month
                    $disabled = 'disabled';
                }
                else{
                    $month_url = get_site_url().'/'.$type.'/'.$this_year.'/'.($key+1).'/';
                }

                if($month_str == ($key+1) && $year_str == $this_year){ // to highlight the current month page loaded
                    $active = 'active';
                }

                $filter_html .= '<div class="month '.$disabled.' '.$active.'"><a href="'.$month_url.'"> '.$each_month.' </a></div>';
            }
            $filter_html .= '</div>'; // .months-wrap ends
            $filter_html .= '</div>'; // .year-month-wrap ends

            $i++;
        }

        $filter_html .= '</div>'; // .calender-wrap ends
        return $filter_html;
    }

    function pre_get_posts($query){
        //Only alter query if custom variable is set.
        $month_str = $query->get('monthnum');
        $year_str = $query->get('year');
        if( !empty($month_str) ){

            $meta_query = $query->get('meta_query');
            if( empty($meta_query) )
                $meta_query = array();

            //Convert 2012/05 into a datetime object get the first and last days of that month in yyyy/mm/dd format
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
//            echo '<pre>';print_r($query);


        }
    }

}
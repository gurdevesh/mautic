<?php
/**
 * Define shortcodes for breadcrumbs and filter
 *
 * @link              https://snotrainfotech.com/
 * @since             1.0.0
 *
 * @package           EventNews
 * @subpackage        EventNews/includes
 */

class Shortcode
{
    public function __construct(){
        // Do Nothing.
    }

    /**
     * Callback function for shortcode - 'si_breadcrumbs'
     * Display Breadcrumbs on the page where shortcode is used
     *
     * @return string The structured breadcrumbs html string
     */
    function show_breadcrumbs(){

        // Set variables for later use
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

    /**
     * Callback function for shortcode - 'si_archive_filter'
     * Filter the custom posts on the page where shortcode is used - For Web view
     *
     * @param $attr Type of post - news | events
     * @return string The structured html of Filter by year month
     */
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

            $filter_html .= '<ul class="filter '.$active.'">'
                .'<li>'
                .'<label class="d-year" data-year-name="'.$year.'"><strong>'.$year.'</strong></label>'
                .'<ul class="d-month">';

            foreach($month as $each) {
                if($type == 'events'){
                    $url = get_site_url().'/si-'.$type.'/'.$year.'/'.$each.'/';
                } else {
                    $url = get_site_url().'/'.$type.'/'.$year.'/'.$each.'/';
                }

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

    /**
     * Callback function for shortcode - 'si_archive_filter_mobile'
     * Filter the custom posts on the page where shortcode is used - For Mobile view
     *
     * @param $attr Type of post - news | events
     * @return string The structured html of Calender View
     */
    function calendar_for_mobile($attr){
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
                    if($type == 'events'){
                        $month_url = get_site_url().'/si-'.$type.'/'.$this_year.'/'.($key+1).'/';
                    } else {
                        $month_url = get_site_url().'/'.$type.'/'.$this_year.'/'.($key+1).'/';
                    }
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

}
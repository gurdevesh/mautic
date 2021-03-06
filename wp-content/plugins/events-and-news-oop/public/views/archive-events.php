<?php
/**
 * Template Name: Events Archive
 *
 * @link              https://snotrainfotech.com/
 * @since             1.0.0
 *
 * @package           EventNews
 * @subpackage        EventNews/public/views
 */

include get_template_directory().'/fullwidth-header.php';

$meta_query = array();
if(is_month()){
    $month_str = get_query_var('custom_month');
    $year_str = get_query_var('custom_year');
    if( !empty($month_str) ){
        $month = new DateTime($year_str.'/'.$month_str.'/01');
        $meta_query = array(
            'key' => 'date',
            'value' => array($month->format('Y-m-d').' 00:00:00',$month->format('Y-m-t'). '23:59:59'),
            'compare' => 'BETWEEN',
        );
    }
}

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = array (
    'post_type' => 'events',
    'paged'         => $paged,
    'meta_query'    => array($meta_query),
    'meta_key'			=> 'date',
    'orderby'			=> 'meta_value',
    'order'				=> 'DESC'
);
?>
<section id="primary" class="content-area">
    <div class="container">
        <h2>Events</h2>
        <div class="row">
            <div class="col-md-2">
                <div class="collapsible-dates">
                    <?php echo do_shortcode("[si_archive_filter type='events']"); ?>
                </div>
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mautic-sub-form">
                            <h4>
                                Don't miss on our events. Subscribe to
                                <span class="text-black">
                                    get alerts
                                </span>
                            </h4>
                            <?php include "mautic-form.php"; ?>
                        </div>
                    </div>
                </div>
                <div class="custom-calender">
                    <?php echo do_shortcode("[si_archive_filter_mobile type='events']"); ?>
                </div>

                <?php
                $loop = new WP_Query($args);
                /* Start the Loop */
                while ( $loop->have_posts() ) :
                $loop->the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="event-wrap">
                        <div class="events-date">
                            <?php
                            $event_date = get_field('date' );
                            $date = strtotime($event_date);
                            $day =  date('j', $date);
                            $month =  date('M', $date);
                            $year =  date('Y', $date);

                            if(!empty($event_date)): ?>
                                <br />
                                <?php
                                $current_date = date('F j, Y g:i a');
                                $new_date_format= date( 'j F Y', strtotime($event_date));
                                if ( strtotime($current_date) < strtotime($event_date) ) { ?>
                                    <h4>Upcoming On</h4>
                                <?php } ?>
                                <div class="date-wrap">
                                    <span class="day"> <?php echo $day; ?></span>
                                    <span class="month"> <?php echo $month; ?> </span>
                                    <span class="year"> <?php echo $year; ?> </span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="events-details-wrap">
                            <div class="event-img">
                                <?php $bg = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); ?>
                                <img src="<?php echo $bg[0]; ?>" class="img-responsive" />
                            </div>
                            <div class="events-details">
                                <div class="event-title">
                                    <h3> <a href="<?php the_permalink() ?>"><?php the_title() ?></a> </h3>
                                </div>
                                <div class="mobile-events-date">
                                	<i class="far fa-calendar-alt"></i>
		                            <?php
		                            if(!empty($event_date)):
		                                $current_date = date('F j, Y g:i a');
		                                $new_date_format= date( 'j F Y', strtotime($event_date));
		                                ?>
		                                <span class="date-wrap-cal">
		                                     <?php echo $day; ?>  <?php echo $month; ?> <?php echo $year; ?> 
		                                </span>
		                            <?php endif; ?>
		                        </div>
                                <div class="event-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?php
                                    $location = get_field( 'location' );
                                    if(!empty($location)){ ?>
                                        <?php  echo get_field( 'location' );
                                    } ?>
                                </div>

                                <div class="event-text">
                                    <?php  the_excerpt(); ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </article>
                <?php endwhile; // End of the loop. ?>
                <div class="si-pagging">
	                <?php echo paginate_links(array('total'=> $loop->max_num_pages, 'prev_text' => '« Prev')); ?>
	            </div>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </div>

</section><!-- #primary -->

<?php
get_footer();

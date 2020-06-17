<?php
/**
 * Template Name: Events Archive
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
?>
	<section id="primary" class="content-area">
    	<div class="container">
    		<h2>Events</h2>

            <?php
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
            ?>

    		<div class="row"> 
    			<div class="col-md-2"> 
    				<div class="collapsible-dates">
                        <?php echo do_shortcode("[si_archive_filter type='events']"); ?>
    				</div>
    			</div>
    			<div class="col-md-10">
    				<div class="custom-calender">
				        <div class="current-year-month">
				            <a href="#"> <i class="far fa-calendar-minus"></i> April 2020  <i class="fas fa-chevron-down"></i></a>
				        </div>
				        <div class="calender-wrap">
				            <div class="year-wrap">
				                <div class="current-year">
				                    2020
				                </div>
				                <div class="year-next-prev">
				                    <a href="" class="prev-year"> <i class="fas fa-chevron-up"></i> </a>
				                    <a href="" class="next-year"> <i class="fas fa-chevron-down"></i> </a>
				                </div>
				            </div>
				            <div class="months-wrap">
				                <div class="month"> <a href="#"> JAN </a> </div>
				                <div class="month"> <a href="#"> FEB </a> </div>
				                <div class="month"> <a href="#"> MAR </a> </div>
				                <div class="month"> <a href="#"> APR </a> </div>
				                <div class="month"> <a href="#"> MAY </a> </div>
				                <div class="month active"> <a href="#"> JUN </a> </div>
				                <div class="month"> <a href="#"> JUL </a> </div>
				                <div class="month"> <a href="#"> AUG </a> </div>
				                <div class="month"> <a href="#"> SEP </a> </div>
				                <div class="month"> <a href="#"> OCT </a> </div>
				                <div class="month"> <a href="#"> NOV </a> </div>
				                <div class="month"> <a href="#"> DEC </a> </div>
				            </div>
				        </div>
				    </div>
    				<?php
		            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		            $args = array (
		                'post_type' => 'events',
		                'paged'         => $paged,
                        'meta_query' => array($meta_query)
		            );
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

			                    if(!empty($event_date)){ ?>
			                        <br />
			                        <!-- <strong>Event Date:</strong> -->
			                        <?php
										//$current_date = date('l F jS Y - g:i A');
			                        $current_date = date('l, F jS Y g:i A T');
			                        $new_date_format= date( 'j F Y', strtotime($event_date));
			                        if ( strtotime($current_date) < strtotime($event_date) ) { ?>
			                            <h4>Upcoming On</h4>
			                        <?php } ?>
			                        <div class="date-wrap">
					    				<span class="day"> <?php echo $day; ?></span>
					    				<span class="month"> <?php echo $month; ?> </span>
					    				<span class="year"> <?php echo $year; ?> </span>
					    			</div>
			                    <?php } ?>				    			
				    		</div>
				    		<div class="events-details-wrap"> 
				    			<div class="event-img">
				    				<?php
					                    $bg = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
					                ?>
					                <img src="<?php echo $bg[0]; ?>" class="img-responsive" />
				    			</div>
				    			<div class="events-details">
				    				<div class="event-title"> 
					    				<h3> <a href="<?php the_permalink() ?>"><?php the_title() ?></a> </h3>
					    			</div>
					    			<div class="mobile-date">
					    				<i class="far fa-calendar-minus"></i>
					    				<span class="day"> <?php echo $day; ?></span>
					    				<span class="month"> <?php echo $month; ?> </span>
					    				<span class="year"> <?php echo $year; ?> </span>
						    			
					    			</div>
					    			<div class="event-location"> 
					    				<i class="fas fa-map-marker-alt"></i>
					    				<?php
					                    $location = get_field( 'location' );
					                    if(!empty($location)){ ?>
					                        <strong>Location:</strong>
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
				    <?php  endwhile; // End of the loop. ?>
                	<?php //wpbeginner_numeric_posts_nav();
	                	echo paginate_links(array('total'=> $loop->max_num_pages))
	                ?>
	                
	                <?php wp_reset_postdata(); ?>
    			</div>
    		</div>

    	</div>

    </section><!-- #primary -->

<?php
get_footer();

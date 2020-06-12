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
    		<h2><?php the_title() ?></h2>
    		<div class="row"> 
    			<div class="col-md-2"> 
    				<div class="collapsible-dates">
    					 <?php filter_archive_year_month('events'); ?>
    				</div>
    			</div>
    			<div class="col-md-10">
    				<?php
		            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		            $args = array (
		                'post_type' => 'events',
		                'paged'         => $paged,
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
			//                        $current_date = date('l F jS Y - g:i A');
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

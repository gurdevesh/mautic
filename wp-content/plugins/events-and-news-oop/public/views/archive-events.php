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
			<div class="row">
				<div class="col-md-12">
					<div class="mautic-sub-form">
						<h4> 
							Don't miss on our events. Subscribe to 
							<span class="text-black">
								get alerts 
							</span> 
						</h4>
						<style type="text/css" scoped>
							.mauticform_wrapper { max-width: 600px; margin: 10px auto; }
							.mauticform-innerform {}
							.mauticform-post-success {}
							.mauticform-name { font-weight: bold; font-size: 1.5em; margin-bottom: 3px; }
							.mauticform-description { margin-top: 2px; margin-bottom: 10px; }
							.mauticform-error { margin-bottom: 10px; color: red; }
							.mauticform-message { margin-bottom: 10px;color: green; }
							.mauticform-row { display: block; margin-bottom: 20px; }
							.mauticform-label { font-size: 1.1em; display: block; font-weight: bold; margin-bottom: 5px; }
							.mauticform-row.mauticform-required .mauticform-label:after { color: #e32; content: " *"; display: inline; }
							.mauticform-helpmessage { display: block; font-size: 0.9em; margin-bottom: 3px; }
							.mauticform-errormsg { display: block; color: red; margin-top: 2px; }
							.mauticform-selectbox, .mauticform-input, .mauticform-textarea { width: 100%; padding: 0.5em 0.5em; border: 1px solid #CCC; background: #fff; box-shadow: 0px 0px 0px #fff inset; border-radius: 4px; box-sizing: border-box; }
							.mauticform-checkboxgrp-row {}
							.mauticform-checkboxgrp-label { font-weight: normal; }
							.mauticform-checkboxgrp-checkbox {}
							.mauticform-radiogrp-row {}
							.mauticform-radiogrp-label { font-weight: normal; }
							.mauticform-radiogrp-radio {}
							.mauticform-button-wrapper .mauticform-button.btn-default, .mauticform-pagebreak-wrapper .mauticform-pagebreak.btn-default { color: #5d6c7c;background-color: #ffffff;border-color: #dddddd;}
							.mauticform-button-wrapper .mauticform-button, .mauticform-pagebreak-wrapper .mauticform-pagebreak { display: inline-block;margin-bottom: 0;font-weight: 600;text-align: center;vertical-align: middle;cursor: pointer;background-image: none;border: 1px solid transparent;white-space: nowrap;padding: 6px 12px;font-size: 13px;line-height: 1.3856;border-radius: 3px;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;}
							.mauticform-button-wrapper .mauticform-button.btn-default[disabled], .mauticform-pagebreak-wrapper .mauticform-pagebreak.btn-default[disabled] { background-color: #ffffff; border-color: #dddddd; opacity: 0.75; cursor: not-allowed; }
							.mauticform-pagebreak-wrapper .mauticform-button-wrapper {  display: inline; }
						</style>
						<div id="mauticform_wrapper_subscription" class="mauticform_wrapper">
							<form autocomplete="false" role="form" method="post" action="http://34.73.98.235/mautic/mauticopensource/form/submit?formId=1" id="mauticform_subscription" data-mautic-form="subscription" enctype="multipart/form-data">
								<div class="mauticform-error" id="mauticform_subscription_error"></div>
								<div class="mauticform-message" id="mauticform_subscription_message"></div>
								<div class="mauticform-innerform">

									
									<div class="mauticform-page-wrapper mauticform-page-1" data-mautic-form-page="1">

									<div id="mauticform_subscription_email" data-validate="email" data-validation-type="email" class="mauticform-row mauticform-email mauticform-field-1 mauticform-required">
										<input id="mauticform_input_subscription_email" name="mauticform[email]" value="" placeholder="Enter your e-mail ID" class="mauticform-input" type="email">
										<button type="submit" name="mauticform[submit]" id="mauticform_input_subscription_submit" value="" class="mauticform-button btn btn-default">Subscribe</button>
										<span class="mauticform-errormsg" style="display: none;">Please enter valid Email ID</span>
									</div>

									<div id="mauticform_subscription_submit" class="mauticform-row mauticform-button-wrapper mauticform-field-2">
										
									</div>
									</div>
								</div>

								<input type="hidden" name="mauticform[formId]" id="mauticform_subscription_id" value="1">
								<input type="hidden" name="mauticform[return]" id="mauticform_subscription_return" value="">
								<input type="hidden" name="mauticform[formName]" id="mauticform_subscription_name" value="subscription">

								</form>
						</div>
					</div>
				</div>
			</div>
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
									//$current_date = date('l, F jS Y g:i A T');
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
					    			<div class="mobile-date" >
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

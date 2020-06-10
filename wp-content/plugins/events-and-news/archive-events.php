<?php
/**
 * The template for displaying list of News posts 
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
			<div id="main" class="site-main">
	            <h2>Events</h2>
				<?php
					
				/* Start the Loop */
				while ( have_posts() ) :
					the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="article-left"> 
							<?php
							$event_date = get_field('date' );
		                    if(!empty($event_date)){ ?>
		                        <br />
		                        <!-- <strong>Event Date:</strong> -->
								<?php
								$current_date = date('l, F jS Y g:i A T');
								$new_date_format= date( 'j F Y', strtotime($event_date));
								if ( strtotime($current_date) < strtotime($event_date) ) { ?>
								<h3>Upcoming On</h3>
								<?php } ?>
								<br/>
								<strong> <?php 
											//echo esc_html(  $new_date_format );
											echo $event_date;
										?> 
								</strong>
		                    <?php } ?>
						</div>


						<header class="entry-header">
		                    <h1 class="entry-title">
		                        <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
		                    </h1>
							
						</header>
						<div class="entry-content">
		                    <?php
		                    $bg = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
		                    ?>
		                    <img src="<?php echo $bg[0]; ?>" class="img-responsive" />
		                    <?php  the_excerpt(); ?>
							<!--  <a href="--><?php //the_permalink() ?><!--">Read More</a><br />-->

							<?php
		                    $location = get_field( 'location' );
		                    if(!empty($location)){ ?>
		                        <strong>Location:</strong>
		                        <?php  echo get_field( 'location' );
		                    } ?>

		                    
						</div><!-- .entry-content -->
					</article>
					<?php  endwhile; // End of the loop. ?>
	                <?php wpbeginner_numeric_posts_nav(); ?>
			</div><!-- #main -->

		</div>
	</section><!-- #primary -->
<?php
get_footer();

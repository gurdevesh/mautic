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
<h2>archive</h2>
	<section id="primary" class="content-area">
		<main id="main" class="site-main">
			<?php
				
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				
				get_template_part( 'template-parts/content/content', 'page' );

				echo get_field( 'location' ); 
				
				$current_date = date('j F, Y');
				$event_date = get_field('date' );
				if ( strtotime($current_date) > strtotime($event_date) ) { ?>
				<h3>Upcoming On</h3>
				<?php } ?>
				<br/>
				<strong> <?php echo esc_html(  get_field('date') ) .' '.  get_field('duration'); ?> </strong>
				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				 if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();

<?php
 /*Template Name: New Template
 */
 
get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', 'single' ); ?>
                <strong> Date: </strong>
                <?php echo esc_html(  get_field('date' ) ); ?>
                <br />
                <strong> Source: </strong>
                <?php echo esc_html( get_field('source' ) ); ?>
                <br />
                <strong> PDF Download: </strong>
                <a href="<?php echo esc_html( get_field('pdf_download') ); ?>" download>Download</a>
              <?php  
              $terms = get_the_terms( get_the_ID(), 'news_type' );
            //   print_r($a); 
                echo '<br />';
                // echo get_category_link(5);

                if(!empty($terms[0])){
                    $term = $terms[0]; ?>
                    <strong> Category: </strong>
                    <a href="<?php echo get_category_link($term->term_id) ?>" ><?php echo $term->name; ?></a>
                <?php } ?>

                <?php wp_get_archives( array( 'type' => 'monthly', 'format' => 'html', 'show_post_count' => 1, 'post_type'=>'news' ) ); ?>

                <br />
                <?php
				if ( is_singular( 'attachment' ) ) {
					// Parent post navigation.
					the_post_navigation(
						array(
							/* translators: %s: parent post link */
							'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'twentynineteen' ), '%title' ),
						)
					);
				} elseif ( is_singular( 'post' ) ) {
					// Previous/next post navigation.
					the_post_navigation(
						array(
							'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next Post', 'twentynineteen' ) . '</span> ' .
								'<span class="screen-reader-text">' . __( 'Next post:', 'twentynineteen' ) . '</span> <br/>' .
								'<span class="post-title">%title</span>',
							'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous Post', 'twentynineteen' ) . '</span> ' .
								'<span class="screen-reader-text">' . __( 'Previous post:', 'twentynineteen' ) . '</span> <br/>' .
								'<span class="post-title">%title</span>',
						)
					);
				}

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
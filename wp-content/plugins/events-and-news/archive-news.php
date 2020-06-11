<?php
/**
 * Template Name: News Archive
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
        <main id="main" class="site-main">
            <h2>News</h2>
            <?php

            /* Start the Loop */
            while ( have_posts() ) :
            the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title">
                        <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                    </h1>
                    <?php
                    // Edit post link.
//                    edit_post_link(
//                        sprintf(
//                            wp_kses(
//                            /* translators: %s: Name of current post. Only visible to screen readers. */
//                                __( 'Edit <span class="screen-reader-text">%s</span>', 'twentynineteen' ),
//                                array(
//                                    'span' => array(
//                                        'class' => array(),
//                                    ),
//                                )
//                            ),
//                            get_the_title()
//                        ),
//                        '<span class="edit-link">' . twentynineteen_get_icon_svg( 'edit', 16 ),
//                        '</span>'
//                    );
                    ?>
                </header>
                <div class="entry-content">
                    <?php
                    $bg = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                    ?>
                    <img src="<?php echo $bg[0]; ?>" class="img-responsive" />
                    <?php  the_excerpt(); ?>
                    <!--  <a href="--><?php //the_permalink() ?><!--">Read More</a><br />-->


                </div><!-- .entry-content -->
                <?php  endwhile; // End of the loop. ?>
                <?php wpbeginner_numeric_posts_nav(); ?>
                <?php filter_archive_year_month('news'); ?>
        </main><!-- #main -->
    </section><!-- #primary -->
<?php
get_footer();

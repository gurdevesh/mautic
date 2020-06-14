<?php
/**
 * The template for displaying all single posts for Events
 *
 * @link https://snotrainfotech.com/
 *
 * @package EventNews
 * @subpackage EventNews/Views
 * @since 1.0.0
 */

get_header();

?>
    <div class="container">
        <div class="single-event-wrap">
            <div class="date-time-wrap"> 
                <div class="row"> 
                    
                </div>
            </div>
        </div>
    </div>


    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <?php echo do_shortcode("[si_breadcrumbs]"); ?>
        <?php

            // Start the Loop.
            while (have_posts()) :
                the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <strong> <?php echo esc_html(get_field('date')) .' '.  get_field('duration'); ?> </strong>
                        <h1 class="entry-title">
                            <?php the_title() ?>
                        </h1>
                    </header>
                    <div class="entry-content">
                        <?php
                        $bg = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                        ?>
                        <img src="<?php echo $bg[0]; ?>" class="img-responsive" />
                        <?php the_content(); ?>
                        <br/>
                        <br/>
                    </div><!-- .entry-content -->
                </article><!-- #post-<?php the_ID(); ?> -->
            <?php
            endwhile; ?>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();

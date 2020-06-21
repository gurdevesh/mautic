<?php
/**
 * The template for displaying all single posts of post type Events
 *
 * @link              https://snotrainfotech.com/
 * @since             1.0.0
 *
 * @package           EventNews
 * @subpackage        EventNews/public/views
 */

include get_template_directory().'/fullwidth-header.php';
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <div class="container">
            <?php
            // Start the Loop.
            while (have_posts()) :
                the_post(); ?>
            <div class="single-news-page">
                <div class="breadcrumb-wrap">
                    <?php echo do_shortcode("[si_breadcrumbs]"); ?>
                </div>
                <div class="news-date-wrap">
                    <div class="date">
                        <i class="far fa-calendar-alt"></i>
                        <?php 
                        $date = date_create(get_field('date' ));
                        echo date_format($date,"l, F jS Y g A (T)");
						?>
                    </div>
                    <div class="time">
                        <i class="far fa-clock"></i>
                        <?php echo esc_html( get_field('duration' )); ?>
                    </div>
                </div>
                <div class="single-news-title">
                    <h2> 
                        <?php the_title() ?>
                    </h2>
                </div>
                <?php $bg = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); ?>
                <div class="single-news-desc">
                    <img src="<?php echo $bg[0]; ?>" class="img-responsive" />
                    <?php the_content(); ?>
                </div>
            </div>
            <?php endwhile; ?>
        </div>  
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();

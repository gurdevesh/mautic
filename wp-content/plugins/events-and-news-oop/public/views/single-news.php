<?php
/**
 * Single New template
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
            while (have_posts()) : the_post(); ?>

            <div class="single-news-page">
                <div class="breadcrumb-wrap">
                    <?php echo do_shortcode("[si_breadcrumbs]"); ?>
                </div>
                <div class="news-date-wrap">
                    <div class="date">
                        <i class="far fa-calendar-alt"></i>
                        <?php
                            $event_date = get_field('date' );
                            $date = strtotime($event_date);
                            $month =  date('F', $date);
                            $dname = date('l', $date);
                            $day =  date('j', $date);
                            $year =  date('Y', $date);

                            echo $dname.', '.$month.' '.$day.' '.$year ;
                        ?>
                    </div>
                    <div class="time">
                        <i class="far fa-clock"></i>
                        <?php echo esc_html( human_time_diff( get_the_time('U'), current_time('timestamp') ) ) . ' ago'; ?>
                    </div>
                    <div class="category">
                        <i class="fas fa-sitemap"></i>
                        <?php
                            $terms = get_the_terms( get_the_ID(), 'news_type' );
                            if(!empty($terms[0])){
                                $term = $terms[0]; ?>
                                <a href="<?php echo get_category_link($term->term_id) ?>" ><?php echo $term->name; ?></a>
                            <?php }
                            $bg = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                        ?>
                    </div>
                </div>
                <div class="single-news-title">
                    <h2>
                        <?php the_title() ?>
                    </h2>
                </div>
                <div class="single-news-desc">
                    <img src="<?php echo $bg[0]; ?>" class="img-responsive" />
                    <?php the_content(); ?>
                </div>
            </div>
            <?php
            endwhile; ?>

        </div>
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();




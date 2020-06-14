<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since Twenty Nineteen 1.0
 */

get_header();
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
                    <?php echo do_shortcode("[breadcrumb]"); ?>   
                </div>
                <div class="news-date-wrap">
                    <div class="date">
                        <i class="far fa-calendar-alt"></i>
                        <?php echo esc_html(  get_field('date' ) ); ?>
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

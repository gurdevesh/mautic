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
            <h2><?php the_title() ?></h2>
            <strong>Media Contact</strong>
            <ul>
                <li><?php echo get_field('media_name') ?></li>
                <li><?php echo get_field('media_email') ?></li>
                <li><?php echo get_field('media_contact') ?></li>
            </ul>

            <strong>Media</strong>
            <ul>
                <li>
                    <strong>FutureBridge Introduction</strong>
                <a href="<?php echo esc_html( get_field('intro') ); ?>" download>Download</a></li>
                <li><strong>FutureBridge Logo</strong>
                <a href="<?php echo esc_html( get_field('logo') ); ?>" download>Download</a></li>
                <li><strong>Press Photos</strong>
                <a href="<?php echo esc_html( get_field('press_photos') ); ?>" download>Download</a></li>
            </ul>
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $args = array (
                'post_type' => 'news',
                'paged'         => $paged,
            );
            $loop = new WP_Query($args);

            /* Start the Loop */
            while ( $loop->have_posts() ) :
            $loop->the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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


                </div><!-- .entry-content -->
                <?php  endwhile; // End of the loop. ?>
                <?php //wpbeginner_numeric_posts_nav();
                echo paginate_links(array('total'=> $loop->max_num_pages))
                ?>
                <?php filter_archive_year_month('news'); ?>
                <?php wp_reset_postdata(); ?>

        </main><!-- #main -->
    </section><!-- #primary -->
<?php
get_footer();

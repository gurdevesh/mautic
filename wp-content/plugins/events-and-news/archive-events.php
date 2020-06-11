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
        <main id="main" class="site-main">
            <h2><?php the_title() ?></h2>
            <?php
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $args = array (
                'post_type' => 'events',
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

                    <?php
                    $location = get_field( 'location' );
                    if(!empty($location)){ ?>
                        <strong>Location:</strong>
                        <?php  echo get_field( 'location' );
                    } ?>

                    <?php
                    $event_date = get_field('date' );
                    if(!empty($event_date)){ ?>
                        <br />
                        <!-- <strong>Event Date:</strong> -->
                        <?php
//                        $current_date = date('l F jS Y - g:i A');
                        $current_date = date('l, F jS Y g:i A T');
                        $new_date_format= date( 'j F Y', strtotime($event_date));
                        if ( strtotime($current_date) < strtotime($event_date) ) { ?>
                            <h3>Upcoming On</h3>
                        <?php } ?>
                        <br/>
                        <strong> <?php echo esc_html(  $new_date_format );?> </strong>
                    <?php } ?>
                </div><!-- .entry-content -->
                <?php  endwhile; // End of the loop. ?>
                <?php //wpbeginner_numeric_posts_nav();
                echo paginate_links(array('total'=> $loop->max_num_pages))
                ?>
                <?php filter_archive_year_month('events'); ?>
                <?php wp_reset_postdata(); ?>
        </main><!-- #main -->
    </section><!-- #primary -->
<?php
get_footer();

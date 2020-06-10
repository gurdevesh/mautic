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
        <main id="main" class="site-main">
            <h2>Events</h2>
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
                    edit_post_link(
                        sprintf(
                            wp_kses(
                            /* translators: %s: Name of current post. Only visible to screen readers. */
                                __( 'Edit <span class="screen-reader-text">%s</span>', 'twentynineteen' ),
                                array(
                                    'span' => array(
                                        'class' => array(),
                                    ),
                                )
                            ),
                            get_the_title()
                        ),
                        '<span class="edit-link">' . twentynineteen_get_icon_svg( 'edit', 16 ),
                        '</span>'
                    );
                    ?>
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
                    $date = strtotime($s);
					$day =  date('j', $date);
					$month =  date('F', $date);
					$year =  date('jS Y', $date);
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
                        <strong> 
                        	<?php 
                        		echo $day.' '.$month.' '.$year; 
                        		//esc_html(  $new_date_format );
                        	?> 
                        </strong>
                  	<?php } ?>
                </div><!-- .entry-content -->
                <?php  endwhile; // End of the loop. ?>
                <?php wpbeginner_numeric_posts_nav(); ?>
                <?php filter_archive_year_month('events'); ?>

        </main><!-- #main -->
    </section><!-- #primary -->
<?php
get_footer();

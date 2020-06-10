<?php
get_header();
?>
    <div id="primary" class="content-area">
        <main id="main" class="site-main">
            <?php

            // Start the Loop.
            while (have_posts()) :
                the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <strong> Date: </strong>
                        <?php echo esc_html(  get_field('date' ) ); ?>
                        <br />
                        <h1 class="entry-title">
                            <?php the_title() ?>
                        </h1>
                    </header>
                    <div class="entry-content">
                        <strong> Source: </strong>
                        <?php echo esc_html( get_field('source' ) ); ?>
                        <br />
                        <strong> PDF Download: </strong>
                        <a href="<?php echo esc_html( get_field('pdf_download') ); ?>" download>Download</a>
                        <br />
                        <?php
                        $terms = get_the_terms( get_the_ID(), 'news_type' );
                        if(!empty($terms[0])){
                            $term = $terms[0]; ?>
                            <strong> Category: </strong>
                            <a href="<?php echo get_category_link($term->term_id) ?>" ><?php echo $term->name; ?></a>
                        <?php }
                        $bg = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); ?>

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




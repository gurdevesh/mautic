<?php
/**
 * Template Name: News Archive
 *
 * @link              https://snotrainfotech.com/
 * @since             1.0.0
 *
 * @package           EventNews
 * @subpackage        EventNews/public/views
 */

include get_template_directory().'/fullwidth-header.php';

$meta_query = array();
if(is_month()){
    $month_str = get_query_var('custom_month');
    $year_str = get_query_var('custom_year');
    if( !empty($month_str) ){
        $month = new DateTime($year_str.'/'.$month_str.'/01');
        $meta_query = array(
            'key' => 'date',
            'value' => array($month->format('Ymd'),$month->format('Ymt')),
            'compare' => 'BETWEEN',
            'type' => 'date'
        );
    }
}

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$args = array (
    'post_type' => 'news',
    'paged'     => $paged,
    'meta_query' => array($meta_query),
    'meta_key'			=> 'date',
    'orderby'			=> 'meta_value',
    'order'				=> 'DESC'
);
$loop = new WP_Query($args);

$page_id = '';
$page = get_page_by_path( "news", OBJECT, array( 'page' ) );
if(!empty($page)){
    $page_id = $page->ID;   
}
$siteurl = get_site_url();
?>
<section id="primary" class="content-area">
    <div class="container">
        <div class="tabs-section">
            <ul class="nav nav-tabs tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link <?php echo $overview ?> active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php echo $news ?>" id="news-tab" data-toggle="tab" href="#news" role="tab" aria-controls="news" aria-selected="false">News</a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade <?php echo $overview ?> overview-tab" style="display: block;" id="overview"  role="tabpanel" aria-labelledby="overview-tab">
                    <div class="media-wrap">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4> Media Contact </h4>
                                        <div class="media-ul">
                                            <ul>
                                                <?php $media_name = get_field( "media_name", $page_id );
                                                    if( $media_name ) { ?>
                                                <li>
                                                    <i class="fas fa-user-circle"></i>
                                                    <a href="#"> <?php echo $media_name; ?> </a>
                                                </li>
                                                <?php } ?>
                                                <?php $media_email = get_field( "media_email", $page_id );
                                                    if( $media_email ) { ?>
                                                <li>
                                                    <i class="fas fa-envelope"></i>
                                                    <a href="mailto:<?php echo $media_email; ?>">
                                                        <?php echo $media_email; ?>
                                                    </a>
                                                </li>
                                                <?php } ?>
                                                <?php $media_contact = get_field( "media_contact", $page_id );
                                                    if( $media_contact ) { ?>
                                                 <li>
                                                    <i class="fas fa-phone"></i>
                                                    <a href="tel:<?php echo $media_contact; ?> "> <?php echo $media_contact; ?> </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4> Media </h4>
                                        <div class="media-ul">
                                            <ul>
                                                <?php $intro = get_field( "intro", $page_id );
                                                    if( $intro ) { ?>
                                                <li>
                                                    <i class="fas fa-info-circle"></i>
                                                    <a href="<?php echo $intro; ?>" download> FutureBridge Introduction </a>
                                                    <a class="download-link"  href="<?php echo $intro; ?>" download>
                                                        <i class="fas fa-download"></i> </a>
                                                </li>
                                                <?php } ?>
                                                <?php $logo = get_field( "logo", $page_id );
                                                    if( $logo ) { ?>
                                                <li>
                                                    <i class="fas">
                                                        <img src="<?php echo $siteurl.'/wp-content/uploads/2018/09/futurebridge-favicon.png'; ?>" />
                                                    </i>
                                                    <a href="<?php echo $logo; ?>" download> FutureBridge Logo </a>
                                                    <a class="download-link" href="<?php echo $logo; ?>" download>
                                                        <i class="fas fa-download"></i> </a>
                                                </li>
                                                <?php } ?>
                                                <?php $press_photos = get_field( "press_photos", $page_id );
                                                    if( $press_photos ) { ?>
                                                <li>
                                                    <i class="far fa-images"></i>
                                                    <a href="<?php echo $press_photos; ?>" download> Press Photos </a>
                                                    <a class="download-link" href="<?php echo $press_photos; ?>" download>
                                                        <i class="fas fa-download"></i> </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mautic-sub-form">
                                            <h4>
                                                Subscribe to
                                                <span class="text-black">
                                                    FutureBridge
                                                </span>
                                                press releases
                                            </h4>
                                            <?php include "mautic-form.php"; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="twitter-wrap">
                                    <a class="twitter-timeline" href="https://twitter.com/TheFutureBridge?ref_src=twsrc%5Etfw">Tweets by TheFutureBridge</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade <?php echo $news ?>" id="news" role="tabpanel" aria-labelledby="news-tab">
                  <div class="row">
                        <div class="col-md-2">
                            <div class="collapsible-dates">
                                <?php echo do_shortcode("[si_archive_filter type='news']"); ?>
                            </div>
                            <div class="custom-calender">
                                <?php echo do_shortcode("[si_archive_filter_mobile type='news']"); ?>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="news-listing">
                                 <?php
                                    /* Start the Loop */
                                    while ( $loop->have_posts() ) :
                                    $loop->the_post(); ?>
                                <div class="news-listed-wrap">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <?php
                                                $terms = get_the_terms( get_the_ID(), 'news_type' );
                                                if(!empty($terms[0])){
                                                    $term = $terms[0]; ?>
                                                    <div class="news-category"><?php echo $term->name; ?></div>
                                                <?php }
                                            ?>

                                            <div class="news-date">
                                                <?php
                                                $event_date = get_field('date' );
                                                $day =  date("j", strtotime($event_date));
                                                $month = date("M", strtotime($event_date));
                                                $year =  date("Y", strtotime($event_date));

                                                if(!empty($event_date)){ ?>
                                                    <br />
                                                    <span class="day"> <?php echo $day; ?></span>
                                                    <span class="month"> <?php echo $month; ?> </span>
                                                    <span class="year"> <?php echo $year; ?> </span>
                                                <?php } ?>
                                            </div>
                                            <?php
                                                $tags = get_field('source' );
                                                $tagsLists = explode(',', $tags);
                                            ?>
                                            <div class="news-tags">
                                                <ul>
                                                    <?php
                                                        foreach($tagsLists as $tagsList){
                                                            echo '<li>'.$tagsList.'</li>';
                                                        }
                                                    ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <h5 class="news-title">
                                                <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                                            </h5>
                                            <div class="news-excerpt">
                                            <?php  the_excerpt();
                                            ?>
                                            </div>
                                            <div class="pdf-download-link">
                                            <?php 
                                                $pdflink = get_field('pdf_download');
                                                $pdflinks = $pdflink['url'];
                                                if($pdflink != ''){ ?>
                                                <a href="<?php echo $pdflinks;?>" download>
                                                    <i class="fas fa-download"></i>
                                                </a>
                                               <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php  endwhile; // End of the loop. ?>
                                <div class="si-pagging">
                                    <?php echo paginate_links(array('total'=> $loop->max_num_pages)) ?>
                                </div>
                            </div>
                        </div>
                  </div>
              </div>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();

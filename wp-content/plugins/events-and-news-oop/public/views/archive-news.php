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
        <div class="container">
            <div class="tabs-section">
                <ul class="nav nav-tabs tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="overview-tab" data-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link inactive" id="news-tab" data-toggle="tab" href="#news" role="tab" aria-controls="news" aria-selected="false">News</a>
                  </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active overview-tab" id="overview"  role="tabpanel" aria-labelledby="overview-tab">
                        <div class="media-wrap"> 
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row"> 
                                        <div class="col-md-6"> 
                                            <h4> Media Contact </h4>
                                            <div class="media-ul">
                                                <ul>
                                                    <?php 
                                                        $media_name = get_field( "media_name" );

                                                        if( $media_name ) {
                                                    ?>        
                                                    <li> 
                                                        <i class="fas fa-user-circle"></i> 
                                                        <a href="#"> <?php echo $media_name; ?> </a>
                                                    </li>
                                                    <?php 
                                                        }
                                                    ?>
                                                    <?php 
                                                        $media_email = get_field( "media_email" );

                                                        if( $media_email ) {
                                                    ?>        
                                                    <li> 
                                                        <i class="fas fa-envelope"></i> 
                                                        <a href="mailto:<?php echo $media_email; ?>"> 
                                                            <?php echo $media_email; ?> 
                                                        </a>
                                                    </li>
                                                    <?php 
                                                        }
                                                    ?>
                                                    <?php 
                                                        $media_contact = get_field( "media_contact" );

                                                        if( $media_contact ) {
                                                    ?>        
                                                     <li> 
                                                        <i class="fas fa-phone-alt"></i> 
                                                        <a href="tel:<?php echo $media_contact; ?> "> <?php echo $media_contact; ?> </a>
                                                    </li>
                                                    <?php 
                                                        }
                                                    ?>
                                                   
                                                   
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6"> 
                                            <h4> Media Contact </h4>
                                            <div class="media-ul">
                                                <ul>
                                                    <?php 
                                                        $intro = get_field( "intro" );

                                                        if( $intro ) {
                                                            

                                                    ?>

                                                    <li> 
                                                        <i class="fas fa-info-circle"></i> 
                                                        <a href="<?php echo $intro; ?>" download> FutureBridge Introduction </a>
                                                        <a class="download-link"  href="<?php echo $intro; ?>" download><i class="fas fa-download"></i> </a>

                                                    </li>
                                                    <?php
                                                    }
                                                    ?>  

                                                    <?php 
                                                        $logo = get_field( "logo" );

                                                        if( $logo ) {
                                                            

                                                    ?>
                                                    <li> 
                                                        <i class="fas fa-bars"></i> 
                                                        <a href="<?php echo $logo; ?>" download> FutureBridge Logo </a>
                                                        <a class="download-link" href="<?php echo $logo; ?>" download><i class="fas fa-download"></i> </a>
                                                    </li>
                                                    <?php
                                                        }
                                                    ?>
                                                    <?php 
                                                        $press_photos = get_field( "press_photos" );

                                                        if( $press_photos ) {        

                                                    ?>
                                                    <li> 
                                                        <i class="far fa-images"></i> 
                                                        <a href="<?php echo $press_photos; ?>" download> Press Photos </a>
                                                        <a class="download-link" href="<?php echo $press_photos; ?>" download><i class="fas fa-download"></i> </a>
                                                    </li>
                                                    <?php
                                                    }
                                                ?>
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
                                                <style type="text/css" scoped>
                                                    .mauticform_wrapper { max-width: 600px; margin: 10px auto; }
                                                    .mauticform-innerform {}
                                                    .mauticform-post-success {}
                                                    .mauticform-name { font-weight: bold; font-size: 1.5em; margin-bottom: 3px; }
                                                    .mauticform-description { margin-top: 2px; margin-bottom: 10px; }
                                                    .mauticform-error { margin-bottom: 10px; color: red; }
                                                    .mauticform-message { margin-bottom: 10px;color: green; }
                                                    .mauticform-row { display: block; margin-bottom: 20px; }
                                                    .mauticform-label { font-size: 1.1em; display: block; font-weight: bold; margin-bottom: 5px; }
                                                    .mauticform-row.mauticform-required .mauticform-label:after { color: #e32; content: " *"; display: inline; }
                                                    .mauticform-helpmessage { display: block; font-size: 0.9em; margin-bottom: 3px; }
                                                    .mauticform-errormsg { display: block; color: red; margin-top: 2px; }
                                                    .mauticform-selectbox, .mauticform-input, .mauticform-textarea { width: 100%; padding: 0.5em 0.5em; border: 1px solid #CCC; background: #fff; box-shadow: 0px 0px 0px #fff inset; border-radius: 4px; box-sizing: border-box; }
                                                    .mauticform-checkboxgrp-row {}
                                                    .mauticform-checkboxgrp-label { font-weight: normal; }
                                                    .mauticform-checkboxgrp-checkbox {}
                                                    .mauticform-radiogrp-row {}
                                                    .mauticform-radiogrp-label { font-weight: normal; }
                                                    .mauticform-radiogrp-radio {}
                                                    .mauticform-button-wrapper .mauticform-button.btn-default, .mauticform-pagebreak-wrapper .mauticform-pagebreak.btn-default { color: #5d6c7c;background-color: #ffffff;border-color: #dddddd;}
                                                    .mauticform-button-wrapper .mauticform-button, .mauticform-pagebreak-wrapper .mauticform-pagebreak { display: inline-block;margin-bottom: 0;font-weight: 600;text-align: center;vertical-align: middle;cursor: pointer;background-image: none;border: 1px solid transparent;white-space: nowrap;padding: 6px 12px;font-size: 13px;line-height: 1.3856;border-radius: 3px;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;}
                                                    .mauticform-button-wrapper .mauticform-button.btn-default[disabled], .mauticform-pagebreak-wrapper .mauticform-pagebreak.btn-default[disabled] { background-color: #ffffff; border-color: #dddddd; opacity: 0.75; cursor: not-allowed; }
                                                    .mauticform-pagebreak-wrapper .mauticform-button-wrapper {  display: inline; }
                                                </style>
                                                <div id="mauticform_wrapper_subscription" class="mauticform_wrapper">
                                                    <form autocomplete="false" role="form" method="post" action="http://34.73.98.235/mautic/mauticopensource/form/submit?formId=1" id="mauticform_subscription" data-mautic-form="subscription" enctype="multipart/form-data">
                                                        <div class="mauticform-error" id="mauticform_subscription_error"></div>
                                                        <div class="mauticform-message" id="mauticform_subscription_message"></div>
                                                        <div class="mauticform-innerform">

                                                            
                                                          <div class="mauticform-page-wrapper mauticform-page-1" data-mautic-form-page="1">

                                                            <div id="mauticform_subscription_email" data-validate="email" data-validation-type="email" class="mauticform-row mauticform-email mauticform-field-1 mauticform-required">
                                                                <input id="mauticform_input_subscription_email" name="mauticform[email]" value="" placeholder="Enter your e-mail ID" class="mauticform-input" type="email">
                                                                <button type="submit" name="mauticform[submit]" id="mauticform_input_subscription_submit" value="" class="mauticform-button btn btn-default">Subscribe</button>
                                                                <span class="mauticform-errormsg" style="display: none;">Please enter valid Email ID</span>
                                                            </div>

                                                            <div id="mauticform_subscription_submit" class="mauticform-row mauticform-button-wrapper mauticform-field-2">
                                                                
                                                            </div>
                                                            </div>
                                                        </div>

                                                        <input type="hidden" name="mauticform[formId]" id="mauticform_subscription_id" value="1">
                                                        <input type="hidden" name="mauticform[return]" id="mauticform_subscription_return" value="">
                                                        <input type="hidden" name="mauticform[formName]" id="mauticform_subscription_name" value="subscription">

                                                        </form>
                                                </div>
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
                  <div class="tab-pane fade" id="news" role="tabpanel" aria-labelledby="news-tab">
                      <div class="row"> 
                            <div class="col-md-2"> 
                                <div class="collapsible-dates">
                                    <?php echo do_shortcode("[si_archive_filter type='events']"); ?>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="news-listing">
                                     <?php
                                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                                        $args = array (
                                            'post_type' => 'news',
                                            'paged'     => $paged,
                                        );
                                        $loop = new WP_Query($args);

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
                                                    $date = strtotime($event_date);
                                                    $day =  date('j', $date);
                                                    $month =  date('M', $date);
                                                    $year =  date('Y', $date);

                                                    if(!empty($event_date)){ ?>
                                                        <br />
                                                        <!-- <strong>Event Date:</strong> -->
                                                        
                                                        <span class="day"> <?php echo $day; ?></span>
                                                        <span class="month"> <?php echo $month; ?> </span>
                                                        <span class="year"> <?php echo $year; ?> </span>
                                                        
                                                    <?php } ?>  
                                                </div>
                                                <?php
                                                    $tags = get_field('source' );
                                                    //$myString = "9,admin@example.com,8";
                                                    $tagsLists = explode(',', $tags);
                                                    //print_r($tagsList);

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
                                                if($pdflink != ''){
                                                   ?>
                                                    <a href="<?php the_field('pdf_download');?>" download> 
                                                        <i class="fas fa-download"></i> 
                                                    </a>
                                                   <?php
                                                }
                                                ?>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <?php  endwhile; // End of the loop. ?>
                                    <?php
                                    echo paginate_links(array('total'=> $loop->max_num_pages))
                                    ?>
                                </div>
                            </div>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">

    </script>
   

<?php
get_footer();

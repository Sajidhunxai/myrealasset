<?php
global $post;
$info_price = STTour::get_info_price();
if ( isset( $_REQUEST['start'] ) && strlen( $_REQUEST['start'] ) > 0 ) {
    $_REQUEST['check_in'] = $_REQUEST['check_out'] = $_REQUEST['end'] = $_REQUEST['start'];
}
$url=st_get_link_with_search(get_permalink(),array('start','end','date','duration','people'),$_REQUEST);

$class = 'col-lg-4 col-md-6 col-sm-6 col-xs-12 item-service grid-item has-matchHeight';
if(isset($top_search) and $top_search)
    $class = 'col-lg-3 col-md-4 col-sm-6 col-xs-12 item-service grid-item has-matchHeight';
if(isset($slider) and $slider)
    $class = 'item-service grid-item has-matchHeight';
?>
<div class="<?php echo esc_attr($class); ?>">
    <div class="service-border">
        <div class="thumb">
            <?php echo st()->load_template('layouts/modern/hotel/loop/wishlist'); ?>
            <div class="service-tag bestseller">
                <?php echo STFeatured::get_featured(); ?>
            </div>
            <a href="<?php echo esc_url($url); ?>">
                <?php
                if(has_post_thumbnail()){
                    //the_post_thumbnail(array(680, 630), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive'));
                    the_post_thumbnail(array(680, 500), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive'));
                }else{
                    echo '<img src="'. get_template_directory_uri() . '/img/no-image.png' .'" alt="Default Thumbnail" class="img-responsive" />';
                }
                ?>
            </a>
            <?php echo st_get_avatar_in_list_service(get_the_ID(),70)?>
        </div>
        <h4 class="service-title plr15"><a href="<?php echo esc_url($url); ?>"><?php echo get_the_title(); ?></a></h4>

        <div class="service-review plr15">
            <ul class="icon-group text-color booking-item-rating-stars">
                <?php
                $avg = STReview::get_avg_rate();
                echo TravelHelper::rate_to_string($avg);
                ?>
            </ul>
            <?php
            $count_review = get_comment_count(get_the_ID())['approved'];
            ?>
            <span class="review">
                <?php //echo esc_html($count_review) . ' ' . _n(esc_html__('Review', 'traveler'),esc_html__('Reviews', 'traveler'),$count_review); ?>
                <?php comments_number(__('0 reviews', 'traveler'), __('1 Review', 'traveler'), __('% Reviews', 'traveler')); ?>
            </span>
        </div>

        <div class="section-footer">
            <div class="footer-inner plr15">
                <?php
                $duration = get_post_meta( get_the_ID(), 'duration_day', true );
                if(!empty($duration)) {
                    ?>
                    <div class="service-duration">
                        <?php echo TravelHelper::getNewIcon('time-clock-circle-1', '#5E6D77', '16px', '16px'); ?>
                        <?php echo esc_html($duration); ?>
                    </div>
                    <?php
                }
                ?>
                <div class="service-price">
                    <span>
                        <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '10px', '16px'); ?>
                            <span class="fr_text"><?php _e("from", 'traveler') ?></span>
                    </span>
                    <span class="price">
                        <?php
                        echo STTour::get_price_html(get_the_ID());
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

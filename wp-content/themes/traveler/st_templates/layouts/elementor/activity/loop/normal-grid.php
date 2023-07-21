<?php
global $post;
$info_price = STActivity::inst()->get_info_price();
if ( isset( $_REQUEST['start'] ) && strlen( $_REQUEST['start'] ) > 0 ) {
    $_REQUEST['check_in'] = $_REQUEST['check_out'] = $_REQUEST['end'] = $_REQUEST['start'];
}
if(isset($_REQUEST['location_id'])) {
    $_REQUEST['location_id'] = intval($_REQUEST['location_id']);
}

$url=st_get_link_with_search(get_permalink(),array('start','end','date','duration','people'),$_REQUEST);

if (!empty($item_row)) {
                            
    $class = 'col-lg-' . (12 / $item_row).' col-sm-6 col-md-6';
    
} else {
    $class='col-12 col-sm-6 col-md-4 col-lg-4';
}
$class_image='image-feature';
if( !empty($slider) && $slider === 'slider'){
    $class = 'swiper-slide';
    $class_image = 'swiper-lazy';
}
?>
<div class="item-tour st-item-activity <?php echo esc_attr($class); ?>" itemscope itemtype="https://schema.org/Event">
    <div class="item item-tours service-border st-border-radius"  itemprop="event">
        <div class="featured-image">
            <?php if(!empty( $info_price['discount'] ) and $info_price['discount']>0 and $info_price['price_new'] >0) { ?>
                <?php echo STFeatured::get_sale($info_price['discount']); ?>
            <?php } ?>
            <?php if(is_user_logged_in()){ ?>
                <?php $data = STUser_f::get_icon_wishlist();?>
                <div class="service-add-wishlist login <?php echo ($data['status']) ? 'added' : ''; ?>" data-id="<?php echo get_the_ID(); ?>" data-type="<?php echo get_post_type(get_the_ID()); ?>" title="<?php echo ($data['status']) ? __('Remove from wishlist', 'traveler') : __('Add to wishlist', 'traveler'); ?>">
                    <i class="fa fa-heart"></i>
                    <div class="lds-dual-ring"></div>
                </div>
            <?php }else{ ?>
                <a href="#" class="login" data-bs-toggle="modal" data-target="#st-login-form">
                    <div class="service-add-wishlist" title="<?php echo __('Add to wishlist', 'traveler'); ?>">
                        <i class="fa fa-heart"></i>
                        <div class="lds-dual-ring"></div>
                    </div>
                </a>
            <?php } ?>
            <div class="service-tag bestseller">
                <?php echo STFeatured::get_featured(); ?>
            </div>
            <a href="<?php echo esc_url($url); ?>" itemprop="url">
                <?php
                if(has_post_thumbnail()){
                    the_post_thumbnail(array(450, 300), array('alt' => TravelHelper::get_alt_image(), 'itemprop' => 'image', 'class' => 'img-responsive'));
                }else{
                    echo '<img itemprop="photo" src="'. get_template_directory_uri() . '/img/no-image.png' .'" alt="Default Thumbnail" class="img-responsive" />';
                }
                ?>
            </a>
            <?php do_action('st_list_compare_button',get_the_ID(),get_post_type(get_the_ID())); ?>
            <?php echo st_get_avatar_in_list_service(get_the_ID(),70)?>
        </div>
        <div class="content-item" itemscope itemtype="https://schema.org/Place">
            
            <h3 class="title" itemprop="name"><a href="<?php echo esc_url($url); ?>"><?php echo get_the_title(); ?></a></h3>
            <?php if ($address = get_post_meta(get_the_ID(), 'address', TRUE)): ?>
                <p class="service-location plr15 location" itemprop="location">
                    <span itemprop="address" itemscope itemtype="https://schema.org/PostalAddress"> 
                        <?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?>
                    </span>
                </p>
            <?php endif;?>
            <?php 
                $datetime = date("Y-m-d H:i:s");

                 // Updated ISO8601
            ?>
            <div class="event-date d-none" itemprop="startDate" content="<?php echo date("Y-m-d H:i:s");?>"><?php echo date("Y-m-d H:i:s");?></div>
            <div class="section-footer">
                <div class="reviews d-flex align-items-center" itemprop="starRating" itemscope itemtype="https://schema.org/Rating">
                    <?php
                        $avg = STReview::get_avg_rate();
                        if(!empty($avg)){ ?>
                            <ul class="rate d-flex align-items-center rate-tours" itemprop="ratingValue">
                                <?php
                                echo TravelHelper::rate_to_string($avg);
                                ?>
                            </ul>
                        <?php }
                    ?>
                    
                    <?php
                    $count_review = get_comment_count(get_the_ID())['approved'];
                    ?>
                    <span class="summary">
                        <?php comments_number( __( 'No Review', 'traveler' ), __( '1 Review', 'traveler' ), get_comments_number() . ' ' . __( 'Reviews', 'traveler' ) ); ?>
                    </span>
                </div>
                <div class="footer-inner d-flex align-items-center justify-content-between">
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
                    <div class="price-wrapper d-flex align-items-center " itemprop="priceRange">
                        <span>
                            <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '10px', '16px'); ?>
                                <span class="fr_text"><?php _e("from", 'traveler') ?></span>
                        </span>
                        <span class="price">
                            <?php
                            echo STActivity::get_price_html(get_the_ID());
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

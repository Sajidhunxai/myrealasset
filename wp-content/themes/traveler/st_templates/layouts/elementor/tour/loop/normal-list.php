<?php
global $post;
$info_price = STTour::get_info_price();
if ( isset( $_REQUEST['start'] ) && strlen( $_REQUEST['start'] ) > 0 ) {
    $_REQUEST['check_in'] = $_REQUEST['check_out'] = $_REQUEST['end'] = $_REQUEST['start'];
}
$url=st_get_link_with_search(get_permalink(),array('check_in','check_out','duration','people'),$_REQUEST);
?>
<div class="item item-service item-tours item-service-inner st-border-radius" itemscope itemtype="https://schema.org/Trip">
    <div class="row align-content-around flex-wrap item-service-wrapper">
        <div class="col-sm-4">
            <div class="thumb">
               
                <?php if(is_user_logged_in()){ ?>
                    <?php $data = STUser_f::get_icon_wishlist();?>
                    <div class="service-add-wishlist login <?php echo ($data['status']) ? 'added' : ''; ?>" data-id="<?php echo get_the_ID(); ?>" data-type="<?php echo get_post_type(get_the_ID()); ?>" title="<?php echo ($data['status']) ? __('Remove from wishlist', 'traveler') : __('Add to wishlist', 'traveler'); ?>">
                        <i class="fa fa-heart"></i>
                        <div class="lds-dual-ring"></div>
                    </div>
                <?php }else{ ?>
                    <a href="" class="login" data-bs-toggle="modal" data-target="#st-login-form">
                        <div class="service-add-wishlist" title="<?php echo __('Add to wishlist', 'traveler'); ?>">
                            <i class="fa fa-heart"></i>
                            <div class="lds-dual-ring"></div>
                        </div>
                    </a>
                <?php } ?>
                <div class="service-tag bestseller">
                    <?php echo STFeatured::get_featured(); ?>
                </div>
                <a href="<?php echo esc_url($url); ?>">
                    <?php
                    if(has_post_thumbnail()){
                        the_post_thumbnail(array(450, 300), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive', 'itemprop'=>"image"));
                    }else{
                        echo '<img src="'. get_template_directory_uri() . '/img/no-image.png' .'" alt="Default Thumbnail" class="img-responsive" />';
                    }
                    ?>
                </a>
                <?php do_action('st_list_compare_button',get_the_ID(),get_post_type(get_the_ID())); ?>
                <?php echo st_get_avatar_in_list_service(get_the_ID(),70)?>
            </div>
        </div>
        <div class="col-sm-5 item-content">
            <div class="section-footer h-100 d-flex align-items-center">
                <div class="item-content-w">
                    <?php if ($address = get_post_meta(get_the_ID(), 'address', TRUE)): ?>
                        <p class="service-location" itemprop="itinerary" itemscope itemtype="https://schema.org/ItemList"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?></p>
                    <?php endif;?>
                    <h4 class="service-title" itemprop="name"><a href="<?php echo esc_url($url); ?>"><?php echo get_the_title(); ?></a></h4>
                    <div class="reviews d-flex align-items-center">
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
                    <div class="service-excerpt">
                        <?php echo mb_strimwidth(strip_shortcodes(New_Layout_Helper::cutStringByNumWord(get_the_excerpt(), 17)), 0, 220, '...'); ?>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-sm-3 section-footer">
            <div class="h-100 footer-flex d-flex align-content-between flex-wrap">
                <?php
                $duration = get_post_meta( get_the_ID(), 'duration_day', true );
                ?>
                <?php
                if(!empty($duration)) {
                    ?>
                    <div class="service-duration d-block d-sm-none d-md-none d-lg-none">
                        <?php echo TravelHelper::getNewIcon('time-clock-circle-1', '#5E6D77', '17px', '17px'); ?>
                        <?php echo esc_html($duration); ?>
                    </div>
                    <?php
                }
                ?>

                <div class="price-wrapper d-flex align-items-center">
                    <span class="price-text">
                        <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '16px', '16px'); ?>
                        <span class="fr_text"><?php _e("from", 'traveler') ?></span>
                    </span>
                    <span class="price">
                        <?php
                        echo STTour::get_price_html(get_the_ID());
                        ?>
                    </span>
                </div>

                <?php
                if(!empty($duration)) {
                    ?>
                    <div class="price-wrapper d-none d-sm-block d-md-block d-lg-block service-duration ">
                        <?php echo TravelHelper::getNewIcon('time-clock-circle-1', '#5E6D77', '17px', '17px'); ?>
                        <?php echo esc_html($duration); ?>
                    </div>
                    <?php
                }
                ?>

                <div class="price-wrapper d-none d-sm-block d-md-block d-lg-block service-type">
                    <?php
                        $tour_type = get_the_terms(get_the_ID(), 'st_tour_type');
                        if(!empty($tour_type)){
                            $tour_type_str = $tour_type[0]->name;
                            echo TravelHelper::getNewIcon('ico_tour_type', '#000000', '17px', '17px', true);
                            echo esc_html($tour_type_str);
                        }
                    ?>
                </div>
                <div class="service-type type-btn-view-more">
                    <a href="<?php echo esc_url($url) ?>" class="btn btn-primary btn-view-more"><?php echo __('VIEW TOUR', 'traveler'); ?></a>
                </div>
                <?php if(!empty( $info_price['discount'] ) and $info_price['discount']>0 and $info_price['price_new'] >0) { ?>
                    <?php echo STFeatured::get_sale($info_price['discount']); ?>
                <?php } ?>
            </div>
            
        </div>
    </div>
</div>

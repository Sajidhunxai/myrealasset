<?php
global $post;
$post_id = get_the_ID();
$post_translated = TravelHelper::post_translated($post_id);
$url=st_get_link_with_search(get_permalink($post_translated),array('start','end','date','adult_number','child_number'),$_GET);
$phone_number = get_post_meta($post_translated,'phone',true);
?>
<div class="item item-service item-service-inner st-border-radius" itemscope itemtype="https://schema.org/Hotel">
    <div class="row align-content-around flex-wrap item-service-wrapper">
        <div class="col-sm-4">
            <div class="featured-image">
                <?php if(is_user_logged_in()){ ?>
                    <?php $data = STUser_f::get_icon_wishlist();?>
                    <div class="service-add-wishlist login <?php echo ($data['status']) ? 'added' : ''; ?>" data-id="<?php echo esc_attr($post_translated); ?>" data-type="<?php echo get_post_type($post_translated); ?>" title="<?php echo ($data['status']) ? __('Remove from wishlist', 'traveler') : __('Add to wishlist', 'traveler'); ?>">
                        <i class="fa fa-heart"></i>
                        <div class="lds-dual-ring"></div>
                    </div>
                <?php }else{ ?>
                    <a href="#" class="login" data-bs-toggle="modal" data-bs-target="#st-login-form">
                        <div class="service-add-wishlist" title="<?php echo __('Add to wishlist', 'traveler'); ?>">
                            <i class="fa fa-heart"></i>
                            <div class="lds-dual-ring"></div>
                        </div>
                    </a>
                <?php } ?>
                <div class="service-tag bestseller">
                    <?php echo STFeatured::get_featured(); ?>
                </div>
                <a href="<?php echo esc_url($url); ?>" itemprop="photo">
                    <?php
                    if(has_post_thumbnail()){
                        echo get_the_post_thumbnail($post_translated, array(450, 417), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive' , 'itemprop'=>"photo"));
                    }else{
                        echo '<img src="'. get_template_directory_uri() . '/img/no-image.png' .'" alt="Default Thumbnail" class="img-responsive" />';
                    }
                    ?>
                </a>
                <?php
                    if(has_post_thumbnail()){
                        echo get_the_post_thumbnail($post_translated, array(450, 417), array('alt' => TravelHelper::get_alt_image(), 'class' => 'd-none', 'itemprop'=>"image"));
                    }
                ?>
                <?php 
                    if(!empty($phone_number)){?>
                        <span class="d-none" itemprop="telephone"><?php echo esc_html($phone_number);?></span>
                    <?php }
                ?>
                <?php do_action('st_list_compare_button',get_the_ID(),get_post_type(get_the_ID())); ?>
                <?php echo st_get_avatar_in_list_service(get_the_ID(),70)?>
                <?php
                $view_star_review = st()->get_option('view_star_review', 'review');
                if($view_star_review == 'review') :
                    ?>
                    <ul class="icon-group d-block d-sm-none d-md-none text-color booking-item-rating-stars">
                        <?php
                        $avg = STReview::get_avg_rate();
                        echo TravelHelper::rate_to_string($avg);
                        ?>
                    </ul>
                <?php elseif($view_star_review == 'star'): ?>
                    <ul class="icon-list d-block d-sm-none d-md-none icon-group booking-item-rating-stars">
                        <span class="pull-left mr10"><?php echo __('Hotel star', 'traveler'); ?></span>
                        <?php
                        $star = STHotel::getStar();
                        echo  TravelHelper::rate_to_string($star, $star);
                        ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-sm-5 item-content">
            <div class="h-100 d-flex align-items-center">
                <div class="item-content-w">
                    <?php
                    $view_star_review = st()->get_option('view_star_review', 'review');
                    if($view_star_review == 'review') :
                        ?>
                        <ul class="d-none d-sm-block d-md-block icon-group text-color booking-item-rating-stars">
                            <?php
                            $avg = STReview::get_avg_rate();
                            echo TravelHelper::rate_to_string($avg);
                            ?>
                        </ul>
                    <?php elseif($view_star_review == 'star'): ?>
                        <ul class="d-none d-sm-block d-md-block icon-list icon-group booking-item-rating-stars">
                            <span class="pull-left mr10"><?php echo __('Hotel star', 'traveler'); ?></span>
                            <?php
                            $star = STHotel::getStar();
                            echo  TravelHelper::rate_to_string($star, $star);
                            ?>
                        </ul>
                    <?php endif; ?>
                    <h4 class="service-title" itemprop="name"><a href="<?php echo esc_url($url); ?>"><?php echo get_the_title($post_translated); ?></a></h4>
                    <?php
                        $hotel_facilities = V2Hotel_Helper::getHotelTerm();
                        if($hotel_facilities){
                            echo '<ul class="facilities">';
                            foreach ($hotel_facilities as $k => $v){
                                echo '<li>'. esc_html($v->name) .'</li>';
                            }
                            echo '</ul>';
                        }
                    ?>
                    <?php if ($address = get_post_meta($post_translated, 'address', TRUE)): ?>
                        <p itemprop="address" itemscope itemtype="https://schema.org/PostalAddress" class="service-location"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?></p>
                    <?php endif;?>
                </div>
            </div>
            
        </div>
        <div class="col-sm-3 section-footer">
            <div class="h-100 footer-flex d-flex align-content-between flex-wrap">
                <div class="reviews d-none d-sm-flex d-md-flex" itemprop="starRating" itemscope itemtype="https://schema.org/Rating">
                    <?php
                    $count_review = get_comment_count(get_the_ID())['approved'];
                    $avg = STReview::get_avg_rate();
                    ?>
                    <div class="count-review">
                        <span class="text-rating"><?php echo TravelHelper::get_rate_review_text($avg, $count_review); ?></span>
                        <span class="review"><?php echo esc_html($count_review) . ' ' . _n(esc_html__('Review', 'traveler'),esc_html__('Reviews', 'traveler'),$count_review); ?></span>
                    </div>
                    <span class="rating" itemprop="ratingValue"><?php echo esc_html($avg); ?><small>/5</small></span>
                </div>
                <div class="reviews d-block d-sm-none d-md-none">
                    <?php
                    $avg = STReview::get_avg_rate();
                    ?>
                    <span class="rating"><?php echo esc_html($avg); ?>/5 <?php echo TravelHelper::get_rate_review_text($avg, $count_review); ?></span>
                    <span class="st-dot"></span>
                    <span class="review"><?php echo esc_html($count_review) . ' ' . _n(esc_html__('Review', 'traveler'),esc_html__('Reviews', 'traveler'),$count_review); ?></span>
                </div>
                <div class="price-wrapper d-flex align-items-center" itemprop="priceRange">
                    <span>
                        <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '10px', '16px'); ?>
                        <?php if(STHotel::is_show_min_price()): ?>
                            <?php _e("From", 'traveler') ?>
                        <?php else:?>
                            <?php _e("Avg", 'traveler') ?>
                        <?php endif;?>
                    </span>
                    <span class="price">
                        <?php
                        $price = STHotel::get_price();
                        echo TravelHelper::format_money($price);
                        ?>
                    </span>
                    <span class="unit"><?php echo __('/night', 'traveler'); ?></span>
                </div>
            </div>
            
        </div>
    </div>
</div>

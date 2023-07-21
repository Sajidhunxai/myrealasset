<?php
global $post;
$post_translated = TravelHelper::post_translated(get_the_ID());
?>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 item-service grid-item has-matchHeight">

		<div class="thumb">
	        <?php if(is_user_logged_in()){ ?>
	            <?php $data = STUser_f::get_icon_wishlist();?>
	            <div class="service-add-wishlist login <?php echo esc_attr(($data['status']) ? 'added' : ''); ?>" data-id="<?php echo esc_attr($post_translated); ?>" data-type="<?php echo esc_attr(get_post_type($post_translated)); ?>" title="<?php echo esc_attr(($data['status']) ? __('Remove from wishlist', 'traveler') : __('Add to wishlist', 'traveler')); ?>">
	                <i class="fa fa-heart"></i>
	                <div class="lds-dual-ring"></div>
	            </div>
	        <?php }else{ ?>
	            <a href="#" class="login" data-toggle="modal" data-target="#st-login-form">
	                <div class="service-add-wishlist" title="<?php echo __('Add to wishlist', 'traveler'); ?>">
	                    <i class="fa fa-heart"></i>
	                    <div class="lds-dual-ring"></div>
	                </div>
	            </a>
	        <?php } ?>
	        <div class="service-tag bestseller">
	            <?php echo STFeatured::get_featured(); ?>
	        </div>
	        <a href="<?php echo esc_url(get_the_permalink($post_translated)) ?>">
	            <?php
	            if(has_post_thumbnail($post_translated)){
	                echo get_the_post_thumbnail($post_translated, array(680, 630), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive'));
	            }else{
	                echo '<img src="'. get_template_directory_uri() . '/img/no-image.png' .'" alt="Default Thumbnail" class="img-responsive" />';
	            }
	            ?>
	        </a>
	        <?php
	        $view_star_review = st()->get_option('view_star_review', 'review');
	        if($view_star_review == 'review') :
	            ?>
	            <ul class="icon-group text-color booking-item-rating-stars">
	                <?php
	                $avg = STReview::get_avg_rate();
	                echo TravelHelper::rate_to_string($avg);
	                ?>
	            </ul>
	        <?php elseif($view_star_review == 'star'): ?>
	            <ul class="icon-list icon-group booking-item-rating-stars">
	                <span class="pull-left mr10"><?php echo __('Hotel star', 'traveler'); ?></span>
	                <?php
	                $star = STHotel::getStar();
	                echo  TravelHelper::rate_to_string($star, $star);
	                ?>
	            </ul>
	        <?php endif; ?>
			<?php echo st_get_avatar_in_list_service(get_the_ID(),70)?>
	    </div>
	    <h4 class="service-title plr15"><a href="<?php echo esc_url(get_the_permalink($post_translated)); ?>"><?php echo esc_html(get_the_title($post_translated)); ?></a></h4>
	    <?php if ($address = get_post_meta($post_translated, 'address', TRUE)): ?>
	        <p class="service-location plr15"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?></p>
	    <?php endif;?>

	    <div class="section-footer plr15">
	        <div class="service-review">
	            <?php
	            $count_review = STReview::count_comment($post_translated);
	            $avg = STReview::get_avg_rate();
	            ?>
	            <span class="rating"><?php echo esc_html($avg); ?>/5 <?php echo TravelHelper::get_rate_review_text($avg, $count_review); ?></span>
	            <span class="st-dot"></span>
	            <span class="review"><?php echo esc_html($count_review) . ' ' . _n(esc_html__('Review', 'traveler'),esc_html__('Reviews', 'traveler'),$count_review); ?></span>
	        </div>
	        <div class="service-price">
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
	                $price = isset($post->st_price)?$post->st_price:0;
	                if($price){
	                    echo TravelHelper::format_money($price);
	                }else{
	                    $price = STHotel::get_price();
	                    echo TravelHelper::format_money($price);
	                }
	                ?>
	            </span>
	            <span><?php echo __('/night', 'traveler'); ?></span>
	        </div>
	    </div>

</div>

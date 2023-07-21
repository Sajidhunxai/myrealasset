<?php
$icon_type  = '<i class="fa fa-building-o"></i>';
$price_type = st_get_language( "night" );
$price      = STHotel::get_price( get_the_ID() );
?>
<li class="st-item-list post-<?php the_ID() ?>">
		<a data-id="<?php the_ID() ?>" data-type="<?php echo get_post_type( get_the_ID() ) ?>" data-placement="top"
           rel="tooltip" class="btn_remove_wishlist cursor fa fa-times booking-item-wishlist-remove"
           data-original-title="<?php st_the_language( 'remove' ) ?>"></a>
        <div class="spinner user_img_loading ">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
        <div class="item-service st-ccv-hotel" id="list-wishlist-hotel">
	        <div class="row item-service-wrapper has-matchHeight">
		        <div class="col-lg-3 col-md-3 col-sm-12 thumb-wrapper col-xs-12">
		            <div class="thumb">
		                <div class="service-tag bestseller">
		                    <?php echo STFeatured::get_featured(); ?>
		                </div>
		                <a href="<?php echo get_the_permalink() ?>">
		                    <?php
		                    if(has_post_thumbnail()){
		                        the_post_thumbnail(array(450, 417), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive'));
		                    }else{
		                        echo '<img src="'. get_template_directory_uri() . '/img/no-image.png' .'" alt="Default Thumbnail" class="img-responsive" />';
		                    }
		                    ?>
		                </a>
		                <?php
		                $view_star_review = st()->get_option('view_star_review', 'review');?>
		            </div>
		        </div>
		        <div class="col-lg-6 col-md-6 col-sm-12 item-content col-xs-12">
		            <div class="item-content-w">
		                <?php
		                $view_star_review = st()->get_option('view_star_review', 'review');
		                if($view_star_review == 'review') :?>
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
		                <h4 class="service-title"><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a></h4>
		                <?php
		                    if (class_exists('V2Hotel_Helper')) {
							    $hotel_facilities = V2Hotel_Helper::getHotelTerm();
							} else {
								$hotel_facilities = TravelHelper::getHotelTerm();
							}
		                    if($hotel_facilities){
		                        echo '<ul class="facilities">';
		                        foreach ($hotel_facilities as $k => $v){
		                            echo '<li>'. esc_html($v->name) .'</li>';
		                        }
		                        echo '</ul>';
		                    }
		                ?>
		                <?php if ($address = get_post_meta(get_the_ID(), 'address', TRUE)): ?>
		                    <p class="service-location"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?></p>
		                <?php endif;?>
		            </div>
		        </div>
		        <div class="col-lg-3 col-md-3 col-sm-12 section-footer col-xs-12">
		            <div class="service-review hidden-xs">
		                <?php
		                $count_review = get_comment_count(get_the_ID())['approved'];
		                $avg = STReview::get_avg_rate();
		                ?>
		                <div class="count-review">
		                    <span class="text-rating"><?php echo TravelHelper::get_rate_review_text($avg, $count_review); ?></span>
		                    <span class="review"><?php echo esc_html($count_review) . ' ' . _n(esc_html__('Review', 'traveler'),esc_html__('Reviews', 'traveler'),$count_review); ?></span>
		                </div>
		                <span class="rating"><?php echo esc_html($avg); ?><small>/5</small></span>
		            </div>
		            <div class="service-review hidden-lg hidden-md hidden-sm">
		                <?php
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
		                <span class="unit"><?php echo __('/night', 'traveler'); ?></span>
		            </div>
		        </div>
		    </div>
	    </div>
</li>



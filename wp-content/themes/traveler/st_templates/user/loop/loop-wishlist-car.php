<?php
	$pickup_date = STInput::get('pick-up-date', date(TravelHelper::getDateFormat()));
	$dropoff_date = STInput::get('drop-off-date', date(TravelHelper::getDateFormat(), strtotime("+ 1 day")));

	$pickup_date = TravelHelper::convertDateFormat($pickup_date);
	$dropoff_date = TravelHelper::convertDateFormat($dropoff_date);

	$pick_up_time = STInput::get('pick-up-time', '12:00 PM');
	$drop_off_time = STInput::get('drop-off-time', '12:00 PM');

	$info_price = STCars::get_info_price(get_the_ID(), strtotime($pickup_date), strtotime($dropoff_date));
	$cars_price = $info_price['price'];
	$count_sale = $info_price['discount'];
	$price_origin = $info_price['price_origin'];
	$list_price = $info_price['list_price'];
	$url = st_get_link_with_search(get_permalink(get_the_ID()), array('pick-up-date', 'drop-off-date', 'pick-up-time', 'drop-off-time'), $_GET);
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
        <div class="item-service st-ccv-tour item-service-car">
	        <div class="row item-service-wrapper has-matchHeight">
	            <div class="col-lg-3 col-md-3 col-sm-4 thumb-wrapper">
	                <div class="thumb">
	                    <?php if (!empty($info_price['discount']) and $info_price['discount'] > 0 and $info_price['price'] > 0) { ?>
	                        <?php echo STFeatured::get_sale($info_price['discount']); ?>
	                    <?php } ?>
	                    <div class="service-tag bestseller">
	                        <?php echo STFeatured::get_featured(); ?>
	                    </div>
	                    <a href="<?php echo esc_url($url); ?>">
	                        <?php
	                        if (has_post_thumbnail()) {
	                            the_post_thumbnail(array(450, 417), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive'));
	                        } else {
	                            echo '<img src="' . get_template_directory_uri() . '/img/no-image.png' . '" alt="Default Thumbnail" class="img-responsive" />';
	                        }
	                        ?>
	                    </a>
	                    <!-- <?php echo st_get_avatar_in_list_service(get_the_ID(), 35) ?> -->
	                </div>
	            </div>
	            <div class="col-lg-6 col-md-6 col-sm-5 item-content">
	                <div class="item-content-w">
	                    <?php
	                    $category = get_the_terms(get_the_ID(), 'st_category_cars');
	                    if (!is_wp_error($category) && is_array($category)) {
	                        $category = array_shift($category);
	                        echo '<div class="car-type">' . esc_html($category->name) . '</div>';
	                    }
	                    ?>
	                    <h4 class="service-title"><a href="<?php echo esc_url($url); ?>"><?php echo get_the_title(); ?></a></h4>
	                    <div class="service-review">
	                        <ul class="icon-group text-color booking-item-rating-stars">
	                            <?php
	                            $avg = STReview::get_avg_rate();
	                            echo TravelHelper::rate_to_string($avg);
	                            ?>
	                        </ul>
	                        <?php
	                        $count_review = STReview::count_comment(get_the_ID());
	                        ?>
	                        <span class="review"><?php echo esc_attr($count_review) . ' ' . _n(esc_html__('Review', 'traveler'), esc_html__('Reviews', 'traveler'), $count_review); ?></span>
	                    </div>
	                    <div class="car-equipments clearfix">
	                        <?php
	                        $pasenger = (int)get_post_meta(get_the_ID(), 'passengers', true);
	                        $auto_transmission = get_post_meta(get_the_ID(), 'auto_transmission', true);
	                        $baggage = (int)get_post_meta(get_the_ID(), 'baggage', true);
	                        $door = (int)get_post_meta(get_the_ID(), 'door', true);
	                        ?>
	                        <div class="item" data-toggle="tooltip" title="<?php echo esc_attr__('Passenger', 'traveler') ?>">
	                            <span class="ico"><?php echo TravelHelper::getNewIcon('ico_regular_1', '#1A2B50', '22px', '22px') ?></span>
	                            <span class="text"><?php echo esc_attr($pasenger); ?></span>
	                        </div>
	                        <div class="item" data-toggle="tooltip" title="<?php echo esc_attr__('Gear Shift', 'traveler') ?>">
	                            <span class="ico"><?php echo TravelHelper::getNewIcon('ico_gear_shift', '#1A2B50', '22px', '22px') ?></span>
	                            <span class="text"><?php if ($auto_transmission == 'on') echo esc_html__('Auto', 'traveler'); else echo esc_html__('Manual', 'traveler') ?></span>
	                        </div>
	                        <div class="item" data-toggle="tooltip" title="<?php echo esc_attr__('Baggage', 'traveler') ?>">
	                            <span class="ico"><?php echo TravelHelper::getNewIcon('ico_suite_1', '#1A2B50', '22px', '22px') ?></span>
	                            <span class="text"><?php echo esc_attr($baggage); ?></span>
	                        </div>
	                        <div class="item">
	                            <span class="ico" data-toggle="tooltip" title="<?php echo esc_attr__('Door', 'traveler') ?>"><?php echo TravelHelper::getNewIcon('ico_doors_1', '#1A2B50', '22px', '22px') ?></span>
	                            <span class="text"><?php echo esc_attr($door); ?></span>
	                        </div>
	                    </div>
	                    
	                    <div class="text-small">
	                        <p style="margin-bottom: 10px;">
	                            <?php
	                            $excerpt=get_the_content( );
	                            $excerpt=strip_tags($excerpt);
	                            echo TravelHelper::cutnchar($excerpt,200);
	                            ?>
	                        </p>
	                    </div>
	                </div>
	            </div>
	            <div class="col-lg-3 col-md-3 col-sm-3 section-footer">
	                <div class="service-price">
	                        <span>
	                            <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '10px', '16px'); ?>
	                        </span>
	                    <span class="price">
	                            <?php
	                            echo TravelHelper::format_money($cars_price);
	                            ?>
	                        </span>
	                    <span class="unit">/<?php echo strtolower(STCars::get_price_unit('label')) ?></span>
	                </div>
	                <a href="<?php echo esc_url($url) ?>"
	                   class="btn btn-primary btn-view-more"><?php echo __('VIEW CAR', 'traveler'); ?></a>

	                <?php if (!empty($info_price['discount']) and $info_price['discount'] > 0 and $info_price['price'] > 0) { ?>
	                    <?php echo STFeatured::get_sale($info_price['discount']); ?>
	                <?php } ?>
	            </div>
	        </div>
	    </div>
	</li>

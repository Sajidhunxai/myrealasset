<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User loop wishlist
 *
 * Created by ShineTheme
 *
 */
$price_type = "";
if(!st_check_service_available($data['type'])) {
    $data['type'] = '';
    return;
}
switch ( $data['type'] ) {
	case 'st_hotel':
		$icon_type  = '<i class="fa fa-building-o"></i>';
		$price_type = st_get_language( "night" );
		$price      = STHotel::get_price( $data['id'] );
		break;
	case 'st_rental':
		$icon_type  = '<i class="fa fa-home"></i>';
		$price_type = st_get_language( "night" );
		$price      = get_post_meta( $data['id'], 'price', true );
		$count_sale = get_post_meta( $data['id'], 'discount_rate', true );
		if ( ! empty( $count_sale ) ) {
			$x          = $price;
			$price_sale = $price - $price * ( $count_sale / 100 );
			$price      = $price_sale;
			$price_sale = $x;
		}
		break;
	case 'st_activity':
		$icon_type  = '<i class="fa fa-bolt"></i>';
		$price_type = st_get_language( "activity" );
		$price      = STActivity::get_price_person( $data['id'] );
		$price_sale = $price['adult_new'];
		$price      = $price['adult'];
		break;
	case 'st_tours':
		$icon_type  = '<i class="fa fa-bolt"></i>';
		$price_type = st_get_language( "tour" );
		$price      = STTour::get_price_person( $data['id'] );
		$price_sale = $price['adult_new'];
		$price      = $price['adult'];

		break;
	case 'st_cars':
		$icon_type  = '<i class="fa fa-car"></i>';
		$price_type = st_get_language( 'user_person' );
		$price      = get_post_meta( $data['id'], 'cars_price', true );
		$count_sale = get_post_meta( $data['id'], 'discount', true );
		if ( ! empty( $count_sale ) ) {
			$x          = $price;
			$price_sale = $price - $price * ( $count_sale / 100 );
			$price      = $price_sale;
			$price_sale = $x;
		}
		break;
	case 'cruise':
		$icon_type  = '<i class="fa fa-bolt"></i>';
		$price_type = st_get_language( "night" );
		$price      = get_post_meta( $data['id'], 'price', true );
		$count_sale = get_post_meta( $data['id'], 'discount', true );
		if ( ! empty( $count_sale ) ) {
			$x          = $price;
			$price_sale = $price - $price * ( $count_sale / 100 );
			$price      = $price_sale;
			$price_sale = $x;
		}
		break;
}
?>
<?php
while ( have_posts() ) {
	the_post();
	?>
    <li class="st-item-list post-<?php the_ID() ?>">
            <!-- <span class="booking-item-wishlist-title">
                <?php echo balanceTags( $icon_type ) ?>
	            <?php
	            switch ( $data['type'] ) {
		            case 'st_hotel':
			            echo __( 'Hotel', 'traveler' );
			            break;
		            case 'st_rental':
			            echo __( 'Rental', 'traveler' );
			            break;
		            case 'st_cars':
			            echo __( 'Cars', 'traveler' );
			            break;
		            case 'st_activity':
			            echo __( 'Activity', 'traveler' );
			            break;
		            case 'st_tours':
			            echo __( 'Tours', 'traveler' );
			            break;
		            default:
			            echo esc_html( mb_convert_case( str_ireplace( "st_", "", $data['type'] ), MB_CASE_TITLE, "UTF-8" ) );
			            break;
	            }
	            ?>
                <span><?php st_the_language( "added_on" ) ?>
		            <?php
		            $current_date  = $data['date'];
		            $format        = TravelHelper::getDateFormat();
		            $date_wishlist = date( $format, strtotime( $current_date ) );
		            echo esc_html( $date_wishlist );
		            ?>
                </span>
            </span> -->
        <a data-id="<?php the_ID() ?>" data-type="<?php echo get_post_type( get_the_ID() ) ?>" data-placement="top"
           rel="tooltip" class="btn_remove_wishlist cursor fa fa-times booking-item-wishlist-remove"
           data-original-title="<?php st_the_language( 'remove' ) ?>"></a>
        <div class="spinner user_img_loading ">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
        <div class="item-service st-ccv-tour">
            <div class="row item-service-wrapper has-matchHeight">
                <div class="col-lg-3 col-md-3 col-sm-12 thumb-wrapper col-xs-12">
					<?php
					$img = get_the_post_thumbnail( get_the_ID(), array(
						800,
						600,
						'bfi_thumb' => true
					), array( 'alt' => TravelHelper::get_alt_image( get_post_thumbnail_id() ) ) );
					if ( ! empty( $img ) ) {
						echo balanceTags( $img );
					} else {
						echo '<img width="800" height="600" alt="no-image" class="wp-post-image" src="' . bfi_thumb( ST_TRAVELER_URI . '/img/no-image.png', array(
								'width'  => 800,
								'height' => 600
							) ) . '">';
					}
					?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 item-content col-xs-12">
                	<div class="item-content-w">
	                	<?php if ($address = get_post_meta(get_the_ID(), 'address', TRUE)): ?>
	                        <p class="service-location"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?></p>
	                    <?php endif;?>
	                    <h4 class="service-title"><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h4>
	                    <div class="text-small">
	                        <p style="margin-bottom: 10px;">
	                            <?php
	                            $excerpt=get_the_content( );
	                            $excerpt=strip_tags($excerpt);
	                            echo TravelHelper::cutnchar($excerpt,200);
	                            ?>
	                        </p>
	                    </div>
	                    <div class="service-excerpt">
							<?php echo mb_strimwidth(strip_shortcodes(New_Layout_Helper::cutStringByNumWord(get_the_excerpt(), 12)), 0, 220, '...'); ?>
	                    </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 col-sm-12 section-footer col-xs-12">
                    <?php
                    	if($data['type'] === 'st_hotel'){ ?>
                    		<div class="service-review hidden-xs">
			                    <?php
			                    $count_review = STReview::count_comment(get_the_ID());
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
			                        <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '14px', '18px'); ?>
			                        <?php if(STHotel::is_show_min_price()): ?>
			                            <?php _e("From", 'traveler') ?>
			                        <?php else:?>
			                            <?php _e("Avg", 'traveler') ?>
			                        <?php endif;?>
			                    </span>
			                    <span class="price">
			                        <?php
			                        $price = isset($post->st_price)?$post->st_price:0;
			                        echo TravelHelper::format_money($price);
			                        ?>
			                    </span>
			                    <span class="unit"><?php echo __('/night', 'traveler'); ?></span>
			                </div>
                    	<?php } elseif($data['type'] === 'st_rental') {?>
                    		<div class="service-review hidden-xs">
			                    <?php
			                    $count_review = STReview::count_comment(get_the_ID());
			                    $avg = STReview::get_avg_rate();
			                    ?>
			                    <div class="count-review">
			                        <span class="text-rating"><?php echo TravelHelper::get_rate_review_text($avg, $count_review); ?></span>
			                        <span class="review"><?php echo esc_html($count_review) . ' ' . _n(esc_html__('Review', 'traveler'), esc_html__('Reviews', 'traveler'), $count_review); ?></span>
			                    </div>
			                    <span class="rating"><?php echo esc_html($avg); ?><small>/5</small></span>
			                </div>
			                <div class="service-review hidden-lg hidden-md hidden-sm">
			                    <?php
			                    $count_review = STReview::count_comment(get_the_ID());
			                    $avg = STReview::get_avg_rate();
			                    ?>
			                    <span class="rating"><?php echo esc_html($avg); ?>/5 <?php echo TravelHelper::get_rate_review_text($avg, $count_review); ?></span>
			                    <span class="st-dot"></span>
			                    <span class="review"><?php echo esc_html($count_review) . ' ' . _n(esc_html__('Review', 'traveler'), esc_html__('Reviews', 'traveler'), $count_review); ?></span>
			                </div>
			                <div class="service-price">
			                    <span>
			                        <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '10px', '16px'); ?>
			                        <?php _e("From", 'traveler') ?>
			                    </span>
			                    <span class="price">
			                        <?php
			                        echo TravelHelper::format_money($price);
			                        ?>
			                    </span>
			                    <span class="unit"><?php echo __('/night', 'traveler'); ?></span>
			                </div>
                    	<?php } elseif($data['type'] === 'st_cars') {
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
                    		<?php if ($address = get_post_meta(get_the_ID(), 'address', TRUE)): ?>
		                        <p class="service-location"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?></p>
		                    	<?php endif;?>
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
			                <?php if (!empty($info_price['discount']) and $info_price['discount'] > 0 and $info_price['price'] > 0) { ?>
			                    <?php echo STFeatured::get_sale($info_price['discount']); ?>
			                <?php }
                    	} elseif($data['type'] === 'st_activity') { ?>
                    		<div class="st-center-y">
			                    <div class="service-price">
			                            <span class="price-text">
			                                <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '16px', '16px'); ?>
			                                <span class="fr_text"><?php _e("from", 'traveler') ?></span>
			                            </span>
			                        <span class="price">
			                                <?php
			                                echo STActivity::inst()->get_price_html(get_the_ID());
			                                ?>
			                            </span>
			                    </div>
			                    <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-view-more"><?php echo __('VIEW DETAIL', 'traveler'); ?></a>
			                </div>

			                <?php if(!empty( $info_price['discount'] ) and $info_price['discount']>0 and $info_price['price_new'] >0) { ?>
			                    <?php echo STFeatured::get_sale($info_price['discount']); ?>
			                <?php }
                    	} elseif($data['type'] === 'st_tours') {
			                $duration = get_post_meta( get_the_ID(), 'duration_day', true );
			                ?>
			                <?php
			                if(!empty($duration)) {
			                    ?>
			                    <div class="service-duration hidden-lg hidden-md hidden-sm">
			                        <?php echo TravelHelper::getNewIcon('time-clock-circle-1', '#5E6D77', '17px', '17px'); ?>
			                        <?php echo esc_html($duration); ?>
			                    </div>
			                    <?php
			                }
			                ?>

			                <div class="service-price">
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
			                    <div class="service-duration hidden-xs">
			                        <?php echo TravelHelper::getNewIcon('time-clock-circle-1', '#5E6D77', '17px', '17px'); ?>
			                        <?php echo esc_html($duration); ?>
			                    </div>
			                    <?php
			                }
			                ?>

			                <div class="service-type">
			                    <?php
			                        $tour_type = get_the_terms(get_the_ID(), 'st_tour_type');
			                        if(!empty($tour_type)){
			                            $tour_type_str = $tour_type[0]->name;
			                            echo TravelHelper::getNewIcon('ico_tour_type', '#000000', '17px', '17px', true);
			                            echo esc_html($tour_type_str);
			                        }
			                    ?>
			                </div>

			                <?php if(!empty( $info_price['discount'] ) and $info_price['discount']>0 and $info_price['price_new'] >0) { ?>
			                    <?php echo STFeatured::get_sale($info_price['discount']); ?>
			                <?php }
                    	} else {

                    	}
                    ?>
                </div>
            </div>
        </div>
    </li>
<?php }?>
<?php
wp_reset_query();
wp_reset_postdata();
?>

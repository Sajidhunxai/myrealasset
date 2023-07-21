<?php
global $post;
$transfer = STCarTransfer::inst();


$pickup_date = STInput::get('pick-up-date', date(TravelHelper::getDateFormat()));
$dropoff_date = STInput::get('drop-off-date', date(TravelHelper::getDateFormat(), strtotime("+ 1 day")));

$pickup_date = TravelHelper::convertDateFormatNew($pickup_date);
$dropoff_date = TravelHelper::convertDateFormatNew($dropoff_date);

$pick_up_time = STInput::get('pick-up-time', '12:00 PM');
$drop_off_time = STInput::get('drop-off-time', '12:00 PM');

$transfer_from = (int)STInput::get( 'transfer_from' );
$transfer_to   = (int)STInput::get( 'transfer_to' );
$roundtrip     = STInput::get( 'roundtrip', '' );

$price_type = get_post_meta(get_the_ID(), 'price_type', true);
$pasenger = (int)get_post_meta(get_the_ID(), 'passengers', true);
$auto_transmission = get_post_meta(get_the_ID(), 'auto_transmission', true);
$baggage = (int)get_post_meta(get_the_ID(), 'baggage', true);
$door = (int)get_post_meta(get_the_ID(), 'door', true);
$number_pass = (int)get_post_meta(get_the_ID(), 'num_passenger', true);

?>

<div class="booking-item item item-rental item-service item-service-inner item-car st-border-radius" itemscope itemtype="https://schema.org/RentalCarReservation" data-format="<?php echo TravelHelper::getDateFormatMoment() ?>, hh:mm A" data-date-format="<?php echo TravelHelper::getDateFormatMoment() ?>" data-time-format="hh:mm A"
     data-timepicker="true">
    <form class="row form-booking-car-transfer align-content-around flex-wrap item-service-wrapper has-matchHeight">
        <div class="col-sm-4">
            <div class="featured-image">
                <?php if (!empty($info_price['discount']) and $info_price['discount'] > 0 and $info_price['price'] > 0) { ?>
                    <?php echo STFeatured::get_sale($info_price['discount']); ?>
                <?php } ?>
                <?php if (is_user_logged_in()) { ?>
                    <?php $data = STUser_f::get_icon_wishlist(); ?>
                    <div class="service-add-wishlist login <?php echo ($data['status']) ? 'added' : ''; ?>"
                         data-id="<?php echo get_the_ID(); ?>" data-type="<?php echo get_post_type(get_the_ID()); ?>"
                         title="<?php echo ($data['status']) ? __('Remove from wishlist', 'traveler') : __('Add to wishlist', 'traveler'); ?>">
                        <i class="fa fa-heart"></i>
                        <div class="lds-dual-ring"></div>
                    </div>
                <?php } else { ?>
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
                <a href="#">
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail(array(760, 460), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive', 'itemprop'=>'image'));
                    } else {
                        echo '<img src="' . get_template_directory_uri() . '/img/no-image.png' . '" alt="Default Thumbnail" class="img-responsive" />';
                    }
                    ?>
                </a>
                <?php do_action('st_list_compare_button',get_the_ID(),get_post_type(get_the_ID())); ?>
                <div class="d-block d-sm-none">
                    <?php echo st_get_avatar_in_list_service(get_the_ID(), 70) ?>
                </div>
                
            </div>
        </div>
        <div class="col-sm-5 item-content">
            <div class="h-100 d-flex align-items-center">
                <div class="item-content-w">
                    <?php
                    $category = get_the_terms(get_the_ID(), 'st_category_cars');
                    if (!is_wp_error($category) && is_array($category)) {
                        $category = array_shift($category);
                        echo '<div class="car-type">' . esc_html($category->name) . '</div>';
                    }
                    ?>
                    <h4 class="service-title" itemprop="name"><?php echo get_the_title(); ?></h4>
                    <div class="service-review d-flex d-sm-none d-md-none">
                        <ul class="icon-group  text-color booking-item-rating-stars">
                            <?php
                            $avg = STReview::get_avg_rate();
                            echo TravelHelper::rate_to_string($avg);
                            ?>
                        </ul>
                        <?php
                        $count_review = STReview::count_comment(get_the_ID());
                        ?>
                        <span class="review"><?php echo esc_html($count_review) . ' ' . _n(esc_html__('Review', 'traveler'), esc_html__('Reviews', 'traveler'), $count_review); ?></span>
                    </div>
                    <div class="car-equipments amenities clearfix">
                        <span class="amenity amenity-car" data-bs-toggle="tooltip" title="<?php echo esc_attr__('Passenger', 'traveler') ?>">
                            <span class="ico"><?php echo TravelHelper::getNewIcon('ico_regular_1', '#1A2B50', '22px', '22px') ?></span>
                            <span class="text"><?php echo esc_attr($pasenger); ?></span>
                        </span>
                        <span class="amenity amenity-car" data-bs-toggle="tooltip" title="<?php echo esc_attr__('Gear Shift', 'traveler') ?>">
                            <span class="ico"><?php echo TravelHelper::getNewIcon('ico_gear_shift', '#1A2B50', '22px', '22px') ?></span>
                            <span class="text"><?php if ($auto_transmission == 'on') echo esc_html__('Auto', 'traveler'); else echo esc_html__('Manual', 'traveler') ?></span>
                        </span>
                        <span class="amenity amenity-car" data-bs-toggle="tooltip" title="<?php echo esc_attr__('Baggage', 'traveler') ?>">
                            <span class="ico"><?php echo TravelHelper::getNewIcon('ico_suite_1', '#1A2B50', '22px', '22px') ?></span>
                            <span class="text"><?php echo esc_attr($baggage); ?></span>
                        </span>
                        <span class="amenity amenity-car">
                            <span class="ico" data-bs-toggle="tooltip" title="<?php echo esc_attr__('Door', 'traveler') ?>"><?php echo TravelHelper::getNewIcon('ico_doors_1', '#1A2B50', '22px', '22px') ?></span>
                            <span class="text"><?php echo esc_attr($door); ?></span>
                        </span>
                    </div>
                    <?php
                    $show_avatar = st()->get_option('avatar_in_list_service', 'off');
                    if ($show_avatar == 'on') {
                        ?>
                        <div class="service-author">
                            <?php echo st_get_avatar_in_list_service(get_the_ID(), 70) ?>
                            <p class="name">
                                <?php
                                $post_author_id = get_post_field('post_author', get_the_ID());
                                echo trim(TravelHelper::get_username($post_author_id));
                                ?>
                            </p>
                        </div>
                    <?php } ?>
                    <div class="booking-item-features booking-item-features-small clearfix mt20">
                        <div class="st-choose-datetime">
                            <a class="st_click_choose_datetime" type="button"
                                data-target="#st_click_choose_datetime" aria-expanded="false"
                                aria-controls="st_click_choose_datetime">
                                <?php echo __('Choose Pickup time', 'traveler'); ?> <i class="fa fa-angle-down arrow"></i>
                            </a>
                        </div>
                        <?php
                        //$passenger = (int)STInput::get( 'passengers', 1 );
                        $extra_price = get_post_meta(get_the_ID(), 'extra_price', true);
                        if(!empty($extra_price) and is_array($extra_price)){
                        ?>
                        <div class="sroom-extra-service">
                            <a class="st_click_choose_service" type="button"
                                    data-target="#extra-service-sroom-<?php echo get_the_ID(); ?>" aria-expanded="false"
                                    aria-controls="extra-service-sroom-<?php echo get_the_ID(); ?>">
                                <?php echo __('Extra services ', 'traveler'); ?> <i class="fa fa-angle-down arrow"></i>

                            </a>

                            <div class="st-tooltip" id="extra-service-sroom-<?php echo get_the_ID(); ?>">
                                    <div class="st-modal-dialog">
                                        <?php $extra = STInput::request("extra_price");
                                        if (!empty($extra['value'])) {
                                            $extra_value = $extra['value'];
                                        }
                                        ?>
                                        <div class="st-close-button text-right">
                                            <i class="fas fa-times"></i>
                                        </div>
                                        <div class="st-modal-content">
                                            <table class="table" style="table-layout: fixed;">
                                                <?php $inti = 0; ?>
                                                <?php foreach ($extra_price as $key => $val): ?>
                                                    <tr class="<?php echo ($inti > 4) ? 'extra-collapse-control extra-none' : '' ?>">
                                                        <td width="70%">
                                                            <label for="field-<?php echo esc_html($val['extra_name']); ?>"
                                                                class="ml20 mt5"><?php echo esc_html($val['title']) . ' (' . TravelHelper::format_money($val['extra_price']) . ')'; ?></label>
                                                            <input type="hidden"
                                                                name="extra_price[price][<?php echo esc_html($val['extra_name']); ?>]"
                                                                value="<?php echo esc_html($val['extra_price']); ?>">
                                                            <input type="hidden"
                                                                name="extra_price[title][<?php echo esc_html($val['extra_name']); ?>]"
                                                                value="<?php echo esc_html($val['title']); ?>">
                                                            <input type="hidden"
                                                            name="extra_price[extra_required][<?php echo esc_html($val['extra_name']); ?>]"
                                                    value="<?php echo esc_html($val['extra_required']); ?>">
                                                        </td>
                                                        <td>
                                                            <select
                                                                    class="form-control app extra-service-select"
                                                                    name="extra_price[value][<?php echo esc_html($val['extra_name']); ?>]"
                                                                    id="field-<?php echo esc_html($val['extra_name']); ?>"
                                                                    data-extra-price="<?php echo esc_html($val['extra_price']); ?>">
                                                                <?php
                                                                $max_item = intval($val['extra_max_number']);
                                                                if ($max_item <= 0) $max_item = 1;
                                                                for ($i = 0; $i <= $max_item; $i++):
                                                                    $check = "";
                                                                    if (!empty($extra_value[$val['extra_name']]) and $i == $extra_value[$val['extra_name']]) {
                                                                        $check = "selected";
                                                                    }
                                                                    ?>
                                                                    <option <?php echo esc_html($check) ?>
                                                                            value="<?php echo esc_html($i); ?>"><?php echo esc_html($i); ?></option>
                                                                <?php endfor; ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <?php $inti++; endforeach; ?>
                                                <?php if (count($extra_price) > 5) {
                                                    echo '<tr><td colspan="2" class="extra-collapse text-center"><a href="#"><i class="fa fa-angle-double-down"></i></a></td></tr>';
                                                } ?>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                            if($price_type === 'passenger'){ ?>
                                <div class="sroom-passenger">
                                    <a class="st_click_choose_passenger" type="button"
                                            data-target="#extra-service-passenger-<?php echo get_the_ID(); ?>" aria-expanded="false"
                                            aria-controls="extra-service-passenger-<?php echo get_the_ID(); ?>">
                                        <?php echo __('Passenger ', 'traveler'); ?> <i class="fa fa-angle-down arrow"></i>

                                    </a>
                                    <div class="st-tooltip" id="extra-service-passenger-<?php echo get_the_ID(); ?>">
                                        <div class="st-modal-dialog">
                                            <div class="st-close-button text-right">
                                                <i class="fas fa-times"></i>
                                            </div>
                                            <div class="st-modal-content">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo __('Passenger', 'traveler');?></label>
                                                <?php
                                                    if (!empty($number_pass)) {
                                                        echo '<select name="passengers" class="form-control">';
                                                    for ($number_pas = 1; $number_pas <= $number_pass ; $number_pas++) {
                                                            echo '<option value="'.esc_attr($number_pas).'">'.esc_html($number_pas).'</option>';
                                                        }
                                                        echo "</select>";
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        ?>
                        <?php
                            $journey_car = get_post_meta(get_the_ID(), 'journey', true);
                            $sr_carstrander = new STCarTransfer();
                            $get_transfer = $sr_carstrander->get_transfer(get_the_ID(),$transfer_from, $transfer_to);
                            if(isset( $get_transfer->has_return)){
                                $return_car = $get_transfer->has_return;
                            } else {
                                $return_car = 'no';
                            }


                            if(!empty($return_car) && ($return_car === 'yes')){ ?>
                                <div class="sroom-return">
                                    <a class="st_click_choose_return" type="button"
                                            data-target="#extra-service-return-<?php echo get_the_ID(); ?>" aria-expanded="false"
                                            aria-controls="extra-service-return-<?php echo get_the_ID(); ?>">
                                        <?php echo __('Return ', 'traveler'); ?> <i class="fa fa-angle-down arrow"></i>

                                    </a>
                                    <div class="st-tooltip" id="extra-service-return-<?php echo get_the_ID(); ?>">
                                        <div class="st-modal-dialog">
                                            <div class="st-close-button text-right">
                                                <i class="fas fa-times"></i>
                                            </div>
                                            <div class="st-modal-content">
                                                <div class="form-group">
                                                    <label class="control-label"><?php echo __('Return', 'traveler');?></label>
                                                    <div class="input-group">
                                                        <span><input type="radio" name="return_car"  value="yes"> <?php echo __('Yes', 'traveler');?> </span><br>
                                                        <span><input type="radio" name="return_car" checked value="no"> <?php echo __('No', 'traveler');?> </span><br>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php }
                        ?>
                         
                    </div>
                </div>
            </div>
            
        </div>
        <div class="col-sm-3 section-footer">
            <div class="h-100 footer-flex d-flex align-content-between flex-wrap">
                <div class="reviews d-block d-sm-none d-md-none">
                    <?php
                    $count_review = STReview::count_comment(get_the_ID());
                    $avg = STReview::get_avg_rate();
                    ?>
                    <span class="rating"><?php echo esc_html($avg); ?>/5 <?php echo TravelHelper::get_rate_review_text($avg, $count_review); ?></span>
                    <span class="st-dot"></span>
                    <span class="review"><?php echo esc_html($count_review) . ' ' . _n(esc_html__('Review', 'traveler'), esc_html__('Reviews', 'traveler'), $count_review); ?></span>
                </div>
                <div class="price-wrapper">
                    <div class="price-booking">
                        <span>
                            <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '10px', '16px'); ?>
                        </span>
                        <span class="price">
                            <?php
                            $minmax = STAdminCars::inst()->get_min_max_price_transfer( get_the_ID() );
                            echo TravelHelper::format_money( $minmax[ 'min_price' ] ) 
                            ?>
                        </span>
                        <span class="unit">/<?php echo esc_html($transfer->get_transfer_unit( get_the_ID() )); ?></span>
                    </div>
                    
                    <div class="show-detail">
                        <input type="hidden" name="transfer_from" value="<?php echo esc_attr( $transfer_from ); ?>">
                        <input type="hidden" name="transfer_to" value="<?php echo esc_attr( $transfer_to ); ?>">
                        <input type="hidden" name="roundtrip" value="<?php echo esc_attr( $roundtrip ); ?>">
                        <input type="hidden" name="start" value="<?php echo esc_attr( $pickup_date ); ?>">
                        <input type="hidden" name="start-time" value="<?php echo esc_attr( $pick_up_time ); ?>">
                        <input type="hidden" name="end" value="<?php echo esc_attr( $dropoff_date ); ?>">
                        <input type="hidden" name="end-time" value="<?php echo esc_attr( $drop_off_time ); ?>">
                        <input type="hidden" name="action" value="add_to_cart_transfer">
                        <input type="hidden" name="car_id" value="<?php echo get_the_ID(); ?>">
                        <div class="service-price-book">
                            <input type="submit" name="booking_car_transfer" class="btn btn-primary btn-book_cartransfer" value="<?php echo __( 'Book Now', 'traveler' ); ?>">
                        </div>


                        <?php if (!empty($info_price['discount']) and $info_price['discount'] > 0 and $info_price['price'] > 0) { ?>
                            <?php echo STFeatured::get_sale($info_price['discount']); ?>
                        <?php } ?>
                    </div>
                    
                </div>
            </div>
            
        </div>
    </form>
    <div class="message alert alert-danger" role="alert"></div>
</div>
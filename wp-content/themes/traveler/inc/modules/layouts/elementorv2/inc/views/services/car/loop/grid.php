<?php
$url = st_get_link_with_search(get_permalink(), array('location_id_pick_up', 'location_id_drop_off','pick-up','drop-off','pick-up-date', 'drop-off-date', 'pick-up-time', 'drop-off-time'), $_REQUEST);
$pickup_date = STInput::get('pick-up-date');
$dropoff_date = STInput::get('drop-off-date');

$pickup_date = TravelHelper::convertDateFormat($pickup_date);
$dropoff_date = TravelHelper::convertDateFormat($dropoff_date);

$pick_up_time = STInput::get('pick-up-time', '12:00 PM');
$drop_off_time = STInput::get('drop-off-time', '12:00 PM');

$info_price = STCars::get_info_price(get_the_ID(), strtotime($pickup_date), strtotime($dropoff_date));
$cars_price = $info_price['price'];
$count_sale = $info_price['discount'];
$price_origin = $info_price['price_origin'];
$list_price = $info_price['list_price'];
$post_id = get_the_ID();
$post_translated = TravelHelper::post_translated($post_id);
$thumbnail_id = get_post_thumbnail_id($post_translated);


$info_price = STCars::get_info_price();
$class_image = 'image-feature st-hover-grow';

?>
<div class="services-item grid item-elementor" itemscope itemtype="https://schema.org/RentalCarReservation">
    <div class="item service-border st-border-radius">
        <div class="featured-image">
            <div class="st-tag-feature-sale">
               
                <?php
                $is_featured = get_post_meta($post_translated, 'is_featured', true);
                if ($is_featured == 'on') { ?>
                    <div class="featured">
                        <?php 
                            if(!empty(st()->get_option('st_text_featured', ''))){
                                echo esc_html(st()->get_option('st_text_featured', ''));
                            } else {?>
                                <?php echo esc_html__('Featured', 'traveler') ?>
                            <?php }
                        ?>
                    </div>
                <?php } ?>
                <?php if(!empty( $info_price['discount'] ) and $info_price['discount']>0 and $info_price['price'] >0) { ?>
                    <?php echo STFeatured::get_sale($info_price['discount']); ?>
                <?php } ?>
            </div>
            <?php if (is_user_logged_in()) { ?>
                <?php $data = STUser_f::get_icon_wishlist(); ?>
                <div class="service-add-wishlist login <?php echo ($data['status']) ? 'added' : ''; ?>"
                     data-id="<?php echo get_the_ID(); ?>" data-type="<?php echo get_post_type(get_the_ID()); ?>"
                     title="<?php echo ($data['status']) ? __('Remove from wishlist', 'traveler') : __('Add to wishlist', 'traveler'); ?>">
                    <?php echo TravelHelper::getNewIconV2('wishlist');?>
                    <div class="lds-dual-ring"></div>
                </div>
            <?php } else { ?>
                <a href="#" class="login" data-bs-toggle="modal" data-bs-target="#st-login-form">
                    <div class="service-add-wishlist" title="<?php echo __('Add to wishlist', 'traveler'); ?>">
                        <?php echo TravelHelper::getNewIconV2('wishlist');?>
                        <div class="lds-dual-ring"></div>
                    </div>
                </a>
            <?php } ?>
            <a href="<?php echo esc_url($url); ?>">
                <img itemprop="image" src="<?php echo wp_get_attachment_image_url($thumbnail_id, array(450, 300)); ?>"
                     alt="<?php echo get_the_title(); ?>" class="<?php echo esc_attr($class_image); ?>"/>
            </a>
            <?php do_action('st_list_compare_button', get_the_ID(), get_post_type(get_the_ID())); ?>
            <?php echo st_get_avatar_in_list_service(get_the_ID(),70)?>
        </div>
        <div class="content-item">
            <?php
            $category = get_the_terms(get_the_ID(), 'st_category_cars');
            if (!is_wp_error($category) && is_array($category)) {
                $category = array_shift($category);
                echo '<div class="car-type plr15">' . esc_html($category->name) . '</div>';
            }
            ?>
            <h3 class="title" itemprop="name">
                <a href="<?php echo esc_url($url); ?>"
                   class="c-main"><?php echo get_the_title($post_translated) ?></a>
            </h3>
            <div class="car-equipments d-flex align-items-center justify-content-start clearfix">
                <?php
                $pasenger = (int)get_post_meta(get_the_ID(), 'passengers', true);
                $auto_transmission = get_post_meta(get_the_ID(), 'auto_transmission', true);
                $baggage = (int)get_post_meta(get_the_ID(), 'baggage', true);
                $door = (int)get_post_meta(get_the_ID(), 'door', true);
                ?>
                <div class="item d-flex flex-column" data-bs-toggle="tooltip" title="<?php echo esc_attr__('Passenger', 'traveler') ?>">
                    <span class="ico"><i class="stt-icon-user2"></i></span>
                    <span class="text text-center"><?php echo esc_attr($pasenger); ?></span>
                </div>
                <div class="item d-flex flex-column" data-bs-toggle="tooltip" title="<?php echo esc_attr__('Gear Shift', 'traveler') ?>">
                    <span class="ico"><i class="<?php if ($auto_transmission == 'on') { echo 'stt-icon-automatic';} else { echo 'stt-icon-manual';} ?>"></i></span>
                    <span class="text text-center">
                        <?php if ($auto_transmission == 'on') {
                        echo esc_html__('auto', 'traveler');
                    } else{
                        echo esc_html__('manual', 'traveler');
                    }  ?></span>
                </div>
                <div class="item d-flex flex-column" data-bs-toggle="tooltip" title="<?php echo esc_attr__('Baggage', 'traveler') ?>">
                    <span class="ico"><i class="stt-icon-baggage"></i></span>
                    <span class="text text-center"><?php echo esc_attr($baggage); ?></span>
                </div>
                <div class="item d-flex flex-column" data-bs-toggle="tooltip" title="<?php echo esc_attr__('Door', 'traveler') ?>">
                    <span class="ico">
                        <i class="stt-icon-car-door"></i>
                    </span>
                    <span class="text text-center"><?php echo esc_attr($door); ?></span>
                </div>
            </div>
            <div class="section-footer">
               
                <div class="price-wrapper d-flex align-items-center" itemprop="totalPrice">
                    <span class="price">
                        <?php
                        echo TravelHelper::format_money($cars_price);
                        ?>
                    </span>
                    <span class="unit"><?php echo ' / '.  strtolower(STCars::get_price_unit('label')) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>


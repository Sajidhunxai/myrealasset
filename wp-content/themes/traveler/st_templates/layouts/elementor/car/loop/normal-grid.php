<?php
global $post;
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


if (!empty($item_row)) {              
    $class = 'col-12 col-sm-6 col-md-'.(12 / $item_row).' col-lg-' . (12 / $item_row);
}else {
    $class='col-12 col-sm-6 col-md-4 col-lg-4';
}
$class_image='image-feature';
if( !empty($slider) && $slider === 'slider'){
    $class = 'swiper-slide';
    $class_image = 'swiper-lazy';
}
if(!empty($top_search)){
    $class='col-12 col-sm-6 col-md-3 col-lg-3';
}
?>
<div class="item item-tours item-rental item-car <?php echo esc_attr($class); ?>" itemscope itemtype="https://schema.org/RentalCarReservation">
    <div class="service-border st-border-radius">
        <div class="featured-image">
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
            <a href="<?php echo esc_url($url); ?>" itemprop="url">
                <?php
                if (has_post_thumbnail()) {
                    the_post_thumbnail(array(760, 460), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive', 'itemprop'=>'image'));
                } else {
                    echo '<img src="' . get_template_directory_uri() . '/img/no-image.png' . '" alt="Default Thumbnail" class="img-responsive" />';
                }
                ?>
            </a>
            <?php do_action('st_list_compare_button',get_the_ID(),get_post_type(get_the_ID())); ?>
            <?php echo st_get_avatar_in_list_service(get_the_ID(), 70) ?>
        </div>
        
        <div class="content-item">
            <?php
            $category = get_the_terms(get_the_ID(), 'st_category_cars');
            if (!is_wp_error($category) && is_array($category)) {
                $category = array_shift($category);
                echo '<div class="car-type plr15">' . esc_html($category->name) . '</div>';
            }
            ?>
            <h3 class="title" itemprop="name"><a href="<?php echo esc_url($url); ?>"><?php echo get_the_title(); ?></a></h3>
            <div class="car-equipments amenities clearfix">
                <?php
                $pasenger = (int)get_post_meta(get_the_ID(), 'passengers', true);
                $auto_transmission = get_post_meta(get_the_ID(), 'auto_transmission', true);
                $baggage = (int)get_post_meta(get_the_ID(), 'baggage', true);
                $door = (int)get_post_meta(get_the_ID(), 'door', true);
                ?>
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
            <div class="section-footer">
                <div class="footer-inner plr15">
                    <?php
                    $duration = get_post_meta(get_the_ID(), 'duration_day', true);
                    if (!empty($duration)) {
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
                        </span>
                        <span class="price">
                            <?php
                            echo TravelHelper::format_money($cars_price);
                            ?>
                        </span>
                        <span class="unit">/<?php echo strtolower(STCars::get_price_unit('label')) ?></span>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

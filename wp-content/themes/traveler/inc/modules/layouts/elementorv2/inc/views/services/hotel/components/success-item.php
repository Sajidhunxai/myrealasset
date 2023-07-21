<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * hotel payment item row
 *
 * Created by ShineTheme
 *
 */
$order_token_code = STInput::get('order_token_code');

if ($order_token_code) {
    $order_code = STOrder::get_order_id_by_token($order_token_code);
}

$hotel_id = $key;

$object_id = $key;
$total = 0;
$room_id = $data['data']['room_id'];

$check_in = $data['data']['check_in'];

$check_out = $data['data']['check_out'];

$date_diff = STDate::dateDiff($check_in,$check_out);

$adult_number = intval($data['data']['adult_number']);
$child_number = intval($data['data']['child_number']);

$number_room = intval($data['number']);

$data_prices = get_post_meta($order_id, 'data_prices', true);

$price = floatval($data_prices['origin_price']);

$hotel_link = '';
if (isset($hotel_id) and $hotel_id) {
    $hotel_link = get_permalink($hotel_id);
}
$currency = get_post_meta($order_code, 'currency', true);

$extras = isset($data['data']['extras']) ? $data['data']['extras'] : array();
$extra_type = isset($data['data']['extra_type']) ? $data['data']['extra_type'] : 'perday';
?>
<?php if (isset($hotel_id) and $hotel_id): ?>
    <div class="service-section">
        <div class="service-left">
            <a href="<?php echo esc_url($hotel_link) ?>">
                <?php echo get_the_post_thumbnail($hotel_id, array(140, 110, 'bfi_thumb' => true), array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id($hotel_id)), 'class' => 'img-responsive')); ?>
            </a>
        </div>
        <div class="service-right">
            <h3 class="title"><a href="<?php echo esc_url($hotel_link) ?>"><?php echo get_the_title($hotel_id) ?></a>
            </h3>
            <?php
            $address = get_post_meta($hotel_id, 'address', true);
            if ($address):
                ?>
                <p class="address"><?php echo esc_html($address); ?> </p>
            <?php
            endif;
            ?>
        </div>
    </div>
<?php endif; ?>
<div class="room-type">
    <span class="label"><?php echo __('Room type:', 'traveler'); ?></span>
    <span class="value"><a href="<?php echo get_the_permalink($room_id) ?>"><?php echo get_the_title($room_id)?></a></span>
</div>
<div class="info-section">
    <h4 class="info-heading"><?php echo esc_html__('Your trip', 'traveler'); ?></h4>
    <ul>
        <?php
        $theme_option = st()->get_option('partner_show_contact_info');
        $metabox = get_post_meta($hotel_id, 'show_agent_contact_info', true);
        $use_agent_info = FALSE;
        if ($theme_option == 'on') $use_agent_info = true;
        if ($metabox == 'user_agent_info') $use_agent_info = true;
        if ($metabox == 'user_item_info') $use_agent_info = FALSE;
        $obj_hotel = get_post($hotel_id);
        $user_id = $obj_hotel->post_author;
        ?>
        <?php if (isset($hotel_id) and $hotel_id): ?>
            <?php if ($use_agent_info) {
                $agent_email = get_the_author_meta('user_email', $user_id);
                $agent_phone = get_user_meta($user_id, 'st_phone', true);
                ?>
                <?php if(!empty($agent_email)){ ?>
                    <li><span class="label"><?php st_the_language('booking_email') ?></span><span
                            class="value"><?php echo esc_html($agent_email) ?></span></li>
                <?php } ?>
                <?php if(!empty($agent_phone)){ ?>
                    <li><span class="label"><?php st_the_language('booking_phone') ?></span><span
                            class="value"><?php echo esc_html($agent_phone) ?></span></li>
                <?php } ?>
            <?php } else {
                $hotel_email = get_post_meta($hotel_id, 'email', true);
                $hotel_phone = get_post_meta($hotel_id, 'phone', true);
                ?>
                <?php if(!empty($agent_phone)){ ?>
                    <li><span class="label"><?php st_the_language('booking_email') ?></span><span
                            class="value"><?php echo esc_html($hotel_email) ?></span></li>
                <?php } ?>
                <?php if(!empty($agent_phone)){ ?>
                    <li><span class="label"><?php st_the_language('booking_phone') ?></span><span
                            class="value"><?php echo esc_html($hotel_phone) ?></span></li>
                <?php } ?>
            <?php } ?>
        <?php endif; ?>
        <li>
            <span class="label">
                <?php echo esc_html__('Date', 'traveler'); ?>
            </span>
            <span class="value">
                <?php echo date(TravelHelper::getDateFormat(), strtotime($check_in)); ?>
                -
                <?php echo date(TravelHelper::getDateFormat(), strtotime($check_out)); ?>
            </span>
        </li>

        <li class="ad-info">
            <ul>
                <li>
                    <span class="label"><?php echo esc_html__('Number of Night', 'traveler'); ?></span>
                    <span class="value"><?php echo esc_html($date_diff) ?></span>
                </li>
                <?php if($adult_number) {?>
                    <li>
                        <span class="label"><?php echo esc_html__('Adults', 'traveler'); ?></span>
                        <span class="value"><?php echo esc_attr($adult_number); ?></span>
                    </li>
                <?php } ?>
                <?php if($child_number) {?>
                    <li>
                        <span class="label"><?php echo esc_html__('Children', 'traveler'); ?></span>
                        <span class="value"><?php echo esc_attr($child_number); ?></span>
                    </li>
                <?php } ?>
                <li>
                    <span class="label"><?php echo esc_html__('Room', 'traveler'); ?></span>
                    <span class="value"><?php echo esc_html($number_room);?></span>
                </li>
            </ul>
        </li>

        <li class="guest-value">
            <?php st_print_order_item_guest_name($data['data']) ?>
        </li>
    </ul>
</div>

<div class="price-details">
    <h5><?php echo __('Price details', 'traveler'); ?></h5>
    <div class="item">
            <span class="label">
                <?php echo sprintf(_n('%s night', '%s nights', $date_diff, 'traveler'), $date_diff) ?>
            </span>
        <span class="value">
                <?php echo TravelHelper::format_money_from_db($price, $currency); ?>
            </span>
    </div>
    <?php
    $check_extra = false;
    if(!empty($extras["value"]) && is_array(array_values($extras["value"]))){
        foreach(array_values($extras["value"]) as $value_number){
            if($value_number > 0){
                $check_extra = true;
                break;
            }
        }
    }

    if($check_extra) :
        ?>
        <div class="extra-prices">
            <?php
            foreach ($extras['value'] as $name => $number):
                $number_item = intval($extras['value'][$name]);
                if ($number_item <= 0) $number_item = 0;
                if ($number_item > 0):
                    $price_item = floatval($extras['price'][$name]);
                    if ($price_item <= 0) $price_item = 0;
                    ?>
                    <div class="item">
                        <span class="label">
                            <?php echo esc_html($extras['title'][$name]) . ' x ' . esc_html($number_item) . ' ' . esc_html__('(Extra)', 'traveler') ?>
                        </span>
                        <span class="value">
                            <?php
                            $calc_extra_price = 0;
                            if($extra_type == 'perday') {
                                $calc_extra_price = $price_item * $number_item * $date_diff * $number_room;
                            }else{
                                $calc_extra_price = $price_item * $number_item * $number_room;
                            }
                            ?>
                            <?php echo TravelHelper::format_money_from_db($calc_extra_price, $currency) ?>
                        </span>
                    </div>
                <?php endif;
            endforeach;
            ?>
        </div>
    <?php endif; ?>
    <?php
    if(isset($item['data']['deposit_money'])):
        $deposit      = $item['data']['deposit_money'];
        if(!empty($deposit['type']) and !empty($deposit['amount'])){
            $deposite_amount = '';
            $deposite_type = '';
            switch($deposit['type']){
                case "percent":
                    $deposite_amount = $deposit['amount'] . ' %';
                    $deposite_type = __('percent', 'traveler');
                    break;
                case "amount":
                    $deposite_amount = TravelHelper::format_money($deposit['amount']);
                    $deposite_type = __('amount', 'traveler');
                    break;
            } ?>
            <li>
                    <span class="label">
                        <?php echo esc_html(__('Deposit','traveler')) ?>
                        <?php echo ' '. esc_html($deposite_type) ?>
                    </span>
                <span class="value pull-right">
                        <?php
                        echo esc_html($deposite_amount);
                        ?>
                    </span>
            </li>
        <?php }
    endif; ?>
</div>
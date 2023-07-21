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
  $item = $data;
  $item_id = $item['data']['st_booking_id'];
  $extras = isset($item['data']['data_equipment']) ? $item['data']['data_equipment'] : array();
    ?>
<div class="service-section">
    <div class="service-left">
        <h3 class="title"><a href="<?php echo get_permalink($item_id) ?>"><?php echo get_the_title($item_id) ?></a></h3>
        <?php
        $address = get_post_meta($item_id, 'cars_address', true);
        if ($address):
            ?>
            <p class="address"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?> </p>
        <?php
        endif;
        ?>
    </div>
    <div class="service-right">
        <?php echo get_the_post_thumbnail($item_id, array(110, 110, 'bfi_thumb' => true), array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id($item_id)), 'class' => 'img-responsive')); ?>
    </div>
</div>
<div class="info-section">
    <ul>
        <li>
                <span class="label">
                    <?php echo __('Car type', 'traveler'); ?>
                </span>
            <span class="value">
                     <?php
                     $cartype = get_the_terms($item_id, 'st_category_cars');
                     if (!is_wp_error($cartype) && !empty($cartype)) {
                         $cartype_html = '';
                         foreach ($cartype as $type) {
                             $cartype_html .= $type->name . ', ';
                         }
                         if (!empty($cartype_html)) {
                             echo substr($cartype_html, 0, -2);
                         }
                     }
                     ?>
                </span>
        </li>
        <!--Add Info-->
        <li>
            <span class="label"><?php echo __('Pick Up From', 'traveler'); ?></span>
            <span class="value"><?php echo esc_html($item['data']['pick_up']); ?></span>
        </li>
        <li>
            <span class="label"><?php echo __('Drop Off To', 'traveler'); ?></span>
            <span class="value"><?php echo esc_html($item['data']['drop_off']); ?></span>
        </li>
        <li>
            <span class="label"><?php echo __('Est. Distance', 'traveler'); ?></span>
            <span class="value"><?php echo round($item['data']['data_destination'], 2); ?> <?php echo strtolower(STCars::get_price_unit('label')) ?></span>
        </li>
        <li>
            <span class="label"><?php echo __('Date', 'traveler'); ?></span>
            <span class="value"><?php echo date(TravelHelper::getDateFormat() . ', H:i A', $item['data']['check_in_timestamp']); ?> - <?php echo date(TravelHelper::getDateFormat() . ', H:i A', $item['data']['check_out_timestamp']); ?></span>
        </li>
        <?php
        if($item['data']['has_return'] === 'yes'){
            echo '<li>
                    <span class="label">'. __("Direction Price", 'traveler').'</span>
                    <span class="value">'.TravelHelper::format_money($item_id['data']['price']).'</span>
                </li>';
            echo '<li>
                <span class="label">'. __("Towards Price", 'traveler').'</span>
                <span class="value">'.TravelHelper::format_money($item_id['data']['price_return']).'</span>
            </li>';
        }
        /*diff date*/
        /*$date1 = strtotime(date(TravelHelper::getDateFormat() . ', H:i ', $item['data']['check_in_timestamp']));
        $date2 = strtotime(date(TravelHelper::getDateFormat() . ', H:i ', $item['data']['check_out_timestamp']));
        $diff = abs($item['data']['check_out_timestamp'] - $item['data']['check_in_timestamp']);
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24)
                       / (30*60*60*24));
        $days_extra = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));*/
        $days_extra = $item['data']['numberday'];
        ?>
        <?php if (isset($extras['value']) && is_array($extras['value']) && count($extras['value'])): ?>
            <li>
                <span class="label"><?php echo __('Extra', 'traveler'); ?></span>
            </li>
            <li class="extra-value">
                <?php
                foreach ($extras['value'] as $name => $number):
                    $number_item = intval($extras['value'][$name]);
                    if ($number_item <= 0) $number_item = 0;
                    if ($number_item > 0):
                        $price_item = floatval($extras['price'][$name]);
                        if ($price_item <= 0) $price_item = 0;
                        $price_type = $extras['price_type'][$name];
                        ?>
                        <span class="pull-right">
                            <?php
                            if($price_type == 'fixed'){
                                echo esc_html($extras['title'][$name]) . ' (' . TravelHelper::format_money($price_item) . ') x ' . esc_attr($number_item) . ' ' . __('Item(s)', 'traveler');
                            }else{
                                echo esc_html($extras['title'][$name]) . ' (' . TravelHelper::format_money($price_item) . ') x ' . esc_html($number_item) . ' ' . __('Item(s)', 'traveler'). ' x '.esc_html($days_extra).' '. __('Day(s)', 'traveler');
                            }

                            ?>
                            </span> <br/>
                    <?php endif;
                endforeach;
                ?>
            </li>
        <?php endif; ?>
    </ul>
</div>
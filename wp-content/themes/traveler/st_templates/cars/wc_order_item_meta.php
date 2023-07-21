<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 14/07/2015
 * Time: 3:17 CH
 */
$item_data = isset($item['item_meta']) ? $item['item_meta'] : array();
$numberdays = $item_data['_st_numberday'];
$pick_up_time = isset($item_data['_st_check_in_time']) ? $item_data['_st_check_in_time'] : "";
$drop_off_time = isset($item_data['_st_check_out_time']) ? $item_data['_st_check_out_time'] : "";

?>
<ul class="wc-order-item-meta-list">
    <?php if(isset($item_data['_st_price_unit'])):?>
        <li>
            <span class="meta-label"><?php _e('Price Unit:','traveler') ?></span>
            <span class="meta-data"><?php echo STCars::get_price_unit_by_unit_id($item_data['_st_price_unit']) ?></span>
        </li>
    <?php endif;?>

    <?php if(isset($item_data['_st_pick_up']) and $item_data['_st_pick_up']){?>
    <li>
        <span class="meta-label"><?php _e('Pick-up:','traveler') ?></span>
        <span class="meta-data"><?php
            if($item_data['_st_pick_up']){
                echo esc_html($item_data['_st_pick_up']);
            }

             ?></span>
    </li>
    <?php

    }?>

    <?php if(isset($item_data['_st_drop_off']) and $item_data['_st_drop_off']){?>
    <li>
        <span class="meta-label"><?php _e('Drop-off:','traveler') ?></span>
        <span class="meta-data"><?php
            if($item_data['_st_drop_off']){
                echo esc_html($item_data['_st_drop_off']);
            }
            ?>
        </span>
    </li>
    <?php

    }?>

    <?php if(isset($item_data['_st_check_in_timestamp'])):?>
    <li>
        <span class="meta-label"><?php _e('Date:','traveler') ?></span>
        <span class="meta-data"><?php echo date_i18n(TravelHelper::getDateFormat().' '.get_option('time_format'),$item_data['_st_check_in_timestamp']); ?>
            <?php if(isset($item_data['_st_check_out_timestamp'])){?>
                <i class="fa fa-long-arrow-right"></i>
                <?php echo date_i18n(TravelHelper::getDateFormat().' '.get_option('time_format'),$item_data['_st_check_out_timestamp']); ?>
            <?php }?>
        </span>
    </li>
    <?php endif;?>
    <?php

     if(isset($item_data['_st_data_equipment'])):

        $selected_equipment=$item_data['_st_data_equipment'];
        if($selected_equipment and $selected_equipment=maybe_unserialize($selected_equipment)){
            if(is_array($selected_equipment) and !empty($selected_equipment)){
                ?>
                <li>
                    <span class="meta-label"><?php _e('Equipments:','traveler') ?></span>
                    <span class="meta-data">
                        <br>
                            <?php
                            $new_layout = st()->get_option('st_theme_style', 'modern');
                            if ( isset($new_layout) && $new_layout === 'classic' ) :
                                foreach($selected_equipment as $key => $item){
                                    $title = isset($item->title) ? $item->title : '';
                                    $price_item = isset($item->price) ? floatval($item->price) : 0;
                                    if ($price_item <= 0) {
                                        $price_item = 0;
                                    }
                                    $number_item = isset($item->number_item) ? intval($item->number_item) : 0;

                                    $price_type = isset($item->price_unit) ? $item->price_unit : '';

                                    if ($number_item <= 0){
                                        $number_item = 0;
                                    }
                                    if ($number_item) { ?>
                                        <span style="padding-left: 10px ">
                                            <?php
                                            if($price_type == 'fixed'){
                                                echo esc_attr($title) . ": " . esc_attr($number_item) . ' x <b>' . TravelHelper::format_money($price_item) . '</b>';
                                            }else{
                                                echo esc_attr($title) . ": " . esc_attr($number_item) . ' x <b>' . TravelHelper::format_money($price_item) . '</b>' .' x '.esc_html($numberdays).' '. __('Day(s)', 'traveler');
                                            }
                                            ?>
                                        </span><br/>
                                    <?php
                                    }
                                }
                            else :
                                foreach($selected_equipment['title'] as $key=>$title){
                                    $price_item = floatval($selected_equipment['price'][$key]);
                                    if ($price_item <= 0) {
                                        $price_item = 0;
                                    }
                                    $number_item = intval($selected_equipment['value'][$key]);

                                    $price_type = $selected_equipment['price_type'][$key];

                                    if ($number_item <= 0){
                                        $number_item = 0;
                                    }
                                    if ($number_item) { ?>
                                        <span style="padding-left: 10px ">
                                            <?php
                                            if($price_type == 'fixed'){
                                                echo esc_attr($title) . ": " . esc_attr($number_item) . ' x <b>' . TravelHelper::format_money($price_item) . '</b>';
                                            }else{
                                                echo esc_attr($title) . ": " . esc_attr($number_item) . ' x <b>' . TravelHelper::format_money($price_item) . '</b>' .' x '.esc_html($numberdays).' '. __('Day(s)', 'traveler');
                                            }
                                            ?>
                                        </span><br/>
                                    <?php
                                    }
                                }
                            endif;
                            ?>
                    </span>
                </li>
            <?php
            }
        }
     endif;?>
     <?php if(isset($item_data['_st_sale_price'])):?>
        <li>
            <span class="meta-label"><?php _e('Price:','traveler') ?></span>
            <span class="meta-data"><?php echo TravelHelper::format_money($item_data['_st_sale_price']); ?></span>
            /
            <?php
            $duration = $item_data['_st_duration_unit'] ;
                if ($duration =='day') {
                    if($numberdays == 1){
                        echo __("day" , 'traveler') ;
                    }else{
                        echo sprintf(__('%s days', 'traveler'), $item_data['_st_numberday']);
                    }
                }
                if ($duration =='hour') {echo __("hour" , 'traveler') ; }
                if ($duration == "distance") {
                    $type_distance = st()->get_option( "cars_price_by_distance" , "kilometer" );
                    if($type_distance == "kilometer") {
                        echo __( "kilometer" , 'traveler' );
                    } else {
                        echo __( "mile" , 'traveler' );
                    }
                }
            ?>
        </li>
    <?php endif;?>
    <?php if(isset($item_data['_st_data_destination']) && $item_data['_st_duration_unit'] == 'distance'):?>
        <li>
            <span class="meta-label"><?php _e('Distance:','traveler') ?></span>
            <span class="meta-data"><?php echo TravelHelper::format_money($item_data['_st_data_destination']); ?></span>
            <?php
            $type_distance = st()->get_option( "cars_price_by_distance" , "kilometer" );
            if($type_distance == "kilometer") {
                echo __( "kilometer" , 'traveler' );
            } else {
                echo __( "mile" , 'traveler' );
            }
            ?>
        </li>
    <?php endif;?>
     <?php  if(isset($item_data['_st_discount_rate'])): $data=$item_data['_st_discount_rate'];?>
        <?php  if (!empty($data)) {?><li><p>
            <?php echo __("Discount"  ,'traveler') .": "; ?>
            <?php echo esc_attr($data);?>
        <?php } ;?></p></li>
    <?php endif; ?>


</ul>

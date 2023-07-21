<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 14/07/2015
 * Time: 3:17 CH
 */
$item_data=isset($item['item_meta'])?$item['item_meta']:array();

$format=TravelHelper::getDateFormat();
?>
<ul class="wc-order-item-meta-list">
    <?php if(isset($item_data['_st_room_id'])): $data=$item_data['_st_room_id'];?>
        <li>
            <span class="meta-label"><?php _e('Room:','traveler') ?></span>
            <span class="meta-data"><?php echo sprintf('<a href="%s">%s</a>',get_permalink($data),get_post($data)->post_title) ?></span>
        </li>
    <?php endif;?>
    <?php if(isset($item_data['_st_check_in'])): $data=$item_data['_st_check_in']; ?>
        <li>
            <span class="meta-label"><?php _e('Date:','traveler') ?></span>
            <span class="meta-data"><?php
                echo esc_html($data);
                ?>
                <?php if(isset($item_data['_st_check_out'])){ $data=$item_data['_st_check_out']; ?>
                    <i class="fa fa-long-arrow-right"></i>
                    <?php echo esc_html($data);?>
                <?php }?>
            </span>
        </li>
    <?php endif;?>

    <?php if(isset($item_data['_st_adult_number'])):?>
        <li>
            <span class="meta-label"><?php _e('Adult:','traveler') ?></span>
            <span class="meta-data"><?php echo esc_html($item_data['_st_adult_number']); ?></span>
        </li>
    <?php endif;?>
    <?php if(isset($item_data['_st_child_number'])):?>
        <li>
            <span class="meta-label"><?php _e('Children:','traveler') ?></span>
            <span class="meta-data"><?php echo esc_html($item_data['_st_child_number']); ?></span>
        </li>
    <?php endif;?>
    <?php if(isset($item_data['_st_room_num_search'])): $data=$item_data['_st_room_num_search'];?>
        <?php
        if ( get_post_meta( $item_data['_st_room_id'], 'price_by_per_person', true ) == 'on' ) : ?>
            <li>
                <span class="meta-label"><?php _e('Number of rooms:','traveler') ?></span>
                <span class="meta-data"><?php echo esc_html($item_data['_st_room_num_search']); ?></span>
            </li>
            <?php
            if ( isset($item_data['_st_adult_number']) && intval( $item_data['_st_adult_number'] ) > 0 ) :
                $order_data_id_woo = STUser_f::get_booking_meta($item_data['_st_wc_order_id']);
                $order = wc_get_order( $order_data_id_woo['wc_order_id'] );
                $price_adult = wc_price(intval( floatval($item_data['_st_adult_price'])),array( 'currency' => $order->get_currency()));
                $price_adult_total =  wc_price(intval($item_data['_st_room_num_search']) * intval($item_data['_st_adult_number']) * floatval($item_data['_st_adult_price']),array( 'currency' => $order->get_currency()));

                ?>
                <li>
                    <span class="meta-label"><?php _e('Adult Price:','traveler') ?></span>
                    <span class="meta-price"><?php echo $price_adult_total ?></span>
                </li>
                <?php
            endif; ?>
            <?php
            if ( isset($item_data['_st_child_number']) && intval( $item_data['_st_child_number'] ) > 0 ) :
                $order_data_id_woo = STUser_f::get_booking_meta($item_data['_st_wc_order_id']);
                $order = wc_get_order( $order_data_id_woo['wc_order_id'] );
                $price_child = wc_price(intval( floatval($item_data['_st_child_price'])),array( 'currency' => $order->get_currency()));
                $price_child_total =  wc_price(intval($item_data['_st_room_num_search']) * intval($item_data['_st_adult_number']) * floatval($item_data['_st_child_price']),array( 'currency' => $order->get_currency()));
                ?>
                <li>
                    <span class="meta-label"><?php _e('Child Price:','traveler') ?></span>
                    <span class="meta-price"><?php echo $price_child_total; ?></span>
                </li>
                <?php
            endif; ?>
            <?php
        else : 
            $order_data_id_woo = STUser_f::get_booking_meta($item_data['_st_wc_order_id']);
            $order = wc_get_order( $order_data_id_woo['wc_order_id'] );
            $st_item_price = wc_price(intval( floatval($item_data['_st_item_price'])),array( 'currency' => $order->get_currency()));
            
        ?>
            <li>
                <span class="meta-label"><?php _e('Number of rooms:','traveler') ?></span>
                <span class="meta-data"><?php echo esc_html($item_data['_st_room_num_search']); ?></span>
                x
                <span class="meta-price"><?php echo $st_item_price; ?></span>
            </li>
            <?php
        endif; ?>
    <?php endif;?>
    <?php if(isset($item_data['_st_extras']) and ($extra_price = $item_data['_st_extra_price'])): $data=$item_data['_st_extras'];?>
        <li>
        <p><?php echo __("Extra prices"  ,'traveler') .": "; ?></p>
        <ul>
        <?php
        if(!empty($data['title']) and  is_array($data['title'])){
            foreach ($data['title'] as $key => $title) { ?>
                <?php if($data['value'][$key]){ ?>
                    <li style="padding-left: 10px "> <?php echo esc_attr($title) ;?>:
                    <?php
                        echo esc_html($data['value'][$key]); ?> x <?php echo TravelHelper::format_money($data['price'][$key]) ;
                    ?>
                </li>
                <?php }?>
            <?php }
        }
        ?>
        </ul>
        </li>
    <?php endif; ?>
    <?php  if(isset($item_data['_st_discount_rate'])): $data=st_wc_parse_order_item_meta($item_data['_st_discount_rate']);?>
        <?php  if (!empty($data)) {?><li><p>
            <?php echo __("Discount"  ,'traveler') .": "; ?>
            <?php echo esc_attr($data) ."%";?>
        <?php } ;?></p></li>
    <?php endif; ?>
    <?php  if(isset($item_data['_line_tax'])): $data=st_wc_parse_order_item_meta($item_data['_line_tax']);?>
            <?php  if (!empty($data)) {?><li><p>
            <?php echo __("Tax"  ,'traveler') .": "; ?>
            <?php echo TravelHelper::format_money($data) ;?>
        <?php } ;?></p></li>
    <?php endif; ?>


</ul>

<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 14/07/2015
 * Time: 3:17 CH
 */
$item_data=isset($item['item_meta'])?$item['item_meta']:array();
$format=TravelHelper::getDateFormat();
$data_price =$item_data['_st_data_price'];
?>
<ul class="wc-order-item-meta-list">
    <?php if(isset($item_data['_st_check_in'])): $data=$item_data['_st_check_in']; ?>
        <li>
            <span class="meta-label"><?php _e('Date:','traveler') ?></span>
            <span class="meta-data"><?php
                echo esc_html($data);
                ?>
                <?php if(isset($item_data['_st_check_out'])){ $data=$item_data['_st_check_out']; ?>
                    <i class="fa fa-long-arrow-right"></i>
                    <?php echo esc_html($data); ?>
                <?php }?>
            </span>
        </li>
    <?php endif;?>
    <?php if(isset($item_data['_st_starttime'])): ?>
        <li>
            <span class="meta-label"><?php _e('Start Time:','traveler') ?></span>
            <span class="meta-data">
                <?php
                echo esc_html($item_data['_st_starttime']);
                ?>
            </span>
        </li>
    <?php endif;?>
    <?php if(isset($item_data['_st_price_old'])):?>
        <li>
            <span class="meta-label"><?php _e('Price:','traveler') ?></span>
            <span class="meta-data"><?php echo TravelHelper::format_money($item_data['_st_price_old']) ?></span>
        </li>
    <?php endif;?>

    <?php if(isset($item_data['_st_adult_number']) and  $adult=$item_data[ '_st_adult_number' ] and $adult){?>
        <li>
            <span class="meta-label"><?php echo __( 'Adult number:' , 'traveler' ); ?></span>
            <span class="meta-data">
                <?php echo esc_html($adult);?>
                <?php if(!empty($adult)){?>
                    x
                    <?php echo TravelHelper::format_money($data_price['adult_price']/$adult) ; ?>
                    <i class="fa fa-long-arrow-right"></i>
                    <?php echo TravelHelper::format_money($data_price['adult_price']) ?>
                <?php  } ?>
            </span>
        </li>
    <?php }?>
    <?php if(isset($item_data['_st_child_number']) and $child=$item_data[ '_st_child_number' ] and $child){?>
        <li>
            <span class="meta-label"><?php echo __( 'Children number:' , 'traveler' ); ?></span>
            <span class="meta-data">
                <?php echo esc_html($child)?>
                <?php if(!empty($child)){?>
                    x
                    <?php echo TravelHelper::format_money($data_price['child_price']/$child) ; ?>
                    <i class="fa fa-long-arrow-right"></i>
                    <?php echo TravelHelper::format_money($data_price['child_price']) ?>
                <?php }?>
            </span>
        </li>
    <?php  }?>
    <?php if(isset($item_data['_st_infant_number']) and $infant=$item_data[ '_st_infant_number' ] and $infant){?>
        <li>
            <span class="meta-label"><?php echo __( 'Infant number:' , 'traveler' ); ?></span>
            <span class="meta-data">
                <?php echo esc_html($infant)?>
                <?php if(!empty($infant)){?>
                    x
                    <?php echo TravelHelper::format_money($data_price['infant_price']/$infant) ; ?>
                    <i class="fa fa-long-arrow-right"></i>
                    <?php echo TravelHelper::format_money($data_price['infant_price']) ?>
                <?php }?>
            </span>
        </li>
    <?php  }?>
    <?php if(isset($item_data['_st_extras']) && ($extra_price = $item_data['_st_extra_price'])): $data=$item_data['_st_extras'];?>
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
    <?php
    if(isset($item_data['_st_discount_rate']) && isset($item_data['_st_st_booking_id'])):
        $data=$item_data['_st_discount_rate'];
        if (!empty($data)) {?>
            <li><p> <?php
                echo __("Discount"  ,'traveler') .": ";
                $discount_type = get_post_meta( $item_data['_st_st_booking_id'], 'discount_type', true );
                if ( $discount_type == 'amount' )
                    echo esc_html(TravelHelper::format_money($data));
                else
                    echo esc_html($data. '%');
        } ;?></p></li>
        <?php
    endif; ?>
    <?php  if(isset($item_data['_line_tax'])): $data=$item_data['_line_tax'];?>
            <?php  if (!empty($data)) {?><li><p>
            <?php echo __("Tax"  ,'traveler') .": "; ?>
            <?php echo TravelHelper::format_money($data) ;?>
        <?php } ;?></p></li>
    <?php endif; ?>

</ul>

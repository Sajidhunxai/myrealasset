<?php
/**
 * Created by PhpStorm.
 * User: MSI
 * Date: 03/06/2015
 * Time: 3:53 CH
 */
$div_id = "st_cart_item".md5(json_encode($st_booking_data['cart_item_key']));
?>
<p class="booking-item-description">
    <?php echo __( 'Depart date:' , 'traveler' ); ?>
    <?php echo date_i18n( TravelHelper::getDateFormat() , strtotime( $st_booking_data[ 'depart_date' ] ) ) ?>
</p>
<p class="booking-item-description">
    <?php echo __( 'Arrive date:' , 'traveler' ); ?>
    <?php echo date_i18n( TravelHelper::getDateFormat() , strtotime( $st_booking_data[ 'return_date' ] ) ) ?>
</p>
<?php if(isset($st_booking_data['depart_data_time']['depart_time'])){?>
<p class="booking-item-description">
    <?php echo __( 'Depart Time:' , 'traveler' ); ?>
    <?php echo esc_html($st_booking_data['depart_data_time']['depart_time']); ?>
</p>
<?php }?>
<?php if(isset($st_booking_data['depart_data_time']['arrive_time'])){?>
    <p class="booking-item-description">
        <?php echo __( 'Arrive Time:' , 'traveler' ); ?>
        <?php echo esc_html($st_booking_data['return_data_time']['arrive_time']); ?>
    </p>
<?php } 
    if(isset($st_booking_data['flight_type']) && ($st_booking_data['flight_type'] === 'return')){ ?>
        <div class='cart_border_bottom'></div>
        <p class="booking-item-title"><?php echo __( 'Return' , 'traveler' ); ?> </p>
        <p class="booking-item-description">
            <?php echo __( 'Depart date:' , 'traveler' ); ?>
            <?php echo date_i18n( TravelHelper::getDateFormat() , strtotime( $st_booking_data[ 'depart_date' ] ) ) ?>
        </p>
        <p class="booking-item-description">
            <?php echo __( 'Arrive date:' , 'traveler' ); ?>
            <?php echo date_i18n( TravelHelper::getDateFormat() , strtotime( $st_booking_data[ 'return_date' ] ) ) ?>
        </p>
        <?php if(isset($st_booking_data['return_data_time']['depart_time'])){?>
            <p class="booking-item-description">
                <?php echo __( 'Depart Time:' , 'traveler' ); ?>
                <?php echo esc_html($st_booking_data['return_data_time']['depart_time']); ?>
            </p>
        <?php }?>
        <?php if(isset($st_booking_data['return_data_time']['arrive_time'])){?>
            <p class="booking-item-description">
                <?php echo __( 'Arrive Time:' , 'traveler' ); ?>
                <?php echo esc_html($st_booking_data['return_data_time']['arrive_time']); ?>
            </p>
        <?php }?>
    <?php }
?>

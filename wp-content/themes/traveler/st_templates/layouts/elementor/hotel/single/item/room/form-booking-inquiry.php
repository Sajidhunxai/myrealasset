<div class="form-book-wrapper st-border-radius">
    <?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
    <div class="form-head">
        <?php
        if ( $price_by_per_person == 'on' ) :
            echo __('from ', 'traveler');
            echo sprintf( '<span class="price">%s</span>', TravelHelper::format_money($sale_price) );
            echo '<span class="unit">';
            echo sprintf( _n( '/person', '/%d persons', $total_person, 'traveler' ), $total_person );
            echo sprintf( _n( '/night', '/%d nights', $numberday, 'traveler' ), $numberday );
            echo '</span>';
        else:
            echo __('from ', 'traveler');
            echo sprintf( '<span class="price">%s</span>', TravelHelper::format_money($sale_price) );
            echo '<span class="unit">';
            echo sprintf( _n( '/night', '/%d nights', $numberday, 'traveler' ), $numberday );
            echo '</span>';
        endif; ?>
    </div>
    <h4 class="title-enquiry-form"><?php echo esc_html__('Inquiry', 'traveler'); ?></h4>
    <?php echo st()->load_template( 'email/email_single_service' ); ?>
    <form id="form-booking-inpage" class="form single-room-form hotel-room-booking-form" method="post">
        <input name="action" value="hotel_add_to_cart" type="hidden">
        <input name="item_id" value="<?php echo esc_attr($hotel_id); ?>" type="hidden">
        <input name="room_id" value="<?php echo esc_attr($room_id); ?>" type="hidden">
        <?php wp_nonce_field( 'room_search', 'room_search' ) ?>
        <input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID();?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
    </form>
</div>
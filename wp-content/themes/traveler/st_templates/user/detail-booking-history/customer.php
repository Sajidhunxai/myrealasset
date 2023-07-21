<div class="info">
    <div class="row">
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('First name ' , 'traveler') ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_first_name', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('Last name ' , 'traveler') ; ?></strong>:
                <?php echo get_post_meta($order_id, 'st_last_name', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('Email ' , 'traveler') ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_email', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('Phone ' , 'traveler') ;  ?></strong>:
                <?php $country_code = get_post_meta($order_id, 'st_country_code', true);
                if(!empty($country_code)){
                    $st_phone = $country_code . get_post_meta($order_id, 'st_phone', true);
                    echo esc_html($st_phone);
                }else{
                     echo get_post_meta($order_id, 'st_phone', true) ;
                }

                ?>

            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('Address Line 1' , 'traveler' ) ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_address', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('Address Line 2' , 'traveler' ) ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_address2', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('City' , 'traveler') ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_city', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('State/Province/Region' , 'traveler') ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_province', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('ZIP code/Postal code' , 'traveler') ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_zip_code', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('Country' , 'traveler') ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_country', true) ?>
            </div>
        </div>
        <div class="col-md-12">
            <div class="item_booking_detail">
                <strong><?php echo __('Special Requirements' , 'traveler') ;  ?></strong>:
                <?php echo get_post_meta($order_id, 'st_note', true) ?>
            </div>
        </div>
    </div>

</div>

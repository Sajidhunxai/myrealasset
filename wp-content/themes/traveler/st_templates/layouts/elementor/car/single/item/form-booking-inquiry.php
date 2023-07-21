<div class="form-book-wrapper st-border-radius relative">
    <?php echo st()->load_template('layouts/elementor/common/loader'); ?>
    <div class="form-head">
        <?php echo wp_kses(sprintf(__('<span class="price">%s</span><span class="unit">/%s</span>', 'traveler'), TravelHelper::format_money($cars_price), strtolower(STCars::get_price_unit('label'))), ['span' => ['class' => []]]) ?>
    </div>

    <h4 class="title-enquiry-form"><?php echo esc_html__('Inquiry', 'traveler'); ?></h4>
    <?php echo st()->load_template( 'email/email_single_service' ); ?>
    <form id="form-booking-inpage" method="post" action="#booking-request" class="activity-booking-form">
        <input type="hidden" name="action" value="activity_add_to_cart">
        <input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
        <?php
        $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
        $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));

        $start    = STInput::request( 'check_in', date( TravelHelper::getDateFormat(), strtotime($current_calendar) ) );
        $end      = STInput::request( 'check_out', date( TravelHelper::getDateFormat(), strtotime($current_calendar) ) );
        $date = STInput::request('date', date('d/m/Y h:i a', strtotime($current_calendar)). '-'. date('d/m/Y h:i a', strtotime($current_calendar)));
        ?>

        <input type="hidden" class="check-in-input"
                value="<?php echo esc_attr( $start ) ?>" name="check_in">
        <input type="hidden" class="check-out-input"
                value="<?php echo esc_attr( $end ) ?>" name="check_out">
        <input type="hidden" class="check-in-out-input"
                value="<?php echo esc_attr( $date ) ?>" name="check_in_out"
                data-action="st_get_availability_activity_frontend"
                data-tour-id="<?php the_ID(); ?>" data-posttype="st_activity">
        <?php
        /*Starttime*/
        $starttime_value = STInput::request('starttime_tour', '');
        ?>

        <div class="form-group form-more-extra st-form-starttime" <?php echo ($starttime_value != '') ? '' : 'style="display: none"' ?>>
            <input type="hidden" data-starttime="<?php echo esc_attr($starttime_value); ?>"
                    data-checkin="<?php echo esc_attr($start); ?>" data-checkout="<?php echo esc_attr($end); ?>"
                    data-tourid="<?php echo get_the_ID(); ?>" id="starttime_hidden_load_form" data-posttype="st_activity"/>
        </div>
        <input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID();?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
    </form>
</div>
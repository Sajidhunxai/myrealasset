<?php if(empty($activity_external) || $activity_external == 'off'){ ?>
    <?php echo st()->load_template('layouts/elementor/common/loader'); ?>
    <div class="st-form-booking-action">
        <form id="form-booking-inpage" method="post" action="#booking-request" class="tour-booking-form activity-booking-form form-has-guest-name">
            <div class="st-group-form">
                <input type="hidden" name="action" value="activity_add_to_cart">
                <input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
                <input type="hidden" name="type_activity"
                        value="<?php echo esc_attr($activity_type); ?>">
                        
                <div class="search-form">
                    <?php echo stt_elementorv2()->loadView('services/activity/single/item/form-book/date'); ?>
                    <?php echo stt_elementorv2()->loadView('services/activity/single/item/form-book/guest'); ?>
                </div>
                <?php echo stt_elementorv2()->loadView('services/activity/single/item/form-book/guest-name'); ?>
            </div>
            
            <?php echo stt_elementorv2()->loadView('services/activity/single/item/form-book/extra'); ?>
            <div class="total-price-book d-flex justify-content-between align-items-center">
                <div id="total-text">
                    <h5><?php echo esc_html__('Total','traveler');?></h5>
                </div>
                <div id="total-value">
                    <div class="st-price-origin form-head d-flex align-self-end">
                        <h5>
                            <?php
                            echo wp_kses(sprintf(__(' <span class="price d-flex align-content-end flex-column">%s</span>', 'traveler'), TravelHelper::format_money( 0 )), ['span' => ['class' => []]]); ?>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="submit-group">
                <button class="text-center btn-v2 btn-primary btn-book-ajax"
                        type="submit"
                        name="submit"><?php echo esc_html__('Book now', 'traveler') ?><i class="fa fa-spinner fa-spin d-none"></i></button>
                <input style="display:none;" type="submit"
                        class="btn btn-default btn-send-message"
                        data-id="<?php echo get_the_ID(); ?>" name="st_send_message"
                        value="<?php echo __('Send message', 'traveler'); ?>">
            </div>
            <div class="message-wrapper mt30"></div>
        </form>
    </div>
<?php } else {?>
    <div class="submit-group mb30">
        <a href="<?php echo esc_url($activity_external_link); ?>" class="btn btn-green btn-large btn-full upper"><?php echo esc_html__( 'Explore', 'traveler' ); ?></a>
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

            <input type="text" class="check-in-input"
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
<?php }?>
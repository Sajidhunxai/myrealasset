<div class="form-book-wrapper st-border-radius relative">
    <?php if ( !empty( $info_price[ 'discount' ] ) and $info_price[ 'discount' ] > 0 and $info_price[ 'price_new' ] > 0 ) { ?>
        <div class="tour-sale-box">
            <?php echo STFeatured::get_sale( $info_price[ 'discount' ] ); ?>
        </div>
    <?php } ?>
    <?php echo st()->load_template( 'layouts/elementor/common/loader' ); ?>
    <div class="form-head">
        <div class="price">
            <span class="label">
                <?php _e( "from", 'traveler' ) ?>
            </span>
            <span class="value">
            <?php
            echo STActivity::inst()->get_price_html( get_the_ID() );
            ?>
        </span>
        </div>
    </div>
    <nav>
        <ul class="nav nav-tabs nav-fill-st" id="nav-tab" role="tablist">
            <li><a id="nav-book-tab"  class="active" data-bs-toggle="tab" href="#nav-book" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo esc_html__( 'Book', 'traveler' ) ?></a></li>
            <li><a id="nav-inquirement-tab" data-bs-toggle="tab" href="#nav-inquirement" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo esc_html__( 'Inquiry', 'traveler' ) ?></a></li>
        </ul>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-book" role="tabpanel" aria-labelledby="nav-book-tab">
            <?php if(empty($activity_external) || $activity_external == 'off'){ ?>
                <form id="form-booking-inpage" method="post" action="#booking-request" class="activity-booking-form form-has-guest-name">
                    <input type="hidden" name="action" value="activity_add_to_cart">
                    <input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
                    <?php
                    $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
                    $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));

                    $start    = STInput::request( 'check_in', date( TravelHelper::getDateFormat(), strtotime($current_calendar) ) );
                    $end      = STInput::request( 'check_out', date( TravelHelper::getDateFormat(), strtotime($current_calendar) ) );
                    $date = STInput::request('date', date('d/m/Y h:i a', strtotime($current_calendar)). '-'. date('d/m/Y h:i a', strtotime($current_calendar)));
                    $has_icon = ( isset( $has_icon ) ) ? $has_icon : false;
                    ?>
                    <div class="form-group form-date-field form-date-search clearfix <?php if ( $has_icon ) echo ' has-icon '; ?>"
                            data-format="<?php echo TravelHelper::getDateFormatMoment() ?>" data-availability-date="<?php echo esc_attr($current_calendar_reverb); ?>">
                        <?php
                        if ( $has_icon ) {
                            echo TravelHelper::getNewIcon( 'ico_calendar_search_box' );
                        }
                        ?>
                        <div class="date-wrapper d-flex align-items-center justify-content-between">
                            <div class="check-in-wrapper">
                                <label><?php echo __( 'Date', 'traveler' ); ?></label>
                                <div class="render check-in-render"><?php echo esc_html($start); ?></div>
                                <?php
                                $class_hidden_enddate = 'hidden';
                                $activity_type = get_post_meta(get_the_ID(), 'type_activity', true);
                                if($activity_type != 'daily_activity' && (strtotime($end) - strtotime($start)) > 0 ){
                                    $class_hidden_enddate = '';
                                }
                                ?>
                                <span class="sts-tour-checkout-label <?php echo esc_html($class_hidden_enddate); ?>"><span> - </span><div class="render check-out-render"><?php echo esc_html($end); ?></div></span>
                            </div>
                            <i class="fa fa-angle-down arrow"></i>
                        </div>
                        <input type="text" class="check-in-input"
                                value="<?php echo esc_attr( $start ) ?>" name="check_in">
                        <input type="hidden" class="check-out-input"
                                value="<?php echo esc_attr( $end ) ?>" name="check_out">
                        <input type="text" class="check-in-out-input"
                                value="<?php echo esc_attr( $date ) ?>" name="check_in_out"
                                data-action="st_get_availability_activity_frontend"
                                data-tour-id="<?php the_ID(); ?>" data-posttype="st_activity">
                    </div>

                    <?php
                    /*Starttime*/
                    $starttime_value = STInput::request('starttime_tour', '');
                    ?>

                    <div class="form-group form-more-extra st-form-starttime" <?php echo ($starttime_value != '') ? '' : 'style="display: none"' ?>>
                        <input type="hidden" data-starttime="<?php echo esc_attr($starttime_value); ?>"
                                data-checkin="<?php echo esc_attr($start); ?>" data-checkout="<?php echo esc_attr($end); ?>"
                                data-tourid="<?php echo get_the_ID(); ?>" id="starttime_hidden_load_form" data-posttype="st_activity"/>
                        <div class="" id="starttime_box">
                            <label><?php echo __('Start time', 'traveler'); ?></label>
                            <select class="form-control st_tour_starttime" name="starttime"
                                    id="starttime_tour"></select>
                        </div>
                    </div>
                    <!--End starttime-->

                    <?php echo st()->load_template( 'layouts/elementor/activity/elements/search/single/guest', '' ); ?>
                    <?php echo st()->load_template( 'layouts/elementor/activity/elements/search/single/extra', '' ); ?>
                    <div class="submit-group">
                        <button class="btn btn-large btn-full upper btn-book-ajax"
                                type="submit"
                                name="submit">
                            <?php echo esc_html__( 'Book Now', 'traveler' ) ?>
                            <i class="fa fa-spinner fa-spin d-none"></i>
                        </button>
                        <input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID();?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
                    </div>
                    <div class="message-wrapper mt30">
                        <!-- <?php echo STTemplate::message() ?> -->
                    </div>
                </form>
            <?php }else{ ?>
                <div class="submit-group mb30">
                    <a href="<?php echo esc_url($activity_external_link); ?>" class="btn btn-large btn-full upper"><?php echo esc_html__( 'Explore', 'traveler' ); ?></a>
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
            <?php } ?>
        </div>
        <div class="tab-pane fade " id="nav-inquirement" role="tabpanel" aria-labelledby="nav-inquirement-tab">
            <?php echo st()->load_template( 'email/email_single_service' ); ?>
        </div>
    </div>
</div>
<?php
    $current_calendar = TravelHelper::get_current_available_calendar(TravelHelper::post_origin(get_the_ID(), 'st_tours'));
    $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));

    $start = STInput::request('start', date(TravelHelper::getDateFormat(), strtotime($current_calendar)));
    $end = STInput::request('end', date(TravelHelper::getDateFormat(), strtotime($current_calendar)));
    $time_checkin =  strtotime(date(TravelHelper::getDateFormat(), strtotime($start))); 
    if(!empty(st_get_date_checkin_checkout_groupday_tour(get_the_ID(),  $time_checkin  ))){
        $timestamp_end = st_get_date_checkin_checkout_groupday_tour(get_the_ID(),$time_checkin)[0]['check_out'];
        $end = STInput::request('end', date(TravelHelper::getDateFormat(), $timestamp_end));
    }
    $date     = STInput::request( 'date', date( 'd/m/Y h:i a' ) . '-' . date( 'd/m/Y h:i a', strtotime( '+1 day' ) ) );
    $has_icon = ( isset( $has_icon ) ) ? $has_icon : false;
    $current_calendar = TravelHelper::get_current_available_calendar(TravelHelper::post_origin(get_the_ID(), 'st_tours'));
    $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));
?>
<div class="form-group form-date-field st-search-date-tour st-single-tour-search form-date-search d-flex align-items-center" data-format="<?php echo TravelHelper::getDateFormatMoment() ?>"
data-availability-date="<?php echo esc_attr($current_calendar_reverb); ?>">
    <?php
        if ( $has_icon ) {
            echo TravelHelper::getNewIcon( 'ico_calendar_search_box' );
        }
    ?>
    <div class="date-wrapper d-flex  justify-content-between align-items-center">
        <div class="check-in-wrapper">
            <?php
            $class_hidden_enddate = 'd-none';
            $style_font = '';
            $activity_type = get_post_meta(get_the_ID(), 'type_activity', true);
            if($activity_type != 'daily_activity' && (strtotime($end) - strtotime($start)) > 0 ){
                $style_font = 'style="font-size:14px;"';
                $class_hidden_enddate = '';
            }
            ?>
            <label><?php echo __( 'Date', 'traveler' ); ?></label>
            <div class="d-flex align-items-center" <?php echo !empty($style_font) ? esc_attr($style_font) : '';?>>
                <div class="render check-in-render"><?php echo esc_html($start); ?></div>
                
                <span class="sts-tour-checkout-label d-flex align-items-center <?php echo esc_html($class_hidden_enddate); ?>"><span> - </span><div class="render check-out-render"><?php echo esc_html($end); ?></div></span>
            </div>
            
            
        </div>
        <i class="stt-icon-arrow-down"></i>
    </div>
    <input type="hidden" class="check-in-input"
            value="<?php echo esc_attr($start) ?>" name="check_in">
    <input type="hidden" class="check-out-input"
            value="<?php echo esc_attr($end) ?>" name="check_out">
    <input type="text" class="check-in-out-input"
            value="<?php echo esc_attr($date) ?>" name="check_in_out"
            data-action="st_get_availability_activity_frontend"
            data-tour-id="<?php the_ID(); ?>" data-posttype="st_activity">
</div>

<?php
/*Starttime*/
$starttime_value = STInput::request('starttime_tour', '');
$current_calendar = date(TravelHelper::getDateFormat(), strtotime($current_calendar));
$list_time = AvailabilityHelper::_get_starttime_tour_frontend_by_date(get_the_ID(),$current_calendar,$current_calendar,'st_activity');
?>
<div class="form-group form-more-extra st-form-starttime" 
    <?php if(!empty($list_time['data']) && !empty($list_time['data'][0])){
        echo "";
    } else {
        echo 'style="display: none"';
    }?>>
    <input type="hidden" data-starttime="<?php echo esc_attr($starttime_value); ?>"
        data-checkin="<?php echo esc_attr($start); ?>"
        data-checkout="<?php echo esc_attr($end); ?>"
        data-tourid="<?php echo get_the_ID(); ?>"
        id="starttime_hidden_load_form"  data-posttype="st_tours"/>
    <div class="starttime_box" id="starttime_box">
        <label><?php echo __('Start time', 'traveler'); ?></label>
        <select class="form-control st_tour_starttime" name="starttime_tour"
                id="starttime_tour">
            <?php if(!empty($list_time['data']) && !empty($list_time['data'][0])){ 
                $name = count($list_time['data']) > 1 ? __('vacancies', 'traveler') : __('a vacancy', 'traveler');
                foreach($list_time['data'] as $key=>$time){if(intval($list_time['check'][$key]) > 0){
                    $num_vacancies = intval($list_time['check'][$key]);
                } else {
                    $num_vacancies = esc_html__('Unlimited','traveler');
                }
                ?>
                <option value="<?php echo esc_attr($time);?>"><?php echo esc_attr($time);?> ( <?php echo esc_html($num_vacancies);?> <?php echo esc_html($name);?> )</option>
            <?php 
                }
            }?>    
        </select>
    </div>
</div>
<!--End starttime-->
<?php
$time_format = st()->get_option('time_format', '12h');
$string_time_format_js = 'hh:mm A';
$string_time_format = 'h:i A';
if ($time_format === '24h') {
    $string_time_format_js = 'HH:mm';
    $string_time_format = 'H:i';
}

$pick_up_date = STInput::request('pick-up-date', "");
$pick_up_time = STInput::request('pick-up-time', date($string_time_format));
$drop_off_date = STInput::request('drop-off-date', "");
$drop_off_time = STInput::request('drop-off-time', date($string_time_format));
$date_time = $pick_up_date.' '.$pick_up_time.'-'.$drop_off_date.' '.$drop_off_time;
$date_time_default = date('d/m/Y h:i a') . '-' . date('d/m/Y h:i a');
if(!empty($pick_up_date)){
    $date_time = $date_time;
} else {
    $date_time = $date_time_default;
}
$date = STInput::request('date', $date_time);
$has_icon = (isset($has_icon)) ? $has_icon : false;

if(!empty($pick_up_date)){
    $pick_up_datetext = $pick_up_date;
    $pick_up_date = $pick_up_date;
} else {
    $pick_up_datetext = esc_html__('Add date, Add time', 'traveler');
    $pick_up_date = "";
}

if(!empty($drop_off_date)){
    $drop_off_datetext = $drop_off_date;
    $drop_off_date = $drop_off_date;
} else {
    $drop_off_datetext = esc_html__('Add date, Add time', 'traveler');
    $drop_off_date = "";
}
?>
<div class="form-group form-date-field form-date-search d-flex align-items-center" 
    data-format="<?php echo TravelHelper::getDateFormatMoment() ?>, <?php echo esc_attr($string_time_format_js) ?>" data-date-format="<?php echo TravelHelper::getDateFormatMoment() ?>" data-time-format="<?php echo esc_attr($string_time_format_js) ?>"
    data-timepicker="true" data-label-start-time="<?php echo __('Pick-up', 'traveler') ?>"
    data-label-end-time="<?php echo __('Drop-off', 'traveler') ?>"
>
    <div class="date-item-wrapper d-flex align-items-center checkin">
        <span class="stt-icon stt-icon-in"></span>
        <div class="item-inner">
            <label><?php echo esc_html__('Pick-up', 'traveler'); ?></label>
            <div class="render check-in-render"><?php echo esc_html($pick_up_datetext); ?></div>
        </div>
    </div>
    <span class="stt-icon stt-icon-arrow-right-1 date-item-arrow"></span>
    <div class="date-item-wrapper d-flex align-items-center checkout">
        <span class="stt-icon stt-icon-out"></span>
        <div class="item-inner">
            <label><?php echo esc_html__('Drop-off', 'traveler'); ?></label>
            <div class="render check-out-render"><?php echo esc_html($drop_off_datetext); ?></div>
        </div>
    </div>
    <input type="hidden" class="check-in-input" value="<?php echo esc_attr($pick_up_date) ?>" name="pick-up-date">
    <input type="hidden" class="check-in-input-time" value="<?php echo esc_attr($pick_up_time) ?>" name="pick-up-time">
    <input type="hidden" class="check-out-input" value="<?php echo esc_attr($drop_off_date) ?>" name="drop-off-date">
    <input type="hidden" class="check-out-input-time" value="<?php echo esc_attr($drop_off_time) ?>"
           name="drop-off-time">
    <input type="text" class="check-in-out" value="<?php echo esc_attr($date); ?>" name="date">
</div>
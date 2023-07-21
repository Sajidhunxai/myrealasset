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
    $pick_up_datetext = TravelHelper::getDateFormatMomentText();
    $pick_up_date = "";
}

if(!empty($drop_off_date)){
    $drop_off_datetext = $drop_off_date;
    $drop_off_date = $drop_off_date;
} else {
    $drop_off_datetext = TravelHelper::getDateFormatMomentText();
    $drop_off_date = "";
}
?>
<div class="form-group form-extra-field form-date-field form-date-search form-date-car clearfix <?php if ($has_icon) echo ' has-icon '; ?>"
     data-format="<?php echo TravelHelper::getDateFormatMoment() ?>, <?php echo esc_attr($string_time_format_js) ?>" data-date-format="<?php echo TravelHelper::getDateFormatMoment() ?>" data-time-format="<?php echo esc_attr($string_time_format_js) ?>"
     data-timepicker="true" data-label-start-time="<?php echo __('Pick Up Time', 'traveler') ?>"
     data-label-end-time="<?php echo __('Return Time', 'traveler') ?>">
    <?php
    if ($has_icon) {
        echo TravelHelper::getNewIcon('ico_calendar_search_box');
    }
    ?>
    <div class="date-wrapper clearfix">
        <div class="check-in-wrapper">
            <label><?php echo __('Pick Up Time', 'traveler'); ?></label>
            <div class="render check-in-render"><?php echo esc_html($pick_up_datetext) . ', '. esc_html($pick_up_time); ?></div>
        </div>
        <div class="check-out-wrapper">
            <label><?php echo __('Return Time', 'traveler'); ?></label>
            <div class="render check-out-render"><?php echo esc_html($drop_off_datetext).', '. esc_html($drop_off_time); ?></div>
            <span>
        </div>
    </div>
    <input type="hidden" class="check-in-input" value="<?php echo esc_attr($pick_up_date) ?>" name="pick-up-date">
    <input type="hidden" class="check-in-input-time" value="<?php echo esc_attr($pick_up_time) ?>" name="pick-up-time">
    <input type="hidden" class="check-out-input" value="<?php echo esc_attr($drop_off_date) ?>" name="drop-off-date">
    <input type="hidden" class="check-out-input-time" value="<?php echo esc_attr($drop_off_time) ?>"
           name="drop-off-time">
    <input type="text" class="check-in-out" value="<?php echo esc_attr($date); ?>" name="date">
</div>

<?php
$start = STInput::get('start', "");
$end = STInput::get('end', "");
$date = STInput::get('date', date('d/m/Y h:i a') . '-' . date('d/m/Y h:i a', strtotime('+1 day')));
$has_icon = (isset($has_icon)) ? $has_icon : false;
$extraClass = '';
$blog_style = st()->get_option('blog_list_style_modern', 1);
if ($blog_style == 2) {
    $extraClass = ' date-popup-solo ';
}
if (!empty($start)) {
    $starttext = $start;
    $start = $start;
} else {
    $starttext = TravelHelper::getDateFormatMomentText();
    $start = "";
}

if (!empty($end)) {
    $endtext = $end;
    $end = $end;
} else {
    $endtext = TravelHelper::getDateFormatMomentText();
    $end = "";
}
?>
<div data-custom-class="search-datepicker" class=" form-group form-date-field form-date-search-new clearfix <?php echo esc_html($extraClass); ?> <?php if ($has_icon) echo ' has-icon '; ?>" data-format="<?php echo TravelHelper::getDateFormatMoment() ?>">
    <?php
    if ($has_icon) {
        echo TravelHelper::getNewIcon('ico_calendar_search_box');
    }
    ?>
    <div class="date-wrapper clearfix">
        <div class="check-in-wrapper">


            <div class="st-render">
                <div class="render check-in-render"><?php if (empty($start)) { ?>
                        <label class="st-date-text"><?php echo esc_html__('When', 'traveler'); ?></label>
                        <?php
                    } else {
                        echo esc_html($start) . esc_html__(" -", 'traveler');
                    }
                    ?>
                </div>
                <div class="render check-out-render"><?php echo esc_html($end); ?></div>
            </div>
        </div>
    </div>
    <input type="hidden" class="check-in-input" value="<?php echo esc_attr($start) ?>" name="start">
    <input type="hidden" class="check-out-input" value="<?php echo esc_attr($end) ?>" name="end">
    <input type="text" class="check-in-out" value="<?php echo esc_attr($date); ?>" name="date">
</div>
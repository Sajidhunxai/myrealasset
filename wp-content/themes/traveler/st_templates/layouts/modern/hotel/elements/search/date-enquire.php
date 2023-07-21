<?php
$start = STInput::get('start', date(TravelHelper::getDateFormat()));
$end = STInput::get('end', date(TravelHelper::getDateFormat(), strtotime("+ 1 day")));
$date = STInput::get('date', date('d/m/Y h:i a'). '-'. date('d/m/Y h:i a', strtotime('+1 day')));
$has_icon = (isset($has_icon))? $has_icon: false;
?>
<div class="form-group form-date-field date-enquire form-date-search clearfix <?php if($has_icon) echo ' has-icon '; ?>" data-format="<?php echo TravelHelper::getDateFormatMoment() ?>">
    <?php
        if($has_icon){
            echo TravelHelper::getNewIcon('ico_calendar_search_box');
        }
    ?>
    <div class="date-wrapper clearfix">
        <div class="check-in-wrapper">
            <ul class="st_grid_date">
                <li>
                    <div class="st-item-date">
                        <label><?php echo __('Check In', 'traveler'); ?></label>
                        <div class="render check-in-render"><?php echo esc_html($start); ?></div>
                    </div>
                </li>
                <li>
                    <div class="st-item-date">
                        <label><?php echo __('Check Out', 'traveler'); ?></label>
                        </span><div class="render check-out-render"><?php echo esc_html($end); ?></div>
                    </div>
                </li>
            </ul>
        </div>
        <input type="hidden" class="check-in-input" value="<?php echo esc_attr($start) ?>" name="start">
        <input type="hidden" class="check-out-input" value="<?php echo esc_attr($end) ?>" name="end">
        <input type="text" class="check-in-out" value="<?php echo esc_attr($date); ?>" name="date">
    </div>
    
</div>
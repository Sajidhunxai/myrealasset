<?php
$start = STInput::get('check_in', "");
$end = STInput::get('check_out', "");
$date = STInput::get('date', date('d/m/Y h:i a'). '-'. date('d/m/Y h:i a', strtotime('+1 day')));
$has_icon = (!empty($has_icon))? $has_icon: false;
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
<div class="form-group form-date-field form-date-search d-flex align-items-center<?php if ($has_icon) {
    echo ' has-icon ';
                                                                                 } ?>" data-format="<?php echo TravelHelper::getDateFormatMoment() ?>">
    
    <div class="date-wrapper">
        <div class="check-in-wrapper">
            <label><?php echo __('Arrival Date', 'traveler-layout-essential'); ?></label>
            <div class="render check-in-render"><?php echo esc_html($starttext); ?></div>
        </div>
        <?php
        if ($has_icon) { ?>
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 2.5H18V0.5H16V2.5H8V0.5H6V2.5H3C2.20435 2.5 1.44129 2.81607 0.87868 3.37868C0.31607 3.94129 0 4.70435 0 5.5L0 24.5H24V5.5C24 4.70435 23.6839 3.94129 23.1213 3.37868C22.5587 2.81607 21.7956 2.5 21 2.5ZM2 5.5C2 5.23478 2.10536 4.98043 2.29289 4.79289C2.48043 4.60536 2.73478 4.5 3 4.5H21C21.2652 4.5 21.5196 4.60536 21.7071 4.79289C21.8946 4.98043 22 5.23478 22 5.5V8.5H2V5.5ZM2 22.5V10.5H22V22.5H2Z" fill="#7B7B7B"/>
                <path d="M17 13.5H15V15.5H17V13.5Z" fill="#7B7B7B"/>
                <path d="M13 13.5H11V15.5H13V13.5Z" fill="#7B7B7B"/>
                <path d="M9 13.5H7V15.5H9V13.5Z" fill="#7B7B7B"/>
                <path d="M17 17.5H15V19.5H17V17.5Z" fill="#7B7B7B"/>
                <path d="M13 17.5H11V19.5H13V17.5Z" fill="#7B7B7B"/>
                <path d="M9 17.5H7V19.5H9V17.5Z" fill="#7B7B7B"/>
                </svg>
        <?php }
        ?>
    </div>
    <div class="date-wrapper">
        <div class="check-in-wrapper">
            <label><?php echo __('Depature Date', 'traveler-layout-essential'); ?></label>
            <div class="render check-out-render"><?php echo esc_html($endtext); ?></div>
        </div>
        <?php
        if ($has_icon) { ?>
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 2.5H18V0.5H16V2.5H8V0.5H6V2.5H3C2.20435 2.5 1.44129 2.81607 0.87868 3.37868C0.31607 3.94129 0 4.70435 0 5.5L0 24.5H24V5.5C24 4.70435 23.6839 3.94129 23.1213 3.37868C22.5587 2.81607 21.7956 2.5 21 2.5ZM2 5.5C2 5.23478 2.10536 4.98043 2.29289 4.79289C2.48043 4.60536 2.73478 4.5 3 4.5H21C21.2652 4.5 21.5196 4.60536 21.7071 4.79289C21.8946 4.98043 22 5.23478 22 5.5V8.5H2V5.5ZM2 22.5V10.5H22V22.5H2Z" fill="#7B7B7B"/>
                <path d="M17 13.5H15V15.5H17V13.5Z" fill="#7B7B7B"/>
                <path d="M13 13.5H11V15.5H13V13.5Z" fill="#7B7B7B"/>
                <path d="M9 13.5H7V15.5H9V13.5Z" fill="#7B7B7B"/>
                <path d="M17 17.5H15V19.5H17V17.5Z" fill="#7B7B7B"/>
                <path d="M13 17.5H11V19.5H13V17.5Z" fill="#7B7B7B"/>
                <path d="M9 17.5H7V19.5H9V17.5Z" fill="#7B7B7B"/>
                </svg>
        <?php }
        ?>
    </div>
    <input type="hidden" class="check-in-input" value="<?php echo esc_attr($start) ?>" name="check_in">
    <input type="hidden" class="check-out-input" value="<?php echo esc_attr($end) ?>" name="check_out">
    <input type="text" class="check-in-out" value="<?php echo esc_attr($date); ?>" name="date">
</div>
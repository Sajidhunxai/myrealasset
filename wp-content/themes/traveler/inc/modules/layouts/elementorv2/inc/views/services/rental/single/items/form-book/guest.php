<?php
$start = STInput::post('check_in', date(TravelHelper::getDateFormat()));
$end = STInput::post('check_out', date(TravelHelper::getDateFormat(), strtotime("+ 1 day")));
$rental_number = get_post_meta(get_the_ID(), 'rental_max_adult', true);
$rental_max_children = get_post_meta(get_the_ID(), 'rental_max_children', true);
$min_people = get_post_meta(get_the_ID(), 'min_people', true);
if (empty($min_people) or $min_people <= 0)
    $min_people = 1;

$rental_max_adult = get_post_meta(get_the_ID(), 'rental_max_adult', true);
if (empty($rental_max_adult) or $rental_max_adult <= 0){
    $rental_max_adult = 20;
}

$rental_max_children = get_post_meta(get_the_ID(), 'rental_max_children', true);
if (empty($rental_max_children) or $rental_max_children <= 0){
    $rental_max_children = 20;
}
$adult_number = STInput::post('adult_number', $min_people);
$child_number = STInput::post('child_number', 0);



$has_icon = (isset($has_icon)) ? $has_icon : false;

$hide_adult = get_post_meta(get_the_ID(), 'hide_adult_in_booking_form', true);
$hide_children = get_post_meta(get_the_ID(), 'hide_children_in_booking_form', true);
$hide_infant = get_post_meta(get_the_ID(), 'hide_infant_in_booking_form', true);

?>

<div class="form-group form-guest-search clearfix <?php if ($has_icon) echo ' has-icon '; ?>">
    <?php
    if ($has_icon) {
        echo TravelHelper::getNewIcon('ico_calendar_search_box');
    }
    ?>
    <?php if ($hide_adult != 'on'): ?>
        <div class="guest-wrapper d-flex align-items-center justify-content-between">
            <div class="check-in-wrapper">
                <label><?php echo __('Adults', 'traveler'); ?></label>
            </div>
            <div class="select-wrapper">
                <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                    <input type="text" name="adult_number" value="<?php echo esc_attr($adult_number); ?>"
                           class="form-control st-input-number adult_number" autocomplete="off" readonly data-min="<?php echo esc_attr($min_people);?>"
                           data-max="<?php echo esc_attr($rental_number); ?>"/>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($hide_children != 'on'): ?>
        <div class="guest-wrapper d-flex align-items-center justify-content-between">
            <div class="check-in-wrapper">
                <label><?php echo __('Children', 'traveler'); ?></label>
            </div>
            <div class="select-wrapper">
                <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                    <input type="text" name="child_number" value="<?php echo esc_html($child_number); ?>"
                           class="form-control st-input-number child_number" autocomplete="off" readonly data-min="0"
                           data-max="<?php echo esc_attr($rental_max_children); ?>"/>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
</div>


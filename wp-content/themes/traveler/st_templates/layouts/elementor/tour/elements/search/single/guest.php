<?php
$start = STInput::post('check_in', date(TravelHelper::getDateFormat()));
$end = STInput::post('check_out', date(TravelHelper::getDateFormat(), strtotime("+ 1 day")));


$max_people = get_post_meta(get_the_ID(), 'max_people', true);
if (empty($max_people) or $max_people <= 0)
    $max_people = 20;
$min_people = get_post_meta(get_the_ID(), 'min_people', true);
if (empty($min_people) or $min_people <= 0){
    $min_people = 0;
}
$adult_number = STInput::get('adult_number', $min_people);
$child_number = STInput::get('child_number', 0);
$infant_number = STInput::get('infant_number', 0);


    
$tour_guest_adult = st()->get_option('tour_guest_adult', __('Age 18+', 'traveler'));
if (isset($tour_guest_adult) && !empty($tour_guest_adult)) {
    $tour_guest_adult = st()->get_option('tour_guest_adult', __('Age 18+', 'traveler'));
} else {
    $tour_guest_adult = __('Age 18+', 'traveler');
}

$tour_guest_childrent = st()->get_option('tour_guest_childrent', __('Age 6-17', 'traveler'));
if (isset($tour_guest_childrent) && !empty($tour_guest_childrent)) {
    $tour_guest_childrent = $tour_guest_childrent;
} else {
    $tour_guest_childrent = __('Age 6-17', 'traveler');
}
$tour_guest_infant = st()->get_option('tour_guest_infant', __('Age 0-5', 'traveler'));
if (isset($tour_guest_infant) && !empty($tour_guest_infant)) {
    $tour_guest_infant = $tour_guest_infant;
} else {
    $tour_guest_infant = __('Age 0-5', 'traveler');
}

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
                <div class="render"><?php echo esc_html($tour_guest_adult); ?></div>
            </div>
            <div class="select-wrapper">
                <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                    <input type="text" name="adult_number" value="<?php echo esc_attr($adult_number); ?>"
                           class="form-control st-input-number adult_number" autocomplete="off" readonly data-min="<?php echo esc_attr($min_people);?>"
                           data-max="<?php echo esc_attr($max_people); ?>"/>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($hide_children != 'on'): ?>
        <div class="guest-wrapper d-flex align-items-center justify-content-between">
            <div class="check-in-wrapper">
                <label><?php echo __('Children', 'traveler'); ?></label>
                <div class="render"><?php echo esc_html($tour_guest_childrent); ?></div>
            </div>
            <div class="select-wrapper">
                <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                    <input type="text" name="child_number" value="<?php echo esc_html($child_number); ?>"
                           class="form-control st-input-number child_number" autocomplete="off" readonly data-min="0"
                           data-max="<?php echo esc_attr($max_people); ?>"/>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($hide_infant != 'on'): ?>
        <div class="guest-wrapper d-flex align-items-center justify-content-between">
            <div class="check-in-wrapper">
                <label><?php echo __('Infant', 'traveler'); ?></label>
                <div class="render"><?php echo esc_html($tour_guest_infant); ?></div>
            </div>
            <div class="select-wrapper">
                <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                    <input type="text" name="infant_number" value="<?php echo esc_attr($infant_number); ?>"
                           class="form-control st-input-number infant_number" autocomplete="off" readonly data-min="0"
                           data-max="<?php echo esc_attr($max_people); ?>"/>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
</div>

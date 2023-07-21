<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Content search flight
 *
 * Created by ShineTheme
 *
 */

wp_enqueue_script( 'bootstrap-datepicker.js' ); wp_enqueue_script( 'bootstrap-datepicker-lang.js' );
wp_enqueue_script('affilate-api.js');

$fields = array(
    array(
        'title' => esc_html__('Origin', 'traveler'),
        'name' => 'origin',
        'placeholder' => esc_html__('Origin', 'traveler'),
        'layout_col' => '6',
        'layout2_col' => '6',
        'is_required' => 'on'
    ),
    array(
        'title' => esc_html__('Destination', 'traveler'),
        'name' => 'destination',
        'placeholder' => esc_html__('Destination', 'traveler'),
        'layout_col' => '6',
        'layout2_col' => '6',
        'is_required' => 'on'
    ),
    array(
        'title' => esc_html__('Depart', 'traveler'),
        'name' => 'depart',
        'placeholder' => esc_html__('Depart date', 'traveler'),
        'layout_col' => '4',
        'layout2_col' => '4',
        'is_required' => 'on'
    ),
    array(
        'title' => esc_html__('Return', 'traveler'),
        'name' => 'return',
        'placeholder' => esc_html__('Return date', 'traveler'),
        'layout_col' => '4',
        'layout2_col' => '4',
        'is_required' => 'off'
    )
);

$st_direction = !empty($st_direction) ? $st_direction : "horizontal";

if (!isset($field_size)) $field_size = '';
$class = '';
$id = 'id="sticky-nav"';
if(isset($in_tab)) {
    $class = 'in_tab';
    $id = '';
}
?>
<?php $link = st()->get_option('custom_flight_search_link', ''); ?>
<div class="search-form hotel-search-form-home hotel-search-form <?php echo esc_attr($class); ?>" <?php echo ($id); ?>>
    <form role="search" method="get" class="search main-search ss-search-flights-link" autocomplete="off" action="" target="_blank">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="row">
                    <div class="col-lg-6 col-md-6 field-origin">
                        <?php echo TravelHelper::getNewIcon('ico_maps_search_box'); ?>
                        <?php echo st()->load_template('layouts/modern/ss_flight/search/field-origin'); ?>
                    </div>
                    <div class="col-lg-6 col-md-6 field-destination">
                        <?php echo st()->load_template('layouts/modern/ss_flight/search/field-destination'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="row">
                    <div class="col-lg-6 col-md-6 field-depart">
                        <?php echo TravelHelper::getNewIcon('ico_calendar_search_box'); ?>
                        <?php echo st()->load_template('layouts/modern/ss_flight/search/field-depart'); ?>
                    </div>
                    <div class="col-lg-6 col-md-6 field-return">
                        <?php echo st()->load_template('layouts/modern/ss_flight/search/field-return'); ?>
                    </div>
                </div>
            </div>
            <?php

            $country = st()->get_option('ss_market_country', 'US');
            $currency = st()->get_option('ss_currency', 'USD');
            $locale = st()->get_option('ss_locale', 'en-US');
            $api_key = st()->get_option('ss_api_key','prtl674938798674');
            $api_key = substr($api_key,0,16);
            ?>
            <input type="hidden" class="skyscanner-search-flights-data" data-api="<?php echo esc_attr($api_key)?>" data-locale="<?php echo esc_attr($locale)?>" data-currency="<?php echo esc_attr($currency)?>" data-country="<?php echo esc_attr($country); ?>">
            <input type="hidden" name="apiKey" value="<?php echo esc_attr($api_key); ?>">
            <div class="col-lg-2 col-md-2 ss-button-submit">
                <div class="form-button">
                    <button class="btn btn-primary btn-lg" type="submit"><?php echo esc_html__('SEARCH', 'traveler'); ?></button>
                </div>
            </div>
        </div>
       <!-- <span class="api_info"><i class="fa fa-info-circle"></i> <?php /*echo esc_html__('Search flights API of ', 'traveler')*/?><a href="https://skyscanner.net" target="_blank"><?php /*echo __('Skyscanner ', 'traveler')*/?></a></span>-->
    </form>
</div>

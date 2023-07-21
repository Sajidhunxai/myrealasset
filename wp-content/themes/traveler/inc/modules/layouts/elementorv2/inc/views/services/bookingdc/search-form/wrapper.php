<?php
wp_enqueue_script( 'bootstrap-datepicker.js' ); wp_enqueue_script( 'bootstrap-datepicker-lang.js' );
wp_enqueue_script('affilate-api.js');
$fields = [
    [
        'title' => __('Destination', 'traveler'),
        'field_search' => 'address',
        'placeholder' => __('e.g. city, region, district or specific hotel', 'traveler'),
        'layout_col' => '6',
        'layout2_col' => '6',
        'max_num' => '20',
        'is_required' => 'on',
    ],
    [
        'title' => __('Check-in', 'traveler'),
        'field_search' => 'check_in',
        'placeholder' => '',
        'layout_col' => '3',
        'layout2_col' => '3',
        'max_num' => '20',
        'is_required' => 'on',
    ],
    [
        'title' => __('Check-out', 'traveler'),
        'field_search' => 'check_out',
        'placeholder' => '',
        'layout_col' => '3',
        'layout2_col' => '3',
        'max_num' => '20',
        'is_required' => 'on',
    ],
    [
        'title' => __('Room(s)', 'traveler'),
        'field_search' => 'room_num',
        'placeholder' => '',
        'layout_col' => '4',
        'layout2_col' => '4',
        'max_num' => '20',
        'is_required' => 'on',
    ],
    [
        'title' => __('Adults', 'traveler'),
        'field_search' => 'adult',
        'placeholder' => '',
        'layout_col' => '4',
        'layout2_col' => '4',
        'max_num' => '20',
        'is_required' => 'on',
    ],
    [
        'title' => __('Children', 'traveler'),
        'field_search' => 'children',
        'placeholder' => '',
        'layout_col' => '4',
        'layout2_col' => '4',
        'max_num' => '20',
        'is_required' => 'on',
    ],

];

$bdc_status_iframe = st()->get_option('bookingdc_iframe', '');
$class = '';
$id = 'id="sticky-nav"';
if(isset($in_tab)) {
    $class = 'in_tab';
    $id = '';
}
?>
<div class="search-form hotel-search-form-home hotel-search-form st-border-radius <?php echo esc_attr($class); ?>">
 <?php if ($bdc_status_iframe == 'on') {
        $bdc_code_iframe = st()->get_option('bookingdc_iframe_code', '');
        echo balanceTags($bdc_code_iframe);
    } else {
        $aid = st()->get_option('bookingdc_aid', '1384277');
        $aid_default = '382821';
        $cname = st()->get_option('bookingdc_cname', '');
        $lang = st()->get_option('bookingdc_lang', 'en');
        $currency = st()->get_option('bookingdc_currency', 'USD');

        $domain = $cname != '' ? '//' . $cname . '/' : '//www.booking.com/';
        $target_page = 'searchresults.html';
        $class = '';
            $id = 'id="sticky-nav"';
            if(isset($in_tab)) {
                $class = 'in_tab';
                $id = '';
            }
        ?>
        <form action="<?php echo esc_url($domain . $target_page); ?>" class="form bookingdc" method="get">
            <input type="hidden" name="si" value="ai,co,ci,re,di"/>
            <input type="hidden" name="utm_campaign" value="search_box"/>
            <input type="hidden" name="utm_medium" value="sp"/>
            <input type="hidden" name="lang" value="<?php echo esc_html($lang); ?>" />
            <input type="hidden" name="lang_click" value="other" />
            <input type="hidden" name="lang_changed" value="1" />
            <input type="hidden" name="selected_currency" value="<?php echo strtoupper($currency); ?>" />
            <input type="hidden" name="changed_currency" value="1" />

            <?php
            if ( $cname == '' || ( $cname != '' && $aid != $aid_default ) ) {
                echo '<input type="hidden" name="aid" value="' . esc_attr($aid) . '" />';
                echo '<input type="hidden" name="label" value="wp-searchbox-widget-' . esc_attr($aid) . '" />';
                echo '<input type="hidden" name="utm_term" value="wp-searchbox-widget-' . esc_attr($aid) . '" />';
                echo '<input type="hidden" name="error_url" value="' . esc_attr($domain . $target_page) . '?aid=' . esc_attr($aid) . ';" />';
            }
            elseif ( $cname != '' ) {
                echo '<input type="hidden" name="ifl" value="1" />';
                echo '<input type="hidden" name="label" value="wp-searchbox-widget-' . esc_attr($cname) . '" />';
                echo '<input type="hidden" name="utm_term" value="wp-searchbox-widget-' . esc_attr($cname) . '" />';
                echo '<input type="hidden" name="error_url" value="' . esc_attr($domain . $target_page) . '" />';
            }
            else {
                echo '<input type="hidden" name="label" value="wp-searchbox-widget-' . esc_attr($aid) . '" />';
            }

            ?>
            <div class="row">
                <div class="col-md-3">
                    <?php echo stt_elementorv2()->loadView('services/bookingdc/search/location', '', [ 'has_icon' => true ] ) ?>
                </div>
                <div class="col-md-4">
                    <?php echo stt_elementorv2()->loadView('services/bookingdc/search/date', '', [ 'has_icon' => true ] ) ?>
                </div>
                <div class="col-md-3">
                    <?php echo stt_elementorv2()->loadView('services/bookingdc/search/guest', '', [ 'has_icon' => true ] ) ?>
                </div>
                <div class="col-md-2">
                    <?php echo stt_elementorv2()->loadView('services/bookingdc/search/advanced', '' ) ?>
                </div>
            </div>
        </form>
    <?php }?>
</div>

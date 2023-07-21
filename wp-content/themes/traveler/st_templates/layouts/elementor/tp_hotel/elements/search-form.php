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
        'title' => esc_html__('City or hotel name', 'traveler'),
        'name' => 'destination',
        'placeholder' => esc_html__('City or hotel name', 'traveler'),
        'layout_col' => '12',
        'layout2_col' => '12',
        'is_required' => 'on'
    ),
    array(
        'title' => esc_html__('Check In', 'traveler'),
        'name' => 'checkin',
        'placeholder' => esc_html__('Check In', 'traveler'),
        'layout_col' => '3',
        'layout2_col' => '3',
        'is_required' => 'on'
    ),
    array(
        'title' => esc_html__('Check Out', 'traveler'),
        'name' => 'checkout',
        'placeholder' => esc_html__('Check Out', 'traveler'),
        'layout_col' => '3',
        'layout2_col' => '3',
        'is_required' => 'on'
    ),
    array(
        'title' => esc_html__('Guests', 'traveler'),
        'name' => 'guest',
        'placeholder' => esc_html__('Guest', 'traveler'),
        'layout_col' => '4',
        'layout2_col' => '4',
        'is_required' => 'off'
    )
);

$st_direction = !empty($st_direction) ? $st_direction : "horizontal";

$marker = st()->get_option('tp_marker', '124778');

if (!isset($field_size)) $field_size = '';
?>
<?php
$tp_show_api_info = st()->get_option('tp_show_api_info', 'on');
$tp_locale_default = st()->get_option('tp_locale_default', 'en');
$tp_currency_default = st()->get_option('tp_currency_default');
$use_whitelabel = st()->get_option('tp_redirect_option');
$action = 'https://search.hotellook.com';
$target = '_blank';
$button_class = '';
if($use_whitelabel == 'on'){
    $button_class = 'btn-tp-search-hotels';
    $action = '';
    $target = '_self';
    $page_id = st()->get_option('tp_whitelabel_page','');
    if(empty($page_id)){
        $whitelabel_name = st()->get_option('tp_whitelabel', 'whilelabel.travelerwp.com');
    }else{
        $whitelabel_name = get_permalink($page_id).'/#';
    }
    echo '<input type="hidden" id="current_url_hotel" name="current_url_hotel" value="'.esc_url($whitelabel_name).'">';
}

$class = '';
$id = 'id="sticky-nav"';
if(isset($in_tab)) {
    $class = 'in_tab';
    $id = '';
}

?>
<div class="search-form hotel-search-form-home st-traveler-payout hotel-search-form st-border-radius <?php echo esc_attr($class); ?>">
    <form role="search" method="get" class="form search main-search tp_hotel" action="<?php echo esc_attr($action);?>" target="<?php echo esc_attr($target)?>">
        <input type="hidden" name="marker" value="<?php echo esc_attr($marker); ?>">
        <?php echo '<input type="hidden" id="tp_locale_default" name="tp_locale_default" value="'.esc_attr($tp_locale_default).'">';
        echo '<input type="hidden" id="tp_currency_default" name="tp_currency_default" value="'.esc_attr($tp_currency_default).'">'; ?>
        <div class="row">
            <div class="col-md-4 col-lg-4 border-right">
                <?php echo st()->load_template( 'layouts/elementor/travelpayouts_api/search/hotel/location', '', [ 'has_icon' => true ] ) ?>
            </div>
            <div class="col-md-3 col-lg-3">
                <?php echo st()->load_template( 'layouts/elementor/travelpayouts_api/search/hotel/date', '', [ 'has_icon' => true ] ) ?>
            </div>
            <div class="col-md-3 col-lg-3">
                <?php echo st()->load_template( 'layouts/elementor/travelpayouts_api/search/hotel/guest', '', [ 'has_icon' => true ] ) ?>
            </div>
            <div class="col-md-2 col-lg-2">
                <?php echo st()->load_template( 'layouts/elementor/travelpayouts_api/search/hotel/advanced', '' ) ?>
            </div>
        </div>
    </form>
</div>

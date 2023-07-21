<?php
$id_page = st()->get_option('car_transfer_search_page');
if(isset($id_page) && !empty($id_page)){
    $link_action = get_the_permalink($id_page);
}else{
    $link_action = home_url( '/' );
}
$class = '';
$id = 'id="sticky-nav"';
if (isset($in_tab)) {
    $class = 'in_tab';
    $id = '';
}

?>
<div class="search-form <?php echo esc_attr($class); ?> stt-car-transfer st-border-radius">
    <form action="<?php echo esc_url($link_action); ?>" class="form d-flex align-items-center" method="get">
        <?php
        echo stt_elementorv2()->loadView('services/car_transfer/search-form/location-pickup', ['has_icon' => true]);
        echo stt_elementorv2()->loadView('services/car_transfer/search-form/location-dropoff' , ['has_icon' => true]);
        ?>
        <div class="button-search-wrapper">
            <button class="btn btn-primary btn-search">
                <span class="stt-icon stt-icon-search-normal"></span>
                <?php echo esc_html__('Search', 'traveler'); ?>
            </button>
        </div>
    </form>
</div>

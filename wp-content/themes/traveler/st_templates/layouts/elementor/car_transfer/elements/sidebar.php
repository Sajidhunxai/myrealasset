<?php
$filters = get_post_meta(get_the_ID(), 'rs_filter_car', true);
if(!isset($format))
    $format = '';
?>
<div class="col-lg-3 col-md-3 sidebar-filter">
    <div class="sidebar-item st-border-radius sidebar-search-form d-sm-block d-md-block">
        <div class="search-form-wrapper">
            <div class="search-form st-border-radius">
                <div class="search-title">
                    <?php echo __('SEARCH CARS', 'traveler'); ?> <span class="d-block d-md-none d-sm-none close-filter"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span>
                </div>
                <!--Address-->
                <div class="row">
                    <form action="<?php echo get_the_permalink(); ?>" class="form" method="get">
                        <div class="col-md-12">
                            <?php echo st()->load_template('layouts/elementor/car_transfer/elements/search/location-from-search', '', ['has_icon' => true]) ?>
                        </div>
                        <div class="col-md-12">
                            <?php echo st()->load_template('layouts/elementor/car_transfer/elements/search/location-to-search', '', ['has_icon' => true]) ?>
                        </div>
                        <div class="col-md-12">
                            <?php echo st()->load_template('layouts/elementor/car_transfer/elements/search/advanced', '', ['position' => 'sidebar']); ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="sidebar-item-wrapper">
    <h3 class="sidebar-title"><?php echo __('FILTER BY', 'traveler'); ?> <span class="d-block d-md-none d-sm-none close-filter"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span></h3>

    <?php
        if(!empty($filters)){
            foreach ($filters as $k => $v){
                echo st()->load_template('layouts/elementor/car_transfer/elements/sidebar/' . esc_html($v['rs_filter_type']), '', array('title' => $v['title'], 'taxonomy' => $v['rs_filter_type_taxonomy']));
            }
        }
    ?>
    </div>
</div>
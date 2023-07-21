<?php
$filters = get_post_meta(get_the_ID(), 'rs_filter_car', true);
if(!isset($format))
    $format = '';
?>
<div class="col-lg-3 col-md-3 sidebar-filter">
    <div class="sidebar-item sidebar-search-form">
        <div class="search-form-wrapper sidebar-inner">
            <div class="search-form">
                <div class="search-title">
                    <?php echo __('SEARCH CARS', 'traveler'); ?> <span class="hidden-lg hidden-md close-filter"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span>
                </div>
                <!--Address-->
                <div class="row">
                    <form action="<?php echo get_the_permalink(); ?>" class="form" method="get">
                        <div class="col-md-12">
                            <?php echo st()->load_template('layouts/modern/car_transfer/elements/search/location-sidebar', '', ['has_icon' => true]); ?>
                        </div>
                        <div class="col-md-12">
                            <?php echo st()->load_template('layouts/modern/car_transfer/elements/search/advanced', '', ['position' => 'sidebar']); ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="sidebar-item-wrapper">
    <h3 class="sidebar-title"><?php echo __('FILTER BY', 'traveler'); ?> <span class="hidden-lg hidden-md close-filter"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span></h3>

    <?php
        if(!empty($filters)){
            foreach ($filters as $k => $v){
                echo st()->load_template('layouts/modern/car_transfer/elements/sidebar/' . esc_html($v['rs_filter_type']), '', array('title' => $v['title'], 'taxonomy' => $v['rs_filter_type_taxonomy']));
            }
        }
    ?>
    </div>
</div>
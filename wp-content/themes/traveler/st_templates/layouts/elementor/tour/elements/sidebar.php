<?php
$filters = get_post_meta(get_the_ID(), 'rs_filter_tour', true);
if(!isset($format))
    $format = '';
?>
<div class="col-lg-3 col-sm-3 sidebar-filter">
    <div class="sidebar-item st-border-radius sidebar-search-form d-none d-sm-none d-md-block">
        <div class="search-form-wrapper">
            <div class="search-form st-border-radius">
                <div class="search-title">
                    <?php echo __('SEARCH TOURS', 'traveler'); ?> <span class="d-block d-md-none d-sm-none close-filter"><i class="fa fa-times" aria-hidden="true"></i></span>
                </div>
                <!--Address-->
                <div class="row">
                    <form action="<?php echo get_the_permalink(); ?>" class="form" method="get">
                        <div class="col-sm-12">
                            <?php echo st()->load_template('layouts/elementor/tour/elements/search/location', '', ['has_icon' => true]); ?>
                        </div>
                        <div class="col-sm-12">
                            <?php echo st()->load_template('layouts/elementor/tour/elements/search/date', '', ['has_icon' => true]); ?>
                        </div>
                        <div class="col-sm-12">
                            <?php echo st()->load_template('layouts/elementor/tour/elements/search/advanced', '', ['position' => 'sidebar']); ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <h3 class="sidebar-title"><?php echo __('FILTER BY', 'traveler'); ?> <span class="d-sm-none d-md-none close-filter"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span></h3>

    <?php
        if(!empty($filters)){
            foreach ($filters as $k => $v){
                echo st()->load_template('layouts/elementor/tour/elements/sidebar/' . esc_attr($v['rs_filter_type']), '', array('title' => $v['title'], 'taxonomy' => $v['rs_filter_type_taxonomy']));
            }
        }
    ?>

    
</div>

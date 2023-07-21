<?php
$filters = get_post_meta(get_the_ID(), 'rs_filter_tour', true);

if (!isset($format))
    $format = '';
?>
<div class="col-lg-4 col-md-4 sidebar-filter">
    <div class="sidebar-item-wrapper">
        <h3 class="sidebar-title"><?php echo __('FILTER BY', 'traveler'); ?> <span class="hidden-lg hidden-md close-filter"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span></h3>

        <?php
        if (!empty($filters)) {
            $array_tem = array();
            foreach ($filters as $k => $v) {
                if (isset($v['rs_filter_type_taxonomy'])) {
                    $array_tem['taxonomy'] = $v['rs_filter_type_taxonomy'];
                }
                if (isset($v['title'])) {
                    $array_tem['title'] = $v['title'];
                }
                echo st()->load_template('layouts/modern/tour/elements/sidebar/' . esc_attr($v['rs_filter_type']), '', $array_tem);
            }
        }
        ?>
    </div>
</div>

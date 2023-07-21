<?php
$filters = get_post_meta(get_the_ID(), 'rs_filter_car', true);
if(!isset($format))
    $format = '';

$name_asc = 'name_a_z';
$name_desc = 'name_z_a';
?>
<div class="top-filter align-items-center justify-content-between flex-row-reverse">
    <ul>
        <li><h3 class="title"><?php echo __('FILTER BY', 'traveler'); ?></h3> <span class="d-md-none hidden-lg hidden-md close-filter"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span></li>
        <?php
        if(!empty($filters)){
            foreach ($filters as $k => $v){
                echo st()->load_template('layouts/elementor/car/elements/top-filter/' . esc_html($v['rs_filter_type']), '', array('title' => $v['title'], 'taxonomy' => $v['rs_filter_type_taxonomy']));
            }
        }
        ?>
    </ul>
</div>
<?php
$filters = get_post_meta(get_the_ID(), 'rs_filter', true);
if(!isset($format))
    $format = '';
?>
<div class="top-filter">
    <ul>
        <li><h3 class="title"><?php echo __('FILTER BY', 'traveler'); ?></h3> <span class="d-md-none hidden-lg hidden-md close-filter"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span></li>
        <?php
        if(!empty($filters)){
            foreach ($filters as $k => $v){
                echo st()->load_template('layouts/modern/hotel/elements/top-filter/' . esc_attr($v['rs_filter_type']), '', array('title' => $v['title'], 'taxonomy' => $v['rs_filter_type_taxonomy']));
            }
        }
        ?>
    </ul>
</div>
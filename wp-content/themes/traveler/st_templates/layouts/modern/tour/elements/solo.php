<?php
//$style = get_post_meta(get_the_ID(), 'rs_style_tour', true);
if (empty($style))
    $style = 'grid8';

global $wp_query, $st_search_query;
if ($st_search_query) {
    $query = $st_search_query;
} else
    $query = $wp_query;

if (empty($format))
    $format = '';

if (empty($layout))
    $layout = '';

$result_string = balanceTags(STTour::get_instance()->get_result_string());
?>  
<div class="col-lg-8 col-md-8">
    <div class="st-left">
    <h2 class="search-string modern-result-string" id="modern-result-string"><?php echo balanceTags($result_string); ?> <div id="btn-clear-filter" class="btn-clear-filter" style="display: none"><?php echo __('Clear filter', 'traveler'); ?></div> </h2>
    </div>
    
    <div id="modern-search-result" class="modern-search-result" data-layout="1">
        <?php echo st()->load_template('layouts/modern/common/loader', 'content'); ?>
        <?php
        if ($style == 'grid') {
            echo '<div class="row row-wrapper">';
        } else {
            echo '<div class="style-list row">';
        }
        ?>
        <?php
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                echo st()->load_template('layouts/modern/tour/elements/loop/' . esc_attr($style));
            }
        } else {
            echo ($style == 'grid') ? '<div class="col-xs-12">' : '';
            echo st()->load_template('layouts/modern/tour/elements/loop/none');
            echo ($style == 'grid') ? '</div>' : '';
        }
        wp_reset_query();
        ?>
    </div>
</div>

<div class="pagination moderm-pagination" id="moderm-pagination" data-layout="normal">
    <?php TravelHelper::paging(false, false); ?>
    <span class="count-string count-string--solo">
        <?php
        if (!empty($st_search_query)) {
            $query = $st_search_query;
        }
        if ($query->found_posts) {
            $page = get_query_var('paged');
            $posts_per_page = st()->get_option('tour_posts_per_page', 6);
            if (!$page)
                $page = 1;
            $last = (int) $posts_per_page * ((int) $page);
            if ($last > $query->found_posts)
                $last = $query->found_posts;
        }
        ?>
    </span>
</div>
</div>

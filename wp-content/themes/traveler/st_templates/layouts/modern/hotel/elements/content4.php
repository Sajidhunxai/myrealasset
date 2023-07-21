<?php
$style = 'grid';

global $wp_query, $st_search_query;
if ($st_search_query) {
    $query = $st_search_query;
} else $query = $wp_query;

if(empty($format))
    $format = '';

if(empty($layout))
    $layout = '';
?>
<div class="">
    <?php echo st()->load_template('layouts/modern/hotel/elements/toolbar2', '', array('style' => $style, 'format' => $format, 'layout' => $layout)); ?>
    <div id="modern-search-result" class="modern-search-result" data-layout="1">
        <?php echo st()->load_template('layouts/modern/common/loader', 'content'); ?>
        <?php
        if($style == 'grid'){
          echo '<div class="row row-wrapper">';
        }else{
            echo '<div class="style-list">';
        }
        ?>
        <?php
        if($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                echo st()->load_template('layouts/modern/hotel/elements/loop/normal', $style, array('fullwidth' => true));
            }
        }else{
            echo ($style == 'grid') ? '<div class="col-xs-12">' : '';
            echo st()->load_template('layouts/modern/hotel/elements/none');
            echo ($style == 'grid') ? '</div>' : '';
        }
        wp_reset_query();
        ?>
        </div>
    </div>

    <div class="pagination moderm-pagination" id="moderm-pagination" data-layout="normal">
        <?php echo TravelHelper::paging(false, false); ?>
        <span class="count-string">
            <?php
            if (!empty($st_search_query)) {
                $query = $st_search_query;
            }
            if ($query->found_posts):
                $page = get_query_var('paged');
                $posts_per_page = st()->get_option( 'hotel_posts_per_page', 12 );
                if (!$page) $page = 1;
                $last = (int)$posts_per_page * (int)($page);
                if ($last > $query->found_posts) $last = $query->found_posts;
                echo sprintf(__('%d - %d of %d ', 'traveler'), (int)$posts_per_page * ($page - 1) + 1, $last, $query->found_posts );
                echo ( $query->found_posts == 1 ) ? __( 'Hotel', 'traveler' ) : __( 'Hotels', 'traveler' );
            endif;
            ?>
        </span>
    </div>
</div>

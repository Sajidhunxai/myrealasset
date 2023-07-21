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
<div class="filter-fullwidth">
    <div class="toolbar">
        <ul class="toolbar-action-mobile d-block d-sm-none d-md-none">
            <li><a href="#" class="btn btn-primary btn-date"><?php echo __('Date', 'traveler'); ?></a></li>
            <li><a href="#" class="btn btn-primary btn-sort"><?php echo __('Sort', 'traveler'); ?></a></li>
            <li><a href="#" class="btn btn-primary btn-filter"><?php echo __('Filter', 'traveler'); ?></a></li>
        </ul>
        <div class="dropdown-menu sort-menu sort-menu-mobile">
            <div class="sort-title">
                <h3><?php echo __('SORT BY', 'traveler'); ?> <span class="d-block d-sm-none d-md-none close-filter"><?php echo TravelHelper::getNewIcon('Ico_close', '#A0A9B2', '20px', '20px'); ?></span></h3>
            </div>
            <div class="sort-item st-icheck">
                <div class="st-icheck-item"><label> <?php echo __('New tour', 'traveler'); ?><input class="service_order" type="radio" name="service_order_m_<?php echo esc_attr($format); ?>" data-value="new" /><span class="checkmark"></span></label></div>
            </div>
            <div class="sort-item st-icheck">
                <span class="title"><?php echo __('Price', 'traveler'); ?></span>
                <div class="st-icheck-item"><label> <?php echo __('Low to High', 'traveler'); ?><input class="service_order" type="radio" name="service_order_m_<?php echo esc_attr($format); ?>"  data-value="price_asc"/><span class="checkmark"></span></label></div>
                <div class="st-icheck-item"><label> <?php echo __('High to Low', 'traveler'); ?><input class="service_order" type="radio" name="service_order_m_<?php echo esc_attr($format); ?>"  data-value="price_desc"/><span class="checkmark"></span></label></div>
            </div>
            <div class="sort-item st-icheck">
                <span class="title"><?php echo __('Name', 'traveler'); ?></span>
                <div class="st-icheck-item"><label> <?php echo __('a - z', 'traveler'); ?><input class="service_order" type="radio" name="service_order_m_<?php echo esc_attr($format); ?>"  data-value="name_a_z"/><span class="checkmark"></span></label></div>
                <div class="st-icheck-item"><label> <?php echo __('z - a', 'traveler'); ?><input class="service_order" type="radio" name="service_order_m_<?php echo esc_attr($format); ?>"  data-value="name_z_a"/><span class="checkmark"></span></label></div>
            </div>
        </div>
        
    </div>
    <?php
    echo st()->load_template('layouts/elementor/tour/elements/top-filter/top-filter');
    ?>
    <div id="modern-search-result" class="modern-search-result">
        <?php echo st()->load_template('layouts/elementor/common/loader', 'content'); ?>
        <?php
        if($style == 'grid'){
            echo '<div class="service-list-wrapper row">';
        }else{
            echo '<div class="service-list-wrapper list-style">';
        }
        ?>
        <?php
        if($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                echo st()->load_template('layouts/elementor/tour/loop/normal-' . esc_attr($style), '', array('top_search' => true));
            }
        }else{
            echo($style == 'grid') ? '<div class="col-12">' : '';
            echo st()->load_template('layouts/modern/tour/loop/none');
            echo ($style == 'grid') ? '</div>' : '';
        }
        wp_reset_query();
        ?>
        </div>
    </div>

    <div class="pagination moderm-pagination" id="moderm-pagination" data-layout="normal">
        <?php TravelHelper::paging(false, false); ?>
        <span class="count-string">
            <?php
            if (!empty($st_search_query)) {
                $query = $st_search_query;
            }
            if ($query->found_posts):
                $page = get_query_var('paged');
                $posts_per_page = st()->get_option( 'tour_posts_per_page', 12 );
                if (!$page) $page = 1;
                $last = $posts_per_page * ($page);
                if ($last > $query->found_posts) $last = $query->found_posts;
                echo sprintf( __( '%d - %d of %d ', 'traveler' ), $posts_per_page * ( $page - 1 ) + 1, $last, $query->found_posts );
                echo ( $query->found_posts == 1 ) ? __( 'Tour', 'traveler' ) : __( 'Tours', 'traveler' );
            endif;
            ?>
        </span>
    </div>
</div>

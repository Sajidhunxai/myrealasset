<?php

use Inc\Base\ST_Elementor_Widget;

$stElementorWidget = new ST_Elementor_Widget;
$attrs = [];
if ($list_style === 'slider') {
    $attrs = [
        'data-effect' => [
            esc_attr($effect_style)
        ],
        'data-slides-per-view' => [
            esc_attr($slides_per_view)
        ],
        'data-pagination' => [
            esc_attr($pagination)
        ],
        'data-navigation' => [
            esc_attr($navigation)
        ],
        'data-auto-play' => [
            esc_attr($auto_play)
        ],
        'data-loop' => [
            esc_attr($loop)
        ],
        'data-delay' => [
            esc_attr($delay)
        ]
    ];
}
$item_row_tablet = !empty($item_row_tablet) ? $item_row_tablet : 1;
$item_row_tablet_extra = !empty($item_row_tablet_extra) ? $item_row_tablet_extra : 1;
?>
<div class="st-list-service st_list_service_room st_agency_list_service <?php echo esc_attr($list_style . ' ' . $style); ?>" <?php echo st_render_html_attributes($attrs); ?>>
    <?php

    $args = [
        'post_type' => 'st_rental',
        'post_status' => 'publish',
        'paged' => $paged
    ];
    $st_order = !empty($order) ? $order : '';
    $st_orderby = !empty($orderby) ? $orderby : '';
    if (!empty($st_order)) {
        $args['order'] = $st_order;
    }
    if (!empty($st_orderby)) {
        $args['orderby'] = $st_orderby;
    }
    if ($st_orderby === 'post__in' && !empty($post_ids_room) && $type_form == 'single') {
        $list_ids = ST_Elementor::st_explode_select2($post_ids_room);
        $args['post__in'] = array_keys($list_ids);
    }

    if (TravelHelper::is_wpml()) {
        $current_lang = TravelHelper::current_lang();
        $main_lang = TravelHelper::primary_lang();
        global $sitepress;
        $sitepress->switch_lang($current_lang, true);
    }
    STRental::inst()->alter_search_query();
    $query_service = new WP_Query($args);
    STRental::inst()->remove_alter_search_query();
    if ($query_service->have_posts()) {
        if ($list_style == 'grid') {
            $html = '<div class="service-list-wrapper"><div class="row">';
            $col_classes = 'col-lg-12';
            if ($item_row) {
                $col_classes = 'col-12 col-sm-' . (12 / $item_row_tablet) . ' col-md-' . (12 / $item_row_tablet_extra) . ' col-lg-' . (12 / $item_row);
            }

            while ($query_service->have_posts()) :
                $query_service->the_post();
                $html .= '<div class="' . esc_attr($col_classes) . '">';
                $html .= $stElementorWidget->loadTemplate('list-service-rental/rental/loop/grid');
                $html .= '</div>';
            endwhile;

            wp_reset_postdata();

            $html .= '</div></div>';
        } elseif ($list_style == 'slider') {
            $html = '<div class="service-list-wrapper swiper-container"><div class="swiper-wrapper">';

            while ($query_service->have_posts()) :
                $query_service->the_post();
                $html .= '<div class="swiper-slide">';
                $html .= $stElementorWidget->loadTemplate('list-service-rental/rental/loop/grid');
                $html .= '</div>';
            endwhile;

            wp_reset_postdata();

            $html .= '</div>';
            if ($pagination == 'on') {
                $html .= '<div class="swiper-pagination"></div>';
            }
            $html .= '</div>';
            if ($navigation == 'on') {
                $html .= '<div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_646_610)">
                    <path d="M10.828 11.9998L15.778 16.9498L14.364 18.3638L7.99995 11.9998L14.364 5.63577L15.778 7.04977L10.828 11.9998Z" fill="#7B7B7B"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_646_610">
                    <rect width="24" height="24" fill="white" transform="translate(24 24) rotate(-180)"/>
                    </clipPath>
                    </defs>
                    </svg>
                    </span></div><div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_646_606)">
                    <path d="M13.1719 12.0002L8.22192 7.05023L9.63592 5.63623L15.9999 12.0002L9.63592 18.3642L8.22192 16.9502L13.1719 12.0002Z" fill="#7B7B7B"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_646_606">
                    <rect width="24" height="24" fill="white"/>
                    </clipPath>
                    </defs>
                    </svg>
                    </span></div>';
            }
        } else {
            $html = st()->load_template('layouts/elementor/common/loader', 'content');
            $html .= '<div class="row service-list-wrapper list-style">';
            $col_classes = 'col-lg-12';
            while ($query_service->have_posts()) :
                $query_service->the_post();
                $html .= '<div class="' . esc_attr($col_classes) . '">';
                $html .= $stElementorWidget->loadTemplate('list-service-rental/rental/loop/list');
                $html .= '</div>';
            endwhile;

            wp_reset_postdata();

            $html .= '</div>';
        }
        echo balanceTags($html);
        if ($list_style == 'grid' || $list_style == 'list') {
            echo '<div class="panigation-list-new-style pagination moderm-pagination" data-action_service="st_filter_rental_ajax" data-order="' . esc_attr($st_order) . '" data-orderby="' . esc_attr($st_orderby) . '">';
            echo TravelHelper::paging($query_service, false);
            echo '</div>';
        }
    }
    ?>
</div>
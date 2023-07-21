<?php
    $attrs = [
        'data-effect' => [
            'creative'
        ],
        'data-slides-per-view' => [
            esc_attr($number_item_show)
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
        ],
        'data-center-slider' => [
            'off'
        ],
        'data-space-between' => [
            30
        ]
    ];



    
    $args = [
        'post_type' => 'location',
        'posts_per_page' => -1
    ];
    if (!empty($ids)) {
        $list_ids = ST_Elementor::st_explode_select2($ids);
        $args['post__in'] = array_keys($list_ids);
        $args['orderby'] = 'post__in';
    }

    $query_destination = new WP_Query($args);

    $result_page = '';
    $service =  ST_Elementor::listServiceSelection();
    if (count($service) == 1) {
        $result_page = '';
        if(!empty($service[0])){
            switch ($service[0]) {
                case 'st_hotel':
                    $result_page = get_the_permalink(st_get_page_search_result('st_hotel'));
                    break;
                case 'st_rental':
                    $result_page = get_the_permalink(st_get_page_search_result('st_rental'));
                    break;
                case 'st_tours':
                    $result_page = get_the_permalink(st_get_page_search_result('st_tours'));
                    break;
                case 'st_activity':
                    $result_page = get_the_permalink(st_get_page_search_result('st_activity'));
                    break;
                case 'st_cars':
                    $result_page = get_the_permalink(st_get_page_search_result('st_cars'));
                    break;
            }
        }
    }

    if ($query_destination->have_posts()) {
        echo '<div class="st-list-destination st-sliders number-' . esc_attr($number_item_show) . '" ' . st_render_html_attributes($attrs) . ' ">';
        echo '<div class="swiper-container">';
        echo '<div class="swiper-wrapper">';
        while ($query_destination->have_posts()) {
            $query_destination->the_post();
            $location_id = get_the_ID();
            $location_name = get_the_title();
            $url = get_the_permalink($location_id);
            $thumbnail = wp_get_attachment_image_url(get_post_thumbnail_id(), [400, 400]);
            if (count($service) >= 1) {
                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
            }
            ?>
            <div class="swiper-slide">
                <div class="thumbnail">
                    <a class="st-link" href="<?php echo esc_url($url) ?>">
                        <img src="<?php echo ($thumbnail); ?>" alt="<?php echo esc_attr($location_name); ?>"
                             class="img-fluid st-hover-grow">
                    </a>
                </div>
                <h3 class="title">
                    <a href="<?php echo esc_url($url); ?>">
                        <?php echo esc_html($location_name); ?>
                    </a>
                </h3>
                <div class="desc">
                    <?php
                    $desc_str = '';
                    $total_service = STLocation::count_services_multi_service($location_id, $service);
                    foreach ($total_service as $kk => $vv) {
                        $result_page = '';
                        switch ($vv['post_type']) {
                            case 'st_hotel':
                                $result_page = get_the_permalink(st()->get_option('hotel_search_result_page'));
                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                $desc_str .= '<a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Hotel', '%s Hotels', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a>';
                                break;
                            case 'st_rental':
                                $result_page = get_the_permalink(st()->get_option('rental_search_result_page'));
                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                $desc_str .= '<a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Rental', '%s Rentals', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a>';
                                break;
                            case 'st_tours':
                                $result_page = get_the_permalink(st()->get_option('tours_search_result_page'));
                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                $desc_str .= '<a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Tour', '%s Tours', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a>';
                                break;
                            case 'st_activity':
                                $result_page = get_the_permalink(st()->get_option('activity_search_result_page'));
                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                $desc_str .= '<a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Activity', '%s Activities', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a>';
                                break;
                            case 'st_cars':
                                $result_page = get_the_permalink(st()->get_option('cars_search_result_page'));
                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                $desc_str .= '<a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Car', '%s Cars', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a>';
                                break;
                        }
                    }

                    echo balanceTags($desc_str);
                    ?>
                </div>
            </div>
            <?php
        }
        echo '</div></div>';
        if($pagination == 'on'){
            echo '<div class="swiper-pagination"></div>';
        }
        if ($navigation == 'on') {
            echo '<div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"></span></div><div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"></span></div>';
        }
        echo '</div>';
    }

?>
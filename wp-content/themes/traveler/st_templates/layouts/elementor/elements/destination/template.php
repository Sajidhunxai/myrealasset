<?php 
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
    
    ?>
    <div class="row st-list-destination <?php echo esc_attr($layout_style);?> <?php echo esc_attr($position_text);?> <?php echo !empty($style) ? esc_attr($style) : '';?>">
    <?php
        $i = 0;
        while ($query_destination->have_posts()): $query_destination->the_post();
            $location_id = get_the_ID();
            $location_name = get_the_title();
            if (count($service) >= 1){
                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                
                if(!empty($list_ids) && count($list_ids) == 1){
                    $class = 'col-12 normal-item';
                } else {
                    $class = 'col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 normal-item';
                    if($number_show_in_row == '2'){
                        $class = 'col-12 col-sm-6 col-md-6 normal-item';
                    } elseif ($number_show_in_row == '4'){
                        $class = 'col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 normal-item';
                    }elseif ($number_show_in_row == '3'){
                        $class = 'col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4 normal-item';
                    } else {
                        $class = 'col-12 normal-item';
                    }
                }
                
            }
                
            ?>
            <div class="<?php echo esc_attr($class); ?>">
                <div class="destination-item">
                    <div class="image st-border-radius">
                        <?php
                        $thumbnail = get_post_thumbnail_id();
                        $size = 'full';
                        $img_src = wp_get_attachment_image_url($thumbnail, $size);
                        ?>
                        <a class="st-link" href="<?php echo esc_url(get_the_permalink($location_id)) ?>">
                            <img src="<?php echo ($img_src); ?>" alt = "<?php echo get_the_title();?>"
                                    class="img-responsive">
                        </a>
                        <div class="content">
                            <h3 class="title">
                                <a href="<?php echo esc_url(get_the_permalink($location_id)); ?>">
                                    <?php the_title() ?>
                                </a>
                            </h3>
                            <?php
                                echo '<div class="desc d-flex align-items-center justify-content-center flex-wrap multi">';
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
                                echo '</div>';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $i++;
        endwhile;
        wp_reset_postdata();
        ?>
    </div>
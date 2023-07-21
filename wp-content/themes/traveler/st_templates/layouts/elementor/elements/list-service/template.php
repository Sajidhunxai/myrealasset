<?php 
$attrs = [];
if ($list_style === 'slider'){
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
if($list_style =='list' && $style_list == 'vertical'){
    $class_vertical_style_list = ' st-list-vertical '.esc_attr($style);
} else {
    $class_vertical_style_list = esc_attr($style);
}

?>
<div class="st-list-service <?php echo esc_attr($type_form);?> <?php echo esc_attr($class_vertical_style_list);?>"
    <?php echo st_render_html_attributes($attrs);?> >
    <?php echo st()->load_template('layouts/elementor/common/loader', 'content'); ?>
    <?php 
    if($type_form === 'mix_service' && $list_style !== 'slider'){ 
        $services = ST_Elementor::st_explode_select2($services);

        ?>
        <div class="title d-flex align-items-center">
            <?php
            if(!empty($heading))
                echo '<h2>'.esc_html($heading) . '</h2> ';
            ?>
            <div class="st-list-dropdown">
                <div class="header" data-value="<?php echo esc_attr(array_key_first($services)) ?>">
                    <span><?php echo !empty(array_key_first($services)) ? ST_Elementor::get_title_service(array_key_first($services)) : ''; ?></span>
                    <?php if(count($services) > 1){ ?>
                    <i class="fa fa-angle-down"></i>
                    <?php } ?>
                </div>
                <?php if(count($services) > 1){ ?>
                <ul class="list">
                    <?php
                        $i = 0;
                        foreach ($services as $k => $v){
                            $args_list = [
                                'post_type'      => $k,
                                'posts_per_page' => $posts_per_page,
                                'order'          => $order,
                                'orderby'        => $orderby,
                                'list_style'        => $list_style,
                                
                            ];
                            if ( isset($v['ids']) ) {
                                $args_list[ 'post__in' ] = explode( ',', $v['ids'] );
                                $args_list['orderby'] = 'post__in';
                            }
                            $array_item['st_style'] = !empty($list_style) ? $list_style : 'grid';
                            $array_item['item_row'] = !empty($item_row) ? $item_row : '4';
                            $class = '';
                            if($i == 0)
                                $class = 'active';
                            echo "<li data-value='". esc_attr($k) ."' data-styleitem='".str_ireplace(array("'"),'\"',balanceTags(wp_json_encode($array_item)))."' data-arg ='".str_ireplace(array("'"),'\"',balanceTags(wp_json_encode($args_list)))."' class='". esc_attr($class) ."'>". esc_html(ST_Elementor::get_title_service($k)) ."</li>";
                            $i++;
                        }
                    ?>
                </ul>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <div class="multi-service-wrapper">
    
        <?php
        if($type_form === 'mix_service'){
            $v= !empty(array_key_first($services)) ? array_key_first($services) : array();
        } else {
            $v= $service;
        }
        if(!empty($v)){
            global $post;
            $old_post = $post;
            
            $args = [
                'post_type'      => $v,
                'posts_per_page' => $posts_per_page,
                'order'          => $order,
                'orderby'        => $orderby,
                'post_status' => 'publish'
            ];
            
            if($list_style == 'slider'){
                $row_class = ' swiper-container';
            } elseif($list_style == 'list'){
                $row_class = ' list-style ';
            } else {
                $row_class = ' row';
            }
            if(empty($item_row)){
                $item_row = 4;
            }
            switch ($v){
                case 'st_hotel':
                    if(st_check_service_available('st_hotel')) {
                        echo '<div class="tab-content '. esc_attr($v) .'">';
                        global $wp_query , $st_search_query;
                        if(!empty($category_hotel)){
                            $term_tax_hotel = explode(":",$category_hotel);
                            if($term_tax_hotel[0] != 0){
                                $taxonomies = get_taxonomies(['object_type' => [$v]]);
                                $arr_tax = [
                                    'relation' => 'OR',
                                ];
                                foreach($taxonomies as $tax){
                                    $arr_tax[] = array(
                                        'taxonomy' => $tax,
                                        'field' => 'term_id',
                                        'terms' => intval($term_tax_hotel[0]),
                                    );
                                }
                                $args['tax_query'] = $arr_tax;
                            }
                            
                                
                        }
                        if($orderby === 'post__in' && !empty($post_ids_hotel) && $type_form == 'single'){
                            $list_ids = ST_Elementor::st_explode_select2($post_ids_hotel);
                            $args['post__in'] = array_keys($list_ids);
                        }
                        $current_lang = TravelHelper::current_lang();
                        $main_lang = TravelHelper::primary_lang();
                        $hotel = STHotel::inst();
                        $hotel->alter_search_query();
                        $query_service = new WP_Query($args);
                        $html = '<div class="service-list-wrapper'.esc_attr($row_class).'">';
                        if($list_style == 'slider'){
                            $html .= '<div class="swiper-wrapper">' ;
                        }
                        while ($query_service->have_posts()):
                            $query_service->the_post();
                            if($list_style == 'list'){
                                $html .= st()->load_template('layouts/elementor/hotel/loop/normal-list', '', array('slider' => $list_style));
                            } else {
                                
                                $html .= st()->load_template('layouts/elementor/hotel/loop/normal-grid', '', array('slider' => $list_style ,'item_row' => $item_row));
                            }
                            
                        endwhile;
                        $hotel->remove_alter_search_query();
                        wp_reset_postdata();
                        $post = $old_post;
                        if($list_style == 'slider'){
                            $html .= '</div>';
                        }
                        $html .= '</div>';
                        if($list_style == 'slider'){
                            if($pagination == 'on'){
                                $html .= '<div class="swiper-pagination"></div>';
                            }
                            if($navigation == 'on'){
                                $html .= '<div class="st-button-prev"><span></span></div><div class="st-button-next"><span></span></div>';
                            }
                        }
                        echo balanceTags($html);
                        echo '</div>';
                    }
                    break;
                case 'st_tours':
                    if(st_check_service_available('st_tours')) {
                        echo '<div class="tab-content '. esc_attr($v) .'">';
                        global $wp_query , $st_search_query;
                        if(!empty($category_tour)){
                            $term_tax_tour = explode(":",$category_tour);
                           
                            if ($term_tax_tour[0] != 0) {
                                $taxonomies_tour = TravelHelper::st_get_attribute_advance($v);
                                $arr_tax_tour = [
                                    'relation' => 'OR',
                                ];
                                
                                foreach($taxonomies_tour as $tax_tour){
                                    if(!empty($tax_tour["value"])){
                                        $arr_tax_tour[] = array(
                                            'taxonomy' => $tax_tour["value"],
                                            'field' => 'term_id',
                                            'terms' => intval($term_tax_tour[0]),
                                        );
                                    }
                                    
                                }
                                $args['tax_query'] = $arr_tax_tour;
                            }
                                
                        }
                        if($orderby === 'post__in' && !empty($post_ids_tour) && $type_form == 'single'){
                            $list_ids = ST_Elementor::st_explode_select2($post_ids_tour);
                            $args['post__in'] = array_keys($list_ids);
                        }
                        $current_lang = TravelHelper::current_lang();
                        $main_lang = TravelHelper::primary_lang();
                        $tour = STTour::get_instance();
                        $tour->alter_search_query();
                        $query_service = new WP_Query($args);
                        $html = '<div class="service-list-wrapper'.esc_attr($row_class).'">';
                        if($list_style == 'slider'){
                            $html .= '<div class="swiper-wrapper">' ;
                        }
                        while ($query_service->have_posts()):
                            $query_service->the_post();
                            if($list_style == 'list'){
                                $html .= st()->load_template('layouts/elementor/tour/loop/normal-list', '', array('slider' => $list_style));
                            } else {
                                $html .= st()->load_template('layouts/elementor/tour/loop/normal-grid', '', array('slider' => $list_style , 'item_row' => $item_row));
                            }
                        endwhile;
                        $tour->remove_alter_search_query();
                        wp_reset_postdata();
                        $post = $old_post;
                        if($list_style == 'slider'){
                            $html .= '</div>';
                        }
                        $html .= '</div>';
                        if($list_style == 'slider'){
                            if($pagination == 'on'){
                                $html .= '<div class="swiper-pagination"></div>';
                            }
                            if($navigation == 'on'){
                                $html .= '<div class="st-button-prev"><span></span></div><div class="st-button-next"><span></span></div>';
                            }
                        }
                        echo balanceTags($html);
                        echo '</div>';
                    }
                    break;
                case 'st_rental':
                    if(st_check_service_available('st_rental')) {
                        echo '<div class="tab-content st-search-rental'. esc_attr($v) .'">';
                        global $wp_query , $st_search_query;
                        if(!empty($category_rental)){
                            $term_tax_rental = explode(":",$category_rental);
                           
                            if ($term_tax_rental[0] != 0) {
                                $taxonomies = TravelHelper::st_get_attribute_advance($v);
                                $arr_tax = [
                                    'relation' => 'OR',
                                ];
                                foreach($taxonomies as $tax){
                                    if(!empty($tax["value"])){
                                        $arr_tax[] = array(
                                            'taxonomy' => $tax["value"],
                                            'field' => 'term_id',
                                            'terms' => intval($term_tax_rental[0]),
                                        );
                                    }
                                }
                                $args['tax_query'] = $arr_tax;
                            }
                                
                        }
                        if($orderby === 'post__in' && !empty($post_ids_rental) && $type_form == 'single'){
                            $list_ids = ST_Elementor::st_explode_select2($post_ids_rental);
                            $args['post__in'] = array_keys($list_ids);
                        }
                        $current_lang = TravelHelper::current_lang();
                        $main_lang = TravelHelper::primary_lang();
                        $rental = STRental::inst();
                        $rental->alter_search_query();
                        $query_service = new WP_Query($args);
                        $html = '<div class="service-list-wrapper'.esc_attr($row_class).'">';
                        if($list_style == 'slider'){
                            $html .= '<div class="swiper-wrapper">' ;
                        }
                        while ($query_service->have_posts()):
                            $query_service->the_post();
                            if($list_style == 'list'){
                                $html .= st()->load_template('layouts/elementor/rental/loop/normal-list', '', array('slider' => $list_style));
                            } else {
                                $html .= st()->load_template('layouts/elementor/rental/loop/normal-grid', '', array('slider' => $list_style, 'item_row' => $item_row));
                            }
                        endwhile;
                        $rental->remove_alter_search_query();
                        wp_reset_postdata();
                        $post = $old_post;
                        if($list_style == 'slider'){
                            $html .= '</div>';
                        }
                        $html .= '</div>';
                        if($list_style == 'slider'){
                            if($pagination == 'on'){
                                $html .= '<div class="swiper-pagination"></div>';
                            }
                            if($navigation == 'on'){
                                $html .= '<div class="st-button-prev"><span></span></div><div class="st-button-next"><span></span></div>';
                            }
                        }
                        echo balanceTags($html);
                        echo '</div>';
                    }
                    break;
                case 'st_activity':
                    if(st_check_service_available('st_activity')) {
                        echo '<div class="tab-content '. esc_attr($v) .'">';
                        global $wp_query , $st_search_query;
                        if(!empty($category_activity)){
                            $term_tax_activity = explode(":",$category_activity);
                           
                            if($term_tax_activity[0] != 0){
                                $taxonomies = get_taxonomies(['object_type' => ['st_activity']]);
                                $arr_tax = [
                                    'relation' => 'OR',
                                ];
                                foreach($taxonomies as $tax){
                                    $arr_tax[] = array(
                                        'taxonomy' => $tax,
                                        'field' => 'term_id',
                                        'terms' => intval($term_tax_activity[0]),
                                    );
                                }
                                $args['tax_query'] = $arr_tax;
                            }
                                
                        }
                        if($orderby === 'post__in' && !empty($post_ids_activity) && $type_form == 'single'){
                            $list_ids = ST_Elementor::st_explode_select2($post_ids_activity);
                            $args['post__in'] = array_keys($list_ids);
                        }
                        $current_lang = TravelHelper::current_lang();
                        $main_lang = TravelHelper::primary_lang();
                        $activity = STActivity::inst();
                        $activity->alter_search_query();
                        $query_service = new WP_Query($args);
                        $html = '<div class="service-list-wrapper'.esc_attr($row_class).'">';
                        if($list_style == 'slider'){
                            $html .= '<div class="swiper-wrapper">' ;
                        }
                        while ($query_service->have_posts()):
                            $query_service->the_post();
                            if($list_style == 'list'){
                                $html .= st()->load_template('layouts/elementor/activity/loop/normal-list', '', array('slider' => $list_style));
                            } else {
                                $html .= st()->load_template('layouts/elementor/activity/loop/normal-grid', '', array('slider' => $list_style , 'item_row' => $item_row));
                            }
                        endwhile;
                        $activity->remove_alter_search_query();
                        wp_reset_postdata();
                        $post = $old_post;
                        if($list_style == 'slider'){
                            $html .= '</div>';
                        }
                        $html .= '</div>';
                        if($list_style == 'slider'){
                            if($pagination == 'on'){
                                $html .= '<div class="swiper-pagination"></div>';
                            }
                            if($navigation == 'on'){
                                $html .= '<div class="st-button-prev"><span></span></div><div class="st-button-next"><span></span></div>';
                            }
                        }
                        echo balanceTags($html);
                        echo '</div>';
                    }
                    break;
                
                case 'st_cars':
                    
                    if(st_check_service_available('st_cars')) {
                        
                        echo '<div class="tab-content st-search-car'. esc_attr($v) .'">';
                        global $wp_query , $st_search_query;
                        if(!empty($category_car)){
                            $term_tax_car = explode(":",$category_car);
                           
                            if ($term_tax_car[0] != 0) {
                                $taxonomies = TravelHelper::st_get_attribute_advance($v);
                                $arr_tax = [
                                    'relation' => 'OR',
                                ];
                                foreach($taxonomies as $tax){
                                    if(!empty($tax["value"])){
                                        $arr_tax[] = array(
                                            'taxonomy' => $tax["value"],
                                            'field' => 'term_id',
                                            'terms' => intval($term_tax_car[0]),
                                        );
                                    }
                                }
                                $args['tax_query'] = $arr_tax;
                            }
                                
                        }
                        if($orderby === 'post__in' && !empty($post_ids_car) && $type_form == 'single'){
                            $list_ids = ST_Elementor::st_explode_select2($post_ids_car);
                            $args['post__in'] = array_keys($list_ids);
                        }
                        
                        $current_lang = TravelHelper::current_lang();
                        $main_lang = TravelHelper::primary_lang();
                        $car = STCars::get_instance();
                        $car->alter_search_query();
                        $query_service = new WP_Query($args);
                        $html = '<div class="service-list-wrapper'.esc_attr($row_class).'">';
                        if($list_style == 'slider'){
                            $html .= '<div class="swiper-wrapper">' ;
                        }
                        while ($query_service->have_posts()):
                            $query_service->the_post();
                            if($list_style == 'list'){
                                $html .= st()->load_template('layouts/elementor/car/loop/normal-list', '', array('slider' => $list_style));
                            } else {
                                $html .= st()->load_template('layouts/elementor/car/loop/normal-grid', '', array('slider' => $list_style, 'item_row' => $item_row));
                            }
                        endwhile;
                        $car->remove_alter_search_query();
                        wp_reset_postdata();
                        $post = $old_post;
                        if($list_style == 'slider'){
                            $html .= '</div>';
                        }
                        $html .= '</div>';
                        if($list_style == 'slider'){
                            if($pagination == 'on'){
                                $html .= '<div class="swiper-pagination"></div>';
                            }
                            if($navigation == 'on'){
                                $html .= '<div class="st-button-prev"><span></span></div><div class="st-button-next"><span></span></div>';
                            }
                        }
                        echo balanceTags($html);
                        echo '</div>';
                    }
                    break;
            }
        } ?>
        
    </div>
</div>

<?php
global $post;
$old_post = $post;


$attrs = [];
if ($list_style == 'slider') {
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

if ($type_form === 'mix_service') {
    $v = !empty($services) ? ST_Elementor::st_explode_select2($services) : array();
} else {
    $v = $service;
}

$item_row_tablet =  2;
$item_row_tablet_extra = 2;

if (!empty($v) && $type_form  !== 'mix_service') { ?>
    <div class="st-list-service <?php echo esc_attr($list_style . ' ' . $style); ?>" <?php echo st_render_html_attributes($attrs); ?> 
    >
        <?php
        $args = [
            'post_type' => $v,
            'posts_per_page' => $posts_per_page,
            'order' => $order,
            'orderby' => $orderby,
            'post_status' => 'publish'
        ];
        switch ($v) {
            case 'st_hotel':
                if (st_check_service_available('st_hotel')) {
                    
                    if (!empty($category_hotel)) {
                        $term_tax_hotel = explode(":", $category_hotel);
                        
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
                    $hotel->remove_alter_search_query();
                    if ($query_service->have_posts()) {
                        if ($list_style == 'grid') {
                            $html = '<div class="service-list-wrapper"><div class="row">';
                            $col_classes = 'col-lg-12';

                            if (!empty($item_row)) {
                                $col_classes = 'col-12'.' col-sm-12 col-md-'.(12 / $item_row_tablet_extra).' col-lg-'.(12 / $item_row_tablet_extra). ' col-xl-'.(12 / $item_row);  
                            }
                            while ($query_service->have_posts()):
                                $query_service->the_post();
                                $html .= '<div class="' . esc_attr($col_classes) . '">';
                                $html .= stt_elementorv2()->loadView('services/hotel/loop/grid');
                                $html .= '</div>';
                            endwhile;
                            $hotel->remove_alter_search_query();
                            wp_reset_postdata();
                            $post = $old_post;
                            $html .= '</div></div>';
                        } elseif ($list_style == 'slider') {
                            $html = '<div class="service-list-wrapper swiper-container"><div class="swiper-wrapper">';
                            
                            while ($query_service->have_posts()):
                                $query_service->the_post();
                                $html .= '<div class="swiper-slide">';
                                $html .= stt_elementorv2()->loadView('services/hotel/loop/grid');
                                $html .= '</div>';
                            endwhile;
                            $hotel->remove_alter_search_query();
                            wp_reset_postdata();
                            $post = $old_post;
                            $html .= '</div>';
                            if ($pagination == 'on') {
                                $html .= '<div class="swiper-pagination"></div>';
                            }
                            $html .= '</div>';
                            if ($navigation == 'on') {
                                $html .= '<div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"></span></div><div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"></span></div>';
                            }
                        } else {
                            $html = '<div class="row service-list-wrapper list-style">';
                            $col_classes = 'col-lg-12';
                            while ($query_service->have_posts()):
                                $query_service->the_post();
                                $html .= '<div class="' . esc_attr($col_classes) . '">';
                                if($style_list == 'vertical'){
                                    $html .= stt_elementorv2()->loadView('services/hotel/loop/list');
                                } else {
                                    $html .= stt_elementorv2()->loadView('services/hotel/loop/list-2');
                                }
                                
                                $html .= '</div>';
                            endwhile;
                            $hotel->remove_alter_search_query();
                            wp_reset_postdata();
                            $post = $old_post;
                            $html .= '</div>';
                        }
                        echo balanceTags($html);
                    }
                }
                break;
            case 'st_tours':
                if (st_check_service_available('st_tours')) {
                    
                    if (!empty($category_tour)) {
                        $term_tax_tour = explode(":", $category_tour);
                        
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
                    if ($query_service->have_posts()) {
                        if ($list_style == 'grid') {
                            $html = '<div class="service-list-wrapper service-tour"><div class="row">';
                            $col_classes = 'col-lg-12';
                          
                            if (!empty($item_row)) {
                            
                                if (!empty($item_row)) {
                                    $col_classes = 'col-12'.' col-sm-12 col-md-'.(12 / $item_row_tablet_extra).' col-lg-'.(12 / $item_row_tablet_extra). ' col-xl-'.(12 / $item_row);  
                                }
                                
                            }
                            while ($query_service->have_posts()):
                                $query_service->the_post();
                                $html .= '<div class="' . esc_attr($col_classes) . '">';
                                $html .= stt_elementorv2()->loadView('services/tour/loop/grid');
                                $html .= '</div>';
                            endwhile;
                            $tour->remove_alter_search_query();
                            wp_reset_postdata();
                            $post = $old_post;
                            $html .= '</div></div>';
                        } elseif ($list_style == 'slider') {
                            $html = '<div class="service-list-wrapper service-tour swiper-container"><div class="swiper-wrapper">';
                            $col_classes = 'col-lg-12';
                            
                            while ($query_service->have_posts()):
                                $query_service->the_post();
                                $html .= '<div class="swiper-slide">';
                                $html .= stt_elementorv2()->loadView('services/tour/loop/grid');
                                $html .= '</div>';
                            endwhile;
                            $tour->remove_alter_search_query();
                            wp_reset_postdata();
                            $post = $old_post;
                            $html .= '</div>';
                            if ($pagination == 'on') {
                                $html .= '<div class="swiper-pagination"></div>';
                            }
                            $html .= '</div>';
                            if ($navigation == 'on') {
                                $html .= '<div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"></span></div><div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"></span></div>';;
                            }
                        }else {
                            $html = '<div class="row service-list-wrapper service-tour list-style style-list">';
                            $col_classes = 'col-12 item-service';
                            while ($query_service->have_posts()):
                                $query_service->the_post();
                                $html .= '<div class="' . esc_attr($col_classes) . '">';
                                $html .= stt_elementorv2()->loadView('services/tour/loop/list');
                                $html .= '</div>';
                            endwhile;
                            $tour->remove_alter_search_query();
                            wp_reset_postdata();
                            $post = $old_post;
                            $html .= '</div>';
                        }
                        echo balanceTags($html);
                    }
                }
                break;
            case 'st_activity':
                if (st_check_service_available('st_activity')) {
                    
                    if (!empty($category_activity)) {
                        $term_tax_activity = explode(":", $category_activity);

                        if ($term_tax_activity[0] != 0) {
                            $taxonomies = TravelHelper::st_get_attribute_advance($v);
                            $arr_tax = [
                                'relation' => 'OR',
                            ];
                            foreach($taxonomies as $tax){
                                if(!empty($tax["value"])){
                                    $arr_tax[] = array(
                                        'taxonomy' => $tax["value"],
                                        'field' => 'term_id',
                                        'terms' => intval($term_tax_activity[0]),
                                    );
                                }
                                
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
                    $activity->remove_alter_search_query();
                    if ($query_service->have_posts()) {
                        if ($list_style == 'grid') {
                            $html = '<div class="service-list-wrapper service-tour"><div class="row">';
                            $col_classes = 'col-lg-12'; 
                            if (!empty($item_row)) {
                                $col_classes = 'col-12'.' col-sm-12 col-md-'.(12 / $item_row_tablet_extra).' col-lg-'.(12 / $item_row_tablet_extra). ' col-xl-'.(12 / $item_row);    
                            }
                            while ($query_service->have_posts()):
                                $query_service->the_post();
                                $html .= '<div class="' . esc_attr($col_classes) . '">';
                                $html .= stt_elementorv2()->loadView('services/activity/loop/grid');
                                $html .= '</div>';
                            endwhile;
                            $activity->remove_alter_search_query();
                            wp_reset_postdata();
                            $post = $old_post;
                            $html .= '</div></div>';
                        } elseif ($list_style == 'slider') {
                            $html = '<div class="service-list-wrapper service-tour swiper-container"><div class="swiper-wrapper">';
                            $col_classes = 'col-lg-12';
            
                            while ($query_service->have_posts()):
                                $query_service->the_post();
                                $html .= '<div class="swiper-slide">';
                                $html .= stt_elementorv2()->loadView('services/activity/loop/grid');
                                $html .= '</div>';
                            endwhile;
                            $activity->remove_alter_search_query();
                            wp_reset_postdata();
                            $post = $old_post;
                            $html .= '</div>';
                            if ($pagination == 'on') {
                                $html .= '<div class="swiper-pagination"></div>';
                            }
                            $html .= '</div>';
                            if ($navigation == 'on') {
                                $html .= '<div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"></span></div><div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"></span></div>';
                            }
                        }else {
                            $html = '<div class="row service-list-wrapper service-tour list-style style-list">';
                            $col_classes = 'col-12 item-service';
                            while ($query_service->have_posts()):
                                $query_service->the_post();
                                $html .= '<div class="' . esc_attr($col_classes) . '">';
                                $html .= stt_elementorv2()->loadView('services/activity/loop/list');
                                $html .= '</div>';
                            endwhile;
                            $activity->remove_alter_search_query();
                            wp_reset_postdata();
                            $post = $old_post;
                            $html .= '</div>';
                        }
                        echo balanceTags($html);
                    }
                }
            break;
            case 'st_cars':
                if (st_check_service_available('st_cars')) {
                    
                    if (!empty($category_car)) {
                        $term_tax_car = explode(":", $category_car);

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
                    $cars = STCars::get_instance();
                    $cars->alter_search_query();
                    $query_service = new WP_Query($args);
                    $cars->remove_alter_search_query();
                    if ($query_service->have_posts()) {
                        if ($list_style == 'grid') {
                            $html = '<div class="service-list-wrapper car-layout4 service-tour"><div class="row">';
                            $col_classes = 'col-lg-12';

                            if (!empty($item_row)) {
                                $col_classes = 'col-12'.' col-sm-12 col-md-'.(12 / $item_row_tablet_extra).' col-lg-'.(12 / $item_row_tablet_extra). ' col-xl-'.(12 / $item_row);   
                            }

                            while ($query_service->have_posts()):
                                $query_service->the_post();
                                $html .= '<div class="' . esc_attr($col_classes) . '">';
                                $html .= stt_elementorv2()->loadView('services/car/loop/grid');
                                $html .= '</div>';
                            endwhile;
                            $cars->remove_alter_search_query();
                            wp_reset_postdata();
                            $post = $old_post;
                            $html .= '</div></div>';
                        } elseif ($list_style == 'slider') {
                            $html = '<div class="service-list-wrapper service-tour car-layout4 swiper-container"><div class="swiper-wrapper">';
                            $col_classes = 'col-lg-12';
                           
                            while ($query_service->have_posts()):
                                $query_service->the_post();
                                $html .= '<div class="swiper-slide">';
                                $html .= stt_elementorv2()->loadView('services/car/loop/grid');
                                $html .= '</div>';
                            endwhile;
                            $cars->remove_alter_search_query();
                            wp_reset_postdata();
                            $post = $old_post;
                            $html .= '</div>';
                            if ($pagination == 'on') {
                                $html .= '<div class="swiper-pagination"></div>';
                            }
                            $html .= '</div>';
                            if ($navigation == 'on') {
                                $html .= '<div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"></span></div><div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"></span></div>';
                            }
                        }else {
                            $html = '<div class="row service-list-wrapper  car-layout4 service-tour list-style style-list">';
                            $col_classes = 'col-12 item-service';
                            while ($query_service->have_posts()):
                                $query_service->the_post();
                                $html .= '<div class="' . esc_attr($col_classes) . '">';
                                $html .= stt_elementorv2()->loadView('services/car/loop/list');
                                $html .= '</div>';
                            endwhile;
                            $cars->remove_alter_search_query();
                            wp_reset_postdata();
                            $post = $old_post;
                            $html .= '</div>';
                        }
                        echo balanceTags($html);
                    }
                }
            break;
            case 'st_rental':
                if (st_check_service_available('st_rental')) {
                    
                    if (!empty($category_rental)) {
                        $term_tax_rental = explode(":", $category_rental);

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
                    $rental->remove_alter_search_query();
                    if ($query_service->have_posts()) {
                        if ($list_style == 'grid') {
                            $html = '<div class="service-list-wrapper rental-grid service-tour"><div class="row">';
                            $col_classes = 'col-lg-12';
                           
                            if (!empty($item_row)) {
                                $col_classes = 'col-12'.' col-sm-12 col-md-'.(12 / $item_row_tablet_extra).' col-lg-'.(12 / $item_row_tablet_extra). ' col-xl-'.(12 / $item_row);  
                            }
                            while ($query_service->have_posts()):
                                $query_service->the_post();
                                $html .= '<div class="' . esc_attr($col_classes) . '">';
                                $html .= stt_elementorv2()->loadView('services/rental/loop/grid');
                                $html .= '</div>';
                            endwhile;
                            $rental->remove_alter_search_query();
                            wp_reset_postdata();
                            $post = $old_post;
                            $html .= '</div></div>';
                        } elseif ($list_style == 'slider') {
                            $html = '<div class="service-list-wrapper service-tour car-layout4 swiper-container"><div class="swiper-wrapper">';
                            $col_classes = 'col-lg-12';
                            
                            while ($query_service->have_posts()):
                                $query_service->the_post();
                                $html .= '<div class="swiper-slide">';
                                $html .= stt_elementorv2()->loadView('services/rental/loop/grid');
                                $html .= '</div>';
                            endwhile;
                            $rental->remove_alter_search_query();
                            wp_reset_postdata();
                            $post = $old_post;
                            $html .= '</div>';
                            if ($pagination == 'on') {
                                $html .= '<div class="swiper-pagination"></div>';
                            }
                            $html .= '</div>';
                            if ($navigation == 'on') {
                                $html .= '<div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"></span></div><div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"></span></div>';
                            }
                        }else {
                            $html = '<div class="row service-list-wrapper list-style">';
                            $html .= '<div class="col-12 item-service">';
                                if($style_list == 'vertical'){
                                    $col_classes = 'services-item list item-elementor';
                                } else {
                                    $col_classes = 'services-item list list-2 item-elementor';
                                }
                                while ($query_service->have_posts()):
                                    $query_service->the_post();
                                    $html .= '<div class="' . esc_attr($col_classes) . '">';
                                    if($style_list == 'vertical'){
                                        $html .= stt_elementorv2()->loadView('services/rental/loop/list-2');
                                    } else {
                                        $html .= stt_elementorv2()->loadView('services/rental/loop/list');
                                    }
                                    
                                    $html .= '</div>';
                                endwhile;
                            $html .= '</div>';
                            $rental->remove_alter_search_query();
                            wp_reset_postdata();
                            $post = $old_post;
                            $html .= '</div>';
                        }
                        echo balanceTags($html);
                    }
                }
            break;
        }
        ?>
    </div>
<?php } else { 
    $services = $v;
    ?>
    <div  class="list-tab-wrapper mix-multi <?php echo esc_attr($style);?>">
        <?php if(count($services)>1){?>
            <nav>
                <ul class="nav nav-tabs d-flex align-items-center justify-content-center nav-fill-st" id="nav-tab" role="tablist">
                    <?php 
                        foreach($services as $key=>$service){ 
                            if($key !== 'st_flight'):?>
                            <li><a class="text-center  <?php if($key== array_key_first($services) ){echo 'active';}?>" id="nav-list-of_service<?php echo esc_attr($service);?>-tab" data-bs-toggle="tab" data-bs-target="#nav-list-of_service<?php echo esc_attr($key);?>"
                                            role="tab" aria-controls="nav-list-of_service<?php echo esc_attr($key);?>"
                                            aria-selected="true"><?php echo esc_html(ST_Elementor::get_title_service($key)); ?></a>
                            </li>
                        <?php 
                        endif;    
                        }
                    ?>
                </ul>
            </nav>
        <?php }?>
        <div class="tab-content" id="nav-content-wishlist">
            <?php
            $active_tab = false;
            if(count($services) == 1){
                $active_tab = true;
            }
            $action_ajax = '';
            foreach($services as $key=>$service){
                ?>
                    <div class="tab-pane stt-tab-list-ofservice <?php if($key== array_key_first($services) || $active_tab==true ){echo 'active';}?>" id="nav-list-of_service<?php echo esc_attr($key);?>" role="tabpanel"
                    aria-labelledby="nav-list-of_service<?php echo esc_attr($key);?>">
                        <div class="modern-search-result service-list-wrapper <?php if($key == 'st_tours' || $key == 'st_activity'){echo ' service-tour';}?>">
                            <?php 
                                switch ($key) {
                                    case 'st_hotel':
                                        if (st_check_service_available('st_hotel')) {
                                            $action_ajax = 'st_filter_hotel_ajax';
                                            $paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
                                            $args = [
                                                'post_type' => $key,
                                                'order' => $order,
                                                'orderby' => $orderby,
                                                'posts_per_page' => $posts_per_page,
                                            ];
                                            
                                            if (!empty($category_hotel)) {
                                                $term_tax_hotel = explode(":", $category_hotel);
                                                
                                                if ($term_tax_hotel[0] != 0) {
                                                    $taxonomies = TravelHelper::st_get_attribute_advance($v);
                                                    $arr_tax = [
                                                        'relation' => 'OR',
                                                    ];
                                                    foreach($taxonomies as $tax){
                                                        $arr_tax[] = array(
                                                            'taxonomy' => $tax,
                                                            'field' => 'term_id',
                                                            'terms' => $term_tax_hotel[0],
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
                                            $hotel->remove_alter_search_query();
                                            if ($query_service->have_posts()) {
                                                if ($list_style == 'grid') {
                                                    $html = '<div class="row">';
                                                    $col_classes = 'col-lg-12';
                                                                        
                                                    if (!empty($item_row)) {
                                                        $col_classes = 'col-12'.' col-sm-12 col-md-'.(12 / $item_row_tablet_extra).' col-lg-'.(12 / $item_row_tablet_extra). ' col-xl-'.(12 / $item_row);  
                                                    }
                                                    while ($query_service->have_posts()):
                                                        $query_service->the_post();
                                                        $html .= '<div class="' . esc_attr($col_classes) . '">';
                                                        $html .= stt_elementorv2()->loadView('services/hotel/loop/grid');
                                                        $html .= '</div>';
                                                    endwhile;
                                                    $hotel->remove_alter_search_query();
                                                    wp_reset_postdata();
                                                    $post = $old_post;
                                                    $html .= '</div>';
                                                } elseif ($list_style == 'slider') {
                                                    $html = '<div class="service-list-wrapper swiper-container"><div class="swiper-wrapper">';
                                                    
                                                    while ($query_service->have_posts()):
                                                        $query_service->the_post();
                                                        $html .= '<div class="swiper-slide">';
                                                        $html .= stt_elementorv2()->loadView('services/hotel/loop/grid');
                                                        $html .= '</div>';
                                                    endwhile;
                                                    $hotel->remove_alter_search_query();
                                                    wp_reset_postdata();
                                                    $post = $old_post;
                                                    $html .= '</div>';
                                                    if ($pagination == 'on') {
                                                        $html .= '<div class="swiper-pagination"></div>';
                                                    }
                                                    $html .= '</div>';
                                                    if ($navigation == 'on') {
                                                        $html .= '<div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"></span></div><div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"></span></div>';;
                                                    }
                                                } else {
                                                    $html = '<div class="row service-list-wrapper list-style">';
                                                    $col_classes = 'col-lg-12';
                                                    while ($query_service->have_posts()):
                                                        $query_service->the_post();
                                                        $html .= '<div class="' . esc_attr($col_classes) . '">';
                                                        $html .= stt_elementorv2()->loadView('services/hotel/loop/list');
                                                        $html .= '</div>';
                                                    endwhile;
                                                    $hotel->remove_alter_search_query();
                                                    
                                                    $post = $old_post;
                                                    $html .= '</div>';
                                                }
                                                echo balanceTags($html); ?>
                                            <?php 
                                                wp_reset_postdata();
                                            }
                                        }
                                        break;
                                    case 'st_tours':
                                        if (st_check_service_available('st_tours')) {
                                            $action_ajax = 'st_filter_tour_ajax';
                                            $args_tour = [
                                                'post_type' => $key,
                                                'posts_per_page' => $posts_per_page,
                                                'order' => $order,
                                                'orderby' => $orderby,
                                            ];
                                            
                                            if (!empty($category_tour)) {
                                                $term_tax_tour = explode(":", $category_tour);
                        
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
                                                    $args_tour['tax_query'] = $arr_tax_tour;
                                                }
                        
                                            }
                                            if($orderby === 'post__in' && !empty($post_ids_tour) && $type_form == 'single'){
                                                $list_ids = ST_Elementor::st_explode_select2($post_ids_tour);
                                                $args_tour['post__in'] = array_keys($list_ids);
                                            }
                                            $current_lang = TravelHelper::current_lang();
                                            $main_lang = TravelHelper::primary_lang();
                                            $tour = STTour::get_instance();
                                            $tour->alter_search_query();
                                            $query_service = new WP_Query($args_tour);
                                            $tour->remove_alter_search_query();
                                            if ($query_service->have_posts()) {
                                                if ($list_style == 'grid') {
                                                    $html = '<div class="row">';
                                                    $col_classes = 'col-lg-12';
                                                    
                                                    if (!empty($item_row)) {
                                                        $col_classes = 'col-12'.' col-sm-12 col-md-'.(12 / $item_row_tablet_extra).' col-lg-'.(12 / $item_row_tablet_extra). ' col-xl-'.(12 / $item_row);   
                                                    }
                                                    while ($query_service->have_posts()):
                                                        $query_service->the_post();
                                                        $html .= '<div class="' . esc_attr($col_classes) . '">';
                                                        $html .= stt_elementorv2()->loadView('services/tour/loop/grid');
                                                        $html .= '</div>';
                                                    endwhile;
                                                    $tour->remove_alter_search_query();
                                                    wp_reset_postdata();
                                                    $post = $old_post;
                                                    $html .= '</div>';
                                                } elseif ($list_style == 'slider') {
                                                    $html = '<div class="service-list-wrapper service-tour swiper-container"><div class="swiper-wrapper">';
                                                    $col_classes = 'col-lg-12';
                                                   
                                                    while ($query_service->have_posts()):
                                                        $query_service->the_post();
                                                        $html .= '<div class="swiper-slide">';
                                                        $html .= stt_elementorv2()->loadView('services/tour/loop/grid');
                                                        $html .= '</div>';
                                                    endwhile;
                                                   
                                                    wp_reset_postdata();
                                                    $post = $old_post;
                                                    $html .= '</div>';
                                                    if ($pagination == 'on') {
                                                        $html .= '<div class="swiper-pagination"></div>';
                                                    }
                                                    $html .= '</div>';
                                                    if ($navigation == 'on') {
                                                        $html .= '<div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"></span></div><div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"></span></div>';;
                                                    }
                                                }else {
                                                    $html = '<div class="row service-list-wrapper service-tour list-style style-list">';
                                                    $col_classes = 'col-lg-4 col-md-4 col-12 item-service';
                                                    while ($query_service->have_posts()):
                                                        $query_service->the_post();
                                                        $html .= '<div class="' . esc_attr($col_classes) . '">';
                                                        $html .= stt_elementorv2()->loadView('services/tour/loop/list');
                                                        $html .= '</div>';
                                                    endwhile;
                                                    $tour->remove_alter_search_query();
                                                    wp_reset_postdata();
                                                    $post = $old_post;
                                                    $html .= '</div>';
                                                }
                                                echo balanceTags($html);
                                                ?>
                                            <?php 
                                                wp_reset_postdata();
                                            }
                                        }
                                        break;
                                    case 'st_activity':
                                        if (st_check_service_available('st_activity')) {
                                            $action_ajax = 'st_filter_activity_ajax';
                                            $args_activity = [
                                                'post_type' => $key,
                                                'posts_per_page' => $posts_per_page,
                                                'order' => $order,
                                                'orderby' => $orderby,
                                            ];
                                            
                                            if (!empty($category_activity)) {
                                                $term_tax_activity = explode(":", $category_activity);
                        
                                                if ($term_tax_activity[0] != 0) {
                                                    $taxonomies = TravelHelper::st_get_attribute_advance($v);
                                                    $arr_tax = [
                                                        'relation' => 'OR',
                                                    ];
                                                    foreach($taxonomies as $tax){
                                                        if(!empty($tax["value"])){
                                                            $arr_tax[] = array(
                                                                'taxonomy' => $tax["value"],
                                                                'field' => 'term_id',
                                                                'terms' => intval($term_tax_activity[0]),
                                                            );
                                                        }
                                                        
                                                    }
                                                    $args_activity['tax_query'] = $arr_tax;
                                                }
                        
                                            }
                                            if($orderby === 'post__in' && !empty($post_ids_activity) && $type_form == 'single'){
                                                $list_ids = ST_Elementor::st_explode_select2($post_ids_activity);
                                                $args_activity['post__in'] = array_keys($list_ids);
                                            }
                                            $current_lang = TravelHelper::current_lang();
                                            $main_lang = TravelHelper::primary_lang();
                                            $activity = STActivity::inst();
                                            $activity->alter_search_query();
                                            $query_service = new WP_Query($args_activity);
                                            $activity->remove_alter_search_query();
                                            if ($query_service->have_posts()) {
                                                if ($list_style == 'grid') {
                                                    $html = '<div class="row">';
                                                    $col_classes = 'col-lg-12';
                                                                            
                                                    if (!empty($item_row)) {
                                                        $col_classes = 'col-12'.' col-sm-12 col-md-'.(12 / $item_row_tablet_extra).' col-lg-'.(12 / $item_row_tablet_extra). ' col-xl-'.(12 / $item_row);    
                                                    }
                                                    while ($query_service->have_posts()):
                                                        $query_service->the_post();
                                                        $html .= '<div class="' . esc_attr($col_classes) . '">';
                                                        $html .= stt_elementorv2()->loadView('services/activity/loop/grid');
                                                        $html .= '</div>';
                                                    endwhile;
                                                    $activity->remove_alter_search_query();
                                                    wp_reset_postdata();
                                                    $post = $old_post;
                                                    $html .= '</div>';
                                                } elseif ($list_style == 'slider') {
                                                    $html = '<div class="service-list-wrapper service-tour swiper-container"><div class="swiper-wrapper">';
                                                    $col_classes = 'col-lg-12';
                                                   
                                                    while ($query_service->have_posts()):
                                                        $query_service->the_post();
                                                        $html .= '<div class="swiper-slide">';
                                                        $html .= stt_elementorv2()->loadView('services/activity/loop/grid');
                                                        $html .= '</div>';
                                                    endwhile;
                                                    $activity->remove_alter_search_query();
                                                    wp_reset_postdata();
                                                    $post = $old_post;
                                                    $html .= '</div>';
                                                    if ($pagination == 'on') {
                                                        $html .= '<div class="swiper-pagination"></div>';
                                                    }
                                                    $html .= '</div>';
                                                    if ($navigation == 'on') {
                                                        $html .= '<div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"></span></div><div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"></span></div>';
                                                    }
                                                }else {
                                                    $html = '<div class="row service-list-wrapper service-tour list-style style-list">';
                                                    $col_classes = 'col-lg-4 col-md-4 col-12 item-service';
                                                    while ($query_service->have_posts()):
                                                        $query_service->the_post();
                                                        $html .= '<div class="' . esc_attr($col_classes) . '">';
                                                        $html .= stt_elementorv2()->loadView('services/activity/loop/list');
                                                        $html .= '</div>';
                                                    endwhile;
                                                    $activity->remove_alter_search_query();
                                                    wp_reset_postdata();
                                                    $post = $old_post;
                                                    $html .= '</div>';
                                                }
                                                echo balanceTags($html);?>
                                            <?php 
                                                wp_reset_postdata();
                                            }
                                        }
                                    break;

                                    case 'st_cars':
                                        if (st_check_service_available('st_cars')) {
                                            $action_ajax = 'st_filter_cars_ajax';
                                            $args_car = [
                                                'post_type' => $key,
                                                'posts_per_page' => $posts_per_page,
                                                'order' => $order,
                                                'orderby' => $orderby,
                                            ];
                                            
                                            if (!empty($category_car)) {
                                                $term_tax_car = explode(":", $category_car);
                        
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
                                                    $args_car['tax_query'] = $arr_tax;
                                                }
                        
                                            }
                                            if($orderby === 'post__in' && !empty($post_ids_car) && $type_form == 'single'){
                                                $list_ids = ST_Elementor::st_explode_select2($post_ids_car);
                                                $args_car['post__in'] = array_keys($list_ids);
                                            }
                                            $current_lang = TravelHelper::current_lang();
                                            $main_lang = TravelHelper::primary_lang();
                                            $cars = STCars::get_instance();
                                            $cars->alter_search_query();
                                            $query_service = new WP_Query($args_car);
                                            $cars->remove_alter_search_query();
                                            if ($query_service->have_posts()) {
                                                if ($list_style == 'grid') {
                                                    $html = '<div class="row car-layout4">';
                                                    $col_classes = 'col-lg-12';
                                                                        
                                                    if (!empty($item_row)) {
                                                        $col_classes = 'col-12'.' col-sm-12 col-md-'.(12 / $item_row_tablet_extra).' col-lg-'.(12 / $item_row_tablet_extra). ' col-xl-'.(12 / $item_row);    
                                                    }
                                                    while ($query_service->have_posts()):
                                                        $query_service->the_post();
                                                        $html .= '<div class="' . esc_attr($col_classes) . '">';
                                                        $html .= stt_elementorv2()->loadView('services/car/loop/grid');
                                                        $html .= '</div>';
                                                    endwhile;
                                                    $cars->remove_alter_search_query();
                                                    wp_reset_postdata();
                                                    $post = $old_post;
                                                    $html .= '</div>';
                                                } elseif ($list_style == 'slider') {
                                                    $html = '<div class="service-list-wrapper car-layout4 service-tour swiper-container"><div class="swiper-wrapper">';
                                                    $col_classes = 'col-lg-12';
                                                                        
                                                    while ($query_service->have_posts()):
                                                        $query_service->the_post();
                                                        $html .= '<div class="swiper-slide">';
                                                        $html .= stt_elementorv2()->loadView('services/car/loop/grid');
                                                        $html .= '</div>';
                                                    endwhile;
                                                    $cars->remove_alter_search_query();
                                                    wp_reset_postdata();
                                                    $post = $old_post;
                                                    $html .= '</div>';
                                                    if ($pagination == 'on') {
                                                        $html .= '<div class="swiper-pagination"></div>';
                                                    }
                                                    $html .= '</div>';
                                                    if ($navigation == 'on') {
                                                        $html .= '<div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"></span></div><div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"></span></div>';
                                                    }
                                                }else {
                                                    $html = '<div class="row  car-layout4 service-list-wrapper service-tour list-style style-list">';
                                                    $col_classes = 'col-lg-4 col-md-4 col-12 item-service';
                                                    while ($query_service->have_posts()):
                                                        $query_service->the_post();
                                                        $html .= '<div class="' . esc_attr($col_classes) . '">';
                                                        $html .= stt_elementorv2()->loadView('services/car/loop/list');
                                                        $html .= '</div>';
                                                    endwhile;
                                                    $cars->remove_alter_search_query();
                                                    wp_reset_postdata();
                                                    $post = $old_post;
                                                    $html .= '</div>';
                                                }
                                                echo balanceTags($html);
                                                wp_reset_postdata();
                                            }
                                        }
                                    break;


                                    case 'st_rental':
                                        if (st_check_service_available('st_rental')) {
                                            $action_ajax = 'st_filter_rental_ajax';
                                            $args_rental = [
                                                'post_type' => $key,
                                                'posts_per_page' => $posts_per_page,
                                                'order' => $order,
                                                'orderby' => $orderby,
                                            ];
                                            
                                            if (!empty($category_rental)) {
                                                $term_tax_rental = explode(":", $category_rental);
                        
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
                                                    $args_rental['tax_query'] = $arr_tax;
                                                }
                        
                                            }
                                            if($orderby === 'post__in' && !empty($post_ids_rental) && $type_form == 'single'){
                                                $list_ids = ST_Elementor::st_explode_select2($post_ids_rental);
                                                $args_rental['post__in'] = array_keys($list_ids);
                                            }
                                            $current_lang = TravelHelper::current_lang();
                                            $main_lang = TravelHelper::primary_lang();
                                            $rental = STRental::inst();
                                            $rental->alter_search_query();
                                            $query_service = new WP_Query($args_rental);
                                            $rental->remove_alter_search_query();
                                            if ($query_service->have_posts()) {
                                                if ($list_style == 'grid') {
                                                    $html = '<div class="row service-list-wrapper rental-grid service-tour">';
                                                    $col_classes = 'col-lg-12';
                                                   
                                                    if (!empty($item_row)) {
                                                        $col_classes = 'col-12'.' col-sm-12 col-md-'.(12 / $item_row_tablet_extra).' col-lg-'.(12 / $item_row_tablet_extra). ' col-xl-'.(12 / $item_row);   
                                                    }
                                                    while ($query_service->have_posts()):
                                                        $query_service->the_post();
                                                        $html .= '<div class="' . esc_attr($col_classes) . '">';
                                                        $html .= stt_elementorv2()->loadView('services/rental/loop/grid');
                                                        $html .= '</div>';
                                                    endwhile;
                                                    $rental->remove_alter_search_query();
                                                    wp_reset_postdata();
                                                    $post = $old_post;
                                                    $html .= '</div>';
                                                } elseif ($list_style == 'slider') {
                                                    $html = '<div class="service-list-wrapper service-tour car-layout4 swiper-container"><div class="swiper-wrapper">';
                                                    $col_classes = 'col-lg-12';
                                                    
                                                    while ($query_service->have_posts()):
                                                        $query_service->the_post();
                                                        $html .= '<div class="swiper-slide">';
                                                        $html .= stt_elementorv2()->loadView('services/rental/loop/grid');
                                                        $html .= '</div>';
                                                    endwhile;
                                                    $rental->remove_alter_search_query();
                                                    wp_reset_postdata();
                                                    $post = $old_post;
                                                    $html .= '</div>';
                                                    if ($pagination == 'on') {
                                                        $html .= '<div class="swiper-pagination"></div>';
                                                    }
                                                    $html .= '</div>';
                                                    if ($navigation == 'on') {
                                                        $html .= '<div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"></span></div><div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"></span></div>';
                                                    }
                                                }else {
                                                    $html = '<div class="row service-list-wrapper car-layout4 service-tour list-style style-list">';
                                                    $col_classes = 'col-lg-4 col-md-4 col-12 item-service';
                                                    while ($query_service->have_posts()):
                                                        $query_service->the_post();
                                                        $html .= '<div class="' . esc_attr($col_classes) . '">';
                                                        $html .= stt_elementorv2()->loadView('services/rental/loop/list');
                                                        $html .= '</div>';
                                                    endwhile;
                                                    $rental->remove_alter_search_query();
                                                    wp_reset_postdata();
                                                    $post = $old_post;
                                                    $html .= '</div>';
                                                }
                                                echo balanceTags($html);
                                            }
                                        }
                                    break;
                                }
                            ?>
                        </div>
                        <?php echo st()->load_template('layouts/elementor/common/loader', 'content'); ?>
                        <div class="panigation-list-new-style pagination moderm-pagination" data-stt_service = "<?php echo esc_attr($key);?>" data-action_service = "<?php echo esc_attr($action_ajax);?>" 
                            data-order = "<?php echo esc_attr($order);?>"
                            data-orderby = "<?php echo esc_attr($orderby);?>"
                            data-st_item_row = "<?php echo esc_attr($item_row);?>"
                            data-st_item_row_tablet = "<?php echo esc_attr($item_row_tablet);?>"
                            data-st_item_row_tablet_extra = "<?php echo esc_attr($item_row_tablet_extra);?>"
                            <?php 
                                if(get_post_type(get_the_ID()) === 'location'){ ?>
                                    data-st_location_id = <?php echo get_the_ID();?>
                                <?php }
                            ?>
                            data-posts_per_page="<?php echo esc_attr($posts_per_page) ?>">
                            <?php echo TravelHelper::paging($query_service, false); ?>
                        </div>
                    </div>
            <?php }?>
        </div>
    </div>
<?php }
?>

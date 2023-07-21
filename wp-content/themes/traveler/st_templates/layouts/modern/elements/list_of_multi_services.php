<?php
/**
 * Created by PhpStorm.
 * User: HanhDo
 * Date: 2/18/2019
 * Time: 1:56 PM
 */
$list_services = vc_param_group_parse_atts($list_services);
if(!empty($list_services)){
    ?>
    <div class="st-list-of-multi-services">
        <h2 class="title">
            <?php
            if(!empty($heading))
                echo esc_html($heading) . ': ';
            ?>
            <div class="st-list-dropdown">
                <div class="header" data-value="<?php echo esc_attr($list_services[0]['service']) ?>">
                    <span><?php echo isset($list_services[0]['name']) ? $list_services[0]['name'] : ''; ?></span>
                    <?php if(count($list_services) > 1){ ?>
                    <i class="fa fa-angle-down"></i>
                    <?php } ?>
                </div>
                <?php if(count($list_services) > 1){ ?>
                <ul class="list">
                    <?php
                        $i = 0;
                        foreach ($list_services as $k => $v){
                            $args_list = [
                                'post_type'      => $v['service'],
                                'posts_per_page' => $posts_per_page,
                                'order'          => 'ASC',
                                'orderby'        => 'name',
                            ];
                            if ( isset($v['ids']) ) {
                                $args_list[ 'post__in' ] = explode( ',', $v['ids'] );
                                $args_list['orderby'] = 'post__in';
                            }
                            
                            $class = '';
                            if($i == 0)
                                $class = 'active';
                            echo "<li data-value='". esc_attr($v['service']) ."' data-arg ='".str_ireplace(array("'"),'\"',balanceTags(wp_json_encode($args_list)))."' class='". esc_attr($class) ."'>". esc_html($v['name']) ."</li>";
                            $i++;
                        }
                    ?>
                </ul>
                <?php } ?>
            </div>
        </h2>
        <div class="map-loading" style="display:none"></div>
        <div class="multi-service-wrapper">
            <?php
            $v= $list_services[0];
            global $post;
            $old_post = $post;

            $args = [
                'post_type'      => $v['service'],
                'posts_per_page' => $posts_per_page,
                'order'          => 'ASC',
                'orderby'        => 'name',
            ];
            if ( isset($v['ids']) ) {
                $args[ 'post__in' ] = explode( ',', $v['ids'] );
                $args['orderby'] = 'post__in';
            }
            switch ($v['service']){
                case 'st_hotel':
                    if(st_check_service_available('st_hotel')) {
                        echo '<div class="tab-content '. esc_attr($v['service']) .'">';
                        global $wp_query , $st_search_query;
                        $current_lang = TravelHelper::current_lang();
                        $main_lang = TravelHelper::primary_lang();
                        $hotel = STHotel::inst();
                        $hotel->alter_search_query();
                         query_posts( $args );
                        $st_search_query = $wp_query;
                         $hotel->remove_alter_search_query();
                        wp_reset_postdata(); wp_reset_query();
                        global $wp_query, $st_search_query;
                        if ($st_search_query) {
                            $query = $st_search_query;
                        } else $query = $wp_query;
                        $html = '<div class="search-result-page st-tours service-slider-wrapper"><div class="st-hotel-result  services-grid"><div class="owl-carousel st-service-slider">';
                        while ($query->have_posts()):
                            $query->the_post();
                            $html .= st()->load_template('layouts/modern/hotel/loop/grid', '', array('slider' => true));
                        endwhile;
                        $hotel->remove_alter_search_query();
                        wp_reset_postdata();
                        $post = $old_post;
                        $html .= '</div></div></div>';
                        echo balanceTags($html);
                        echo '</div>';
                    }
                    break;
                case 'st_tours':
                    if(st_check_service_available('st_tours')) {
                        echo '<div class="tab-content '. esc_attr($v['service']) .'">';
                        $tour = STTour::get_instance();
                        $tour->alter_search_query();
                        $query = new WP_Query($args);
                        if ($query->have_posts()) {
                            echo '<div class="search-result-page st-tours service-slider-wrapper"><div class="st-hotel-result modern-search-result"><div class="owl-carousel st-service-slider">';
                            while ($query->have_posts()):
                                $query->the_post();
                                echo st()->load_template('layouts/modern/tour/elements/loop/grid', '', array('slider' => true));
                            endwhile;
                            echo '</div></div></div>';
                        }
                        $tour->remove_alter_search_query();
                        wp_reset_postdata();
                        $post = $old_post;
                        echo '</div>';
                    }
                    break;
                case 'st_activity':
                    if(st_check_service_available('st_activity')) {
                        echo '<div class="tab-content '. esc_attr($v['service']) .'">';
                        $activity = STActivity::inst();
                        $activity->alter_search_query();
                        $query = new WP_Query($args);
                        if ($query->have_posts()) {
                            echo '<div class="search-result-page st-tours service-slider-wrapper st_activity"><div class="st-hotel-result modern-search-result"><div class="owl-carousel st-service-slider">';
                            while ($query->have_posts()):
                                $query->the_post();
                                echo st()->load_template('layouts/modern/activity/elements/loop/grid', '', array('slider' => true));
                            endwhile;
                            echo '</div></div></div>';
                        }
                        $activity->remove_alter_search_query();
                        wp_reset_postdata();
                        $post = $old_post;
                        echo '</div>';
                    }
                    break;
                case 'st_rental':
                    if(st_check_service_available('st_rental')) {
                        echo '<div class="tab-content '. esc_attr($v['service']) .'">';
                        $rental = STRental::inst();
                        $rental->alter_search_query();
                        $query = new WP_Query($args);
                        $html = '<div class="search-result-page st-rental st-tours service-slider-wrapper"><div class="st-hotel-result services-grid"><div class="owl-carousel st-service-slider">';
                        while ($query->have_posts()):
                            $query->the_post();
                            $html .= st()->load_template('layouts/modern/rental/elements/loop/grid', '', array('slider' => true));
                        endwhile;
                        $rental->remove_alter_search_query();
                        wp_reset_postdata();
                        $post = $old_post;
                        $html .= '</div></div></div>';
                        echo balanceTags($html);
                        echo '</div>';
                    }
                    break;
                case 'st_cars':
                    if(st_check_service_available('st_cars')) {
                        echo '<div class="tab-content '. esc_attr($v['service']) .'">';
                        $car = STCars::get_instance();
                        $car->alter_search_query();
                        $query = new WP_Query($args);
                        $html = '<div class="search-result-page st-cars st-tours service-slider-wrapper"><div class="st-hotel-result  modern-search-result services-grid"><div class="owl-carousel st-service-slider">';
                        while ($query->have_posts()):
                            $query->the_post();
                            $html .= st()->load_template('layouts/modern/car/elements/loop/grid', '', array('slider' => true));
                        endwhile;
                        $car->remove_alter_search_query();
                        wp_reset_postdata();
                        $post = $old_post;
                        $html .= '</div></div></div>';
                        echo balanceTags($html);
                        echo '</div>';
                    }
                    break;
                }
            ?>
        </div>
    </div>
    <?php
}

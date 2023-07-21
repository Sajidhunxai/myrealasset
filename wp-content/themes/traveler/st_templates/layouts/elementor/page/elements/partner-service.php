<?php
if (!empty($arr_service)) {
    $active_tab = STInput::get('service', $arr_service[0]);
}
if (!empty($arr_service)) { ?>
    <ul class="nav nav-tabs" id="">
        <?php
        foreach ($arr_service as $k => $v) {
            if (STUser_f::_check_service_available_partner('st_'.$v, $current_user_upage->ID)) {
                $get = $_GET;
                $get['service'] = $v;
                unset($get['pages']);
                $author_link = esc_url(get_author_posts_url($current_user_upage->ID));
                $url = esc_url(add_query_arg($get, $author_link));
                ?>
                <li class="<?php echo ($active_tab == $v) ? 'active' : ''; ?>"><a
                        href="<?php echo esc_url($url); ?>"
                        aria-expanded="true"><?php
                        switch ($v) {
                            case "hotel":
                                echo __('Hotels', 'traveler');
                                break;
                            case "tours":
                                echo __('Tours', 'traveler');
                                break;
                            case "activity":
                                echo __('Activity', 'traveler');
                                break;
                            case "cars":
                                echo __('Car', 'traveler');
                                break;
                            case "rental":
                                echo __('Rental', 'traveler');
                                break;
                            case "flight":
                                echo __('Flight', 'traveler');
                                break;
                        }

                        ?></a></li>
                <?php
            }
        }
        ?>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade active in author-sv-list" id="tab-all">
            <?php
            $service = STInput::get('service', $arr_service[0]);
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $author = $current_user_upage->ID;
            $is_featured_hotel = st()->get_option('is_featured_search_hotel', 'off');
            $is_featured_rental = st()->get_option( 'is_featured_search_rental', 'off' );
            $is_featured_tour = st()->get_option('is_featured_search_tour', 'off');
            $is_featured_activity = st()->get_option( 'is_featured_search_activity', 'off' );
            $is_featured_car = st()->get_option( 'is_featured_search_car', 'off' );
            $args = array(
                'post_type' => 'st_' . esc_attr($service),
                'post_status' => 'publish',
                'author' => $author,
                'posts_per_page' => 6,
                'paged' => $paged,

            );
            if($service === 'hotel'){
                if (!empty($is_featured_hotel) and $is_featured_hotel == 'on') {
                    $args['meta_key'] = 'is_featured';
                    $args['orderby'] = 'meta_value';
                    $args['order'] = 'DESC';
                }
            } else if($service === 'tours'){
                if (!empty($is_featured_tour) and $is_featured_tour == 'on') {
                    $args['meta_key'] = 'is_featured';
                    $args['orderby'] = 'meta_value';
                    $args['order'] = 'DESC';
                }
            } else if($service === 'activity'){
                if (!empty($is_featured_activity) and $is_featured_activity == 'on') {
                    $args['meta_key'] = 'is_featured';
                    $args['orderby'] = 'meta_value';
                    $args['order'] = 'DESC';
                }
            }else if($service === 'cars'){
                if (!empty($is_featured_car) and $is_featured_car == 'on') {
                    $args['meta_key'] = 'is_featured';
                    $args['orderby'] = 'meta_value';
                    $args['order'] = 'DESC';
                }
            }else if($service === 'rental'){
                if (!empty($is_featured_rental) and $is_featured_rental == 'on') {
                    $args['meta_key'] = 'is_featured';
                    $args['orderby'] = 'meta_value';
                    $args['order'] = 'DESC';
                }
            }
            $query = new WP_Query($args);

            if ($query->have_posts()) {
                switch ($service) {
                    case "hotel":
                        echo '<div class="search-result-page"><div class="st-results st-hotel-result"><div class="row service-list-wrapper">';
                        break;
                    case "tours":
                        echo '<div class="search-result-page st-tours"><div class="st-results st-hotel-result"><div class="row service-list-wrapper">';
                        break;
                    case "activity":
                        echo '<div class="search-result-page st-tours st-activity"><div class="st-results st-hotel-result"><div class="row service-list-wrapper">';
                        break;
                    case "cars":
                        echo '<div class="search-result-page st-tours"><div class="st-results st-hotel-result"><div class="row service-list-wrapper">';
                        break;
                    case "rental":
                        echo '<div class="search-result-page st-rental "><div class="st-results st-hotel-result"><div class="row service-list-wrapper">';
                        break;
                    // case "flight":
                    //     echo '<ul class="booking-list loop-rental style_list">';
                    //     break;
                }
                while ($query->have_posts()) {
                    $query->the_post();
                    switch ($service) {
                        case "hotel":
                            echo st()->load_template('layouts/elementor/hotel/loop/normal', 'grid',array('item_row'=> 3));
                            break;
                        case "tours":
                           
                            echo st()->load_template('layouts/elementor/tour/loop/normal','grid',array('item_row'=> 3));
                            break;
                        case "activity":
                          
                            echo st()->load_template('layouts/elementor/activity/loop/normal','grid',array('item_row'=> 3));
                            break;
                        case "cars":
                            echo st()->load_template('layouts/elementor/car/loop/normal','grid',array('item_row'=> 3));
                            break;
                        case "rental":
                            echo st()->load_template('layouts/elementor/rental/loop/normal','grid');
                            break;
                        case "flight":
                            echo st()->load_template('user/loop/loop', 'flight-upage');
                            break;
                    }
                }
                echo "</div></div></div>";
            } else {
                echo '<h5>' . __('No data', 'traveler') . '</h5>';
            }
            wp_reset_postdata();
            ?>
            <br/>
            <div class="pull-left author-pag">
                <?php st_paging_nav(null, $query) ?>
            </div>
        </div>
    </div>

    <div class="st-review-new">
        <h5><?php echo __('Review', 'traveler'); ?></h5>
        <?php
        echo st()->load_template('layouts/elementor/page/elements/partner', 'review', array(
            'current_user_upage' => $current_user_upage,
            'arr_service' => $arr_service,
            'post_per_page_review' => 5
        ));
        ?>
    </div>

    <?php
} else {
    echo __('No partner services!', 'traveler');
}
?>
<?php
if (is_user_logged_in()) {
    $current_user = wp_get_current_user();
    $data_list    = json_decode(get_user_meta( $current_user->ID, 'st_wishlist', true ));
    $arr_id['hotel'] = $arr_id['tours'] = $arr_id['rental'] = $arr_id['activity'] = $arr_id['cars'] =[];
    foreach($data_list as $serv){
        if(!empty($serv->type) && $serv->type == 'st_hotel'){
            $arr_id['hotel'][] = $serv->id;
        }
        if(!empty($serv->type) && $serv->type == 'st_tours'){
            $arr_id['tours'][] = $serv->id;
        }
        if(!empty($serv->type) && $serv->type == 'st_activity'){
            $arr_id['activity'][] = $serv->id;
        }
        if(!empty($serv->type) && $serv->type == 'st_rental'){
            $arr_id['rental'][] = $serv->id;
        }
        if(!empty($serv->type) && $serv->type == 'st_cars'){
            $arr_id['cars'][] = $serv->id;
        }
    }

    $services =  ST_Elementor::listServiceSelection();?>
    <div id="list-wishlist-wrapper" class="list-wishlist-wrapper <?php echo esc_attr($style);?>">
        <?php if(count($services)>1){?>
            <nav>
                <ul class="nav nav-tabs d-flex align-items-center justify-content-center nav-fill-st" id="nav-tab" role="tablist">
                    <?php 
                        foreach($services as $key=>$service){ 
                            if($service !== 'st_flight'):?>
                            <li><a class="text-center <?php if($key==0){echo 'active';}?>" id="nav-<?php echo esc_attr($service);?>-tab" data-bs-toggle="tab" data-bs-target="#nav-<?php echo esc_attr($service);?>"
                                            role="tab" aria-controls="nav-<?php echo esc_attr($service);?>"
                                            aria-selected="true"><?php echo esc_html(ST_Elementor::get_title_service($service)); ?></a>
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
            foreach($services as $key=>$service){
                ?>
                    <div class="tab-pane <?php if($key==0 || $active_tab==true ){echo 'active';}?>" id="nav-<?php echo esc_attr($service);?>" role="tabpanel"
                    aria-labelledby="nav-<?php echo esc_attr($service);?>-tab">
                    <div class="row service-list-wrapper <?php if($service == 'st_tours' || $service == 'st_activity'){echo ' service-tour';}?>">
                        <?php switch ($service) {
                            case 'st_hotel':
                                if($arr_id['hotel']){
                                    $query           = array(
                                        'post_type'      => 'st_hotel' ,
                                        'post_status'    => 'publish' ,
                                        's'              => '',
                                        'post__in' => $arr_id['hotel'],
                                    );
                                    global $wp_query , $st_search_query;
    
                                    $current_lang = TravelHelper::current_lang();
                                    $main_lang = TravelHelper::primary_lang();
                                    if (TravelHelper::is_wpml()) {
                                        global $sitepress;
                                        $sitepress->switch_lang($main_lang, true);
                                    }
    
                                    $hotel = STHotel::inst();
                                    $hotel->alter_search_query();
                                    query_posts( $query );
                                    $st_search_query = $wp_query;
                                    $query = $st_search_query;
                                    $hotel->remove_alter_search_query();
                                    wp_reset_query();
                                    if($query->have_posts()) {
                                        while ($query->have_posts()) {
                                            $query->the_post();
                                            if(!empty($style) && $style == 'style_2'){
                                                echo '<div class="col-lg-3 col-md-3 col-12 item-service">';
                                                echo stt_elementorv2()->loadView('services/hotel/loop/grid');
                                                echo '</div>';
                                            } else {
                                                echo st()->load_template('layouts/elementor/hotel/loop/normal-grid', '',array('item_row'=> 4));
                                            }
                                            
                                        }
                                    }else{
                                        echo '<div class="col-12">';
                                        echo st()->load_template('layouts/modern/hotel/elements/none');
                                        echo '</div>';
                                    }
                                    wp_reset_query();
                                } else { ?>
                                    <div class="alert alert-warning mt15 none-tour"><?php echo __('Not found.', 'traveler'); ?></div>
                                <?php }
                                
                                break;
                            
                            case 'st_tours':
                                if($arr_id['tours']){
                                    $query_tour           = array(
                                        'post_type'      => 'st_tours' ,
                                        'post_status'    => 'publish' ,
                                        's'              => '',
                                        'post__in' => $arr_id['tours'],
                                    );
                                    global $wp_query , $st_search_query;

                                    $current_lang = TravelHelper::current_lang();
                                    $main_lang = TravelHelper::primary_lang();
                                    if (TravelHelper::is_wpml()) {
                                        global $sitepress;
                                        $sitepress->switch_lang($main_lang, true);
                                    }

                                    $tour = STTour::get_instance();
                                    $tour->alter_search_query();
                                    query_posts( $query_tour );
                                    $st_search_query = $wp_query;
                                    $query_tour = $st_search_query;
                                    $tour->remove_alter_search_query();
                                    wp_reset_query();
                                    if($query_tour->have_posts()) {
                                        while ($query_tour->have_posts()) {
                                            $query_tour->the_post();
                                            if(!empty($style) && $style == 'style_2'){
                                                echo '<div class="col-lg-3 col-md-3 col-12 item-service">';
                                                echo stt_elementorv2()->loadView('services/tour/loop/grid');
                                                echo '</div>';
                                            } else {
                                                echo st()->load_template('layouts/elementor/tour/loop/normal-grid', '',array('item_row'=> 4));
                                            }
                                            
                                        }
                                    }else{
                                        echo '<div class="col-12">';
                                        echo st()->load_template('layouts/modern/tour/loop/none');
                                        echo '</div>';
                                    }
                                    wp_reset_query();
                                } else { ?>
                                    <div class="alert alert-warning mt15 none-tour"><?php echo __('Not found.', 'traveler'); ?></div>
                                <?php }
                                break;
                            case 'st_activity':
                                if(!empty($arr_id['activity'])){
                                    $query_activity           = array(
                                        'post_type'      => 'st_activity' ,
                                        'post_status'    => 'publish' ,
                                        's'              => '',
                                        'post__in' => $arr_id['activity'],
                                    );
                                    global $wp_query , $st_search_query;
    
                                    $current_lang = TravelHelper::current_lang();
                                    $main_lang = TravelHelper::primary_lang();
                                    if (TravelHelper::is_wpml()) {
                                        global $sitepress;
                                        $sitepress->switch_lang($main_lang, true);
                                    }
    
                                    $activity = STActivity::inst();
                                    $activity->alter_search_query();
                                    query_posts( $query_activity );
                                    $st_search_query = $wp_query;
                                    $query_activity = $st_search_query;
                                    $activity->remove_alter_search_query();
                                    wp_reset_query();
                                    if($query_activity->have_posts()) {
                                        while ($query_activity->have_posts()) {
                                            $query_activity->the_post();
                                            if(!empty($style) && $style == 'style_2'){
                                                echo '<div class="col-lg-3 col-md-3 col-12 item-service">';
                                                
                                                echo stt_elementorv2()->loadView('services/activity/loop/grid');
    
                                                echo '</div>';
                                            } else {
                                                echo st()->load_template('layouts/elementor/activity/loop/normal-grid', '',array('item_row'=> 4));
                                            }
                                            
                                        }
                                    }else{
                                        echo '<div class="col-12">';
                                        echo st()->load_template('layouts/elementor/activity/loop/none');
                                        echo '</div>';
                                    }
                                    wp_reset_query();
                                } else { ?>
                                    <div class="alert alert-warning mt15 none-tour"><?php echo __('Not found.', 'traveler'); ?></div>
                                <?php }
                                
                            break;
                            case 'st_rental':
                                if(!empty($arr_id['rental'])){
                                    $query_rental           = array(
                                        'post_type'      => 'st_rental' ,
                                        'post_status'    => 'publish' ,
                                        's'              => '',
                                        'post__in' => $arr_id['rental'],
                                    );
                                    global $wp_query , $st_search_query;
    
                                    $current_lang = TravelHelper::current_lang();
                                    $main_lang = TravelHelper::primary_lang();
                                    if (TravelHelper::is_wpml()) {
                                        global $sitepress;
                                        $sitepress->switch_lang($main_lang, true);
                                    }
    
                                    $rental =STRental::inst();
                                    $rental->alter_search_query();
                                    query_posts( $query_rental );
                                    $st_search_query = $wp_query;
                                    $query_rental = $st_search_query;
                                    $rental->remove_alter_search_query();
                                    wp_reset_query();
                                    if($query_rental->have_posts()) {
                                        while ($query_rental->have_posts()) {
                                            $query_rental->the_post();
                                            if(!empty($style) && $style == 'style_2'){
                                                echo '<div class="col-lg-3 col-md-3 col-12 item-service">';
                                                echo stt_elementorv2()->loadView('services/rental/loop/grid');
                                                echo '</div>';
                                            } else {
                                                echo st()->load_template('layouts/elementor/rental/loop/normal-grid', '',array('item_row'=> 4));
                                            }
                                            
                                        }
                                    }else{
                                        echo '<div class="col-12">';
                                        echo st()->load_template('layouts/elementor/rental/elements/none');
                                        echo '</div>';
                                    }
                                    wp_reset_query();
                                } else { ?>
                                    <div class="alert alert-warning mt15 none-tour"><?php echo __('Not found.', 'traveler'); ?></div>
                                <?php }
                                
                            break;

                            case 'st_cars':
                                if(!empty($arr_id['cars'])){
                                    $query_cars           = array(
                                        'post_type'      => 'st_cars' ,
                                        'post_status'    => 'publish' ,
                                        's'              => '',
                                        'post__in' => $arr_id['cars'],
                                    );
                                    global $wp_query , $st_search_query;
    
                                    $current_lang = TravelHelper::current_lang();
                                    $main_lang = TravelHelper::primary_lang();
                                    if (TravelHelper::is_wpml()) {
                                        global $sitepress;
                                        $sitepress->switch_lang($main_lang, true);
                                    }
    
                                    $cars = STCars::get_instance();
                                    $cars->alter_search_query();
                                    query_posts( $query_cars );
                                    $st_search_query = $wp_query;
                                    $query_cars = $st_search_query;
                                    $cars->remove_alter_search_query();
                                    wp_reset_query();
                                    if($query_cars->have_posts()) {
                                        while ($query_cars->have_posts()) {
                                            $query_cars->the_post();
                                            if(!empty($style) && $style == 'style_2'){
                                                echo '<div class="col-lg-3 col-md-3 col-12 item-service">';
                                                echo stt_elementorv2()->loadView('services/car/loop/grid');
                                                echo '</div>';
                                            } else {
                                                echo st()->load_template('layouts/elementor/car/loop/normal-grid', '',array('item_row'=> 4));
                                            }
                                            
                                        }
                                    }else{
                                        echo '<div class="col-12">';
                                        echo st()->load_template('layouts/elementor/car/loop/none');
                                        echo '</div>';
                                    }
                                    wp_reset_query();
                                } else { ?>
                                    <div class="alert alert-warning mt15 none-tour"><?php echo __('Not found.', 'traveler'); ?></div>
                                <?php }
                                
                            break;
                        }
                        ?>
                    </div>
                </div>
            <?php }?>
        </div>
    </div>
<?php } else {?>
    <div class="alert alert-warning mt15 none-tour"><?php echo __('Please login.', 'traveler'); ?></div>
<?php }
    
?>
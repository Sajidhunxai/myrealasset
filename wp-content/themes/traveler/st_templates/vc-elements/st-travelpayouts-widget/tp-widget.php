<?php
/**
 * Created by wpbooking.
 * Developer: nasanji
 * Date: 5/15/2017
 * Version: 1.0
 */
$marker = st()->get_option('tp_marker', '124778');
$currency_default = st()->get_option('tp_currency_default','usd');

$use_whitelabel = st()->get_option('tp_redirect_option', 'off');

switch($widget_type){
    case 'popular-router':
        $location = 'BKK';
        if(!empty($pr_destination['location_id'])){
            $location = $pr_destination['location_id'];
        }
        if(empty($language)){
            $language = 'en';
        }
        $page_id = st()->get_option('tp_whitelabel_page','');

        if(empty($page_id)){
            $host = st()->get_option('tp_whitelabel', 'hydra.aviasales.ru');
        }else{
            $host = esc_url(get_the_permalink($page_id).'#/flights');
            $host = str_replace(array('http://','https://','/','#'),array('','','%2F','%23'),$host);
        }

        if($use_whitelabel == 'off'){
            $host = 'hydra.aviasales.ru';
        }

        echo '<script data-optimize="0" data-no-optimize="1" async src="//www.travelpayouts.com/weedle/widget.js?width=400px&marker='.esc_attr($marker).'&host='.esc_attr($host).'&locale='.esc_attr($language).'&currency='.esc_attr($currency_default).'&destination='.esc_attr($location).'" charset="UTF-8"></script>';
        break;
    case 'flights-map':
        $location = 'PAR';
        if(!empty($pr_destination['location_id'])){
            $location = $pr_destination['location_id'];
        }
        if(empty($language1)){
            $language1 = 'en';
        }
        if($direct == 'yes'){
            $direct = 'true';
        }else{
            $direct = 'false';
        }
        $domain = st()->get_option('tp_whitelabel', 'map.jetradar.com');
        if($domain != 'map.jetradar.com'){
            $domain = $domain.'/map';
        }

        if($use_whitelabel == 'off'){
            $domain = 'map.jetradar.com';
        }

        echo '<iframe src="//maps.avs.io/flights/?auto_fit_map=true&hide_sidebar=true&hide_reformal=true&disable_googlemaps_ui=true&zoom=5&show_filters_icon=true&redirect_on_click=true&small_spinner=true&hide_logo=false&direct='.esc_attr($direct).'&lines_type=TpLines&cluster_manager=TpWidgetClusterManager&marker='.esc_attr($marker).'.map&show_tutorial=false&locale='.esc_attr($language1).'&currency='.esc_attr($currency_default).'&host='.esc_attr($domain).'&origin_iata='.esc_attr($location).'" width="100%" height="450" scrolling="no" frameborder="0"></iframe>';
        break;
    case 'calendar':
        $page_id = st()->get_option('tp_whitelabel_page','');
        if(empty($page_id)){
            $host = st()->get_option('tp_whitelabel', 'jetradar.com%2Fsearches%2Fnew');
        }else{
            $host = esc_url(get_the_permalink($page_id).'#/flights');
            $host = str_replace(array('http://','https://','/','#'),array('','','%2F','%23'),$host);
        }

        if($use_whitelabel == 'off'){
            $host = 'jetradar.com%2Fsearches%2Fnew';
        }

        $location1 = 'HAN';
        if(!empty($pr_origin['location_id'])){
            $location1 = $pr_origin['location_id'];
        }

        $location2 = 'BKK';
        if(!empty($pr_destination['location_id'])){
            $location2 = $pr_destination['location_id'];
        }

        echo '<div class="calendar-widget"><script data-optimize="0" data-no-optimize="1" charset="utf-8" src="//www.travelpayouts.com/calendar_widget/iframe.js?marker='.esc_attr($marker).'.&origin='.esc_attr($location1).'&destination='.esc_attr($location2).'&currency='.esc_attr($currency_default).'&searchUrl='.esc_attr($host).'&one_way=false&only_direct=false&locale='.esc_attr($language2).'&period=year&range=7%2C14&width=800" async></script></div>';
        break;
    case 'hotels-map':

        $lat_lon = 'lat=21.188273091358273&lng=105.87235119628907';
        if(!empty($map_lat_lon['hotel_map'])){
            $lat_lon = $map_lat_lon['hotel_map'];
        }

        $page_id = st()->get_option('tp_whitelabel_page','');
        if(empty($page_id)){
            $host = st()->get_option('tp_whitelabel', '');
            if(!empty($host)){
                $host = $host.'%2Fhotels';
            }else{
                $host = 'hotellook.com';
            }
        }else{
            $host = esc_url(get_the_permalink($page_id).'#/hotels');
            $host = str_replace(array('http://','https://','/','#'),array('','','%2F','%23'),$host);
        }

        if($use_whitelabel == 'off'){
            $host = 'hotellook.com';
        }

        $drag = $disable_zoom = $scroll = $map_styled = 'false';

        if(strpos($map_control, 'drag') !== false){
            $drag = 'true';
        }

        if(strpos($map_control, 'disable_zoom') !== false){
            $disable_zoom = 'true';
        }
        if(strpos($map_control, 'scroll') !== false){
            $scroll = 'true';
        }
        if(strpos($map_control, 'map_styled') !== false){
            $map_styled = 'true';
        }
        echo '<iframe src="//maps.avs.io/hotels?color='.str_replace('#','%23',esc_attr($color_schema)).'&locale='.esc_attr($language).'&marker='.esc_attr($marker).'.'.esc_attr($add_marker).'hotelsmap&changeflag=0&draggable='.esc_attr($drag).'&map_styled='.esc_attr($map_styled).'&map_color='.str_replace('#','%23',esc_attr($color_schema)).'&contrast_color=%23FFFFFF&disable_zoom='.esc_attr($disable_zoom).'&base_diameter='.((int)($marker_size)).'&scrollwheel='.esc_attr($scroll).'&host='.esc_attr($host).'&'.esc_attr($lat_lon).'&zoom='.((int)$map_zoom).'" height="450px" width="100%"  scrolling="no" frameborder="0"></iframe>';
        break;
    case 'hotel':
        $page_id = st()->get_option('tp_whitelabel_page','');
        if(empty($page_id)){
            $host = st()->get_option('tp_whitelabel', '');
            if(!empty($host)){
                $host = $host.'%2Fhotels';
            }else{
                $host = 'hotellook.com%2Fsearch';
            }
        }else{
            $host = esc_url(get_the_permalink($page_id).'#/hotels');
            $host = str_replace(array('http://','https://','/','#'),array('','','%2F','%23'),$host);
        }

        if($use_whitelabel == 'off'){
            $host = 'hotellook.com%2Fsearch';
        }

        $id = '361687';
        if(!empty($hotel_id['h_id'])){
            $id = $hotel_id['h_id'];
        }

        echo '<div class="hotel-widget"><script data-optimize="0" data-no-optimize="1" charset="utf-8" async src="//www.travelpayouts.com/chansey/iframe.js?hotel_id='.esc_attr($id).'&locale='.esc_attr($language).'&host='.esc_attr($host).'&marker='.esc_attr($marker).'.'.esc_attr($add_marker).'&currency='.esc_attr($currency_default).'&width=500"></script></div>';
        break;
    case 'hotel-selections':
        if ($language3 == 'ru') {
            $language3 = '';
        } else {
            $language3 = '_' . $language3;
        }
        $page_id = st()->get_option('tp_whitelabel_page', '');
        if (empty($page_id)) {
            $host = st()->get_option('tp_whitelabel', '');
            if (!empty($host)) {
                $host = $host . '%2Fhotels';
            } else {
                $host = 'search.hotellook.com';
            }
        } else {
            $host = esc_url(get_the_permalink($page_id) . '#/hotels');
            $host = str_replace(array('http://', 'https://'), array('', ''), $host);
            $host = urlencode($host);
        }

        if($use_whitelabel == 'off'){
            $host = 'search.hotellook.com';
        }

        if($find_by == 'city'){
            $city_id = '14115';
            if(!empty($city_data['city_id'])){
                $city_id = $city_data['city_id'];
            }

            $categories = '';
            if(!empty($city_data['city_avail']) && count($city_data['city_avail']) > 0){
                $categories = 'categories=';
                foreach($city_data['city_avail'] as $key => $value){
                    $categories .= $value.'%2C';
                    if($key == count($city_data['city_avail']) - 1){
                        $categories .= $value;
                    }
                }
            }

            echo '<script data-optimize="0" data-no-optimize="1" async src="//www.travelpayouts.com/blissey/scripts'.esc_attr($language3).'.js?'.($categories).'&id='.esc_attr($city_id).'&type='.esc_attr($w_layout).'&currency='.esc_attr($currency_default).'&width=800&host='.esc_attr($host).'&marker='.esc_attr($marker).'.'.esc_attr($add_marker).'&limit='.esc_attr($limit).'" charset="UTF-8"></script>';
        }


        if($find_by == 'hotels'){
            if(!empty($list_hotel)) {

                $hotels = vc_param_group_parse_atts($list_hotel);
                if(is_array($hotels)){
                    $i = 0;
                    foreach($hotels as $key => $val){
                        parse_str(urldecode($val['s_hotel_id']), $hotel);
                        if(!empty($hotel['h_id'])){
                            if($i == 0){
                                $ids = $hotel['h_id'];
                            }else{
                                $ids .= '%2C'.$hotel['h_id'];
                            }

                            $i++;
                        }
                    }
                }

                echo '<script data-optimize="0" data-no-optimize="1" async src="//www.travelpayouts.com/blissey/scripts' . esc_attr($language3) . '.js?type=' . esc_attr($w_layout) . '&currency=' . esc_attr($currency_default) . '&width=800&host=' . esc_attr($host) . '&marker=' . esc_attr($marker) . '.' . esc_attr($add_marker) . '&ids='.esc_attr($ids).'&limit=' . esc_attr($limit) . '" charset="UTF-8"></script>';
            }
        }
        break;
}
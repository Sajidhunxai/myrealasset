<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13-11-2018
 * Time: 1:44 PM
 * Since: 1.0.0
 * Updated: 1.0.0
 */

$class_form_type = '';
if ($form_type == 'mix') {
    $class_form_type = 'mix';
    if (!empty($service_items)) {
        $service_items = vc_param_group_parse_atts($service_items);
        if (count($service_items) <= 0) {
            $service = '';
        } elseif (count($service_items) == 1) {
            $service = $service_items[0]['tab_service'];
        } else {
            $service = $service_items;
        }
    }
}

$class_heading = 'text-center';
switch ($heading_align) {
    case 'left':
        $class_heading = 'text-left';
        break;
    case 'right':
        $class_heading = 'text-right';
        break;
}

if (!empty($service)) {
    $classForm = '';
    if (is_array($service)) {

        foreach ($service as $tab) {
            $classForm .= 'st-search-form-' . $tab['tab_service'] .' ';
        }
    } else {
        $classForm = 'st-search-form-' . $service;
    }
    if ($service == 'st_tours' && $tour_style == 'style2') {

            if (!empty($heading)) {
                echo '<h1 class="st-heading  ' . esc_attr($class_heading) . '">' . esc_html($heading) . '</h1>';
            }
            ?>
            <?php
            if (!empty($description)) {
                echo '<div class="sub-heading ' . esc_attr($class_heading) . '">' . esc_html($description) . '</div>';
            }
            echo st()->load_template('layouts/modern/tour/elements/search-form-new', '', ['has_icon' => true]);

    } else {
        ?>

        <div class="search-form-wrapper auto-height-form-search <?php echo esc_attr($style . ' ' . $class_form_type . ' ' . $classForm); ?>">
            <?php
            if ($style == 'slider') {
                if (!empty($images)) {
                    $arr_images = explode(',', $images);
                    if (!empty($arr_images)) {
                        echo '<div class="st-bg-slider  fotorama" data-auto="false"  data-transition="dissolve" data-fit="cover" data-arrows="false" data-autoplay="3000" data-loop="true" data-stopautoplayontouch="false" data-minwidth="100%" data-nav="false">';

                       
                        foreach ($arr_images as $k => $v) {
                            $image_item = wp_get_attachment_image_url($v, 'full');
                           
                            echo '<img src="' . esc_url($image_item) . '" alt="'.esc_html($heading).'"></img>';
                        }

                        echo '</div>';
                    }
                }
                ?>
                <div class="search-form-text">
                    <div class="container">
                        <?php
                        if ($form_type == 'mix') { 
                            echo '<h1 class="st-heading ' . esc_attr($class_heading) . '">';
                            if (!empty($heading)) {
                                echo esc_html($heading);
                            }
                            echo  '</h1>';
                            ?>
                            <?php
                                echo '<div class="sub-heading ' . esc_attr($class_heading) . '">';
                            if (!empty($description)) {
                                echo esc_html($description);
                            }
                            echo '</div>';
                        } else {
                            if (!empty($heading)) {
                                echo '<h1 class="st-heading ' . esc_attr($class_heading) . '">' . esc_html($heading) . '</h1>';
                            }
                            ?>
                            <?php
                            if (!empty($description)) {
                                echo '<div class="sub-heading ' . esc_attr($class_heading) . '">' . esc_html($description) . '</div>';
                            }
                        }
                        
                        if (is_array($service)) {
                            echo '<ul class="nav nav-tabs" role="tablist">';
                            $j = 0;
                            foreach ($service as $vtab) {
                                $active_class = ($j == 0) ? 'active' : '';
                                echo '<li role="' . esc_attr($vtab['tab_service']) . '" class="' . esc_attr($active_class) . '"><a href="#' . esc_attr($vtab['tab_service']) . '" aria-controls="' . esc_attr($vtab['tab_service']) . '" role="tab" data-toggle="tab">' . esc_attr($vtab['tab_title']) . '</a></li>';
                                $j++;
                            }
                            echo '</ul>';

                            echo '<div class="tab-content">';
                            $jj = 0;
                            foreach ($service as $vtabcontent) {
                                switch ($vtabcontent['tab_service']) {
                                    case 'st_rental':
                                        $folder_name = 'rental';
                                        break;
                                    case 'st_tours':
                                        $folder_name = 'tour';
                                        break;
                                    case 'st_activity':
                                        $folder_name = 'activity';
                                        break;
                                    case 'st_cars':
                                        $folder_name = 'car';
                                        break;
                                    case 'st_cartranfer':
                                        $folder_name = 'car_transfer';
                                        break;
                                    case 'tp_flight':
                                        $folder_name = 'tp_flight';
                                        break;
                                    case 'tp_hotel':
                                        $folder_name = 'tp_hotel';
                                        break;
                                    
                                    case 'hotels_combined':
                                        $folder_name = 'hotels_combined';
                                        break;
                                    case 'bookingdc':
                                        $folder_name = 'bookingdc';
                                        break;
                                    case 'expedia':
                                        $folder_name = 'expedia';
                                        break;
                                    default:
                                        $folder_name = 'hotel';
                                        break;
                                }
                                $active_class = ($jj == 0) ? 'active' : '';
                                echo '<div role="tabpanel" class="tab-pane ' . esc_attr($active_class) . '" id="' . esc_attr($vtabcontent['tab_service']) . '">';
                                echo apply_filters('get_search_form_tab', st()->load_template('layouts/modern/' . esc_attr($folder_name) . '/elements/search-form', 'home', array('in_tab' => true, 'vtabcontent' => $vtabcontent)),array('in_tab' => true, 'vtabcontent' => $vtabcontent));
                                echo '</div>';
                                $jj++;
                            }
                            echo '</div>';
                        } else {
                            
                            switch ($service) {
                                case 'st_rental':
                                    $folder_name = 'rental';
                                    break;
                                case 'st_tours':
                                    $folder_name = 'tour';
                                    break;
                                case 'st_cars':
                                    $folder_name = 'car';
                                    break;
                                case 'st_cartranfer':
                                    $folder_name = 'car_transfer';
                                    break;
                                case 'st_activity':
                                    $folder_name = 'activity';
                                    break;
                                case 'tp_flight':
                                    $folder_name = 'tp_flight';
                                    break;
                                case 'tp_hotel':
                                    $folder_name = 'tp_hotel';
                                    break;
                                
                                case 'hotels_combined':
                                    $folder_name = 'hotels_combined';
                                    break;
                                case 'bookingdc':
                                    $folder_name = 'bookingdc';
                                    break;
                                case 'expedia':
                                    $folder_name = 'expedia';
                                    break;
                                default:
                                    $folder_name = 'hotel';
                                    break;
                            }

                            $feature_item = (isset($feature_item)) ? vc_param_group_parse_atts($feature_item) : [];
                            echo st()->load_template('layouts/modern/' . esc_attr($folder_name) . '/elements/search-form', 'home', ['in_tab' => true,'feature_item' => $feature_item]);
                        }
                        ?>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <?php
                if (!empty($heading)) {
                    echo '<h1 class="st-heading ' . esc_attr($class_heading) . '">' . esc_html($heading) . '</h1>';
                }
                ?>
                <?php
                if (!empty($description)) {
                    echo '<div class="sub-heading ' . esc_attr($class_heading) . '">' . esc_html($description) . '</div>';
                }

                if (is_array($service)) {
                    echo '<ul class="nav nav-tabs" role="tablist">';
                    $j = 0;
                    foreach ($service as $vtab) {
                        $active_class = ($j == 0) ? 'active' : '';
                        echo '<li role="' . esc_attr($vtab['tab_service']) . '" class="' . esc_attr($active_class) . '"><a href="#' .esc_attr( $vtab['tab_service']) . '" aria-controls="' . esc_attr($vtab['tab_service']) . '" role="tab" data-toggle="tab">' . esc_attr($vtab['tab_title']) . '</a></li>';
                        $j++;
                    }
                    echo '</ul>';

                    echo '<div class="tab-content">';
                    $jj = 0;
                    foreach ($service as $vtabcontent) {
                        switch ($vtabcontent['tab_service']) {
                            case 'st_rental':
                                $folder_name = 'rental';
                                break;
                            case 'st_tours':
                                $folder_name = 'tour';
                                break;
                            case 'st_activity':
                                $folder_name = 'activity';
                                break;
                            case 'st_cars':
                                $folder_name = 'car';
                                break;
                            case 'st_cartranfer':
                                $folder_name = 'car_transfer';
                                break;
                            case 'st_shortcode':
                                $folder_name = 'search_shortcode';
                                break;
                            case 'tp_flight':
                                $folder_name = 'tp_flight';
                                break;
                            case 'tp_hotel':
                                $folder_name = 'tp_hotel';
                                break;
                            
                            case 'hotels_combined':
                                $folder_name = 'hotels_combined';
                                break;
                            case 'bookingdc':
                                $folder_name = 'bookingdc';
                                break;
                            case 'expedia':
                                $folder_name = 'expedia';
                                break;
                            default:
                                $folder_name = 'hotel';
                                break;
                        }

                        $active_class = ($jj == 0) ? 'active' : '';
                        echo '<div role="tabpanel" class="tab-pane ' . esc_attr($active_class) . '" id="' . esc_attr($vtabcontent['tab_service']) . '">';
                        echo apply_filters('get_search_form_tab', st()->load_template('layouts/modern/' . esc_attr($folder_name) . '/elements/search-form', 'home', array('in_tab' => true, 'vtabcontent' => $vtabcontent)),array('in_tab' => true, 'vtabcontent' => $vtabcontent));

                        echo '</div>';
                        $jj++;
                    }
                    echo '</div>';
                } else {
                    switch ($service) {
                        case 'st_rental':
                            $folder_name = 'rental';
                            break;
                        case 'st_tours':
                            $folder_name = 'tour';
                            break;
                        case 'st_activity':
                            $folder_name = 'activity';
                            break;
                        case 'st_cars':
                            $folder_name = 'car';
                            break;
                        case 'st_cartranfer':
                            $folder_name = 'car_transfer';
                            break;
                        case 'tp_flight':
                            $folder_name = 'tp_flight';
                            break;
                        case 'tp_hotel':
                            $folder_name = 'tp_hotel';
                            break;
                        
                        case 'hotels_combined':
                            $folder_name = 'hotels_combined';
                            break;
                        case 'bookingdc':
                            $folder_name = 'bookingdc';
                            break;
                        case 'expedia':
                            $folder_name = 'expedia';
                            break;
                        default:
                            $folder_name = 'hotel';
                            break;
                    }
                    $feature_item = (isset($feature_item)) ? vc_param_group_parse_atts($feature_item) : [];
                    echo '<div role="tabpanel" class="tab-pane" id="' . esc_attr($folder_name) . '">';
                    echo  apply_filters('get_search_form_tab', st()->load_template('layouts/modern/' . esc_attr($folder_name) . '/elements/search-form', 'home', ['feature_item' => $feature_item]),array('vtabcontent' => $service));
                    echo '</div>';
                    
                }
                ?>
                <?php
            }
            ?>
        </div>
        <?php
    }
}

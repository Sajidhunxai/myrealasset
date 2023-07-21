<?php 
?>
<div class="st-banner-search-form <?php echo esc_attr($style) ?>">
    <?php
    if (!empty($type_form) && !empty($services) && ($type_form !== 'single')) {
        if(is_array($services)){
            $services = '';
        }
        $services = ST_Elementor::st_explode_select2($services);
        if (count($services) > 1) {
            echo '<ul class="multi-search nav nav-pills justify-content-center" role="tablist">';
            $j = 0;
            foreach ($services as $vtab => $item) {
                switch ($vtab) {
                    case 'st_rental':
                        $tab_title = esc_html__('Rental', 'traveler');
                        break;
                    case 'st_tours':
                        $tab_title = esc_html__('Tours', 'traveler');
                        break;
                    case 'st_hotel':
                        $tab_title = esc_html__('Hotel', 'traveler');
                        break;
                    case 'st_activity':
                        $tab_title = esc_html__('Activity', 'traveler');
                        break;
                    case 'st_cars':
                        $tab_title = esc_html__('Cars Rental', 'traveler');
                        break;
                    case 'st_cartransfer':
                        $tab_title = esc_html__('Car Transfer', 'traveler');
                        break;
                    case 'tp_flight':
                        $tab_title = esc_html__('TravelerPayout Flight', 'traveler');
                        break;
                    case 'tp_hotel':
                        $tab_title = esc_html__('TravelerPayout Hotel', 'traveler');
                        break;
                    
                    case 'bookingdc':
                        $tab_title = esc_html__('Booking.com', 'traveler');
                        break;
                    case 'expedia':
                        $tab_title = esc_html__('Expedia', 'traveler');
                        break;
                    default:
                        $tab_title = $item;
                        break;
                }
                $active_class = ($j == 0) ? 'active' : '';
                echo '<li class="nav-item" role="presentation">
                        <a class="nav-link ' . esc_attr($active_class) . '" data-bs-toggle="pill" href="#" data-bs-target="#nav-' . esc_attr($vtab) . '" role="tab" aria-controls="nav-' . esc_attr($vtab) . '">' . esc_html($tab_title) . '</a>
                        </li>';
                $j++;
            }
            echo '</ul>';

            echo '<div class="tab-content">';
            $jj = 0;
            foreach ($services as $vtabcontent => $item) {
                switch ($vtabcontent) {
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
                    case 'st_cartransfer':
                        $folder_name = 'car_transfer';
                        break;
                    case 'tp_flight':
                        $folder_name = 'tp_flight';
                        break;
                    case 'tp_hotel':
                        $folder_name = 'tp_hotel';
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
                $active_class = ($jj == 0) ? 'show active' : '';
                echo '<div class="tab-pane fade' . esc_attr($active_class) . '" id="nav-' . esc_attr($vtabcontent) . '" role="tabpanel">'; ?>
                <div class="st-search-form-el st-border-radius">
                    <div class="st-search-el search-form-v2">
                        <?php echo apply_filters('get_search_form_tab',  stt_elementorv2()->loadView('services/'. $folder_name .'/search-form/wrapper'),array('in_tab' => true, 'vtabcontent' => $vtabcontent));
                        ?>
                    </div>
                </div>

                <?php echo '</div>';
                $jj++;
            }
            echo '</div>';
        } else { ?>
            <div class="st-search-form-el st-border-radius">
                <div class="st-search-el search-form-v2">
                    <?php
                    foreach ($services as $vtab => $item) {
                        switch ($vtab) {
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
                            case 'st_cartransfer':
                                $folder_name = 'car_transfer';
                                break;
                            case 'tp_flight':
                                $folder_name = 'tp_flight';
                                break;
                            case 'tp_hotel':
                                $folder_name = 'tp_hotel';
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
                        $active_class = 'show active';
                        echo '<div class="tab-pane fade' . esc_attr($active_class) . '" id="nav-' . esc_attr($folder_name) . '" role="tabpanel">'; ?>
                        <div class="st-search-form-el st-border-radius">
                            <div class="st-search-el search-form-v2">
                                <?php
                                 echo  apply_filters('get_search_form_tab', stt_elementorv2()->loadView('services/'. $folder_name .'/search-form/wrapper'),array('in_tab' => true, 'vtabcontent' => $folder_name));

                                ?>
                            </div>
                        </div>
    
                        <?php echo '</div>';
                    }?>
                    
                </div>
            </div>
        <?php }
    } else {
        ?>

        <?php
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
                    case 'st_cartransfer':
                        $folder_name = 'car_transfer';
                        break;
                    case 'tp_flight':
                        $folder_name = 'tp_flight';
                        break;
                    case 'tp_hotel':
                        $folder_name = 'tp_hotel';
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
                $active_class = 'show active';
                echo '<div class="tab-pane fade' . esc_attr($active_class) . '" id="nav-' . esc_attr($service) . '" role="tabpanel">'; ?>
                <div class="st-search-form-el st-border-radius">
                    <div class="st-search-el search-form-v2">
                        <?php 
                            echo  apply_filters('get_search_form_tab', stt_elementorv2()->loadView('services/'. $folder_name .'/search-form/wrapper'),array('in_tab' => true, 'vtabcontent' => $service));
                        ?>
                    </div>
                </div>

                <?php echo '</div>';
                ?>
    <?php } ?>
</div>

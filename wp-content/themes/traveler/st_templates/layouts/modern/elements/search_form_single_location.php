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

$class_heading = 'text-left';

if (!empty($service)) {
    $classForm = '';
    if (is_array($service)) {

        foreach ($service as $tab) {
            $classForm .= 'st-search-form-' . esc_html($tab['tab_service']);
        }
    } else {
        $classForm = 'st-search-form-' . $service;
    }
    ?>
    <div class="search-form-wrapper <?php echo esc_attr($style . ' ' . $class_form_type . ' ' . $classForm); ?>">
        <div class="search-form-text">
            <div class="container">
                <?php
                if (is_array($service)) {
                    echo '<ul class="nav nav-tabs" role="tablist">';
                    $j = 0;
                    foreach ($service as $vtab) {
                        $active_class = ($j == 0) ? 'active' : '';
                        echo '<li role="' . esc_attr($vtab['tab_service']) . '" class="' . esc_attr($active_class) . '"><a href="#' . esc_attr($vtab['tab_service']) . '" aria-controls="' . esc_attr($vtab['tab_service'] ). '" role="tab" data-toggle="tab">' . esc_html($vtab['tab_title']) . '</a></li>';
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
                            default:
                                $folder_name = 'hotel';
                                break;
                        }
                        $active_class = ($jj == 0) ? 'active' : '';
                        echo '<div role="tabpanel" class="tab-pane ' . esc_attr($active_class) . '" id="' . esc_attr($vtabcontent['tab_service']) . '">';
                        echo st()->load_template('layouts/modern/' . esc_attr($folder_name) . '/elements/search-form', 'home', array('in_tab' => true));
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
                        default:
                            $folder_name = 'hotel';
                            break;
                    }

                    $feature_item = (isset($feature_item)) ? vc_param_group_parse_atts($feature_item) : [];
                    echo st()->load_template('layouts/modern/' . esc_attr($folder_name) . '/elements/search-form', 'home', ['feature_item' => $feature_item]);
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}

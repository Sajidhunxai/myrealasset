<?php extract(shortcode_atts(array(
    'title_tab' => '',
    'service_tab' => '',
    'posts_per_page' => '',
), $attr));
if (!empty($service_tab)) {
    $service_tab = vc_param_group_parse_atts($service_tab);
    if (count($service_tab) <= 0) {
        $service_tab = array();
    } else {
        $service_tab = $service_tab;
    }
}
$id_location = get_the_ID();
?>
<div class="st-overview-content st_tab_service">
    <div class="st-content-over">
        <div class="st-content">
            <div class="title">
                <h3><?php echo esc_html($title_tab); ?></h3>
            </div>
            <div class="st_tab_service">
                <?php if (is_array($service_tab)) {
                    echo '<ul class="nav nav-tabs" role="tablist">';
                    $j = 0;
                    foreach ($service_tab as $vtab) {
                        $active_class = ($j == 0) ? 'active' : '';
                        echo '<li role="' . esc_attr($vtab['tab_service']) . '" class="' . esc_attr($active_class) . '"><a href="#' . esc_attr($vtab['tab_service']) . '_ccv" aria-controls="' . esc_attr($vtab['tab_service']) . '" role="tab" data-toggle="tab">' . esc_html($vtab['tab_title']) . '</a></li>';
                        $j++;
                    }
                    echo '</ul>';
                } ?>
            </div>
        </div>
        <div class="st-tab-service-content">
            <div class="st-loader-ccv">
                <div class="st-loader">

                </div>
            </div>
            <?php
            echo '<div class="tab-content">';
            $jj = 0;
            foreach ($service_tab as $vtabcontent) {
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
                    default:
                        $folder_name = 'hotel';
                        break;
                }
                $active_class = ($jj == 0) ? 'active' : '';
                echo '<div role="tabpanel" class="tab-pane ' . esc_attr($active_class) . '" id="' . esc_attr($vtabcontent['tab_service']) . '_ccv">';


                echo st()->load_template('layouts/modern/location/elements/content-' . esc_attr($folder_name) . '', '', array('in_tab' => true, 'posts_per_page' => $posts_per_page, 'id_location' => $id_location));
                echo '</div>';
                $jj++;
            }

            echo '</div>';
            ?>
        </div>
    </div>
</div>


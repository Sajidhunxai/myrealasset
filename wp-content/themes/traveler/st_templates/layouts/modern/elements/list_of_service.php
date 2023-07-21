<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13-11-2018
 * Time: 5:10 PM
 * Since: 1.0.0
 * Updated: 1.0.0
 */
global $post;
$old_post = $post;

$args = [
    'post_type' => $service,
    'posts_per_page' => $posts_per_page,
    'order' => 'ASC',
    'orderby' => 'name',
];
if ($ids) {
    $args['post__in'] = explode(',', $ids);
    $args['orderby'] = 'post__in';
}
switch ($service) {
    case 'st_hotel':
        if (st_check_service_available('st_hotel')) {
            $hotel = STHotel::inst();
            $hotel->alter_search_query();
            $query = new WP_Query($args);
            $html = '<div class="services-grid"><div class="row">';
            while ($query->have_posts()):
                $query->the_post();
                $html .= st()->load_template('layouts/modern/hotel/loop/grid', '');
            endwhile;
            $hotel->remove_alter_search_query();
            wp_reset_postdata();
            $post = $old_post;
            $html .= '</div></div>';
            echo balanceTags($html);
        }
        break;
    case 'st_tours':
        if (st_check_service_available('st_tours')) {
            $tour = STTour::get_instance();
            $tour->alter_search_query();
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                if ($style == 'style1') {
                    echo '<div class="search-result-page st-tours service-slider-wrapper"><div class="st-hotel-result modern-search-result"><div class="owl-carousel st-service-slider ">';
                    while ($query->have_posts()):
                        $query->the_post();
                        echo st()->load_template('layouts/modern/tour/elements/loop/grid', '', array('slider' => true));
                    endwhile;
                    echo '</div></div></div>';
                } elseif ($style == 'style4') {
                    echo '<div class="search-result-page st-tours service-slider-wrapper"><div class="st-hotel-result modern-search-result"><div class="owl-carousel  list-service-' . esc_attr($style) . '">';
                    while ($query->have_posts()):
                        $query->the_post();
                        echo st()->load_template('layouts/modern/tour/elements/loop/grid2', '', array('slider' => true));
                    endwhile;
                    echo '</div></div></div>';
                } elseif ($style == 'style5') {
                    echo '<div class="row st-list-tour-services">';
                    echo '<div class="col-md-3 title-service">';
                    if (!empty($title)) {
                        echo '<h2 class="title">' . esc_html($title) . '</h2>';
                    }
                    if (!empty($description)) {
                        echo '<p class="description">' . esc_html($description) . '</p>';
                    }
                    echo '</div>';
                    echo '<div class="search-result-page st-tours service-slider-wrapper col-md-9"><div class="st-hotel-result modern-search-result"><div class="owl-carousel  list-service-' . esc_attr($style) . '">';
                    while ($query->have_posts()):
                        $query->the_post();
                        echo st()->load_template('layouts/modern/tour/elements/loop/grid3', '', array('slider' => true));
                    endwhile;
                    echo '</div></div></div></div>';
                } elseif ($style == 'style6') {
                    echo '<div class="search-result-page st-tours service-slider-wrapper"><div class="st-hotel-result modern-search-result"><div class="owl-carousel  list-service-' . esc_attr($style) . '">';
                    while ($query->have_posts()):
                        $query->the_post();
                        echo st()->load_template('layouts/modern/tour/elements/loop/grid4', '', array('slider' => true));
                    endwhile;
                    echo '</div></div></div>';
                } elseif ($style == 'style7') {
                    echo '<div class="search-result-page st-tours service-slider-7 service-slider-wrapper modern-search-result"><div class="list-service-' . esc_attr($style) . ' row">';
                    while ($query->have_posts()):
                        $query->the_post();
                        echo st()->load_template('layouts/modern/tour/elements/loop/grid7', '', array('slider' => false));
                    endwhile;
                    echo '</div></div>';
                } else {
                    $class = 'list-service-' . esc_attr($style);
                    if ($style == 'style2' || $style == 'style3') {
                        $class .= ' owl-carousel';
                    }
                    echo '<div class="search-result-page st-tours service-slider-wrapper"><div class="st-hotel-result modern-search-result"><div class="' . esc_attr($class) . '">';
                    while ($query->have_posts()):
                        $query->the_post();
                        echo st()->load_template('layouts/modern/tour/elements/loop/grid', '', array('slider' => ($style == 'style2' || $style == 'style3') ? true : false,'col'=> '3'));
                    endwhile;
                    echo '</div></div></div>';
                }
            }
            $tour->remove_alter_search_query();
            wp_reset_postdata();
            $post = $old_post;
        }
        break;
    case 'st_rental':
        if (st_check_service_available('st_rental')) {
            $rental = STRental::inst();
            $rental->alter_search_query();
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                echo '<div class="search-result-page st-rental service-slider-wrapper"><div class="st-hotel-result"><div class="owl-carousel st-service-rental-slider">';
                while ($query->have_posts()):
                    $query->the_post();
                    echo st()->load_template('layouts/modern/rental/elements/loop/grid', '', array('slider' => true));
                endwhile;
                echo '</div></div></div>';
            }
            $rental->remove_alter_search_query();
            wp_reset_postdata();
            $post = $old_post;
        }
        break;
    case 'st_activity':
        if (st_check_service_available('st_activity')) {
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
        }
        break;
    case 'st_cars':
        if (st_check_service_available('st_cars')) {
            $car = STCars::get_instance();
            $car->alter_search_query();
            $query = new WP_Query($args);
            if ($query->have_posts()) {
                echo '<div class="search-result-page st-tours service-slider-wrapper st_cars"><div class="st-hotel-result  modern-search-result"><div class="owl-carousel st-service-slider">';
                while ($query->have_posts()):
                    $query->the_post();
                    echo st()->load_template('layouts/modern/car/elements/loop/grid', '', array('slider' => true));
                endwhile;
                echo '</div></div></div>';
            }
            $car->remove_alter_search_query();
            wp_reset_postdata();
            $post = $old_post;
        }
        break;
}
if ($style === "loadmore") {
    ?>
    <div class="row st-loadmore loadmore-ccv">
        <div class="col-md-12 load-ajax-icon">
            <div class="loader-wrapper">
                <div class="st-loader"></div>
            </div>
        </div>
        <div class="text-center st-button-loadmore">

            <div class="control-loadmore text-center">
                <a class="load_more_post st-button--main" href="#" data-posts-per-page="<?php echo (int) $posts_per_page; ?>" data-paged="1" type_service="<?php echo esc_attr($service); ?>"  data-id_service = "<?php echo esc_attr($ids) ?>" check-all="true" ><?php echo esc_html__('Load more', 'traveler') ?></a>

            </div>

        </div>
    </div>
<?php } ?>

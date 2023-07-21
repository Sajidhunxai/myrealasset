<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 14-11-2018
 * Time: 11:09 AM
 * Since: 1.0.0
 * Updated: 1.0.0
 */
$service = explode(',', $service);
if (!empty($service)) {
    $args = [
        'post_type' => 'location',
        'posts_per_page' => $posts_per_page
    ];
    if ($ids) {
        $args['post__in'] = explode(',', $ids);
        $args['orderby'] = 'post__in';
    }

    global $post;
    $old_post = $post;
    $query = new WP_Query($args);

    $result_page = '';

    if (count($service) == 1) {
        $result_page = '';

        switch ($service[0]) {
            case 'st_hotel':
                $result_page = get_the_permalink(st_get_page_search_result('st_hotel'));
                break;
            case 'st_rental':
                $result_page = get_the_permalink(st_get_page_search_result('st_rental'));
                break;
            case 'st_tours':
                $result_page = get_the_permalink(st_get_page_search_result('st_tours'));
                break;
            case 'st_activity':
                $result_page = get_the_permalink(st_get_page_search_result('st_activity'));
                break;
            case 'st_cars':
                $result_page = get_the_permalink(st_get_page_search_result('st_cars'));
                break;
        }
    }
    ?>
    <?php if ($style == 'layout5') { ?>
        <div class="list-destination list-destination-style5 row">
            <?php
            while ($query->have_posts()): $query->the_post();
                $location_id = get_the_ID();
                $result_page = add_query_arg([
                    'location_name' => get_the_title(),
                    'location_id' => get_the_ID()
                        ], $result_page);
                ?>
                <div class=" col-xs-12 col-sm-6 col-md-6 col-lg-4">
                    <div class="destination-item">
                        <img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), [370, 370]); ?>" width="370" height="370" alt = "<?php echo get_the_title();?>">
                        <a href="<?php echo esc_url(get_the_permalink($location_id)) ?>"><h3 class="title"><?php the_title(); ?></h3></a>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
            $post = $old_post;
            ?>
        </div>
    <?php } elseif ($style == 'layout6') { ?>
        <div class="list-destination list-destination-style6 row">
            <?php
            while ($query->have_posts()): $query->the_post();
                $location_id = get_the_ID();
                $result_page = add_query_arg([
                    'location_name' => get_the_title(),
                    'location_id' => get_the_ID()
                        ], $result_page);
                ?>
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="destination-item has-matchHeight">
                        <a href="<?php echo esc_url(get_the_permalink($location_id)) ?>">
                            <img src="<?php echo wp_get_attachment_image_url(get_post_thumbnail_id(), [740, 540]); ?>" width="740" height="540" alt = "<?php echo get_the_title();?>">
                            <h3 class="title"><?php the_title(); ?></h3>
                        </a>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
            $post = $old_post;
            ?>
        </div>
    <?php } elseif ($style == 'layout7') { ?>
        <div class="row list-destination <?php echo esc_attr($style); ?>">
            <?php
            $i = 0;
            while ($query->have_posts()): $query->the_post();
                $location_id = get_the_ID();
                $location_name = get_the_title();
                if (count($service) == 1)
                    $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                $class = 'col-xs-12 col-sm-6 col-md-4 has-matchHeight normal-item';
                ?>
                <div class="<?php echo esc_attr($class); ?>">
                    <div class="destination-item">
                        <div class="image">
                            <a href="<?php echo get_permalink($location_id); ?>">
                                <?php
                                $thumbnail = get_post_thumbnail_id();
                                $size = array(370, 370);
                                if ($style == 'masonry') {
                                    if ($i == 0)
                                        $size = array(770, 375);
                                } elseif ($style == 'layout3') {
                                    $size = array(270, 335);
                                } elseif ($style == 'layout4') {
                                    $size = array(270, 200);
                                }
                                $img_src = wp_get_attachment_image_url($thumbnail, $size);
                                ?>
                                <img src="<?php echo esc_url($img_src); ?>" class="img-responsive" width="<?php echo esc_attr($size[0]);?>" height="<?php echo esc_attr($size[1]);?>" alt = "<?php echo get_the_title();?>">
                            </a>
                        </div>
                        <div class="content affilate-destination">
                            <div class="st_destination">
                                <h3 class="title">
                                    <a href="<?php echo get_permalink($location_id); ?>">
                                        <?php the_title() ?>
                                    </a>
                                </h3>
                                <?php
                                if (count($service) == 1) {
                                    echo '<div class="desc ' . esc_attr($service[0]) . '">';
                                    switch ($service[0]) {
                                        case 'st_hotel':
                                            $total = STLocation::count_services($location_id, "'st_hotel'");
                                            echo '<a href="' . esc_url($result_page) . '">';
                                            echo sprintf(_n('%s Hotel', '%s Hotels', $total, 'traveler'), $total);
                                            echo '</a>';
                                            break;
                                        case 'st_rental':
                                            $total = STLocation::count_services($location_id, "'st_rental'");
                                            echo '<a href="' . esc_url($result_page) . '">';
                                            echo sprintf(_n('%s Rental', '%s Rentals', $total, 'traveler'), $total);
                                            echo '</a>';
                                            break;
                                        case 'st_tours':
                                            $total = STLocation::count_services($location_id, '"' . $service[0] . '"');
                                            echo '<a href="' . esc_url($result_page) . '">';
                                            echo sprintf(_n('%s Tour', '%s Tours', $total, 'traveler'), $total);
                                            echo '</a>';
                                            break;
                                        case 'st_activity':
                                            $total = STLocation::count_services($location_id, '"' . $service[0] . '"');
                                            echo '<a href="' . esc_url($result_page) . '">';
                                            echo sprintf(_n('%s Activity', '%s Activities', $total, 'traveler'), $total);
                                            echo '</a>';
                                            break;
                                        case 'st_cars':
                                            $total = STLocation::count_services($location_id, '"' . $service[0] . '"');
                                            echo '<a href="' . esc_url($result_page) . '">';
                                            echo sprintf(_n('%s Car', '%s Cars', $total, 'traveler'), $total);
                                            echo '</a>';
                                            break;
                                    }
                                    echo '</div>';
                                } else {
                                    echo '<ul class="desc multi">';
                                    $desc_str = '';
                                    $total_service = STLocation::count_services_multi_service($location_id, $service);
                                    foreach ($total_service as $kk => $vv) {
                                        $result_page = '';
                                        switch ($vv['post_type']) {
                                            case 'st_hotel':
                                                $result_page = get_the_permalink(st()->get_option('hotel_search_result_page'));
                                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                $desc_str .= '<li><a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Hotel', '%s Hotels', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a></li>';
                                                break;
                                            case 'st_rental':
                                                $result_page = get_the_permalink(st()->get_option('rental_search_result_page'));
                                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                $desc_str .= '<li><a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Rental', '%s Rentals', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a></li>';
                                                break;
                                            case 'st_tours':
                                                $result_page = get_the_permalink(st()->get_option('tours_search_result_page'));
                                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                $desc_str .= '<li><a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Tour', '%s Tours', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a></li>';
                                                break;
                                            case 'st_activity':
                                                $result_page = get_the_permalink(st()->get_option('activity_search_result_page'));
                                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                $desc_str .= '<li><a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Activity', '%s Activities', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a></li>';
                                                break;
                                            case 'st_cars':
                                                $result_page = get_the_permalink(st()->get_option('cars_search_result_page'));
                                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                $desc_str .= '<li><a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Car', '%s Cars', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a></li>';
                                                break;
                                        }
                                    }

                                    echo balanceTags($desc_str);
                                    echo '</ul>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $i++;
            endwhile;
            wp_reset_postdata();
            $post = $old_post;
            ?>
        </div>
    <?php } elseif ($style == 'layout8') { ?>
        <div class=" list-destination-style8  <?php echo esc_attr($style); ?>">
            <div class="owl-carousel">
                <?php
                $i = 0;
                while ($query->have_posts()): $query->the_post();
                    $location_id = get_the_ID();
                    $location_name = get_the_title();
                    if (count($service) == 1)
                        $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                    ?>
                    <div class="destination-item">
                        <div class="image">
                            <?php
                            $thumbnail = get_post_thumbnail_id();
                            $size = array(370, 370);
                            $img_src = wp_get_attachment_image_url($thumbnail, $size);
                            ?>
                            <a href="<?php echo esc_url(get_the_permalink($location_id)); ?>">
                                <img src="<?php echo esc_url($img_src); ?>" width="<?php echo esc_attr($size[0]);?>" height="<?php echo esc_attr($size[1]);?>"
                                     class="img-responsive" alt = "<?php echo get_the_title();?>">
                            </a>
                        </div>
                        <div class="content affilate-destination">
                            <div class="st_destination">
                                <h3 class="title">
                                    <a href="<?php echo esc_url(get_the_permalink($location_id)); ?>">
                                        <?php the_title() ?>
                                    </a>
                                </h3>
                                <?php
                                if (count($service) == 1) {
                                    echo '<div class="desc ' . esc_attr($service[0]) . '">';
                                    switch ($service[0]) {
                                        case 'st_hotel':
                                            $total = STLocation::count_services($location_id, "'st_hotel'");
                                            echo '<a href="' . esc_url($result_page) . '">';
                                            echo sprintf(_n('%s Hotel', '%s Hotels', $total, 'traveler'), $total);
                                            echo '</a>';
                                            break;
                                        case 'st_rental':
                                            $total = STLocation::count_services($location_id, "'st_rental'");
                                            echo '<a href="' . esc_url($result_page) . '">';
                                            echo sprintf(_n('%s Rental', '%s Rentals', $total, 'traveler'), $total);
                                            echo '</a>';
                                            break;
                                        case 'st_tours':
                                            $total = STLocation::count_services($location_id, '"' . $service[0] . '"');
                                            echo '<a href="' . esc_url($result_page) . '">';
                                            echo sprintf(_n('%s Tour', '%s Tours', $total, 'traveler'), $total);
                                            echo '</a>';
                                            break;
                                        case 'st_activity':
                                            $total = STLocation::count_services($location_id, '"' . $service[0] . '"');
                                            echo '<a href="' . esc_url($result_page) . '">';
                                            echo sprintf(_n('%s Activity', '%s Activities', $total, 'traveler'), $total);
                                            echo '</a>';
                                            break;
                                    }
                                    echo '</div>';
                                } else {
                                    echo '<ul class="desc multi">';
                                    $desc_str = '';
                                    foreach ($service as $kk => $vv) {
                                        $result_page = '';
                                        $total = STLocation::count_services($location_id, '"' . $vv . '"');
                                        switch ($vv) {
                                            case 'st_hotel':
                                                $result_page = get_the_permalink(st()->get_option('hotel_search_result_page'));
                                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                $desc_str .= '<li><a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Hotel', '%s Hotels', $total, 'traveler'), $total) . '</a></li>';
                                                break;
                                            case 'st_rental':
                                                $result_page = get_the_permalink(st()->get_option('rental_search_result_page'));
                                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                $desc_str .= '<li><a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Rental', '%s Rentals', $total, 'traveler'), $total) . '</a></li>';
                                                break;
                                            case 'st_tours':
                                                $result_page = get_the_permalink(st()->get_option('tours_search_result_page'));
                                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                $desc_str .= '<li><a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Tour', '%s Tours', $total, 'traveler'), $total) . '</a></li>';
                                                break;
                                            case 'st_activity':
                                                $result_page = get_the_permalink(st()->get_option('activity_search_result_page'));
                                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                $desc_str .= '<li><a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Activity', '%s Activities', $total, 'traveler'), $total) . '</a></li>';
                                                break;
                                        }
                                    }

                                    echo balanceTags($desc_str);
                                    echo '</ul>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    $i++;
                endwhile;
                wp_reset_postdata();
                $post = $old_post;
                ?>
            </div>

        </div>
    <?php } elseif ($style == 'layout9') { //layout solo destination ?>
        <div class="row list-destination  list-destination--<?php echo esc_attr($style); ?>">
            <?php
            $i = 0;
            while ($query->have_posts()): $query->the_post();
                $location_id = get_the_ID();
                $location_name = get_the_title();
                $url = st_get_link_with_search(get_the_permalink(st()->get_option('tours_search_result_page')), array('location_name', 'location_id'), ['location_name' => $location_name, 'location_id' => $location_id]);
                $class = 'has-matchHeight normal-item slider-item';
                ?>
                <div class="<?php echo esc_attr($class); ?>">
                    <div class="destination-item">
                        <div class="image">
                            <a href="<?php echo esc_url($url); ?>">
                                <?php
                                $thumbnail = get_post_thumbnail_id();
                                $size = array(270, 360);
                                $img_src = wp_get_attachment_image_url($thumbnail, $size);
                                ?>
                                <img src="<?php echo esc_url($img_src); ?>" class="img-responsive" width="<?php echo esc_attr($size[0]);?>" height="<?php echo esc_attr($size[1]);?>" alt = "<?php echo get_the_title();?>">
                            </a>
                        </div>
                        <div class="content affilate-destination">
                            <div class="st_destination">
                                <a href="<?php echo esc_url($url); ?>">
                                    <h3 class="title">
                                        <?php the_title() ?> 
                                    </h3>                                
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $i++;
            endwhile;
            wp_reset_postdata();
            $post = $old_post;
            ?>

        </div>
    <?php } else { ?>
        <div class="row list-destination <?php echo esc_attr($style); ?>">
            <?php
            $i = 0;
            while ($query->have_posts()): $query->the_post();
                $location_id = get_the_ID();
                $location_name = get_the_title();
                if (count($service) == 1)
                    $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                $class = 'col-xs-12 col-sm-6 col-md-4 has-matchHeight normal-item';
                if ($style == 'masonry') {
                    if ($i == 0)
                        $class = 'col-xs-12 col-sm-12 col-md-8 has-matchHeight first-item';
                    elseif ($i == 1)
                        $class = 'col-xs-12 col-sm-6 col-md-4 has-matchHeight second-item';
                    else
                        $class = 'col-xs-12 col-sm-6 col-md-4 has-matchHeight normal-item';
                } elseif ($style == 'layout3') {
                    $class = 'col-xs-12 col-sm-6 col-md-3 has-matchHeight normal-item';
                }
                ?>
                <div class="<?php echo esc_attr($class); ?>">
                    <div class="destination-item">
                        <div class="image">
                            <?php
                            $thumbnail = get_post_thumbnail_id();
                            $size = array(370, 370);
                            if ($style == 'masonry') {
                                if ($i == 0)
                                    $size = array(770, 375);
                            } elseif ($style == 'layout3') {
                                $size = array(270, 335);
                            } elseif ($style == 'layout4') {
                                $size = array(270, 200);
                            }
                            $img_src = wp_get_attachment_image_url($thumbnail, $size);
                            ?>
                            <a class="st-link" href="<?php echo esc_url(get_the_permalink($location_id)) ?>">
                                <img src="<?php echo esc_url($img_src); ?>" width="<?php echo esc_attr($size[0]);?>" height="<?php echo esc_attr($size[1]);?>"
                                     class="img-responsive" alt = "<?php echo get_the_title();?>">
                            </a>
                            <div class="content">
                                <h3 class="title">
                                    <a href="<?php echo esc_url(get_the_permalink($location_id)); ?>">
                                        <?php the_title() ?>
                                    </a>
                                </h3>
                                <?php
                                if ($style != 'layout4') {
                                    if (count($service) == 1) {
                                        echo '<div class="desc ' . esc_attr($service[0]) . '">';
                                        switch ($service[0]) {
                                            case 'st_hotel':
                                                $total = STLocation::count_services($location_id, "'st_hotel'");
                                                echo '<a href="' . esc_url($result_page) . '">';
                                                echo sprintf(_n('%s property', '%s properties', $total, 'traveler'), $total);
                                                echo '</a>';
                                                break;
                                            case 'st_rental':
                                                $total = STLocation::count_services($location_id, "'st_rental'");
                                                echo '<a href="' . esc_url($result_page) . '">';
                                                echo sprintf(_n('%s property', '%s properties', $total, 'traveler'), $total);
                                                echo '</a>';
                                                break;
                                            case 'st_tours':
                                                $total = STLocation::count_services($location_id, '"' . $service[0] . '"');
                                                echo '<a href="' . esc_url($result_page) . '">';
                                                echo sprintf(_n('%s tour', '%s tours', $total, 'traveler'), $total);
                                                echo '</a>';
                                                break;
                                            case 'st_activity':
                                                $total = STLocation::count_services($location_id, '"' . $service[0] . '"');
                                                echo '<a href="' . esc_url($result_page) . '">';
                                                echo sprintf(_n('%s activity', '%s activities', $total, 'traveler'), $total);
                                                echo '</a>';
                                                break;
                                            case 'st_cars':
                                                $total = STLocation::count_services($location_id, '"' . $service[0] . '"');
                                                echo '<a href="' . esc_url($result_page) . '">';
                                                echo sprintf(_n('%s car', '%s cars', $total, 'traveler'), $total);
                                                echo '</a>';
                                                break;
                                        }
                                        echo '</div>';
                                    } else {
                                        echo '<div class="desc multi">';
                                        $desc_str = '';
                                        $total_service = STLocation::count_services_multi_service($location_id, $service);
                                        foreach ($total_service as $kk => $vv) {
                                            $result_page = '';
                                            switch ($vv['post_type']) {
                                                case 'st_hotel':
                                                    $result_page = get_the_permalink(st()->get_option('hotel_search_result_page'));
                                                    $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                    $desc_str .= '<a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Hotel', '%s Hotels', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a>';
                                                    break;
                                                case 'st_rental':
                                                    $result_page = get_the_permalink(st()->get_option('rental_search_result_page'));
                                                    $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                    $desc_str .= '<a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Rental', '%s Rentals', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a>';
                                                    break;
                                                case 'st_tours':
                                                    $result_page = get_the_permalink(st()->get_option('tours_search_result_page'));
                                                    $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                    $desc_str .= '<a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Tour', '%s Tours', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a>';
                                                    break;
                                                case 'st_activity':
                                                    $result_page = get_the_permalink(st()->get_option('activity_search_result_page'));
                                                    $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                    $desc_str .= '<a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Activity', '%s Activities', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a>';
                                                    break;
                                                case 'st_cars':
                                                    $result_page = get_the_permalink(st()->get_option('cars_search_result_page'));
                                                    $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                    $desc_str .= '<a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Car', '%s Cars', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a>';
                                                    break;
                                            }
                                        }

                                        echo balanceTags($desc_str);
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                            <?php
                            if ($style == 'layout4') {
                                if (count($service) == 1) {
                                    echo '<div class="desc ' . esc_attr($service[0]) . ' single">';
                                    switch ($service[0]) {
                                        case 'st_hotel':
                                            $total = STLocation::count_services($location_id, "'st_hotel'");
                                            echo '<a href="' . esc_url($result_page) . '">';
                                            echo sprintf(_n('%s property', '%s properties', $total, 'traveler'), $total);
                                            echo '</a>';
                                            break;
                                        case 'st_rental':
                                            $total = STLocation::count_services($location_id, "'st_rental'");
                                            echo '<a href="' . esc_url($result_page) . '">';
                                            echo sprintf(_n('%s property', '%s properties', $total, 'traveler'), $total);
                                            echo '</a>';
                                            break;
                                        case 'st_tours':
                                            $total = STLocation::count_services($location_id, '"' . $service[0] . '"');
                                            echo '<a href="' . esc_url($result_page) . '">';
                                            echo sprintf(_n('%s tour', '%s tours', $total, 'traveler'), $total);
                                            echo '</a>';
                                            break;
                                        case 'st_activity':
                                            $total = STLocation::count_services($location_id, '"' . $service[0] . '"');
                                            echo '<a href="' . esc_url($result_page) . '">';
                                            echo sprintf(_n('%s activity', '%s activities', $total, 'traveler'), $total);
                                            echo '</a>';
                                            break;
                                        case 'st_cars':
                                            $total = STLocation::count_services($location_id, '"' . $service[0] . '"');
                                            echo '<a href="' . esc_url($result_page) . '">';
                                            echo sprintf(_n('%s car', '%s cars', $total, 'traveler'), $total);
                                            echo '</a>';
                                            break;
                                    }
                                    echo '</div>';
                                } else {
                                    echo '<div class="desc multi">';
                                    $desc_str = '';
                                    $total_service = STLocation::count_services_multi_service($location_id, $service);
                                    foreach ($total_service as $kk => $vv) {
                                        $result_page = '';
                                        switch ($vv['post_type']) {
                                            case 'st_hotel':
                                                $result_page = get_the_permalink(st()->get_option('hotel_search_result_page'));
                                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                $desc_str .= '<a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Hotel', '%s Hotels', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a>';
                                                break;
                                            case 'st_rental':
                                                $result_page = get_the_permalink(st()->get_option('rental_search_result_page'));
                                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                $desc_str .= '<a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Rental', '%s Rentals', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a>';
                                                break;
                                            case 'st_tours':
                                                $result_page = get_the_permalink(st()->get_option('tours_search_result_page'));
                                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                $desc_str .= '<a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Tour', '%s Tours', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a>';
                                                break;
                                            case 'st_activity':
                                                $result_page = get_the_permalink(st()->get_option('activity_search_result_page'));
                                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                $desc_str .= '<a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Activity', '%s Activities', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a>';
                                                break;
                                            case 'st_cars':
                                                $result_page = get_the_permalink(st()->get_option('cars_search_result_page'));
                                                $result_page = add_query_arg(['location_name' => $location_name, 'location_id' => $location_id], $result_page);
                                                $desc_str .= '<a href="' . esc_url($result_page) . '">' . sprintf(_n('%s Car', '%s Cars', $vv['total_item'], 'traveler'), $vv['total_item']) . '</a>';
                                                break;
                                        }
                                    }

                                    echo balanceTags($desc_str);
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
                $i++;
            endwhile;
            wp_reset_postdata();
            $post = $old_post;
            ?>
        </div>
        <?php
    }
}

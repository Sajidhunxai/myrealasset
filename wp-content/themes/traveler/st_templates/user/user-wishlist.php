<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User wishlist
 *
 * Created by ShineTheme
 *
 */
$array_tab_wishlist = array();
if (st_check_service_available('st_hotel')):
    $array_tab_wishlist['tab_hotel'] =  __('Hotel', 'traveler');
endif;
if (st_check_service_available('st_tours')):
    $array_tab_wishlist['tab_tour'] =  __('Tour', 'traveler');
endif;
if (st_check_service_available('st_activity')):
    $array_tab_wishlist['tab_activity'] =  __('Activity', 'traveler');
endif;
if (st_check_service_available('st_rental')):
    $array_tab_wishlist['tab_rental'] =  __('Rental', 'traveler');
endif;
if (st_check_service_available('st_cars')):
    $array_tab_wishlist['tab_car'] =  __('Car', 'traveler');
endif;
?>
<div class="st-create">
    <h2><?php STUser_f::get_title_account_setting() ?></h2>
</div>
<div class="infor-st-setting st-wishlist-wrap">
    <div class="st-loadding-wishlist">
        <div class="lds-dual-ring"></div>
    </div>

    <div class="tabbable">
        <ul class="nav nav-tabs" id="myTab">
            <?php
                $i= 0;
                foreach ($array_tab_wishlist as $key => $tab) { ?>
                    <li <?php if($i == 0){?> class="active" <?php }?> >
                       <a href="#<?php echo esc_attr($key)?>" data-toggle="tab"><?php echo esc_attr($tab);?></a>
                    </li>
                <?php
                $i++;
            }
            ?>
        </ul>
        <div class="tab-content">
             <?php
                $j= 0;
                $data_list = array();
                $data_list = get_user_meta( $data->ID , 'st_wishlist' , true);
                $list_id_hotel = array();
                $list_id_rental = array();
                $list_id_activity = array();
                $list_id_car = array();
                $list_id_tours = array();
                if(!empty($data_list)){
                    $data_list = json_decode($data_list);
                    foreach ($data_list as $key => $value) {
                        if($value->type==="st_hotel"){
                            $list_id_hotel[] = $value->id;
                        } else if($value->type==="st_rental"){
                            $list_id_rental[] = $value->id;
                        }else if($value->type==="st_tours"){
                            $list_id_tours[] = $value->id;
                        }else if($value->type==="st_activity"){
                            $list_id_activity[] = $value->id;
                        }else if($value->type==="st_cars"){
                            $list_id_car[] = $value->id;
                        } else {

                        }
                    }
                }
                foreach ($array_tab_wishlist as $key => $tab) {
                    if($key === 'tab_hotel'){ ?>
                        <div class="tab-pane fade <?php if($j == 0){?> in active <?php }?>" id="<?php echo esc_attr($key)?>">
                            <?php if(!empty($list_id_hotel)){ ?>
                                <div id="data_whislist" data-list-wishlist ="<?php echo implode(",",$list_id_hotel);?>" class="booking-list st-wishlist-hotel booking-list-wishlist style-list">
                                    <ul class="page-numbers">
                                    <?php
                                    $posts_per_page = st()->get_option( 'hotel_posts_per_page', 12 );
                                    $args = array(
                                        'post_type' => 'st_hotel',
                                        'post__in' => $list_id_hotel,
                                        'posts_per_page'       => $posts_per_page,
                                    );
                                    $hotel = STHotel::inst();
                                    $hotel->alter_search_query();
                                    query_posts($args);
                                    while ( have_posts() ) {
                                    the_post();
                                    global $post;
                                    echo st()->load_template('user/loop/loop', 'wishlist-hotel');
                                    }
                                    $hotel->remove_alter_search_query();
                                    ?>
                                    </ul>
                                    <div class="pagination moderm-pagination" id="modern-pagination-hotel" data-layout="normal">
                                        <?php echo TravelHelper::paging(false, false); ?>
                                        <span class="count-string">
                                            <?php
                                            global $wp_query, $st_search_query;
                                            if (!empty($st_search_query)) {
                                                $query = $st_search_query;
                                            } else{
                                                $query = $wp_query;
                                            }
                                            if ($query->found_posts):
                                                $page = get_query_var('paged');
                                                $posts_per_page = st()->get_option( 'hotel_posts_per_page', 12 );
                                                if (!$page) $page = 1;
                                                $last = (int)$posts_per_page * (int)($page);
                                                if ($last > $query->found_posts) $last = $query->found_posts;
                                                echo sprintf(__('%d - %d of %d ', 'traveler'), (int)$posts_per_page * ($page - 1) + 1, $last, $query->found_posts );
                                                echo ( $query->found_posts == 1 ) ? __( 'Hotel', 'traveler' ) : __( 'Hotels', 'traveler' );
                                            endif;
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            <?php
                             wp_reset_query();
                        } else {
                                echo '<h1>'.st_get_language('no_wishlist').'</h1>';
                            }?>
                        </div>
                    <?php }
                    if($key === 'tab_tour'){ ?>
                        <div class="tab-pane fade <?php if($j == 0){?> in active <?php }?>" id="<?php echo esc_attr($key)?>">
                            <?php if(!empty($list_id_tours)){ ?>
                                <div id="data_whislist" data-list-wishlist-tour ="<?php echo implode(",",$list_id_tours);?>" class="booking-list st-wishlist-tour booking-list-wishlist style-list">
                                    <ul class="page-numbers">
                                    <?php
                                    $posts_per_page = st()->get_option( 'tour_posts_per_page', 12 );
                                    $args = array(
                                        'post_type' => 'st_tours',
                                        'post__in' => $list_id_tours,
                                        'posts_per_page' => $posts_per_page,
                                    );
                                    $tour = STTour::get_instance();
                                    $tour->alter_search_query();
                                    query_posts($args);
                                    while ( have_posts() ) {
                                    the_post();
                                    global $post;
                                    echo st()->load_template('user/loop/loop', 'wishlist-tour');
                                    }
                                    $tour->remove_alter_search_query();
                                    ?>
                                    </ul>
                                    <div class="pagination moderm-pagination" id="modern-pagination-tour" data-layout="normal">
                                        <?php echo TravelHelper::paging(false, false); ?>
                                        <span class="count-string">
                                            <?php
                                            global $wp_query, $st_search_query;
                                            if (!empty($st_search_query)) {
                                                $query = $st_search_query;
                                            } else{
                                                $query = $wp_query;
                                            }
                                            if ($query->found_posts):
                                                $page = get_query_var('paged');
                                                $posts_per_page = st()->get_option( 'tour_posts_per_page', 12 );
                                                if (!$page) $page = 1;
                                                $last = (int)$posts_per_page * (int)($page);
                                                if ($last > $query->found_posts) $last = $query->found_posts;
                                                echo sprintf(__('%d - %d of %d ', 'traveler'), (int)$posts_per_page * ($page - 1) + 1, $last, $query->found_posts );
                                                echo ( $query->found_posts == 1 ) ? __( 'Tour', 'traveler' ) : __( 'Tours', 'traveler' );
                                            endif;
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            <?php
                            wp_reset_query();
                            } else {
                                echo '<h1>'.st_get_language('no_wishlist').'</h1>';
                            }?>
                        </div>
                    <?php }
                    if($key === 'tab_activity'){ ?>
                        <div class="tab-pane fade <?php if($j == 0){?> in active <?php }?>" id="<?php echo esc_attr($key)?>">
                            <?php if(!empty($list_id_activity)){ ?>
                                <div id="data_whislist" data-list-wishlist-activity ="<?php echo implode(",",$list_id_activity);?>" class="booking-list st-wishlist-activity booking-list-wishlist style-list">
                                    <ul class="page-numbers">
                                    <?php
                                    $posts_per_page = st()->get_option( 'activity_posts_per_page', 12 );
                                    $args = array(
                                        'post_type' => 'st_activity',
                                        'post__in' => $list_id_activity,
                                        'posts_per_page' => $posts_per_page,
                                    );
                                    $activity = STActivity::inst();
                                    $activity->alter_search_query();
                                    query_posts($args);
                                    while ( have_posts() ) {
                                    the_post();
                                    global $post;
                                    echo st()->load_template('user/loop/loop', 'wishlist-activity');
                                    }
                                    $activity->remove_alter_search_query();
                                    ?>
                                    </ul>
                                    <div class="pagination moderm-pagination" id="modern-pagination-activity" data-layout="normal">
                                        <?php echo TravelHelper::paging(false, false); ?>
                                        <span class="count-string">
                                            <?php
                                            global $wp_query, $st_search_query;
                                            if (!empty($st_search_query)) {
                                                $query = $st_search_query;
                                            } else{
                                                $query = $wp_query;
                                            }
                                            if ($query->found_posts):
                                                $page = get_query_var('paged');
                                                $posts_per_page = st()->get_option( 'activity_posts_per_page', 12 );
                                                if (!$page) $page = 1;
                                                $last = (int)$posts_per_page * (int)($page);
                                                if ($last > $query->found_posts) $last = $query->found_posts;
                                                echo sprintf(__('%d - %d of %d ', 'traveler'), (int)$posts_per_page * ($page - 1) + 1, $last, $query->found_posts );
                                                echo ( $query->found_posts == 1 ) ? __( 'Activity', 'traveler' ) : __( 'Activities', 'traveler' );
                                            endif;
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            <?php
                            wp_reset_query();
                            } else {
                                echo '<h1>'.st_get_language('no_wishlist').'</h1>';
                            }?>
                        </div>
                    <?php }
                    if($key === 'tab_rental'){ ?>
                        <div class="tab-pane fade <?php if($j == 0){?> in active <?php }?>" id="<?php echo esc_attr($key)?>">
                            <?php if(!empty($list_id_rental)){ ?>
                                <div id="data_whislist" data-list-wishlist-rental ="<?php echo implode(",",$list_id_rental);?>" class="booking-list st-wishlist-rental booking-list-wishlist style-list">
                                    <ul class="page-numbers">
                                    <?php
                                    $posts_per_page = st()->get_option( 'rental_posts_per_page', 12 );
                                    $args = array(
                                        'post_type' => 'st_rental',
                                        'post__in' => $list_id_rental,
                                        'posts_per_page' => $posts_per_page,
                                    );
                                    $rental = STRental::inst();
                                    $rental->alter_search_query();
                                    query_posts($args);
                                    while ( have_posts() ) {
                                    the_post();
                                    global $post;
                                    echo st()->load_template('user/loop/loop', 'wishlist-rental');
                                    }
                                    $rental->remove_alter_search_query();
                                    ?>
                                    </ul>
                                    <div class="pagination moderm-pagination" id="modern-pagination-rental" data-layout="normal">
                                        <?php echo TravelHelper::paging(false, false); ?>
                                        <span class="count-string">
                                            <?php
                                            global $wp_query, $st_search_query;
                                            if (!empty($st_search_query)) {
                                                $query = $st_search_query;
                                            } else{
                                                $query = $wp_query;
                                            }
                                            if ($query->found_posts):
                                                $page = get_query_var('paged');
                                                $posts_per_page = st()->get_option( 'rental_posts_per_page', 12 );
                                                if (!$page) $page = 1;
                                                $last = (int)$posts_per_page * (int)($page);
                                                if ($last > $query->found_posts) $last = $query->found_posts;
                                                echo sprintf(__('%d - %d of %d ', 'traveler'), (int)$posts_per_page * ($page - 1) + 1, $last, $query->found_posts );
                                                echo ( $query->found_posts == 1 ) ? __( 'Rental', 'traveler' ) : __( 'Rentals', 'traveler' );
                                            endif;
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            <?php
                            wp_reset_query();
                            } else {
                                echo '<h1>'.st_get_language('no_wishlist').'</h1>';
                            }?>


                        </div>
                    <?php }
                    if($key === 'tab_car'){ ?>
                        <div class="tab-pane fade <?php if($j == 0){?> in active <?php }?>" id="<?php echo esc_attr($key)?>">
                            <?php if(!empty($list_id_car)){ ?>
                                <div id="data_whislist" data-list-wishlist-car ="<?php echo implode(",",$list_id_car);?>" class="booking-list st-wishlist-car booking-list-wishlist style-list">
                                    <ul class="page-numbers">
                                    <?php
                                    $posts_per_page = st()->get_option( 'car_posts_per_page', 12 );
                                    $args = array(
                                        'post_type' => 'st_cars',
                                        'post__in' => $list_id_car,
                                        'posts_per_page' => $posts_per_page,
                                    );
                                    $car = STCars::get_instance();
                                    $car->alter_search_query();
                                    query_posts($args);
                                    while ( have_posts() ) {
                                    the_post();
                                    global $post;
                                    echo st()->load_template('user/loop/loop', 'wishlist-car');
                                    }
                                    $car->remove_alter_search_query();
                                    ?>
                                    </ul>
                                    <div class="pagination moderm-pagination" id="modern-pagination-car" data-layout="normal">
                                        <?php echo TravelHelper::paging(false, false); ?>
                                        <span class="count-string">
                                            <?php
                                            global $wp_query, $st_search_query;
                                            if (!empty($st_search_query)) {
                                                $query = $st_search_query;
                                            } else{
                                                $query = $wp_query;
                                            }
                                            if ($query->found_posts):
                                                $page = get_query_var('paged');
                                                $posts_per_page = st()->get_option( 'car_posts_per_page', 12 );
                                                if (!$page) $page = 1;
                                                $last = (int)$posts_per_page * (int)($page);
                                                if ($last > $query->found_posts) $last = $query->found_posts;
                                                echo sprintf(__('%d - %d of %d ', 'traveler'), (int)$posts_per_page * ($page - 1) + 1, $last, $query->found_posts );
                                                echo ( $query->found_posts == 1 ) ? __( 'Car', 'traveler' ) : __( 'Cars', 'traveler' );
                                            endif;
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            <?php
                            wp_reset_query();
                            } else {
                                echo '<h1>'.st_get_language('no_wishlist').'</h1>';
                            }?>
                        </div>
                    <?php }
                $j++;
                }?>
        </div>
    </div>
</div>

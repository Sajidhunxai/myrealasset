<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13-11-2018
 * Time: 5:10 PM
 * Since: 1.0.0
 * Updated: 1.0.0
 */

    $args = [
        'post_type' => 'st_hotel',
        'posts_per_page' => $posts_per_page,
    ];
    if(empty($ids)){
        $ids  = implode(',',st_get_all_ids_posttype('st_hotel')); 
    } 
    $args['post__in'] = explode(',', $ids);

    if (st_check_service_available('st_hotel')) {
        global $wp_query , $st_search_query, $st_search_args;
        $st_search_args = $args;
        $current_lang = TravelHelper::current_lang();
        $main_lang = TravelHelper::primary_lang();
        if (TravelHelper::is_wpml()) {
            global $sitepress;
            $sitepress->switch_lang($main_lang, true);
        }
        $st_pride_query = new WP_Query($args);
        $html = '<div class="services-grid"><div class="row">';
        while ($st_pride_query->have_posts()):
            $st_pride_query->the_post();
            $html .= st()->load_template('layouts/modern/hotel/loop/grid', '');
        endwhile;
        wp_reset_postdata();
        if (TravelHelper::is_wpml()) {
            global $sitepress;
            $sitepress->switch_lang($current_lang, true);
        }
        $html .= '</div></div>';
        echo balanceTags($html); ?>
        <div class="row st-loadmore loadmore-ccv">
            <div class="col-md-12 load-ajax-icon">
                <?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
            </div>
            <?php 
                if($posts_per_page !== '-1'){ ?>
                    <div class="text-center st-button-loadmore">
                        <div class="control-loadmore text-center">
                            <a class="load_more_post st-button--main" href="#" data-posts-per-page="<?php echo (int)$posts_per_page;?>" data-paged="1" type_service="st_hotel"  data-id_service = "<?php echo esc_attr($ids) ?>" check-all="true" data-index="1"><?php echo esc_html__('Load more' ,'traveler')  ?></a>

                        </div>

                    </div>
                <?php }
            ?>
            
        </div>
    <?php }
?>

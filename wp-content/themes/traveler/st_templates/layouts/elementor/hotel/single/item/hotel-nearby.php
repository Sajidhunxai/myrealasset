<?php 
    $st_show_hotel_nearby = st()->get_option('st_show_hotel_nearby','off');
    if($st_show_hotel_nearby == 'on'){
        global $post;
        $hotel = new STHotel();
        $nearby_posts = $hotel->get_near_by();
        if ($nearby_posts) { ?>
            <div class="st-hr x-large"></div>
            <h2 class="st-heading text-center"><?php echo __('Hotel Nearby', 'traveler') ?></h2>
            <div class="services-grid services-nearby hotel-nearby grid mt50">
                <div class="row service-list-wrapper">
                    <?php
                        foreach ($nearby_posts as $key => $post) {
                            setup_postdata($post);
                            echo st()->load_template('layouts/elementor/hotel/loop/normal', 'grid',array('item_row'=> 4));
                        }
                        wp_reset_query();
                        wp_reset_postdata();
                    ?>
                </div>
            </div>
        <?php }
    }
    
?>
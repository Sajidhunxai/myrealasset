<?php 
    $st_show_hotel_nearby = st()->get_option('st_show_hotel_nearby','off');
    if($st_show_hotel_nearby == 'on'){
        global $post;
        $hotel = new STHotel();
        $nearby_posts = $hotel->get_near_by(get_the_ID(), null, 8);
        if ($nearby_posts) { 
            wp_enqueue_script('owlcarousel');
            wp_enqueue_style('owlcarousel');
            $responsive = [
                '992' => [
                    'items' => 4,
                ],
                '768' => [
                    'items' => 2,
                ],
                '0' => [
                    'items' => 1,
                ]
            ];
            ?>
            <div class="services-nearby">
                <div class="st-hr x-large"></div>
                <h2 class="st-heading"><?php echo __('Explore other options', 'traveler') ?></h2>
                <div class="services-grid hotel-nearby">
                    <div class="service-list-wrapper owl-carousel st-owl-slider" data-items="3" data-margin="24" data-responsive="<?php echo esc_attr(json_encode($responsive)) ;?>">
                        <?php
                            foreach ($nearby_posts as $key => $post) {
                                setup_postdata($post);
                                echo '<div class="item-slide">';
                                echo stt_elementorv2()->loadView('services/hotel/loop/grid');
                                echo '</div>';
                            }
                            wp_reset_query();
                            wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </div>
                
        <?php }
    }
    
?>
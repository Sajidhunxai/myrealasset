<?php
if (!empty($post_ids_room)) {
    $attrs = [
        'data-effect' => [
            esc_attr($effect_style)
        ],
        'data-slides-per-view' => [
            esc_attr($slides_per_view)
        ],
        'data-pagination' => [
            esc_attr($pagination)
        ],
        'data-navigation' => [
            esc_attr($navigation)
        ],
        'data-auto-play' => [
            esc_attr($auto_play)
        ],
        'data-loop' => [
            esc_attr($loop)
        ],
        'data-delay' => [
            esc_attr($delay)
        ],
        'data-center-slider' => [
            esc_attr($center_slider)
        ],
        'data-style-slider' => [
            esc_attr($style_slider)
        ],
        'data-space-between' => [
            esc_attr($space_slider['size'])
        ]
    ];
    ?>
    <div class="st-sliders st_slider_room <?php echo esc_attr($style_slider); ?>" <?php echo st_render_html_attributes($attrs); ?> itemscope itemtype="https://schema.org/Hotel">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php
                $list_ids = ST_Elementor::st_explode_select2($post_ids_room);

                foreach ($list_ids as $key => $value) {
                    $img_url = get_the_post_thumbnail_url($key, 'full');
                    $price_ori = floatval(get_post_meta($key, 'price', true));
                    $hotel_id = intval(get_post_meta($key, 'room_parent', true));
                    ?>
                        <div class="swiper-slide">
                            <div class="st-img">
                                <h3 class="d-none" itemprop="name"><?php echo get_the_title($hotel_id); ?></h3>
                                <img class="swiper-lazy" src="<?php echo esc_url($img_url);?>" alt="<?php echo get_the_title($key)?>" width="100%" height="700px">
                                <div itemprop="containsPlace" itemscope itemtype="https://schema.org/HotelRoom">
                                    <h3 itemprop="name"><?php echo get_the_title($key)?></h3>
                                </div>
                                <?php if (!empty($text_button)) { ?>
                                    <a class="btn" href="<?php echo esc_url(get_permalink($key)); ?>" itemprop="priceRange"><?php echo esc_html__('starting at ', 'traveler'); ?><?php echo TravelHelper::format_money($price_ori) ?></a>
                                <?php } ?>
                            </div>
                        </div>
                <?php }
                ?>
            </div>

        </div>
        <?php
        $html = '';
        if ($pagination == 'on') {
            $html .= '<div class="swiper-pagination"></div>';
        }
        if ($navigation == 'on' && $center_slider == 'off') {
            $html .= '<div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"></span></div><div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"></span></div>';
        }

        echo balanceTags($html);
        ?>
    </div>
<?php }
?>
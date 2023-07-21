<?php
if (!empty($st_sliders)) {
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
    <div class="st-sliders <?php echo esc_attr($style_slider); ?>" <?php echo st_render_html_attributes($attrs); ?>>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php
                foreach ($st_sliders as $slider) {
                    ?>
                    <div class="swiper-slide">
                        <img class="swiper-lazy" src="<?php echo esc_url($slider['url']); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
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
        if ($navigation == 'on') {
            if ($style_slider === 'style-2') {
                $html .= '<div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"></span></div><div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"></span></div>';
            } else {
                $html .= '<div class="st-button-prev"><span></span></div><div class="st-button-next"><span></span></div>';
            }
        }
        if ($style_slider === 'style-2') {
            $html .= '<span class="count-item-index"></span>';
        }
        echo balanceTags($html);
        ?>
    </div>
<?php }
?>
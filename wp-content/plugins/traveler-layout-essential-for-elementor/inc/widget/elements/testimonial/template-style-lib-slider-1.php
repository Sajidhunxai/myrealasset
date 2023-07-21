<?php
$attrs = [];
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
    ]
];
$responsive = [
    '0' => [
        'slidesPerView' =>  1,
        'spaceBetween' => 10,
    ],
    '767' => [
        'slidesPerView' =>  2,
        'spaceBetween' => 24,
    ],
    '1024' => [
        'slidesPerView' =>  3,
        'spaceBetween' => 24,
    ],
    '1366' => [
        'slidesPerView' => $slides_per_view,
        'spaceBetween' => 24,
    ]
];

$class_col = $row_class = $html = '';
$item_in_row = $slides_per_view;

$class_col = 'swiper-slide';

$row_class = ' swiper-container';

if (!empty($list_testimonial)) { ?>
    <div class="st-testimonial st-lib st-style-arrow" <?php echo st_render_html_attributes($attrs); ?> <?php echo ' data-responsive="' . esc_attr(json_encode($responsive)) . '"'; ?>>

        <div class="testimonial-wrapper <?php echo esc_attr($row_class); ?>">

            <div class="swiper-wrapper">

                <?php
                foreach ($list_testimonial as $item_tes) { ?>
                    <div class="item-testimonial <?php echo esc_attr($st_style_testimonial); ?> <?php echo esc_attr($class_col); ?>">

                        <div class="item service-border-lib st-border-radius-lib">
                            <div class="d-flex-lib">
                                <div class="st-content-lib">
                                    <?php echo esc_html($item_tes["content_testimonial"]); ?>
                                </div>

                                <div class="rate-lib">
                                    <?php
                                    if (intval($item_tes["st_star_testimonial"]) > 0) {
                                        for ($i = 0; $i < intval($item_tes["st_star_testimonial"]); $i++) { ?>
                                            <i class="fa fa-star"></i>
                                        <?php }
                                    }
                                    ?>
                                </div>
                                <div class="author-meta-lib">
                                    <h4><?php echo esc_html($item_tes["name_testimonial"]); ?></h4>
                                    <div class="office-testimonial-lib"><?php echo esc_html($item_tes["office_testimonial"]); ?></div>

                                </div>

                            </div>

                        </div>

                    </div>
                <?php }

                ?>

            </div>

        </div>
        <?php
        if ($pagination == 'on') {
            $html .= '<div class="swiper-pagination"></div>';
        }
        if ($navigation == 'on') {
            $html .= '<div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"></span></div><div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"></span></div>';
        }

        echo balanceTags($html);
        ?>
    </div>
<?php } ?>
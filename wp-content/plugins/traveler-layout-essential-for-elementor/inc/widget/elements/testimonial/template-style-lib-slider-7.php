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
        'slidesPerView' => isset($item_row_mobile) ? $item_row_mobile : 1,
        'spaceBetween' => 10,
    ],
    '767' => [
        'slidesPerView' => isset($item_row_tablet) ? $item_row_tablet : 1,
        'spaceBetween' => 24,
    ],
    '1024' => [
        'slidesPerView' => isset($item_row_laptop) ? $item_row_laptop : 3,
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
    <div class="st-testimonial st-lib st-style-arrow <?php echo esc_attr($st_style_testimonial); ?>" <?php echo st_render_html_attributes($attrs); ?> <?php echo ' data-responsive="' . esc_attr(json_encode($responsive)) . '"'; ?>>

        <div class="testimonial-wrapper <?php echo esc_attr($row_class); ?>">

            <div class="swiper-wrapper">

                <?php
                foreach ($list_testimonial as $item_tes) { ?>
                    <div class="item-testimonial style-lib-slider-2 <?php echo esc_attr($st_style_testimonial); ?> <?php echo esc_attr($class_col); ?>">

                        <div class="item">
                            <div class="d-flex-lib">
                                <?php
                                if (intval($item_tes["st_star_testimonial"]) > 0) {
                                    echo "<div class='elementor--star-style-star_unicode'><div class='elementor-star-rating'>";
                                    for ($i = 0; $i < intval($item_tes["st_star_testimonial"]); $i++) { ?>
                                        <div class="elementor-star">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_11_1092)">
                                                    <path d="M19.4675 23.3151L12.0005 17.8271L4.5335 23.3151L7.4005 14.4521L-0.0625 8.99909H9.1515L12.0005 0.121094L14.8495 8.99909H24.0625L16.6005 14.4521L19.4675 23.3151Z" fill="#EB5757" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_11_1092">
                                                        <rect width="24" height="24" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </div>
                                    <?php }
                                    echo "</div></div>";
                                }
                                ?>
                                <div class="st-content-lib">
                                    <?php echo esc_html($item_tes["content_testimonial"]); ?>
                                </div>

                                <div class="author-meta-lib">
                                    <?php
                                    if (!empty($item_tes["st_avatar_testimonial"]['url'])) {
                                        ?>
                                        <div class="st-avatar-lib"><img src="<?php echo esc_url($item_tes["st_avatar_testimonial"]['url']); ?>" alt="<?php echo esc_attr($item_tes["name_testimonial"]); ?>"></div>
                                    <?php }
                                    ?>
                                    <h4><?php echo esc_html($item_tes["name_testimonial"]); ?></h4>
                                    <p class="office-testimonial-lib"><?php echo esc_html($item_tes["office_testimonial"]); ?></p>

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
            $html .= '<div class="st-button-prev"><svg width="30" height="22" viewBox="0 0 30 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.1505 1.09952C11.7112 0.660185 10.9988 0.660185 10.5595 1.09952L1.4545 10.2045C1.24353 10.4155 1.125 10.7017 1.125 11C1.125 11.2984 1.24353 11.5845 1.4545 11.7955L10.5595 20.9005C10.9988 21.3399 11.7112 21.3399 12.1505 20.9005C12.5898 20.4612 12.5898 19.7489 12.1505 19.3095L4.96599 12.125H27.75C28.3713 12.125 28.875 11.6213 28.875 11C28.875 10.3787 28.3713 9.87502 27.75 9.87502H4.96599L12.1505 2.69051C12.5898 2.25117 12.5898 1.53886 12.1505 1.09952Z" fill="white"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.4157 0.83436C11.8299 0.248573 10.8801 0.248573 10.2943 0.83436L1.18934 9.93936C0.908034 10.2207 0.75 10.6022 0.75 11C0.75 11.3978 0.908034 11.7794 1.18934 12.0607L10.2943 21.1657C10.8801 21.7515 11.8299 21.7515 12.4157 21.1657C13.0014 20.5799 13.0014 19.6301 12.4157 19.0444L5.87132 12.5H27.75C28.5784 12.5 29.25 11.8284 29.25 11C29.25 10.1716 28.5784 9.50002 27.75 9.50002H5.87132L12.4157 2.95568C13.0014 2.36989 13.0014 1.42015 12.4157 0.83436ZM10.8247 1.36469C11.1176 1.0718 11.5924 1.0718 11.8853 1.36469C12.1782 1.65758 12.1782 2.13246 11.8853 2.42535L4.70083 9.60985C4.59358 9.7171 4.56149 9.8784 4.61954 10.0185C4.67758 10.1587 4.81432 10.25 4.96599 10.25H27.75C28.1642 10.25 28.5 10.5858 28.5 11C28.5 11.4142 28.1642 11.75 27.75 11.75H4.96599C4.81432 11.75 4.67758 11.8414 4.61954 11.9815C4.56149 12.1216 4.59358 12.2829 4.70083 12.3902L11.8853 19.5747C12.1782 19.8676 12.1782 20.3425 11.8853 20.6353C11.5924 20.9282 11.1176 20.9282 10.8247 20.6353L1.71967 11.5304C1.57902 11.3897 1.5 11.1989 1.5 11C1.5 10.8011 1.57902 10.6103 1.71967 10.4697L10.8247 1.36469Z" fill="white"/>
                </svg>                
                </div><div class="st-button-next"><svg width="30" height="22" viewBox="0 0 30 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.8495 1.09952C18.2888 0.660185 19.0012 0.660185 19.4405 1.09952L28.5455 10.2045C28.7565 10.4155 28.875 10.7017 28.875 11C28.875 11.2984 28.7565 11.5845 28.5455 11.7955L19.4405 20.9005C19.0012 21.3399 18.2888 21.3399 17.8495 20.9005C17.4102 20.4612 17.4102 19.7489 17.8495 19.3095L25.034 12.125H2.25C1.62868 12.125 1.125 11.6213 1.125 11C1.125 10.3787 1.62868 9.87502 2.25 9.87502H25.034L17.8495 2.69051C17.4102 2.25117 17.4102 1.53886 17.8495 1.09952Z" fill="white"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.5843 0.83436C18.1701 0.248573 19.1199 0.248573 19.7057 0.83436L28.8107 9.93936C29.092 10.2207 29.25 10.6022 29.25 11C29.25 11.3978 29.092 11.7794 28.8107 12.0607L19.7057 21.1657C19.1199 21.7515 18.1701 21.7515 17.5843 21.1657C16.9986 20.5799 16.9986 19.6301 17.5843 19.0444L24.1287 12.5H2.25C1.42157 12.5 0.75 11.8284 0.75 11C0.75 10.1716 1.42157 9.50002 2.25 9.50002H24.1287L17.5843 2.95568C16.9986 2.36989 16.9986 1.42015 17.5843 0.83436ZM19.1753 1.36469C18.8824 1.0718 18.4076 1.0718 18.1147 1.36469C17.8218 1.65758 17.8218 2.13246 18.1147 2.42535L25.2992 9.60985C25.4064 9.7171 25.4385 9.8784 25.3805 10.0185C25.3224 10.1587 25.1857 10.25 25.034 10.25H2.25C1.83579 10.25 1.5 10.5858 1.5 11C1.5 11.4142 1.83579 11.75 2.25 11.75H25.034C25.1857 11.75 25.3224 11.8414 25.3805 11.9815C25.4385 12.1216 25.4064 12.2829 25.2992 12.3902L18.1147 19.5747C17.8218 19.8676 17.8218 20.3425 18.1147 20.6353C18.4076 20.9282 18.8824 20.9282 19.1753 20.6353L28.2803 11.5304C28.421 11.3897 28.5 11.1989 28.5 11C28.5 10.8011 28.421 10.6103 28.2803 10.4697L19.1753 1.36469Z" fill="white"/>
                </svg>                
                </div>';
        }

        echo balanceTags($html);
        ?>
    </div>
<?php } ?>
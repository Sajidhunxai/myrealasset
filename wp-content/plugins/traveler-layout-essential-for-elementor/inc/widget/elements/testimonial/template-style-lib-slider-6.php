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
        'slidesPerView' => isset($item_row_laptop) ? $item_row_laptop : 1,
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
    <div class="st-testimonial st-lib st-style-arrow <?php echo esc_attr($st_style_testimonial); ?> " <?php echo st_render_html_attributes($attrs); ?> <?php echo ' data-responsive="' . esc_attr(json_encode($responsive)) . '"'; ?>>

        <div class="testimonial-wrapper <?php echo esc_attr($row_class); ?>">

            <div class="swiper-wrapper">

                <?php
                foreach ($list_testimonial as $item_tes) { ?>
                    <div class="item-testimonial <?php echo esc_attr($class_col); ?>">

                        <div class="item">
                            <div class="d-flex-lib">

                                <div class="st-content-lib service-border-lib st-border-radius-lib">
                                    <?php echo esc_html($item_tes["content_testimonial"]); ?>
                                </div>

                                <div class="author-meta-lib">
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

                                    <?php
                                    if (!empty($item_tes["st_avatar_testimonial"]['url'])) {
                                        ?>
                                        <div class="st-avatar-lib"><img src="<?php echo esc_url($item_tes["st_avatar_testimonial"]['url']); ?>" alt="<?php echo esc_attr($item_tes["name_testimonial"]); ?>"></div>
                                    <?php }
                                    ?>
                                    <div class="name_testimonial"><?php echo esc_html($item_tes["name_testimonial"]); ?></div>
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
            $html .= '<div class="st-button-prev"><svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.10033 1.3996C7.80744 1.10671 7.33256 1.10671 7.03967 1.3996L0.969669 7.4696C0.829018 7.61025 0.75 7.80102 0.75 7.99993C0.75 8.19884 0.829018 8.38961 0.969669 8.53026L7.03967 14.6003C7.33256 14.8932 7.80744 14.8932 8.10033 14.6003C8.39322 14.3074 8.39322 13.8325 8.10033 13.5396L3.31066 8.74993H18.5C18.9142 8.74993 19.25 8.41415 19.25 7.99993C19.25 7.58572 18.9142 7.24993 18.5 7.24993H3.31066L8.10033 2.46026C8.39322 2.16737 8.39322 1.69249 8.10033 1.3996Z" fill="#4F4F4F"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.27711 1.22283C7.88658 0.8323 7.25342 0.832301 6.86289 1.22283L0.792892 7.29282C0.605356 7.48036 0.5 7.73472 0.5 7.99993C0.5 8.26515 0.605356 8.5195 0.792892 8.70704L6.86289 14.777C7.25342 15.1676 7.88658 15.1676 8.27711 14.777C8.66763 14.3865 8.66763 13.7533 8.27711 13.3628L3.91421 8.99993H18.5C19.0523 8.99993 19.5 8.55222 19.5 7.99993C19.5 7.44765 19.0523 6.99993 18.5 6.99993H3.91421L8.27711 2.63704C8.66763 2.24651 8.66763 1.61335 8.27711 1.22283ZM7.21645 1.57638C7.41171 1.38112 7.72829 1.38112 7.92355 1.57638C8.11882 1.77164 8.11882 2.08822 7.92355 2.28348L3.13388 7.07315C3.06238 7.14465 3.04099 7.25218 3.07969 7.3456C3.11839 7.43902 3.20955 7.49993 3.31066 7.49993H18.5C18.7761 7.49993 19 7.72379 19 7.99993C19 8.27607 18.7761 8.49993 18.5 8.49993H3.31066C3.20955 8.49993 3.11839 8.56084 3.07969 8.65426C3.04099 8.74768 3.06238 8.85521 3.13388 8.92671L7.92355 13.7164C8.11881 13.9116 8.11881 14.2282 7.92355 14.4235C7.72829 14.6187 7.41171 14.6187 7.21645 14.4235L1.14645 8.35349C1.05268 8.25972 1 8.13254 1 7.99993C1 7.86732 1.05268 7.74015 1.14645 7.64638L7.21645 1.57638Z" fill="#4F4F4F"/>
                </svg>
                </div><div class="st-button-next"><svg width="20" height="16" viewBox="0 0 20 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8997 1.3996C12.1926 1.10671 12.6674 1.10671 12.9603 1.3996L19.0303 7.4696C19.171 7.61025 19.25 7.80102 19.25 7.99993C19.25 8.19884 19.171 8.38961 19.0303 8.53026L12.9603 14.6003C12.6674 14.8932 12.1926 14.8932 11.8997 14.6003C11.6068 14.3074 11.6068 13.8325 11.8997 13.5396L16.6893 8.74993H1.5C1.08579 8.74993 0.75 8.41415 0.75 7.99993C0.75 7.58572 1.08579 7.24993 1.5 7.24993H16.6893L11.8997 2.46026C11.6068 2.16737 11.6068 1.69249 11.8997 1.3996Z" fill="#4F4F4F"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.7229 1.22283C12.1134 0.8323 12.7466 0.832301 13.1371 1.22283L19.2071 7.29282C19.3946 7.48036 19.5 7.73472 19.5 7.99993C19.5 8.26515 19.3946 8.5195 19.2071 8.70704L13.1371 14.777C12.7466 15.1676 12.1134 15.1676 11.7229 14.777C11.3324 14.3865 11.3324 13.7533 11.7229 13.3628L16.0858 8.99993H1.5C0.947715 8.99993 0.5 8.55222 0.5 7.99993C0.5 7.44765 0.947715 6.99993 1.5 6.99993H16.0858L11.7229 2.63704C11.3324 2.24651 11.3324 1.61335 11.7229 1.22283ZM12.7836 1.57638C12.5883 1.38112 12.2717 1.38112 12.0764 1.57638C11.8812 1.77164 11.8812 2.08822 12.0764 2.28348L16.8661 7.07315C16.9376 7.14465 16.959 7.25218 16.9203 7.3456C16.8816 7.43902 16.7905 7.49993 16.6893 7.49993H1.5C1.22386 7.49993 1 7.72379 1 7.99993C1 8.27607 1.22386 8.49993 1.5 8.49993H16.6893C16.7905 8.49993 16.8816 8.56084 16.9203 8.65426C16.959 8.74768 16.9376 8.85521 16.8661 8.92671L12.0764 13.7164C11.8812 13.9116 11.8812 14.2282 12.0764 14.4235C12.2717 14.6187 12.5883 14.6187 12.7836 14.4235L18.8536 8.35349C18.9473 8.25972 19 8.13254 19 7.99993C19 7.86732 18.9473 7.74015 18.8536 7.64638L12.7836 1.57638Z" fill="#4F4F4F"/>
                </svg>
                </div>';
        }

        echo balanceTags($html);
        ?>
    </div>
<?php } ?>
<?php
$attrs = array();
$attrs = [
    'data-slides-per-view' => [
        esc_attr($item_row)
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
        'slidesPerView' => isset($item_row_tablet) ? $item_row_tablet : 3,
        'spaceBetween' => 24,
    ],
    '1024' => [
        'slidesPerView' => isset($item_row_laptop) ? $item_row_laptop : 5,
        'spaceBetween' => 24,
    ],
    '1366' => [
        'slidesPerView' => $item_row,
        'spaceBetween' => 24,
    ]
];
$html = '';
$args = [
    'post_type' => 'post',
    'posts_per_page' => $posts_per_page,
    'order' => $order,
    'orderby' => $orderby,
];
if ($orderby === 'post__in' && !empty($post_ids)) {
    $list_ids = ST_Elementor::st_explode_select2($post_ids);
    $args['post__in'] = array_keys($list_ids);
}
$query_service = new WP_Query($args);
if ($query_service->have_posts()) { ?>
    <div class="st-list-service st-sliders st-style-arrow <?php echo esc_attr($layout_style); ?>" <?php echo st_render_html_attributes($attrs); ?> <?php echo ' data-responsive="' . esc_attr(json_encode($responsive)) . '"'; ?>>

        <div class="service-list-wrapper st-blog-list-el st-blog-list-lib swiper-container">
            <div class="swiper-wrapper">
                <?php while ($query_service->have_posts()) :
                    $query_service->the_post(); ?>
                    <div class="swiper-slide">
                        <?php
                        $post_id = get_the_ID();
                        $post_translated = TravelHelper::post_translated($post_id);
                        $thumbnail_id = get_post_thumbnail_id($post_translated);
                        ?>
                        <div class="services-item grid item-elementor">
                            <div class="item">
                                <div class="featured-image">
                                    <a href="<?php echo get_the_permalink(); ?>">
                                        <img itemprop="photo" src="<?php echo wp_get_attachment_image_url($thumbnail_id, array(450, 300)); ?>" alt="<?php echo get_the_title(); ?>" class="img-fluid st-hover-grow" />
                                    </a>
                                    <?php do_action('st_list_compare_button', get_the_ID(), get_post_type(get_the_ID())); ?>
                                </div>
                                <div class="content-item">
                                    <?php
                                    $category_detail = get_the_category(get_the_ID());
                                    if (!empty($category_detail)) {
                                        ?>
                                        <div class="cate category-color">
                                            <ul>
                                                <?php
                                                $v = $category_detail[0];
                                                $color = get_term_meta($v->term_id, '_category_color', true);
                                                $bg_rgba = st_hex2rgb_new($color, 0.06);
                                                $text_rgba = st_hex2rgb_new($color, 1);
                                                $inline_css = '';
                                                if (!empty($color)) {
                                                    $inline_css = 'style="background:' . esc_attr($bg_rgba) . '"';
                                                }
                                                echo '<li ' . ($inline_css) . '><a href="' . get_category_link($v->term_id) . '" style="color:' . esc_attr($text_rgba) . '"><span style="color:' . esc_attr($text_rgba) . '"></span>' . esc_html($v->name) . '</a></li>';
                                                ?>
                                            </ul>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <h3 class="title" itemprop="name">
                                        <a href="<?php echo get_the_permalink(); ?>" class="st-link c-main"><?php echo get_the_title($post_translated) ?></a>
                                    </h3>

                                    <div class="meta">
                                        <ul>
                                            <li>
                                                <?php the_time(get_option('date_format')) ?>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
                ?>
            </div>
            <?php if ($pagination == 'on') { ?>
                <div class="swiper-pagination"></div>
            <?php } ?>
        </div>
        <?php
        if ($navigation == 'on') { ?>
            <div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"></span></div>
            <div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"></span></div>
        <?php }
        echo balanceTags($html);
        ?>

    </div>
<?php }
?>
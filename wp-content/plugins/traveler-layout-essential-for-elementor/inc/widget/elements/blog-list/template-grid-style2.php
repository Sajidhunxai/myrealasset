<?php
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
$item_row_tablet = !empty($item_row_tablet) ? $item_row_tablet : 1;
$item_row_tablet_extra = !empty($item_row_tablet_extra) ? $item_row_tablet_extra : 1;
$query_service = new WP_Query($args);
if ($query_service->have_posts()) { ?>
    <div class="st-list-service st-sliders blog-grid-style2">
        <div class="service-list-wrapper st-blog-list-el">
            <div class="row">
                <?php while ($query_service->have_posts()) :
                    $col_classes = 'col-lg-12';
                    if ($item_row) {
                        $col_classes = 'col-12 col-sm-' . (12 / $item_row_tablet) . ' col-md-' . (12 / $item_row_tablet_extra) . ' col-lg-' . (12 / $item_row);
                    }
                    $query_service->the_post(); ?>
                    <div class="<?php echo esc_attr($col_classes) ?>">
                        <?php
                        $post_id = get_the_ID();
                        $post_translated = TravelHelper::post_translated($post_id);
                        $thumbnail_id = get_post_thumbnail_id($post_translated);

                        ?>
                        <div class="services-item grid item-elementor" itemscope>
                            <div class="item service-border">
                                <div class="featured-image">
                                    <a href="<?php echo get_the_permalink(); ?>">
                                        <img itemprop="photo" src="<?php echo wp_get_attachment_image_url($thumbnail_id, array(450, 300)); ?>" alt="<?php echo get_the_title(); ?>" class="img-fluid st-hover-grow" />
                                    </a>
                                </div>
                                <div class="content-item">
                                    <?php
                                    $category_detail = get_the_category(get_the_ID());
                                    if (!empty($category_detail)) {
                                        $v = $category_detail[0];
                                        ?>
                                        <div class="cate">
                                            <ul>
                                                <li><a href="<?php echo get_category_link($v->term_id) ?>"> <?php echo esc_html($v->name) ?></a></li>
                                            </ul>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <h3 class="title" itemprop="name">
                                        <a href="<?php echo get_the_permalink(); ?>" class="st-link c-main"><?php echo get_the_title($post_translated) ?></a>
                                    </h3>

                                    <div class="excerpt-wrapper d-flex align-items-end justify-content-between">
                                        <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                    </div>
                                    <div class="readmore">
                                        <a href="<?php echo get_the_permalink(); ?>"><?php echo esc_html__('Read more', 'traveler-layout-essential') ?><svg width="19" height="16" viewBox="0 0 19 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.3997 1.39972C11.6926 1.10683 12.1674 1.10683 12.4603 1.39972L18.5303 7.46972C18.671 7.61038 18.75 7.80114 18.75 8.00005C18.75 8.19897 18.671 8.38973 18.5303 8.53038L12.4603 14.6004C12.1674 14.8933 11.6926 14.8933 11.3997 14.6004C11.1068 14.3075 11.1068 13.8326 11.3997 13.5397L16.1893 8.75005H1C0.585786 8.75005 0.25 8.41427 0.25 8.00005C0.25 7.58584 0.585786 7.25005 1 7.25005H16.1893L11.3997 2.46038C11.1068 2.16749 11.1068 1.69262 11.3997 1.39972Z" fill="#A28458" />
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.2229 1.22295C11.6134 0.832423 12.2466 0.832423 12.6371 1.22295L18.7071 7.29295C18.8946 7.48048 19 7.73484 19 8.00005C19 8.26527 18.8946 8.51962 18.7071 8.70716L12.6371 14.7772C12.2466 15.1677 11.6134 15.1677 11.2229 14.7772C10.8324 14.3866 10.8324 13.7535 11.2229 13.3629L15.5858 9.00005H1C0.447715 9.00005 0 8.55234 0 8.00005C0 7.44777 0.447715 7.00005 1 7.00005H15.5858L11.2229 2.63716C10.8324 2.24664 10.8324 1.61347 11.2229 1.22295ZM12.2836 1.5765C12.0883 1.38124 11.7717 1.38124 11.5764 1.5765C11.3812 1.77176 11.3812 2.08834 11.5764 2.28361L16.3661 7.07328C16.4376 7.14478 16.459 7.25231 16.4203 7.34572C16.3816 7.43914 16.2905 7.50005 16.1893 7.50005H1C0.723858 7.50005 0.5 7.72391 0.5 8.00005C0.5 8.2762 0.723858 8.50005 1 8.50005H16.1893C16.2905 8.50005 16.3816 8.56096 16.4203 8.65438C16.459 8.7478 16.4376 8.85533 16.3661 8.92683L11.5764 13.7165C11.3812 13.9118 11.3812 14.2283 11.5764 14.4236C11.7717 14.6189 12.0883 14.6189 12.2836 14.4236L18.3536 8.35361C18.4473 8.25984 18.5 8.13266 18.5 8.00005C18.5 7.86745 18.4473 7.74027 18.3536 7.6465L12.2836 1.5765Z" fill="#A28458" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
<?php }
?>
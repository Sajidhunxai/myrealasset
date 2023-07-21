<?php
$posts_per_page = $array_args["posts_per_page"];
$order = $array_args["order"];
$orderby = $array_args["orderby"];
$post_ids = $array_args["post_ids"];

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
?>
<div class="st-blog-list-single">
    <?php while ($query_service->have_posts()) :
        $query_service->the_post();
        $post_id = get_the_ID();
        $post_translated = TravelHelper::post_translated($post_id);
        $thumbnail_id = get_post_thumbnail_id($post_translated);
        ?>
        <div class="blog-list-wrapper">
            <div class="col-12 col-lg-8">
                <?php
                $category_detail = get_the_category(get_the_ID());
                if (!empty($category_detail)) {
                    $v = $category_detail[0];
                    echo '<h2>' . esc_html($v->name) . '</h2>';
                }

                ?>

                <h3>
                    <a href="<?php echo get_the_permalink(); ?>" class="st-link c-main"><?php echo get_the_title($post_translated) ?></a>
                </h3>
                <div class="excerpt-wrapper d-flex align-items-end justify-content-between">
                    <?php echo wp_trim_words(get_the_excerpt(), 40); ?>
                </div>
                <a class="button" href="<?php echo get_the_permalink(); ?>"><span><?php echo __("Read more", "traveler-layout-essential") ?></span></a>
            </div>
            <div class="col-12 col-lg-4">
                <div class="featured-image">
                    <a href="<?php echo get_the_permalink(); ?>">
                        <img itemprop="photo" src="<?php echo wp_get_attachment_image_url($thumbnail_id, array(450, 300)); ?>" alt="<?php echo get_the_title(); ?>" class="img-fluid" />
                    </a>
                </div>
            </div>
        </div>
        <?php
    endwhile;
    wp_reset_postdata();
    ?>
</div>
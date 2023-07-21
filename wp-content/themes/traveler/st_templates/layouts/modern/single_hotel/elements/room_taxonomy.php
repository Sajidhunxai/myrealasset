<?php
$tax = st()->get_option('st_room_taxonomy', '');
$terms = get_terms([
    'taxonomy' => $tax,
    'hide_empty' => true,
    'order' => 'asc',
]);
$list_room_page = st()->get_option('st_hotel_alone_list_of_rooms_page');

if (!is_wp_error($terms) && !empty($terms)) {
    echo '<div class="row st-room-tax-item">';
    foreach ($terms as $item) {
        $term_id = $item->term_id;
        $term_name = $item->name;
        $img_id = get_term_meta($term_id, 'term_image_id', true);
        $img_url = wp_get_attachment_image_url($img_id, [570, 300]);
        $link = add_query_arg('term_name', $item->slug, get_the_permalink($list_room_page));

        ?>
        <div class="col-sm-6 room-item">
            <a href="<?php echo esc_url($link) ?>" >
                <div class="item-thumb">
                    <img src="<?php echo esc_url($img_url) ?>" alt="<?php esc_html__('image', 'traveler') ?>">
                </div>

            <div class="item-name">
                <span class="name">
                    <?php echo esc_html($term_name) ?>
                </span>
                <span class="arrow">
                    <img src="<?php echo get_template_directory_uri()?>/v2/images/Arrow_room.svg" alt="arrow">
                </span>
            </div>
            </a>
        </div>
    <?php }
    echo '</div>';
}


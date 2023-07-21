<?php
if ($number < 0) {
    $number = 'all';
}
$args = array(
    'taxonomy' => 'st_tour_type',
    'hide_empty' => false

);
if (!empty($category_ids)) {
    $args['include'] = explode(',', $category_ids);
    $args['orderby'] = 'include' ;
}else{
    $args['number'] = $number;
}
$query = get_terms($args);
$result_page = '';
$result_page = get_the_permalink(st_get_page_search_result('st_tours'));
?>
<?php if($style == 'layout1'){ ?>
<div class="category-slider-wrapper">
    <div class="category-slider owl-carousel ">
        <?php foreach ($query as $value) {

            $tour_style_id = $value->term_id;

            $result_page = add_query_arg(['taxonomy[st_tour_type]' => $tour_style_id], $result_page);
            $imageID = get_term_meta($value->term_id, 'st_tour_type_image',true);
            $imageUrl = wp_get_attachment_image_url($imageID, array(540,740));
            ?>
            <div class="category-item">
                <div class="thumb">
                    <?php if (!empty($imageUrl)) { ?>
                        <a href="<?php echo esc_url($result_page) ?>"><img src="<?php echo esc_url($imageUrl) ?> " alt="<?php echo get_bloginfo('description') ?>"></a>
                    <?php }else{ ?>
                        <a href="<?php echo esc_url($result_page) ?>"><img src="<?php echo get_template_directory_uri() ?>/img/no-image.png" alt="<?php echo get_bloginfo('description') ?>"></a>
                    <?php } ?>
                    <span class="st-title"><?php echo esc_html($value->name) ?></span>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php }elseif ($style == 'layout2'){ ?>
    <div class="category-slider-wrapper">
        <div class="category-slider owl-carousel style-2 ">
            <?php foreach ($query as $value) {

                $tour_style_id = $value->term_id;

                $result_page = add_query_arg(['taxonomy[st_tour_type]' => $tour_style_id], $result_page);
                $imageID = get_term_meta($value->term_id, 'st_tour_type_image',true);
                $imageUrl = wp_get_attachment_image_url($imageID, array(540,740));

                ?>
                <div class="category-item">
                    <div class="thumb">
                        <?php if (!empty($imageUrl)) { ?>
                            <a href="<?php echo esc_url($result_page) ?>"><img src="<?php echo esc_url($imageUrl) ?> " alt="<?php echo get_bloginfo('description') ?>"><span class="st-title"><?php echo esc_html($value->name) ?></span></a>
                        <?php }else{ ?>
                            <a href="<?php echo esc_url($result_page) ?>"><img src="<?php echo get_template_directory_uri() ?>/img/no-image.png" alt="<?php echo get_bloginfo('description') ?>"><span class="st-title"><?php echo esc_html($value->name) ?></span></a>
                        <?php } ?>
                        
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<?php
$inner_style = '';
if (is_single() || is_page()) {
    $thumb_id = get_post_thumbnail_id(get_the_ID());
    if (!empty($thumb_id)) {
        $img = wp_get_attachment_image_url($thumb_id, 'full');
        $inner_style = Assets::build_css("background-image: url(" . esc_url($img) . ") !important;");
    }
}
if (is_archive() || is_tag() || is_search() || is_home()) {
    $img = st()->get_option('header_blog_image', '');
    if (!empty($img))
        $inner_style = Assets::build_css("background-image: url(" . esc_url($img) . ") !important;");
}
?>
<div class="banner banner--solo <?php echo esc_attr($inner_style); ?>">
    <div class="container">
        <div class="banner-headding">
            <?php if (is_page() || is_home()) { ?>
                <p class="banner-title-solo">
                    <?php echo (is_home()) ? get_the_title(get_option('page_for_posts', true)) : get_the_title(); ?>
                </p>
                <?php $content = (is_home()) ? get_post_meta(get_option('page_for_posts', true), 'page_header_text', true) : get_post_meta(get_the_ID(), 'page_header_text', true); ?>
                <?php if ($content) { ?>
                    <h3 class="banner-content-solo">
                        <?php echo esc_html($content); ?>
                    </h3>
                <?php } ?>
            <?php } ?>
        </div>

    </div>
</div>

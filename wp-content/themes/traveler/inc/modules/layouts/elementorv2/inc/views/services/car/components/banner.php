<?php
$inner_style = '';
$thumb_id = get_post_thumbnail_id(get_the_ID());
if (!empty($thumb_id)) {
    $img = wp_get_attachment_image_url($thumb_id, 'full');
    $inner_style = Assets::build_css("background-image: url(" . esc_url($img) . ") !important;");
}
?>
<div class="banner <?php echo esc_attr($inner_style) ?>">
    <div class="container">
        <h1 class="tag_h1 d-none d-lg-none"><?php echo get_the_title(); ?></h1>
        <div class="row">
            <div class="col-12">
                <div class="st-banner-search-form style_2">
                    <div class="st-search-form-el st-border-radius">
                        <div class="st-search-el search-form-v2">
                            <?php echo stt_elementorv2()->loadView('services/car/search-form/wrapper'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
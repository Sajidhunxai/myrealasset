<?php
$gallery = get_post_meta(get_the_ID(), 'gallery', true);
$gallery_array = explode(',', $gallery);
if (!empty($gallery_array)) { ?>
    <div class="st-gallery-car" data-width="100%"
            data-nav="thumbs" data-allowfullscreen="true">
        <div class="fotorama" data-auto="true">
            <?php
            foreach ($gallery_array as $value) {
                ?>
                <img src="<?php echo wp_get_attachment_image_url($value, [900, 600]) ?>" alt="<?php echo get_the_title();?>">
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}
?>
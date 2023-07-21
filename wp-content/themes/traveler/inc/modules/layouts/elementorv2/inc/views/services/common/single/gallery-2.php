<?php 
$gallery = get_post_meta(get_the_ID(), 'gallery', true);
$gallery_array = explode(',', $gallery);

if(!empty($gallery_array) && is_array($gallery_array)){ ?>
    <div class="st-gallery st-border-radius style-slider">
        <div class="owl-carousel">
        <?php
        foreach ($gallery_array as $key=>$value) { ?>
            <img class="item-gallery" src="<?php echo wp_get_attachment_image_url($value, 'full') ?>" alt="<?php echo get_the_title();?>">
        <?php } ?>
        </div>
        <div class="count"></div>
    </div>
<?php }?>

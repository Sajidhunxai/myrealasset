<?php 
$gallery = get_post_meta(get_the_ID(), 'gallery', true);
$gallery_array = explode(',', $gallery);

if(!empty($gallery_array) && is_array($gallery_array)){ ?>
    <div class="st-gallery st-border-radius style-masonry">
        <div class="st-list-item-gallery">
            <?php if(!empty($style) && $style ==='grid'){ ?>
                <?php
                    foreach ($gallery_array as $key=>$value) { 
                        if($key < 5){ ?>
                            <a href="<?php echo wp_get_attachment_image_url($value, 'full') ?>" data-elementor-open-lightbox="no" class="item-gallery"><img src="<?php echo wp_get_attachment_image_url($value, 'full') ?>" alt="<?php echo get_the_title();?>"></a>
                        <?php } else { ?>
                            <a  href="<?php echo wp_get_attachment_image_url($value, 'full') ?>" class="item-gallery item-hide"><img src="<?php echo wp_get_attachment_image_url($value, 'full') ?>" alt="<?php echo get_the_title();?>"></a>
                        <?php }
                    }
                ?>
            <?php  }?>
        </div>
        <div class="shares dropdown">
            <div class="btn-group">
                <?php
                $video_url = get_post_meta(get_the_ID(), 'video', true);
                if (!empty($video_url)) {
                    ?>
                    <a href="<?php echo esc_url($video_url); ?>"
                        class="btn btn-transparent has-icon radius st-video-popup"><span class="stt-icon stt-icon-play"></span></a>
                    <?php
                } ?>
                <a href="#st-gallery-popup" class="btn btn-transparent has-icon radius st-gallery-popup"><span class="stt-icon stt-icon-category"></span><?php echo esc_html__('All photo','traveler');?></a>
                <div id="st-gallery-popup" class="hidden">
                    <?php
                    foreach ($gallery_array as $k => $v) {
                        if(!empty($v)){
                            echo '<a href="' . wp_get_attachment_image_url($v, 'full') . '">'.__('Gallery', 'traveler').'</a>';
                        }

                        }
                    ?>
                </div>
            </div>
            
        </div>
        
    </div>
<?php }?>

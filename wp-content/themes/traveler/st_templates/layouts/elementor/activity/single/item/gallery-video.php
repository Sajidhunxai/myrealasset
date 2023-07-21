<?php 
$gallery = get_post_meta($post_id, 'gallery', true);
$gallery_array = explode(',', $gallery); ?>
?>
<div class="st-gallery">
    <div class="shares dropdown">
        <a href="#" class="share-item social-share">
            <?php echo TravelHelper::getNewIcon( 'ico_share', '', '20px', '20px' ) ?>
        </a>
        <ul class="share-wrapper">
            <li><a class="facebook"
                    href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                    target="_blank" rel="noopener" original-title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
            <li><a class="twitter"
                    href="https://twitter.com/share?url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                    target="_blank" rel="noopener" original-title="Twitter"><i class="fab fa-twitter"></i></a></li>
            <li><a class="no-open pinterest"
                href="http://pinterest.com/pin/create/bookmarklet/?url=<?php the_permalink() ?>&is_video=false&description=<?php the_title() ?>&media=<?php echo get_the_post_thumbnail_url(get_the_ID())?>"
                    target="_blank" rel="noopener" original-title="Pinterest"><i class="fab fa-pinterest-p"></i></a></li>
            <li><a class="linkedin"
                    href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                    target="_blank" rel="noopener" original-title="LinkedIn"><i class="fab fa-linkedin-in"></i></a></li>
        </ul>
        <?php echo st()->load_template( 'layouts/modern/hotel/loop/wishlist' ); ?>
    </div>
    <div class="btn-group">
        <?php $video_url = get_post_meta( get_the_ID(), 'video', true );
            if ( !empty( $video_url ) ) {
                ?>
                <a href="<?php echo esc_url( $video_url ); ?>"
                    class="btn btn-transparent has-icon radius st-video-popup"><?php echo TravelHelper::getNewIcon( 'video-player', '#FFFFFF', '18px', '18px' ) ?><?php echo __( 'Video', 'traveler' ) ?></a>
            <?php } ?>
        <?php if(!empty($gallery)){?>
            <a href="#st-gallery-popup"
            class="btn btn-transparent has-icon radius st-gallery-popup"><?php echo TravelHelper::getNewIcon( 'camera-retro', '#FFFFFF', '18px', '18px' ) ?><?php echo __( 'More Photos', 'traveler' ) ?></a>
        <?php }?>
        <div id="st-gallery-popup" class="hidden">
            <?php
                if ( !empty( $gallery_array ) ) {
                    foreach ( $gallery_array as $k => $v ) {
                        echo '<a href="' . wp_get_attachment_image_url( $v, 'full' ) . '">Image</a>';
                    }
                }
            ?>
        </div>
    </div>
</div>
<?php
    if ( !empty( $gallery_array ) ) { ?>
        <div class="st-gallery" data-width="100%"
                data-nav="thumbs" data-allowfullscreen="true">
            <div class="fotorama" data-auto="false">
                <?php
                    foreach ( $gallery_array as $value ) {
                        ?>
                        <img src="<?php echo wp_get_attachment_image_url( $value, [ 870, 555 ] ) ?>" alt="<?php echo get_the_title();?>">
                        <?php
                    }
                ?>
            </div>
            <div class="shares dropdown">
                <a href="#" class="share-item social-share">
                    <i class="fas fa-share"></i>
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
                <?php
                $video_url = get_post_meta(get_the_ID(), 'video', true);
                if (!empty($video_url)) {
                    ?>
                    <a href="<?php echo esc_url($video_url); ?>"
                        class="st-video-popup share-item"><i class="fab fa-youtube"></i></a>
                    <?php
                } ?>
                <?php echo st()->load_template('layouts/elementor/hotel/elements/wishlist'); ?>
            </div>
        </div>
        <?php
    }
?>
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
                    <?php echo TravelHelper::getNewIcon( 'ico_share', '', '20px', '20px' ) ?>
                </a>
                <ul class="share-wrapper">
                    <li><a class="facebook"
                            href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                            target="_blank" rel="noopener" original-title="Facebook"><i
                                    class="fa fa-facebook fa-lg"></i></a></li>
                    <li><a class="twitter"
                            href="https://twitter.com/share?url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                            target="_blank" rel="noopener" original-title="Twitter"><i
                                    class="fa fa-twitter fa-lg"></i></a></li>
                    <li><a class="no-open pinterest"
                        href="http://pinterest.com/pin/create/bookmarklet/?url=<?php the_permalink() ?>&is_video=false&description=<?php the_title() ?>&media=<?php echo get_the_post_thumbnail_url(get_the_ID())?>"
                            target="_blank" rel="noopener" original-title="Pinterest"><i
                                    class="fa fa-pinterest fa-lg"></i></a></li>
                    <li><a class="linkedin"
                            href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                            target="_blank" rel="noopener" original-title="LinkedIn"><i
                                    class="fa fa-linkedin fa-lg"></i></a></li>
                </ul>
                <?php echo st()->load_template( 'layouts/modern/hotel/loop/wishlist' ); ?>
            </div>
        </div>
        <?php
    }
?>
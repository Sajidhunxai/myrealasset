<?php
$post_id = get_the_ID();
$post_translated = TravelHelper::post_translated($post_id);
$thumbnail_id = get_post_thumbnail_id($post_translated);

?>
<div class="services-item grid item-elementor" itemscope>
    <div class="item service-border st-border-radius">
        <div class="featured-image">
            <a href="<?php echo get_the_permalink(); ?>">
                <img itemprop="photo" src="<?php echo wp_get_attachment_image_url($thumbnail_id, array(450, 300)); ?>"
                     alt="<?php echo get_the_title(); ?>" class="img-fluid st-hover-grow"/>
            </a>
        </div>
        <div class="content-item">
                <?php
                $category_detail = get_the_category(get_the_ID());
                if (!empty($category_detail)) {
                    ?>
                    <div class="cate category-color">
                        <ul>
                            <?php
                            $v = $category_detail[0];
                            $color = get_term_meta($v->term_id, '_category_color', true);
                            $bg_rgba = st_hex2rgb_new($color , 0.06);
                            $text_rgba = st_hex2rgb_new($color , 1);
                            $inline_css = '';
                            if (!empty($color)) {
                                $inline_css = 'style="background:' . esc_attr($bg_rgba) . '"';
                            }
                            echo '<li ' . ($inline_css) . '><a href="' . get_category_link($v->term_id) . '" style="color:'.esc_attr($text_rgba).'"><span style="color:'.esc_attr($text_rgba).'"></span>' . esc_html($v->name) . '</a></li>';
                            ?>
                        </ul>
                    </div>
                    <?php
                }
            ?>
            <h3 class="title" itemprop="name">
                <a href="<?php echo get_the_permalink(); ?>"
                   class="c-main"><?php echo get_the_title($post_translated) ?></a>
            </h3>
            
            <div class="excerpt-wrapper d-flex align-items-end justify-content-between">
                   <?php echo wp_trim_words(get_the_excerpt(), 10);?>
            </div>
        </div>
    </div>
</div>


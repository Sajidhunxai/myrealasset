<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Loop content blog
 *
 * Created by ShineTheme
 *
 */
?>
<div <?php post_class('article-style3 post') ?> >
    <div class="header">
        <?php if (get_post_format()): ?>
            <header class="post-header">
                <?php echo st()->load_template('layouts/modern/blog/single/loop/loop', get_post_format()); ?>
            </header>
        <?php elseif (has_post_thumbnail() and get_the_post_thumbnail()): ?>
            <header class="post-header">
                <?php echo st()->load_template('layouts/modern/blog/content', 'image'); ?>
            </header>
        <?php endif; ?>
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
                        echo '<li ' . ($inline_css) . '><a href="' . get_category_link($v->term_id) . '" style="color:'.esc_attr($text_rgba).'">' . esc_html($v->name) . '</a></li>';
                        ?>
                    </ul>
                </div>
                <?php
            }
        ?>
    </div>
    <div class="post-inner">
        <h2 class="post-title"><a class="text-darken" href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
        <div class="post-desciption">
            <?php the_excerpt() ?>
        </div>
        <?php echo st()->load_template('layouts/modern/blog/content', 'meta'); ?>
    </div>
</div>

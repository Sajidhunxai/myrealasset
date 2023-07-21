<?php

/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * index.php
 *
 * Created by ShineTheme
 *
 */
if(New_Layout_Helper::isNewLayout()){
    get_header();
    ?>
    <div id="st-content-wrapper" class="search-result-page st-page-default">
        <div class="banner bg-default-banner">
            <div class="container">
                <h1 class="page-title"><?php esc_html_e('Blog', 'traveler') ?></h1>
            </div>
        </div>
        
        <div class="container">
            <div class="st-blog">
                <div class="row">
                    <?php
                    $sidebar_pos = apply_filters('st_blog_sidebar', 'right');
                    if ($sidebar_pos == "left") {
                        get_sidebar('blog');
                    }
                    ?>
                    <div class="<?php echo ($sidebar_pos == 'no') ? 'col-sm-12 col-xs-12' : 'col-sm-9 col-xs-12'; ?> ">
                        <div class="content">
                            <?php
                            if (have_posts()):
                                while (have_posts()) {
                                    the_post();
                                    echo st()->load_template('layouts/modern/blog/content');
                                }
                                TravelHelper::paging();
                            else:
                                echo st()->load_template('layouts/modern/blog/content', 'none');
                            endif;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                    <?php
                    $sidebar_pos = apply_filters('st_blog_sidebar', 'right');
                    if ($sidebar_pos == "right") {
                        get_sidebar('blog');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
    get_footer();
    return;
}
get_header();
?>
<div class="container">
    <h1 class="page-title"><?php esc_html_e('Blog', 'traveler') ?></h1>
</div>
<div class="container">
    <div class="row">
        <?php
        $sidebar_pos = apply_filters('st_blog_sidebar', 'right');
        if ($sidebar_pos == "left") {
            get_sidebar('blog');
        }
        ?>
        <div class="<?php echo apply_filters('st_blog_sidebar', 'right') == 'no' ? 'col-sm-12' : 'col-sm-9'; ?>">
            <?php
            if (have_posts()):
                while (have_posts()) {
                    the_post();
                    echo st()->load_template('blog/content-loop');
                }
                TravelHelper::paging();
            else:
                echo st()->load_template('blog/content-none');
            endif;
            ?>
        </div>
        <?php
        $sidebar_pos = apply_filters('st_blog_sidebar', 'right');
        if ($sidebar_pos == "right") {
            get_sidebar('blog');
        }
        ?>
    </div>
</div>
<?php get_footer(); ?>
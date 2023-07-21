<?php
get_header();
?>
<div id="st-content-wrapper" class="search-result-page">
    <?php echo st()->load_template('layouts/modern/hotel/elements/banner'); ?>
    <?php st_breadcrumbs_new() ?>
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
                        $args = array(
                            'post_type' => 'post',
                            'paged' => get_query_var('paged')
                        );
                        $query = new WP_Query($args);
                        if ($query->have_posts()):
                            echo '<div class="blog-wrapper">';
                            while ($query->have_posts()) {
                                $query->the_post();
                                echo st()->load_template('layouts/modern/blog/content');
                            }
                            echo '</div><div class="pagination">';
                            TravelHelper::paging($query, false);
                            echo '</div>';
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

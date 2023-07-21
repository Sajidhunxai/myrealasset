<?php
get_header();
$postsPerPage = get_option('posts_per_page', 9);

?>
<div id="st-content-wrapper" class="search-result-page st-blog-solo--wrapper">
    <div class="st-blog--banner">
        <?php echo st()->load_template('layouts/modern/blog/banner'); ?>
        <?php st_breadcrumbs_new() ?>
    </div>
    <div class="container">
        <div class="st-blog st-blog--search">
            <div class="search-form-top">
                <?php echo st()->load_template('layouts/modern/blog/search-form'); ?>
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12">
                    <div class="content">
                        <?php
                        $args = array(
                            'post_type' => 'post',
                            'post_status' => 'publish',
                            'paged' => get_query_var('paged')
                        );
                        $paged = intval(STInput::get('ppp', 1));
                        $postsPerPage *= $paged;
                        $args['posts_per_page'] = $postsPerPage;
                        $paged++;
                        $postTitle = STInput::get('post_title');
                        if ($postTitle) {
                            $args['s'] = $postTitle;
                        }
                        $cat = STInput::get('cat');
                        if ($cat) {
                            $args['cat'] = $cat;
                        }
                        $query = new WP_Query($args);
                        $foundPosts = $query->found_posts;
                        if ($query->have_posts()):
                            echo '<div class="blog-wrapper row">';
                            while ($query->have_posts()) {
                                $query->the_post();
                                echo st()->load_template('layouts/modern/blog/content', 2);
                            }
                            echo '</div>';
                        else:
                            echo st()->load_template('layouts/modern/blog/content', 'none');
                        endif;
                        wp_reset_postdata();
                        ?>
                        <input type="hidden" value="<?php echo esc_html($paged); ?>" id="solo_load_more_blog"/>
                    </div>
                </div>
            </div>
            <?php if ($foundPosts > $postsPerPage) { ?>
                <div class="solo-load-more-blog" data-url="<?php echo get_permalink(get_option('page_for_posts')); ?>">
                    <button><?php echo esc_html__('LOAD MORE', 'traveler') ?></button>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php
get_footer();

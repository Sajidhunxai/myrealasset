<?php
while (have_posts()):
    the_post();
    ?>
    <div id="st-content-wrapper" class="st-single-blog--solo">
        <?php
        $blog_image = get_the_post_thumbnail_url(get_the_ID());
        if (empty($blog_image)) {
            $blog_image = st()->get_option('header_blog_image');
        }
        ?>
        <div class="single-blog--heading" style="background-image: url(<?php echo esc_attr($blog_image); ?>)">
            <div class="st-title--bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-xs-12 col-sm-12 col-md-8 blog-tablet">
                            <div class="post-info">
                                <?php
                                $category_detail = get_the_category(get_the_ID());
                                $v = $category_detail[0];
                                $color = get_term_meta($v->term_id, '_category_color', true);
                                $inline_css = '';
                                if (!empty($color)) {
                                    $inline_css = 'style="color: #' . esc_attr($color) . '"';
                                }
                                echo '<a ' . $inline_css . ' href="' . get_category_link($v->term_id) . '">' . esc_html($v->name) . '</a>';
                                ?>
                                <?php echo get_the_date(); ?>
                                <h2 class="title"><?php the_title() ?></h2>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="st-blog">
            <div class="blog-content content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 blog-content--center">
                            <div class="article article--detail-solo">
                                <div class="st-title--bg">
                                    <div class="post-info">
                                        <?php
                                        $category_detail = get_the_category(get_the_ID());
                                        $v = $category_detail[0];
                                        $color = get_term_meta($v->term_id, '_category_color', true);
                                        $inline_css = '';
                                        if (!empty($color)) {
                                            $inline_css = 'style="color: #' . esc_attr($color) . '"';
                                        }
                                        echo '<a ' . $inline_css . ' href="' . get_category_link($v->term_id) . '">' . esc_html($v->name) . '</a>';
                                        ?>
                                        <?php echo get_the_date(); ?>
                                        <h2 class="title"><?php the_title() ?></h2>
                                    </div>
                                </div>
                                <div class="post-content"><?php the_content() ?></div>
                                <div class="st-flex space-between">
                                    <div class="share">
                                        <?php echo __('Share', 'traveler'); ?>
                                        <div class="share-icon">
                                            <a class="facebook share-item"
                                               href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                                               target="_blank" rel="noopener" original-title="Facebook"><i
                                                    class="fa fa-facebook fa-lg"></i></a>
                                            <a class="twitter share-item"
                                               href="https://twitter.com/share?url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                                               target="_blank" rel="noopener" original-title="Twitter"><i
                                                    class="fa fa-twitter fa-lg"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="comment-wrapper">
                                <h2 class="title"><?php comments_number( __( 'Comment (0)', 'traveler' ), __( 'Comment (1)', 'traveler' ), __( 'Comments (%)', 'traveler' ) ); ?></h2>
                                <ol class="comment-list">
                                    <?php
                                        $comment_per_page = (int)get_option( 'comments_per_page', 10 );
                                        $paged            = ( get_query_var( 'cpage' ) ) ? get_query_var( 'cpage' ) : 1;

                                        $offset         = ( $paged - 1 ) * $comment_per_page;
                                        $args           = [
                                            'number'  => $comment_per_page,
                                            'offset'  => $offset,
                                            'post_id' => get_the_ID(),
                                            'status' => ['approve']
                                        ];
                                        global $sitepress;
                                        remove_filter( 'comments_clauses', array( $sitepress, 'comments_clauses' ), 10, 2 );
                                        $comments_query = new WP_Comment_Query;
                                        $comments       = $comments_query->query( $args );

                                        wp_list_comments( [
                                            'style'       => 'ol',
                                            'short_ping'  => true,
                                            'avatar_size' => 50,
                                            'page'        => $paged,
                                            'per_page'    => $comment_per_page,
                                            'callback'    => [ 'TravelHelper', 'comments_list_new' ]
                                        ], $comments );
                                        add_filter( 'comments_clauses', array( $sitepress, 'comments_clauses' ), 10, 2 );
                                    ?>
                                </ol>
                                <?php
                                    
                                        wp_enqueue_script( 'comment-reply' )
                                        ?>
                                        <div id="write-comment">
                                            <?php
                                                TravelHelper::comment_form_post();
                                            ?>
                                        </div>
                                        <?php
                                    
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="st-blog-solo--wrapper">
                <div class="st-blog--search">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-xs-12">
                                <div class="single-blog--title">
                                    <p><?php esc_html_e('Lastest News', 'traveler') ?></p>
                                    <h3><?php esc_html_e('Learn More About Tours', 'traveler') ?></h3>
                                </div>
                                <div class="content">
                                    <?php
                                    $args = array(
                                        'post_type' => 'post',
                                        'posts_per_page' => 3,
                                        'post__not_in' => [get_the_ID()],
                                        'order' => 'desc',
                                        'post_status' => 'publish'
                                    );
                                    $query = new WP_Query($args);
                                    if ($query->have_posts()) {
                                        echo '<div class="blog-wrapper col-sm-12 col-xs-12">';
                                        while ($query->have_posts()) {
                                            $query->the_post();
                                            echo st()->load_template('layouts/modern/blog/content', 2);
                                        }
                                        echo '</div>';
                                    }
                                    wp_reset_postdata();
                                    ?>
                                </div>
                                <?php
                                    if(!empty($category_detail[0])){ ?>
                                        <div class="st-blog-btn">
                                            <a href="<?php echo esc_url(get_term_link($category_detail[0]->term_id)); ?>"><?php esc_html_e('READ MORE ARTICLES', 'traveler') ?></a>
                                        </div>
                                    <?php }
                                ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>

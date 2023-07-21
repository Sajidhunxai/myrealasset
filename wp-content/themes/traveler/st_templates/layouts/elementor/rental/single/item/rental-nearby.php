<div class="container">
    <?php
    $search_tax_advance = st()->get_option( 'attribute_search_form_rental', 'rental_types' );
    $terms_posts = wp_get_post_terms(get_the_ID(),$search_tax_advance);
    $arr_id_term_post = array();
    if(is_array($terms_posts) && !empty($terms_posts)){
        foreach($terms_posts as $term_post){
            $arr_id_term_post[] = $term_post->term_id;
        }
    }
    
    $args = [
        'posts_per_page' => 4,
        'post_type' => 'st_rental',
        'post_author' => get_post_field('post_author', get_the_ID()),
        'post__not_in' => [$post_id],
        'orderby' => 'rand',
        'tax_query' => array(
            'taxonomy' => $search_tax_advance,
            'terms' => $arr_id_term_post,
            'field' => 'term_id',
            'operator' => 'IN'
        ),
    ];
    global $post;
    $old_post = $post;
    $query = new WP_Query($args);
    if ($query->have_posts()):
        ?>
        <div class="st-hr large"></div>
        <h2 class="st-heading st-related text-center"><?php echo esc_html__('You might also like', 'traveler') ?></h2>
        <div class="row service-list-wrapper">
            <?php
            while ($query->have_posts()): $query->the_post();
            echo st()->load_template('layouts/elementor/rental/loop/normal-grid', '' , array('item_row'=> 4));
            endwhile;
            ?>
        </div>
    <?php
    endif;
    wp_reset_postdata();
    $post = $old_post;
    ?>
</div>    
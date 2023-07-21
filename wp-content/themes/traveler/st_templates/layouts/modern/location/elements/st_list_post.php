<?php extract(shortcode_atts(array(
    'ids_post' => '',
  ), $attr));
$args_post =explode(",",$ids_post);
$args_list = array(
    'post_type' => 'post',
    'post__in' => $args_post,
    'orderby' => 'post__in'
);
$list_query = new WP_Query($args_list);
?>
<div class="location-list-post">
    <div class="list_ccv">
    <?php if($list_query->have_posts()) : while($list_query->have_posts()) : $list_query->the_post();
    $url = get_the_permalink();
    $term_list = wp_get_post_terms( get_the_ID(), 'category', array( 'fields' => 'all' ) );
    ?>
        <div class="row margin-bottom-90">
            <div class="col-md-8 has-matchHeight">
                <div class="item">
                    <div class="st_category">
                        <?php echo esc_attr($term_list[0]->name);?>
                    </div>
                    <div class="title">
                        <h2><?php the_title();?></h2>
                    </div>
                    <div class="content">
                        <p><?php echo New_Layout_Helper::cutStringByNumWord(get_the_excerpt(), 40) ?></p>
                        <div class="st-readmore button-color">
                            <a href="<?php the_permalink();?>" ><?php echo __('Read more','traveler');?></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 has-matchHeight">
                <div class="image_post">
                    <?php if (has_post_thumbnail()) {
                        echo '<a href="' . esc_url($url) . '">';
                        the_post_thumbnail(array(370, 440), array('class' => 'img-responsive'));
                        echo '</a>';
                    }?>
                </div>
            </div>
        </div>
    <?php endwhile;endif;wp_reset_postdata();?>
        
    </div>
</div>
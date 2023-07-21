<?php 
if(isset($settings)) :
    $content = apply_filters('stt_elementor_blog_list_view', '', $settings);

    if($content){
        echo $content;
        return;
    }
endif;
$attrs=array();
if ($layout_style == 'slider') {
    $attrs = [
        'data-slides-per-view' => [
            esc_attr($item_row)
        ],
        'data-pagination' => [
            esc_attr($pagination)
        ],
        'data-navigation' => [
            esc_attr($navigation)
        ],
        'data-auto-play' => [
            esc_attr($auto_play)
        ],
        'data-loop' => [
            esc_attr($loop)
        ],
        'data-delay' => [
            esc_attr($delay)
        ]
    ];
}



$args = [
    'post_type' => 'post',
    'posts_per_page' => $posts_per_page,
    'order' => $order,
    'orderby' => $orderby,
];
if($orderby === 'post__in' && !empty($post_ids)){
    $list_ids = ST_Elementor::st_explode_select2($post_ids);
    $args['post__in'] = array_keys($list_ids);
}
$item_row_tablet = !empty($item_row_tablet) ? $item_row_tablet : 2;
$item_row_tablet_extra = !empty($item_row_tablet_extra) ? $item_row_tablet_extra : 3;
$query_service = new WP_Query($args);
if ($query_service->have_posts()) {?>
<div class="st-list-service st-sliders <?php echo esc_attr($layout_style . ' style_2'); ?>" <?php echo st_render_html_attributes($attrs); ?> >
    <?php 
    if ($layout_style == 'grid') {?>
        <div class="service-list-wrapper st-blog-list-el">
            <div class="row">
                <?php while ($query_service->have_posts()):
                    $col_classes = 'col-lg-12';
                    if ($item_row) {
                        $col_classes ='col-12 col-sm-'.(12 / $item_row_tablet).' col-md-'.(12 / $item_row_tablet_extra) . ' col-lg-' . (12 / $item_row);
                    }
                    $query_service->the_post();
                    $html = '<div class="' . esc_attr($col_classes) . '">';
                        $html .= stt_elementorv2()->loadView('blog/loop/grid');
                    $html .= '</div>';
                    echo balanceTags($html);
                endwhile; wp_reset_postdata(); ?>
            </div>
        </div>
    <?php } else {?>
        <div class="service-list-wrapper st-blog-list-el swiper-container">
            <div class="swiper-wrapper">
                <?php while ($query_service->have_posts()):
                    $query_service->the_post();
                    $html = '<div class="swiper-slide">';
                    $html .= stt_elementorv2()->loadView('blog/loop/grid');
                    $html .= '</div>';
                    echo balanceTags($html);
                endwhile; wp_reset_postdata(); 
                ?>
            </div>
            <?php if ($pagination == 'on') {?>
                <div class="swiper-pagination"></div>
            <?php }?>
        </div>
        <?php 
        if ($navigation == 'on') {?>
            <div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"></span></div><div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"></span></div>
        <?php }
        ?>
    <?php }?>
</div>    
<?php }
?>
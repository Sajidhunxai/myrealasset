<?php 
if(isset($settings)) :
    $content = apply_filters('stt_elementor_testimonial_view', '', $settings);

    if($content){
        echo $content;
        return;
    }
endif;
$attrs = [];
$array_slider = array('slider','slider-2');
if(in_array($st_style_testimonial,$array_slider)){
    $attrs = [
        'data-effect' => [
            esc_attr($effect_style)
        ],
        'data-slides-per-view' => [
            esc_attr($slides_per_view)
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

$class_col = $row_class = $html = '';
$item_in_row = $slides_per_view;
if(!in_array($st_style_testimonial,$array_slider)){
    if($item_in_row == 2){
        $class_col = 'col-12 col-sm-6 col-md-6';
    } elseif ($item_in_row == 3){
        $class_col = 'col-12 col-sm-4 col-md-4';
    } elseif ($item_in_row == 4){
        $class_col = 'col-12 col-sm-3 col-md-3';
    }
} else {
    $class_col = 'swiper-slide';
}

if(in_array($st_style_testimonial,$array_slider)){
    $row_class = ' swiper-container';
} else {
    $row_class = ' row';
}

if(!empty($list_testimonial)){ ?>
    <div class="st-testimonial"
        <?php echo st_render_html_attributes($attrs);?>
        >
        
        <div class="testimonial-wrapper <?php echo esc_attr($row_class);?>">
            <?php  if(in_array($st_style_testimonial,$array_slider)){ ?>
                <div class="swiper-wrapper">
            <?php } ?>
            <?php 
                foreach($list_testimonial as $item_tes){ ?>
                    <div class="item-testimonial st-style-<?php echo esc_attr($st_style_testimonial);?> <?php echo esc_attr($class_col); ?>">
                        <?php 
                            if($st_style_testimonial === 'slider-2'){ ?>
                                <div class="item">
                                    <div class="text-center head-tesimonial">
                                        <?php
                                        if (!empty($item_tes["st_avatar_testimonial"]['url']) ) {
                                            ?>
                                            <img class="st-avatar" src="<?php echo esc_url($item_tes["st_avatar_testimonial"]['url']); ?>" alt="<?php echo esc_attr($item_tes["name_testimonial"]); ?>">
                                        <?php }
                                        ?>
                                    </div>
                                    <p class="text-center st-content">
                                        <?php echo esc_html($item_tes["content_testimonial"]);?>
                                    </p>
                                    <div class="text-center author-meta">
                                        <h4><?php echo esc_html($item_tes["name_testimonial"]);?></h4>
                                        <?php 
                                            if(intval($item_tes["st_star_testimonial"]) > 0){
                                                for($i=0; $i<intval($item_tes["st_star_testimonial"]) ; $i++){ ?>
                                                    <i class="fa fa-star"></i>
                                                <?php }
                                            }
                                        ?>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="item service-border st-border-radius">
                                    <div class="d-flex align-items-center head-tesimonial">
                                        <?php
                                        if (!empty($item_tes["st_avatar_testimonial"]['url']) ) {
                                            ?>
                                            <img class="st-avatar" src="<?php echo esc_url($item_tes["st_avatar_testimonial"]['url']); ?>" alt="<?php echo esc_attr($item_tes["name_testimonial"]); ?>">
                                        <?php }
                                        ?>
                                        <div class="author-meta">
                                            <h4><?php echo esc_html($item_tes["name_testimonial"]);?></h4>
                                            <?php 
                                                if(intval($item_tes["st_star_testimonial"]) > 0){
                                                    for($i=0; $i<intval($item_tes["st_star_testimonial"]) ; $i++){ ?>
                                                        <i class="fa fa-star"></i>
                                                    <?php }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <p class="st-content">
                                        <?php echo esc_html($item_tes["content_testimonial"]);?>
                                    </p>
                                </div>
                            <?php }
                        
                        ?>
                        
                    </div>
                <?php }
            
            ?>
                
                
            <?php  if(in_array($st_style_testimonial,$array_slider)){ ?>
                </div>
            <?php }
            ?>
        </div>
        <?php  if(in_array($st_style_testimonial,$array_slider)){
            if($pagination == 'on'){
                $html .= '<div class="swiper-pagination"></div>';
            }
            if($navigation == 'on'){
                $html .= '<div class="st-button-prev"><span></span></div><div class="st-button-next"><span></span></div>';
            }
        }
        echo balanceTags($html);
        ?>
    </div>
<?php }?>
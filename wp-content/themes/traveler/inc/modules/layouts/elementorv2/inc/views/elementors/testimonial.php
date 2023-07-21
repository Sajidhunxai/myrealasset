<?php 
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
if(!empty($list_testimonial)){ ?>
<div class="st-testimonial-modern-slider">
    <div class="st-testimonial" <?php echo st_render_html_attributes($attrs); ?>>
        <div class="service-testimonial-wrapper swiper-container"><div class="swiper-wrapper">
            <?php 
            foreach($list_testimonial as $item_tes){ ?>
                <div class="swiper-slide">
                    <div class="item">
                        
                        <?php
                        if (!empty($item_tes["st_avatar_testimonial"]['url']) ) {
                            ?>
                            <div class="head-tesimonial">
                                <img class="st-avatar" src="<?php echo esc_url($item_tes["st_avatar_testimonial"]['url']); ?>" alt="<?php echo esc_attr($item_tes["name_testimonial"]); ?>">
                            </div>
                        <?php }
                        ?>
                        
                        <p class="st-content">
                            <?php echo esc_html($item_tes["content_testimonial"]);?>
                        </p>
                        <div class="author-meta">
                            <?php 
                                if(intval($item_tes["st_star_testimonial"]) > 0){
                                    for($i=0; $i<intval($item_tes["st_star_testimonial"]) ; $i++){ ?>
                                        <i class="review-testimonial stt-icon-star1"></i>
                                    <?php }
                                }
                            ?>
                            <?php 
                                if(!empty($item_tes['name_testimonial'])){ ?>
                                    <div class="name"><?php echo esc_html($item_tes["name_testimonial"]);?></div>
                                <?php }
                            ?>
                            
                            <?php 
                                if(!empty($item_tes['office_testimonial'])){ ?>
                                    <p class="office-testimonial"><?php echo esc_html($item_tes['office_testimonial']);?></p>
                                <?php }
                            ?>
                           
                        </div>
                    </div>
                </div>
            <?php }?>
        </div>                  
    </div>
    <?php if ($pagination == 'on') { ?>
    <div class="swiper-pagination"></div>
    <?php }
    if ($navigation == 'on') { ?>
        <div class="st-button-prev"><span class="stt-icon stt-icon-arrow-left"></span></div><div class="st-button-next"><span class="stt-icon stt-icon-arrow-right"></span></div>
    <?php } ?>
</div>


<?php }?>
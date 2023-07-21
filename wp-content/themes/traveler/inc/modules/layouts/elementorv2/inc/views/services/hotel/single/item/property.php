<div class="item-service-map-new">
    <div class="close-popup-on-map" id="close-popup-on-map"><span class="stt-icon stt-icon-close"></span></div>
    <div class="services-item grid item-elementor">
        <div class="item service-border st-border-radius">
            <div class="featured-image">
                <a href="<?php if(isset($data['url'])) {echo esc_url($data['url']); }?>">
                    <?php
                    if(!empty($data['featured'])){
                        echo '<img src="'. esc_url($data['featured']) .'" alt="'.esc_attr($data['name']).'" class="img-responsive"  style ="object-fit: cover;"/>';
                    }else{
                        echo '<img src="'. get_template_directory_uri() . '/img/no-image.png' .'" alt="Default Thumbnail" class="img-responsive" />';
                    }
                    ?>
                </a>

            </div>
            <div class="content-item">
                <h3 class="title"><a href="#"><?php echo esc_html($data['name']); ?></a></h3>
                <p class="sub-title"><?php echo esc_html($data['description']); ?></p>
            </div>
        </div>
    </div>
    
   
</div>
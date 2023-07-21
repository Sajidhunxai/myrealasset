<div class="item-service-map">
    <div class="thumb">
        <a href="<?php if(!empty($data['url'])) {echo esc_url($data['url']); }?>">
            <?php
            if(!empty($data['featured'])){
                echo '<img src="'. esc_url($data['featured']) .'" alt="'.esc_attr($data['name']).'" class="img-responsive"  style ="
                width: 150px;height:120px;object-fit: cover;"/>';
            }else{
                echo '<img src="'. get_template_directory_uri() . '/img/no-image.png' .'" alt="Default Thumbnail" class="img-responsive" />';
            }
            ?>
        </a>

    </div>
    <div class="content">
        <h4 class="service-title"><a href="#"><?php echo esc_html($data['name']); ?></a></h4>
        <p class="service-location"><?php echo esc_html($data['description']); ?></p>
    </div>
</div>
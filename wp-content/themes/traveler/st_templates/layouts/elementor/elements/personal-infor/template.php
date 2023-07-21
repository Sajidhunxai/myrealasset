<div class="item-personal-infor">
    <div class="thumb">
        <img src="<?php echo esc_url($avatar['url']); ?>" class="img-responsive" alt="<?php echo esc_attr($name);?>">
        <?php 
            if(!empty($link_facebook['url']) || !empty($link_instagram['url']) || !empty($link_youtube) || !empty($link_twitter['url'])){ ?>
                <div class="social">
                    <ul> 
                        <?php if(!empty($link_facebook['url'])){?>
                            <li><a href="<?php echo esc_url($link_facebook['url']);?>"><i class="fab fa-facebook-f"></i></a></li>
                        <?php }?>
                        <?php if(!empty($link_instagram['url'])){?>
                            <li><a href="<?php echo esc_url($link_instagram['url']);?>"><i class="fab fa-instagram"></i></a></li>
                        <?php }?>
                        
                        <?php if(!empty($link_twitter['url'])){?>
                            <li><a href="<?php echo esc_url($link_twitter['url']);?>"><i class="fab fa-twitter"></i></a></li>
                        <?php }?>
                        <?php if(!empty($link_youtube['url'])){?>
                            <li><a href="<?php echo esc_url($link_youtube['url']);?>"><i class="fab fa-youtube"></i></a></li>
                        <?php }?>
                    </ul>
                </div>
            <?php }
        
        ?>
        
    </div>
    <?php 
        if(!empty($name)){ ?>
            <p class="name"><?php echo esc_html($name);?></p>
        <?php }
    ?>
    <?php 
        if(!empty($position)){ ?>
            <p class="position"><?php echo esc_html($position);?></p>
        <?php }
    ?>
</div>
<div class="st-testimonial-new <?php echo esc_attr($attr['style_layout']) ?> ">
    <?php if ($attr['style_layout'] == 'style-5') { ?>
        <div class="st-testimonial-image" >
            <img src="#" alt="testimonial-image">
        </div>
    <?php } ?>
    <?php if (!empty($attr['title']) && $attr['style_layout'] != 'style-6') { ?>
        <h3><?php echo esc_html($attr['title']); ?></h3>
        <?php
    }
    $list_team = vc_param_group_parse_atts($attr['list_team']);
    if (!empty($list_team)) {
        $classSlide = 'st-testimonial-slider';
        switch ($attr['style_layout']) {
            case 'style-6':
                $classSlide = 'st-testimonial-solo-slider';
                break;
            default :
                $classSlide = 'st-testimonial-slider';
                break;
        }
        echo '<div class="owl-carousel ' . $classSlide . ' ' . esc_attr($attr['style_layout']) . ' ">';
        foreach ($list_team as $k => $v) {
            if ($attr['style_layout'] == 'style-1') {
                ?>
                <div class="item has-matchHeight">
                    <div class="author">
                        <?php $img = wp_get_attachment_image_url($v['avatar'], array(70, 70)); ?>
                        <img src="<?php echo esc_attr($img); ?>" alt="User Avatar"/>
                        <div class="author-meta">
                            <h4><?php echo esc_attr($v['name']); ?></h4>
                            <div class="star">
                                <?php
                                $rating = $v['rating'];
                                if ($rating > 5)
                                    $rating = 5;
                                if ($rating < 0)
                                    $rating = 0;

                                for ($i = 1; $i <= $rating; $i++) {
                                    echo '<i class="fa fa-star"></i> ';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                        if(!empty($v['content'])){ ?>
                            <p>
                                <?php echo esc_attr($v['content']); ?>
                            </p>
                        <?php }
                    ?>
                    
                </div>
            <?php } elseif ($attr['style_layout'] == 'style-3') { ?>
                <div class="item ">                    
                    <div class="content">
                        <p class="author-meta"><?php echo esc_attr($v['name']); ?></p>
                        <?php if (!empty($v['source'])) { ?>
                                <p class="st-text"><?php echo esc_html($v['source']); ?></p>
                            <?php
                        } ?>
                        
                        <?php
                        if(!empty($v['content'])){ ?>
                            <p>
                                <?php echo esc_attr($v['content']); ?>
                            </p>
                        <?php }
                    ?>
                    </div>
                    <div class="author">
                        <?php $img = wp_get_attachment_image_url($v['avatar'], array(690, 850)); ?>
                        <img src="<?php echo esc_url($img); ?>" alt="User Avatar"/>
                    </div>
                </div>
            <?php } elseif ($attr['style_layout'] == 'style-5') { ?>
                <?php $img = wp_get_attachment_image_url($v['avatar'], array(900, 500)); ?>
                <div class="item " data-image = "<?php echo esc_attr($img) ?>">
                    <div class="author">
                    </div>
                    <div class="content">
                        <p class="author-meta"><?php echo esc_attr($v['name']); ?></p>
                        <p class="st-text"><?php echo esc_html__('Traveler', 'traveler') ?></p>
                        <p>
                            <?php echo esc_html($v['content']); ?>
                        </p>

                    </div>
                </div>
            <?php } elseif ($attr['style_layout'] == 'style-6') { ?>
                <div class="item ">    
                    <div class="content col-xs-12 col-lg-5 col-md-5 col-sm-5">
                        <div class="content-item">
                            <p><?php echo esc_html($v['content']); ?></p>
                            <div class="author-meta">
                                <div><span class="author-name"><?php echo esc_html($v['name']); ?></span></div>
                                <div class="star">
                                    <?php
                                    $rating = $v['rating'];
                                    if ($rating > 5)
                                        $rating = 5;
                                    if ($rating < 0)
                                        $rating = 0;

                                    for ($i = 1; $i <= $rating; $i++) {
                                        echo '<i class="fa fa-star"></i> ';
                                    }
                                    ?>
                                </div>
                                <span class="description"><?php echo ($v['source']) ? esc_html($v['source']) : ''; ?></span>
                            </div>
                        </div>                      

                    </div>
                    <div class="author col-xs-12 col-lg-7 col-md-7 col-sm-7">
                        <?php $img = wp_get_attachment_image_url($v['avatar'], array(670, 510)); ?>
                        <img src="<?php echo esc_url($img); ?>" alt="User Avatar" />
                    </div>            
                </div>
                <!-- testimonial solo -->
            <?php } elseif ($attr['style_layout'] == 'style-4') { ?>
                <div class="item ">
                    <div class="content">
                        <p class="content-meta"><?php echo esc_html__(' " ', 'traveler') ?>
                            <?php echo esc_html($v['content']); ?>
                            <?php echo esc_html__(' " ', 'traveler') ?>
                        </p>
                        <p class="author-meta"><?php echo esc_html__("-", 'traveler') ?><?php echo esc_attr($v['name']); ?><?php echo esc_html__("-", 'traveler') ?></p>
                    </div>
                </div>
            <?php } else { ?>
                <div class="item has-matchHeight">
                    <div class="author">
                        <?php $img = wp_get_attachment_image_url($v['avatar'], array(100, 100)); ?>
                        <img src="<?php echo esc_url($img); ?>" alt="User Avatar"/>
                    </div>
                    <p>
                        <?php echo esc_attr($v['content']); ?>
                    </p>
                    <div class="author-meta">
                        <h4><?php echo esc_attr($v['name']); ?></h4>
                    </div>
                </div>
                <?php
            }
        }
        echo '</div>';
    }
    ?>
</div>

<div class="st-aboutus-team st-aboutus-solo">
    <h3><?php echo esc_html($attr['title']); ?></h3>
    <?php
    $list_team = vc_param_group_parse_atts($attr['list_team']);
    if (!empty($list_team)) {
        echo '<div class="row slide-item">';
        foreach ($list_team as $k => $v) {
            echo '<div class="col-md-3 col-sm-6 item">';
            ?>
            <div class="thumb">
                <img src="<?php echo wp_get_attachment_image_url($v['photo'], 'full') ?>" class="img-responsive" />
            </div>
            <?php if(!empty($v['name'])){ ?>
            <p class="name"><?php echo esc_html($v['name']); ?></p>
            <?php } ?>
            <?php if(!empty($v['position'])){ ?>
            <p class="pos"><?php echo esc_html($v['position']); ?></p>
            <?php } ?>
            <?php if(!empty($v['country'])){ ?>
            <p class="country"><span class="from"><?php echo esc_html__('From','traveler') ?></span><?php echo esc_html($v['country']); ?></p>
            <?php } ?>
            <?php
            echo '</div>';
        }
        echo '</div>';
    }
    ?>
</div>

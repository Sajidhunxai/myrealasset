<div class="st-aboutus-info">
    <?php if(!empty($attr['more_info'])){ ?>
    <p class="message">"<?php echo esc_html($attr['more_info']); ?>"</p>
    <?php } ?>
    <?php
    if(!empty($attr['image'])) {
        $img = wp_get_attachment_image_url($attr['image'], 'full');
        echo '<img src="'. esc_url($img) .'" alt="'. TravelHelper::get_alt_image($attr['image']) .'"/>';
    }
    ?>
    <?php if(!empty($attr['name'])){ ?>
        <p class="name"><?php echo esc_html($attr['name']); ?></p>
    <?php } ?>
    <?php if(!empty($attr['position'])){ ?>
        <p class="pos"><?php echo esc_html($attr['position']); ?></p>
    <?php } ?>
</div>
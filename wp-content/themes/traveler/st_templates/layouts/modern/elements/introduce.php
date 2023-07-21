<?php
if (isset($link)) {
    $st_link = vc_build_link($link);

} else {
    $st_link = [];
}

$st_link = wp_parse_args($st_link, [
    'url' => '',
    'title' => ''
]);

if (!empty($style)) {
    if ($style == 'style1') {
        $image_url = wp_get_attachment_image_url($image,[570,600]);
        ?>
        <div class=" row st-introduce <?php echo esc_attr($style) ?>">
            <div class="col-md-6 col-md-push-6 st-introduce-left ">
                <div class="thumb">
                    <img src="<?php echo esc_url($image_url) ?>" alt="<?php echo get_bloginfo('description'); ?>">
                </div>
            </div>
            <div class="col-md-6 col-md-pull-6 st-introduce-right">
                <div class="st-content">
                    <p class="st-text"><?php echo esc_html($text) ?></p>
                    <h2 class="st-title"><?php echo esc_html($title) ?></h2>
                    <p class="content"><?php echo esc_html($st_content) ?></p>
                    <?php if (!empty($st_link['title'])) {
                        if (!empty($st_link['url'])) {
                            ?>
                            <a href="<?php echo esc_url($st_link['url']) ?>"><button
                                        class="st-link"><?php echo esc_html($st_link['title']) ?></button></a>
                        <?php } else { ?>
                            <a href="#"><button
                                        class="st-link"><?php echo esc_html($st_link['title']) ?></button></a>
                        <?php } ?>
                    <?php } else { ?>
                        <a href="#"><button
                                    class="st-link"><?php echo esc_html__('Read more', 'traveler') ?></button></a>
                    <?php } ?>
                </div>

            </div>
        </div>

    <?php } elseif ($style == 'style2') {
        $image_url = wp_get_attachment_image_url($image,[570,600]);
        ?>
        <div class=" row st-introduce <?php echo esc_attr($style) ?>">
            <div class="col-md-6  st-introduce-left ">
                <div class="thumb">
                    <img src="<?php echo ($image_url) ?>" alt="<?php echo get_bloginfo('description'); ?>">
                </div>
            </div>
            <div class="col-md-6  st-introduce-right">
                <div class="st-content">
                    <p class="st-text"><?php echo esc_html($text) ?></p>
                    <h2 class="st-title"><?php echo esc_html($title) ?></h2>
                    <p class="content"><?php echo esc_html($st_content) ?></p>
                    <?php if (!empty($st_link['title'])) {
                        if (!empty($st_link['url'])) {
                            ?>
                            <a href="<?php echo esc_url($st_link['url']) ?>"><button
                                        class="st-link"><?php echo esc_html($st_link['title']) ?></button></a>
                        <?php } else { ?>
                            <a href="#"><button
                                        class="st-link"><?php echo esc_html($st_link['title']) ?></button></a>
                        <?php } ?>
                    <?php } else { ?>
                        <a href="#"><button
                                    class="st-link"><?php echo esc_html__('Read more', 'traveler') ?></button></a>
                    <?php } ?>
                </div>

            </div>
        </div>
        <?php
    }elseif ($style == 'style3'){
        $image_url = wp_get_attachment_image_url($image,[600,500]);
        $logo_url = wp_get_attachment_image_url($logo,[140,1400]);
        ?>
        <div class=" row st-introduce <?php echo esc_attr($style) ?>">
            <div class="col-md-6  st-introduce-left ">
                <div class="left-content">
                    <div class="thumb">
                        <img src="<?php echo ($image_url) ?>" alt="<?php echo get_bloginfo('description'); ?>">
                    </div>
                    <div class="logo">
                        <img src="<?php echo ($logo_url) ?>" alt="<?php echo get_bloginfo('description'); ?>">
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-md-offset-1  st-introduce-right">
                <div class="st-content">
                    <p class="st-text"><?php echo esc_html($text) ?></p>
                    <h2 class="st-title"><?php echo esc_html($title) ?></h2>
                    <p class="content"><?php echo esc_html($st_content) ?></p>
                    <?php if (!empty($st_link['title'])) {
                        if (!empty($st_link['url'])) {
                            ?>
                            <a href="<?php echo esc_url($st_link['url']) ?>"><button
                                        class="st-link"><span><?php echo esc_html($st_link['title']) ?></span></button></a>
                        <?php } else { ?>
                            <a href="#"><button
                                        class="st-link"><span><?php echo esc_html($st_link['title']) ?></span></button></a>
                        <?php } ?>
                    <?php } else { ?>
                        <a href="#"><button
                                    class="st-link"><span><?php echo esc_html__('Read more', 'traveler') ?></span></button></a>
                    <?php } ?>
                </div>

            </div>
        </div>
    <?php }
}
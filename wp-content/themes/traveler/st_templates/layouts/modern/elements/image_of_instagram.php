<?php

?>
<div class="stt-instagram-content" data-action="<?php echo esc_html__('load_instagram', 'traveler') ?>"
     data-number="<?php echo esc_attr($number_image) ?>" data-name="<?php echo esc_attr($user_name) ?>">
    <div class="container">
        <div class="stt-instagram-follow">
            <div class="left">
                <img src="<?php echo get_template_directory_uri() ?>/v2/images/svg/instagram.svg">
                <span class="left-text"><a
                            href="<?php echo esc_html__('https://www.instagram.com/', 'traveler') . esc_attr($user_name) ?>"
                            target="_blank"><?php echo esc_html__('Follow us on Instagram', 'traveler') ?></a></span>
            </div>
            <div class="right">
                <span class="right-text"><?php echo esc_html__('Tag your Instagram photos ', 'traveler') ?><a
                            href="<?php echo esc_html__('https://www.instagram.com/', 'traveler') . esc_attr($user_name) ?>"
                            target="_blank"><?php echo esc_html__('#yourname') ?></a></span>
            </div>
        </div>
    </div>
    <div class="stt-list-image">
        <div class="stt-image-item owl-carousel">
        </div>
    </div>
</div>
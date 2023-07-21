<?php

extract(shortcode_atts(array(
    'list_slider' => '',
    'style' => 'style1'
), $attr));
$all_slider = vc_param_group_parse_atts($list_slider);
$num_slider = is_array($all_slider) ? count($all_slider) : 0;
if (!empty($all_slider) || is_array($all_slider)) {

    wp_enqueue_style('sts-hai-slider');
    ?>
    <div class="tour-slider-wrapper sts-tour-slider <?php echo esc_attr($style) ?> " data-style="full-screen">

        <div class="tour-slider owl-carousel">
            <?php
            foreach ($all_slider as $key => $val) {
                if (isset($val['link'])) {
                    $st_link = vc_build_link($val['link']);

                } else {
                    $st_link = [];
                }

                $st_link = wp_parse_args($st_link, [
                    'url' => '',
                    'title' => ''
                ]);
                $slider_image = wp_get_attachment_image_src($val['image'], '');
                ?>
                <div class="item ">
                    <div class="outer"
                         style="background-image: url('<?php echo esc_url($slider_image[0]); ?>');">
                        <div class="search-form-text">
                            <div class="container">
                                <div class="st-heading-tour tour-text"><?php echo esc_attr(!empty($val['title_slider']) ? $val['title_slider'] : ''); ?></div>
                                <h2 class="sub-heading-tour tour-text"><?php echo esc_attr(!empty($val['content_slider']) ? $val['content_slider'] : '' ); ?></h2>
                                <?php if (!empty($st_link['title'])) {
                                    ?>
                                    <a href="<?php echo esc_url($st_link['url']) ?>"><span
                                                class="st-link"><?php echo esc_html( !empty($st_link['title']) ? $st_link['title'] : '') ?></span></a>
                                <?php } else { ?>
                                    <a href="<?php echo esc_url($st_link['url']) ?>"><span
                                                class="st-link"><?php echo esc_html__('explorer', 'traveler') ?></span></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php if ($num_slider > 1) { ?>
            <button class="st-pre st-button" type="button"><img
                        src="<?php echo get_template_directory_uri() ?>/v2/images/html/icon_pre.svg" alt="<?php echo bloginfo('description') ?>"></button>
            <button class="st-next st-button" type="button"><img
                        src="<?php echo get_template_directory_uri() ?>/v2/images/html/icon_next.svg" alt="<?php echo bloginfo('description') ?>"></button>
        <?php } ?>
        <?php
        $container = 'container';
        echo st()->load_template('layouts/modern/tour/elements/search-form-new', '', ['container' => $container]); ?>
    </div>
    <?php
}

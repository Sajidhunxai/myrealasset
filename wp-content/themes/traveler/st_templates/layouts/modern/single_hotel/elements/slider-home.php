<?php
extract(shortcode_atts(array(
    'list_slider' => '',
    'speed_slider' => '',
    'style_gallery' => 'style1',
    'text_animation' => 'text-normal',
    'list_slider_style_3' => '',
    'list_slider_style_4' => '',
), $attr));
if (isset($speed_slider) && !empty($speed_slider)) {
    $speed_slider = $speed_slider;
} else {
    $speed_slider = 3000;
}
if ( $style_gallery === 'style3' && isset( $list_slider_style_3 ) && !empty( $list_slider_style_3 ) ) {
    $all_slider = vc_param_group_parse_atts( $list_slider_style_3 );
    $num_slider = is_array( $all_slider ) ? count( $all_slider ) : 0;
} elseif ( $style_gallery === 'style4' && isset( $list_slider_style_4 ) && !empty( $list_slider_style_4 ) ) {
    $all_slider = vc_param_group_parse_atts( $list_slider_style_4 );
    $num_slider = is_array( $all_slider ) ? count( $all_slider ) : 0;
} else {
    $all_slider = vc_param_group_parse_atts($list_slider);
    $num_slider = is_array( $all_slider ) ? count($all_slider) : 0;
}
if (!empty($all_slider) && is_array($all_slider)) {
    if ($style_gallery == 'style1') {
        ?>
        <section id="slider-activity" class="main-slider">
            <div class="search-form-wrapper slider">
                <div class="container-fluid">
                    <div class="row">
                        <div id="carousel-example-generic" class="carousel slide">
                            <!-- Indicators -->
                            <ol class="carousel-indicators carousel-indicators-numbers">
                                <?php for ($num = 0; $num < $num_slider; $num++) { ?>
                                    <li data-target="#carousel-example-generic"
                                        data-slide-to="<?php echo esc_attr($num); ?>" <?php if ($num == 0) { ?> class="active" <?php } ?>></li>
                                <?php } ?>
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <?php foreach ($all_slider as $key => $val) {
                                    if (isset($val['link'])) {
                                        $st_link = vc_build_link($val['link']);
                                    } else {
                                        $st_link = "";
                                    }

                                    $slider_image = wp_get_attachment_image_src($val['image'], ''); ?>
                                    <div class="item <?php if ($key == 0) { ?>active<?php } ?>">
                                        <img src="<?php echo esc_url($slider_image[0]); ?>"
                                             alt="<?php echo esc_attr($val['title_slider']); ?>">
                                        <div class="search-form-text">
                                            <div class="container">
                                                <h1 class="st-heading"><?php echo esc_attr($val['title_slider']); ?></h1>
                                                <div class="sub-heading"><?php echo esc_attr($val['content_slider']); ?></div>
                                                <?php if (!empty($st_link)) { ?>
                                                    <a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-rounded vc_btn3-style-flat vc_btn3-color-danger"
                                                       href="<?php echo esc_url($st_link); ?>"
                                                       title="<?php echo esc_attr($val['title_slider']); ?>"><?php echo esc_html__('LEARN MORE', 'traveler'); ?></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="promotion__overlay"></div>
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- Controls -->

                        </div>
                    </div>

                </div>
            </div>
        </section>
        <script type="text/javascript">
            jQuery(function ($) {
                $('.carousel').carousel({
                    interval: <?php echo esc_attr($speed_slider);?>
                });
            });
        </script>
        <?php
    } elseif ($style_gallery == 'style3') {
        ?>
        <section id="slider-activity" class="main-slider style3">
            <div class="search-form-wrapper slider">
                <div class="container-fluid">
                    <div class="row">
                        <div id="carousel-example-generic-style-3" class="carousel slide style3">
                            <!-- Indicators -->
                            <ol class="carousel-indicators carousel-indicators-numbers">
                                <?php for ($num = 0; $num < $num_slider; $num++) { ?>
                                    <li data-target="#carousel-example-generic-style-3"
                                        data-slide-to="<?php echo esc_attr($num); ?>" <?php if ($num == 0) { ?> class="active" <?php } ?>></li>
                                <?php } ?>
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <?php foreach ($all_slider as $key => $val) {
                                    if (isset($val['link'])) {
                                        $st_link = vc_build_link($val['link']);
                                    } else {
                                        $st_link = "";
                                    }
                                    $customer_avatar = wp_get_attachment_image_src( $val['customer_avatar'], '' ) ?>
                                    <div class="item <?php if ($key == 0) { ?>active<?php } ?>">
                                        <div class="background"></div>
                                        <div class="search-form-text">
                                            <div class="container">
                                                <h1 class="st-heading"><?php echo esc_attr($val['title_slider']); ?></h1>
                                                <div class="sub-heading"><?php echo esc_attr($val['content_slider']); ?></div>
                                                <?php if (!empty($st_link)) { ?>
                                                    <a class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-rounded vc_btn3-style-flat vc_btn3-color-danger"
                                                       href="<?php echo esc_url($st_link); ?>"
                                                       title="<?php echo esc_attr($val['title_slider']); ?>"><?php echo esc_html__('LEARN MORE', 'traveler'); ?></a>
                                                <?php } ?>
                                                <div class="footer-heading">
                                                    <div class="footer-heading-image">
                                                        <img src="<?php echo esc_url( $customer_avatar[0] ) ?>" alt="customer-avatar">
                                                        <img src="<?php echo esc_url( get_template_directory_uri() . '/v2/images/assets/ico_right_quote-sign.svg' ) ?>" class="ico-right-quote-sign" alt="ico-right-quote-sign">
                                                    </div>
                                                    <div class="footer-heading-text">
                                                        <p class="heading-author"><?php echo esc_html( isset($val['customer_name']) ? $val['customer_name'] : '' ) ?></p>
                                                        <p class="heading-author-site"><?php echo esc_html( isset($val['customer_description']) ? $val['customer_description'] : '' ) ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="promotion__overlay"></div>
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- Controls -->

                        </div>
                    </div>

                </div>
            </div>
        </section>
        <script type="text/javascript">
            jQuery(function ($) {
                $('.carousel').carousel({
                    interval: <?php echo esc_attr($speed_slider);?>
                });
            });
        </script>
        <?php
    } elseif ($style_gallery == 'style4') { ?>
        <section id="slider-activity" class="main-slider style4">
            <div class="search-form-wrapper slider">
                <div class="container-fluid">
                    <div class="row">
                        <div id="carousel-example-generic-style-4" class="carousel slide style4">
                            <!-- Indicators -->
                            <ol class="carousel-indicators carousel-indicators-numbers">
                                <?php for ($num = 0; $num < $num_slider; $num++) { ?>
                                    <li data-target="#carousel-example-generic-style-4"
                                        data-slide-to="<?php echo esc_attr($num); ?>" <?php if ($num == 0) { ?> class="active" <?php } ?>></li>
                                <?php } ?>
                            </ol>

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner" role="listbox">
                                <?php foreach ($all_slider as $key => $val) {
                                    if (isset($val['link'])) {
                                        $st_link = vc_build_link($val['link']);
                                    } else {
                                        $st_link = "";
                                    }

                                    $slider_image = wp_get_attachment_image_src($val['image'], ''); ?>
                                    <div class="item <?php if ($key == 0) { ?>active<?php } ?>">
                                        <img src="<?php echo esc_url($slider_image[0]); ?>"
                                             alt="<?php echo esc_attr($val['title_slider']); ?>">
                                        <div class="search-form-text">
                                                <?php
                                            if (!empty($st_link) && isset( $st_link['url'] )) { ?>
                                                <a class=""
                                                        href="<?php echo esc_url($st_link['url']); ?>"
                                                        title="<?php echo esc_attr($val['title_slider']); ?>">
                                                        <?php
                                            } ?>
                                                    <h1 class="st-heading"><?php echo esc_attr($val['title_slider']); ?></h1>
                                                <?php
                                            if (!empty($st_link)) { ?>
                                                </a>
                                                <?php
                                            } ?>
                                        </div>
                                        <div class="promotion__overlay"></div>
                                    </div>
                                <?php } ?>
                            </div>

                            <!-- Controls -->

                        </div>
                    </div>

                </div>
            </div>
        </section>
        <script type="text/javascript">
            jQuery(function ($) {
                $('.carousel').carousel({
                    interval: <?php echo esc_attr($speed_slider);?>
                });
            });
        </script>
        <?php
    } elseif ($style_gallery == 'style5'){
        ?>
        <div class="tour-slider-wrapper sts-tour-slider slider-style5" data-style="full-screen">

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
                                <div class="st-heading-tour tour-text"><?php echo esc_attr($val['title_slider']); ?></div>
                                <h2 class="sub-heading-tour tour-text"><?php echo esc_attr($val['content_slider']); ?></h2>
                                <?php if (!empty($st_link['title'])) {
                                    ?>
                                    <a href="<?php echo esc_url($st_link['url']) ?>"><span
                                                class="st-link"><?php echo esc_html($st_link['title']) ?></span></a>
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
        </div>
    <?php } else {
        wp_enqueue_style('sts-hai-slider');
        ?>
        <div class="vinhome-slider-wrapper sts-vinhome-slider" data-style="full-screen" data-interval="<?php echo esc_attr($speed_slider); ?>">
            <!--text-hoz-->
            <!--text-rotate-->
            <!--text-up-->
            <div class="vinhome-slider <?php echo esc_attr($text_animation); ?>">
                <?php
                foreach ($all_slider as $key => $val) {
                    if (isset($val['link'])) {
                        $st_link = vc_build_link($val['link']);
                    } else {
                        $st_link = "";
                    }
                    $slider_image = wp_get_attachment_image_src($val['image'], '');
                    ?>
                    <div class="item">
                        <div class="outer"
                             style="background-image: url('<?php echo esc_url($slider_image[0]); ?>');"></div>
                        <div class="inner">
                            <div class="img"
                                 style="background-image: url('<?php echo esc_url($slider_image[0]); ?>');"></div>
                        </div>
                        <div class="search-form-text">
                            <div class="container">
                                <h2 class="st-heading vinhome-text"><?php echo esc_attr($val['title_slider']); ?></h2>
                                <div class="sub-heading vinhome-text"><?php echo esc_attr($val['content_slider']); ?></div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php }
} ?>

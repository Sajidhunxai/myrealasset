<?php extract(shortcode_atts(array(
    'style' => 'style1',
    'title' => '',
    'list_testimonial' => '',
    'icon_image' => '',
), $attr));
$list_testimonial = vc_param_group_parse_atts($list_testimonial);
$icon = wp_get_attachment_image_src($icon_image, array(30, 30));

if (isset($icon) && !empty($icon)) {
    $icon_image = $icon;
} else {
    $icon_image = get_template_directory_uri() . '/v2/images/html/ico_right-quote-sign.svg';
} ?>
<?php if ($style == 'style1') { ?>
    <div class="st-testimonial-slider">
        <h3><?php echo esc_attr($title); ?></h3>
        <?php if (!empty($list_testimonial)) { ?>
            <div class="owl-carousel st-testimonial-slider-single">
                <?php foreach ($list_testimonial as $k => $v) { ?>
                    <div class="item has-matchHeight">
                        <div class="icon-test">
                            <?php if(isset($v['name'])){ ?>
                                <img src="<?php echo ($icon_image[0]); ?>" alt="<?php echo esc_attr($title); ?>">
                            <?php }?>
                        </div>
                        <p>
                            <?php echo esc_attr($v['content']); ?>
                        </p>
                        <div class="info-author">
                            <div class="author">
                                <?php $img = wp_get_attachment_image_src($v['avatar'], array(60, 60)); ?>
                                <img src="<?php echo ($img[0]); ?>" alt="<?php echo esc_attr($title); ?>"/>
                                <div class="author-meta">
                                    <div class="st-wrap-content">
                                        <?php if(isset($v['name'])){ ?>
                                            <h4><?php echo esc_attr($v['name']); ?></h4>
                                        <?php }?>
                                        <?php if(isset($v['job'])){ ?>
                                            <div class="job">
                                                <?php echo esc_attr($v['job']); ?>
                                            </div>
                                        <?php }?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <button class="st-arrow prev carousel--prev"><img
                        src="<?php echo get_template_directory_uri() . '/v2/images/html/ico_pre_3.svg'; ?>" alt="">
            </button>
            <button class="st-arrow next carousel--next"><img
                        src="<?php echo get_template_directory_uri() . '/v2/images/html/ico_next_3.svg'; ?>" alt="">
            </button>
            <script type="text/javascript">
                jQuery(function ($) {
                    $('.st-testimonial-slider-single').each(function () {
                        var parent = $(this).parent();
                        var owl = $(this);
                        $(this).owlCarousel({
                            loop: true,
                            items: 1,
                            navigation: true,
                            responsiveClass: true,
                            responsive: {
                                0: {
                                    items: 1,
                                    margin: 15,
                                },
                                575: {
                                    items: 2,
                                },
                                992: {
                                    items: 1,
                                },
                                1200: {
                                    items: 1,
                                }
                            }
                        });
                        $('.next', parent).on('click', function (ev) {
                            ev.preventDefault();
                            owl.trigger('next.owl.carousel');
                        });
                        $('.prev', parent).on('click', function (ev) {
                            ev.preventDefault();
                            owl.trigger('prev.owl.carousel');
                        });
                    });
                });

            </script>
        <?php } ?>
    </div>
<?php } elseif ($style == 'style2') { ?>
    <div class="st-testimonial-slider-style2">
        <?php if (!empty($list_testimonial)) { ?>
            <div class="owl-carousel st-testimonial-slider-single-2">
                <?php foreach ($list_testimonial as $k => $v) {

                    ?>
                    <div class="item has-matchHeight">
                        <p class="content">
                            <?php if (!empty($v['content'])) {
                                echo esc_attr($v['content']);
                            } ?>
                        </p>
                        <?php
                        if (!empty($v['avatar'])) {
                            $img = wp_get_attachment_image_src($v['avatar'], array(60, 60));
                        } ?>
                        <div data-dot="<button role='button' class='owl-dot' style='background-image: url(<?php echo esc_url($img[0]) ?>)'></button>
                        <div class ='st-info'>
                        <?php if(!empty($v['name'])){ ?>
                         <p class = 'st-name'><?php echo esc_html($v['name']) ?></p>
                        <?php } ?>
                        <?php if(!empty($v['job'])){ ?>
                         <p class = 'st-job'><?php echo esc_html($v['job']) ?></p>
                        <?php } ?>
                        </div>
                       ">

                        </div>

                    </div>
                <?php } ?>
            </div>

            <script type="text/javascript">
                jQuery(function ($) {
                    $('.st-testimonial-slider-single-2').each(function () {
                        var parent = $(this).parent();
                        var owl = $(this);
                        $(this).owlCarousel({
                            items: 1,
                            navigation: true,
                            responsiveClass: true,

                            nav: true,
                            dots:true,
                            dotsData: true,
                            responsive: {
                                0: {
                                    items: 1,
                                    margin: 15,
                                },
                                575: {
                                    items: 1,
                                },
                                992: {
                                    items: 1,
                                },
                                1200: {
                                    items: 1,
                                }
                            }
                        });

                    });
                });

            </script>
        <?php } ?>
    </div>
<?php } ?>

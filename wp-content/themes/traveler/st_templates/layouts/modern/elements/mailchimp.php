<?php extract(shortcode_atts(array(
    'heading_title'          => '',
    'sub_title'          => '',
    'icon' => ''
  ), $attr));
?>
<div class="mailchimp">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-lg-10 col-lg-offset-1">
                <div class="row">
                    <div class="col-xs-12  col-md-7 col-lg-6">
                        <div class="media ">
                            <div class="media-left pr30 hidden-xs">
                                <?php
                                $class_ico = Assets::build_css('height: 80px');
                                if (! empty($icon)) {
                                    $img_url = wp_get_attachment_image_url($icon, array('80', '80'));
                                } else {
                                    $img_url = get_template_directory_uri() . "/v2/images/svg/ico_email_subscribe.svg";
                                }?>
                                <img class="media-object <?php esc_attr_e($class_ico) ?>"
                                    src="<?php esc_attr_e($img_url) ?>"
                                    alt="">
                            </div>
                            <div class="media-body">
                                <?php
                                if (! empty($heading_title)) { ?>
                                    <h4 class="media-heading st-heading-section f24"><?php esc_html_e($heading_title) ?></h4>
                                    <?php
                                } ?>
                                <?php
                                if (! empty($sub_title)) { ?>
                                    <p class="f16 c-grey"><?php esc_html_e($sub_title) ?></p>
                                    <?php
                                } ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-5 col-lg-6">
                        <?php
                            $form = st()->get_option( 'mailchimp_shortcode' );
                            if ( $form ) {
                                echo do_shortcode( $form );
                            } else {
                                ?>
                                <form action="#" class="subcribe-form">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="<?php esc_attr_e('Your Email', 'traveler') ?>">
                                        <input type="submit" name="submit" value="<?php echo esc_attr_e('Subscribe', 'traveler') ?>">
                                    </div>
                                </form>
                                <?php
                            }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

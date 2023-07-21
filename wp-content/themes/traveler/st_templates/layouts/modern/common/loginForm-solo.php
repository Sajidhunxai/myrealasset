<div class="modal fade form-login--solo" id="st-login-form" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog--width" role="document" style="max-width: 450px;">
        <div class="modal-content relative">
            <?php echo st()->load_template('layouts/modern/common/loader'); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <?php echo TravelHelper::getNewIcon('Ico_close') ?>
                </button>
                <div class="modal-title"><?php echo esc_html__('Log In', 'traveler') ?></div>
                <span class="modal-sub-title"><?php echo esc_html__('Log in to add new things to your wishlist and access your any device', 'traveler') ?></span>
            </div>
              <div class="advanced">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <?php if (st_social_channel_status('facebook')): ?>
                                    <a onclick="return false" href="#"
                                       class="btn_login_fb_link st_login_social_link" data-channel="facebook">

                                           <span><?php  echo esc_html__('CONTINUE WITH FACEBOOK', 'traveler') ?></span>
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="col-xs-12 col-sm-12">
                                <?php if (st_social_channel_status('google')):

                                    $style_button_social_google = st()->get_option('style_button_social_google', '1');
                                    if( $style_button_social_google == '2'){
                                        echo do_shortcode('[st-google-login type="login"]');
                                    } else { ?>
                                        <a href="#" id="st-google-signin2"
                                        class="btn_login_gg_link st_login_social_link" data-channel="google">

                                                <i class="fab fa-google-plus-g"></i>
                                            <span><?php echo esc_html__('CONTINUE WITH GOOGLE', 'traveler') ?></span>
                                        </a>
                                    <?php }
                                    
                                    ?>
                                    
                                    <!--<div id="st-google-signin2" class="btn_login_gg_link st_login_social_link"></div>-->
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
            <div class="modal-body relative">
                <form action="#" class="form" method="post">
                    <input type="hidden" name="st_theme_style" value="modern"/>
                    <input type="hidden" name="action" value="st_login_popup">
                    <input type="hidden" name="post_id" value="<?php echo get_the_ID();?>">
                    <div class="form-group form-padding">
                        <label class="title-form"><?php echo esc_html__('Or','traveler') ?></label>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" autocomplete="off"
                               placeholder="<?php echo esc_html__('Email or Username', 'traveler') ?>">

                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" autocomplete="off"
                               placeholder="<?php echo esc_html__('Password', 'traveler') ?>">

                    </div>
                    <div class="mt20 st-flex space-between st-icheck">
                        <div class="st-icheck-item">
                            <label for="remember-me" class="c-grey">
                                <input type="checkbox" name="remember" id="remember-me"
                                       value="1"> <?php echo esc_html__('Remember me', 'traveler') ?>
                                <span class="checkmark fcheckbox"></span>
                            </label>
                        </div>
                        <a href="#" class="st-link open-loss-password"
                           data-toggle="modal"><?php echo esc_html__('Forgot Password?', 'traveler') ?></a>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="form-submit"
                               value="<?php echo esc_html__('Log In', 'traveler') ?>">
                    </div>
                    <div class="message-wrapper mt20"></div>


                    <div class="mt20 c-grey font-medium f14 text-center">
                        <?php echo esc_html__('New here?', 'traveler') ?>
                        <a href="#"
                           class="st-link open-signup"
                           data-toggle="modal"><?php echo esc_html__('Create an Account', 'traveler') ?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

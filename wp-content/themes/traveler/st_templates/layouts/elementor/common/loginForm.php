<div class="modal fade login-regiter-popup" id="st-login-form" tabindex="-1" role="dialog" aria-labelledby="st-login-form" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 450px;">
        <div class="modal-content st-border-radius relative">
            <?php echo st()->load_template('layouts/modern/common/loader'); ?>
            <div class="modal-header d-sm-flex d-md-flex justify-content-between align-items-center">
                <div class="modal-title"><?php echo esc_html__('Log In', 'traveler') ?></div>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <?php echo TravelHelper::getNewIcon('Ico_close') ?>
                </button>
                
            </div>
            <div class="modal-body relative">
                <div class="map-loading" style="display:none">
                </div>
                <form action="#" class="form" method="post">
                    <input type="hidden" name="st_theme_style" value="modern"/>
                    <input type="hidden" name="action" value="st_login_popup">
                    <input type="hidden" name="post_id" value="<?php echo get_the_ID();?>">
                    <div class="form-group">
                        <input type="text" class="form-control st-border-radius" name="username" autocomplete="off"
                               placeholder="<?php echo esc_html__('Email or Username', 'traveler') ?>">
                               <?php echo TravelHelper::getNewIcon('ico_email_login_form', '', '18px', ''); ?>
                    </div>
                    <div class="form-group field-password ic-view">
                        <input type="password" class="form-control st-border-radius" name="password" autocomplete="off"
                               placeholder="<?php echo esc_html__('Password', 'traveler') ?>">
                               <?php echo TravelHelper::getNewIcon('ico_pass_login_form', '', '16px', ''); ?>
                    </div>
                    <div class="form-group st-border-radius">
                        <input type="submit" name="submit" class="form-submit"
                               value="<?php echo esc_html__('Log In', 'traveler') ?>">
                    </div>
                    <div class="message-wrapper mt20"></div>
                    <div class="mt20 st-flex space-between st-icheck">
                        <div class="st-icheck-item">
                            <label for="remember-me" class="c-grey">
                                <input type="checkbox" name="remember" id="remember-me"
                                       value="1"> <?php echo esc_html__('Remember me', 'traveler') ?>
                                <span class="checkmark fcheckbox"></span>
                            </label>
                        </div>
                        <a href="#" class="st-link open-loss-password"
                        data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#st-forgot-form"><?php echo esc_html__('Forgot Password?', 'traveler') ?></a>
                    </div>
                    <?php if (st_social_channel_status('facebook') || st_social_channel_status('google') || st_social_channel_status('twitter') ): ?>
                        <div class="advanced">
                            <p class="text-center f14 c-grey"><?php echo esc_html__('or continue with', 'traveler') ?></p>
                            <div class="row">
                                <div class="col-4">
                                    <?php if (st_social_channel_status('facebook')): ?>
                                        <a onclick="return false" href="#"
                                        class="btn_login_fb_link st_login_social_link" data-channel="facebook">
                                            <?php echo TravelHelper::getNewIcon('fb', '', '100%') ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="col-4">
                                    <?php if (st_social_channel_status('google')):
                                        $style_button_social_google = st()->get_option('style_button_social_google', '1');
                                        if( $style_button_social_google == '2'){
                                            echo do_shortcode('[st-google-login type="login"]');
                                        } else { ?>
                                            <a href="#" id="st-google-signin2"
                                            class="btn_login_gg_link st_login_social_link" data-channel="google">
                                                <?php echo TravelHelper::getNewIcon('g+', '', '100%') ?>
                                            </a>
                                        <?php }
                                        ?>

                                        
                                    <?php endif; ?>
                                </div>
                                <div class="col-4">
                                    <?php if (st_social_channel_status('twitter')): ?>
                                        <a href="<?php echo site_url() ?>/social-login/twitter"
                                        onclick="return false"
                                        class="btn_login_tw_link st_login_social_link" data-channel="twitter">
                                            <?php echo TravelHelper::getNewIcon('tt', '', '100%') ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="mt20 c-grey font-medium f14 text-center">
                        <?php echo esc_html__('Do not have an account? ', 'traveler') ?>
                        <a href="#"
                           class="st-link open-signup" data-bs-dismiss="modal"
                           data-bs-toggle="modal" data-bs-target="#st-register-form"><?php echo esc_html__('Sign Up', 'traveler') ?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
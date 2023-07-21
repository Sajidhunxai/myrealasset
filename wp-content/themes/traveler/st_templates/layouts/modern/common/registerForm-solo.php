<div class="modal fade form-register--solo" id="st-register-form" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog--width" role="document" style="max-width: 520px;">
        <div class="modal-content relative">
            <?php echo st()->load_template('layouts/modern/common/loader'); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <?php echo TravelHelper::getNewIcon('Ico_close') ?>
                </button>
                <h4 class="modal-title modal-title--margin"><?php echo esc_html__('Sign Up', 'traveler') ?></h4>
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
                                        echo do_shortcode('[st-google-login type="register"]');
                                     } else { ?>
                                         <a href="#" id="st-google-signin3"
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
            <div class="modal-body">
                <form action="#" class="form" method="post">
                    <input type="hidden" name="st_theme_style" value="modern"/>
                    <input type="hidden" name="action" value="st_registration_popup">
                    <input type="hidden" name="post_id" value="<?php echo get_the_ID();?>">
                    <div class="form-group form-padding">
                        <label class="title-form"><?php echo esc_html__('Or','traveler') ?></label>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" autocomplete="off"
                               placeholder="<?php echo esc_html__('Username *', 'traveler') ?>">
                               
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="fullname" autocomplete="off"
                               placeholder="<?php echo esc_html__('Full Name', 'traveler') ?>">
                               
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" autocomplete="off"
                               placeholder="<?php echo esc_html__('Email *', 'traveler') ?>">
                               
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" autocomplete="off"
                               placeholder="<?php echo esc_html__('Password *', 'traveler') ?>">
                               
                    </div>
                    <?php
                    $allow_partner = st()->get_option('setting_partner', 'off');
                    if ($allow_partner == 'on') {
                        ?>
                        <div class="form-group">
                            <p class="f14 c-grey"><?php echo esc_html__('Select User Type', 'traveler') ?></p>
                            <label class="block" for="normal-user">
                                <input checked id="normal-user" type="radio" class="mr5" name="register_as"
                                       value="normal"> <span class="c-main" data-toggle="tooltip" data-placement="right"
                                       title="<?php echo esc_html__('Used for booking services', 'traveler') ?>"><?php echo esc_html__('Normal User', 'traveler') ?></span>
                            </label>
                            <label class="block" for="partner-user">
                                <input id="partner-user" type="radio" class="mr5" name="register_as"
                                       value="partner">
                                <span class="c-main" data-toggle="tooltip" data-placement="right"
                                      title="<?php echo esc_html__('Used for upload and booking services', 'traveler') ?>"><?php echo esc_html__('Partner User', 'traveler') ?></span>
                            </label>
                        </div>
                    <?php } else { ?>
                        <input type="hidden" name="register_as" value="normal">
                    <?php } ?>
                    <div class="form-group st-icheck-item st-icheck-info">
                        <label for="term">
                            <?php
                            $term_id = get_option('wp_page_for_privacy_policy');
                            ?>
                            <input id="term" type="checkbox" name="term"
                                   class="mr5"> <?php echo wp_kses(sprintf(__('I have read and accept the <a class="st-link" href="%s">Terms and Privacy Policy</a>', 'traveler'), get_the_permalink($term_id)), ['a' => ['href' => [], 'class' => []]]); ?>
                            <span class="checkmark fcheckbox"></span>
                        </label>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="form-submit"
                               value="<?php echo esc_html__('Sign Up', 'traveler') ?>">
                    </div>
                    <div class="message-wrapper mt20"></div>
                    
                    <div class="mt20 c-grey f14 text-center font-medium">
                        <?php echo esc_html__('Already have an account? ', 'traveler') ?>
                        <a href="#" class="st-link open-login"
                           data-toggle="modal"><?php echo esc_html__('Log In', 'traveler') ?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
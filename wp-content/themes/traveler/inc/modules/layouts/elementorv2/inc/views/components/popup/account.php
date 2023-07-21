<div class="modal fade login-regiter-popup style-9" id="st-login-form" tabindex="-1" role="dialog" aria-labelledby="st-login-form" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content st-border-radius relative">
            <?php echo st()->load_template('layouts/modern/common/loader'); ?>
            <div class="modal-header d-sm-flex d-md-flex justify-content-between align-items-center">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span class="stt-icon stt-icon-close"></span>
                </button>
                <ul class="account-tabs">
                    <li class="active st-sign-in" data-target="login-component"><?php echo esc_html__('Sign in', 'traveler'); ?></li>
                    <li class="st-sign-up" data-target="register-component"><?php echo esc_html__('Sign up', 'traveler'); ?></li>
                </ul>
            </div>
            <div class="modal-body relative">
                <div class="login-form-wrapper login-component active">
                    <div class="heading"><?php echo esc_html__('Sign in to your account', 'traveler'); ?></div>
                    <form action="#" class="form" method="post">
                        <input type="hidden" name="st_theme_style" value="modern"/>
                        <input type="hidden" name="action" value="st_login_popup">
                        <input type="hidden" name="post_id" value="<?php echo get_the_ID();?>">
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" autocomplete="off" placeholder="<?php echo esc_html__('Email or Username', 'traveler') ?>">
                        </div>
                        <div class="form-group field-password">
                            <input type="password" class="form-control" name="password" autocomplete="off" placeholder="<?php echo esc_html__('Password', 'traveler') ?>">
                            <span class="stt-icon stt-icon-eye ic-view"></span>
                            <span class="stt-icon stt-icon-eye-blind ic-hide"></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="form-submit" value="<?php echo esc_html__('Log in', 'traveler') ?>">
                        </div>
                        <div class="message-wrapper mt20"></div>
                        <div class="mt20 st-flex space-between st-icheck">
                            <div class="st-icheck-item">
                                <label for="remember-me" class="c-grey">
                                    <input type="checkbox" name="remember" id="remember-me" value="1"> <?php echo esc_html__('Remember me', 'traveler') ?>
                                    <span class="checkmark fcheckbox"></span>
                                </label>
                            </div>
                            <a href="#" class="st-link open-loss-password" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#st-forgot-form"><?php echo esc_html__('Forgot Password?', 'traveler') ?></a>
                        </div>
                        <?php if (st_social_channel_status('facebook') || st_social_channel_status('google') || st_social_channel_status('twitter') ): ?>
                        <div class="advanced">
                            <p class="text-center f14 c-grey"><span><?php echo esc_html__('or sign in with', 'traveler') ?></span></p>
                            <div class="social-login">
                                <?php if (st_social_channel_status('facebook')): ?>
                                    <a onclick="return false" href="#"
                                       class="btn_login_fb_link st_login_social_link" data-channel="facebook">
                                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0 11.0614C0 16.5303 3.97192 21.0778 9.16667 22V14.0553H6.41667V11H9.16667V8.55525C9.16667 5.80525 10.9386 4.27808 13.4447 4.27808C14.2386 4.27808 15.0948 4.4 15.8886 4.52192V7.33333H14.4833C13.1386 7.33333 12.8333 8.00525 12.8333 8.86142V11H15.7667L15.2781 14.0553H12.8333V22C18.0281 21.0778 22 16.5312 22 11.0614C22 4.9775 17.05 0 11 0C4.95 0 0 4.9775 0 11.0614Z" fill="#1877F1"/>
                                        </svg>
                                        <?php echo esc_html__('Sign in with Facebook', 'traveler'); ?>
                                    </a>
                                <?php endif; ?>
                                <?php if (st_social_channel_status('google')): 
                                    $style_button_social_google = st()->get_option('style_button_social_google', '1');
                                    if( $style_button_social_google == '2'){
                                        echo do_shortcode('[st-google-login type="login"]');
                                    } else { ?>
                                        <a href="#" id="st-google-signin2"
                                        class="btn_login_gg_link st_login_social_link" data-channel="google">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18.1713 8.36775H17.5V8.33317H10V11.6665H14.7096C14.0225 13.6069 12.1763 14.9998 10 14.9998C7.23877 14.9998 5.00002 12.7611 5.00002 9.99984C5.00002 7.23859 7.23877 4.99984 10 4.99984C11.2746 4.99984 12.4342 5.48067 13.3171 6.26609L15.6742 3.909C14.1859 2.52192 12.195 1.6665 10 1.6665C5.39794 1.6665 1.66669 5.39775 1.66669 9.99984C1.66669 14.6019 5.39794 18.3332 10 18.3332C14.6021 18.3332 18.3334 14.6019 18.3334 9.99984C18.3334 9.44109 18.2759 8.89567 18.1713 8.36775Z" fill="#FFC107"/>
                                                <path d="M2.6275 6.12109L5.36542 8.129C6.10625 6.29484 7.90042 4.99984 10 4.99984C11.2746 4.99984 12.4342 5.48067 13.3171 6.26609L15.6742 3.909C14.1858 2.52192 12.195 1.6665 10 1.6665C6.79917 1.6665 4.02334 3.47359 2.6275 6.12109Z" fill="#FF3D00"/>
                                                <path d="M9.99999 18.3331C12.1525 18.3331 14.1083 17.5094 15.5871 16.1698L13.0079 13.9873C12.1431 14.645 11.0864 15.0007 9.99999 14.9998C7.83249 14.9998 5.99207 13.6177 5.29874 11.689L2.58124 13.7827C3.9604 16.4815 6.76124 18.3331 9.99999 18.3331Z" fill="#4CAF50"/>
                                                <path d="M18.1713 8.36808H17.5V8.3335H10V11.6668H14.7096C14.3809 12.5903 13.7889 13.3973 13.0067 13.9881L13.0079 13.9872L15.5871 16.1697C15.4046 16.3356 18.3333 14.1668 18.3333 10.0002C18.3333 9.44141 18.2758 8.896 18.1713 8.36808Z" fill="#1976D2"/>
                                            </svg>
                                            <?php echo esc_html__('Sign in with Google', 'traveler'); ?>
                                        </a>
                                    <?php }
                                    
                                    ?>
                                    
                                <?php endif; ?>
                                <?php if (st_social_channel_status('twitter')): ?>
                                    <a href="<?php echo site_url() ?>/social-login/twitter"
                                       onclick="return false"
                                       class="btn_login_tw_link st_login_social_link" data-channel="twitter">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M18.5878 4.67345C17.9489 4.95369 17.2682 5.13944 16.5584 5.22963C17.2886 4.7937 17.8458 4.10867 18.1078 3.28298C17.4271 3.68885 16.6755 3.97553 15.8745 4.13552C15.2281 3.44726 14.3068 3.021 13.3018 3.021C11.352 3.021 9.78219 4.60366 9.78219 6.54386C9.78219 6.82303 9.80581 7.09146 9.86379 7.34701C6.93576 7.2042 4.34488 5.80085 2.60439 3.66308C2.30052 4.19027 2.12229 4.7937 2.12229 5.4433C2.12229 6.66305 2.75041 7.74428 3.68669 8.37026C3.12084 8.35952 2.56573 8.19524 2.09544 7.93648C2.09544 7.94721 2.09544 7.96117 2.09544 7.97513C2.09544 9.68664 3.31626 11.1082 4.91717 11.4357C4.63049 11.5141 4.31804 11.5517 3.99378 11.5517C3.7683 11.5517 3.54067 11.5388 3.327 11.4916C3.78333 12.8863 5.07823 13.9117 6.61794 13.945C5.41967 14.8824 3.89822 15.4471 2.25113 15.4471C1.9623 15.4471 1.68528 15.4342 1.40826 15.3988C2.96838 16.4049 4.81732 16.9793 6.81121 16.9793C13.2922 16.9793 16.8354 11.6107 16.8354 6.95725C16.8354 6.80156 16.8301 6.65124 16.8226 6.50199C17.5215 6.00593 18.1089 5.3864 18.5878 4.67345Z" fill="#03A9F4"/>
                                        </svg>
                                        <?php echo esc_html__('Continue with Twitter', 'traveler'); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="create-account-action">
                            <a href="#"
                               class="st-link open-signup"><?php echo esc_html__('Create an account', 'traveler') ?></a>
                        </div>
                    </form>
                </div>
                <div class="login-form-wrapper register-component">
                    <div class="heading"><?php echo esc_html__('Create an account', 'traveler'); ?></div>
                    <form action="#" class="form" method="post">
                        <input type="hidden" name="st_theme_style" value="modern"/>
                        <input type="hidden" name="action" value="st_registration_popup">
                        <input type="hidden" name="post_id" value="<?php echo get_the_ID();?>">
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" autocomplete="off" placeholder="<?php echo esc_html__('Username *', 'traveler') ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="fullname" autocomplete="off" placeholder="<?php echo esc_html__('Full Name', 'traveler') ?>">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" autocomplete="off" placeholder="<?php echo esc_html__('Email *', 'traveler') ?>">
                        </div>
                        <div class="form-group field-password">
                            <input type="password" class="form-control" name="password" autocomplete="off" placeholder="<?php echo esc_html__('Password', 'traveler') ?>">
                            <span class="stt-icon stt-icon-eye ic-view"></span>
                            <span class="stt-icon stt-icon-eye-blind ic-hide"></span>
                        </div>

                        <?php
                        $allow_partner = st()->get_option('setting_partner', 'off');
                        if ($allow_partner == 'on') {
                            ?>
                            <div class="form-group user-type">
                                <label class="block" for="normal-user">
                                    <input checked id="normal-user" type="radio" class="mr5" name="register_as"
                                           value="normal"> <span data-toggle="tooltip" data-placement="right"
                                                                 title="<?php echo esc_html__('Used for booking services', 'traveler') ?>"><?php echo esc_html__('Normal User', 'traveler') ?></span>
                                </label>
                                <label class="block" for="partner-user">
                                    <input id="partner-user" type="radio" class="mr5" name="register_as"
                                           value="partner">
                                    <span data-toggle="tooltip" data-placement="right"
                                          title="<?php echo esc_html__('Used for upload and booking services', 'traveler') ?>"><?php echo esc_html__('Partner User', 'traveler') ?></span>
                                </label>
                            </div>
                        <?php } else { ?>
                            <input type="hidden" name="register_as" value="normal">
                        <?php } ?>

                        <div class="form-group">
                            <input type="submit" name="submit" class="form-submit" value="<?php echo esc_html__('Register', 'traveler') ?>">
                        </div>

                        <div class="st-icheck">
                            <div class="st-icheck-item">
                                <label for="term">
                                    <?php $term_id = get_option('wp_page_for_privacy_policy'); ?>
                                    <input id="term" type="checkbox" name="term" class="mr5"> <?php echo wp_kses(sprintf(__('I confirm that I have read and accepted the <a class="st-link" href="%s">privacy policy</a>', 'traveler'), get_the_permalink($term_id)), ['a' => ['href' => [], 'class' => []]]); ?>
                                    <span class="checkmark fcheckbox"></span>
                                </label>
                            </div>
                        </div>

                        <div class="message-wrapper mt20"></div>
                        <?php if (st_social_channel_status('facebook') || st_social_channel_status('google') || st_social_channel_status('twitter') ): ?>
                            <div class="advanced">
                                <p class="text-center f14 c-grey"><span><?php echo esc_html__('or sign in with', 'traveler') ?></span></p>
                                <div class="social-login">
                                    <?php if (st_social_channel_status('facebook')): ?>
                                        <a onclick="return false" href="#"
                                        class="btn_login_fb_link st_login_social_link" data-channel="facebook">
                                            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 11.0614C0 16.5303 3.97192 21.0778 9.16667 22V14.0553H6.41667V11H9.16667V8.55525C9.16667 5.80525 10.9386 4.27808 13.4447 4.27808C14.2386 4.27808 15.0948 4.4 15.8886 4.52192V7.33333H14.4833C13.1386 7.33333 12.8333 8.00525 12.8333 8.86142V11H15.7667L15.2781 14.0553H12.8333V22C18.0281 21.0778 22 16.5312 22 11.0614C22 4.9775 17.05 0 11 0C4.95 0 0 4.9775 0 11.0614Z" fill="#1877F1"/>
                                            </svg>
                                            <?php echo esc_html__('Sign in with Facebook', 'traveler'); ?>
                                        </a>
                                    <?php endif; ?>
                                    <?php if (st_social_channel_status('google')):
                                        $style_button_social_google = st()->get_option('style_button_social_google', '1');
                                        if( $style_button_social_google == '2'){
                                            echo do_shortcode('[st-google-login type="register"]');
                                        } else { ?>
                                            <a href="#" id="st-google-signin2"
                                            class="btn_login_gg_link st_login_social_link" data-channel="google">
                                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M18.1713 8.36775H17.5V8.33317H10V11.6665H14.7096C14.0225 13.6069 12.1763 14.9998 10 14.9998C7.23877 14.9998 5.00002 12.7611 5.00002 9.99984C5.00002 7.23859 7.23877 4.99984 10 4.99984C11.2746 4.99984 12.4342 5.48067 13.3171 6.26609L15.6742 3.909C14.1859 2.52192 12.195 1.6665 10 1.6665C5.39794 1.6665 1.66669 5.39775 1.66669 9.99984C1.66669 14.6019 5.39794 18.3332 10 18.3332C14.6021 18.3332 18.3334 14.6019 18.3334 9.99984C18.3334 9.44109 18.2759 8.89567 18.1713 8.36775Z" fill="#FFC107"/>
                                                    <path d="M2.6275 6.12109L5.36542 8.129C6.10625 6.29484 7.90042 4.99984 10 4.99984C11.2746 4.99984 12.4342 5.48067 13.3171 6.26609L15.6742 3.909C14.1858 2.52192 12.195 1.6665 10 1.6665C6.79917 1.6665 4.02334 3.47359 2.6275 6.12109Z" fill="#FF3D00"/>
                                                    <path d="M9.99999 18.3331C12.1525 18.3331 14.1083 17.5094 15.5871 16.1698L13.0079 13.9873C12.1431 14.645 11.0864 15.0007 9.99999 14.9998C7.83249 14.9998 5.99207 13.6177 5.29874 11.689L2.58124 13.7827C3.9604 16.4815 6.76124 18.3331 9.99999 18.3331Z" fill="#4CAF50"/>
                                                    <path d="M18.1713 8.36808H17.5V8.3335H10V11.6668H14.7096C14.3809 12.5903 13.7889 13.3973 13.0067 13.9881L13.0079 13.9872L15.5871 16.1697C15.4046 16.3356 18.3333 14.1668 18.3333 10.0002C18.3333 9.44141 18.2758 8.896 18.1713 8.36808Z" fill="#1976D2"/>
                                                </svg>
                                                <?php echo esc_html__('Sign in with Google', 'traveler'); ?>
                                            </a>
                                        <?php }
                                        
                                        ?>
                                    <?php endif; ?>
                                    <?php if (st_social_channel_status('twitter')): ?>
                                        <a href="<?php echo site_url() ?>/social-login/twitter"
                                        onclick="return false"
                                        class="btn_login_tw_link st_login_social_link" data-channel="twitter">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M18.5878 4.67345C17.9489 4.95369 17.2682 5.13944 16.5584 5.22963C17.2886 4.7937 17.8458 4.10867 18.1078 3.28298C17.4271 3.68885 16.6755 3.97553 15.8745 4.13552C15.2281 3.44726 14.3068 3.021 13.3018 3.021C11.352 3.021 9.78219 4.60366 9.78219 6.54386C9.78219 6.82303 9.80581 7.09146 9.86379 7.34701C6.93576 7.2042 4.34488 5.80085 2.60439 3.66308C2.30052 4.19027 2.12229 4.7937 2.12229 5.4433C2.12229 6.66305 2.75041 7.74428 3.68669 8.37026C3.12084 8.35952 2.56573 8.19524 2.09544 7.93648C2.09544 7.94721 2.09544 7.96117 2.09544 7.97513C2.09544 9.68664 3.31626 11.1082 4.91717 11.4357C4.63049 11.5141 4.31804 11.5517 3.99378 11.5517C3.7683 11.5517 3.54067 11.5388 3.327 11.4916C3.78333 12.8863 5.07823 13.9117 6.61794 13.945C5.41967 14.8824 3.89822 15.4471 2.25113 15.4471C1.9623 15.4471 1.68528 15.4342 1.40826 15.3988C2.96838 16.4049 4.81732 16.9793 6.81121 16.9793C13.2922 16.9793 16.8354 11.6107 16.8354 6.95725C16.8354 6.80156 16.8301 6.65124 16.8226 6.50199C17.5215 6.00593 18.1089 5.3864 18.5878 4.67345Z" fill="#03A9F4"/>
                                            </svg>
                                            <?php echo esc_html__('Continue with Twitter', 'traveler'); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif;?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
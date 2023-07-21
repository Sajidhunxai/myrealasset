<?php
get_header();
wp_enqueue_script('filter-hotel');
?>
    <div id="st-content-wrapper" class="search-result-page layout2">
        <?php
        echo st()->load_template('layouts/elementor/hotel/elements/banner');
        ?>
        <div class="full-map d-none d-sm-none d-md-block">
            <div class="search-form-wrapper">
                <div class="container">
                    <div class="row">
                    <?php echo st()->load_template('layouts/elementor/hotel/elements/search-form'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="st-results st-hotel-result" id="sticky-halfmap">
            <div class="container">
                <?php
                echo st()->load_template('layouts/elementor/hotel/elements/top-filter/top-filter');
                $query           = array(
                    'post_type'      => 'st_hotel' ,
                    'post_status'    => 'publish' ,
                    's'              => '' ,
                    'orderby' => 'post_modified',
                    'order'   => 'DESC',
                );
                global $wp_query , $st_search_query;

                $current_lang = TravelHelper::current_lang();
                $main_lang = TravelHelper::primary_lang();
                if (TravelHelper::is_wpml()) {
                    global $sitepress;
                    $sitepress->switch_lang($main_lang, true);
                }

                $hotel = STHotel::inst();
                $hotel->alter_search_query();
                query_posts( $query );
                $st_search_query = $wp_query;
                $hotel->remove_alter_search_query();
                wp_reset_query();

                if (TravelHelper::is_wpml()) {
                    global $sitepress;
                    $sitepress->switch_lang($current_lang, true);
                }

                echo st()->load_template('layouts/elementor/hotel/elements/content2'); ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="st-login-form" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="max-width: 450px;">
            <div class="modal-content relative">
                <?php echo st()->load_template('layouts/elementor/common/loader'); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <?php echo TravelHelper::getNewIcon('Ico_close') ?>
                    </button>
                    <div class="modal-title"><?php echo esc_html__('Log In', 'traveler') ?></div>
                </div>
                <div class="modal-body relative">
                    <form action="#" class="form" method="post">
                        <input type="hidden" name="st_theme_style" value="modern"/>
                        <input type="hidden" name="action" value="st_login_popup">
                        <input type="hidden" name="post_id" value="<?php echo get_the_ID();?>">
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" autocomplete="off"
                                   placeholder="<?php echo esc_html__('Email or Username', 'traveler') ?>">
                            <?php echo TravelHelper::getNewIcon('ico_email_login_form', '', '18px', ''); ?>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" autocomplete="off"
                                   placeholder="<?php echo esc_html__('Password', 'traveler') ?>">
                            <?php echo TravelHelper::getNewIcon('ico_pass_login_form', '', '16px', ''); ?>
                        </div>
                        <div class="form-group">
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
                               data-bs-toggle="modal"><?php echo esc_html__('Forgot Password?', 'traveler') ?></a>
                        </div>
                        <?php if (st_social_channel_status('facebook') || st_social_channel_status('google') || st_social_channel_status('twitter') ): ?>
                            <div class="advanced">
                                <p class="text-center f14 c-grey"><?php echo esc_html__('or continue with', 'traveler') ?></p>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4">
                                        <?php if (st_social_channel_status('facebook')): ?>
                                            <a onclick="return false" href="#"
                                            class="btn_login_fb_link st_login_social_link" data-channel="facebook">
                                                <?php echo TravelHelper::getNewIcon('fb', '', '100%') ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-xs-12 col-sm-4">
                                        <?php if (st_social_channel_status('google')): ?>
                                            <a href="#" id="st-google-signin2"
                                            class="btn_login_gg_link st_login_social_link" data-channel="google">
                                                <?php echo TravelHelper::getNewIcon('g+', '', '100%') ?>
                                            </a>
                                            <!--<div id="st-google-signin2" class="btn_login_gg_link st_login_social_link"></div>-->
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-xs-12 col-sm-4">
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
                        <?php endif;?>
                        <div class="mt20 c-grey font-medium f14 text-center">
                            <?php echo esc_html__('Do not have an account? ', 'traveler') ?>
                            <a href="#"
                               class="st-link open-signup"
                               data-bs-toggle="modal"><?php echo esc_html__('Sign Up', 'traveler') ?></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="st-register-form" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="max-width: 520px;">
            <div class="modal-content relative">
                <?php echo st()->load_template('layouts/elementor/common/loader'); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <?php echo TravelHelper::getNewIcon('Ico_close') ?>
                    </button>
                    <div class="modal-title"><?php echo esc_html__('Sign Up', 'traveler') ?></div>
                </div>
                <div class="modal-body">
                    <form action="#" class="form" method="post">
                        <input type="hidden" name="st_theme_style" value="modern"/>
                        <input type="hidden" name="action" value="st_registration_popup">
                        <input type="hidden" name="post_id" value="<?php echo get_the_ID();?>">
                        <div class="form-group">
                            <input type="text" class="form-control" name="username" autocomplete="off"
                                   placeholder="<?php echo esc_html__('Username *', 'traveler') ?>">
                            <?php echo TravelHelper::getNewIcon('ico_username_form_signup', '', '20px', ''); ?>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="fullname" autocomplete="off"
                                   placeholder="<?php echo esc_html__('Full Name', 'traveler') ?>">
                            <?php echo TravelHelper::getNewIcon('ico_fullname_signup', '', '20px', ''); ?>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" autocomplete="off"
                                   placeholder="<?php echo esc_html__('Email *', 'traveler') ?>">
                            <?php echo TravelHelper::getNewIcon('ico_email_login_form', '', '18px', ''); ?>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" autocomplete="off"
                                   placeholder="<?php echo esc_html__('Password *', 'traveler') ?>">
                            <?php echo TravelHelper::getNewIcon('ico_pass_login_form', '', '16px', ''); ?>
                        </div>
                        <div class="form-group">
                            <p class="f14 c-grey"><?php echo esc_html__('Select User Type', 'traveler') ?></p>
                            <label class="block" for="normal-user">
                                <input checked id="normal-user" type="radio" class="mr5" name="register_as"
                                       value="normal"> <span class="c-main" data-bs-toggle="tooltip" data-placement="right"
                                                             title="<?php echo esc_html__('Used for booking services', 'traveler') ?>"><?php echo esc_html__('Normal User', 'traveler') ?></span>
                            </label>
                            <label class="block" for="partner-user">
                                <input id="partner-user" type="radio" class="mr5" name="register_as"
                                       value="partner">
                                <span class="c-main" data-bs-toggle="tooltip" data-placement="right"
                                      title="<?php echo esc_html__('Used for upload and booking services', 'traveler') ?>"><?php echo esc_html__('Partner User', 'traveler') ?></span>
                            </label>
                        </div>
                        <div class="form-group st-icheck-item">
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
                        <?php if (st_social_channel_status('facebook') || st_social_channel_status('google') || st_social_channel_status('twitter') ): ?>
                            <div class="advanced">
                                <p class="text-center f14 c-grey"><?php echo esc_html__('or continue with', 'traveler') ?></p>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4">
                                        <?php if (st_social_channel_status('facebook')): ?>
                                            <a onclick="return false" href="#"
                                            class="btn_login_fb_link st_login_social_link" data-channel="facebook">
                                                <?php echo TravelHelper::getNewIcon('fb', '', '100%') ?>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-xs-12 col-sm-4">
                                        <?php if (st_social_channel_status('google')): ?>
                                            <a href="#" id="st-google-signin3"
                                            class="btn_login_gg_link st_login_social_link" data-channel="google">
                                                <?php echo TravelHelper::getNewIcon('g+', '', '100%') ?>
                                            </a>
                                            <!--<div id="st-google-signin3" class="btn_login_gg_link st_login_social_link"></div>-->

                                        <?php endif; ?>
                                    </div>
                                    <div class="col-xs-12 col-sm-4">
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
                        <div class="mt20 c-grey f14 text-center">
                            <?php echo esc_html__('Already have an account? ', 'traveler') ?>
                            <a href="#" class="st-link open-login"
                               data-bs-toggle="modal"><?php echo esc_html__('Log In', 'traveler') ?></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php
echo st()->load_template('layouts/elementor/hotel/elements/popup/date');
echo st()->load_template('layouts/elementor/hotel/elements/popup/guest');
get_footer(); ?>
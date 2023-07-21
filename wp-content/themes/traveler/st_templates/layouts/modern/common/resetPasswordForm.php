<?php
if (!is_user_logged_in()) { ?>
    <div class="modal fade" id="st-forgot-form" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document" style="max-width: 450px;">
            <div class="modal-content">
                <?php echo st()->load_template('layouts/modern/common/loader'); ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <?php echo TravelHelper::getNewIcon('Ico_close') ?>
                    </button>
                    <div class="modal-title"><?php echo __('Reset Password', 'traveler') ?></div>
                </div>
                <div class="modal-body">
                    <form action="#" class="form" method="post">
                        <input type="hidden" name="st_theme_style" value="modern"/>
                        <input type="hidden" name="action" value="st_reset_password">
                        <p class="c-grey f14">
                            <?php echo __('Enter the e-mail address associated with the account.', 'traveler') ?>
                            <br/>
                            <?php echo __('We\'ll e-mail a link to reset your password.', 'traveler') ?>
                        </p>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email"
                                    placeholder="<?php echo esc_html__('Email', 'traveler') ?>">
                            <?php echo TravelHelper::getNewIcon('ico_email_login_form'); ?>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="form-submit"
                                    value="<?php echo esc_html__('Send Reset Link', 'traveler') ?>">
                        </div>
                        <div class="message-wrapper mt20"></div>
                        <div class="text-center mt20">
                            <a href="#" class="st-link font-medium open-login"
                                data-toggle="modal"><?php echo esc_html__('Back to Log In', 'traveler') ?></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
} ?>

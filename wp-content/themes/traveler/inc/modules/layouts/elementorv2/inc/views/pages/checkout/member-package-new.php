<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.3.1
 */
$userdata = get_userdata( get_current_user_id() );
?>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="form-group form-group-icon-left form-group-filled">                
                <label for="field-st_first_name"><?php echo __('First Name', 'traveler') ?><span class="require">*</span> </label>
                <i class="fa fa-user input-icon"></i>                
                <input class="form-control required" id="field-st_first_name" value="<?php echo !empty($userdata->first_name) ? STInput::post('st_first_name', $userdata->first_name) : ''; ?>" name="st_first_name" placeholder="<?php echo __('First Name', 'traveler') ?>" type="text">
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="form-group form-group-icon-left form-group-filled">                
                <label for="field-st_last_name"><?php echo __('Last Name', 'traveler') ?><span class="require">*</span> </label>
                <i class="fa fa-user input-icon"></i>                
                <input class="form-control required" id="field-st_last_name" value="<?php echo !empty($userdata->last_name) ? STInput::post('st_last_name', $userdata->last_name) : ''; ?>" name="st_last_name" placeholder="<?php echo __('Last Name', 'traveler') ?>" type="text">
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="form-group form-group-icon-left form-group-filled">                
                <label for="field-st_email"><?php echo __('Email', 'traveler') ?><span class="require">*</span> </label>
                <i class="fa fa-envelope input-icon"></i>                
                <input class="form-control required" id="field-st_email" value="<?php echo !empty($userdata->user_email) ? STInput::post('st_email', $userdata->user_email) : ''; ?>" name="st_email" placeholder="<?php echo __('Email', 'traveler') ?>" type="text">
            </div>
        </div>
        <div class="col-xs-12 col-sm-6">
            <div class="form-group form-group-icon-left form-group-filled">                
                <label for="field-st_phone"><?php echo __('Phone', 'traveler') ?><span class="require">*</span> </label>
                <i class="fa fa-phone input-icon"></i>                
                <input class="form-control required" id="field-st_phone" value="<?php echo STInput::post('st_phone', get_user_meta(get_current_user_id(), 'st_phone', true)); ?>" name="st_phone" placeholder="<?php echo __('Phone', 'traveler') ?>" type="text">
            </div>
        </div>
    </div>
    <?php if(defined('ICL_LANGUAGE_CODE') and ICL_LANGUAGE_CODE ): ?>
        <input type="hidden" name="lang" value="<?php echo esc_attr(ICL_LANGUAGE_CODE) ?>">
    <?php endif;?>

	<div class="payment-form">
        <h3 class="title"><?php echo __('Select Payment Method', 'traveler'); ?></h3>
        <?php
        if ( !isset( $post_id ) ) $post_id = false;
        STPaymentGateways::get_payment_gateways_package_html( $post_id, 'style-2') ?>
    </div>
	<div class="clearfix">
		<div class="row">
			<div class="col-sm-6">
				<?php if(st()->get_option('booking_enable_captcha','on')=='on'){
                    $st_site_key_captcha = st()->get_option( 'st_site_key_captcha', '6LdQ4fsUAAAAAOi1Y9yU4py-jx36gCN703stk9y1' );
					?>
					<input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                    <input type="hidden" name="action" value="st_checkout_package">
                    <script>
                        grecaptcha.ready(function () {
                            grecaptcha.execute('<?php echo esc_attr($st_site_key_captcha);?>', { action: 'st_checkout_package' }).then(function (token) {
                                var recaptchaResponse = document.getElementById('g-recaptcha-response');
                                recaptchaResponse.value = token;
                            });
                        });
                    </script>
				<?php } else { ?>
                    <input type="hidden" name="action" value="st_checkout_package">
                <?php }?>
			</div>
		</div>
	</div>
	<?php echo STCart::get_default_checkout_fields('st_check_term_conditions');?>
    <div class="alert form_alert hidden"></div>
    
    <div class="submit_payment">
        <input id="st_submit_member_package" type="submit" class="btn btn-primary btn-st-big" name="st_submit_member_package" value="<?php echo __('Submit', 'traveler'); ?>">
        <span class="stt-icon stt-icon-arrow-right-1"></span>
        <i class="fa fa-spinner fa-spin"></i>
    </div>
    <div class="mt20">
        <?php echo STTemplate::message(); ?>
    </div>
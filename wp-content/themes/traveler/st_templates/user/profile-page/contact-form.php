<?php
$message = st()->load_template('email/header');
echo balanceTags($message);
$id_page_send_admin_approved_withdrawal = st()->get_option('send_admin_approved_withdrawal', '');
$content = get_post($id_page_send_admin_approved_withdrawal);
$message .=  do_shortcode($content->post_content);
$message .= st()->load_template('email/footer');
?>
<div class="author-contact-form-wraper">
    <h4><?php echo __('Contact partner', 'traveler'); ?></h4>
    <form method="post" action="" enctype="multipart/form-data" class="author-contact-form">
        <input type="hidden" name="partner_email"
               value="<?php echo esc_attr($current_user->user_email); ?>"/>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group form-group-icon-left">
                    <label for="au_name"><?php echo __('Name', 'traveler'); ?></label><i
                            class="fa fa-user input-icon"></i>
                    <input name="au_name" class="form-control" value=""
                           type="text" placeholder="<?php echo __('Your name', 'traveler'); ?>">
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group form-group-icon-left">
                    <label for="au_email"><?php echo __('Email', 'traveler'); ?></label><i
                            class="fa fa-envelope input-icon"></i>
                    <input name="au_email" class="form-control" value=""
                           type="text" placeholder="<?php echo __('Your email', 'traveler'); ?>">
                </div>
            </div>
        </div>
        <div class="form-group form-group-icon-left">
            <label for="au_message"><?php echo __('Message', 'traveler'); ?></label>
            <textarea rows="10" class="form-control" name="au_message"></textarea>
        </div>
        <div id="author-message"></div>
        <input name="st_btn_update" type="submit" class="btn btn-primary"
               value="<?php echo __('Send Message', 'traveler'); ?>">
        <i class="fa fa-spinner fa-spin" style="display: none;"></i>
    </form>
</div>
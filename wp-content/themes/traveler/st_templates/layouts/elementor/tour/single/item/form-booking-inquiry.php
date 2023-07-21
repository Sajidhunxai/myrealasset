<div class="form-book-wrapper st-border-radius">
    <?php if (!empty($info_price['discount']) and $info_price['discount'] > 0 and $info_price['price_new'] > 0) { ?>
        <div class="tour-sale-box">
            <?php echo STFeatured::get_sale($info_price['discount']); ?>
        </div>
    <?php } ?>
    <?php echo st()->load_template('layouts/elementor/common/loader'); ?>
    <div class="form-head">
        <div class="price">
            <span class="label">
                <?php _e("from", 'traveler') ?>
            </span>
                    <span class="value">
                <?php
                echo STTour::get_price_html(get_the_ID());
                ?>
            </span>
        </div>
    </div>
    <h4 class="title-enquiry-form"><?php echo esc_html__('Inquiry', 'traveler'); ?></h4>
    <?php echo st()->load_template( 'email/email_single_service' ); ?>
    <form id="form-booking-inpage" method="post" action="#booking-request" class="tour-booking-form">
        <input type="hidden" name="action" value="tours_add_to_cart">
        <input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
        <input type="hidden" name="type_tour"
                value="<?php echo get_post_meta(get_the_ID(), 'type_tour', true) ?>">
        <input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID();?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
    </form>

</div>
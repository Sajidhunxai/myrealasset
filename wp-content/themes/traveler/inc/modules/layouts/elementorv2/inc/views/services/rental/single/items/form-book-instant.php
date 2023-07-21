<?php if(empty($room_external) || $room_external == 'off'){
    echo st()->load_template('layouts/elementor/common/loader'); ?>
    <div class="st-form-booking-action">
        <form id="form-booking-inpage" class="form single-room-form form-has-guest-name rental-booking-form" method="post">
            <div class="st-group-form">
                <input type="hidden" name="action" value="rental_add_cart">
                <input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
                <?php wp_nonce_field( 'room_search', 'room_search' ) ?>
                <input name="version_layout" value="elementor" type="hidden">
                <?php echo stt_elementorv2()->loadView('services/rental/single/items/form-book/date', ['booking_period'=>$booking_period , 'room_id'=>$room_id]); ?>
                <div class="form-date-search">
                    
                    <?php echo stt_elementorv2()->loadView('services/rental/single/items/form-book/guest'); ?>
                </div>
                <?php echo stt_elementorv2()->loadView('services/rental/single/items/form-book/guest-name'); ?>
            </div>
            
            <?php echo stt_elementorv2()->loadView('services/rental/single/items/form-book/extra'); ?>
            <div class="total-price-book d-flex justify-content-between align-items-center">
                <div id="total-text">
                    <h5><?php echo esc_html__('Total','traveler');?></h5>
                </div>
                <div id="total-value">
                    <div class="st-price-origin form-head d-flex align-self-end">
                        <h5>
                            <?php
                            echo wp_kses(sprintf(__(' <span class="price d-flex align-content-end flex-column">%s</span>', 'traveler'), TravelHelper::format_money( 0 )), ['span' => ['class' => []]]); ?>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="submit-group">
                <button class="text-center btn-v2 btn-primary btn-book-ajax"
                        type="submit"
                        name="submit"><?php echo esc_html__('Book now', 'traveler') ?><i class="fa fa-spinner fa-spin d-none"></i></button>
                <input style="display:none;" type="submit"
                        class="btn btn-default btn-send-message"
                        data-id="<?php echo get_the_ID(); ?>" name="st_send_message"
                        value="<?php echo __('Send message', 'traveler'); ?>">
            </div>
            <div class="message-wrapper mt30"></div>
        </form>
    </div>
<?php } else {?>
    <div class="submit-group mb30">
        <a href="<?php echo esc_url($room_external_link); ?>" class="btn btn-green btn-large btn-full upper"><?php echo esc_html__( 'Explore', 'traveler' ); ?></a>
        <form id="form-booking-inpage" class="form single-room-form form-has-guest-name rental-booking-form" method="post">
            <input type="hidden" name="action" value="rental_add_cart">
            <input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
            <?php wp_nonce_field( 'room_search', 'room_search' ) ?>
            <input name="version_layout" value="elementor" type="hidden">
            <input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID();?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
        </form>
    </div>
<?php }
?>
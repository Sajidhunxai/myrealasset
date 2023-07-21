<?php if(empty($tour_external) || $tour_external == 'off'){ ?>
<?php echo st()->load_template('layouts/elementor/common/loader'); ?>
    <div class="st-form-booking-action">
        <form id="form-booking-inpage" method="post" action="#booking-request" class="tour-booking-form form-has-guest-name">
            <div class="st-group-form">
                <input type="hidden" name="action" value="tours_add_to_cart">
                <input type="hidden" name="item_id" value="<?php echo get_the_ID(); ?>">
                <input type="hidden" name="type_tour"
                        value="<?php echo get_post_meta(get_the_ID(), 'type_tour', true) ?>">
                        
                <div class="form-date-search search-form">
                    <?php echo stt_elementorv2()->loadView('services/tour/single/item/form-book/date'); ?>
                    <?php echo stt_elementorv2()->loadView('services/tour/single/item/form-book/guest'); ?>
                    <?php echo stt_elementorv2()->loadView('services/tour/single/item/form-book/package'); ?>
                </div>
                <?php echo stt_elementorv2()->loadView('services/common/single/guest-name'); ?>
            </div>
            
            <?php echo stt_elementorv2()->loadView('services/tour/single/item/form-book/extra'); ?>
            <div class="total-price-book d-flex justify-content-between align-items-center">
                <div id="total-text">
                    <h5><?php echo esc_html__('Total','traveler');?></h5>
                </div>
                <div id="total-value">
                    <div class="st-price-origin form-head d-flex align-self-end">
                        <h5>
                            
                            <?php
                             echo wp_kses(sprintf(__(' <span class="price d-flex align-content-end flex-column">%s</span>', 'traveler'), STTour::get_price_html(get_the_ID())), ['span' => ['class' => []]]);
                            ?>
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
        <a href="<?php echo esc_url($tour_external_link); ?>" class="btn btn-green btn-large btn-full upper"><?php echo esc_html__( 'Explore', 'traveler' ); ?></a>
    </div>
<?php }?>
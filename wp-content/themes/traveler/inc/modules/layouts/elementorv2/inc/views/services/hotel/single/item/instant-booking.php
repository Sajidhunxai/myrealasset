<div class="tab-pane fade show active" id="nav-book" role="tabpanel"
        aria-labelledby="nav-book-tab">
    <div class="st-form-head-book d-flex justify-content-between align-items-center">
        <div class="st-price-origin">
            <?php
            if(STHotel::is_show_min_price()):
                _e("from", 'traveler');
            else:
                _e("avg", 'traveler');
            endif;?>
            
            <?php echo wp_kses(sprintf(__(' <span class="price">%s</span> <span class="unit"> / night</span>', 'traveler'), TravelHelper::format_money($price)), ['span' => ['class' => []]]) ?>
        </div>
        
        <?php if (comments_open() and st()->get_option('hotel_review') == 'on') { ?>
            <div class="st-review-booking-form">
                <div class="st-review-box-top d-flex align-items-center">
                    <i class="stt-icon-star1"></i>
                    <?php
                    $count_review = get_comment_count($post_id)['approved'];
                    $avg = STReview::get_avg_rate();
                    ?>
                    <div class="review-score">
                        <?php echo esc_attr($avg); ?>
                    </div>
                    <div class="review-score-base text-center">
                        <span>(<?php comments_number(__('0 review', 'traveler'), __('1 review', 'traveler'), __('% reviews', 'traveler')); ?>)</span>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>
    <?php echo st()->load_template('layouts/elementor/common/loader'); ?>
    <div class="st-form-booking-action">
        <form class="form form-check-availability-hotel">
            <div class="st-group-form">
                <input type="hidden" name="action" value="ajax_search_room">
                <input type="hidden" name="room_search" value="1">
                <input type="hidden" name="is_search_room" value="1">
                <input type="hidden" name="room_parent"
                        value="<?php echo esc_attr(get_the_ID()); ?>">
                <?php echo st()->load_template('layouts/elementor/hotel/elements/search/date-inquiry', ''); ?>
                <div class="search-form">
                    <?php echo stt_elementorv2()->loadView('services/hotel/search-form/guest', ['has_icon' => false]); ?>
                </div>
                
            </div>
            
            <div class="submit-group">
                <button class="text-center btn-v2 btn-primary"
                        type="submit"
                        name="submit"><?php echo esc_html__('Check availability', 'traveler') ?></button>
                <input style="display:none;" type="submit"
                        class="btn btn-default btn-send-message"
                        data-id="<?php echo get_the_ID(); ?>" name="st_send_message"
                        value="<?php echo __('Send message', 'traveler'); ?>">
            </div>
            <div class="message-wrapper mt30"></div>
        </form>
    </div>
    
</div>
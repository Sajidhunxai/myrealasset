<div class="st-form-book-wrapper relative">
    <div class="close-icon hide">
        <i class="stt-icon-close"></i>
    </div>
    <div class="form-booking-price">
        <div class="st-form-head-book st-service-header2 d-flex justify-content-between align-items-center">
            <div class="st-price-origin d-flex align-self-end">
                <?php if (!empty($price) and $price > 0 && $orgin_price > 0) { 
                    $orgin_price = $price;
                 } ?>
                <span class="st-unit align-self-end">
                    <?php echo __("From:", 'traveler');?>
                </span>
                <?php
                $text_day = ($number_day > 1 )? sprintf(__('<span class="fw-normal"> / %s nights</span>', 'traveler'), $number_day): '';
                
                echo wp_kses(sprintf(__(' <span class="price d-flex align-content-end flex-column">%s </span>%s', 'traveler'), TravelHelper::format_money($orgin_price),$text_day), ['span' => ['class' => []]]); ?>
            </div>
            <?php if (comments_open() && st()->get_option('rental_review') == 'on') { ?>
                <div class="st-review-score" itemscope itemtype="https://schema.org/Rating">
                    <div class="head d-flex justify-content-between align-items-center clearfix">
                        <div class="left">
                            <div class="reviews" itemprop="starRating" >
                                <i class="stt-icon-star1"></i>
                                <span class="rate" itemprop="ratingValue">
                                    <?php echo esc_html($review_rate); ?>
                                </span>
                                <span class="summary">
                                    (<?php comments_number(esc_html__('No Review', 'traveler'), esc_html__('1 Review', 'traveler'), get_comments_number() . ' ' . esc_html__('Reviews', 'traveler')); ?>)
                                </span>
                            </div>
                        </div>
                        
                    </div>
                </div>
            <?php }?>
        </div>
        
    </div>
    <?php
    
    if($booking_type == 'instant_enquire') { ?>
        <div class="st-wrapper-form-booking <?php echo esc_attr($booking_type);?>">
            <nav>
                <ul class="nav nav-tabs d-flex align-items-center justify-content-between nav-fill-st" id="nav-tab"
                    role="tablist">
                    <li><a class="active text-center" id="nav-book-tab" data-bs-toggle="tab" data-bs-target="#nav-book"
                        role="tab" aria-controls="nav-home"
                        aria-selected="true"><?php echo esc_html__('Book', 'traveler') ?></a>
                    </li>
                    <li><a class="text-center" id="nav-inquirement-tab" data-bs-toggle="tab"
                        data-bs-target="#nav-inquirement"
                        role="tab" aria-controls="nav-profile"
                        aria-selected="false"><?php echo esc_html__('Inquiry', 'traveler') ?></a>
                    </li>
                </ul>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-book" role="tabpanel"
                    aria-labelledby="nav-book-tab">
                    <?php
                    echo stt_elementorv2()->loadView('services/rental/single/items/form-book-instant', [
                        'price' => $price,
                        'room_id' => $room_id,
                        'room_external' => $room_external,
                        'room_external_link' => $room_external_link,
                        'booking_period' => $booking_period,
                        'number_day' => $number_day,
                        'booking_type' => $booking_type,
                        'review_rate' => $review_rate,
                        'count_review' => $count_review,
                    ]);
                    ?>
                </div>

                <div class="tab-pane fade " id="nav-inquirement" role="tabpanel"
                    aria-labelledby="nav-inquirement-tab">
                    <div class="inquiry-v2">
                        <?php echo st()->load_template('email/email_single_service'); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } elseif($booking_type == 'enquire') { ?>
        <div class="inquiry-v2">
            <?php echo st()->load_template('email/email_single_service'); ?>
        </div>
    <?php } else {
        echo stt_elementorv2()->loadView('services/rental/single/items/form-book-instant', [
            'price' => $price,
            'room_id' => $room_id,
            'room_external' => $room_external,
            'room_external_link' => $room_external_link,
            'booking_period' => $booking_period,
            'number_day' => $number_day,
            'booking_type' => $booking_type,
            'review_rate' => $review_rate,
            'count_review' => $count_review,
        ]);

    } ?>
</div>
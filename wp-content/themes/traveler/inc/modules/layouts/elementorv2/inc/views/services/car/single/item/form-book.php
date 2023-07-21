<div class="st-form-book-wrapper relative">
    <div class="form-booking-price">
        <div class="st-form-head-book st-service-header2 d-flex justify-content-between align-items-center">
            <div class="st-price-origin d-flex align-self-end">
                <?php if (!empty($info_price['discount']) and $info_price['discount'] > 0 and $info_price['price'] > 0) { ?>
                    <div class="tour-sale-box">
                        <?php echo STFeatured::get_sale($info_price['discount']); ?>
                    </div>
                <?php } ?>
                <span class="st-unit align-self-end">
                    <?php echo __("From:", 'traveler');?>
                </span>
                <?php echo wp_kses(sprintf(__('<span class="price d-flex align-content-end"><span class="price">%s</span><span class="unit">/%s</span></span>', 'traveler'), TravelHelper::format_money($info_price['price']), strtolower(STCars::get_price_unit('label'))), ['span' => ['class' => []]]) ?>
            </div>
            <?php if (comments_open() && st()->get_option('car_review') == 'on') { ?>
                <div class="st-review-score" itemscope itemtype="https://schema.org/Rating">
                    <div class="head d-flex justify-content-between align-items-center clearfix">
                        <div class="left">
                            <div class="reviews" itemprop="starRating">
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
    <?php if($booking_type == 'instant_enquire') { ?>
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
                echo stt_elementorv2()->loadView('services/car/single/item/form-booking-instant', [
                    'info_price' =>$info_price,
                    'car_external' => $car_external,
                    'car_external_link' => $car_external_link,
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
        echo stt_elementorv2()->loadView('services/car/single/item/form-booking-instant', [
            'info_price' =>$info_price,
            'car_external' => $car_external,
            'car_external_link' => $car_external_link,
        ]);

    } ?>
</div>
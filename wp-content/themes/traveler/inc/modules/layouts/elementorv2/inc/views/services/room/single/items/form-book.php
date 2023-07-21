<div class="st-form-book-wrapper relative">
    <div class="form-booking-price">
        <?php
        if ($price_by_per_person == 'on') :
            echo __('From: ', 'traveler');
            echo sprintf('<span class="price">%s</span>', TravelHelper::format_money($sale_price));
            echo '<span class="unit">';
            echo sprintf(_n('/ person', '/ %d persons', $total_person, 'traveler'), $total_person);
            echo sprintf(_n('/ night', '/ %d nights', $numberday, 'traveler'), $numberday);
            echo '</span>';
        else:
            echo __('from ', 'traveler');
            echo sprintf('<span class="price">%s</span>', TravelHelper::format_money($sale_price));
            echo '<span class="unit">';
            echo sprintf(_n('/ night', '/ %d nights', $numberday, 'traveler'), $numberday);
            echo '</span>';
        endif; ?>
    </div>
    <?php if($booking_type == 'instant_enquire') { ?>
    <div class="st-wrapper-form-booking">
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
                echo stt_elementorv2()->loadView('services/room/single/items/form-book-instant', [
                    'price_by_per_person' => $price_by_per_person,
                    'sale_price' => $sale_price,
                    'numberday' => $numberday,
                    'hotel_id' => $hotel_id,
                    'room_id' => $room_id,
                    'room_external' => $room_external,
                    'room_external_link' => $room_external_link,
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

        echo stt_elementorv2()->loadView('services/room/single/items/form-book-instant', [
            'price_by_per_person' => $price_by_per_person,
            'sale_price' => $sale_price,
            'numberday' => $numberday,
            'hotel_id' => $hotel_id,
            'room_id' => $room_id,
            'room_external' => $room_external,
            'room_external_link' => $room_external_link,
        ]);

    } ?>
</div>
<div class="form-book-wrapper st-border-radius relative">
    <div class="form-head st-border-radius">
        <?php
        if(STHotel::is_show_min_price()):
            _e("from", 'traveler');
        else:
            _e("avg", 'traveler');
        endif;?>
        <?php echo wp_kses(sprintf(__(' <span class="price">%s</span> <span class="unit"> /night</span>', 'traveler'), TravelHelper::format_money($price)), ['span' => ['class' => []]]) ?>
    </div>
    <nav>
        <ul class="nav nav-tabs d-flex align-items-center nav-fill-st" id="nav-tab" role="tablist">
            <li><a class="active" id="nav-book-tab" data-bs-toggle="tab" data-bs-target="#nav-book"
                                    role="tab" aria-controls="nav-home"
                                    aria-selected="true"><?php echo esc_html__('Book', 'traveler') ?></a>
            </li>
            <li><a id="nav-inquirement-tab" data-bs-toggle="tab" data-bs-target="#nav-inquirement"
                    role="tab" aria-controls="nav-profile"
                    aria-selected="false"><?php echo esc_html__('Inquiry', 'traveler') ?></a>
            </li>
        </ul>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <?php echo st()->load_template('layouts/elementor/hotel/single/item/instant-booking', ''); ?>
        <div class="tab-pane fade " id="nav-inquirement" role="tabpanel"
                aria-labelledby="nav-inquirement-tab">
            <?php echo st()->load_template('email/email_single_service'); ?>
        </div>
    </div>

</div>
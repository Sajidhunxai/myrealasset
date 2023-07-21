<div class="st-form-book-wrapper relative">
    <div class="close-icon hide">
        <i class="stt-icon-close"></i>
    </div>
    <div class="st-wrapper-form-booking form-date-search">
        <nav>
            <ul class="nav nav-tabs d-flex align-items-center justify-content-between nav-fill-st" id="nav-tab" role="tablist">
                <li><a class="active text-center" id="nav-book-tab" data-bs-toggle="tab" data-bs-target="#nav-book"
                                        role="tab" aria-controls="nav-home"
                                        aria-selected="true"><?php echo esc_html__('Book', 'traveler') ?></a>
                </li>
                <li><a class="text-center" id="nav-inquirement-tab" data-bs-toggle="tab" data-bs-target="#nav-inquirement"
                        role="tab" aria-controls="nav-profile"
                        aria-selected="false"><?php echo esc_html__('Inquiry', 'traveler') ?></a>
                </li>
            </ul>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <?php 
                echo stt_elementorv2()->loadView('services/hotel/single/item/instant-booking', array('price' => $price, 'post_id' => $post_id )); ?>
            <div class="tab-pane fade " id="nav-inquirement" role="tabpanel"
                    aria-labelledby="nav-inquirement-tab">
                    <div class="inquiry-v2">
                        <?php echo st()->load_template('email/email_single_service'); ?>
                    </div>
                
            </div>
        </div>
    </div>
    

</div>
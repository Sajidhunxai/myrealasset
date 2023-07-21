<div class="st-hr"></div>
<div class="st-section-single" id="st-list-room">
    <h2 class="st-heading-section">
        <?php echo esc_html__('Availability', 'traveler') ?>
    </h2>
    <?php if(isset($has_form_search)){?>
        <div class="fixed-on-mobile st-fixed-form-booking" data-screen="992px">
            <div class="close-icon hide">
                <?php echo TravelHelper::getNewIcon('Ico_close'); ?>
            </div>
            <?php echo stt_elementorv2()->loadView('services/hotel/single/item/form-book-2',['price' => $price, 'post_id' => $post_id]); ?>
           
        </div>
    <?php }?>
    <div class="st-list-rooms relative">
        <?php echo st()->load_template('layouts/modern/common/loader'); ?>
        <div class="fetch">
            <?php
            global $post;
            $hotel = new STHotel();
            $query = $hotel->search_room();
            while ($query->have_posts()) {
                $query->the_post();
                echo stt_elementorv2()->loadView('services/hotel/loop/room_item');
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>
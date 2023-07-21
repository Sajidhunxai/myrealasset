<div class="accordion-item">
    <h2 class="st-heading-section" id="headingRooms">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRooms" aria-expanded="true" aria-controls="collapseRooms">
            <?php echo esc_html__('Room', 'traveler') ?>
        </button>
    </h2>
    <div id="collapseRooms" class="accordion-collapse collapse show" aria-labelledby="headingRooms" data-bs-parent="#headingRooms">
        <div class="accordion-body">
            <div class="st-list-rooms relative" data-toggle-section="st-list-rooms">
                <?php echo st()->load_template('layouts/modern/common/loader'); ?>
                <div class="fetch">
                    <?php
                    global $post;
                    $hotel = new STHotel();
                    $query = $hotel->search_room();
                    while ($query->have_posts()) {
                        $query->the_post();
                        echo st()->load_template('layouts/elementor/hotel/loop/room_item');
                    }
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
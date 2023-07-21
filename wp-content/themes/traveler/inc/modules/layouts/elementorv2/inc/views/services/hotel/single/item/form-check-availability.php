<div class="search-form st-border-radius">
    <form class="form form-check-availability-hotel form d-flex align-items-center">
        <input type="hidden" name="action" value="ajax_search_room">
        <input type="hidden" name="room_search" value="1">
        <input type="hidden" name="is_search_room" value="1">
        <input type="hidden" name="room_parent"
                value="<?php echo esc_attr(get_the_ID()); ?>">
        <?php
        echo stt_elementorv2()->loadView('services/hotel/search-form/date');
        echo stt_elementorv2()->loadView('services/hotel/search-form/guest', ['has_icon' => true]);
        ?>
        <div class="button-search-wrapper">
            <button class="btn btn-primary btn-search" type="submit"
                        name="submit">
                <span class="stt-icon stt-icon-search"></span>
                <?php echo esc_html__('Search', 'traveler'); ?>
            </button>
        </div>
    </form>
</div>

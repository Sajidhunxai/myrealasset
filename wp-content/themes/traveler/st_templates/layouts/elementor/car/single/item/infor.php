<div class="st-service-feature">
    <div class="row">
        <div class="col-6 col-md-3">
            <div class="item d-flex align-items-center">
                <div class="icon">
                    <?php
                    $fee_cancellation = get_post_meta(get_the_ID(), 'fee_cancellation', true);
                    if ($fee_cancellation == 'on') {
                        echo TravelHelper::getNewIcon('check-1', '#5191FA', '16px', '16px');
                    } else {
                        echo TravelHelper::getNewIcon('remove', '#FA5636', '18px', '18px');
                    }
                    ?>
                </div>
                <div class="info">
                    <div class="name"><?php echo __('Free Cancellation', 'traveler'); ?></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="item d-flex align-items-center">
                <div class="icon">
                    <?php
                    $pay_at_pick_up = get_post_meta(get_the_ID(), 'pay_at_pick_up', true);
                    if ($pay_at_pick_up == 'on') {
                        echo TravelHelper::getNewIcon('check-1', '#5191FA', '16px', '16px');
                    } else {
                        echo TravelHelper::getNewIcon('remove', '#FA5636', '18px', '18px');
                    }
                    ?>
                </div>
                <div class="info">
                    <div class="name"><?php echo __('Pay at Pickup', 'traveler'); ?></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="item d-flex align-items-center">
                <div class="icon">
                    <?php
                    $unlimited_mileage = get_post_meta(get_the_ID(), 'unlimited_mileage', true);
                    if ($unlimited_mileage == 'on') {
                        echo TravelHelper::getNewIcon('check-1', '#5191FA', '16px', '16px');
                    } else {
                        echo TravelHelper::getNewIcon('remove', '#FA5636', '18px', '18px');
                    }
                    ?>
                </div>
                <div class="info">
                    <div class="name"><?php echo __('Unlimited Mileage', 'traveler'); ?></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="item d-flex align-items-center">
                <div class="icon">
                    <?php
                    $shuttle_to_car = get_post_meta(get_the_ID(), 'shuttle_to_car', true);
                    if ($shuttle_to_car == 'on') {
                        echo TravelHelper::getNewIcon('check-1', '#5191FA', '16px', '16px');
                    } else {
                        echo TravelHelper::getNewIcon('remove', '#FA5636', '18px', '18px');
                    }
                    ?>
                </div>
                <div class="info">
                    <div class="name"><?php echo __('Shuttle to Car', 'traveler'); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

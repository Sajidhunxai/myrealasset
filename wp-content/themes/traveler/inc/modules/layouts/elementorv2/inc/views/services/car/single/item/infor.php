<?php 
$icon_infor = apply_filters('stt-icon_infor_car', '<i class="stt-icon-check"></i>');
$icon_off = apply_filters('stt-icon_infor_off_car', '<i class="stt-icon-close"></i>');
?>
<!--Tour Info-->
<div class="st-service-feature">
    <div class="row">
        <div class="col-6 col-sm-3">
            <div class="item d-flex align-items-lg-center">
                
                    <?php
                        $fee_cancellation = get_post_meta(get_the_ID(), 'fee_cancellation', true);
                        if ($fee_cancellation == 'on') {?>
                            <div class="icon">
                            <?php echo htmlspecialchars_decode($icon_infor); ?>
                            </div>
                        <?php } else {?>
                            <div class="icon stt-off ">
                            <?php echo htmlspecialchars_decode($icon_off); ?>
                            </div>
                        <?php } ?>
                    
                
                <div class="info">
                    <div class="name"><?php echo __('Free Cancellation', 'traveler'); ?></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="item d-flex align-items-lg-center">
                <?php
                $pay_at_pick_up = get_post_meta(get_the_ID(), 'pay_at_pick_up', true);
                if ($pay_at_pick_up == 'on') {?>
                    <div class="icon">
                    <?php echo htmlspecialchars_decode($icon_infor); ?>
                    </div>
                <?php } else {?>
                    <div class="icon stt-off ">
                    <?php echo htmlspecialchars_decode($icon_off); ?>
                    </div>
                <?php } ?>
                <div class="info">
                    <div class="name"><?php echo __('Pay at Pickup', 'traveler'); ?></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="item d-flex align-items-lg-center">
                <?php
                    $unlimited_mileage = get_post_meta(get_the_ID(), 'unlimited_mileage', true);
                    if ($unlimited_mileage == 'on') {?>
                        <div class="icon">
                        <?php echo htmlspecialchars_decode($icon_infor); ?>
                        </div>
                    <?php } else {?>
                        <div class="icon stt-off ">
                        <?php echo htmlspecialchars_decode($icon_off); ?>
                        </div>
                <?php } ?>
                <div class="info">
                    <div class="name"><?php echo __('Unlimited Mileage', 'traveler'); ?></div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="item d-flex align-items-lg-center">
                <?php
                $shuttle_to_car = get_post_meta(get_the_ID(), 'shuttle_to_car', true);
                if ($shuttle_to_car == 'on') {?>
                    <div class="icon">
                    <?php echo htmlspecialchars_decode($icon_infor); ?>
                    </div>
                <?php } else {?>
                    <div class="icon stt-off ">
                    <?php echo htmlspecialchars_decode($icon_off); ?>
                    </div>
                <?php } ?>
                <div class="info">
                    <div class="name"><?php echo __('Shuttle to Car', 'traveler'); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Tour info-->
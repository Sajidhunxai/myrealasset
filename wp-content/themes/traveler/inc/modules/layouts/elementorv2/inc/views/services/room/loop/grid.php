<?php
$room_id = TravelHelper::post_translated(get_the_ID());
$url = get_the_permalink();
?>
<div class="room-item">
    <div class="thumbnail">
        <a href="<?php echo esc_url($url) ?>">
            <img src="<?php echo get_the_post_thumbnail_url(null, [800,600]) ?>" alt="" class="img-fluid img-full st-hover-grow">
        </a>
    </div>
    <div class="content">
        <h3 class="name">
            <a href="<?php echo esc_url($url) ?>" class="">
                <?php echo esc_html(get_the_title($room_id)); ?>
            </a>
        </h3>
        <div class="facilities">

            <?php if ( $room_footage = get_post_meta( $room_id, 'room_footage', true ) ): ?>
                <p class="item">
                    <span class="stt-icon stt-icon-area"></span>
                    <span class="text"><?php echo sprintf(esc_html__('S: %s', 'traveler'), $room_footage); ?><?php echo __('m<sup>2</sup>', 'traveler');?></span>
                </p>
            <?php endif; ?>

            <?php if ( $bed = get_post_meta( $room_id, 'bed_number', true ) ): ?>
                <p class="item">
                    <span class="stt-icon stt-icon-bed"></span>
                    <span class="text"><?php echo sprintf(esc_html__('Beds: %s', 'traveler'), $bed) ?></span>
                </p>
            <?php endif; ?>

            <?php if ( $adult = (int)get_post_meta( $room_id, 'adult_number', true ) ): ?>
                <p class="item">
                    <span class="stt-icon stt-icon-adult"></span>
                    <span class="text"><?php echo sprintf(esc_html__('Adults: %s', 'traveler'), $adult) ?></span>
                </p>
            <?php endif; ?>

            <?php if ( $child = (int)get_post_meta( $room_id, 'children_number', true ) ): ?>
                <p class="item">
                    <span class="stt-icon stt-icon-baby"></span>
                    <span class="text"><?php echo sprintf(esc_html__('Child: %s', 'traveler'), $child) ?></span>
                </p>
            <?php endif; ?>

        </div>

        <?php
        $discount_rate = floatval(get_post_meta($room_id,'discount_rate',true));
        $discount_type_total = get_post_meta( $room_id, 'discount_type', true);
        if($discount_rate < 0) $discount_rate = 0;
        if($discount_rate > 100) $discount_rate = 100;

        $price_ori = $sale_price = 0;

        $price_by_per_person = get_post_meta( $room_id, 'price_by_per_person', true );
        if ( $price_by_per_person == 'on' ) {
            $adult_price = floatval( get_post_meta( $room_id, 'adult_price', true ) );
            $child_price = floatval( get_post_meta( $room_id, 'child_price', true ) );
            $price_ori = $adult_price + $child_price ;
        } else {
            $price_ori = floatval(get_post_meta($room_id, 'price', true));
        }
        if($price_ori < 0) $price_ori = 0;

        if($discount_rate){
            if($discount_type_total == 'amount') {
                $sale_price = $price_ori - $discount_rate;
                if($sale_price < 0) $sale_price = 0;
            }else{
                $sale_price = $price_ori - ($price_ori * ($discount_rate / 100));
            }
        }

        echo '<div class="price-wrapper">';
        if(!empty($sale_price)){
            echo '<div class="onsale">'. TravelHelper::format_money($price_ori) .'</div>';
            if($price_by_per_person == 'on')
                echo '<div class="price">'. TravelHelper::format_money($sale_price) . '<span class="unit">'. esc_html__('/ person', 'traveler') .'</span>'  .'</div>';
            else
                echo '<div class="price">'. TravelHelper::format_money($sale_price) . '<span class="unit">'. esc_html__('/ night', 'traveler') .'</span>'  .'</div>';
        }else{
            if($price_by_per_person == 'on')
                echo '<div class="price">'. TravelHelper::format_money($price_ori) . '<span class="unit">'. esc_html__('/ person', 'traveler') .'</span>'  .'</div>';
            else
                echo '<div class="price">'. TravelHelper::format_money($price_ori) . '<span class="unit">'. esc_html__('/ night', 'traveler') .'</span>'  .'</div>';
        }
        echo '</div>';

        ?>
        <a href="<?php echo esc_url($url); ?>" class="btn-show-price">
            <?php echo esc_html__( 'Room Detail', 'traveler' ) ?>
        </a>

    </div>
</div>
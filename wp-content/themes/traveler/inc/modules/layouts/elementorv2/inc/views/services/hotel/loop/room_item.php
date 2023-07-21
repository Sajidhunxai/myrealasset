<?php
    $room_id = get_the_ID();
    $room_id = TravelHelper::post_translated($room_id);
    $item_id = get_post_meta( $room_id, 'room_parent', true );
    if ( empty( $item_id ) ) {
        $item_id = $room_id;
    }
    $get_data = array();
    $get_data['start'] =  STInput::request( 'start' );
    $get_data['end'] =     STInput::request( 'end' );
    $get_data['date'] =     STInput::request( 'date' );
    $get_data['room_num_search'] =     STInput::request( 'room_num_search' );
    $get_data['adult_number'] =     STInput::request( 'adult_number' );
    $get_data['child_number'] =     STInput::request( 'child_number' );

    $link_with_params = add_query_arg($get_data, get_the_permalink());
?>
<div class="item st-border-radius">
    <form class="form-booking-inpage" method="get">
        <input type="hidden" name="check_in" value="<?php echo STInput::request( 'start' ); ?>"/>
        <input type="hidden" name="check_out" value="<?php echo STInput::request( 'end' ); ?>"/>
        <input type="hidden" name="room_num_search" value="<?php echo STInput::request( 'room_num_search' ); ?>"/>
        <input type="hidden" name="adult_number" value="<?php echo STInput::request( 'adult_number' ); ?>"/>
        <input type="hidden" name="child_number" value="<?php echo STInput::request( 'child_number' ); ?>"/>
        <input name="action" value="hotel_add_to_cart" type="hidden">
        <input name="item_id" value="<?php echo esc_attr($item_id); ?>" type="hidden">
        <input name="room_id" value="<?php echo esc_attr($room_id); ?>" type="hidden">
        <input type="hidden" name="start" value="<?php echo STInput::request( 'start' ); ?>"/>
        <input type="hidden" name="end" value="<?php echo STInput::request( 'end' ); ?>"/>
        <input type="hidden" name="is_search_room" value="<?php echo STInput::request( 'is_search_room' ); ?>">
        <div class="row align-items-center align-items-stretch">
            <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                <div class="image">
                    <img src="<?php echo get_the_post_thumbnail_url(null, [800,600]) ?>" alt="" class="img-fluid img-full st-hover-grow">
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-8">
                <div class="row align-items-center">
                    <div class="col-12 col-md-12 col-lg-7">
                        <div class="item-infor">
                            <div class="st-border-right">
                                <h2 class="heading">
                                    <a href="<?php echo esc_url($link_with_params) ?>" class="heading-title">
                                        <?php echo get_the_title($room_id); ?>
                                    </a>
                                </h2>
                                <div class="facilities">
                                    <div class="st-list-facilities">
                                        <?php if ( $room_footage = get_post_meta( $room_id, 'room_footage', true ) ): ?>
                                            <p class="item text-center" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" data-toggle="tooltip" data-placement="top" title="<?php echo __('Room Footage', 'traveler') ?>">
                                                <span class="item-box">
                                                    <i class="stt-icon-area"></i>
                                                </span>
                                                <br/>
                                                <span class="infor"><?php echo esc_attr( $room_footage ); ?><?php echo __('m<sup>2</sup>', 'traveler');?></span>
                                            </p>
                                        <?php endif; ?>
                                        <?php if ( $bed = get_post_meta( $room_id, 'bed_number', true ) ): ?>
                                            <p class="item text-center" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" data-toggle="tooltip" data-placement="top" title="<?php echo __('No. Beds', 'traveler') ?>">
                                                <span class="item-box">
                                                    <i class="stt-icon-bed"></i>
                                                </span>
                                                <br/>
                                                <span class="infor">x<?php echo esc_attr( $bed ); ?></span>
                                            </p>
                                        <?php endif; ?>
                                        <?php if ( $adult = (int)get_post_meta( $room_id, 'adult_number', true ) ): ?>
                                            <p class="item text-center" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" data-toggle="tooltip" data-placement="top" title="<?php echo __('No. Adults', 'traveler') ?>">
                                                <span class="item-box">
                                                    <i class="stt-icon-adult"></i>
                                                </span>
                                                <br/>
                                                <span class="infor">x<?php echo( $adult ); ?></span>
                                            </p>
                                        <?php endif; ?>
                                        <?php if ( $child = (int)get_post_meta( $room_id, 'children_number', true ) ): ?>
                                            <p class="item text-center" data-bs-html="true" data-bs-toggle="tooltip" data-bs-placement="top" data-toggle="tooltip" data-placement="top" title="<?php echo __('No. Children', 'traveler') ?>">
                                                <span class="item-box">
                                                    <i class="stt-icon-baby"></i>
                                                </span>    
                                            
                                                <br/>
                                                <span class="infor">x<?php echo( $child ); ?></span>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="col-12 col-md-12 col-lg-5">
                        <?php
                            $start = TravelHelper::convertDateFormat( STInput::request( 'start' ) );
                            $end   = TravelHelper::convertDateFormat( STInput::request( 'end' ) );
                            if ( $start && $end ) {
                                $numberday       = STDate::dateDiff( $start, $end );
                                $is_search_room  = STInput::request( 'is_search_room' );
                                $room_num_search = intval( STInput::request( 'room_num_search', 1 ) );
                                $adult_number = STInput::request( 'adult_number', 1 );
                                $child_number = STInput::request( 'child_number', '' );
                                $price_by_per_person = get_post_meta( $room_id, 'price_by_per_person', true );
                                $sale_price      = STPrice::getRoomPrice( $room_id, strtotime( $start ), strtotime( $end ), $room_num_search, $adult_number, $child_number );
                                $total_price     = STPrice::getRoomPriceOnlyCustomPrice( $room_id, strtotime( $start ), strtotime( $end ), $room_num_search, $adult_number, $child_number );
                                $total_person = intval( $adult_number ) + intval( $child_number );
                                ?>
                                <div class="price-wrapper">
                                    <span class="price"><?php echo TravelHelper::format_money( $sale_price ) ?></span>
                                    <span class="unit">
                                        <?php
                                        if ( isset( $price_by_per_person ) && $price_by_per_person == 'on' ) {
                                            echo sprintf( _n( '/person', '/%d persons', $total_person, 'traveler' ), $total_person );
                                            echo sprintf( _n( '/night', '/%d nights', $numberday, 'traveler' ), $numberday );
                                        } else {
                                            echo sprintf( _n( '/night', '/%s nights', $numberday , 'traveler'), $numberday );
                                        }
                                        ?>
                                    </span>
                                </div>
                                <a href="<?php echo esc_url($link_with_params); ?>" target="_blank"
                                   class="show-detail btn-v2 btn-primary">
                                    <?php echo esc_html__( 'Room Detail', 'traveler' ) ?>
                                </a>
                            <?php } else {
                                ?>
                                <a href="#"
                                   class="btn-show-price"><?php echo esc_html__( 'Show price', 'traveler' ) ?></a>
                            <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

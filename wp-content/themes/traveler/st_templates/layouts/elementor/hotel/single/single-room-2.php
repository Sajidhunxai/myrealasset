<?php
wp_enqueue_script('single-hotel-detail');
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 20-11-2018
     * Time: 8:08 AM
     * Since: 1.0.0
     * Updated: 1.0.0
     */
    while ( have_posts() ): the_post();
        $room_id   = get_the_ID();
        $hotel_id  = get_post_meta( get_the_ID(), 'room_parent', true );
        $thumbnail = get_the_post_thumbnail_url( $room_id, 'full' );

        $adult_number = STInput::request( 'adult_number', 1 );
        $child_number = STInput::request( 'child_number', '' );


        $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
        $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));

        $start           = STInput::get( 'start', date( TravelHelper::getDateFormat(), strtotime($current_calendar)) );
        $end             = STInput::get( 'end', date( TravelHelper::getDateFormat(), strtotime( "+ 1 day", strtotime($current_calendar)) ) );
        $date            = STInput::get( 'date', date( 'd/m/Y h:i a', strtotime($current_calendar)) . '-' . date( 'd/m/Y h:i a', strtotime( '+1 day', strtotime($current_calendar)) ) );
        $room_num_search = (int)STInput::get( 'room_num_search', 1 );
        if ( $room_num_search <= 0 ) $room_num_search = 1;
        $start       = TravelHelper::convertDateFormat( $start );
        $end         = TravelHelper::convertDateFormat( $end );
        $price_by_per_person = get_post_meta( $room_id, 'price_by_per_person', true );
        $total_price = STPrice::getRoomPriceOnlyCustomPrice( $room_id, strtotime( $start ), strtotime( $end ), $room_num_search, $adult_number, $child_number );
        $sale_price  = STPrice::getRoomPrice( $room_id, strtotime( $start ), strtotime( $end ), $room_num_search, $adult_number, $child_number );


        $gallery       = get_post_meta( $room_id, 'gallery', true );
        $gallery_array = explode( ',', $gallery );

        $room_external = get_post_meta(get_the_ID(), 'st_room_external_booking', true);
        $room_external_link = get_post_meta(get_the_ID(), 'st_room_external_booking_link', true);

        $booking_type = st_get_booking_option_type();
        $numberday = STDate::dateDiff( $start, $end );
        $total_person = intval( $adult_number ) + intval( $child_number );
        ?>
        <div id="st-content-wrapper">
            <?php st_breadcrumbs_new() ?>
            <?php if ( !empty( $gallery_array ) ) { ?>
                <div class="st-flickity st-gallery">
                    <div class="carousel"
                         data-flickity='{ "wrapAround": true, "pageDots": false }'>
                        <?php
                            foreach ( $gallery_array as $value ) {
                                ?>
                                <div class="item" style="background-image: url('<?php echo wp_get_attachment_image_url( $value, 'full' ) ?>')"></div>
                                <?php
                            }
                        ?>
                    </div>
                    <div class="shares dropdown">
                        <a href="#" class="share-item social-share">
                            <i class="fas fa-share"></i>
                        </a>
                        <ul class="share-wrapper">
                            <li><a class="facebook"
                                    href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                                    target="_blank" rel="noopener" original-title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a class="twitter"
                                    href="https://twitter.com/share?url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                                    target="_blank" rel="noopener" original-title="Twitter"><i class="fab fa-twitter"></i></a></li>
                            <li><a class="no-open pinterest"
                                href="http://pinterest.com/pin/create/bookmarklet/?url=<?php the_permalink() ?>&is_video=false&description=<?php the_title() ?>&media=<?php echo get_the_post_thumbnail_url(get_the_ID())?>"
                                    target="_blank" rel="noopener" original-title="Pinterest"><i class="fab fa-pinterest-p"></i></a></li>
                            <li><a class="linkedin"
                                    href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                                    target="_blank" rel="noopener" original-title="LinkedIn"><i class="fab fa-linkedin-in"></i></a></li>
                        </ul>
                        <?php
                        $video_url = get_post_meta(get_the_ID(), 'video', true);
                        if (!empty($video_url)) {
                            ?>
                            <a href="<?php echo esc_url($video_url); ?>"
                                class="st-video-popup share-item"><i class="fab fa-youtube"></i></a>
                            <?php
                        } ?>
                        <?php echo st()->load_template('layouts/elementor/hotel/elements/wishlist'); ?>
                    </div>
                </div>
            <?php } ?>
            <div class="st-hotel-content">
                <div class="hotel-target-book-mobile d-flex justify-content-between align-items-center">
                    <div class="price-wrapper">
                        <?php
                        if ( $price_by_per_person == 'on' ) :
                            echo __('from ', 'traveler');
                            echo sprintf( '<span class="price">%s</span>', TravelHelper::format_money($sale_price) );
                            echo '<span class="unit">';
                            echo sprintf( _n( '/person', '/%d persons', $total_person, 'traveler' ), $total_person );
                            echo sprintf( _n( '/night', '/%d nights', $numberday, 'traveler' ), $numberday );
                            echo '</span>';
                        else:
                            echo __('from ', 'traveler');
                            echo sprintf( '<span class="price">%s</span>', TravelHelper::format_money($sale_price) );
                            echo '<span class="unit">';
                            echo sprintf( _n( '/night', '/%d nights', $numberday, 'traveler' ), $numberday );
                            echo '</span>';
                        endif; ?>
                    </div>
                    <?php
                    if($room_external == 'off' || empty($room_external)){
                        ?>
                        <a href=""
                            class="btn btn-mpopup btn-green">
                                <?php
                                    if($booking_type == 'enquire'){
                                        echo esc_html__('Inquiry', 'traveler');
                                    } else {
                                        echo esc_html__('Book Now', 'traveler');
                                    }
                                ?>
                        </a>
                        <?php
                    }else{
                        ?>
                        <a href="<?php echo esc_url($room_external_link); ?>"
                           class="btn btn-green"><?php echo esc_html__( 'Book Now', 'traveler' ) ?></a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-9">
                        <div class="st-service-header d-flex justify-content-between align-items-center">
                            <div class="left">
                                <h1 class="st-heading"><?php the_title(); ?></h1>
                                <div class="sub-heading mt10"><?php echo __( 'Hotel', 'traveler' ) ?>: <a
                                            href="<?php echo get_the_permalink( $hotel_id ); ?>"
                                            class="st-link"><?php echo get_the_title( $hotel_id ) ?></a>
                                </div>
                            </div>
                        </div>

                        <div class="st-hr large"></div>
                        <div class="room-featured-items">
                            <div class="row">
                                <div class="col-6 col-md-3">
                                    <div class="item has-matchHeight">
                                        <?php echo TravelHelper::getNewIcon( 'ico_square_blue', '', '32px' ); ?>
                                        <?php echo sprintf( __( 'S: %s', 'traveler' ), get_post_meta( $room_id, 'room_footage', true ) ) ?><?php echo __('m','traveler')?><sup>2</sup>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="item has-matchHeight">
                                        <?php echo TravelHelper::getNewIcon( 'ico_beds_blue', '', '32px' ); ?>
                                        <?php echo sprintf( __( 'Beds: %s', 'traveler' ), get_post_meta( $room_id, 'bed_number', true ) ) ?>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="item has-matchHeight">
                                        <?php echo TravelHelper::getNewIcon( 'ico_adults_blue', '', '32px'  ); ?>
                                        <?php echo sprintf( __( 'Adults: %s', 'traveler' ), get_post_meta( $room_id, 'adult_number', true ) ) ?>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <div class="item has-matchHeight">
                                        <?php echo TravelHelper::getNewIcon( 'ico_children_blue', '', '32px' ); ?>
                                        <?php echo sprintf( __( 'Children: %s', 'traveler' ), get_post_meta( $room_id, 'children_number', true ) ) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="st-hr large"></div>
                        <?php echo st()->load_template('layouts/elementor/hotel/single/item/description'); ?>
                        <!--Table Discount group -->
                        <?php $discount_by_day = !empty(get_post_meta(get_the_ID(),'discount_by_day')) ? get_post_meta(get_the_ID(),'discount_by_day',true) : '';
                            if(!empty($discount_by_day)){
                                $discount_type_no_day = !empty(get_post_meta(get_the_ID(),'discount_type_no_day')) ? get_post_meta(get_the_ID(),'discount_type_no_day',true) : '';
                                if($discount_type_no_day == 'percent'){
                                    $text_discount_type_no_day = __('by Percent','traveler');
                                } else {
                                    $text_discount_type_no_day = __('by Amount','traveler');
                                }
                                ?>
                            <div class="st-hr large"></div>
                            <div class="accordion-item">
                                <h2 class="st-heading-section" id="headingDiscount">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDiscount" aria-expanded="true" aria-controls="collapseDiscount">
                                        <?php echo __('Bulk discount', 'traveler') .' ('.esc_html($text_discount_type_no_day).')'; ?>
                                    </button>
                                </h2>
                                <div id="collapseDiscount" class="accordion-collapse collapse show" aria-labelledby="headingDiscount" data-bs-parent="#headingDiscount">
                                    <div class="accordion-body">
                                        <div class="st-program">
                                            <h5><?php echo esc_html__('Bulk discount adult','traveler'); ?></h5>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col"><?php echo esc_html__('Discount group','traveler');?></th>
                                                        <th scope="col"><?php echo esc_html__('From No. days','traveler');?></th>
                                                        <th scope="col"><?php echo esc_html__('To No. days', 'traveler');?></th>
                                                        <th scope="col"><?php echo esc_html__('Value', 'traveler');?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach($discount_by_day as $key=>$discount_day){?>
                                                            <tr>
                                                                <th scope="row"><?php echo intval($key + 1)?></th>
                                                                <td><?php echo esc_html(!empty($discount_day['title']) ? $discount_day['title'] : '');?></td>
                                                                <td><?php echo esc_html(!empty($discount_day['number_day'])? $discount_day['number_day'] : '');?></td>
                                                                <td><?php echo esc_html(!empty($discount_day['number_day_to']) ? $discount_day['number_day_to'] : '');?></td>
                                                                <td>
                                                                    <?php
                                                                    if($discount_type_no_day == 'percent'){
                                                                        echo esc_html($discount_day['value']).'%';
                                                                    } else {
                                                                        echo TravelHelper::format_money($discount_day['value']);
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                        <?php }
                                                    ?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                        <!--End Table Discount group -->
                        <?php echo st()->load_template('layouts/elementor/hotel/single/item/attributes','',['post_type' => 'hotel_room']);?>
                        
                        <div class="stoped-scroll-section"></div>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="widgets">
                            <div class="fixed-on-mobile" data-screen="992px">
                                <div class="close-icon hide">
                                    <?php echo TravelHelper::getNewIcon( 'Ico_close' ); ?>
                                </div>

                                <?php
                                if($booking_type == 'instant_enquire'){
                                    echo st()->load_template('layouts/elementor/hotel/single/item/room/form-booking','instant-inquiry',
                                    [
                                        'price_by_per_person' =>$price_by_per_person,
                                        'sale_price' => $sale_price,
                                        'numberday' => $numberday,
                                        'hotel_id' => $hotel_id,
                                        'room_id' => $room_id,
                                        'room_external' => $room_external,
                                        'room_external_link' => $room_external_link,
                                    ]);
                                }else{
                                    if($booking_type == 'enquire'){
                                        echo st()->load_template('layouts/elementor/hotel/single/item/room/form-booking','inquiry',
                                        [
                                            'price_by_per_person' => $price_by_per_person,
                                            'sale_price' => $sale_price,
                                            'numberday' => $numberday,
                                            'room_external' => $room_external,
                                            'room_external_link' => $room_external_link,
                                        ]);
                                    }else{
                                        echo st()->load_template('layouts/elementor/hotel/single/item/room/form-booking','instant',
                                        ['price_by_per_person' =>$price_by_per_person,
                                            'sale_price' => $sale_price,
                                            'numberday' => $numberday,
                                            'hotel_id' => $hotel_id,
                                            'room_id' => $room_id,
                                            'room_external' => $room_external,
                                            'room_external_link' => $room_external_link,
                                        ]);
                                    }
                                }
                                ?>

                                <?php echo st()->load_template('layouts/elementor/hotel/single/item/owner-info'); ?>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endwhile;

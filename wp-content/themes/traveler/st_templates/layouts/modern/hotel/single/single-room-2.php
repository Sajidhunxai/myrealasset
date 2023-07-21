<?php
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
                            <?php echo TravelHelper::getNewIcon('ico_share', '', '20px', '20px') ?>
                        </a>
                        <ul class="share-wrapper">
                            <li><a class="facebook"
                                   href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                                   target="_blank" rel="noopener" original-title="Facebook"><i
                                            class="fa fa-facebook fa-lg"></i></a></li>
                            <li><a class="twitter"
                                   href="https://twitter.com/share?url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                                   target="_blank" rel="noopener" original-title="Twitter"><i
                                            class="fa fa-twitter fa-lg"></i></a></li>
                            <li><a class="no-open pinterest"
                            href="http://pinterest.com/pin/create/bookmarklet/?url=<?php the_permalink() ?>&is_video=false&description=<?php the_title() ?>&media=<?php echo get_the_post_thumbnail_url(get_the_ID())?>"
                                   target="_blank" rel="noopener" original-title="Pinterest"><i
                                            class="fa fa-pinterest fa-lg"></i></a></li>
                            <li><a class="linkedin"
                                   href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
                                   target="_blank" rel="noopener" original-title="LinkedIn"><i
                                            class="fa fa-linkedin fa-lg"></i></a></li>
                        </ul>
                        <?php echo st()->load_template('layouts/modern/hotel/loop/wishlist'); ?>
                    </div>
                </div>
            <?php } ?>
            <div class="st-hotel-room-content">
                <div class="hotel-target-book-mobile">
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
                                    echo esc_html__('Check Availability', 'traveler');
                                }
                            ?>
                        </a>
                        <?php
                    }else{
                        ?>
                        <a href="<?php echo esc_url($room_external_link); ?>"
                           class="btn btn-green"><?php echo esc_html__( 'Explore', 'traveler' ) ?></a>
                        <?php
                    }
                    ?>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-md-9">
                            <div class="room-heading">
                                <div class="left">
                                    <div class="st-heading x-large"><?php the_title(); ?></div>
                                    <div class="sub-heading mt10"><?php echo __( 'Hotel', 'traveler' ) ?>: <a
                                                href="<?php echo get_the_permalink( $hotel_id ); ?>"
                                                class="st-link"><?php echo get_the_title( $hotel_id ) ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="st-hr large"></div>
                            <div class="room-featured-items">
                                <div class="row">
                                    <div class="col-xs-6 col-md-3">
                                        <div class="item has-matchHeight">
                                            <?php echo TravelHelper::getNewIcon( 'ico_square_blue', '', '32px' ); ?>
                                            <?php echo sprintf( __( 'S: %s', 'traveler' ), get_post_meta( $room_id, 'room_footage', true ) ) ?><?php echo __('m','traveler')?><sup>2</sup>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="item has-matchHeight">
                                            <?php echo TravelHelper::getNewIcon( 'ico_beds_blue', '', '32px' ); ?>
                                            <?php echo sprintf( __( 'Beds: %s', 'traveler' ), get_post_meta( $room_id, 'bed_number', true ) ) ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="item has-matchHeight">
                                            <?php echo TravelHelper::getNewIcon( 'ico_adults_blue', '', '32px'  ); ?>
                                            <?php echo sprintf( __( 'Adults: %s', 'traveler' ), get_post_meta( $room_id, 'adult_number', true ) ) ?>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="item has-matchHeight">
                                            <?php echo TravelHelper::getNewIcon( 'ico_children_blue', '', '32px' ); ?>
                                            <?php echo sprintf( __( 'Children: %s', 'traveler' ), get_post_meta( $room_id, 'children_number', true ) ) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="st-hr large"></div>
                            <h2 class="st-heading-section"><?php echo __( 'Description', 'traveler' ) ?></h2>
                            <?php
                                global $post;
                                $content = $post->post_content;
                                $count   = str_word_count( $content );
                            ?>
                            <div class="st-description" data-toggle-section="st-description" <?php if ( $count >= 120 ) {
                                echo 'data-show-all="st-description"
                             data-height="120"';
                            } ?>>
                                <?php the_content(); ?>
                                <?php if ( $count >= 120 ) { ?>
                                    <div class="cut-gradient"></div>
                                <?php } ?>
                            </div>
                            <?php if ( $count >= 120 ) { ?>
                                <a href="#" class="st-link block" data-show-target="st-description"
                                   data-text-less="<?php echo esc_html__( 'View Less', 'traveler' ) ?>"
                                   data-text-more="<?php echo esc_html__( 'View More', 'traveler' ) ?>"><span
                                            class="text"><?php echo esc_html__( 'View More', 'traveler' ) ?></span><i
                                            class="fa fa-caret-down ml3"></i></a>
                            <?php } ?>
                            
                            <div class="st-hr large"></div>
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
                                                                            echo esc_html($discount_day['discount']).'%';
                                                                        } else {
                                                                            echo TravelHelper::format_money($discount_day['discount']);
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
                            <?php
                            $all_attribute = TravelHelper::st_get_attribute_advance( 'hotel_room');
                            foreach ($all_attribute as $key_attr => $attr) {
                                if(!empty($attr["value"])){
                                    $get_label_tax = get_taxonomy($attr["value"]);
                                    $facilities = get_the_terms( get_the_ID(), $attr["value"]);
                                    ?>
                                    <div class="stt-attr-<?php echo esc_attr($attr["value"]);?>">
                                    <?php if($attr["value"] != 'room_type'){
                                        if(!empty($get_label_tax) && !empty($facilities)  ){
                                                echo '<h2 class="st-heading-section">'.esc_html($get_label_tax->label).'</h2>';
                                            }
                                        ?>
                                        <?php
                                            if ( $facilities ) {
                                                $count = count( $facilities );
                                                ?>
                                                <div class="facilities" data-toggle-section="st-<?php echo esc_attr($attr["value"]);?>"
                                                    <?php if ( $count > 6 ) echo 'data-show-all="st-'. esc_attr($attr["value"]) .'"
                                                data-height="150"'; ?>
                                                    >
                                                    <div class="row">
                                                        <?php
                                                        foreach ( $facilities as $term ) {
                                                            $icon     = TravelHelper::handle_icon( get_tax_meta( $term->term_id, 'st_icon') );
                                                            $icon_new = TravelHelper::handle_icon( get_tax_meta( $term->term_id, 'st_icon_new') );
                                                            if ( !$icon ) $icon = "fa fa-cogs";
                                                            ?>
                                                            <div class="col-xs-6 col-sm-4">
                                                                <div class="item has-matchHeight">
                                                                    <?php
                                                                        if ( !$icon_new ) {
                                                                            echo '<i class="' . esc_attr($icon) . '"></i>' . esc_html($term->name);
                                                                        } else {
                                                                            echo TravelHelper::getNewIcon( $icon_new, '#5E6D77', '24px', '24px' ) . esc_html($term->name);
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                                <?php if ( $count > 6 ) { ?>
                                                    <a href="#" class="st-link block" data-show-target="st-<?php echo esc_attr($attr["value"]);?>"
                                                    data-text-less="<?php echo esc_html__( 'Show Less', 'traveler' ) ?>"
                                                    data-text-more="<?php echo esc_html__( 'Show All', 'traveler' ) ?>"><span
                                                                class="text"><?php echo esc_html__( 'Show All', 'traveler' ) ?></span>
                                                        <i
                                                                class="fa fa-caret-down ml3"></i></a>
                                                    <?php
                                                }
                                            }
                                        if ( $facilities ) {
                                        ?>
                                            <div class="st-hr large"></div>
                                        <?php }
                                    } ?>
                                    </div>
                                <?php }

                            }
                            ?>
                            <div class="stoped-scroll-section"></div>
                        </div>
                        <div class="col-xs-12 col-md-3">
                            <div class="widgets">
                                <div class="fixed-on-mobile" data-screen="992px">
                                    <div class="close-icon hide">
                                        <?php echo TravelHelper::getNewIcon( 'Ico_close' ); ?>
                                    </div>

                                    <?php
                                    if($booking_type == 'instant_enquire'){
                                        ?>
                                        <div class="form-book-wrapper">
                                            <?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
                                            <div class="form-head">
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
                                            <nav>
                                                <ul class="nav nav-tabs nav-fill-st" id="nav-tab" role="tablist">
                                                    <li class="active"><a id="nav-book-tab" data-toggle="tab" href="#nav-book" role="tab" aria-controls="nav-home" aria-selected="true"><?php echo esc_html__( 'Book', 'traveler' ) ?></a></li>
                                                    <li><a id="nav-inquirement-tab" data-toggle="tab" href="#nav-inquirement" role="tab" aria-controls="nav-profile" aria-selected="false"><?php echo esc_html__( 'Inquiry', 'traveler' ) ?></a></li>
                                                </ul>
                                            </nav>
                                            <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                                <div class="tab-pane fade in active" id="nav-book" role="tabpanel" aria-labelledby="nav-book-tab">
                                                    <?php if(empty($room_external) || $room_external == 'off'){ ?>
                                                        <form id="single-room-form" class="form single-room-form hotel-room-booking-form form-has-guest-name" method="post">
                                                            <input name="action" value="hotel_add_to_cart" type="hidden">
                                                            <input name="item_id" value="<?php echo esc_attr($hotel_id); ?>" type="hidden">
                                                            <input name="room_id" value="<?php echo esc_attr($room_id); ?>" type="hidden">
                                                            <?php wp_nonce_field( 'room_search', 'room_search' ) ?>
                                                            <?php
                                                            $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
                                                            $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));

                                                            $start          = STInput::get( 'start', date( TravelHelper::getDateFormat(), strtotime($current_calendar)) );
                                                            $end            = STInput::get( 'end', date( TravelHelper::getDateFormat(), strtotime( "+ 1 day", strtotime($current_calendar)) ) );
                                                            $date           = STInput::get( 'date', date( 'd/m/Y h:i a',  strtotime($current_calendar)) . '-' . date( 'd/m/Y h:i a', strtotime( "+ 1 day", strtotime($current_calendar)) ) );
                                                            $has_icon       = ( isset( $has_icon ) ) ? $has_icon : false;
                                                            $booking_period = intval( get_post_meta( $hotel_id, 'hotel_booking_period', true ) );
                                                            ?>
                                                            <div class="form-group form-date-field date-enquire form-date-hotel-room clearfix <?php if ( $has_icon ) echo ' has-icon '; ?>"
                                                                 data-format="<?php echo TravelHelper::getDateFormatMoment() ?>" data-availability-date="<?php echo esc_attr($current_calendar_reverb); ?>">
                                                                <?php
                                                                if ( $has_icon ) {
                                                                    echo '<i class="field-icon fa fa-calendar"></i>';
                                                                }
                                                                ?>
                                                                <div class="date-wrapper clearfix">
                                                                    <div class="check-in-wrapper">
                                                                        <ul class="st_grid_date">
                                                                            <li>
                                                                                <div class="st-item-date">
                                                                                    <label><?php echo __('Check In', 'traveler'); ?></label>
                                                                                    <div class="render check-in-render"><?php echo esc_html($start); ?></div>
                                                                                </div>
                                                                            </li>
                                                                            <li>
                                                                                <div class="st-item-date">
                                                                                    <label><?php echo __('Check Out', 'traveler'); ?></label>
                                                                                    </span><div class="render check-out-render"><?php echo esc_html($end); ?></div>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" class="check-in-input"
                                                                       value="<?php echo esc_attr( $start ) ?>" name="check_in">
                                                                <input type="hidden" class="check-out-input"
                                                                       value="<?php echo esc_attr( $end ) ?>" name="check_out">
                                                                <input type="text" class="check-in-out"
                                                                       data-minimum-day="<?php echo esc_attr( $booking_period ); ?>"
                                                                       data-room-id="<?php echo esc_attr($room_id) ?>"
                                                                       data-action="st_get_availability_hotel_room"
                                                                       value="<?php echo esc_attr( $date ); ?>" name="date">
                                                            </div>
                                                            <?php echo st()->load_template( 'layouts/modern/hotel/elements/search/guest', '' ); ?>
                                                            <div class="item field-guest form-group form-extra-field">
                                                            <?php echo st()->load_template( 'layouts/modern/hotel/elements/search/guest-name', '' ); ?>
                                                        </div>
                                                            <?php echo st()->load_template( 'layouts/modern/hotel/elements/search/extra', '' ); ?>
                                                            <div class="submit-group">
                                                                <button class="btn btn-large btn-full upper font-medium btn_hotel_booking btn-book-ajax"
                                                                       type="submit"
                                                                       name="submit"
                                                                       value="<?php echo __( 'Book Now', 'traveler' ) ?>">
                                                                    <?php echo __( 'Book Now', 'traveler' ) ?>
                                                                    <i class="fa fa-spinner fa-spin hide"></i>
                                                                </button>
                                                                <input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID();?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
                                                            </div>
                                                            <div class="mt30 message-wrapper">
                                                                <?php echo STTemplate::message() ?>
                                                            </div>
                                                        </form>
                                                    <?php }else{ ?>
                                                        <div class="submit-group mb30">
                                                            <a href="<?php echo esc_url($room_external_link); ?>" class="btn btn-large btn-full upper"><?php echo esc_html__( 'Explore', 'traveler' ); ?></a>
                                                            <form id="form-booking-inpage" class="form single-room-form hotel-room-booking-form form-has-guest-name" method="post">
                                                                <input name="action" value="hotel_add_to_cart" type="hidden">
                                                                <input name="item_id" value="<?php echo esc_attr($hotel_id); ?>" type="hidden">
                                                                <input name="room_id" value="<?php echo esc_attr($room_id); ?>" type="hidden">
                                                                <?php wp_nonce_field( 'room_search', 'room_search' ) ?>
                                                                <input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID();?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
                                                            </form>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="tab-pane fade " id="nav-inquirement" role="tabpanel" aria-labelledby="nav-inquirement-tab">
                                                    <?php echo st()->load_template( 'email/email_single_service' ); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }else{
                                        if($booking_type == 'enquire'){
                                            ?>
                                            <div class="form-book-wrapper">
                                                <?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
                                                <div class="form-head">
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
                                                <h4 class="title-enquiry-form"><?php echo esc_html__('Inquiry', 'traveler'); ?></h4>
                                                <?php echo st()->load_template( 'email/email_single_service' ); ?>
                                                <form id="form-booking-inpage" class="form single-room-form hotel-room-booking-form form-has-guest-name" method="post">
                                                    <input name="action" value="hotel_add_to_cart" type="hidden">
                                                    <input name="item_id" value="<?php echo esc_attr($hotel_id); ?>" type="hidden">
                                                    <input name="room_id" value="<?php echo esc_attr($room_id); ?>" type="hidden">
                                                    <?php wp_nonce_field( 'room_search', 'room_search' ) ?>
                                                    <input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID();?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
                                                </form>
                                            </div>
                                            <?php
                                        }else{
                                            ?>
                                            <div class="form-book-wrapper">
                                                <?php echo st()->load_template( 'layouts/modern/common/loader' ); ?>
                                                <div class="form-head">
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
                                                <?php if(empty($room_external) || $room_external == 'off'){ ?>
                                                    <form id="form-booking-inpage" class="form single-room-form hotel-room-booking-form form-has-guest-name" method="post">
                                                        <input name="action" value="hotel_add_to_cart" type="hidden">
                                                        <input name="item_id" value="<?php echo esc_attr($hotel_id); ?>" type="hidden">
                                                        <input name="room_id" value="<?php echo esc_attr($room_id); ?>" type="hidden">
                                                        <?php wp_nonce_field( 'room_search', 'room_search' ) ?>
                                                        <?php
                                                        $current_calendar = TravelHelper::get_current_available_calendar(get_the_ID());
                                                        $current_calendar_reverb = date('m/d/Y', strtotime($current_calendar));

                                                        $start          = STInput::get( 'start', date( TravelHelper::getDateFormat(), strtotime($current_calendar)) );
                                                        $end            = STInput::get( 'end', date( TravelHelper::getDateFormat(), strtotime( "+ 1 day", strtotime($current_calendar)) ) );
                                                        $date           = STInput::get( 'date', date( 'd/m/Y h:i a',  strtotime($current_calendar)) . '-' . date( 'd/m/Y h:i a', strtotime( "+ 1 day", strtotime($current_calendar)) ) );
                                                        $has_icon       = ( isset( $has_icon ) ) ? $has_icon : false;
                                                        $booking_period = intval( get_post_meta( $hotel_id, 'hotel_booking_period', true ) );
                                                        ?>
                                                        <div class="form-group form-date-field form-date-hotel-room clearfix <?php if ( $has_icon ) echo ' has-icon '; ?>"
                                                             data-format="<?php echo TravelHelper::getDateFormatMoment() ?>" data-availability-date="<?php echo esc_attr($current_calendar_reverb); ?>">
                                                            <?php
                                                            if ( $has_icon ) {
                                                                echo '<i class="field-icon fa fa-calendar"></i>';
                                                            }
                                                            ?>
                                                            <div class="date-wrapper clearfix">
                                                                <div class="check-in-wrapper">
                                                                    <label><?php echo __( 'Check In - Out', 'traveler' ); ?></label>
                                                                    <div class="render check-in-render"><?php echo esc_html($start); ?></div> - <div class="render check-out-render"><?php echo esc_html($end); ?></div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" class="check-in-input"
                                                                   value="<?php echo esc_attr( $start ) ?>" name="check_in">
                                                            <input type="hidden" class="check-out-input"
                                                                   value="<?php echo esc_attr( $end ) ?>" name="check_out">
                                                            <input type="text" class="check-in-out"
                                                                   data-minimum-day="<?php echo esc_attr( $booking_period ); ?>"
                                                                   data-room-id="<?php echo esc_attr($room_id) ?>"
                                                                   data-action="st_get_availability_hotel_room"
                                                                   value="<?php echo esc_attr( $date ); ?>" name="date">
                                                        </div>
                                                        <?php echo st()->load_template( 'layouts/modern/hotel/elements/search/guest', '' ); ?>
                                                        <div class="item field-guest form-group form-extra-field">
                                                            <?php echo st()->load_template( 'layouts/modern/hotel/elements/search/guest-name', '' ); ?>
                                                        </div>
                                                        <?php echo st()->load_template( 'layouts/modern/hotel/elements/search/extra', '' ); ?>
                                                        <div class="submit-group">
                                                            <button class="btn btn-large btn-full upper font-medium btn_hotel_booking btn-book-ajax"
                                                                   type="submit"
                                                                   name="submit">
                                                                <?php echo __( 'Book Now', 'traveler' ) ?>
                                                                <i class="fa fa-spinner fa-spin hide"></i>
                                                            </button>
                                                            <input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID();?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
                                                        </div>
                                                        <div class="mt30 message-wrapper">
                                                            <?php echo STTemplate::message() ?>
                                                        </div>
                                                    </form>
                                                <?php }else{ ?>
                                                    <div class="submit-group mb30">
                                                        <a href="<?php echo esc_url($room_external_link); ?>" class="btn btn-large btn-full upper"><?php echo esc_html__( 'Explore', 'traveler' ); ?></a>
                                                        <form id="form-booking-inpage" class="form single-room-form hotel-room-booking-form form-has-guest-name" method="post">
                                                            <input name="action" value="hotel_add_to_cart" type="hidden">
                                                            <input name="item_id" value="<?php echo esc_attr($hotel_id); ?>" type="hidden">
                                                            <input name="room_id" value="<?php echo esc_attr($room_id); ?>" type="hidden">
                                                            <?php wp_nonce_field( 'room_search', 'room_search' ) ?>
                                                            <input style="display:none;" type="submit" class="btn btn-default btn-send-message" data-id="<?php echo get_the_ID();?>" name="st_send_message" value="<?php echo __('Send message', 'traveler');?>">
                                                        </form>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>

                                    <div class="owner-info widget-box">
                                        <h4 class="heading"><?php echo __( 'Owner', 'traveler' ) ?></h4>
                                        <div class="media">
                                            <div class="media-left">
                                                <?php
                                                $author_id = get_post_field( 'post_author', get_the_ID() );
                                                $userdata  = get_userdata( $author_id );
                                                ?>
                                                <a href="<?php echo st_get_author_posts_url(get_the_ID(),70); ?>">
                                                    <?php
                                                    echo st_get_profile_avatar( $author_id, 60 );
                                                    ?>
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading"><a href="<?php echo st_get_author_posts_url(get_the_ID(),70); ?>" class="author-link"><?php echo TravelHelper::get_username( $author_id ); ?></a></h4>
                                                <p><?php echo sprintf( __( 'Member Since %s', 'traveler' ), date( 'Y', strtotime( $userdata->user_registered ) ) ) ?></p>
                                            </div>
                                            <?php
                                                $enable_inbox = st()->get_option('enable_inbox');
                                                if($enable_inbox === 'on'){ ?>
                                                    <div class="st_ask_question">
                                                        <?php
                                                            if (!is_user_logged_in()) {?>
                                                            <a href="" class="login btn btn-primary upper mt5" data-toggle="modal" data-target="#st-login-form"><?php echo __('Ask a Question', 'traveler');?></a>
                                                        <?php } else{?>
                                                            <a href="" id="btn-send-message-owner" class="btn-send-message-owner btn btn-primary upper mt5" data-id="<?php echo get_the_ID();?>"><?php echo __('Ask a Question', 'traveler');?></a>
                                                        <?php }?>
                                                    </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    endwhile;

<?php
	global $post;
	$post_id = $post->ID;
	if(is_page_template( 'template-user.php' )){
		$post_id = isset($_GET['id']) ? (int)$_GET['id']: 0;
	}
	if(empty($post_id)){
		return;
	}
?>
<?php
	$args = [
		'post_type' => 'hotel_room',
		'posts_per_page' => -1,
		'meta_query' => [
			[
				'key' => 'room_parent',
				'value' => $post_id,
				'compare' => '='
			]
		]
	];
	$rooms = [];
	$query = new WP_Query($args);
	while($query->have_posts()): $query->the_post();
		$rooms[] = [
			'id' => get_the_ID(),
            'name' => get_the_title(),
            'price_by_per_person' => get_post_meta( get_the_ID(), 'price_by_per_person', true )
		];
?>
<?php endwhile; wp_reset_postdata();
wp_enqueue_script('bulk-calendar' );
wp_enqueue_script('bootstrap-datepicker.js' );
wp_enqueue_script( 'bootstrap-datepicker-lang.js' );
?>
<div class="calendar-wrapper">
    <div class="st-inventory-form">
        <span class="mr10"><strong><?php echo esc_html__( 'View by period:', 'traveler' ); ?></strong></span>
        <input type="text" name="st-inventory-start" class="st-inventory-start disabled" value="" autocomplete="off"
               placeholder="<?php echo esc_html__( 'Start date', 'traveler' ) ?>">
        <input type="text" name="st-inventory-end" class="st-inventory-end disabled" value="" autocomplete="off"
               placeholder="<?php echo esc_html__( 'End date', 'traveler' ) ?>">
        <button class="st-inventory-goto"><?php echo esc_html__( 'View', 'traveler' ); ?></button>
        <button type="button" id="calendar-bulk-edit" class="option-tree-ui-button button button-primary button-large btn btn-primary btn-sm" style="float: right;"><?php echo esc_html__('Bulk Edit', 'traveler'); ?></button>
    </div>
    <div class="gantt wpbooking-gantt st-inventory" data-id="<?php echo esc_attr( $post_id ); ?>"
         data-rooms="<?php echo esc_attr( json_encode( $rooms ) ); ?>">
    </div>
    <div class="st-inventory-color">
        <div class="inventory-color-item">
            <span class="available"></span> <?php echo esc_html__( 'Available', 'traveler' ); ?>
        </div>
        <div class="inventory-color-item">
            <span class="unavailable"></span> <?php echo esc_html__( 'Unavailable', 'traveler' ); ?>
        </div>
        <div class="inventory-color-item">
            <span class="out_stock"></span> <?php echo esc_html__( 'Out of Stock', 'traveler' ); ?>
        </div>
    </div>
    <input type="hidden" value="<?php echo esc_html('Edit number of room', 'traveler'); ?>" id="inventory-text-eidt-room" />
    <div class="panel-room-number-wrapper">
        <div class="panel-room">
            <input class="input-price" type="number" name="input-room-number" value="" placeholder="">
            <input class="input-room-id" type="hidden" name="input-room-id" value="" placeholder="" min="0">
            <a href="javascript: void(0);" class="button btn-add-number-room" style="margin-left: 10px;">Update <i class="fa fa-spin fa-spinner loading-icon"></i></a>
            <span class="close">
                <i class="fa fa-times"></i>
            </span>
            <div class="message-box"></div>
        </div>
    </div>
    <!-- Bulk Edit -->
    <div id="form-bulk-edit" class="fixed">
        <div class="form-container">
            <div class="overlay">
                <span class="spinner is-active"></span>
            </div>
            <div class="form-title">
                <h3 class="clearfix">
                    <?php echo esc_html__( 'Select a Room', 'traveler' ); ?>
                    <select name="post-id" class="ml20 post-bulk">
                        <option
                                value=""><?php echo esc_html__( '---- room ----', 'traveler' ); ?></option>
                        <?php
                        foreach ( $rooms as $room ) {
                            echo '<option value="' . esc_attr( $room[ 'id' ] ) . '" data-price-by-per-person="'. esc_attr( $room['price_by_per_person'] ) .'">' . esc_html( $room[ 'name' ] ) . '</option>';
                        }
                        ?>
                    </select>
                    <button style="float: right;" type="button" id="calendar-bulk-close" class="calendar-bulk-room-close button button-small btn btn-default btn-sm"><?php echo __('Close','traveler'); ?></button>
                </h3>
            </div>
            <div class="form-content clearfix">
                <div class="form-group">
                    <div class="form-title">
                        <h4 class=""><input type="checkbox" class="check-all" data-name="day-of-week"> <?php echo __('Days Of Week', 'traveler'); ?></h4>
                    </div>
                    <div class="form-content">
                        <label class="block"><input type="checkbox" name="day-of-week[]" value="Sunday" style="margin-right: 5px;"><?php echo __('Sunday', 'traveler'); ?></label>
                        <label class="block"><input type="checkbox" name="day-of-week[]" value="Monday" style="margin-right: 5px;"><?php echo __('Monday', 'traveler'); ?></label>
                        <label class="block"><input type="checkbox" name="day-of-week[]" value="Tuesday" style="margin-right: 5px;"><?php echo __('Tuesday', 'traveler'); ?></label>
                        <label class="block"><input type="checkbox" name="day-of-week[]" value="Wednesday" style="margin-right: 5px;"><?php echo __('Wednesday', 'traveler'); ?></label>
                        <label class="block"><input type="checkbox" name="day-of-week[]" value="Thursday" style="margin-right: 5px;"><?php echo __('Thursday', 'traveler'); ?></label>
                        <label class="block"><input type="checkbox" name="day-of-week[]" value="Friday" style="margin-right: 5px;"><?php echo __('Friday', 'traveler'); ?></label>
                        <label class="block"><input type="checkbox" name="day-of-week[]" value="Saturday" style="margin-right: 5px;"><?php echo __('Saturday', 'traveler'); ?></label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-title">
                        <h4 class=""><input type="checkbox" class="check-all" data-name="day-of-month"> <?php echo __('Days Of Month', 'traveler'); ?></h4>
                    </div>
                    <div class="form-content">
                        <?php for( $i = 1; $i <= 31; $i ++):
                            if( $i == 1){
                                echo '<div>';
                            }
                            ?>
                            <label style="width: 40px;"><input type="checkbox" name="day-of-month[]" value="<?php echo esc_attr($i); ?>" style="margin-right: 5px;"><?php echo esc_html($i); ?></label>
                            <?php
                            if( $i != 1 && $i % 5 == 0 ) echo '</div><div>';
                            if( $i == 31 ) echo '</div>';
                            ?>
                        <?php endfor; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-title">
                        <h4 class=""><input type="checkbox" class="check-all" data-name="months"> <?php echo __('Months', 'traveler'); ?>(*)</h4>
                    </div>
                    <div class="form-content">
                        <?php
                        $months = array(
                            'January' => __('January', 'traveler'),
                            'February' => __('February', 'traveler'),
                            'March' => __('March', 'traveler'),
                            'April' => __('April', 'traveler'),
                            'May' => __('May', 'traveler'),
                            'June' => __('June', 'traveler'),
                            'July' => __('July', 'traveler'),
                            'August' => __('August', 'traveler'),
                            'September' => __('September', 'traveler'),
                            'October' => __('October', 'traveler'),
                            'November' => __('November', 'traveler'),
                            'December' => __('December', 'traveler'),
                        );
                        $i = 0;
                        foreach( $months as $key => $month ):
                            if( $i == 0 ){
                                echo '<div>';
                            }
                            ?>
                            <label style="width: 100px;"><input type="checkbox" name="months[]" value="<?php echo esc_attr($key); ?>" style="margin-right: 5px;"><?php echo esc_html($month); ?></label>
                            <?php
                            if( $i != 0 && ($i + 1) % 2 == 0 ) echo '</div><div>';
                            if( $i + 1 == count( $months ) ) echo '</div>';
                            $i++;
                            ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-title">
                        <h4 class=""><input type="checkbox" class="check-all" data-name="years"> <?php echo __('Years', 'traveler'); ?>(*)</h4>
                    </div>
                    <div class="form-content">
                        <?php
                        $year = date('Y');
                        $j = $year -1 ;
                        for( $i = $year; $i <= $year + 2; $i ++ ):
                            if( $i == $year ){
                                echo '<div>';
                            }
                            ?>
                            <label style="width: 100px;"><input type="checkbox" name="years[]" value="<?php echo esc_attr($i); ?>" style="margin-right: 5px;"><?php echo esc_html($i); ?></label>
                            <?php
                            if( $i != $year && ($i == $j + 2 ) ) { echo '</div><div>'; $j = $i; }
                            if( $i == $year + 2 ) echo '</div>';
                            ?>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div class="form-content flex lh30 clearfix">
                <label class="block mr10"><span><strong><?php echo esc_html__( 'Price', 'traveler' ); ?>
                            : </strong></span><input
                            type="text" value="" name="price-bulk" id="price-bulk"
                            placeholder="<?php echo esc_html__( 'Price', 'traveler' ); ?>"></label>
                <label style="display: none;" class="block mr10"><span><strong><?php echo esc_html__( 'Adult Price', 'traveler' ); ?> : </strong></span>
                    <input type="text" value="" name="adult-price-bulk" id="adult-price-bulk" placeholder="<?php echo esc_html__( 'Price', 'traveler' ); ?>">
                </label>
                <label style="display: none;" class="block mr10"><span><strong><?php echo esc_html__( 'Child Price', 'traveler' ); ?> : </strong></span>
                    <input type="text" value="" name="children-price-bulk" id="children-price-bulk" placeholder="<?php echo esc_html__( 'Price', 'traveler' ); ?>">
                </label>
                <label class="block">
                    <span><strong><?php echo esc_html__( 'Status', 'traveler' ); ?>: </strong></span>
                    <select name="status">
                        <option value="available"><?php echo esc_html__( 'Available', 'traveler' ) ?></option>
                        <option
                                value="unavailable"><?php echo esc_html__( 'Unavailable', 'traveler' ) ?></option>
                    </select>
                </label>
                <input type="hidden" class="type-bulk" name="type-bulk" value="accommodation">
                <div class="clear"></div>
                <div class="form-message" style="margin-top: 20px;"></div>
            </div>
            <div class="form-footer">
                <button type="button" id="calendar-bulk-save" class="button button-primary button-large btn btn-primary btn-sm"><?php echo __('Save','traveler'); ?></button>
            </div>
        </div>
    </div>
</div>

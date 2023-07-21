<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 6/21/2016
 * Time: 9:38 AM
 */
if( is_admin() ){
    $post_id = get_the_ID();
}else{
    $post_id = STInput::get('id','');
}
wp_enqueue_script('bulk-calendar' );
?>
<div id="form-bulk-edit" class="form-bulk-edit-activity-tour">
    <div class="form-container">
    <?php if( is_admin() ): ?>
        <div class="overlay">
            <span class="spinner is-active"></span>
        </div>
    <?php else: ?>
        <div class="overlay-form" style="display: none;"><i class="fa fa-refresh text-color"></i></div>
    <?php endif; ?>
        <div class="form-title">
            <h3 class="clearfix"><?php echo __('Bulk Price Edit', 'traveler'); ?>
                <button style="float: right;" type="button" id="calendar-bulk-close" class="button button-small btn btn-default btn-sm"><?php echo __('Close','traveler'); ?></button>
            </h3>
        </div>
        <div class="form-content clearfix">
            <h4 style="margin-bottom: 20px;"><?php echo __('Choose Date:', 'traveler'); ?></h4>
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
                        <label style="width: 40px;"><input type="checkbox" name="day-of-month[]" value="<?php echo esc_html($i); ?>" style="margin-right: 5px;"><?php echo esc_html($i); ?></label>

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
                        <label style="width: 100px;"><input type="checkbox" name="months[]" value="<?php echo esc_html($key); ?>" style="margin-right: 5px;"><?php echo esc_html($month); ?></label>

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
                        <label style="width: 100px;"><input type="checkbox" name="years[]" value="<?php echo esc_html($i); ?>" style="margin-right: 5px;"><?php echo esc_html($i); ?></label>

                        <?php
                        if( $i != $year && ($i == $j + 2 ) ) { echo '</div><div>'; $j = $i; }
                        if( $i == $year + 2 ) echo '</div>';
                        ?>

                    <?php endfor; ?>
                </div>
            </div>
        </div>
        <div class="form-content clearfix">
            <div style="margin-bottom: 15px" class="row">
                <?php if(get_post_type($post_id) == 'st_tours'){ ?>
                    <div class="col-xs-12 col-sm-4">
                        <label class="block"><span><strong><?php echo __('Base Price', 'traveler'); ?>: </strong></span>
                            <input class="form-control" type="text" value="0" name="price-bulk" id="base-price-bulk" placeholder="<?php echo __('Base price', 'traveler'); ?>"></label>
                    </div>
                <?php } ?>
                <div class="col-xs-12 col-sm-4">
                    <label class="block"><span><strong><?php echo __('Adult', 'traveler'); ?>: </strong></span>
                    <input class="form-control" type="text" value="0" name="adult-price-bulk" id="adult-price-bulk" placeholder="<?php echo __('Adult', 'traveler'); ?>"></label>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <label class="block"><span><strong><?php echo __('Children', 'traveler'); ?>: </strong></span>
                    <input class="form-control" type="text" value="0" name="children-price-bulk" id="children-price-bulk" placeholder="<?php echo __('Children', 'traveler'); ?>"></label>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <label class="block"><span><strong><?php echo __('Infant', 'traveler'); ?>: </strong></span>
                    <input class="form-control" type="text" value="0" name="infant-price-bulk" id="infant-price-bulk" placeholder="<?php echo __('Infant', 'traveler'); ?>"></label>
                </div>
            </div>
            <?php if(get_post_type($post_id) == 'st_tours'){ ?>
                <input type="hidden" name="calendar_price_type" id="calendar_price_type" value="<?php echo STTour::get_price_type($post_id); ?>"/>
            <?php } ?>
            <!-- Start Time -->
                <div class="row bulk-starttime">
                    <div class="col-xs-12">
                        <div class="">
                            <label><strong><?php echo __('StartTime', 'traveler'); ?></strong></label>
                        </div>

                        <div class="">
                            <div class="calendar-starttime-wraper starttime-origin">
                                <select class="calendar_starttime_hour" name="">
							        <?php
                                    $time_format = st()->get_option('time_format', '24h');
                                    if($time_format == '24h'){
                                        for ( $i = 0; $i < 24; $i ++ ) {
                                            echo '<option value="' . esc_attr((($i < 10) ? ('0' . $i) : $i)) . '">' . esc_html((($i < 10) ? ('0' . $i) : $i)) . '</option>';
                                        }
                                    }else{
                                        for ( $i = 1; $i < 13; $i ++ ) {
                                            echo '<option value="' . esc_attr((($i < 10) ? ('0' . $i) : $i)) . '">' . esc_html((($i < 10) ? ('0' . $i) : $i)) . '</option>';
                                        }
                                    }
							        ?>
                                </select>
                                <span dir="rtl"><i><?php echo __( 'hour', 'traveler' ); ?></i></span>
                                <select class="calendar_starttime_minute" name="">
							        <?php
							        for ( $i = 0; $i < 60; $i ++ ) {
								        echo '<option value="' . esc_attr((($i < 10) ? ('0' . $i) : $i)) . '">' . esc_html((($i < 10) ? ('0' . $i) : $i)) . '</option>';
							        }
							        ?>
                                </select>
                                <span dir="rtl"><i><?php echo __( 'minute', 'traveler' ); ?></i></span>
                                <?php if($time_format == '12h'){ ?>
                                    <select class="calendar_starttime_format" name="">
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                <?php } ?>
                                <div class="calendar-remove-starttime" data-time-format="<?php echo esc_attr($time_format); ?>"><span class="dashicons dashicons-no-alt"></span></div>
                            </div>
                            <div id="calendar-add-starttime" class="calendar-add-starttime" data-time-format="<?php echo esc_attr($time_format); ?>"><span class="dashicons dashicons-plus"></span></div>
                        </div>
                    </div>
                </div><br />
            <!---->
            <div style="margin-bottom: 15px">
                <label class="block"><span><strong><?php echo __('Status', 'traveler'); ?>: </strong></span></label>
                <select class="form-control" name="status" id="">
                    <option value="available"><?php echo __('Available', 'traveler'); ?></option>
                    <option value="unavailable"><?php echo __('Unavailable', 'traveler'); ?></option>
                </select>
            </div>
            <div style="margin-bottom: 15px">
                <input name="calendar_groupday" id="calendar_groupday" value="1" type="checkbox">
                <span class="ml5"><?php echo __( 'Group day', 'traveler' ) ?></span>
            </div>
            <input type="hidden" name="post-id" value="<?php echo esc_html($post_id); ?>">
            <div class="form-message" style="margin-top: 20px;"></div>
        </div>
        <div class="form-footer">
            <button type="button" id="calendar-bulk-save" class="button button-primary button-large btn btn-primary btn-sm"><?php echo __('Save','traveler'); ?></button><!--
								<button type="button" id="calendar-bulk-cancel" class="button button-large"><?php echo __('Cancel','traveler'); ?></button> -->
        </div>
    </div>
</div>

<?php 
    wp_enqueue_script( 'bootstrap-datepicker.js' ); wp_enqueue_script( 'bootstrap-datepicker-lang.js' ); 
?>
<?php $post_id = intval($_GET['id']);
?>
<span class="hidden st_partner_avaiablity <?php echo STInput::get('sc') ?> "></span>
<div class="row calendar-wrapper template-user <?php echo STInput::get('sc') ?>" data-post-id="<?php echo esc_html($post_id); ?>" >
    <div class="col-xs-12 col-md-12 calendar-wrapper-inner">
        <div class="overlay-form"><i class="fa fa-refresh text-color"></i></div>
        <div class="calendar-content">
        </div>
    </div>
    <div class="col-xs-12 col-md-12">
        <div class="calendar-form">
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="calendar_check_in"><?php echo __('Check In', 'traveler'); ?></label>
                        <input readonly="readonly" type="text" class="form-control date-picker" placeholder="<?php echo __('Check In', 'traveler'); ?>" name="calendar_check_in" id="calendar_check_in">
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="calendar_check_out"><?php echo __('Check Out', 'traveler'); ?></label>
                        <input readonly="readonly" type="text" class="form-control date-picker" placeholder="<?php echo __('Check Out', 'traveler'); ?>" name="calendar_check_out" id="calendar_check_out">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="calendar_price"><?php echo __('Economy Price', 'traveler'); ?></label>
                        <input type="text" name="calendar_price[economy]" id="calendar_price_eco" placeholder="<?php echo __('Price', 'traveler'); ?>" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="calendar_price"><?php echo __('Business Price', 'traveler'); ?></label>
                        <input type="text" name="calendar_price[business]" id="calendar_price_bus" placeholder="<?php echo __('Price', 'traveler'); ?>" class="form-control">
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="calendar_status"><?php echo __('Status', 'traveler'); ?></label>
                        <select name="calendar_status" id="calendar_status" class="form-control">
                            <option value="available"><?php echo __('Available', 'traveler'); ?></option>
                            <option value="unavailable"><?php echo __('Unavailble', 'traveler'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-message">
                    <p class="text-danger"></p>
                </div>
            </div>
            <div class="form-group">
                <input type="hidden" name="calendar_post_id" value="<?php echo esc_html($post_id); ?>">
                <input type="submit" id="calendar_submit" class="btn btn-primary" name="calendar_submit" value="<?php echo __('Update', 'traveler'); ?>">
                <?php do_action('traveler_after_form_submit_flight_calendar'); ?>
            </div>
        </div>
    </div>
    <?php do_action('traveler_after_form_flight_calendar'); ?>
</div>
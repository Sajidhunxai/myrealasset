<?php
/**
*@since 1.1.9
* use for Booking Activity
**/
wp_enqueue_script( 'bootstrap-datepicker.js' ); wp_enqueue_script( 'bootstrap-datepicker-lang.js' );

?>
<div class="st-create">
  <h2><?php _e("Add New Activity Booking",'traveler') ?></h2>
</div>
<form action="#" method="post" id="form-add-booking-partner"
  class="form-add-booking-partner st_add_booking_activity <?php echo STUser_f::get_status_msg(); ?>">
  <?php wp_nonce_field('add_booking_partner','add_booking_partner_field'); ?>
  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingOne">
        <h2 class="panel-title">
          <a style="font-size: 22px; font-weight: 400;" role="button" data-toggle="collapse" data-parent="#accordion"
            href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            <?php echo __('Customer Information', 'traveler'); ?>
          </a>
        </h2>
      </div>
      <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
        <div class="panel-body">
          <div class="form-group form-group-icon-left">
            <label for="id_user" class="head_bol"><?php _e("Booker ID",'traveler') ?>:</label>
            <?php
				        	$id_user='';
				            $pl_name='';
				        	$id_user = get_current_user_id();
				            if($id_user){
				                $user = get_userdata($id_user);
				                if($user){
				                    $pl_name = $user->ID.' - '.$user->user_email;
				                }
				            }
				        ?>
            <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
            <input id="id_user" name="id_user" type="text" readonly="readonly" class="form-control"
              value="<?php echo esc_attr($pl_name); ?>">
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-6">
              <div class="form-group form-group-icon-left">
                <label for="st_first_name" class="head_bol"><?php _e('Customer First Name', 'traveler'); ?> <span
                    class="text-small text-danger">(*)</span>:</label>
                <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
                <input id="st_first_name" name="st_first_name" type="text" class="form-control"
                  value="<?php if(isset($_POST['st_first_name'])) echo esc_attr($_POST['st_first_name']); ?>">
              </div>
            </div>
            <div class="col-xs-12 col-sm-6">
              <div class="form-group form-group-icon-left">
                <label for="st_last_name" class="head_bol"><?php _e('Customer Last Name', 'traveler'); ?> <span
                    class="text-small text-danger">(*)</span>:</label>
                <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
                <input id="st_last_name" name="st_last_name" type="text" class="form-control"
                  value="<?php if(isset($_POST['st_last_name'])) echo esc_attr($_POST['st_last_name']); ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-6">
              <div class="form-group form-group-icon-left">
                <label for="st_email" class="head_bol"><?php _e('Customer Email', 'traveler'); ?> <span
                    class="text-small text-danger">(*)</span>:</label>
                <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
                <input id="st_email" name="st_email" type="text" class="form-control"
                  value="<?php if(isset($_POST['st_email'])) echo esc_attr($_POST['st_email']); ?>">
              </div>
            </div>
            <div class="col-xs-12 col-sm-6">
              <div class="form-group form-group-icon-left">
                <label for="st_phone" class="head_bol"><?php _e('Customer Phone', 'traveler'); ?> <span
                    class="text-small text-danger">(*)</span>:</label>
                <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
                <input id="st_phone" name="st_phone" type="text" class="form-control"
                  value="<?php if(isset($_POST['st_phone'])) echo esc_attr($_POST['st_phone']); ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-6">
              <div class="form-group form-group-icon-left">
                <label for="st_address" class="head_bol"><?php _e('Customer Address', 'traveler'); ?>:</label>
                <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
                <input id="st_address" name="st_address" type="text" class="form-control"
                  value="<?php if(isset($_POST['st_address'])) echo esc_attr($_POST['st_address']); ?>">
              </div>
            </div>
            <div class="col-xs-12 col-sm-6">
              <div class="form-group form-group-icon-left">
                <label for="st_address2" class="head_bol"><?php _e('Customer Address 2', 'traveler'); ?>:</label>
                <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
                <input id="st_address2" name="st_address2" type="text" class="form-control"
                  value="<?php if(isset($_POST['st_address2'])) echo esc_attr($_POST['st_address2']); ?>">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-4">
              <div class="form-group form-group-icon-left">
                <label for="st_city" class="head_bol"><?php _e('Customer City', 'traveler'); ?>:</label>
                <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
                <input id="st_city" name="st_city" type="text" class="form-control"
                  value="<?php if(isset($_POST['st_city'])) echo esc_attr($_POST['st_city']); ?>">
              </div>
            </div>
            <div class="col-xs-12 col-sm-4">
              <div class="form-group form-group-icon-left">
                <label for="st_province" class="head_bol"><?php _e('State/Province/Region', 'traveler'); ?>:</label>
                <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
                <input id="st_province" name="st_province" type="text" class="form-control"
                  value="<?php if(isset($_POST['st_province'])) echo esc_attr($_POST['st_province']); ?>">
              </div>
            </div>
            <div class="col-xs-12 col-sm-4">
              <div class="form-group form-group-icon-left">
                <label for="st_country" class="head_bol"><?php _e('ZIP code/Postal code', 'traveler'); ?>:</label>
                <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
                <input id="st_country" name="st_country" type="text" class="form-control"
                  value="<?php if(isset($_POST['st_country'])) echo esc_attr($_POST['st_country']); ?>">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading" role="tab" id="headingTwo">
        <h2 class="panel-title">
          <a style="font-size: 22px; font-weight: 400;" role="button" data-toggle="collapse" data-parent="#accordion"
            href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <?php echo __('Booking Information', 'traveler'); ?>
          </a>
        </h2>
      </div>
      <div id="collapseTwo" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingTwo">
        <div id="overlay">
          <div class="spinner user_img_loading loaded">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
          </div>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <label for="activity_id" class="head_bol"><?php _e('Activity', 'traveler'); ?> <span
                    class="text-small text-danger">(*)</span>:</label>
                <?php
			                        $activity_id = isset($_POST['item_id']) ? $_POST['item_id'] : '';
			                        $activity_name = (intval($activity_id) > 0) ? get_the_title($activity_id) : "";

			                    ?>
                <input id="activity_id" type="hidden" name="item_id" value="<?php echo esc_attr($activity_id); ?>"
                  data-post-type="st_activity" class="form-control custom-form-control st_post_select_ajax "
                  data-pl-name="<?php echo esc_attr($activity_name); ?>"
                  data-user-id="<?php echo get_current_user_id(); ?>">
              </div>
            </div>
          </div>
          <div class="row st_check_book_none">
            <div class="col-xs-12 col-sm-5-column">
              <div class="form-group">
                <label for="type-activity-wrapper" class="head_bol"><?php _e('Type activity', 'traveler'); ?>: <span
                    id="label_type_activity"></span></label>
                <div id="type-activity-wrapper" style="display:none"></div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-5-column">
              <div class="form-group">
                <label for="max_people" class="head_bol"><?php _e('Max people', 'traveler'); ?>: <span
                    id="label_max_people"></span></label>
                <input type="hidden" readonly="readonly" name="max_people" value="" id="max_people"
                  class="form-control">
              </div>
            </div>
            <div class="col-xs-12 col-sm-5-column">
              <div class="form-group">
                <label for="adult_price" class="head_bol"><?php _e('Adult Price', 'traveler'); ?>: <span
                    id="label_adult_price"></span></label>
                <input id="adult_price" readonly type="hidden" name="adult_price" value="" class="form-control">
              </div>
            </div>
            <div class="col-xs-12 col-sm-5-column">
              <div class="form-group">
                <label for="child_price" class="head_bol"><?php _e('Children Price', 'traveler'); ?>: <span
                    id="label_child_price"></span></label>
                <input id="child_price" readonly type="hidden" name="child_price" value="" class="form-control">
              </div>
            </div>
            <div class="col-xs-12 col-sm-5-column">
              <div class="form-group">
                <label for="infant_price" class="head_bol"><?php _e('Infant Price', 'traveler'); ?>: <span
                    id="label_infant_price"></span></label>
                <input id="infant_price" readonly type="hidden" name="infant_price" value="" class="form-control">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 col-sm-5-column">
              <div class="form-group">
                <label for="adult_number" class="head_bol"><?php _e('No. Adults', 'traveler'); ?> <span
                    class="text-small text-danger">(*)</span>:</label>
                <div id="adult-wrapper">
                  <?php
		      						$adult_number = isset($_POST['adult_number']) ? intval($_POST['adult_number']) : 1;
		      					?>
                  <select name="adult_number" class="form-control" style="width: 100%;">
                    <?php for($i = 1; $i <= $adult_number; $i++): ?>
                    <option value="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></option>
                    <?php endfor; ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-5-column">
              <div class="form-group">
                <label for="child_number" class="head_bol"><?php _e('No. Children', 'traveler'); ?>:</label>
                <div id="child-wrapper">
                  <?php
		      						$child_number = isset($_POST['child_number']) ? intval($_POST['child_number']) : 0;
		      					?>
                  <select name="child_number" class="form-control" style="width: 100%;">
                    <?php for($i = 0; $i <= $child_number; $i++): ?>
                    <option value="<?php echo esc_attr($i); ?>"><?php echo esc_attr($i); ?></option>
                    <?php endfor; ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-5-column">
              <div class="form-group">
                <label for="infant_number" class="head_bol"><?php _e('No. Infant', 'traveler'); ?> <span
                    class="text-small text-danger">(*)</span>:</label>
                <div id="infant-wrapper">
                  <?php
		      						$infant_number = isset($_POST['infant_number']) ? intval($_POST['infant_number']) : 0;
		      					?>
                  <select name="infant_number" class="form-control" style="width: 100%;">
                    <?php for($i = 0; $i <= $infant_number; $i++): ?>
                    <option value="<?php echo esc_attr($i); ?>"><?php echo esc_attr($i); ?></option>
                    <?php endfor; ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-5-column">
              <div class="form-group">
                <label for="check_in_activity" class="head_bol"><?php _e('Departure date', 'traveler'); ?> <span
                    class="text-small text-danger">(*)</span>:</label>
                <?php
		      						$check_in = isset($_POST['check_in']) ? $_POST['check_in'] : '';
		      					?>
                <div class="input-group">
                  <span class="input-group-addon" id="basic-checkin"><a href="#" class="" id="activity_time"
                      data-toggle="modal" data-target="#calendar_activity_modal"><i
                        class="fa fa-calendar"></i></a></span>
                  <?php
		      							$start = STInput::request('check_in', date(TravelHelper::getDateFormat()));
												$end = STInput::request('check_out', date(TravelHelper::getDateFormat()));
												$date = STInput::request('date', date('d/m/Y h:i a') . '-' . date('d/m/Y h:i a'));
												$class_hidden_enddate = 'hidden';
		      						?>
                  <input readonly data-date-format="<?php echo TravelHelper::getDateFormatJs() ?>"
                    aria-describedby="basic-checkin" data-date-format="<?php echo TravelHelper::getDateFormatJs(); ?>"
                    autocomplete="off" type="text" name="check_in" id="check_in_activity"
                    value="<?php echo esc_attr($check_in); ?>" class="form-control">
                  <input type="text" class="check-in-out-input" value="<?php echo esc_attr($date) ?>"
                    name="check_in_out" data-action="st_get_availability_activity_frontend"
                    data-tour-id="<?php the_ID(); ?>" data-posttype="st_activity">
                  <input type="hidden" id="st_frontend_security"
                    value="<?php echo wp_create_nonce('st_frontend_security'); ?>" name="st_frontend_security">
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-5-column">
              <div class="form-group">
                <?php /*Starttime*/
                  $starttime_value = STInput::request('starttime_tour', '');
                  ?>

                <div class="form-group form-more-extra st-form-starttime"
                  <?php echo ($starttime_value != '') ? '' : 'style="display: none"' ?>>
                  <input type="hidden" data-starttime="<?php echo esc_attr($starttime_value); ?>"
                    data-checkin="<?php echo esc_attr($start); ?>" data-checkout="<?php echo esc_attr($end); ?>"
                    data-tourid="<?php echo get_the_ID(); ?>" id="starttime_hidden_load_form"
                    data-posttype="st_activity" />
                  <div class="" id="starttime_box">
                    <label><?php echo __('Start time', 'traveler'); ?></label>
                    <select class="form-control st_tour_starttime" name="starttime" id="starttime_tour"></select>
                  </div>
                </div>
                <!--End starttime-->
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-6 st_check_book_none">
              <div class="form-group">
                <label for="extra-price-wrapper" class="head_bol"><?php _e('Extra', 'traveler'); ?>:</label>
                <div id="extra-price-wrapper">

                </div>
              </div>
            </div>
            <div class="col-xs-12 col-sm-6">
              <div class="form-group">
                <label for="check_out_activity" class="head_bol"><?php _e('Return date', 'traveler'); ?> <span
                    class="text-small text-danger">(*)</span>:</label>
                <?php
		      						$check_out = isset($_POST['check_out']) ? $_POST['check_out'] : '';
		      					?>
                <div class="input-group">
                  <span class="input-group-addon" id="basic-checkout"><i class="fa fa-calendar"></i></span>
                  <input data-date-format="<?php echo TravelHelper::getDateFormatJs() ?>" readonly
                    aria-describedby="basic-checkout" data-date-format="<?php echo TravelHelper::getDateFormatJs(); ?>"
                    autocomplete="off" type="text" name="check_out" id="check_out_activity"
                    value="<?php echo esc_attr($check_out); ?>" class="form-control">
                </div>
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-xs-12 col-sm-12 st_check_book_none">
              <div class="form-group">
                <div id="required_name_html">

                </div>

              </div>
            </div>
          </div>
          <div class="form-group">
            <input type="hidden" name="action" value="booking_form_submit">
            <input type="hidden" name="booking_by" value="partner">
            <input type="hidden" name="sc" value="<?php echo esc_attr(get_query_var('sc')); ?>">
            <input type="hidden" name="st_payment_gateway" value="st_submit_form" />
            <input value="1" name="term_condition" type="hidden" />
            <input type="hidden" name="allow_capcha" value="on">
            <div class="clearfix">
              <div class="row">
                <div class="col-sm-6">
                  <?php
                          $st_site_key_captcha = st()->get_option( 'st_site_key_captcha', '6LdQ4fsUAAAAAOi1Y9yU4py-jx36gCN703stk9y1' );
                          if ( st()->get_option( 'booking_enable_captcha', 'on' ) == 'on' ) {
                          ?>
                  <div class="form-group captcha_box">
                    <input type="hidden" id="st_captcha" name="st_captcha">
                  </div>
                  <script>
                    grecaptcha.ready(function () {
                      grecaptcha.execute('<?php echo esc_attr($st_site_key_captcha);?>', {
                        action: 'st_checkout'
                      }).then(function (token) {
                        var recaptchaResponse = document.getElementById('st_captcha');
                        recaptchaResponse.value = token;
                      });
                    });
                  </script>
                  <?php } ?>

                </div>
              </div>
            </div>
            <input type="hidden" name="security" value="<?php echo esc_attr(wp_create_nonce( 'travel_order' )) ?>">
            <input name='st_payment_gateway_st_submit_form' class="st_payment_gatewaw_submit" type="hidden"
              value="<?php st_the_language('submit_request')?>">
          </div>
          <div class="form-group">
            <a href="#" id="partner-booking-button" class="btn btn-primary"><?php echo __('Book Now','traveler'); ?></a>
          </div>
          <div class="form-group">
            <div class="alert form_alert hidden"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
<div id="activity_time_content" style="padding:15px; display: none">
  <div class="row calendar-wrapper calendar-wrapper-inner">
    <div class="col-xs-12">
      <div class="overlay-form"><i class="fa fa-refresh text-color"></i></div>
      <div class="calendar-content" id="calendar-content">

      </div>
    </div>
  </div>
</div>
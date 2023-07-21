<?php
/**
*@since 1.1.9
* use for Booking Hotel
**/
wp_enqueue_script( 'bootstrap-datepicker.js' ); wp_enqueue_script( 'bootstrap-datepicker-lang.js' );

?>
<div class="st-create">
    <h2><?php _e("Add New Room Booking",'traveler') ?></h2>
</div>
<form action="#" method="post" id="form-add-booking-partner" class="form-add-booking-partner <?php echo STUser_f::get_status_msg(); ?>">
	<?php wp_nonce_field('add_booking_partner','add_booking_partner_field'); ?>
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default">
    		<div class="panel-heading" role="tab" id="headingOne">
      			<h2 class="panel-title">
        			<a style="font-size: 22px; font-weight: 400;"  role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
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
				        <input id="id_user" name="id_user" type="text" readonly="readonly" class="form-control" value="<?php echo esc_attr($pl_name); ?>">
				    </div>
				    <div class="row">
				    	<div class="col-xs-12 col-sm-6">
				    		<div class="form-group form-group-icon-left">

						        <label for="st_first_name" class="head_bol"><?php _e('Customer First Name', 'traveler'); ?> <span class="text-small text-danger">(*)</span>:</label>

						        <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
						        <input id="st_first_name" name="st_first_name" type="text" class="form-control" value="<?php if(isset($_POST['st_first_name'])) echo esc_html($_POST['st_first_name']); ?>">
						    </div>
				    	</div>
				    	<div class="col-xs-12 col-sm-6">
				    		<div class="form-group form-group-icon-left">

						        <label for="st_last_name" class="head_bol"><?php _e('Customer Last Name', 'traveler'); ?> <span class="text-small text-danger">(*)</span>:</label>
						        <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
						        <input id="st_last_name" name="st_last_name" type="text" class="form-control" value="<?php if(isset($_POST['st_last_name'])) echo esc_attr($_POST['st_last_name']); ?>">
						    </div>
				    	</div>
				    </div>
				    <div class="row">
				    	<div class="col-xs-12 col-sm-6">
				    		<div class="form-group form-group-icon-left">

						        <label for="st_email" class="head_bol"><?php _e('Customer Email', 'traveler'); ?> <span class="text-small text-danger">(*)</span>:</label>
						        <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
						        <input id="st_email" name="st_email" type="text" class="form-control" value="<?php if(isset($_POST['st_email'])) echo esc_attr($_POST['st_email']); ?>">
						    </div>
				    	</div>
				    	<div class="col-xs-12 col-sm-6">
				    		<div class="form-group form-group-icon-left">

						        <label for="st_phone" class="head_bol"><?php _e('Customer Phone', 'traveler'); ?> <span class="text-small text-danger">(*)</span>:</label>
						        <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
						        <input id="st_phone" name="st_phone" type="text" class="form-control" value="<?php if(isset($_POST['st_phone'])) echo esc_attr($_POST['st_phone']); ?>">
						    </div>
				    	</div>
				    </div>
				    <div class="row">
				    	<div class="col-xs-12 col-sm-6">
				    		<div class="form-group form-group-icon-left">

						        <label for="st_address" class="head_bol"><?php _e('Customer Address', 'traveler'); ?>:</label>
						        <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
						        <input id="st_address" name="st_address" type="text" class="form-control" value="<?php if(isset($_POST['st_address'])) echo esc_attr($_POST['st_address']); ?>">
						    </div>
				    	</div>
				    	<div class="col-xs-12 col-sm-6">
				    		<div class="form-group form-group-icon-left">

						        <label for="st_address2" class="head_bol"><?php _e('Customer Address 2', 'traveler'); ?>:</label>
						        <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
						        <input id="st_address2" name="st_address2" type="text" class="form-control" value="<?php if(isset($_POST['st_address2'])) echo esc_attr($_POST['st_address2']); ?>">
						    </div>
				    	</div>
				    </div>
				    <div class="row">
				    	<div class="col-xs-12 col-sm-4">
				    		<div class="form-group form-group-icon-left">

						        <label for="st_city" class="head_bol"><?php _e('Customer City', 'traveler'); ?>:</label>
						        <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
						        <input id="st_city" name="st_city" type="text" class="form-control" value="<?php if(isset($_POST['st_city'])) echo esc_attr($_POST['st_city']); ?>">
						    </div>
				    	</div>
				    	<div class="col-xs-12 col-sm-4">
				    		<div class="form-group form-group-icon-left">

						        <label for="st_province" class="head_bol"><?php _e('State/Province/Region', 'traveler'); ?>:</label>
						        <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
						        <input id="st_province" name="st_province" type="text" class="form-control" value="<?php if(isset($_POST['st_province'])) echo esc_attr($_POST['st_province']); ?>">
						    </div>
				    	</div>
				    	<div class="col-xs-12 col-sm-4">
				    		<div class="form-group form-group-icon-left">

						        <label for="st_country" class="head_bol"><?php _e('ZIP code/Postal code', 'traveler'); ?>:</label>
						        <i class="fa  fa-file-text input-icon input-icon-hightlight"></i>
						        <input id="st_country" name="st_country" type="text" class="form-control" value="<?php if(isset($_POST['st_country'])) echo esc_attr($_POST['st_country']); ?>">
						    </div>
				    	</div>
				    </div>
      			</div>
      		</div>
      	</div>
      	<div class="panel panel-default">
    		<div class="panel-heading" role="tab" id="headingTwo">
      			<h2 class="panel-title">
        			<a style="font-size: 22px; font-weight: 400;"  role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
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
	      				<div class="col-xs-12 col-sm-6">
	      					<div class="form-group">
						        <label for="hotel_id" class="head_bol"><?php _e('Room', 'traveler'); ?> <span class="text-small text-danger">(*)</span>:</label>
						        <?php
			                        $room_id = isset($_POST['item_id']) ? $_POST['item_id'] : '';
			                        $room_name = (intval($room_id) > 0) ? get_the_title($room_id) : "";
			                    ?>
			                    <input id="room_id" type="hidden" name="item_id" value="<?php echo esc_attr($room_id); ?>" data-post-type="hotel_room" class="form-control custom-form-control st_post_select_ajax " data-pl-name="<?php echo esc_attr($room_name); ?>" data-user-id="<?php echo get_current_user_id(); ?>">
                                <input class="room_id" type="hidden" name="room_id" value="<?php echo esc_html($room_id) ?>">
                            </div>
	      				</div>
      					<div class="col-xs-12 col-sm-6 st_check_book_none">
      						<div class="form-group">
		      					<label for="item_price" class="head_bol"><?php _e('Room Origin Price', 'traveler'); ?>: <span id="label_room_price"></span></label>
		      					<input id="item_price" readonly type="hidden" name="item_price" value="" class="form-control">
		      				</div>
      					</div>
      				</div>
      				<div class="row">
      					<div class="col-xs-12 col-sm-5-column">
      						<div class="form-group">
		      					<label  for="adult_number" class="head_bol"><?php _e('No. Adults', 'traveler'); ?> <span class="text-small text-danger">(*)</span>:</label>
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
		      							<option value="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></option>
		      						<?php endfor; ?>
		      						</select>
		      					</div>
		      				</div>
      					</div>
      					<div class="col-xs-12 col-sm-5-column">
      						<div class="form-group">
		      					<label for="room_num_search" class="head_bol"><?php _e('No. Rooms', 'traveler'); ?> <span class="text-small text-danger">(*)</span>:</label>
		      					<div id="room-wrapper">
	      						<?php
		      						$room_number = isset($_POST['room_num_search']) ? intval($_POST['room_num_search']) : 1;
		      					?>
		      						<select name="room_num_search" class="form-control" style="width: 100%;">
		      						<?php for($i = 1; $i <= $room_number; $i++): ?>
		      							<option value="<?php echo esc_attr($i); ?>"><?php echo esc_html($i); ?></option>
		      						<?php endfor; ?>
		      						</select>
		      					</div>
		      				</div>
      					</div>
      					<div class="col-xs-12 col-sm-5-column">
      						<div class="form-group">
		      					<label for="check_in" class="head_bol"><?php _e('Check In', 'traveler'); ?> <span class="text-small text-danger">(*)</span>:</label>
		      					<?php
		      						$check_in = isset($_POST['check_in']) ? $_POST['check_in'] : '';
		      					?>
		      					<div class="input-group">
								  	<span class="input-group-addon" id="basic-checkin"><i class="fa fa-calendar"></i></span>
								  	<input readonly aria-describedby="basic-checkin" data-date-format="<?php echo TravelHelper::getDateFormatJs(); ?>" autocomplete="off" type="text" name="check_in" id="check_in" value="<?php echo esc_attr($check_in); ?>" class="form-control">
								</div>

		      				</div>
      					</div>
      					<div class="col-xs-12 col-sm-5-column">
      						<div class="form-group">
		      					<label for="check_out" class="head_bol"><?php _e('Check Out', 'traveler'); ?> <span class="text-small text-danger">(*)</span>:</label>
		      					<?php
		      						$check_out = isset($_POST['check_out']) ? $_POST['check_out'] : '';
		      					?>
		      					<div class="input-group">
			      					<span class="input-group-addon" id="basic-checkout"><i class="fa fa-calendar"></i></span>
								  	<input readonly aria-describedby="basic-checkout" data-date-format="<?php echo TravelHelper::getDateFormatJs(); ?>" autocomplete="off" type="text" name="check_out" id="check_out" value="<?php echo esc_attr($check_out); ?>" class="form-control">
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
      				<div class="row">
      					<div class="col-xs-12 col-sm-12 st_check_book_none">
      						<div class="form-group">
		      					<label for="extra-price-wrapper"  class="head_bol"><?php _e('Extra', 'traveler'); ?>:</label>
		      					<div id="extra-price-wrapper">

		      					</div>
		      				</div>
      					</div>
      				</div>
      				<div class="form-group">
      					<input type="hidden" name="action" value="booking_form_submit">
      					<input type="hidden" name="booking_by" value="partner">
      					<input type="hidden" name="sc" value="<?php echo esc_attr(get_query_var('sc')); ?>">
      					<input type="hidden" name="st_payment_gateway" value="st_submit_form"/>
      					<input value="1" name="term_condition" type="hidden"/>
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
												grecaptcha.execute('<?php echo esc_attr($st_site_key_captcha);?>', { action: 'st_checkout' }).then(function (token) {
													var recaptchaResponse = document.getElementById('st_captcha');
													recaptchaResponse.value = token;
												});
											});
										</script>
									<?php } ?>
									
								</div>
							</div>
						</div>
      					<input type="hidden" name="security" value="<?php echo esc_attr(wp_create_nonce( 'travel_order' ))?>">
					     <input name='st_payment_gateway_st_submit_form'  class="st_payment_gatewaw_submit" type="hidden" value="<?php st_the_language('submit_request')?>">
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

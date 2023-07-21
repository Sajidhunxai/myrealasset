<?php
/**
 * Created by PhpStorm.
 * User: Dungdt
 * Date: 12/16/2015
 * Time: 6:03 PM
 */
?>
<div class="pm-info">
	<div class="row">
		<div class="col-sm-6">
			<div class="col-card-info">
				<div class="form-group first">
					<label for="st_authorize_card_name"><?php _e('Name on the Card (*)','traveler') ?></label>
					<div class="controls">
						<input type="text" class="form-control" align="" name="st_authorize_card_name" id="st_authorize_card_name" placeholder="<?php _e('Card name','traveler') ?>">
					</div>
				</div>
				<div class="form-group second">
					<label for="st_authorize_card_number"><?php _e('Card number (*)','traveler') ?></label>
					<div class="controls">
						<input type="text" class="form-control" align="" name="st_authorize_card_number" id="st_authorize_card_number" placeholder="<?php _e('Your card number','traveler') ?>">
					</div>
				</div>
				<div class="card-code-expiry">
					<div class="form-group expiry-date">
						<div class="controls clearfix">
							<div class="form-control-wrap">
								<label for="st_authorize_card_expiry_month"><?php _e('Month (*)','traveler') ?></label>
								<select name="st_authorize_card_expiry_month" id="st_authorize_card_expiry_month" class="form-control app required">
									<optgroup label="<?php _e('Month','traveler')?>">
										<?php
										for($i=1;$i<=12;$i++){
											printf('<option value="%s">%s</option>',$i,$i);
										} ?>
									</optgroup>
								</select>
							</div>
							<div class="form-control-wrap">
                                <label for="st_authorize_card_expiry_year"><?php _e('Year (*)','traveler') ?></label>
								<select name="st_authorize_card_expiry_year" id="st_authorize_card_expiry_year" class="form-control app required">
									<optgroup label="<?php _e('Year','traveler')?>">
										<?php
										$y=date('Y');
										for($i=date('Y');$i<$y+49;$i++){
											printf('<option value="%s">%s</option>',$i,$i);
										} ?>
									</optgroup>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group card-code">
						<label for="st_authorize_card_code"><?php _e('CVV (*)','traveler') ?></label>
						<div class="controls">
							<input type="text" class="form-control" align="" name="st_authorize_card_code" id="st_authorize_card_code">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
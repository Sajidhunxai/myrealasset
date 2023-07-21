<div class="traveler-important-notice">

	<div class="traveler-registration-steps">

		<div class="feature-section st_admin_support">

			<div class="st_col_12">

				<h3>

					<?php echo __('Sync Price','traveler')?>

				</h3>

				<div class="updated" style="padding: 8px 10px 5px 10px !important; margin-left: 0px; margin-top: 15px;"><?php echo __('Recommend : To avoid losing data, Please backup the database before running','traveler')?></div>

				<p class="control-form">

					<input type="hidden" name="_s" id="st_security_sync_price" value="<?php echo wp_create_nonce( "st_security_sync_price" ); ?>">

					<a class="button button-large button-primary" id="st_sync_price"><?php echo __('Sync Now','traveler')?><i class="fa fa-spin fa-spinner" style="display:none"></i></a>

				</p>

			</div>

		</div>

	</div>



</div>


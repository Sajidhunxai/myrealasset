<?php
/**
 *@since 1.3.1
 *    Template Name: Member Checkout Success
 **/
$token = STInput::get('order_token_code','');
$status = STInput::get('status');

$admin_packages = STAdminPackages::get_inst();
$cls_packages = STPackages::get_inst();
$get_order_by_token = $cls_packages->get_order_by_token($token);
if( !$get_order_by_token || !$admin_packages->enabled_membership() ){
	wp_redirect( home_url( '/' ) );
	exit();
}
$cls_packages->update_order($token, $status);
$get_order_by_token = $cls_packages->get_order_by_token($token);
get_header();
?>
<div class="gap"></div>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 text-center mb50">
			<?php 
				if( $get_order_by_token->status === 'completed' || $get_order_by_token->status === 'incomplete' ): 
			?>
				<i class="fa fa-check round box-icon-large box-icon-center box-icon-success mb30"></i>
				<h2 class="text-center">
					<?php
						$userdata = get_userdata( $get_order_by_token->partner );

					    echo esc_html($userdata->user_login);
					    echo ', ';
					    echo __('your payment was successful!' , 'traveler' ) ; ;
					?>
				</h2>
			<?php elseif( $get_order_by_token->status === 'canceled' ): ?>
				<i class="fa fa-times round box-icon-large box-icon-center box-icon-danger mb30"></i>
				<h2 class="text-center">
					<?php
						$userdata = get_userdata( $get_order_by_token->partner );

					    echo esc_html($userdata->user_login);
					    echo ', ';
					    echo __('your payment was not successful!' , 'traveler' ) ; ;
					?>
				</h2>
			<?php endif; ?>
			<h5 class="text-center mb30">
			<?php 
				_e('Booking details have been sent to: ','traveler');
				$partner_info = unserialize($get_order_by_token->partner_info);
    			echo esc_html($partner_info['email']);
			?>
    		</h5>
    		<p><strong><?php echo __('Order Number:' , 'traveler' ) ;  ?></strong> ORDER-<?php echo esc_html($get_order_by_token->id); ?></p>
    		<p><strong><?php echo __('Status:' , 'traveler' ) ;  ?></strong> 
				<?php
					$status  = esc_attr($get_order_by_token->status);
					if( $status == 'incomplete'){
						echo '<span class="order-status warning">'. $status . '</span>';
					}elseif($status == 'completed'){
						echo '<span class="order-status success">'. $status . '</span>';
					}elseif($status == 'cancelled'){
						echo '<span class="order-status danger">'. $status . '</span>';
					}
				?>
    		</p>
    		<p><strong><?php echo __('Date:' , 'traveler' ) ;  ?></strong> <?php echo date('Y/m/d', $get_order_by_token->created); ?></p>
    		<p><strong><?php echo __('Payment Method:' , 'traveler' ) ;  ?></strong> <?php echo balanceTags($cls_packages->convert_payment($get_order_by_token->gateway)); ?></p>
    		<h2 class="text-center mt30"><?php echo __('Package Infomation', 'traveler'); ?></h2>
    		<p><strong><?php echo __('Package:' , 'traveler' ) ;  ?></strong> <span class="color-main uppercase"><?php echo esc_html($get_order_by_token->package_name); ?></span></p>
    		<p><strong><?php echo __('Time Available:' , 'traveler' ) ;  ?></strong> <?php echo balanceTags($admin_packages->convert_item($get_order_by_token->package_time, true)); ?></p>
    		<p><strong><?php echo __('Commission:', 'traveler') ?></strong> <?php echo esc_html($get_order_by_token->package_commission) . '%'; ?></p>
    		<p><strong><?php echo __('No. Items can upload:', 'traveler') ?></strong> <?php echo esc_html($get_order_by_token->package_item_upload); ?></p>
    		<p><strong><?php echo __('No. Items can set featured:', 'traveler') ?></strong> <?php echo esc_html($get_order_by_token->package_item_featured); ?></p>
			
			<?php 
				$partner_info = $get_order_by_token->partner_info;
				if( !empty($partner_info) ):
					$partner_info = unserialize($partner_info);
			?>
	    		<h2 class="mt50"><?php echo __('Partner Information' , 'traveler') ;  ?></h2>
				<table cellpadding="0" cellspacing="0" width="100%" border="0px" class="mb30 tb_cart_customer">
				<tbody>
				<tr>
				    <td width="50%" style="border-bottom: 1px dashed #ccc;padding:10px;">
				        <strong><?php echo __('First name' , 'traveler') ;  ?></strong></td>
				    <td align="right" class="text-right" style="border-bottom: 1px dashed #ccc;padding:10px;">
				        <?php echo esc_attr($partner_info['firstname'] ); ?>
				    </td>
				</tr>
				<tr>
				    <td width="50%" style="border-bottom: 1px dashed #ccc;padding:10px;">
				        <strong><?php echo __('Last name' , 'traveler') ;  ?></strong></td>
				    <td align="right" class="text-right" style="border-bottom: 1px dashed #ccc;padding:10px;">
				        <?php echo esc_attr($partner_info['lastname'] ); ?>
				    </td>
				</tr>
				<tr>
				    <td width="50%" style="border-bottom: 1px dashed #ccc;padding:10px;">
				        <strong><?php echo __('Email' , 'traveler') ;  ?></strong></td>
				    <td align="right" class="text-right" style="border-bottom: 1px dashed #ccc;padding:10px;">
				        <?php echo esc_attr($partner_info['email'] ); ?>
				    </td>
				</tr>
				<tr>
				    <td width="50%" style="border-bottom: 1px dashed #ccc;padding:10px;">
				        <strong><?php echo __('Phone' , 'traveler') ;  ?></strong></td>
				    <td align="right" class="text-right" style="border-bottom: 1px dashed #ccc;padding:10px;">
				        <?php echo esc_attr($partner_info['phone'] ); ?>
				    </td>
				</tr>
				</tbody>
				</table>
			<?php endif; ?>
			<?php 
				if (is_user_logged_in()):
				$page_user = st()->get_option('page_my_account_dashboard');
				if ($link = get_permalink($page_user)):
			    	$link=esc_url(add_query_arg(array('sc'=>'setting'),$link));
		    ?>
			    <div class="text-center mg20">
			        <a href="<?php echo esc_url($link)?>" class="btn btn-primary">
			        	<i class="fa fa-book"></i> 
			        	<?php echo __('Partner Infomation' , 'traveler') ;  ?>
			        </a>
			    </div>
			<?php endif; endif; ?>
		</div>
	</div>
</div>
<?php get_footer();?>
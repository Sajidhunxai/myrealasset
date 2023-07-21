<?php 
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.3.1
 *
 * Class STAttribute
 *
 * Created by ShineTheme
 *
 */
 ?>
 <div class="wrap woocommerce">
    <div class="icon32 icon32-attributes" id="icon-woocommerce"><br/></div>
    <h2><?php _e( 'Member Packages', 'traveler' ) ?></h2>
    <br class="clear" />
    <div id="col-container">
        <div id="col-left">
            <?php if ( !empty( $message)) : ?>
                <div id="message" class="updated notice notice-success is-dismissible"><p><?php echo $message; ?></p></div>
            <?php endif; ?>
            <div class="col-wrap">
                <div class="form-wrap">
                    <h3><?php _e( 'Add New Package', 'traveler' ) ?></h3>
                    <form action="#" method="post">
                        <div class="form-field">
                            <label for="package_label"><?php _e( 'Name', 'traveler' ); ?></label>
                            <input name="package_label" id="package_label" type="text" value="<?php echo STInput::post('package_label',''); ?>" />
                            <p class="description"><?php _e( 'Name of package.', 'traveler' ); ?></p>
                        </div>
                        <div class="form-field">
                            <label for="package_subname"><?php _e( 'Sub name', 'traveler' ); ?></label>
                            <input name="package_subname" id="package_subname" type="text" value="<?php echo STInput::post('package_subname',''); ?>" />
                            <p class="description"><?php _e( 'Sub-name of package.', 'traveler' ); ?></p>
                        </div>

                        <div class="form-field">
                            <label for="package_price"><?php _e( 'Price', 'traveler' ); ?></label>
                            <input type="number" name="package_price" id="package_price" value="<?php echo STInput::post('package_price',''); ?>" min="0" step="1">
                            <p class="description"><?php _e( 'Price of package.', 'traveler' ); ?></p>
                        </div>

                        <div class="form-field package-list-service">
                            <label for="package_service"><?php _e( 'Services', 'traveler' ); ?></label>
                            <?php
                                $list_services = STUser_f::_get_service_available();
                                if(!empty($list_services)){
                                    echo '<label><input type="checkbox" name="package_services[]" value="all" /> '. __('All', 'traveler') .'</label>';
                                    foreach ($list_services as $k => $v){
                                        $obj = get_post_type_object( $v );
                                        echo '<label><input type="checkbox" name="package_services[]" value="'. $v .'" /> '. $obj->labels->singular_name .'</label>';
                                    }
                                }

                            ?>
                            <p class="description"><?php _e( 'Assign service for membership package.', 'traveler' ); ?></p>
                        </div>
						
						<div class="form-field">
                            <label for="package_available"><?php _e( 'Time available (days)', 'traveler' ); ?></label>
                            <input type="number" name="package_available" id="package_available" value="<?php echo STInput::post('package_available',''); ?>" min="0" step="1">
                            <p class="description"><?php _e( 'Time available of package. Leave emty for unlimited.', 'traveler' ); ?></p>
                        </div>

                        <div class="form-field">
                        	<?php 
                        		$default_commission = (float)st()->get_option('partner_commission','0');
                        	?>
                            <label for="package_commision"><?php _e( 'Commission (%)', 'traveler' ); ?></label>
                            <input type="number" name="package_commision" id="package_commision" value="<?php echo STInput::post('package_commision',esc_attr( $default_commission )); ?>" min="0" step="1">
                            <p class="description"><?php _e( 'The commission between admin and partner. Default from Theme Settings -> Partner Options -> Commissions', 'traveler' ); ?></p>
                        </div>
                        <div class="form-field">
                            <label for="package_item_upload"><?php _e( 'Number of item can upload', 'traveler' ); ?></label>
                            <input type="number" name="package_item_upload" id="package_item_upload" value="<?php echo STInput::post('package_item_upload',''); ?>" min="0" step="1">
                            <p class="description"><?php _e( 'Number of item can upload. Leave emty for unlimited.', 'traveler' ); ?></p>
                        </div>
						<div class="form-field">
                            <label for="package_item_featured"><?php _e( 'Number of item can set the featured', 'traveler' ); ?></label>
                            <input type="number" name="package_item_featured" id="package_item_featured" value="<?php echo STInput::post('package_item_featured',''); ?>" min="0" step="1">
                            <p class="description"><?php _e( 'Number of item can set featured. Leave emty for unlimited.', 'traveler' ); ?></p>
                        </div>
						<div class="form-field">
                            <label for="package_description"><?php _e( 'Description', 'traveler' ); ?></label>
                            <textarea name="package_description" id="package_description" cols="30" rows="10"><?php echo STInput::post('package_description',''); ?></textarea>
                            <p class="description"><?php _e( 'Description.', 'traveler' ); ?></p>
                        </div>

                        <input type="hidden" name="action" value="st_add_member_package">

                        <p class="submit"><input type="submit" name="st_add_member_package" id="submit" class="button" value="<?php _e( 'Add Package', 'traveler' ); ?>"></p>
                    </form>
                </div>
            </div>
        </div>
        <div id="col-right">
            <div class="col-wrap">
                <table class="widefat attributes-table wp-list-table ui-sortable" style="width:100%">
                    <thead>
                    <tr>
                        <th scope="col">
                        	<?php _e( 'Package Name', 'traveler' ) ?>
                        </th>
                        <th scope="col"><?php _e( 'Price', 'traveler' ) ?></th>
                        <th scope="col"><?php _e( 'Time Available', 'traveler' ) ?></th>
                        <th scope="col"><?php _e( 'Commission', 'traveler' ) ?></th>
                        <th scope="col"><?php _e( 'Items can be uploaded', 'traveler' ) ?></th>
                        <th scope="col"><?php _e( 'Items can set featured', 'traveler' ) ?></th>
                        <th scope="col"><?php _e( 'Services', 'traveler' ) ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    	$cls_packages = STAdminPackages::get_inst();
                        $packages = $cls_packages->get_packages();
						if( !empty( $packages ) ):
							foreach( $packages as $key => $package ):
                    ?>
                	<tr>
                		<td>
                			<a href="<?php echo esc_url( add_query_arg('edit_package', (int) $package->id) ); ?>">
                        		<strong><?php echo esc_attr( $package->package_name ); ?></strong>
                        	</a> 
                			<div class="row-actions">
                        		<span class="edit">
                        			<a href="<?php echo esc_url( add_query_arg('edit_package', (int) $package->id) ); ?>">
                        				<?php _e( 'Edit', 'traveler' ); ?>
                        			</a> 
                        			| 
                        		</span>
                        		<span class="delete">
                        			<a class="delete" href="<?php echo esc_url( wp_nonce_url( add_query_arg('delete_package', (int) $package->id), 'st_delete_package' ) ); ?>">
                        				<?php _e( 'Delete', 'traveler' ); ?>
                        			</a>
                        		</span>
                        	</div>
                		</td>
						<td><?php echo TravelHelper::format_money((float)$package->package_price); ?></td>
						<td>
                            <?php echo esc_html($cls_packages->convert_item($package->package_time, true)); ?>
                        </td>
						<td><?php echo (int) $package->package_commission. '%'; ?></td>
						<td><?php echo esc_html($cls_packages->convert_item($package->package_item_upload)); ?></td>
						<td><?php echo esc_html($cls_packages->convert_item($package->package_item_featured)); ?></td>
                        <td><?php echo esc_html($cls_packages->paser_list_services($package->package_services)); ?></td>
                	</tr>

					<?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
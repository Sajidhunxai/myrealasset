<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User setting
 *
 * Created by ShineTheme
 *
 */
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$role = $current_user->roles;
$role = array_shift($role);
?>
<div class="row div-partner-page-title">
    <div class="col-md-12">
        <h3 class="partner-page-title"><?php STUser_f::get_title_account_setting() ?></h3>
    </div>

    <div class="msg">
        <?php
        if (!empty(STUser_f::$msg_uptp)) {
            STUser_f::get_mess_utp();
        }
        ?>
    </div>
<div class="col-md-12">
<?php
    $admin_packages = STAdminPackages::get_inst();
    $order = $admin_packages->get_order_by_partner(get_current_user_id());
    $enable = $admin_packages->enabled_membership();
    if($enable && $admin_packages->get_user_role() == 'partner'):
        if( $order ):
        ?>
        <div class="row mb20">
            <div class="col-xs-12">
                <div class="partner-package-info">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <div class="packages-heading">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/membership.png" alt="<?php echo TravelHelper::get_alt_image(); ?>" class="heading-image img-responsive">
                            </div>
                            <h3 class="uppercase color-main"><strong><?php echo esc_html($order->package_name ); ?></strong></h3>
                            <?php
                                $status  = esc_attr($order->status);
                                if( $status == 'incomplete'){
                                    $string_status = __('Incomplete','traveler');
                                    echo '<span class="order-status warning">'. balanceTags($string_status) . '</span>';
                                }elseif($status == 'completed'){
                                    $string_status = __('Completed','traveler');
                                    echo '<span class="order-status success">'. balanceTags($string_status) . '</span>';
                                }elseif($status == 'cancelled'){
                                    $string_status = __('Cancelled','traveler');
                                    echo '<span class="order-status danger">'. balanceTags($string_status) . '</span>';
                                }
                            ?>
                            <?php
                                $can_upgrade = $admin_packages->can_upgrade($user_id);
                                if($can_upgrade):
                                    $link = $admin_packages->register_member_page();
                                    $link = add_query_arg('upgrade', TravelHelper::st_encrypt($user_id), $link);
                            ?>
                            <br>
                                <a class="mt10 btn btn-primary" href="<?php echo esc_url( $link ); ?>"><?php echo __('Upgrade', 'traveler') ?></a>
                            <?php endif; ?>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <h4 class="text-center"><?php echo __('Package Details', 'traveler'); ?></h4>
                            <div class="mt10 text-center">

                            <?php
                                $currency = get_post_meta($order->id,'currency', true );
                                $currency = (isset($currency['symbol']))? $currency['symbol']: '';
                            ?>
                                <strong><?php echo __('Price', 'traveler'); ?>: </strong><?php echo TravelHelper::format_money_raw((float)$order->package_price, $currency); ?>
                            </div>
                            <div class="mt10 text-center">
                                <?php
                                if($admin_packages->convert_item($order->package_time, true) === 'Unlimited'){
                                    $time_available = __('Unlimited', 'traveler');
                                } else {
                                    $time_available = $admin_packages->convert_item($order->package_time, true);
                                }
                                ?>
                                <strong><?php echo __('Time Available', 'traveler'); ?>: </strong><?php echo esc_html($time_available); ?>
                            </div>
                            <div class="mt10 text-center">
                                <strong><?php echo __('Commission', 'traveler'); ?>: </strong><?php echo esc_attr( $order->package_commission ). '%'; ?>
                            </div>
                            <div class="mt10 text-center">
                                <?php
                                if($order->package_item_upload === 'unlimited'){
                                    $package_item_upload = __('Unlimited', 'traveler');
                                } else {
                                    $package_item_upload = $order->package_item_upload;
                                }
                                ?>
                                <strong><?php echo __('No. Items can upload', 'traveler'); ?>: </strong><?php echo esc_html( $package_item_upload ); ?>
                            </div>
                            <div class="mt10 text-center">
                                <?php
                                    if($order->package_item_featured === 'unlimited'){
                                        $package_item_featured = __('Unlimited', 'traveler');
                                    } else {
                                        $package_item_featured = $order->package_item_featured;
                                    }
                                ?>
                                <strong><?php echo __('No. Items can set Featured', 'traveler'); ?>: </strong><?php echo esc_html( $package_item_featured ); ?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <h5 class="text-center"><?php echo __('Activation date', 'traveler'); ?></h5>
                            <p class="text-center"><strong><?php echo date('Y-m-d', $order->created); ?></strong></p>
                            <h5 class="text-center"><?php echo __('Expiration date', 'traveler'); ?></h5>
                            <p class="text-center">
                                <strong>
                                    <?php
                                    if($order->package_time == 'unlimited'){
                                        echo esc_html__('Unlimited',  'traveler');
                                    }else{
                                        $date = strtotime('+'. (int) $order->package_time . ' days', $order->created);
                                        echo $date_end = date('Y-m-d', $date);
                                    }
                                    
                                    ?>
                                </strong>
                                
                                
                            </p>
                           
                            <?php 
                             $number_left = STDate::dateDiff(date('Y-m-d'),$date_end);
                                if($number_left > 0){ ?>
                                    <p class="text-center">
                                    <strong>
                                        <?php 
                                        echo esc_html($number_left);
                                        echo ( $number_left == 1 ) ? __( ' (Day left)', 'traveler' ) : __( ' (Days left)', 'traveler' ); ?>
                                    </strong>
                                </p>
                                <?php }
                            ?>
                            
                            <h5 class="text-center"><?php echo __('Services', 'traveler'); ?></h5>
                            <p class="text-center">
                                <strong>
                                    <?php echo esc_html($admin_packages->paser_list_services($order->package_services)); ?>
                                </strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <?php
                    $item_can_public = $admin_packages->count_item_can_public(get_current_user_id());
                    if($item_can_public < 0 ):
                ?>
                <div class="alert alert-warning mt20">
                    <?php
                        echo __('<strong>PACKAGE INFORMATIONS:</strong> Some of your items are not published because it exceeds the amount of the package.', 'traveler')
                    ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php else: ?>
            <div class="row mb20">
                <div class="col-xs-12">
                    <div class="partner-package-info">
                        <div class="packages-heading">
                            <img src="<?php echo get_template_directory_uri(); ?>/img/membership.png" alt="<?php echo TravelHelper::get_alt_image(); ?>" class="heading-image img-responsive">
                        </div>
                        <p class="text-warning">
                            <?php echo __('Your account need to register a membership package to continue using.', 'traveler'); ?>
                        </p>
                        <a class="btn btn-primary mt10" href="<?php echo esc_url( $admin_packages->register_member_page() ); ?>"><?php echo __('Register', 'traveler') ?></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php
        endif;
?>
<div class="infor-st-setting">
    <form method="post" action="" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <?php
                if(!empty($_REQUEST['status'])){
                    if($_REQUEST['status'] == 'success'){
                        echo '<div class="alert alert-'.esc_attr($_REQUEST['status']).'">
                                <button data-dismiss="alert" type="button" class="close"><span aria-hidden="true">×</span>
                                </button>
                                <p class="text-small">'.st_get_language('user_update_successfully').'</p>
                              </div>';
                    }
                    if($_REQUEST['status'] == 'danger'){
                        echo '<div class="alert alert-'.esc_attr($_REQUEST['status']).'">
                                <button data-dismiss="alert" type="button" class="close"><span aria-hidden="true">×</span>
                                </button>
                                <p class="text-small">'.__("Update not successfully",'traveler').'</p>
                              </div>';
                    }
                }
                ?>
                <?php wp_nonce_field('user_setting','st_update_user'); ?>
                <input type="hidden" name="id_user" value="<?php echo esc_attr($data->ID) ?>">
                <h4><?php st_the_language('user_personal_infomation') ?></h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <div class="form-group form-group-filled">
                    <label for="st_name"><?php echo __('Username', 'traveler'); ?></label>
                    <input readonly class="form-control" value="<?php echo esc_attr($data->user_login) ?>" type="text"/>
                </div>
                <div class="form-group form-group-filled">
                    <label for="st_paypal_email"><?php esc_html_e("Paypal Email",'traveler') ?></label>
                    <input name="st_paypal_email" class="form-control" value="<?php echo esc_attr(get_user_meta($data->ID , 'st_paypal_email' , true)) ?>" type="text" />
                </div>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="form-group form-group-filled">
                    <label for="st_email"><?php st_the_language('user_mail') ?></label>
                    <input name="st_email" class="form-control" value="<?php echo esc_attr($data->user_email) ?>" type="text" />
                </div>
                <?php 
                    @ob_start();
                ?>
                <div class="form-group form-group-filled">
                    <label for="st_phone"><?php st_the_language('user_phone_number') ?></label>
                    <input name="st_phone" class="form-control" value="<?php echo esc_attr(get_user_meta($data->ID , 'st_phone' , true)) ?>" type="text" />
                </div>
                <?php 
                    $html= @ob_get_clean();
                    echo apply_filters('st_user_settings_phone_field', $html, $data);
                ?>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="gap gap-small"></div>
                <div class="form-group form-group-filled">
                    <label for="st_phone"><?php echo __('About Yourself', 'traveler'); ?></label>
                    <textarea rows="6" name="st_bio" class="form-control" ><?php echo esc_attr(get_user_meta($data->ID , 'st_bio' , true)); ?></textarea>
                </div>
                <div class="gap gap-small"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-icon-left">
                    <div class="checkbox">
                        <label for="st_is_check_show_info" class="st_is_check_show_">
                            <?php
                            $is_check =  get_user_meta($data->ID , 'st_is_check_show_info' , true);
                            if(!empty($is_check)){
                                $is_check = 'checked="checked"';
                            }
                            ?>
                            <input <?php echo esc_attr($is_check); ?> name="st_is_check_show_info" class="i-check" type="checkbox" />
                            <?php st_the_language('show_email_and_phone_number_to_other_account') ?>
                        </label>
                    </div>
                </div>
                <div class="form-group form-group-icon-left">
                    <div class="st-line-bg"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group form-group-icon-left">
                    <?php
                    $id_img = get_user_meta($user_id , 'st_avatar' , true);
                    $url_avatar = "";
                    $post_thumbnail_id = wp_get_attachment_image_src($id_img, 'full');
                    if(!empty($post_thumbnail_id)){
                        $url_avatar = array_shift($post_thumbnail_id);
                    }
                    ?>
                    <div class="st-change-avatar">
                        <?php
                        if(!empty($url_avatar)){
                            echo '<div class="user-profile-avatar user_seting">
                                    <img width="50" height="50" class="avatar avatar-300 photo img-thumbnail" src="'.esc_url($url_avatar).'" alt="'.TravelHelper::get_alt_image().'">
                                  </div>';
                        } else {
                            echo '<div class="user-profile-avatar user_seting">
                                    <img width="50" height="50" class="avatar avatar-300 photo img-thumbnail" src="'.esc_url(get_avatar_url($user_id)).'">
                                  </div>';
                        }
                        ?>
                        <div class="st-title">
                            <p class="title">
                                <?php _e("Change Avatar",'traveler');?>
                            </p>
                            <p>
                                <?php _e("JPG or PNG",'traveler');?>
                            </p>
                        </div>
                    </div>


                </div>
            </div>
            <div class="col-md-9">
                <div class="form-group form-group-icon-left">
                    <div class="input-group setting-avatar">
                        <span class="input-group-btn">
                            <span class="btn btn-primary btn-file" >
                                <span class="st-upload-avatar" data-multi="false" data-output="id"><?php _e("Avatar",'traveler') ?></span>
                            </span>
                        </span>
                        <input id="id_avatar_user_setting" name="id_avatar" type="hidden" value="<?php echo esc_attr($id_img) ?>">
                        <input type="hidden" readonly="" value="<?php echo esc_url($url_avatar); ?>" class="form-control data_lable">
                        <div class="st-selection">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-icon-left">
                    <div class="st-line-bg"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4 style="margin-top: 30px;"><?php st_the_language('user_location') ?></h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group form-group-filled">
                    <label for="st_airport"><?php st_the_language('user_home_airport') ?></label>
                    <input name="st_airport" class="form-control" value="<?php echo esc_attr(get_user_meta($data->ID , 'st_airport' , true)) ?>" type="text" />
                </div>
                <div class="form-group">
                    <label for="st_province"><?php st_the_language('user_state_province_region') ?></label>
                    <input name="st_province" class="form-control" value="<?php echo esc_attr(get_user_meta($data->ID , 'st_province' , true)) ?>" type="text" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="st_address"><?php st_the_language('user_street_address') ?></label>
                    <input name="st_address" class="form-control" value="<?php echo esc_attr(get_user_meta($data->ID , 'st_address' , true)) ?>" type="text" />
                </div>
                <div class="form-group">
                    <label for="st_zip_code"><?php st_the_language('user_zip_code_postal_code') ?></label>
                    <input name="st_zip_code" class="form-control" value="<?php echo esc_attr(get_user_meta($data->ID , 'st_zip_code' , true)) ?>" type="text" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="st_city"><?php st_the_language('user_city') ?></label>
                    <input name="st_city" class="form-control" value="<?php echo esc_attr(get_user_meta($data->ID , 'st_city' , true)) ?>" type="text" />
                </div>
                <div class="form-group">
                    <label for="st_country"><?php st_the_language('user_country') ?></label>
                    <input name="st_country" class="form-control" value="<?php echo esc_attr(get_user_meta($data->ID , 'st_country' , true)) ?>" type="text" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-icon-left">
                    <div class="st-line-bg"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-icon-left">
                    <input name="st_btn_update" type="submit" class="btn btn-primary" value="<?php st_the_language('user_save_changes') ?>">
                </div>
            </div>
        </div>
    </form>

</div>

<div class="infor-st-setting" style="margin-bottom: 157px;">
    <form method="post" action="">
        <?php wp_nonce_field('user_setting','st_update_pass'); ?>
        <div class="row">
            <div class="col-md-12">
                <h4><?php st_the_language('user_change_password') ?></h4>
                <div class="msg">
                    <?php
                    if(!empty(STUser_f::$msg)){
                        echo '<div class="alert alert-'.STUser_f::$msg['status'].'">
                                <button data-dismiss="alert" type="button" class="close"><span aria-hidden="true">×</span>
                                </button>
                                <p class="text-small">'.STUser_f::$msg['msg'].'</p>
                              </div>';
                    }?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <input type="hidden" name="user_login" value="<?php echo esc_attr($data->user_login) ?>">
                <div class="form-group form-group-filled">
                    <label for="old_pass"><?php st_the_language('user_current_password') ?></label>
                    <input name="old_pass" class="form-control" type="password" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group form-group-filled">
                    <label for="new_pass"><?php st_the_language('user_new_password') ?></label>
                    <input name="new_pass" class="form-control" type="password" />
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group form-group-filled">
                    <label for="new_pass_again"><?php st_the_language('user_new_password_again') ?></label>
                    <input name="new_pass_again" class="form-control" type="password" />
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-filled">
                    <div class="st-line-bg"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-filled">
                    <input name="btn_update_pass" class="btn btn-primary" type="submit" value="<?php st_the_language('user_change_password') ?>" />
                </div>
            </div>
        </div>
    </form>
</div>

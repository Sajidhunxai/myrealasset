<?php
$token = STInput::get('order_token_code','');
$status = STInput::get('status');

$admin_packages = STAdminPackages::get_inst();
$cls_packages = STPackages::get_inst();
$get_order_by_token = $cls_packages->get_order_by_token($token);
$cls_packages->update_order($token, $status);
if( !$get_order_by_token || !$admin_packages->enabled_membership() ){
    wp_redirect( home_url( '/' ) );
    exit();
}

$abc_packages = STAdminPackages::get_inst();
get_header();
?>
<div id="st-content-wrapper" class="st-package-success-wrapper st-checkout-page  st-page-default member-package-layout2">
    <?php echo st()->load_template('layouts/modern/hotel/elements/banner'); ?>
    <?php st_breadcrumbs_new(); ?>
    <div class="st-package-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php if(isset($_REQUEST['order_token_code']) && $get_order_by_token->status  !== 'completed' && $get_order_by_token->gateway === 'st_razor'){
                        do_action( 'st_receipt_st_razor_package', $get_order_by_token->id );
                    }?>
                </div>
            </div>
            <div class="box_info_payment">
                <div class="row">
                    <div class="col-md-12 col-lg-8">
                        <div class="d-flex align-items-center st-notice-success">
                            <?php 
                                if( $get_order_by_token->status === 'completed' || $get_order_by_token->status === 'incomplete' || $get_order_by_token->status === 'pending' ): 
                            ?>
                            <div class="icon-success">
                                <img src="<?php echo get_template_directory_uri().'/v3/images/ico_success_new.svg';?>" alt="">
                            </div>
                            <div class="title-admin">
                                <p class="st-admin-success"><?php $userdata = get_userdata( $get_order_by_token->partner );echo !empty($userdata->user_login) ? esc_html($userdata->user_login) : '' ; echo ', ';?> <span><?php echo __('your checkout was successful!' , 'traveler' );?></span></p>
                                <p class="st-text">
                                    <?php echo __('Booking details have been sent to: ' , 'traveler' );
                                    $partner_info = unserialize($get_order_by_token->partner_info);
                                    echo '<span>'.balanceTags($partner_info['email']).'</span>';  ?>
                                </p>
                            </div>
                            <?php elseif( $get_order_by_token->status === 'canceled' ): ?>
                                <div class="icon-success">
                                    <img src="<?php echo get_template_directory_uri().'/v2/images/ico_success.svg';?>" alt="">
                                </div>
                                <div class="title-admin">
                                    <p class="st-admin-success"><?php $userdata = get_userdata( $get_order_by_token->partner );echo !empty($userdata->user_login) ? esc_html($userdata->user_login) : ''; echo ', ';  echo __('Your payment was not successful!' , 'traveler' );?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-4">
                        <div class="sidebar-order">
                            <ul class="list-unstyled st-list-sider-info">
                                <li>
                                    <p><?php echo __('Booking Number: ','traveler');?></p>
                                    <p><span><strong><?php echo esc_html($get_order_by_token->id); ?></strong></span></p>
                                </li>
                                <li>
                                    <p><?php echo __('Booking Date: ','traveler');?></p>
                                    <p><span><strong><?php echo date('Y/m/d', $get_order_by_token->created); ?></strong></span></p>
                                </li>
                                <li>
                                    <p><?php echo __('Payment Method: ','traveler');?></p>
                                    <p><span><strong><?php echo balanceTags($cls_packages->convert_payment($get_order_by_token->gateway)); ?></strong></span></p>
                                </li>
                                <li>
                                    <p><?php echo __('Status: ','traveler');?>
                                    </p>
                                    <p>
                                        <?php
                                    
                                            $status  = esc_attr($get_order_by_token->status);
                                            if( $status == 'incomplete'){
                                                echo '<span class="order-status warning"><strong>'. $status . '</strong></span>';
                                            }elseif($status == 'completed'){
                                                echo '<span class="order-status success"><strong>'. $status . '</strong></span>';
                                            }elseif($status == 'cancelled'){
                                                echo '<span class="order-status danger"><strong>'. $status . '</strong></span>';
                                            }elseif($status == 'pending'){
                                                echo '<span class="order-status warning"><strong>'. $status . '</strong></span>';
                                            } ?>
                                    </p>
                                </li>
                            </ul>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container info-order-member" style="margin-top: 80px;">
            <div class="row">
                <div class="col-md-12 col-lg-8 order-1 order-sm-2">
                    <div class="st-title-yourinfor">
                        <div class="title">
                            <h2><?php echo __('Your Information','traveler');?></h2>
                        </div>
                        <div class="st-table-infor">
                            <?php 
                            $partner_info = $get_order_by_token->partner_info;
                            if( !empty($partner_info) ):
                                $partner_info = unserialize($partner_info);?>

                            <div class="info-form st-border-radius">
                                <ul>
                                    <li>
                                        <span class="label"><?php echo __('First name' , 'traveler') ;  ?></span>
                                        <span class="value"><?php echo esc_attr($partner_info['firstname'] ); ?></span>
                                    </li>
                                    <li>
                                        <span class="label"><?php echo __('Last name' , 'traveler') ;  ?></span>
                                        <span class="value"><?php echo esc_attr($partner_info['lastname'] ); ?></span>
                                    </li>
                                    <li>
                                        <span class="label"><?php echo __('Email' , 'traveler') ;  ?></span>
                                        <span class="value"><?php echo esc_attr($partner_info['email'] ); ?></span>
                                    </li>
                                    <li>
                                        <span class="label"><?php echo __('Phone' , 'traveler') ;  ?></span>
                                        <span class="value"><?php echo esc_attr($partner_info['phone'] ); ?></span>
                                    </li>
                                </ul>
                            </div>
                            <?php endif; ?>
                            <?php 
                            if (is_user_logged_in()):
                                $page_user = st()->get_option('page_my_account_dashboard');
                                if ($link = get_permalink($page_user)):
                                    $link=esc_url(add_query_arg(array('sc'=>'setting'),$link));?>
                                    <div class="text-center mg20">
                                        <a href="<?php echo esc_url($link)?>" class="btn btn-primary">
                                            <i class="fa fa-book"></i> 
                                            <?php echo __('Partner Infomation' , 'traveler') ;  ?>
                                        </a>
                                    </div>
                                <?php endif;
                            endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-4 order-2 order-sm-1">
                    
                    <div class="st-title-yourinfor st-sidebar-package"> 
                        <h2><?php echo __('Your Member Package','traveler');?></h2>
                    </div>
                    <div class="package-cart st-border-radius mb20">
                        <div class="cart-head">
                            <h4>
                            <?php echo esc_html($get_order_by_token->package_name); ?> </h4>
                        </div>
                        <div class="cart-content">
                            <h5><?php echo __('Package Information','traveler');?></h5>
                            <div class="item">
                                <span><?php echo __('Time Available','traveler');?></span>
                                <span class="pull-right"><?php echo esc_html($admin_packages->convert_item($get_order_by_token->package_time, true)); ?></span>
                            </div>
                            <div class="item">
                                <span><?php echo __('Commission','traveler');?></span>
                                <span class="pull-right"><?php echo esc_html($get_order_by_token->package_commission ). '%'; ?></span>
                            </div>
                            <div class="item">
                                <span><?php echo __('Items can be uploaded','traveler');?></span>
                                <span class="pull-right"><?php echo esc_html($get_order_by_token->package_item_upload); ?></span>
                            </div>
                            <div class="item">
                                <span><?php echo __('Items can set featured','traveler');?></span>
                                <span class="pull-right"><?php echo esc_html($get_order_by_token->package_item_featured); ?></span>
                            </div>
                            <div class="item">
                                <span><?php echo __('Services','traveler');?></span>
                            
                                <span class="pull-right"><?php echo esc_html($abc_packages->paser_list_services($get_order_by_token->package_services)); ?></span>
                            </div>
                        </div>
                        <div class="cart-footer">
                            <span> <strong><?php echo __('Pay amount','traveler');?></strong></span>
                            <span class="pull-right"><strong><?php echo TravelHelper::format_money((float)$get_order_by_token->package_price); ?></strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
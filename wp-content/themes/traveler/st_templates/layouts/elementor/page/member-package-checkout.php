<?php
/**
 *@since 1.3.1
 *@updated 1.3.1
 *    Template Name: Member Packages Checkout New
 **/

$content = apply_filters('st_get_member_package_checkout_page', '', $layout);
if($content){
    echo $content;
    return;
}

$admin_packages = STAdminPackages::get_inst();
if( !$admin_packages->enabled_membership() ){
    wp_redirect( home_url( '/' ) );
    exit();
}

get_header();

wp_enqueue_script( 'checkout-js' );
wp_enqueue_script('checkout-modern');
wp_enqueue_script('st-vina-stripe-js');
$cls_package = STAdminPackages::get_inst();
$package = $cls_package->get_cart();
?>
<div id="st-content-wrapper" class="st-page-default">
    <?php echo st()->load_template('layouts/modern/hotel/elements/banner'); ?>
    <?php st_breadcrumbs_new(); ?>
    <?php
    $cls_package = STAdminPackages::get_inst();
    $package = $cls_package->get_cart();
    ?>
    <div class="st-package-wrapper">
        <?php if (!$package): ?>
            <div class="row">
                <div class="container">
                    <div class="col-xs-12 col-sm-8">
                        <div class="alert alert-danger">
                            <p><?php esc_html_e('Sorry! Your cart is currently empty.','traveler') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: 
            $package_item_upload = ($package->package_item_upload !== 'unlimited') ? (int)esc_html($package->package_item_upload) : esc_html__('Unlimited','traveler'); 
            $package_item_featured = ($package->package_item_featured !== 'unlimited') ? (int)esc_html($package->package_item_featured) : esc_html__('Unlimited','traveler'); 
            ?>
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-xs-12 col-md-4">
                    <h4 class="mt20"><?php echo __('Your Member Package', 'traveler'); ?></h4>
                    <div class="package-cart st-border-radius mb20">
                        <div class="cart-head">
                            <h4>
                                <?php echo esc_html( $package->package_name); ?>
                            </h4>
                        </div>
                        <div class="cart-content">
                            <h5><?php echo __('Package Information', 'traveler'); ?></h5>
                            <div class="item">
                                <span><?php echo __('Time Available', 'traveler'); ?></span>
                                <span class="pull-right"><?php echo esc_html($cls_package->convert_item($package->package_time, true)); ?></span>
                            </div>
                            <div class="item">
                                <span><?php echo __('Commission', 'traveler'); ?></span>
                                <span class="pull-right"><?php echo (int) $package->package_commission. '%'; ?></span>
                            </div>
                            <div class="item">
                                <span><?php echo __('Items can upload', 'traveler') ?></span>
                                <span class="pull-right"><?php echo esc_html($package_item_upload); ?></span>
                            </div>
                            <div class="item">
                                <span><?php echo __('Items can set featured', 'traveler') ?></span>
                                <span class="pull-right"><?php echo esc_html($package_item_featured); ?></span>
                            </div>
                            <div class="item">
                                <span><?php echo __('Services', 'traveler') ?></span>
                                <span class="pull-right"><?php echo esc_html($cls_package->paser_list_services($package->package_services)); ?></span>
                            </div>
                        </div>
                        <div class="cart-footer">
                            <span> <strong><?php echo __('PAY AMOUNT', 'traveler'); ?></strong></span>
                            <span class="pull-right"><strong><?php echo TravelHelper::format_money((float)$package->package_price); ?></strong></span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-8 ">
                    <div class="row row-wrap">
                        <div class="col-md-12">
                            <div class="entry-content">
                                <?php
                                    while (have_posts()) {
                                        the_post();
                                        the_content();
                                    }
                                ?>
                            </div>
                            <form id="mpk-form" class="" method="post">
                                <?php echo st()->load_template('check_out/member_package_new') ?>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <?php
        endif; ?>
    </div>
    
</div>
<?php
get_footer();
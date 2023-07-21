<?php
/**
 *@since 1.3.1
 *@updated 1.3.1
 *    Template Name: Member Packages Checkout New
 **/
$admin_packages = STAdminPackages::get_inst();
if( !$admin_packages->enabled_membership() ){
    wp_redirect( home_url( '/' ) );
    exit();
}
if(check_using_elementor()){
    $layout = st()->get_option('member_packages_layout', '1');
    echo st()->load_template( 'layouts/elementor/page/member-package-checkout', '', ['layout' => $layout]);
    return;
}
get_header('member');
wp_enqueue_script( 'checkout-js' );
$cls_package = STAdminPackages::get_inst();
$package = $cls_package->get_cart();
?>
<div id="st-content-wrapper" class="search-result-page package-page-st">
    <?php echo st()->load_template('layouts/template-banner-page'); ?>
    <div class="breadcrumb">
        <?php st_breadcrumbs_new(); ?>
    </div>
    <?php
    $cls_package = STAdminPackages::get_inst();
    $package = $cls_package->get_cart();
    ?>
    <div class="gap"></div>
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
            <div class="col-xs-12 col-md-4 col-md-push-8">
                <h4 class="mt20"><?php echo __('Your Member Package', 'traveler'); ?></h4>
                <div class="package-cart mb20">
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
            <div class="col-xs-12 col-md-8 col-md-pull-4">
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
<?php
get_footer('member');
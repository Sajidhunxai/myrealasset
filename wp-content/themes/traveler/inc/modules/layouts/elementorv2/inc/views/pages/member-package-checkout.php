<?php
get_header();
wp_enqueue_script( 'checkout-js' );
wp_enqueue_script('checkout-modern');
wp_enqueue_script('st-vina-stripe-js');
$cls_package = STAdminPackages::get_inst();
$package = $cls_package->get_cart();
?>

<div id="st-content-wrapper" class="st-page-default member-package-layout2">
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
                    <div class="col-12 col-sm-8">
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
                <div class="col-12 col-md-12 col-lg-4">
                    <h4 class="title mt20"><?php echo __('Your Member Package', 'traveler'); ?></h4>
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
                                <span><?php echo __('Items can be uploaded', 'traveler') ?></span>
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
                            <span> <strong><?php echo __('Pay amount', 'traveler'); ?></strong></span>
                            <span class="pull-right"><strong><?php echo TravelHelper::format_money((float)$package->package_price); ?></strong></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8 ">
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
                            <h4 class="title mt20"><?php echo __('Information', 'traveler'); ?></h4>
                            <form id="mpk-form" class="" method="post">
                                <?php echo stt_elementorv2()->loadView('pages/checkout/member-package-new') ?>
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
<?php
/*
Template Name: Member Package New
*/
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Template Name : Member Package New
 *
 * Created by ShineTheme
 *
 */
$admin_packages = STAdminPackages::get_inst();
$user_id = get_current_user_id();
$can_upgrade = $admin_packages->can_upgrade($user_id);

if ((!$can_upgrade) && (!$admin_packages->user_can_register_package($user_id) || !$admin_packages->enabled_membership())) {
    //wp_redirect( home_url( '/' ) );
    //exit();
}
if(check_using_elementor()){
    echo st()->load_template( 'layouts/elementor/page/member-package');
    return;
}

get_header('member');
wp_enqueue_script('st-vina-stripe-js');
?>
    <div id="st-content-wrapper" class="search-result-page package-page-st">
        <?php echo st()->load_template('layouts/template-banner-page'); ?>
        <div class="container">
            <div class="breadcrumb">
                <?php st_breadcrumbs_new(); ?>
            </div>
            <?php if(have_posts()){
                the_post();
                the_content();
            }?>
        </div>
    </div>
<?php
get_footer('member');
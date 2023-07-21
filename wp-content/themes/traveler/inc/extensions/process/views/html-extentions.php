<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $wp_version;
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$all_plugins = get_plugins();
$list_plugin_installs = array();
foreach($all_plugins as $key=>$value){
    $name_plugin = substr($key, 0, strpos($key, '/'));
    array_push($list_plugin_installs,$name_plugin);
    
}
?>

<div class="wrap st-vina-settings">
<h1 class="wp-heading-inline"><?php echo esc_html(__('Extensions','traveler')); ?></h1>
    <nav class="nav-tab-wrapper wpm-nav-tab-wrapper st-tab-extendsion">
        <a href="<?php echo admin_url().'admin.php?page=st-vina-extensions&extension-tab=list'; ?>" class="nav-tab <?php if(!isset($_GET['tab'])){echo 'nav-tab-active';}?>"><?php echo esc_html('Plugins','traveler')?></a>
        <a href="<?php echo admin_url().'admin.php?page=st-vina-extensions&extension-tab=extendsion'; ?>" class="nav-tab <?php if(isset($_GET['tab']) && $_GET['tab']==='extendsion'){echo 'nav-tab-active';}?>"><?php echo esc_html('Extension','traveler')?></a>
    </nav>
    <?php
    $list_extendsions=apply_filters('st_vina_list_extendsion',array());
    $check_purchase = STAdminlandingpage::checkValidatePurchaseCode();
    if(!$check_purchase){
        ?>
        <div class="error" style="padding: 8px 10px 5px 10px !important; margin-left: 0px; margin-top: 15px;">
            <p class="about-description"><?php printf(__("Please register product before install demo content %s",'traveler'),'<a href="'.admin_url('admin.php?page=st_product_reg')  .'" target="_blank">Click here.</a>')?></p>
        </div>
        <?php
        return;
    }
    ?>

    <div class="traveler-demo-themes">
    <?php
    if(!empty($list_extendsions)){ 
        ?>
        <div class="st-install feature-section theme-browser rendered">
            <div class='st_landing_page_admin_grid' style="overflow: hidden" id="the-list">
                    <?php
                    foreach($list_extendsions as $key=>$value)
                    {
                        $st_key_check = $key.'/'.$key.'.php';
                        $security_st = wp_create_nonce( 'activate-plugin_' . $st_key_check );
                        $security_st_deactivate = wp_create_nonce( 'deactivate-plugin_' . $st_key_check );
                        ?>
                        <div class="plugin-card">
                            <div class="plugin-card-top">
                                <div class="name column-name">
                                    <h3>
                                        <a href="<?php echo get_admin_url()?>plugin-install.php?tab=plugin-information&amp;type=extendsion&amp;plugin=<?php echo $key?>&amp;TB_iframe=true&amp;width=772&amp;height=452" class="thickbox open-plugin-details-modal">
                                            <?php echo esc_html($value['name']) ?>
                                            <img src="<?php echo esc_url($value['preview_image']) ?>" class="plugin-icon" alt="">
                                        </a>
                                    </h3>
                                </div>
                                <div class="action-links">
                                    <ul class="plugin-action-buttons">
                                        <li class="button-name">
                                            <?php if ( is_plugin_active( $key.'/'.$key.'.php' ) ) { ?>
                                                <a  href="<?php echo get_admin_url()?>admin.php?page=st-vina-extensions&extension-tab=list&action=deactivate&amp;plugin=<?php echo $key?>%2F<?php echo $key?>.php&amp;plugin_status=all&amp;paged=1&amp;s&amp;_wpnonce=<?php echo $security_st_deactivate;?>" class="button button-primary st-deactive-plugin" style="background-color:#a00; border-color:#a00;"  data-plugin-id="<?php echo esc_attr($key) ?>" href="#">
                                                <?php 
                                                _e('Deactive','traveler'); ?>
                                                </a>
                                            <?php } else {
                                                if (in_array($key, $list_plugin_installs)) {
                                                ?>
                                                <a href="<?php echo get_admin_url()?>admin.php?page=st-vina-extensions&extension-tab=list&action=activate&amp;plugin=<?php echo $key?>%2F<?php echo $key?>.php&amp;plugin_status=all&amp;paged=1&amp;s&amp;_wpnonce=<?php echo $security_st;?>" class="button button-primary st-active-plugin" data-plugin-id="<?php echo esc_attr($key) ?>" >
                                                    <?php 
                                                    _e('Active','traveler');?>
                                                </a>
                                                <?php } else {?>
                                                    <a onclick="return false" class="button st-install-plugin" data-plugin-id="<?php echo esc_attr($key) ?>" href="#">
                                                        <?php 
                                                        _e('Install Now','traveler');?>
                                                    </a>
                                                <?php }?>
                                            <?php }?>
                                        </li>
                                            
                                        <li>
                                            <a href="<?php echo get_admin_url()?>plugin-install.php?tab=plugin-information&amp;type=extendsion&amp;plugin=<?php echo $key?>&amp;TB_iframe=true&amp;width=772&amp;height=452" class="thickbox open-plugin-details-modal" aria-label="More information about plug <?php echo $value['name']?>" data-title="<?php echo $value['name']?>"><?php 
                                                        _e('More Detail','traveler');?>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="desc column-description">
                                    <p><?php echo esc_html($value['description']) ?></p>
                                    <p class="authors"> <cite>By <a href="<?php echo esc_url($value['url-author']) ?>"><?php echo esc_html($value['author']) ?></a></cite></p>
                                </div>
                            </div>

                            <div class="plugin-card-bottom">
                                <div class="vers column-rating">
                                    <div class="star-rating"><span class="screen-reader-text">Price: </span> <strong><span style="font-size:18px; color:#0073aa">Free</strong>
                                    </div>
                                </div>
                                <div class="column-updated">
                                    <strong>Last Updated:</strong>
                                    <?php echo esc_html($value['last_updated']) ?>      
                                </div>
                                <div class="column-downloaded">
                                </div>
                                <div class="column-compatibility">
                                    <span class="compatibility-compatible"><strong>Compatible</strong> with your version of WordPress</span>
                                </div>
                                
                            </div>
                        </div>
                        <?php
                    }

                    ?>
            </div>
        </div>
        
        <?php } ?>
    </div>
</div>

<style type="text/css">
    .nav-tab-wrapper.st-tab-extendsion{
        margin-bottom: 15px;
    }
</style>
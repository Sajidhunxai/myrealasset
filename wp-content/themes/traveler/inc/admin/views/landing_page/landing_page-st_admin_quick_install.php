<?php
$packages=apply_filters('st_demo_packages',array());
$elementor_packages=apply_filters('st_demo_elementor_packages',array());
$check_purchase = STAdminlandingpage::checkValidatePurchaseCode();
if(!$check_purchase){
    ?>
    <div class="error" style="padding: 8px 10px 5px 10px !important; margin-left: 0px; margin-top: 15px;">
        <p class="about-description"><?php printf(__("Please register product before install demo content %s",'traveler'),'<a href="'. admin_url('admin.php?page=st_product_reg') .'" target="_blank">Click here.</a>')?></p>
    </div>
    <?php
    return;
}
?>

<div class="traveler-important-notice">
    <p class="about-description"><?php printf(__('The Demo content is a replication of the Live Content. By importing it, you could get pre-designed service, pages, posts, theme options, sidebar widgets, and other settings. <br><span style=\'color:#3B71FE;    font-weight: 600;\'>It can also take a minute to complete.</span><br><span>Before import, make sure your website data is empty (posts, pages, menus...)

We suggest you use the plugin "Wordpress Reset" to reset your website before import.</span> <br>
<span style=\'color:#3B71FE;font-weight: 600;\'>WARNING: When Import Demo Data. All your current data will be deleted and replaced with Traveler demo data.</span>
<span style=\'color:red\'><b>Kindly back up your database before doing this.</b> %s ','traveler'),'<a style=\'color:#3B71FE;font-weight: 600;\' href="https://travelerwp.com/how-to-download-and-install-theme/" target="_blank">View more info here.</a>')?></p>
    <p>
        Recommended  Configuration
    </p>
    <ul>
        <li>max_execution_time&nbsp;500</li>
        <li>memory_limit 256M</li>
        <li>post_max_size 100M</li>
        <li>upload_max_filesize 100M</li>
        <li>cURL: 7.4 or higher.</li>
        <li>PHP max input vars 10000</li>
        <li>max_allowed_packet= 128M for your database</li>
        <li style="color:#3B71FE;font-weight: 600; font-size:18px;">The last import demo: <span style="color:red;font-weight: 600;font-size:20px;"><?php echo esc_html(get_option('st_demo_install'))?></span></li>
    </ul>
</div>
<div class="traveler-demo-themes">

    <?php
        if(!empty($elementor_packages) && class_exists('Elementor\Plugin')){ ?>
        <div class="st-install feature-section theme-browser rendered">
            <div class='st_landing_page_admin_grid' style="overflow: hidden">
                    <h2 style="font-size: 20px;"><?php echo __('Elementor Demo', 'traveler'); ?></h2>
                    <span></span>
                    <span></span>
                    <?php
                    foreach($elementor_packages as $key=>$el_pk)
                    {
                        ?>
                        <div class="theme">
                            <div class="theme-screenshot">
                                <img src="<?php echo esc_attr($el_pk['preview_image']) ?>" alt="<?php echo TravelHelper::get_alt_image() ?>">
                            </div>

                            <div class="theme-actions-demo">
                                <ul class="theme-name" id="classic" style="display: flex;justify-content: space-between;height: 27px;">
                                    <li><?php echo esc_html($el_pk['title']) ?></li>
                                    <li><a onclick="return false" class="button button-primary st-quick-install-demo" data-required-library = "<?php echo esc_attr($el_pk['pass_install']) ?>" data-style="elementor" data-demo-id="<?php echo esc_attr($key) ?>" href="#"><?php _e('Install','traveler')?></a></li>
                                </ul>

                            </div>

                            <div class="demo-import-loader preview-all"></div>
                            <div class="demo-import-loader preview-classic"><i class="dashicons dashicons-admin-generic"></i></div>
                        </div>
                        <?php
                    }

                    ?>
            </div>
        </div>
        <?php } else {
            if(empty($elementor_packages)){ ?>
                <h2 style="font-size: 20px;"><?php echo __('Have not package demo elementor', 'traveler'); ?></h2>
            <?php }else{ ?>
                <h2 style="font-size: 20px;"><?php echo __('Please install/active plugin Elementor (If import demo Elementor)', 'traveler'); ?></h2>
            <?php } ?>
            
        <?php }
    
    if(!empty($packages)){
        $arr_packages_new = array();
        $arr_packages = array();
        if(isset($packages['mixmap']))
            $arr_packages_new['mixmap'] = $packages['mixmap'];
            
        if(isset($packages['hotel']))
            $arr_packages_new['hotel'] = $packages['hotel'];

        if(isset($packages['tour']))
            $arr_packages_new['tour'] = $packages['tour'];
            
        if(isset($packages['activity']))
            $arr_packages_new['activity'] = $packages['activity'];

        if(isset($packages['rental']))
            $arr_packages_new['rental'] = $packages['rental'];

        if(isset($packages['car']))
            $arr_packages_new['car'] = $packages['car'];

        if(isset($packages['solotour']))
        $arr_packages_new['solotour'] = $packages['solotour'];

        if(isset($packages['single_hotel']))
            $arr_packages_new['single_hotel'] = $packages['single_hotel'];

        if(isset($packages['citytour']))
            $arr_packages_new['citytour'] = $packages['citytour'];

        if(isset($packages['hostel']))
            $arr_packages_new['hostel'] = $packages['hostel'];

        if(isset($packages['yatour']))
            $arr_packages_new['yatour'] = $packages['yatour'];

        if(isset($packages['hiking']))
            $arr_packages_new['hiking'] = $packages['hiking'];

        if(isset($packages['sintour']))
            $arr_packages_new['sintour'] = $packages['sintour'];
        

        if(isset($packages['light']))
            $arr_packages['light'] = $packages['light'];

        if(isset($packages['affiliate']))
            $arr_packages_new['affiliate'] = $packages['affiliate'];

        if(isset($packages['new_hotel']))
            $arr_packages_new['new_hotel'] = $packages['new_hotel'];
        

        // if(isset($packages['traveler-tour']))
        //     $arr_packages['traveler-tour'] = $packages['traveler-tour'];

        if(isset($packages['hotel_tour']))
            $arr_packages['hotel_tour'] = $packages['hotel_tour'];

        ?>
        <div class="st-install feature-section theme-browser rendered">
            <div class='st_landing_page_admin_grid' style="overflow: hidden">
                    <h2 style="font-size: 20px;"><?php echo __('WPBakery Page Builder Demo', 'traveler'); ?></h2>
                    <span></span>
                    <span></span>
                    <?php
                    foreach($arr_packages_new as $key=>$value)
                    {
                        ?>
                        <div class="theme">
                            <div class="theme-screenshot">
                                <img src="<?php echo esc_attr($value['preview_image']) ?>" alt="<?php echo TravelHelper::get_alt_image() ?>">
                            </div>

                            <div class="theme-actions-demo">
                                <ul class="theme-name" id="classic" style="display: flex;justify-content: space-between;height: 27px;">
                                    <li><?php echo esc_html($value['title']) ?></li>
                                    <li><a onclick="return false" class="button button-primary st-quick-install-demo" data-demo-id="<?php echo esc_attr($key) ?>" href="#"><?php _e('Install','traveler')?></a></li>
                                </ul>

                            </div>

                            <div class="demo-import-loader preview-all"></div>
                            <div class="demo-import-loader preview-classic"><i class="dashicons dashicons-admin-generic"></i></div>
                        </div>
                        <?php
                    }

                    ?>
            </div>
        </div>
        <?php
            $enable_import_classic = apply_filters('st_enable_import_classic',false);
            if($enable_import_classic){ ?>
                <div class="st-install feature-section theme-browser rendered">
                    <div class='st_landing_page_admin_grid' style="overflow: hidden">
                            <h2 style="font-size: 20px;"><?php echo __('Style 2', 'traveler'); ?></h2>
                            <span></span>
                            <span></span>

                            <?php
                            foreach($arr_packages as $key=>$value)
                            {
                                ?>
                                <div class="theme">
                                    <div class="theme-screenshot">
                                        <img src="<?php echo esc_attr($value['preview_image']) ?>" alt="<?php echo TravelHelper::get_alt_image() ?>">
                                    </div>
                                    <div class="theme-actions-demo">
                                        <ul class="theme-name" id="classic" style="display: flex;justify-content: space-between;height: 27px;">
                                            <li><?php echo esc_html($value['title']) ?></li>
                                            <li><a onclick="return false" class="button button-primary st-quick-install-demo" data-style="wp-page-builder" data-demo-id="<?php echo esc_attr($key) ?>" href="#"><?php _e('Install','traveler')?></a></li>
                                        </ul>

                                    </div>

                                    <div class="demo-import-loader preview-all"></div>
                                    <div class="demo-import-loader preview-classic"><i class="dashicons dashicons-admin-generic"></i></div>
                                </div>
                                <?php
                            }
                            ?>
                    </div>
                </div>
            <?php }
        ?>
        
        <?php
    } ?>
    <div class="st-tooltip" id="popup-demo-1">
        <div class="st-modal-dialog">
            <div class="st-close-button text-right">
                <i class="glyphicon glyphicon-remove"></i>
            </div>
            <div class="st-modal-content">
                <div class="form-group">
                    <div class="icon-popup">
                        <img src="<?php echo get_template_directory_uri().'/img/icons-new/icon-warning.svg';?>" alt="">
                    </div>
                    <h3 class="control-label st-center">Before Install</h3>
                    <p>Import demo data is only recommended on the fresh installation website. All your current data will be deleted and replaced with Traveler demo data.</p>
                    <div id="required_install_library"></div>
                    <ul class="st-accept">
                        <li>
                            <button class="st-btn-but st-cancel">Cancel</button>
                        </li>
                        <li>
                            <button class="st-btn-but st-agree">Continue</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="st-tooltip" id="popup-demo-2">
        <div class="st-modal-dialog">
            <div class="st-close-button text-right">
                <i class="glyphicon glyphicon-remove"></i>
            </div>
            <div class="st-modal-content">
                <div class="form-group import">
                    <div class="icon-popup">
                        <img class="st-rotating" src="<?php echo get_template_directory_uri().'/img/icons-new/processing-time.svg';?>" alt="">
                    </div>
                    <h3 class="control-label st-center"><?php echo __('Processing...','traveler');?></h3>
                    <div class="progress st-progress-bar">
                        <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                        0%
                        </div>
                    </div>
                    <div class="content-import-error">
                        <div id="console_iport"></div>
                    </div>
                    <div class="st-package-name"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="st-tooltip" id="popup-demo-3">
        <div class="st-modal-dialog">
            <div class="st-close-button text-right">
                <i class="glyphicon glyphicon-remove"></i>
            </div>
            <div class="st-modal-content">
                <div class="form-group st_done">
                    <div class="icon-popup">
                        <img src="<?php echo get_template_directory_uri().'/img/icons-new/smile.svg';?>" alt="">
                    </div>
                    <h3 class="control-label st-center st-font-24">Hooray! All done.</h3>
                    <div id="back-dashboard"><a href="<?php echo get_dashboard_url()?>">Back to Dashboard</a></div>
                    <h3 class="control-label st-center st-font-18">If you want to import data test demo, please <a target= "_blank" href="<?php echo admin_url( 'admin.php?page=st-upgrade-data' ); ?>">Upgrade Data</a>, <a target= "_blank" href="<?php echo admin_url( 'admin.php?page=st_sync_availability' ); ?>">Sync Availability</a> , <a target= "_blank" href="<?php echo admin_url( 'admin.php?page=st_sync_price' ); ?>">Sync Price</a></h3>
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>


<style>
.st-font-24{
    font-size:24px;
}
.st-font-18{
    font-size:18px !important;
}
.st-modal-dialog .form-group.st_done{
    padding-top:80px;
    padding-bottom:80px;
}
#back-dashboard{
    text-align:center;
}
#back-dashboard a{
    position:relative;
    font-weight: 500;
    font-stretch: normal;
    font-style: normal;
    line-height: normal;
    letter-spacing: normal;
    text-align: center;
    color: #5091fb;
    font-size: 16px;
    text-decoration: none;
}
#back-dashboard a:after{
    position: absolute;
    background: #5091fb;
    width: 100%;
    height: 2px;
    bottom: -7px;
    left: 0px;
    content: "";
}
.st-tooltip {
  position: fixed;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  opacity: 0;
  visibility: hidden;
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
  -webkit-transition: visibility 0s linear 0.25s, opacity 0.25s 0s, -webkit-transform 0.25s;
  transition: visibility 0s linear 0.25s, opacity 0.25s 0s, -webkit-transform 0.25s;
  transition: visibility 0s linear 0.25s, opacity 0.25s 0s, transform 0.25s;
  transition: visibility 0s linear 0.25s, opacity 0.25s 0s, transform 0.25s, -webkit-transform 0.25s;
  z-index: 9999; }
.st-modal-content .icon-popup{
    text-align:center;
    line-height: initial;
}
.landing_page_content .st-center{
    text-align:center;
}
.landing_page_content .control-label{
    font-size: 24px;
    font-weight: 500;
    font-stretch: normal;
    font-style: normal;
    line-height: normal;
    letter-spacing: normal;
    text-align: center;
    color: #111111;
    margin-top:10px;
    margin-bottom:10px;
}
.st-modal-content .form-group p{
    font-size: 20px;
    font-weight: normal;
    font-stretch: normal;
    font-style: normal;
    line-height: normal;
    letter-spacing: normal;
    text-align: center;
    color: #333333;
}
.st-modal-content .form-group .st-accept{
    display: flex;
    justify-content: center;
}
.st-modal-content .form-group .st-accept li{
    margin-left:6px;
    margin-right:6px;
}
.st-modal-content .form-group .st-accept button{
    cursor: pointer;
    border-radius: 3px;
    font-size:15px;
    padding:8px 33px;
    font-weight: 500;
    font-stretch: normal;
    font-style: normal;
    line-height: normal;
    letter-spacing: normal;
    text-align: center;
}
.st-modal-content .form-group .st-accept .st-cancel{
    border: solid 1px #111111;
}
.st-modal-content .form-group .st-accept .st-agree{
    border: solid 1px #5091fb;
    color: #ffffff;
    background-color: #5091fb;
}
.st-modal-dialog {
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    width: 38.125rem;
    min-height:404px;
    border-radius: 10px;
    background-color: #ffffff;

}
.content-import::-webkit-scrollbar-track
{
	border-radius: 10px;
	background-color: #FFFFFF;
}
.content-import{
    overflow: hidden;
    overflow-y: scroll;
    max-height: 200px;
}
#console_iport{
    font-size: 16px;
    font-weight: 400;

}
#console_iport span{
    color:#41d721;
}
#console_iport span.res-error{
    color:#cc0000;
}
.content-import::-webkit-scrollbar
{
	width: 10px;
	background-color: #d8d8d8;
}

.content-import::-webkit-scrollbar-thumb
{
	border-radius: 10px;
	background-color: #d8d8d8;
}

.st-modal-dialog .form-group{
    padding:50px 110px;
}
.st-modal-dialog .form-group.import{
    padding:0px;
}
.st-modal-dialog .form-group.import .icon-popup{
    padding:50px 50px 0px 50px;
}
.st-modal-dialog .form-group.import .content-import{
    padding-left:50px;
    margin-bottom:50px;
}

.st-close-button {
  float: right;
  display:block;
  width: 1.5rem;
  line-height: 1.5rem;
  text-align: center;
  cursor: pointer;
  border-radius: 0.25rem;
  display: inline-block; }

.close-button:hover {
  background-color: darkgray; }

.show-modal {
  opacity: 1;
  visibility: visible;
  -webkit-transform: scale(1);
  transform: scale(1);
  -webkit-transition: visibility 0s linear 0s, opacity 0.25s 0s, -webkit-transform 0.25s;
  transition: visibility 0s linear 0s, opacity 0.25s 0s, -webkit-transform 0.25s;
  transition: visibility 0s linear 0s, opacity 0.25s 0s, transform 0.25s;
  transition: visibility 0s linear 0s, opacity 0.25s 0s, transform 0.25s, -webkit-transform 0.25s; }

  @-webkit-keyframes rotating /* Safari and Chrome */ {
  from {
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  to {
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes rotating {
  from {
    -ms-transform: rotate(0deg);
    -moz-transform: rotate(0deg);
    -webkit-transform: rotate(0deg);
    -o-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  to {
    -ms-transform: rotate(360deg);
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
.st-rotating {
  -webkit-animation: rotating 2s linear infinite;
  -moz-animation: rotating 2s linear infinite;
  -ms-animation: rotating 2s linear infinite;
  -o-animation: rotating 2s linear infinite;
  animation: rotating 2s linear infinite;
}
</style>

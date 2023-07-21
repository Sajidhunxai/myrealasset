<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
/**
 * Main class install
 */
class STInstall
{
    public $plugins_folder_baseurl;
    public function __construct()
    {

        add_action('st_vina_display_extensions',array($this,'func_display_extensions'),9);
        add_action( 'wp_ajax_st_install_plugin', [ $this, 'st_install_plugin' ] );
        add_action( 'wp_ajax_nopriv_st_install_plugin', [ $this, 'st_install_plugin' ] );
        add_action( 'admin_init', array($this,'st_action_plugin'));
        add_action( 'admin_enqueue_scripts', array($this, 'st_check_page_url'));
        remove_action( 'install_plugins_pre_plugin-information', 'action_install_plugins_pre_plugin_information', 10, 1 ); 
        add_action( 'install_plugins_pre_plugin-information', array($this, 'install_plugin_information_extension' ), 10, 1);
        $this->plugins_folder_baseurl = WP_PLUGIN_DIR;
    }
    function st_check_page_url(){
        $current_slug = get_current_screen();
            if($current_slug->base === 'theme-settings_page_st-vina-extensions'){
                wp_enqueue_script( 'updates' );
                wp_enqueue_style('adminstyles');
                wp_enqueue_script( 'st_install_plugin_js', get_template_directory_uri() . '/inc/extensions/process/views/assets/install.js',array('jquery'), false, true );
                wp_enqueue_style( 'st_install_plugin', get_template_directory_uri() . '/inc/extensions/process/views/assets/style.css',array(), true, false );
            }
    }

    function install_plugin_information_extension(){
        global $tab;

        if ( empty( $_REQUEST['plugin'] ) ) {
            return;
        }

        if ( empty( $_REQUEST['type'] ) ) {
            return;
        }
        if($_REQUEST['type'] == 'extendsion'){
            $api =apply_filters('st_vina_list_extendsion',array());
        } else {
            $api =apply_filters('st_vina_list_addons',array());
        }
        $api = $api[$_REQUEST['plugin']];
        iframe_header();

        // dd($api); die();

        // $api = plugins_api(
        //     'plugin_information',
        //     array(
        //         'slug' => wp_unslash( $_REQUEST['plugin'] ),
        //     )
        // );

        if ( is_wp_error( $api ) ) {
            wp_die( $api );
        }
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        $all_plugins = get_plugins();
        $list_plugin_installs = array();
        foreach($all_plugins as $key=>$value){
            $name_plugin = substr($key, 0, strpos($key, '/'));
            array_push($list_plugin_installs,$name_plugin);
            
        }
        $banner = get_template_directory_uri().'/inc/extensions/process/views/assets/img/banner.jpg';
        ?>
        <div id="plugin-information-scrollable">
        
            <div id="plugin-information-title" class="with-banner" style="background-image: url(<?php echo esc_url($banner);?>);">
                <div class="vignette"></div>
                <h2><?php echo esc_html($api['name']);?></h2>
                
            </div>
            <div id="plugin-information-tabs" class="with-banner">
                <a name="description" href="#" class="current"><?php echo __('Description', 'traveler');?></a>
            </div>
            <div id="plugin-information-content" class="with-banner">
                <div class="fyi">
                    <ul>
                        <li><strong><?php echo __('Version', 'traveler');?>:</strong> <?php echo esc_html($api['version']);?></li>
                        <li><strong><?php echo __('Author', 'traveler');?>:</strong> <a href="<?php echo esc_url($api['url-author']);?>" target="_blank"><?php echo esc_html($api['author']);?></a></li>
                        <li><strong><?php echo __('Last Updated', 'traveler');?>:</strong> <?php echo esc_html($api['last_updated']);?> </li>
                        <li>
                            <strong><?php echo __('Requires WordPress Version', 'traveler');?>:</strong> <?php echo esc_html($api['requires']);?> </li>
                    </ul>
                    
                </div>
                <div id="section-holder">
                    <div id="section-description" class="section" style="display: block;">
                        <p><?php echo esc_html($api['description']);?></p>
                    </div>
                </div>
            </div>
            <div id="plugin-information-footer">
                <?php
                    $st_key_check = $_REQUEST['plugin'].'/'.$_REQUEST['plugin'].'.php';
                    $security_st = wp_create_nonce( 'activate-plugin_' . $st_key_check );
                    $security_st_deactivate = wp_create_nonce( 'deactivate-plugin_' . $st_key_check );
                ?>
                <?php if ( is_plugin_active( $_REQUEST['plugin'].'/'.$_REQUEST['plugin'].'.php' ) ) { ?>
                    <a target="_parent"  href="<?php echo get_admin_url()?>admin.php?page=st-vina-extensions&extension-tab=list&action=deactivate&amp;plugin=<?php echo $_REQUEST['plugin']?>%2F<?php echo $_REQUEST['plugin']?>.php&amp;plugin_status=all&amp;paged=1&amp;s&amp;_wpnonce=<?php echo $security_st_deactivate;?>" class="button button-primary st-deactive-plugin right disabled" style="background-color:#a00; border-color:#a00;"  data-plugin-id="<?php echo esc_attr($_REQUEST['plugin']) ?>" >
                    <?php 
                    _e('Intalled','traveler'); ?>
                    </a>
                <?php } else {

                    if (in_array($_REQUEST['plugin'], $list_plugin_installs)) {
                    ?>
                    <a href="<?php echo get_admin_url()?>admin.php?page=st-vina-extensions&extension-tab=list&action=activate&amp;plugin=<?php echo $_REQUEST['plugin']?>%2F<?php echo $_REQUEST['plugin']?>.php&amp;plugin_status=all&amp;paged=1&amp;s&amp;_wpnonce=<?php echo $security_st;?>" class="button button-primary st-active-plugin right disabled" target="_parent" data-plugin-id="<?php echo esc_attr($_REQUEST['plugin']) ?>" >
                        <?php 
                        _e('Intalled','traveler');?>
                    </a>
                    <?php } else {
                        $list_addons=apply_filters('st_vina_list_addons',array());
                        if (array_key_exists($_REQUEST['plugin'],$list_addons)){
                        ?>
                            <a  class="button right" target="_parent"  href="<?php echo esc_url($api['url-download']) ?>">
                                <?php 
                                _e('Buy Now','traveler');?>
                            </a>
                    <?php } else { ?>
                        <a  class="button right st-install-plugin-poup" data-slug="<?php echo esc_attr($_REQUEST['plugin']) ?>" id="plugin_install_from_iframe" data-plugin-id="<?php echo esc_attr($_REQUEST['plugin']) ?>" href="#">
                            <?php 
                            _e('Install Now','traveler');?>
                        </a>
                        <?php }
                    }
                }?>
            </div>
        </div>
        
        <?php
           
            iframe_footer();
            ?>
       
        <?php exit;


    }

    public function func_display_extensions(){
        $argsl = array();
        get_template_part( 'inc/extendsions/process/html-list-extentions' );
    }
    public function current_action() {
		if ( isset( $_POST['clear-recent-list'] ) ) {
			return 'clear-recent-list';
		}

		return $this->current_action();
	}
    public function st_action_plugin(){

        $page_extendsion = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';

        if($page_extendsion === 'st-vina-extensions'){
            require_once(ABSPATH . 'wp-admin/includes/admin.php');
            $plugin = isset( $_REQUEST['plugin'] ) ? wp_unslash( $_REQUEST['plugin'] ) : '';
            $action = isset( $_REQUEST['action'] ) ? urlencode( wp_unslash( $_REQUEST['action'] ) ) : '';
            $s      = isset( $_REQUEST['s'] ) ? urlencode( wp_unslash( $_REQUEST['s'] ) ) : '';
            $_SERVER['REQUEST_URI'] = remove_query_arg( array( 'error', 'deleted', 'activate', 'activate-multi', 'deactivate', 'deactivate-multi', '_error_nonce' ), $_SERVER['REQUEST_URI'] );
            if ( $action ) {

                switch ( $action ) {
                    case 'activate':
                        if ( ! current_user_can( 'activate_plugin', $plugin ) ) {
                            wp_die( __( 'Sorry, you are not allowed to activate this plugin.' ) );
                        }
            
                        if ( is_multisite() && ! is_network_admin() && is_network_only_plugin( $plugin ) ) {
                            wp_redirect( self_admin_url( "admin.php?page=st-vina-extensions&extension-tab=list&plugin_status&s=$s" ) );
                            exit;
                        }
                       
                        check_admin_referer( 'activate-plugin_' . $plugin );
                        $result = activate_plugin( $plugin, self_admin_url( 'admin.php?page=st-vina-extensions&extension-tab=list&error=true&plugin=' . urlencode( $plugin ) ), is_network_admin() );
                        if ( is_wp_error( $result ) ) {
                            if ( 'unexpected_output' == $result->get_error_code() ) {
                                $redirect = self_admin_url( 'admin.php?page=st-vina-extensions&extension-tab=list&error=true&charsout=' . strlen( $result->get_error_data() ) . '&plugin=' . urlencode( $plugin ) . "&plugin_status=$status&paged=$page&s=$s" );
                                wp_redirect( add_query_arg( '_error_nonce', wp_create_nonce( 'plugin-activation-error_' . $plugin ), $redirect ) );
                                exit;
                            } else {
                                wp_die( $result );
                            }
                        }
            
                        if ( ! is_network_admin() ) {
                            $recent = (array) get_option( 'recently_activated' );
                            unset( $recent[ $plugin ] );
                            update_option( 'recently_activated', $recent );
                        } else {
                            $recent = (array) get_site_option( 'recently_activated' );
                            unset( $recent[ $plugin ] );
                            update_site_option( 'recently_activated', $recent );
                        }
            
                        if ( isset( $_GET['from'] ) && 'import' == $_GET['from'] ) {
                            wp_redirect( self_admin_url( 'import.php?import=' . str_replace( '-importer', '', dirname( $plugin ) ) ) ); // overrides the ?error=true one above and redirects to the Imports page, stripping the -importer suffix
                        } elseif ( isset( $_GET['from'] ) && 'press-this' == $_GET['from'] ) {
                            wp_redirect( self_admin_url( 'press-this.php' ) );
                        } else {
                            wp_redirect( self_admin_url( "admin.php?page=st-vina-extensions&extension-tab=list&activate=true&plugin_status=$status&paged=$page&s=$s" ) ); // overrides the ?error=true one above
                        }
                        exit;
                    case 'deactivate':
                        if ( ! current_user_can( 'deactivate_plugin', $plugin ) ) {
                            wp_die( __( 'Sorry, you are not allowed to deactivate this plugin.' ) );
                        }
            
                        check_admin_referer( 'deactivate-plugin_' . $plugin );
            
                        if ( ! is_network_admin() && is_plugin_active_for_network( $plugin ) ) {
                            wp_redirect( self_admin_url( "admin.php?page=st-vina-extensions&extension-tab=list&plugin_status=$status&paged=$page&s=$s" ) );
                            exit;
                        }
            
                        deactivate_plugins( $plugin, false, is_network_admin() );
            
                        if ( ! is_network_admin() ) {
                            update_option( 'recently_activated', array( $plugin => time() ) + (array) get_option( 'recently_activated' ) );
                        } else {
                            update_site_option( 'recently_activated', array( $plugin => time() ) + (array) get_site_option( 'recently_activated' ) );
                        }
            
                        if ( headers_sent() ) {
                            echo "<meta http-equiv='refresh' content='" . esc_attr( "0;url=admin.php?page=st-vina-extensions&extension-tab=list&deactivate=true&plugin_status=$status&paged=$page&s=$s" ) . "' />";
                        } else {
                            wp_redirect( self_admin_url( "admin.php?page=st-vina-extensions&extension-tab=list&deactivate=true&plugin_status=$status&paged=$page&s=$s" ) );
                        }
                        exit;
                    default:
                        if ( isset( $_POST['checked'] ) ) {
                            check_admin_referer( 'bulk-plugins' );
                            $plugins  = isset( $_POST['checked'] ) ? (array) wp_unslash( $_POST['checked'] ) : array();
                            $sendback = wp_get_referer();
            
                            /** This action is documented in wp-admin/edit-comments.php */
                            $sendback = apply_filters( 'handle_bulk_actions-' . get_current_screen()->id, $sendback, $action, $plugins );  // phpcs:ignore WordPress.NamingConventions.ValidHookName.UseUnderscores
                            wp_safe_redirect( $sendback );
                            exit;
                        }
                        break;
                
                }
            }
        }
        
    }

    public function st_install_plugin(){
        global $wpdb;
        set_time_limit(0);
        //Download plugin
        $customer_purchase_code = get_option('envato_purchasecode',false);
        $api_get_file_xml='https://shinetheme.com/demosd/plugins/api-download.php';
        $data_api = array(
            'action' => 'download_plugin',
            'customer_purchase_code' =>$customer_purchase_code,
            'name_plugin' => $_REQUEST['plugin_name'],
            'item_id' =>'',
        );
        $array_remote = ( array(
            'method'      => 'POST',
            'timeout'     => 60,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => array(),
            'body'        => $data_api,
            'cookies'     => array()
            )
        );
        $response_remote = wp_remote_post($api_get_file_xml,$array_remote);
       
        $response = json_decode($response_remote['body']);
        $remote_file_url = isset($response->url) ? $response->url : "";
        
        $local_file = $this->plugins_folder_baseurl.'/'.$_REQUEST['plugin_name'] .'.zip';
        $remote_file_url = download_url( $remote_file_url );
        $copy = copy( $remote_file_url, $local_file );
        if( !$copy ) {
            echo json_encode( array(
                    'status'   =>"ok",
                    'messenger'=>"Can not download plugin ",
                )
            );
        } else {
            $file = $this->plugins_folder_baseurl.'/'.$_REQUEST['plugin_name'] .'.zip';
            $path = pathinfo( realpath( $file ), PATHINFO_DIRNAME );
            $zip = new ZipArchive;
            $key = $_REQUEST['plugin_name'];
            $st_key_check = $key.'/'.$key.'.php';
            $security_st = wp_create_nonce( 'activate-plugin_' . $st_key_check );
            $res = $zip->open($file);
            if ($res === TRUE) {
                $zip->extractTo( $path );
                $zip->close();
                unlink($file);
                @ob_start(); ?>
                <a href="admin.php?page=st-vina-extensions&extension-tab=list&action=activate&amp;plugin=<?php echo $key?>%2F<?php echo $key?>.php&amp;plugin_status=all&amp;paged=1&amp;s&amp;_wpnonce=<?php echo $security_st;?>" class="button button-primary st-active-plugin" data-plugin-id="<?php echo esc_attr($key) ?>" href="#">
                    <?php 
                    _e('Active','traveler');?>
                </a>
                <?php
               $button_content = ob_get_contents();
               ob_clean();
               ob_end_flush();
                echo json_encode( array(
                    'status'   =>$_REQUEST['plugin_name'],
                    'html'=>$button_content,
                ));
            }
            else {
                echo json_encode( array(
                    'status'   =>"ok",
                    'messenger'=>"Can not extract plugin <span>ERROR!</span><br>",
                ));
            }
        }
        die();
    }
}
$STInstall = new STInstall();

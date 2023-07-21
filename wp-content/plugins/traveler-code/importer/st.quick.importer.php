<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
/**
 * Main class install
 */
/**
 * Developer: ThoaiNgo
 */
class STVinaImportProcess
{
    public $template_dir = "databases";
    public $plugin_dir;
	public $plugin_url;
	public $uploads_baseurl;
	public $upload_demo;
    public function __construct(){
        $this->createImportFolderNew();
        add_action( 'wp_ajax_quick_import_sql',array($this,'quick_import_sql'));
        add_action( 'wp_ajax_nopriv_quick_import_sql',array($this,'quick_import_sql'));
        add_filter( 'wp_get_attachment_image_src', array($this,'wp_get_attachment_image_src'),99,4 );
        add_filter('wp_get_attachment_url', array($this,'wp_get_attachment_url_func'),99,2);
        add_filter('has_post_thumbnail', array($this,'has_post_thumbnail_func'),99,3);
        add_filter('wp_get_attachment_image_attributes', array($this,'wp_get_attachment_image_attributes_func'),99,3);
        add_filter('post_thumbnail_html', array($this,'post_thumbnail_html_func'),99,5);
        
    }
    public function createImportFolderNew(){
		$this->upload_demo = "traveler-databases";
		$upload_dir    = wp_upload_dir();
		$upload_folder = $upload_dir[ 'basedir' ];
		$path = $upload_folder . '/' . $this->upload_demo;
		if ( !is_dir( $path ) ){
			mkdir( $path, 0755, true );
		} else {
        }
        $this->plugin_dir=plugin_dir_path(__FILE__ );
		$this->plugin_url=plugin_dir_url(__FILE__ );

		$this->uploads_baseurl=wp_upload_dir()['basedir'];
	}
    public function post_thumbnail_html_func($html, $post, $thumb, $size, $attr){
        if (empty($html)) {
            return '<img src="https://via.placeholder.com/300x200?text=Traveler"  class="'.$attr['class'].'"  alt="'.$attr['alt'].'"/>';
        }
        return $html;
    }
    public function wp_get_attachment_image_attributes_func($attr, $attachment, $size){
        if(empty($attr['src'])){
            $attr['src'] = 'https://via.placeholder.com/300x200?text=Traveler';
        }
        
        return $attr;
    }
    public function has_post_thumbnail_func($has, $post, $thumb){
        return true; 
    }

    public function wp_get_attachment_url_func($url, $post_id){
        if(empty($post_id)){
            $url = 'https://via.placeholder.com/300x200?text=Traveler';
        }
        
        return $url;
    }

   
    function load_template_full($template, $data = array()) {
        if (is_array($data))
            extract($data);
        //If file not found
        if (is_file($template)) {
            ob_start();

            include $template;

            $data = @ob_get_clean();

            return $data;
        }
    }
    
    public function recursive_array_diff($array1, $array2) { 
        $difference=array();
        foreach($array1 as $key => $value) {
            if(is_array($value) && isset($array2[$key])){ // it's an array and both have the key
                $new_diff = $this->recursive_array_diff($value, $array2[$key]);
                if( !empty($new_diff) )
                    $difference[$key] = $new_diff;
            } else if(is_array($array2) && is_string($value) && !in_array($value, $array2)) { // the value is a string and it's not in array B
                $difference[$key] = $value . " is missing from the second array";
            } else if(is_array($array2) && !is_numeric($key) && !array_key_exists($key, $array2)) { // the key is not numberic and is missing from array B
                $difference[$key] = "Missing from the second array";
            }
        }
        return $difference;
    }

    function wp_get_attachment_image_src( $image, $attachment_id, $size, $icon) {
        if (!isset($image[0])){
            $image[0] = 'https://via.placeholder.com/300x200?text=Traveler';
            $image[1] = 300;
            $image[2] = 200;
     }
        
        return $image;
    }

    public function quick_import_sql(){
        global $wpdb;
		set_time_limit(0);
        $percent = isset($_POST['percent']) ? $_POST['percent'] : 0;
        $number = isset($_POST['number']) ? intval($_POST['number']) : 0;
        $builder = isset($_REQUEST['builder']) ? ($_REQUEST['builder']) : 'wp-page-builder';
        global $wpdb;
        $wp_user_roles = $wpdb->prefix.'user_roles';
        $array_option = array(
            'siteurl',
            'home',
            'blogname',
            'blogdescription',
            'users_can_register', 
            'admin_email',
            'start_of_week',
            'use_balanceTags',
            'use_smilies',
            'require_name_email',
            'comments_notify',
            'posts_per_rss',
            'rss_use_excerpt',
            'mailserver_url',
            'mailserver_login',
            'mailserver_pass',
            'mailserver_port',
            'default_category',
            'default_comment_status',
            'default_ping_status',
            'default_pingback_flag',
            'posts_per_page',
            'date_format',
            'time_format',
            'links_updated_date_format',
            'comment_moderation',
            'moderation_notify',
            'blog_charset',
            'moderation_keys',
            'active_plugins',
            'category_base',
            'ping_sites',
            'comment_max_links',
            'gmt_offset',
            'default_email_category',
            'recently_edited',
            'default_role',
            'envato_purchasecode',
            'can_compress_scripts',
            'permalink_structure',
            $wp_user_roles,
            'blog_charset',
            'comment_whitelist',
            'comment_registration',
            'html_type',
            'use_trackback',
            'default_role',
            'db_version',
            'admin_email_lifespan',
            'initial_db_version',
            'fresh_site',
            'WPLANG',
        );
        $get_option_array = array();
        foreach($array_option as $option_default){
            $get_option_array[$option_default] = get_option($option_default);
        }
        sanitize_option('permalink_structure','/%postname%/', true);
        update_option('permalink_structure','/%postname%/', true);
        $scan_files =  glob($this->uploads_baseurl.'/'.$this->upload_demo.'/'.$_REQUEST['demo'].'/*.sql');
        if(isset($scan_files) && (count($scan_files) > 0)){
            $count_file_sql = 100/count($scan_files);
        } else {
            $count_file_sql= 0;
        }
        update_option('st_demo_install',$_REQUEST['demo']);
        global $wpdb;
        
        if ( $percent) {
            $wpdb->query( "SET GLOBAL max_allowed_packet=16777216" );
        }
        $charset_collate = $wpdb->get_charset_collate();
        if($number == 0 ){
            $table_name = 'wp_options_st';
            $wp_post_table = $wpdb->prefix.'posts';
            $wp_postmeta_table = $wpdb->prefix.'postmeta';
            $wp_termmeta_table = $wpdb->prefix.'termmeta';
            $wp_term_table = $wpdb->prefix.'terms';
            $wp_term_relationships_table = $wpdb->prefix.'term_relationships';
            $wp_term_taxonomy_table = $wpdb->prefix.'term_taxonomy';
            $wpdb->query( "TRUNCATE TABLE $wp_post_table" );
            $wpdb->query( "TRUNCATE TABLE $wp_postmeta_table" );
            $wpdb->query( "TRUNCATE TABLE $wp_termmeta_table" );
            $wpdb->query( "TRUNCATE TABLE $wp_term_table" );
            $wpdb->query( "TRUNCATE TABLE $wp_term_relationships_table" );
            $wpdb->query( "TRUNCATE TABLE $wp_term_taxonomy_table" );
            $wpdb->query( "DROP TABLE IF EXISTS $table_name" );
            $sql = "CREATE TABLE IF NOT EXISTS wp_options_st (
                option_id bigint(20) unsigned NOT NULL auto_increment,
                option_name varchar(64) NOT NULL default '',
                option_value longtext NOT NULL,
                autoload varchar(20) NOT NULL default 'yes',
                PRIMARY KEY  (option_id),
                UNIQUE KEY option_name (option_name)
              )  $charset_collate;";
    
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
            
            $charset_collate = $wpdb->get_charset_collate();
            $filename = $this->uploads_baseurl.'/'.$this->upload_demo.'/'.$_REQUEST['demo'] .'/wp_posts.sql';
            if (file_exists($filename)) {
                global $wp_filesystem;
                if (!$wp_filesystem) {
                    if (!function_exists('WP_Filesystem')) {
                        require_once wp_normalize_path(ABSPATH . '/wp-admin/includes/file.php');
                    }
                    WP_Filesystem();
                }
                $name = basename($scan_files[0], '.sql');
                $sql = $wp_filesystem->get_contents($scan_files[0]);
                if ($sql) {
                    $pos = stripos($name, '_');
                    $org_name = substr($name, $pos + 1, strlen($name));
                    if($org_name === 'options_st'){
                        $fix_name = 'wp_options_st';
                    } else {
                        $fix_name = $wpdb->prefix . $org_name;
                    }
                    
                    $sql = str_replace($name, $fix_name, $sql);
                    $wpdb->query('Truncate table ' . $fix_name);
                    $statements = array_filter(array_map('trim', explode('INSERT IGNORE INTO', $sql)));
                    foreach ($statements as $stmt) {
                        if (!empty($stmt)) {
                            $wpdb->query("INSERT INTO " . $stmt);
                        }
                    }
                    echo json_encode( array(
                        'status'    => 'ok',
                        'percent_progress' => $percent+$count_file_sql,
                        'okey' => array($org_name,$sql),
                        'next_post_data'=>array(
                            'action'=>'quick_import_sql',
                            'demo'=>$_REQUEST['demo'],
                            'builder' => $builder,
                            'percent' => $percent+$count_file_sql,
                            'number' => $number+1
                        )
                        )
                    );
                } else {
                    echo json_encode( array(
                        'status'    => 'error',
                        'message'  =>$scan_files[0],
                        'percent_progress' => $percent+$count_file_sql,
                        'next_post_data'=>array(
                            'action'=>'quick_import_sql',
                            'demo'=>$_REQUEST['demo'],
                            'builder' => $builder,
                            'percent' => $percent+$count_file_sql,
                            'number' => $number+1
                        )
                        )
                    );
                }
                die();
            } else {
                $customer_purchase_code = get_option('envato_purchasecode',false);
                $api_get_file_xml='http://shinetheme.com/demosd/databases/api-download.php';
                $data_api = array(
                    'action' => 'download_sql',
                    'customer_purchase_code' =>$customer_purchase_code,
                    'name_demo' => $_REQUEST['demo'],
                    'builder' => $builder,
                    'item_id' =>'',
                );
                $array_remote = ( array(
                    'method'      => 'POST',
                    'timeout'     => 600,
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
                $success_res = isset($response->url) ? $response->url : "";
                $elementor_zip_download = isset($response->elementor) ? $response->elementor : "";
                
                //process unzip elementor
                if(!empty($elementor_zip_download) && $builder === 'elementor'){
                    $local_elementor_file = $this->uploads_baseurl.'/elementor.zip';
                    $remote_file_elementor_url = download_url( $elementor_zip_download );
                    $copy_elementor = copy( $remote_file_elementor_url, $local_elementor_file );
                    unlink( $remote_file_elementor_url);

                    if($copy_elementor){
                        $file_elementor_zip = $this->uploads_baseurl.'/elementor.zip';
                        $path = pathinfo( realpath( $file_elementor_zip ), PATHINFO_DIRNAME );
                        $zip = new \ZipArchive();
                        $res = $zip->open($file_elementor_zip,\ZipArchive::CREATE);
                        if ($res === TRUE) {
                            $zip->extractTo( $path );
                            $zip->close();
                            unlink($file_elementor_zip);
                        }
                    }
                }

                if(!empty($success_res)){
                    $remote_file_url = $response->url;
                    $local_file = $this->uploads_baseurl.'/'.$this->upload_demo.'/'.$_REQUEST['demo'] .'.zip';
                    $remote_file_url = download_url( $remote_file_url );
                    $copy = copy( $remote_file_url, $local_file );
                    unlink( $remote_file_url );
                    if( !$copy ) {
                        echo json_encode( array(
                            'status'    => 'error',
                            'percent_progress' => $percent+$count_file_sql,
                            'message' => $e->getMessage(),
                            'next_post_data'=>array(
                                'action'=>'quick_import_sql',
                                'demo'=>$_REQUEST['demo'],
                                'builder' => $builder,
                                'percent' => $percent+$count_file_sql,
                                'number' => $number+1
                            )
                            )
                        );
                        die();
                    } else {
                        $file_zip = $this->uploads_baseurl.'/'.$this->upload_demo.'/'.$_REQUEST['demo'] .'.zip';
                        $path = pathinfo( realpath( $file_zip ), PATHINFO_DIRNAME );
                        $zip = new \ZipArchive();
                        $res = $zip->open($file_zip,\ZipArchive::CREATE);
                        if ($res === TRUE) {
                            $zip->extractTo( $path );
                            $zip->close();
                            unlink($file_zip);
                            $scan_files =  glob($this->uploads_baseurl.'/'.$this->upload_demo.'/'.$_REQUEST['demo'].'/*.sql');
                            if(isset($scan_files) && (count($scan_files) > 0)){
                                $count_file_sql = 100/count($scan_files);
                            } else {
                                $count_file_sql= 0;
                            }
                            global $wp_filesystem;
                            if (!$wp_filesystem) {
                                if (!function_exists('WP_Filesystem')) {
                                    require_once wp_normalize_path(ABSPATH . '/wp-admin/includes/file.php');
                                }
                                WP_Filesystem();
                            }
                            $name = basename($scan_files[0], '.sql');
                            $sql = $wp_filesystem->get_contents($scan_files[0]);
                            if ($sql) {
                                $pos = stripos($name, '_');
                                $org_name = substr($name, $pos + 1, strlen($name));
                                if($org_name === 'options_st'){
                                    $fix_name = 'wp_options_st';
                                } else {
                                    $fix_name = $wpdb->prefix . $org_name;
                                }
                                
                                $sql = str_replace($name, $fix_name, $sql);
                                $wpdb->query('Truncate table ' . $fix_name);
                                $statements = array_filter(array_map('trim', explode('INSERT IGNORE INTO', $sql)));
                                foreach ($statements as $stmt) {
                                    if (!empty($stmt)) {
                                        $wpdb->query("INSERT INTO " . $stmt);
                                    }
                                }
                                echo json_encode( array(
                                    'status'    => 'ok',
                                    'percent_progress' => $percent+$count_file_sql,
                                    'okey' => array($org_name,$sql),
                                    'next_post_data'=>array(
                                        'action'=>'quick_import_sql',
                                        'demo'=>$_REQUEST['demo'],
                                        'builder' => $builder,
                                        'percent' => $percent+$count_file_sql,
                                        'number' => $number+1
                                    )
                                    )
                                );
                            } else {
                                echo json_encode( array(
                                    'status'    => 'error-scanfile',
                                    'message'  =>$scan_files[0],
                                    'percent_progress' => $percent+$count_file_sql,
                                    'next_post_data'=>array(
                                        'action'=>'quick_import_sql',
                                        'demo'=>$_REQUEST['demo'],
                                        'builder' => $builder,
                                        'percent' => $percent+$count_file_sql,
                                        'number' => $number+1
                                    )
                                    )
                                );
                            }
                            die();
                        }
                        else {
                            echo json_encode( array(
                                'status'    => 'error',
                                'percent_progress' => $percent+$count_file_sql,
                                'message' => $scan_files[0],
                                'next_post_data'=>array(
                                    'action'=>'quick_import_sql',
                                    'demo'=>$_REQUEST['demo'],
                                    'builder' => $builder,
                                    'percent' => $percent+$count_file_sql,
                                    'number' => $number+1
                                    )
                                )
                            );
                            die();
                        }
                    }
                } else {
                    echo json_encode( array(
                        'status'=>'error',
                        'stop' => 1,
                        'message' => __('Please check purchase code again','traveler-code'),
                        )
                    );
                    die();
                }
            }
        }
        

        if($number <= count($scan_files)){
            foreach($scan_files as $key=>$file){
                if($number === intval($key) ){

                    global $wp_filesystem;
                    if (!$wp_filesystem) {
                        if (!function_exists('WP_Filesystem')) {
                            require_once wp_normalize_path(ABSPATH . '/wp-admin/includes/file.php');
                        }
                        WP_Filesystem();
                    }
                    $name = basename($file, '.sql');
                    $sql = $wp_filesystem->get_contents($file);
                    if ($sql) {
                        $pos = stripos($name, '_');
                        $org_name = substr($name, $pos + 1, strlen($name));
                        if($org_name === 'options_st'){
                            $fix_name = 'wp_options_st';
                        } else {
                            $fix_name = $wpdb->prefix . $org_name;
                        }
                        $sql = str_replace($name, $fix_name, $sql);
                        $wpdb->query('Truncate table ' . $fix_name);
                        $statements = array_filter(array_map('trim', explode('INSERT IGNORE INTO', $sql)));
                        foreach ($statements as $stmt) {
                            if (!empty($stmt)) {
                                $wpdb->query("INSERT INTO " . $stmt);
                            }
                        }
                        echo json_encode( array(
                            'status'    => 'ok',
                            'okey' => array($org_name,$sql),
                            'percent_progress' => $percent+$count_file_sql,
                            'next_post_data'=>array(
                                'action'=>'quick_import_sql',
                                'demo'=>$_REQUEST['demo'],
                                'builder' => $builder,
                                'percent' => $percent+$count_file_sql,
                                'number' => $number+1
                            )
                            )
                        );
                    } else {
                        echo json_encode( array(
                            'status'    => 'error',
                            'percent_progress' => $percent+$count_file_sql,
                            'next_post_data'=>array(
                                'action'=>'quick_import_sql',
                                'demo'=>$_REQUEST['demo'],
                                'builder' => $builder,
                                'percent' => $percent+$count_file_sql,
                                'number' => $number+1
                            )
                            )
                        );
                    }
                    die();
                    
                }
                
            }
        }
        $table_post = $wpdb->prefix.'posts';
        $table_postmeta = $wpdb->prefix.'postmeta';
        $table_termmeta = $wpdb->prefix.'termmeta';
        $query_post = "SELECT ID FROM {$table_post} WHERE post_type = 'attachment' ";
        $all_id_media = $wpdb->get_results($query_post,ARRAY_A);

        $arr_id_media = array();
        foreach ($all_id_media as $key => $idmedia) {
            array_push($arr_id_media,$idmedia['ID'] );
        }

        $convert_string = implode(",",$arr_id_media);

        //Delete postmeta image
        $sql_postmeta_delete = "DELETE FROM {$table_postmeta} WHERE post_id IN ({$convert_string}) ";
        $delete_images = $wpdb->query($sql_postmeta_delete);

        //Delete post image
        $sql_post_delete = "DELETE FROM {$table_post} WHERE ID IN ({$convert_string}) ";
        $delete_images_post = $wpdb->query($sql_post_delete);
        $all_id_media = $wpdb->get_results($query_post,ARRAY_A);


        $table_option = $wpdb->prefix.'options';
        $field_old_sql = "SELECT * FROM {$table_option}";
        $field_old = $wpdb->get_results($field_old_sql,ARRAY_A);
        $array_key = array();
        $array_key_new = array();
        foreach($field_old as $fl_old){
            $array_key[$fl_old['option_name']] = $fl_old;
        }
        $field_new_sql = "SELECT * FROM wp_options_st";
        $field_new = $wpdb->get_results($field_new_sql,ARRAY_A);

        foreach($field_new as $fl_new){
            if(!in_array($fl_new['option_name'],$array_option )){
                $get_option = get_option($fl_new['option_name']);
                if(isset($get_option)){
                    if($fl_new['option_name'] === 'option_tree'){
                        if(is_serialized($fl_new['option_value'])){
                            $fl_new['option_value'] = unserialize($fl_new['option_value']);
                            
                        }
                        update_option($fl_new['option_name'],$fl_new['option_value']);
                        
                    } else {
                        if(is_serialized($fl_new['option_value'])){
                            $fl_new['option_value'] = unserialize($fl_new['option_value']);
                            
                        }
                        update_option($fl_new['option_name'],$fl_new['option_value']);
                    }
                    
                } else {
                    $autoload = $fl_new['autoload'];
                    add_option( $fl_new['option_name'], $fl_new['option_value'], $autoload );
                }
            }
            $array_key_new[$fl_new['option_name']] = $fl_new;
        }
        $diff = $this->recursive_array_diff($array_key_new,$array_key);

        foreach($array_option as $option_default){
            update_option($option_default,$get_option_array[$option_default]);
        }
        echo json_encode( array(
            'status'=>'ok',
            'stop' => 1,
            'percent_progress' => $percent+$count_file_sql,
            )
        );
        die();
        
    }
     
}
$STVinaImportProcess = new STVinaImportProcess();
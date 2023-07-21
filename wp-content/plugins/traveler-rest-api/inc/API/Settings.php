<?php 
namespace Inc\API;
use \WP_REST_Server;
use \WP_REST_Request;
use \WP_Query;
use \TravelHelper;
use \TravelerObject;
use \Inc\API\STApiCore;
class Settings
{
    public $settings = [];
    private $rest_url = 'traveler';
    
	public function get_settings() {
		add_action( 'rest_api_init', array( $this, '_init_rest_api'));
        add_action('template_redirect', [$this, '_setCartUserApi']);
        add_action('st_before_destroy_cart',[$this, '_removeCartbyUserId']);
	}
    
    public function _init_rest_api(){
        register_rest_route(  $this->rest_url, '/get-logo-mobile',
            array(
                'callback'    => array($this, 'get_logo_api'),
                'permission_callback' => array( $this, 'get_items_permissions_check' ),
                'methods'         => WP_REST_Server::READABLE,
                'args'            => array(),
            )
        );
        register_rest_route( $this->rest_url, '/get-menu-mobile',
            array(
                'callback' => array($this, 'get_menu_api'),
                'permission_callback' => array( $this, 'get_items_permissions_check' ),
                'methods'         => WP_REST_Server::READABLE,
                'args'            => array(),
            )
        
        );
      
        register_rest_route(  $this->rest_url, '/get-locations',
            array(
                'callback'    => array($this, 'get_locations_api'),
                'permission_callback' => array( $this, 'get_items_permissions_check' ),
                'methods'         => WP_REST_Server::READABLE,
                'args'            => array(),
            )
        );

        /// List service

        register_rest_route( $this->rest_url, '/services/(?P<slug>[a-z0-9]+(?:_[a-z0-9]+)*)', array(
            'methods' => WP_REST_Server::READABLE,
            'callback'    => array($this, 'get_list_service_api'),
            'permission_callback' => '__return_true',
            'args' => array(
                'slug' => array (
                    'required' => true
                ),
                'orderby' => array (
                    'required' => true
                ),
                'order' => array (
                    'required' => true
                ),
                'posts_per_page' => array (
                    'required' => true
                ),
                'paged' => array (
                    'required' => true
                ),
            )
        ) );

        /// Detail service

        register_rest_route( $this->rest_url, '/services/(?P<slug>[a-z0-9]+(?:_[a-z0-9]+)*)/(?P<id>[a-z0-9]+(?:_[a-z0-9]+)*)', array(
            'methods' => WP_REST_Server::READABLE,
            'callback'    => array($this, 'get_detail_service_api'),
            'permission_callback' => '__return_true',
            'args' => array(
                'slug' => array (
                    'required' => true
                ),
                'id' => array (
                    'required' => true
                ),
            )
        ) );
       
        
   

        register_rest_route(  $this->rest_url, '/cart',
        array(
                'callback'    => array($this, 'cart_api'),
                'permission_callback' => '__return_true',
                'methods'         => WP_REST_Server::READABLE,
                'args'            => array(
                    'token' => array (
                        'required' => true
                    ),  
                ),
            )
        );

        register_rest_route( $this->rest_url, '/checkout', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback'    => array($this, 'checkout_api'),
            'permission_callback' => '__return_true',
            'args' => array(
                'token' => array(
                    'required' => true
                ),
                'st_first_name' => array(
                    'required' => true
                ),
                'st_last_name' => array(
                    'required' => true
                ),
                'st_email' => array(
                    'required' => true
                ),
                'st_phone' => array(
                    'required' => true
                ),
            ),
        ) );
        
        register_rest_route( $this->rest_url, '/order/list-all', array(
            'methods' => WP_REST_Server::CREATABLE,
            'callback'    => array($this, 'order_list_all_api'),
            'permission_callback' => '__return_true',
            'args' => array(
                'admin_key' => array(
                    'required' => false
                ),
                'token' => array(
                    'required' => false
                ),
                'paged' =>array(
                    'required' => false
                ),

            ),
        ) );
        
        register_rest_route( $this->rest_url, '/order/(?P<id>[a-z0-9]+(?:_[a-z0-9]+)*)', array(
            'methods' => WP_REST_Server::READABLE,
            'callback'    => array($this, 'order_detail_api'),
            'permission_callback' => '__return_true',
            'args' => array(
                'id' => array(
                    'required' => true
                ),
            ),
        ) );

     
        //Elementor API
       
        register_rest_route(  $this->rest_url, '/get-list-item/(?P<type>[a-z0-9]+(?:_[a-z0-9]+)*)',
            array(
                'callback'    => array($this, 'get_list_item'),
                'methods'         => WP_REST_Server::READABLE,
                'permission_callback' => '__return_true',
                'args'            => array(
                    'type' => array (
                        'required' => true
                    ),
                ),
            )
        );

        register_rest_route(  $this->rest_url, '/get-template-item',
            array(
                'callback'    => array($this, 'get_template_item'),
                'permission_callback' => array( $this, 'get_items_permissions_check' ),
                'methods'         => WP_REST_Server::READABLE,
                'args'            => array(
                    'id' => array (
                        'required' => true
                    ),
                    
                ),
            )
        );
    
      
    }
    // Check valid purchasecode
    public function check_valid_purchasecode($pcc){
        
        $array = [
            'cfd6b1472250ae8d0b3548c41cb8868e',
            '3997f54ee0e20ff46c959461b7882355',
            '22c4999f03e69c5ffe34898fc80d7e58',
        ];
        if(in_array(md5($pcc), $array)){
            return true;
        } else {
            return false;
        }
    }
    // Check valid purchasecode
    public function checkValidatePurchaseCode($_purchase_code = false){
       
      
        if(!empty($_purchase_code)){
            
            if(self::check_valid_purchasecode($_purchase_code)){
                return true;
            }else{
                $item_id = 10822683;

                $url = "https://api.envato.com/v3/market/author/sale?code=".$_purchase_code;
                
                $personal_token = "fivQeTQarEgttMvvxLjnYza19xh1r8lo";

                if( ini_get('allow_url_fopen') ) {
                    $options = array('http' => array(
                        'method'  => 'GET',
                        'header' => 'Authorization: Bearer '.$personal_token
                    ));
                    $context  = stream_context_create($options);
                    $envatoRes = file_get_contents($url, false, $context);
                }
                if(!$envatoRes ){
                    $curl = curl_init($url);
                    $header = array();
                    $header[] = 'Authorization: Bearer '.$personal_token;
                    $header[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0';
                    $header[] = 'timeout: 30';
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_HTTPHEADER,$header);

                    $envatoRes = curl_exec($curl);
                    curl_close($curl);
                }

                if(!empty($envatoRes)){
                    $res=json_decode($envatoRes,true);
                    
                    if(!empty($res)){
                     
                        if(isset($res['item']['id'])){
                            if($res['item']['id'] == $item_id){
                                return true;
                            }else {
                                return false; 
                            }
                        }
                    }
                }
            }
        }else {
        
            return false;
        }
    }

    public function get_items_permissions_check(WP_REST_Request $request ) {
        $get_params = $request->get_params();
        return self::checkValidatePurchaseCode($get_params["pass_application"]);
    }

    public function get_logo_api(WP_REST_Request $request){
        $logo_mobile_url = st()->get_option('logo_mobile', '');
        $get_params = $request->get_params();
        if(!empty($logo_mobile_url)){
            $infor = [
                'url' => $logo_mobile_url,
                'status' => true
            ];
        } else {
            $infor = [
                'url' => get_bloginfo( 'name' ),
                'status' => false
            ];
        }
        return $infor;
    }

    public function get_menu_api(WP_REST_Request $request) {
        $theme_locations = get_nav_menu_locations();
        $menu_obj = get_term( $theme_locations['mb_menu'], 'nav_menu' );
        $menu_items = wp_get_nav_menu_items($menu_obj->term_id);
     
        $array_data = [];
        foreach( $menu_items as $menu_item ) {
            
            $array_item_menu = [
                'ID' => $menu_item->ID,
                'name' =>  $menu_item->title,
                'menu_item_parent' => $menu_item->menu_item_parent,
                'url' => $menu_item->url,
            ];
            $array_data[] =$array_item_menu;
        }
        $get_params = $request->get_params();
        if(!empty($array_data)){
            echo json_encode([
				'success' => true,
				'data' => $array_data,
				'notice' => __('Found','traveler-rest-api'),
			]);
        }else {
            echo json_encode(
                [
                    'success' => false,
                    'notice' => __('Not found mobile menu','traveler-rest-api'),
                ]
            );
        }

    }
    
    public function get_locations_api(WP_REST_Request $request) {
        $enable_tree = st()->get_option( 'bc_show_location_tree', 'off' );
        if(empty($location_name)){
            if(!empty($location_id)){
                $location_name = get_the_title($location_id);
            }
        }
        if ( $enable_tree == 'on' ) {
            $lists     = TravelHelper::getListFullNameLocation( 'st_tours');
            $locations = TravelHelper::buildTreeHasSort( $lists );
           
        } else {
            $locations = TravelHelper::getListFullNameLocation( 'st_tours');
        }
        $array_data = [];
        foreach( $locations as $key => $value ) {
            
           $array_location = [
               'ID' => $value['ID'],
               'name' => $value['fullname'],
               'lv' => $value['lv'],
           ];
           
           if(isset( $value[ 'children' ])) {
            $array_location['children'] = $value['children'];
           }
           
           $array_data[] =   $array_location;
        }
        if(!empty($array_data)){
            echo json_encode([
				'success' => true,
				'data' => $array_data,
				'notice' => __('Found','traveler-rest-api'),
			]);
        }else {
            echo json_encode(
                [
                    'success' => false,
                    'notice' => __('Not found locations','traveler-rest-api'),
                ]
            );
        }
        
    }  
   

    public function get_list_service_api(WP_REST_Request $request){
       
        $slug = 'st_'.$request['slug'];
        $orderby = $request['orderby'];
        $order  = $request['order'];
        $paged   = $request['paged'];
        $posts_per_page = $request['posts_per_page'];
        $args = array(
            'post_type'        => $slug,
            'posts_per_page'   => $posts_per_page,
            'paged'            =>$paged,
            'orderby'          =>$orderby,
            'order'            =>$order,
           );
        $query = new WP_Query( $args ); 
       
        $array_data = [];
		if($query->have_posts()) : while($query->have_posts()) : $query->the_post();
       
		$array_item_infor = [
			'ID' =>  get_the_ID(),
			'url' => get_the_permalink(),
            'title' => get_the_title(),
            'image' =>  wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ),
            'excerpt' => get_the_excerpt(),
		];

		$array_data[] =$array_item_infor;
		endwhile;endif; wp_reset_postdata();
        if(!empty($array_data)){
            echo json_encode([
				'success' => true,
				'data' => $array_data,
				'notice' => __('Found','traveler-rest-api'),
			]);
        }else {
            echo json_encode([
				'success' => false,
				'notice' => __('Not Found','traveler-rest-api'),
			]);
        }
    }
    
    public function get_detail_service_api(WP_REST_Request $request){
        $slug = 'st_'.$request['slug'];
      
        $id = $request['id'];
        $date_start = $request['date-start'];
        $date_start_timestamp = strtotime($date_start);
        $date_end = $request['date-end'];
        $date_end_timestamp = strtotime($date_end);
        $args = array(
            'post_type' => $slug,
            'p' => $id, 
           );
        $query = new WP_Query( $args ); 
        $array_data = [];
		if($query->have_posts()) : while($query->have_posts()) : $query->the_post();
        $meta_key = get_post_meta(get_the_ID(), '', true);
        foreach ($meta_key as $key => $value ) {
           
            $array_data_meta[ $key] = $value;
           
        }
        $gallery = get_post_meta(get_the_ID(), 'gallery', true);
        $gallery_array = explode(',', $gallery);
        foreach ($gallery_array as $key=>$value) {
            $array_data_gallery[] =  wp_get_attachment_image_url($value, 'full') ;
        }
        $array_data_gallery_mix['gallery'] = $array_data_gallery;
        $currentDate = date("m/d/Y");
        $currentDate = strtotime($currentDate);
        if(empty($date_end_timestamp)) {
            $end_date = date("m/d/Y", strtotime("+1 month", $currentDate));
            $date_end_timestamp = strtotime($end_date);
        }
        $availability_rows = null;
       
        global $wpdb;
        
        if($slug === 'st_tours' && !empty($date_start_timestamp) && !empty($date_end_timestamp) ) {
            $availability_rows = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}st_tour_availability WHERE post_id = $id AND check_in >= $date_start_timestamp AND check_in <= $date_end_timestamp" ) ;
        }
        if($slug === 'st_activity' && !empty($date_start_timestamp) && !empty($date_end_timestamp) ) {
            $availability_rows = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}st_activity_availability WHERE post_id = $id AND check_in >= $date_start_timestamp AND check_in <= $date_end_timestamp" ) ;
        }
        if($slug === 'st_rental' && !empty($date_start_timestamp) && !empty($date_end_timestamp) ) {
            $availability_rows = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}st_rental_availability WHERE post_id = $id AND check_in >= $date_start_timestamp AND check_in <= $date_end_timestamp" ) ;
        }
        
        
        
        $array_item_infor = [
			'ID' =>  get_the_ID(),
            'title' => get_the_title(),
            'image' =>  wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ),
            'excerpt' => get_the_excerpt(),
            'description' =>  get_the_content(),
            'availability' => $availability_rows,
		];
       
		$array_data[] =array_merge($array_item_infor,$array_data_meta,$array_data_gallery_mix);
        
		endwhile;endif; wp_reset_postdata();
        if(!empty($array_data)){
            echo json_encode([
				'success' => true,
				'data' => $array_data,
				'notice' => __('Found','traveler-rest-api'),
			]);
        }else {
            echo json_encode([
				'success' => false,
				'notice' => __('Not Found','traveler-rest-api'),
			]);
        }
    }

    public function checkout_api(WP_REST_Request $request){
        $get_params = $request->get_params();
        $token = $get_params['token'];
        $st_email = $get_params['st_email'];
        $st_first_name= $get_params['st_first_name'];
        $st_last_name = $get_params['st_last_name'];
        $st_phone = $get_params['st_phone'];
        $st_address = $get_params['st_address'];
        $st_address2 = $get_params['st_address2'];
        $st_city = $get_params['st_city'];
        $st_province = $get_params['st_province'];
        $st_zip_code = $get_params['st_zip_code'];
        $st_country = $get_params['st_country'];
        $st_note = $get_params['st_note'];
        $term_condition = $get_params['term_condition'];
        $st_api_core = new STApiCore;
        $response = $st_api_core->get_user_from_token($token);
        $user_id = !empty($response['id']) ? $response['id'] : 0;
        $data_cart= get_user_meta( $user_id, '_save_cart_data_'.$user_id , true );
        $data_checkout = $st_api_core->booking_form_submit($user_id,$data_cart,$st_email,$st_first_name,$st_last_name,$st_phone,$st_address,$st_address2,$st_city,$st_province,$st_zip_code,$st_country,$st_note,$term_condition);
        
            if(!empty($data_checkout)) {
                echo json_encode(
                    [
                        'success' => true,
                        'data' => $data_checkout,
                        'notice' => __('Your order was submitted successfully!','traveler-rest-api'),
                    ]
                );
            }
    }

    public function order_list_all_api(WP_REST_Request $request) {
        try {
            $get_params = $request->get_params();
            $token = $get_params['token'];
            $admin_key = $get_params['admin_key'];
            $page = $get_params['paged'];
            $status = '';
            $st_api_core = new STApiCore;
            if(st()->get_option('traveler_rest_api_key') == $admin_key){
                $user_id = $admin_key;
            } else {
                
                $response = $st_api_core->get_user_from_token($token);
   
                $user_id = !empty($response['id']) ? $response['id'] : -1;
            }
            
            if($user_id != -1){
                $data = $st_api_core->get_book_history( $user_id , $status, $admin_key,$page );
                if(!empty($data)){
                    echo json_encode([
                        'success' => true,
                        'data' => $data,
                        'notice' => __('Found','traveler-rest-api'),
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'data' => $data,
                        'notice' => __('Token false','traveler-rest-api'),
                    ]);
                }
            } else{
                echo json_encode([
                    'success' => false,
                    'data' => [],
                    'notice' => __('Token false','traveler-rest-api'),
                ]);
            }
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'data' => $data,
                'notice' => $e->getMessage(),
            ]);
        }
        
        die();
    }

    public function order_detail_api(WP_REST_Request $request) { 
        $get_params = $request->get_params();
        $order_id =  $get_params['id'];
        $data_user_order = get_post_meta( $order_id );
        global $wpdb;
        $querystr = "SELECT SQL_CALC_FOUND_ROWS * FROM
        " . $wpdb->prefix . "st_order_item_meta st WHERE st.order_item_id = " .$order_id ." AND type = 'normal_booking'" ;
        $data_order = $wpdb->get_results( $querystr, OBJECT );
        $data_order =  (array) $data_order[0]; 
        $data = array_merge($data_user_order, $data_order);
        if(!empty($data)){
            echo json_encode([
				'success' => true,
				'data' => $data,
				'notice' => __('Found','traveler-rest-api'),
			]);
        }
        die();
    }


    //Elementor Api Callback

    public function get_list_item(WP_REST_Request $request) {
        $get_params = $request->get_params();
        $type = $get_params['type'];
        $args = array(
            'post_type'              => 'elementor_library', 
            'post_status'            => array('publish'),
            'posts_per_page'         => -1, 
            'order'                  => 'DESC', 
            'orderby'                => 'ID', 
            'tax_query' => array(
                array(
                    'taxonomy' => 'elementor_library_type', // taxonomy slug
                    'field'    => 'slug',
                    'terms'    => $type, // term ids
                ),
            ),
        );
        $query = new WP_Query($args);
        $array_data = [];
        if($query->have_posts()) : while($query->have_posts()) : $query->the_post();
        $post_categories = get_the_terms( get_the_ID(), 'elementor_library_category' );
        
        $category = $post_categories[0]->name;
        $categoryID = $post_categories[0]->term_id;
        $live_url = get_permalink(get_the_ID());  
           
		$array_item_infor = [
			'ID' =>  get_the_ID(),
            'title' => get_the_title(),
            'live_url' => $live_url,
            'image' =>  wp_get_attachment_url( get_post_thumbnail_id(get_the_ID()) ),
            'category' => $category,
            'cateID'   => $categoryID,
		];
        
		$array_data[] =$array_item_infor;
		endwhile;endif; wp_reset_postdata();
       
        if(!empty($array_data)){
            echo json_encode([
				'success' => true,
				'data' => $array_data,
				'notice' => __('Found','traveler-rest-api'),
			]);
        }
        die();
    }

    public function get_template_item(WP_REST_Request $request) {
        $get_params = $request->get_params();
        $id = $get_params['id'];
        $user_domain = $get_params['user-domain'];
        $user_name = $get_params['user-name'];
        $user_email = $get_params['user-email'];
        $section_name = get_the_title($id);
        $template_export_data = "";
        if (class_exists("\\Elementor\\Plugin")) {
            $post_ID = $get_params['id'];
            $pluginElementor = \Elementor\Plugin::instance();
            $template_document = $pluginElementor->documents->get( $post_ID );
            $template_export_data = $template_document->get_export_data();
        }
        //inser db 
        global $wpdb;
        $table = $wpdb->prefix.'st_customer';
        $data = array('user_domain' => $user_domain, 'user_name' => $user_name,'user_email'=>$user_email,'section_name'=>$section_name);
        $format = array('%s','%s','%s','%s');
        $wpdb->insert($table,$data,$format);
        $my_id = $wpdb->insert_id;

        if(!empty($template_export_data)) {
            echo json_encode(
                [
                    'success' => true,
                    'data' => $template_export_data,
                    'notice' => __('Found','traveler-rest-api'),
                ]
            );
        }
        die();
    }
   

    public function _removeCartbyUserId(){
        $userID = get_current_user_id();
        return update_user_meta( $userID, '_save_cart_data_'.$userID, null);
    }

    public function _setCartUserApi() {
        if( is_user_logged_in()){
            $userID = get_current_user_id();
            $data= get_user_meta( $userID, '_save_cart_data_'.$userID , true );
            if($data) {
                $data_compress = base64_encode(gzcompress(addslashes(serialize($data)), 9));
                TravelHelper::setcookie('st_cart', $data_compress, time() + (86400 * 30));
            }else {
                TravelHelper::setcookie( 'st_cart', '', time() - 3600 );
            }
           
            //return $cart;
        }
    }
    
   
}
?>
<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 11/24/14
 * Time: 8:58 AM
 */
class STCustomOptiontree
{
    public  $url;
    public $dir;

    function __construct()
    {

        $this->dir=st()->dir('plugins/custom-option-tree');
        $this->url=st()->url('plugins/custom-option-tree');


        add_action('admin_enqueue_scripts',array($this,'add_scripts'));
        add_action('wp_enqueue_scripts',array($this,'_add_scripts'));
    }

    function init()
    {


        if( !class_exists( 'OT_Loader' ) ) return false;


        //Default Fields
        add_filter( 'ot_post_select_ajax_unit_types', array($this,'ot_post_select_ajax_unit_types'), 10, 2 );


        add_filter( 'ot_option_types_array', array($this,'ot_add_custom_option_types') );
        add_action('wp_ajax_st_post_select_ajax',array($this,'st_post_select_ajax'));
        add_action('wp_ajax_st_transfer_from_select_ajax',array($this,'st_transfer_from_select_ajax'));
        add_action('wp_ajax_st_transfer_to_select_ajax',array($this,'st_transfer_to_select_ajax'));
        add_action('wp_ajax_st_post_select_carstransfer_ajax',array($this,'st_post_select_carstransfer_ajax'));


        //Extra Fields

        $files= array_filter(glob($this->dir.'/fields/*'), 'is_file');

        if(!empty($files))
        {
            foreach($files as $key=>$value)
            {
               include_once $value;
            }
        }

        //Custom CSS Output
        include_once $this->dir.'/custom-css-output.php';

    }

    function add_scripts()
    {
        if(!in_array(get_post_type( ) , array('product', 'shop_order'))){
            wp_register_script('select2', get_template_directory_uri().'/js/select2-new/js/select2.full.js',array('jquery'),null,true);

            $lang = get_locale();
            $lang_file = ST_TRAVELER_DIR.'/js/select2-new/js/i18n/'.$lang.'.js';
            if(file_exists($lang_file)){
                wp_register_script('select2-lang', get_template_directory_uri().'/js/select2-new/js/i18n/'.$lang.'.js',array('jquery','select2'),null,true);
            }else{
                $locale_array = explode('_',$lang);
                if(!empty($locale_array) and $locale_array[0]){
                    $locale = $locale_array[0];

                    $lang_file = ST_TRAVELER_DIR.'/js/select2-new/js/i18n/'.$locale.'.js';
                    if(file_exists($lang_file))
                        wp_register_script('select2-lang',get_template_directory_uri().'/js/select2-new/js/i18n/'.$locale.'.js',array('jquery','select2'),null,true);
                }
            }
            wp_register_style('select2', get_template_directory_uri().'/js/select2-new/css/select2.css');

            wp_register_script('st_post_select_ajax',$this->url.'/js/st_post_select_ajax.js',array('select2','select2-lang'),null,true);
            wp_register_style('st_post_select_ajax',$this->url.'/css/post_select_ajax.css',array('select2'));
        }
    }
    function _add_scripts()
    {
        if(get_post_type() == 'product'){
            return;
        }
        wp_register_script('select2', get_template_directory_uri().'/js/select2-new/js/select2.full.js',array('jquery'),null,true);

        $lang = get_locale();
        $lang_file = ST_TRAVELER_DIR.'/js/select2-new/js/i18n/'.$lang.'.js';
        if(file_exists($lang_file)){
            wp_register_script('select2-lang', get_template_directory_uri().'/js/select2-new/js/i18n/'.$lang.'.js',array('jquery','select2'),null,true);
        }else{
            $locale_array = explode('_',$lang);
            if(!empty($locale_array) and $locale_array[0]){
                $locale = $locale_array[0];

                $lang_file = ST_TRAVELER_DIR.'/js/select2-new/js/i18n/'.$locale.'.js';
                if(file_exists($lang_file))
                    wp_register_script('select2-lang',get_template_directory_uri().'/js/select2-new/js/i18n/'.$locale.'.js',array('jquery','select2'),null,true);
            }
        }
        wp_register_style('select2', get_template_directory_uri().'/js/select2-new/css/select2.css');

        wp_register_script('st_post_select_ajax',$this->url.'/js/st_post_select_ajax.js',array('select2','select2-lang'),null,true);
        wp_register_style('st_post_select_ajax',$this->url.'/css/post_select_ajax.css',array('select2'));
    }
    public function st_transfer_from_select_ajax(){
        $result = array();
        $data = TravelHelper::transferDestinationOptionNewFronend();
        $q         = STInput::get('q');
        foreach ( $data as $point ):
            if (strpos($point['label'],$q ) !== FALSE) {
               $result['items'][]         = array(
                    'id' =>  $point['value'],
                    'name' => $point['label'],
                    'description' => $point['value']
                );
            }

        endforeach;
       $result['total_count']     = count($data);
       echo json_encode($result);
        die();
    }
    public function st_transfer_to_select_ajax(){
        $result = array();
        $data = TravelHelper::transferDestinationOptionNewFronend();
        $q         = STInput::get('q');
        foreach ( $data as $point ):
            if (strpos($point['label'],$q ) !== FALSE) {
               $result['items'][]         = array(
                    'id' =>  $point['value'],
                    'name' => $point['label'],
                    'description' => $point['value']
                );
            }

        endforeach;
       $result['total_count']     = count($data);
       echo json_encode($result);
        die();
    }
    public function st_post_select_carstransfer_ajax(){


        $html ='';
        $transfer_from = STInput::get('transfer_from');
        $transfer_to = STInput::get('transfer_to');
        $car_transfer = STCarTransfer::inst();
        $all_tranfer = $car_transfer->get_all_transfer($transfer_from,$transfer_to);
        if(isset($all_tranfer) && !empty($all_tranfer)){
            foreach ($all_tranfer as $key => $value) {
                $html .='<option value="'.$value->post_id.'">'.get_the_title($value->post_id).'</option>';
            }
        }
        $result       = array(
            'html' => wp_unslash($html),
        );

        echo json_encode($result);
        die();
    }
    function st_post_select_ajax(){
        $result       = array(
            'total_count' => 0,
            'items'       => array(),
        );
        $q         = STInput::get('q');
        $post_type = STInput::get('post_type');
        $user_id   = STInput::get('user_id', '');
        if($q){
            if(!$post_type) $post_type ='st_hotel';
            $args = array(
                'post_type'                => $post_type,
                'posts_per_page'           => 20,
                's'                        => isset($q['term']) ? esc_html(trim($q['term'])) : $q,
                'post_status'              => array('publish', 'private')
            );
            if( !is_super_admin( $user_id ) ){
                $args['author'] = $user_id;
            }
            $the_query = new WP_Query( $args );
            if ( $the_query->have_posts() ) {
                while($the_query->have_posts()){
                    $the_query->the_post();
                    $result['items'][]         = array(
                        'id'                       => get_the_ID(),
                        'name'                     => get_the_title(),
                        'description'              => "ID: ".get_the_ID()
                    );

                }
            }
            wp_reset_postdata();
            wp_reset_query();
            $result['total_count']     = $the_query->found_posts;
        }
        echo json_encode($result);
        die();
    }

    function ot_post_select_ajax_unit_types($array, $id )
    {
        return apply_filters( 'post_select_ajax', $array, $id );
    }

    function ot_add_custom_option_types( $types ) {
        $types['post_select_ajax']       = __('Post Select Ajax','traveler');

        return $types;
    }




}


$a=new STCustomOptiontree();
$a->init();


if(!function_exists('ot_type_post_select_ajax')):
function ot_type_post_select_ajax($args = array())
{

    $default=array(

        'field_post_type'=>'st_hotel',
        'field_desc'=>__('Search for a Item','traveler')
    );

    wp_enqueue_script('st_post_select_ajax');
    wp_enqueue_style('st_post_select_ajax');

    $args=wp_parse_args($args,$default);


    extract($args);

    $post_type=$field_post_type;

    /* verify a description */
    $has_desc = $field_desc ? true : false;

    /* format setting outer wrapper */
    echo '<div class="format-setting type-post_select_ajax ' . ( $has_desc ? 'has-desc' : 'no-desc' ) . '">';
    /* description */
    echo balanceTags($has_desc ? '<div class="description">' . htmlspecialchars_decode( $field_desc ) . '</div>' : '');
    /* format setting inner wrapper */
        echo '<div class="format-setting-inner">';
        /* allow fields to be filtered */
        $post_select_ajax = apply_filters( 'ot_recognized_post_select_ajax_fields', $field_value, $field_id );

            $pl_name='';
            $pl_desc='';
            if($field_value)
            {
                $pl_name=get_the_title($field_value);
                $pl_desc="ID: ".get_the_ID($field_value);
                $pl_id = get_the_ID($field_value);
            }

            $post_type_json=$post_type;

            echo '<div class="option-tree-ui-post_select_ajax-input-wrap">';
            echo "<select data-pl-name='{$pl_name}' data-pl-desc='{$pl_desc}' data-placeholder='{$field_desc}' value='{$field_value}' data-post-type='{$post_type_json}' type=hidden class='st_post_select_ajax' id='". esc_attr( $field_id ) . "' name='". esc_attr( $field_name ) ."'><option value='{$field_value}' selected='selected'>{$pl_name}</option></select>";
            echo '</div>';
        echo '</div>';
    echo '</div>';
}
endif;

<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 1/20/15
 * Time: 2:35 PM
 */
if(!class_exists('BTOTGmap'))
{
    class BTOTGmap extends BTOptionField
    {
        static  $instance=null;
        public $curent_key;

        function __construct()
        {
            parent::__construct(__FILE__);
            parent::init(array(
                'id'=>'bt_gmap',
                'name'          =>__('Gmap Location','traveler')
            ));
            add_action('admin_enqueue_scripts',array($this,'add_scripts'));
            add_action('save_post',array($this,'_save_separated_field'));
        }

        /**
         *
         *
         * @since 1.0
         * */
        function _save_separated_field( $post_id )
        {
            $st_google_map = get_post_meta($post_id,'st_google_map',true);
            if(!empty($st_google_map)){
                $default=array(
                    'lat'=>'',
                    'lng'=>'',
                    'zoom'=>'',
                    'type'=>'',
                );
                $meta_value=wp_parse_args($st_google_map,$default);
                update_post_meta($post_id,'map_lat',$meta_value['lat']);
                update_post_meta($post_id,'map_lng',$meta_value['lng']);
                update_post_meta($post_id,'map_zoom',$meta_value['zoom']);
                update_post_meta($post_id,'map_type',$meta_value['type']);
            }
        }

        function add_scripts()
        {
            $google_api_key = st()->get_option('st_googlemap_enabled');
            if($google_api_key === 'on'){
                wp_register_script('gmapv3',$this->_url.'js/gmap3.min.js',array('jquery','gmap-apiv3'),false,true);
                wp_register_script('bt-gmapv3-init',$this->_url.'js/init.js',array('gmapv3'),false,true);
                wp_register_style('bt-gmapv3',$this->_url.'css/bt-gmap.css');
            } else {
                wp_register_script('mapboxv5', 'https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.0/mapbox-gl.js',array(),true,false);
                wp_register_script('mapboxv5-geocoder', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.3.0/mapbox-gl-geocoder.min.js',array(),true,false);
                wp_register_style('mapbox-css-geocoder', 'https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.3.0/mapbox-gl-geocoder.css');
                wp_register_style('mapbox-css', 'https://api.tiles.mapbox.com/mapbox-gl-js/v1.6.0/mapbox-gl.css');
                wp_register_script('bt-mapboxv5-init',$this->_url.'js/init-mapbox.js');
            }
        }

        static function instance()
        {
            if(self::$instance==null)
            {
                self::$instance=new self();
            }
            return self::$instance;
        }
    }
    BTOTGmap::instance();

    if(!function_exists('ot_type_bt_gmap'))
    {
        function ot_type_bt_gmap($args = array())
        {
            $google_api_key = st()->get_option('st_googlemap_enabled');
            $default=array(
                'field_name'=>''
            );
            $args=wp_parse_args($args,$default);
            if($google_api_key === 'on'){
            wp_enqueue_script('bt-gmapv3-init');
            wp_enqueue_style('bt-gmapv3');
            }else {
                wp_enqueue_script('mapboxv5-geocoder');
                wp_enqueue_script('mapboxv5',true,false);
                wp_enqueue_style('mapbox-css-geocoder');
                wp_enqueue_style('mapbox-css');
                wp_enqueue_style('bt-gmapv3');
                wp_enqueue_script('bt-mapboxv5-init');
            }
            BTOTGmap::instance()->curent_key=$args['field_name'];
            echo BTOTGmap::instance()->load_view(false,array('args'=>$args));
        }
    }

    if(!function_exists('ot_type_bt_gmap_html'))
    {
        function ot_type_bt_gmap_html($args = array())
        {
            $google_api_key = st()->get_option('st_googlemap_enabled');
            $default=array(
                'field_name' => 'gmap',
                'range'      => 50
            );
            $args=wp_parse_args($args,$default);
            if($google_api_key === 'on'){
            wp_enqueue_script('bt-gmapv3-init');
            wp_enqueue_style('bt-gmapv3');
            }else {
                wp_enqueue_script('mapboxv5');
                wp_enqueue_script('mapboxv5-geocoder');
                wp_enqueue_script('bt-mapboxv5-init');
                wp_enqueue_style('mapbox-css-geocoder');
                wp_enqueue_style('mapbox-css');
                wp_enqueue_style('bt-gmapv3');
            }
            BTOTGmap::instance()->curent_key=$args['field_name'];
            echo BTOTGmap::instance()->load_view(false,array('args'=>$args));
        }
    }
}

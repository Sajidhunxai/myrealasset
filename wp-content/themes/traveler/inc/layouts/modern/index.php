<?php

if (!class_exists('ST_Traveler_Modern_Layout')) {

    class ST_Traveler_Modern_Layout {

        static $_inst;
        protected $dir;

        function __construct() {
            $new_layout = STFramework::firstGetOption('st_theme_style', 'modern');
            $new_layout = st()->get_option('st_theme_style' , "modern");
            if($new_layout == 'modern'){
                $this->dir = dirname(__FILE__);
                add_action('init', array($this, 'loadShortcodes'));
                $this->loadVcMap();
                $this->loadConfigs();
                $this->loadHelperV2();
                $this->loadWidgetV2();
                $this->loadClassSingleHotel();
                if (class_exists('Elementor\Plugin')) {
                    $this->loadElementor();
                }
            }
        }

        function loadElementor(){
            $file =  ST_TRAVELER_DIR . '/inc/layouts/elementor/elementor.php';
            $file_singlehotel =  ST_TRAVELER_DIR . '/inc/layouts/modern/class/class.single_hotel.php';
            if (file_exists($file)){
                include_once $file;
                include_once $file_singlehotel;
            }
        }

        function loadClassSingleHotel() {
            $files = [
                '/admin/class.admin.single_hotel.php',
                '/class/class.single_hotel.php',
            ];

            foreach ($files as $k => $v) {
                $file = $this->dir . $v;
                if (file_exists($file))
                    include_once $file;
            }
        }

        function loadWidgetV2() {
            $helpers = glob($this->dir . '/widget/*');

            if (!is_array($helpers) or empty($helpers))
                return false;

            if (!empty($helpers)) {
                foreach ($helpers as $key => $value) {
                    $dirname = basename($value, '.php');
                    $file = $this->dir . '/widget/' . $dirname . '.php';
                    if (file_exists($file))
                        include_once $file;
                }
            }

            return true;
        }

        function loadHelperV2() {
            $helpers = glob($this->dir . '/helpers-v2/*');

            if (!is_array($helpers) or empty($helpers))
                return false;

            if (!empty($helpers)) {
                foreach ($helpers as $key => $value) {
                    $dirname = basename($value, '.php');
                    $file = $this->dir . '/helpers-v2/' . $dirname . '.php';
                    if (file_exists($file))
                        include_once $file;
                }
            }

            return true;
        }

        function loadConfigs() {
            $files = [
                '/configs/hotel.php',
                '/configs/tour.php',
                '/configs/post.php',
                '/configs/activity.php',
                '/configs/rental.php',
                '/configs/car.php',
            ];

            foreach ($files as $k => $v) {
                $file = $this->dir . $v;
                if (file_exists($file))
                    include_once $file;
            }
        }

        function loadVcMap() {
            $file = $this->dir . '/vc-elements/vc_map.php';
            if (file_exists($file))
                include_once $file;
        }

        function loadShortcodes() {
            if(function_exists('check_using_elementor') && check_using_elementor()){
                
            } else {
                if (function_exists('st_reg_shortcode') && is_plugin_active('js_composer/js_composer.php')) {
                    $file = $this->dir . '/vc-elements/shortcodes.php';
                    if (file_exists($file))
                        include_once $file;
                }
            }
            
        }

        static function inst() {
            if (!self::$_inst)
                self::$_inst = new self();

            return self::$_inst;
        }

    }

    ST_Traveler_Modern_Layout::inst();
}
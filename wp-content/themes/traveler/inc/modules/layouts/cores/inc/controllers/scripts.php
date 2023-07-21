<?php
if (!class_exists('STT_Layout_Core_Scripts')) {
    class STT_Layout_Core_Scripts
    {
        private static $_inst;
        private $_coreUri;

        public function __construct()
        {
            $this->_coreUri = STT_Module_Layout::inst()->layoutURI . 'cores/';
            add_action('wp_enqueue_scripts', [$this, '_enqueueScripts']);
        }

        public function _enqueueScripts()
        {
            if (!is_page_template('template-user.php')) {
                if(check_using_elementor()){
                    $menu_style = st()->get_option('menu_style_modern', 1);
                    wp_enqueue_style('layout-font-icon', $this->_coreUri . 'assets/css/traveler-icon.css');
                    if($menu_style == 9) {
                        wp_enqueue_style('layout-google-font', 'https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap');
                        
                        wp_enqueue_style('layout-main', $this->_coreUri . 'assets/css/main.css');
                    }
                    
                }
            }
        }

        public static function inst()
        {
            if (empty(self::$_inst)) {
                self::$_inst = new self();
            }
            return self::$_inst;
        }
    }
    STT_Layout_Core_Scripts::inst();
}



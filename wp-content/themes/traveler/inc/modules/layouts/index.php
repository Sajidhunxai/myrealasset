<?php
if (!class_exists('STT_Module_Layout')) {
    class STT_Module_Layout
    {
        private static $_inst;
        public $layoutPath;
        public $layoutURI;
        public $layoutName;

        public function __construct()
        {
            $this->layoutPath = ST_TRAVELER_DIR . '/inc/modules/layouts/';
            $this->layoutURI = ST_TRAVELER_URI . '/inc/modules/layouts/';
            $this->_loadLayouts();
        }

        private function _loadLayouts()
        {
            $folders = glob($this->layoutPath . '*');

            if (!is_array($folders) or empty($folders))
                return;

            if (!empty($folders)) {
                foreach ($folders as $key => $value) {
                    if(is_dir($value)) {
                        if (file_exists($value . '/index.php')) {
                            require_once $value . '/index.php';
                        }
                        $folders = ['helpers', 'controllers', 'models'];
                        foreach ($folders as $folder) {
                            $files = glob($value . '/inc/' . $folder . '/*');
                            if (!empty($files)) {
                                foreach ($files as $file) {
                                    if (file_exists($file)) {
                                        require_once $file;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        public function loadView($name, $data = array())
        {
            $template = locate_template('inc/modules/layouts/' . $this->layoutName . '/inc/views/' . $name . '.php');

            if (is_file($template)) {
                if (is_array($data)) {
                    extract($data);
                }

                ob_start();
                include $template;
                $return = @ob_get_clean();

                return $return;
            }

            return false;
        }

        public static function inst()
        {
            if (empty(self::$_inst)) {
                self::$_inst = new self();
            }
            return self::$_inst;
        }
    }
    STT_Module_Layout::inst();
}
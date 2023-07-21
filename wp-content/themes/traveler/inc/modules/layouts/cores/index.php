<?php
if (!class_exists('STT_Layout_Core')) {
    class STT_Layout_Core
    {
        private static $_inst;

        public function __construct()
        {
            $this->_init();
        }

        private function _init()
        {
            $folders = ['helpers', 'controllers', 'models'];
            foreach ($folders as $folder) {
                $files = glob(STT_Module_Layout::inst()->layoutPath . '/cores/inc/' . $folder . '/*');
                if (!empty($files)) {
                    foreach ($files as $file) {
                        if (file_exists($file)) {
                            require_once $file;
                        }
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
    STT_Layout_Core::inst();
}



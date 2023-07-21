<?php
if (!class_exists('STT_ElementorV2')) {
    class STT_ElementorV2 extends STT_Module_Layout
    {
        private static $_inst;

        public function __construct()
        {
            parent::__construct();
            $this->layoutName = 'elementorv2';
        }

        public static function inst()
        {
            if (empty(self::$_inst)) {
                self::$_inst = new self();
            }
            return self::$_inst;
        }
    }
}

if (!function_exists('stt_elementorv2')) {
    function stt_elementorv2()
    {
        return STT_ElementorV2::inst();
    }
}

stt_elementorv2();




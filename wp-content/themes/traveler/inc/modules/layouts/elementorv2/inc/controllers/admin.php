<?php
if (!class_exists('STT_Hotelv2_Admin')) {
    class STT_Hotelv2_Admin
    {
        private static $_inst;

        public function __construct()
        {
            add_filter('st_list_menu_style', [$this, '_addNewHeaderSelection']);
            add_filter('st_settings_page_options', [$this, '_changePageOptions']);
        }

        public function _changePageOptions($options) {
            if (check_using_elementor()) {
                array_splice( $options, 8, 0, [
                    [
                        'id' => 'page_checkout_style',
                        'label' => __('Select Checkout Page Style', 'traveler'),
                        'desc' => __('Select styles of checkout page (it is default as style 1)', 'traveler'),
                        'type' => 'radio-image',
                        'section' => 'option_page',
                        'std' => '1',
                        'choices' => apply_filters('st_checkout_page_style', [
                            [
                                'id' => '1',
                                'alt' => __('Style 1', 'traveler'),
                                'src' => get_template_directory_uri() . '/img/checkout/style-1.png',
                            ],
                            [
                                'id' => '2',
                                'alt' => __('Style 2', 'traveler'),
                                'src' => get_template_directory_uri() . '/img/checkout/style-2.png',
                            ]
                        ]),
                    ]
                ]);
            }
            return $options;
        }

        public function _addNewHeaderSelection($lists)
        {
            if (check_using_elementor()) {
                $lists[] = [
                    'id' => '9',
                    'alt' => esc_html__('White Header', 'traveler'),
                    'src' => get_template_directory_uri() . '/img/nav10.png'
                ];
            }
            return $lists;
        }

        public static function inst()
        {
            if (empty(self::$_inst)) {
                self::$_inst = new self();
            }
            return self::$_inst;
        }
    }

    STT_Hotelv2_Admin::inst();
}

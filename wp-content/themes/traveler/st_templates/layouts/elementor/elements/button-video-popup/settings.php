<?php

use Elementor\Controls_Manager;
use Elementor\Embed;
use Elementor\Modules\DynamicTags\Module as TagsModule;

if (!class_exists('ST_Button_Video_Popup_Element')) {
    class ST_Button_Video_Popup_Element extends \Elementor\Widget_Base
    {
        
        public function get_name()
        {
            return 'st_button_video_popup';
        }
        
        public function get_title()
        {
            return esc_html__('Button Popup Video', 'traveler');
        }
        
        public function get_icon()
        {
            return 'traveler-elementor-icon';
        }

        public function get_categories()
        {
            return ['st_elements'];
        }
        
        protected function register_controls()
        {
            $layout_style = apply_filters('st_layout_button_style', [
                'default'  => esc_html__( 'Default', 'traveler' ),
            ]);

            $this->start_controls_section(
                'setting_section',
                [
                    'label' => esc_html__('Settings', 'traveler'),
                    'tab' => Controls_Manager::TAB_CONTENT
                ]
            );
            $this->add_control(
                'layout_style',
                [
                    'label' => esc_html__('Style', 'traveler'),
                    'type' => 'select',
                    'label_block' => true,
                    'options' => $layout_style,
                    'default' => 'default',
                ]
            );
            $this->add_control(
                'video_type',
                [
                    'label' => esc_html__('Source', 'traveler'),
                    'type' => Controls_Manager::SELECT,
                    'default' => 'youtube',
                    'options' => [
                        'youtube' => esc_html__('YouTube', 'traveler'),
                        'vimeo' => esc_html__('Vimeo', 'traveler'),
                        'dailymotion' => esc_html__('Dailymotion', 'traveler')
                    ],
                    'frontend_available' => true,
                ]
            );
            
            $this->add_control(
                'youtube_url',
                [
                    'label' => esc_html__('Link', 'traveler'),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                        'categories' => [
                            TagsModule::POST_META_CATEGORY,
                            TagsModule::URL_CATEGORY,
                        ],
                    ],
                    'placeholder' => esc_html__('Enter your URL (YouTube)', 'traveler'),
                    'default' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
                    'label_block' => true,
                    'condition' => [
                        'video_type' => 'youtube',
                    ],
                    'frontend_available' => true,
                ]
            );
            
            $this->add_control(
                'vimeo_url',
                [
                    'label' => esc_html__('Link', 'traveler'),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                        'categories' => [
                            TagsModule::POST_META_CATEGORY,
                            TagsModule::URL_CATEGORY,
                        ],
                    ],
                    'placeholder' => esc_html__('Enter your URL (Vimeo)', 'traveler'),
                    'default' => 'https://vimeo.com/235215203',
                    'label_block' => true,
                    'condition' => [
                        'video_type' => 'vimeo',
                    ],
                ]
            );
            
            $this->add_control(
                'dailymotion_url',
                [
                    'label' => esc_html__('Link', 'traveler'),
                    'type' => Controls_Manager::TEXT,
                    'dynamic' => [
                        'active' => true,
                        'categories' => [
                            TagsModule::POST_META_CATEGORY,
                            TagsModule::URL_CATEGORY,
                        ],
                    ],
                    'placeholder' => esc_html__('Enter your URL (Dailymotion)', 'traveler'),
                    'default' => 'https://www.dailymotion.com/video/x6tqhqb',
                    'label_block' => true,
                    'condition' => [
                        'video_type' => 'dailymotion',
                    ],
                ]
            );
            
            $this->add_control(
                'start',
                [
                    'label' => esc_html__('Start Time', 'traveler'),
                    'type' => Controls_Manager::NUMBER,
                    'description' => esc_html__('Specify a start time (in seconds)', 'traveler'),
                    'frontend_available' => true,
                ]
            );
            
            $this->add_control(
                'end',
                [
                    'label' => esc_html__('End Time', 'traveler'),
                    'type' => Controls_Manager::NUMBER,
                    'description' => esc_html__('Specify an end time (in seconds)', 'traveler'),
                    'condition' => [
                        'video_type' => ['youtube', 'hosted'],
                    ],
                    'frontend_available' => true,
                ]
            );
            
            $this->add_control(
                'yt_privacy',
                [
                    'label' => esc_html__('Privacy Mode', 'traveler'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        1 => esc_html__('On', 'traveler'),
                        0 => esc_html__('Off', 'traveler')
                    ],
                    'default' => 1,
                    'description' => esc_html__('When you turn on privacy mode, YouTube won\'t store information about visitors on your website unless they play the video.', 'traveler'),
                    'condition' => [
                        'video_type' => 'youtube',
                    ],
                    'frontend_available' => true,
                ]
            );
            
            $this->add_control(
                'mute',
                [
                    'label' => esc_html__('Mute', 'traveler'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        1 => esc_html__('On', 'traveler'),
                        0 => esc_html__('Off', 'traveler')
                    ],
                    'default' => 1,
                    'frontend_available' => true,
                ]
            );
            
            $this->add_control(
                'loop',
                [
                    'label' => esc_html__('Loop', 'traveler'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        1 => esc_html__('On', 'traveler'),
                        0 => esc_html__('Off', 'traveler')
                    ],
                    'default' => 0,
                    'condition' => [
                        'video_type!' => 'dailymotion',
                    ],
                    'frontend_available' => true,
                ]
            );
            
            
            $this->end_controls_section();
        }
        
        protected function render()
        {
            $settings = $this->get_settings_for_display();
            
            $video_url = $settings[$settings['video_type'] . '_url'];
            $embed_params = $this->get_embed_params();
            $embed_options = $this->get_embed_options();
            $lightbox_url = \Elementor\Embed::get_embed_url($video_url, $embed_params, $embed_options);
            
            $lightbox_options = [
                'type' => 'video',
                'videoType' => $settings['video_type'],
                'url' => $lightbox_url,
                'modalOptions' => [
                    'id' => 'elementor-lightbox-' . $this->get_id(),
                    'videoAspectRatio' => '169',
                ],
            ];
            $this->add_render_attribute('image-overlay', 'class', 'elementor-custom-embed-image-overlay');
            $this->add_render_attribute('image-overlay', [
                'data-elementor-open-lightbox' => 'yes',
                'data-elementor-lightbox' => wp_json_encode($lightbox_options),
                
            ]);
            
            $settings = array_merge($settings, array('_element' => $this, 'lightbox_url' => $lightbox_url));
            echo apply_filters('stt_elementor_button_view', ST_Elementor::view('button-video-popup.template', $settings, true), $settings);
        }
        
        public function get_embed_params()
        {
            
            $settings = $this->get_settings_for_display();
            
            $params = [];
            
            $params_dictionary = [];
            
            if ('youtube' === $settings['video_type']) {
                $params_dictionary = [
                    'loop',
                    'mute',
                ];
                
                if ($settings['loop']) {
                    $video_properties = Embed::get_video_properties($settings['youtube_url']);
                    
                    $params['playlist'] = $video_properties['video_id'];
                }
                
                $params['start'] = $settings['start'];
                
                $params['end'] = $settings['end'];
                
                $params['wmode'] = 'opaque';
            } elseif ('vimeo' === $settings['video_type']) {
                $params_dictionary = [
                    'loop',
                    'mute' => 'muted',
                ];
                $params['autopause'] = '0';
            } elseif ('dailymotion' === $settings['video_type']) {
                $params_dictionary = [
                    'mute',
                ];
                
                $params['start'] = $settings['start'];
                
                $params['endscreen-enable'] = '0';
            }
            
            foreach ($params_dictionary as $key => $param_name) {
                $setting_name = $param_name;
                
                if (is_string($key)) {
                    $setting_name = $key;
                }
                
                $setting_value = $settings[$setting_name] ? '1' : '0';
                
                $params[$param_name] = $setting_value;
            }
            
            return $params;
        }
        
        private function get_embed_options()
        {
            $settings = $this->get_settings_for_display();
            
            $embed_options = [];
            
            if ('youtube' === $settings['video_type']) {
                $embed_options['privacy'] = $settings['yt_privacy'];
            } elseif ('vimeo' === $settings['video_type']) {
                $embed_options['start'] = $settings['start'];
            }
            
            $embed_options['lazy_load'] = 1;
            
            return $embed_options;
        }
    }
}

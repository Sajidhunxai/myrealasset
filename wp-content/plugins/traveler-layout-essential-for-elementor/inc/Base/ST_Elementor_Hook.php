<?php
namespace Inc\Base;

use Inc\Base\ST_Elementor_Widget;

if (!class_exists('ST_Elementor_Hook')) {
    class ST_Elementor_Hook
    {
        public $stElementorWidget;
        public function __construct()
        {
            $this->stElementorWidget = new ST_Elementor_Widget;
            add_filter('st_style_testimonial', [$this, '_addSettingStyleTestimonial'], 10, 2);
            add_filter('st_style_slider', [$this, '_addSettingStyleSlider'], 10, 2);
            add_filter('stt_elementor_slider_view', [$this, '_addSliderView'], 10, 2);
            add_filter('stt_st_sliders', [$this, '_addSettingStSliders'], 10, 2);
            add_filter('slides_per_view', [$this, '_addSettingPerViewTestimonial'], 10, 2);
            add_filter('settings_slider_condition', [$this, '_addSettingSliderCondition'], 10, 2);
            add_filter('stt_elementor_testimonial_view', [$this, '_addElementorTestimonial'], 10, 2);
            add_filter('st_layout_blog_style', [$this, '_addSettingStyleBlogList'], 10, 2);
            add_filter('st_settings_blog_slider_condition', [$this, '_addSettingBlogSliderCondition'], 10, 2);
            add_filter('st_settings_blog_slider_loop_condition', [$this, '_addSettingBlogSliderLoopCondition'], 10, 2);
            add_filter('stt_elementor_blog_list_view', [$this, '_addElementorBlogList'], 10, 2);
            add_action('wp_ajax_traveler_newsletter', [$this, '_travelerNewsletter']);
            add_action('wp_ajax_nopriv_traveler_newsletter', [$this, '_travelerNewsletter']);
            add_filter('st_layout_faq_style', [$this, '_addSettingStyleFaq'], 10, 2);
            add_filter('stt_elementor_faq_view', [$this, '_addElementorFaq'], 10, 2);
            add_filter('st_layout_button_style', [$this, '_addSettingStyleButton'], 10, 2);
        }
      
        public function _addSettingStyleTestimonial($lists)
        {
            $lists_style = [
                'style-lib-1' => esc_html__('Style Lib 1', 'traveler-layout-essential'),
                'style-lib-2' => esc_html__('Style Lib 2', 'traveler-layout-essential'),
                'style-lib-slider-1' => esc_html__('Style Lib Slider 1', 'traveler-layout-essential'),
                'style-lib-slider-2' => esc_html__('Style Lib Slider 2', 'traveler-layout-essential'),
                'style-lib-slider-3' => esc_html__('Style Lib Slider 3', 'traveler-layout-essential'),
                'style-lib-slider-4' => esc_html__('Style Lib Slider 4', 'traveler-layout-essential'),
                'style-lib-slider-5' => esc_html__('Style Lib Slider 5', 'traveler-layout-essential'),
                'style-lib-slider-6' => esc_html__('Style Lib Slider 6', 'traveler-layout-essential'),
                'style-lib-slider-7' => esc_html__('Style Lib Slider 7', 'traveler-layout-essential'),
            ];
            $array_lists = array_merge($lists, $lists_style);
            return $array_lists;
        }

        public function _addSettingStyleSlider($lists)
        {
            $lists_style = [
                'style-4'  => esc_html__('Style 4', 'traveler-layout-essential'),
                'style-5'  => esc_html__('Style 5', 'traveler-layout-essential'),
                'style-6'  => esc_html__('Style 6', 'traveler-layout-essential'),
                'style-nav-top'  => esc_html__('Style Nav Top', 'traveler-layout-essential'),
                
            ];
            $array_lists = array_merge($lists, $lists_style);
            
            return $array_lists;
        }
        public function _addSliderView($component, $settings)
        {
            $layout = $settings["style_slider"];
            if ($layout == "style-6" || $layout == "style-nav-top") {
                return $this->stElementorWidget->loadTemplate('sliders/template-'.$layout, $settings);
            }
            return $component;
        }
        public function _addSettingStSliders($lists)
        {
            $lists_style = [
                'style_slider' => ['style-1','style-2','style-4','style-5']
            ];
            $array_lists = array_merge($lists, $lists_style);
            return $array_lists;
        }

        public function _addSettingPerViewTestimonial($lists)
        {
            $lists = [
                '1'  => esc_html__('1 items', 'traveler-layout-essential'),
                '2'  => esc_html__('2 items', 'traveler-layout-essential'),
                '3'  => esc_html__('3 items', 'traveler-layout-essential'),
                '4'  => esc_html__('4 items', 'traveler-layout-essential'),
            ];
            return $lists;
        }

        public function _addSettingSliderCondition($lists)
        {
            $lists = [
                'st_style_testimonial' => [
                    'slider',
                    'slider-2',
                    'slider-3',
                    'style-lib-slider-1',
                    'style-lib-slider-2',
                    'style-lib-slider-3',
                    'style-lib-slider-4',
                    'style-lib-slider-5',
                    'style-lib-slider-6',
                    'style-lib-slider-7',
                ],
            ];
            return $lists;
        }

        public function _addElementorTestimonial($component, $settings)
        {
            $layout = $settings["st_style_testimonial"];
            if ($layout !== "normal" && $layout !== "slider" && $layout !== "slider-2" && $layout !=="slider-3") {
                return $this->stElementorWidget->loadTemplate('testimonial/template-'.$layout, $settings);
            }
         
            return $component;
        }
        
        public function _addSettingStyleBlogList($lists)
        {
            $lists_style = [
                'grid-style2' => esc_html__('Grid Style 2', 'traveler-layout-essential'),
                'style-lib-slider-1' => esc_html__('Style Lib Slider 1', 'traveler-layout-essential'),
                'style-lib-slider-2' => esc_html__('Style Lib Slider 2', 'traveler-layout-essential'),
                'style-lib-slider-3' => esc_html__('Style Lib Slider 3', 'traveler-layout-essential'),
                'style-lib-slider-4' => esc_html__('Style Lib Slider 4', 'traveler-layout-essential'),
                'style-lib-slider-5' => esc_html__('Style Lib Slider 5', 'traveler-layout-essential'),
                'style-lib-slider-6' => esc_html__('Style Lib Slider 6', 'traveler-layout-essential'),
                'style-lib-slider-7' => esc_html__('Style Lib Slider 7', 'traveler-layout-essential'),
                'style-lib-slider-8' => esc_html__('Style Lib Slider 8', 'traveler-layout-essential'),
                'style-lib-slider-9' => esc_html__('Style Lib Slider 9', 'traveler-layout-essential'),
            ];
            $array_lists = array_merge($lists, $lists_style);
            
            return $array_lists;
        }

        public function _addSettingBlogSliderLoopCondition(array $list)
        {
            return ['style-lib-slider-9'];
        }
        public function _addSettingBlogSliderCondition($lists)
        {
            $lists = [
                'layout_style' => [
                    'slider',
                    'style-lib-slider-1',
                    'style-lib-slider-2',
                    'style-lib-slider-3',
                    'style-lib-slider-4',
                    'style-lib-slider-5',
                    'style-lib-slider-6',
                    'style-lib-slider-7',
                    'style-lib-slider-8',
                    'style-lib-slider-9',

                ],
            ];
            
            
            return $lists;
        }
        public function _addElementorBlogList($component, $settings)
        {
            $layout = $settings["layout_style"];
            if ($layout !== "grid" && $layout !== "slider") {
                return $this->stElementorWidget->loadTemplate('blog-list/template-'.$layout, $settings);
            }
         
            return $component;
        }

        public function _addSettingStyleFaq($lists)
        {
            $lists_style = [
                'style1' => esc_html__('Style 1', 'traveler-layout-essential'),
                'style2' => esc_html__('Style 2', 'traveler-layout-essential'),
                'style3' => esc_html__('Style 3', 'traveler-layout-essential'),
                'style4' => esc_html__('Style 4', 'traveler-layout-essential'),
                'style5' => esc_html__('Style 5', 'traveler-layout-essential'),
                'style6' => esc_html__('Style 6', 'traveler-layout-essential'),
                'style7' => esc_html__('Style 7', 'traveler-layout-essential'),
                'style8' => esc_html__('Style 8', 'traveler-layout-essential'),
            ];
            $array_lists = array_merge($lists, $lists_style);
            
            return $array_lists;
        }

        public function _addElementorFaq($component, $settings)
        {
         
            $layout = $settings["layout_style"];
          
            if ($layout !== "default") {
                return $this->stElementorWidget->loadTemplate('faq/template', $settings);
            }
         
            return $component;
        }
        
        public function _addSettingStyleButton($lists)
        {
            $lists_style = [
                'style1' => esc_html__('Style 1', 'traveler-layout-essential'),
                'style2' => esc_html__('Style 2', 'traveler-layout-essential'),

            ];
            $array_lists = array_merge($lists, $lists_style);
            
            return $array_lists;
        }


        public function _travelerNewsletter()
        {
            $email = (isset($_POST['email']))?esc_attr($_POST['email']) : '';
            $api_key = (isset($_POST['api_key']))?esc_attr($_POST['api_key']) : '';
            $id_list_mailchimp = (isset($_POST['id_list_mailchimp']))?esc_attr($_POST['id_list_mailchimp']) : '';
            $status_email = (isset($_POST['status_email']))?esc_attr($_POST['status_email']) : '';
            if (empty($api_key)) {
                return [
                    'status' => 0,
                    'message' => esc_html__('Email server configuration incorrect', 'traveler-layout-essential')
                ];
            }
            if (empty($email)) {
                return [
                    'status' => 0,
                    'message' => esc_html__('Email Address is incorrect', 'traveler-layout-essential')
                ];
            }
            $data = array(
                'apikey' => $api_key,
                'email_address' => $email,
                'status' =>  $status_email,
            );
            $endpoint = 'https://' . substr($api_key, strpos($api_key, '-') + 1) . '.api.mailchimp.com/3.0/lists/'.$id_list_mailchimp.'/members/' . md5(strtolower($email));
        
            $response = wp_remote_post($endpoint, array(
                    'method' => 'PUT',
                    'timeout' => 60,
                    'customrequest' => 'PUT',
                    'httpversion' => '1.0',
                    'blocking' => true,
                    'sslverify' => false,
                    'headers' => array(
                        'Content-Type' => ' application/json',
                        'Authorization' => ' Basic ' . base64_encode('user:'.$api_key)),
                    'body' => wp_json_encode($data),
                    'cookies' => array()
                ));
            if (isset($response['errors']) && $response['status'] === 400) {
                $message = '';
                foreach ($response['errors'] as $key => $error_item) {
                    $field = $error_item['field'];
                    $mes = $error_item['message'];
                    $message .= $field . ':' . $mes . '</br>';
                }
                return [
                    'status' => 0,
                    'message' => $message,
                ];
            } else {
                if ($response['response']['code'] !== 200) {
                    return [
                        'status' => 0,
                        'message' => $response['response']['message'],
                    ];
                } else {
                    $message = ($status_email == 'subscribed') ? esc_html__('You have been successfully subscribed', 'traveler-layout-essential') : esc_html__('Your request will be confirmed by the administrator', 'traveler-layout-essential');
                    return [
                        'status' => 1,
                        'message' => $message,
                    ];
                }
            }
            die();
        }
    }


}

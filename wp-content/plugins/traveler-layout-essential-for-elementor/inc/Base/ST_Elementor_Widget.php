<?php
namespace Inc\Base;

class ST_Elementor_Widget
{
    public function __construct()
    {
        add_action('elementor/widgets/register', [$this, '_register_element']);
        add_action('elementor/elements/categories_registered', [$this, '_register_elementor_categories']);
    }

    public function _register_elementor_categories($elements_manager)
    {
        $categories = [
            'st_agency_elements' => [
                'icon' => 'fa fa-plug',
                'title' => esc_html__('Traveler Agency Hotel Elements', 'traveler-layout-essential')
            ],
        ];
        if (is_array($categories)) {
            foreach ($categories as $key => $category) {
                $elements_manager->add_category($key, $category);
            }
        }
        

        return $elements_manager;
    }

    public function _register_element($manager, $folder = '')
    {
        $list_element = [
            'team',
            'testimonial',
            'subscribe-form',
            'counter',
            'icon-box',
            'form-search-agency',
            'list-service-room',
            'list-service-rental',
            'stt-gallery',
            'slider-room',
            'sliders',
            'map',
        ];
        $elements = apply_filters('st-list-element-widget', $list_element);
      
        foreach ($elements as $element_folder_name) {
            $folder_path = ST_ESSENTIAL_PLUGIN_PATH . 'inc/widget/elements/' . $element_folder_name;
           
            if (is_dir($folder_path)) {
                $settings_file = $folder_path . '/settings.php';
                $custom_file = trailingslashit(get_template_directory()) . 'inc/widget/elements/' . $element_folder_name . '/settings.php';
                if (is_file($settings_file)) {
                    if (is_file($custom_file)) {
                        require($custom_file);
                    } else {
                        require($settings_file);
                    }

                    $name = 'ST_' . ucwords(str_replace('-', '_', $element_folder_name), '_') . '_Element';
                  
                    if (class_exists($name)) {
                        \Elementor\Plugin::instance()->widgets_manager->register(new $name());
                    }
                }
            }
        }
    }

    public function loadTemplate($name, $data = null)
    {
        if (is_array($data)) {
            extract($data);
        }
        $template = ST_ESSENTIAL_PLUGIN_PATH . 'inc/widget/elements/' . $name . '.php';
        if (is_file($template)) {
            $templateCustom = locate_template(ST_ESSENTIAL_PLUGIN_PATH . 'inc/widget/elements/' . $name . '.php');
            if (is_file($templateCustom)) {
                $template = $templateCustom;
            }
            ob_start();
            require($template);
            $html = ob_get_clean();
            return $html;
        }
    }
}

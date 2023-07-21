<?php
/**
 *
 */
namespace Inc\Base;

/**
*
*/

class ST_Enqueue
{
    
    public function register()
    {
        add_action('elementor/editor/before_enqueue_styles', array($this, 'before_enqueue_styles'));
        add_action('elementor/editor/before_enqueue_scripts', array($this, 'before_enqueue_scripts'));
        add_action('elementor/preview/enqueue_styles', array($this, 'enqueue_preview_styles'));
        add_action('wp_enqueue_scripts', array( $this, 'enqueue' ), 999);
    }
    
    function enqueue()
    {
        // enqueue all our scripts
        $rtl = st()->get_option('right_to_left', '');
        wp_enqueue_style('elementor-widget-style', ST_ESSENTIAL_PLUGIN_URL. 'assets/css/main.css');
        wp_enqueue_style('magnific-css', get_template_directory_uri() . '/v2/css/magnific-popup.css');
        wp_enqueue_script('st-library-slider', ST_ESSENTIAL_PLUGIN_URL . 'assets/js/st-library-slider.js', array(), '', true);
        wp_enqueue_script('st-custom', ST_ESSENTIAL_PLUGIN_URL . 'assets/js/st-custom.js', array(), '', true);
        wp_enqueue_script('magnific-js', get_template_directory_uri() . '/v2/js/magnific-popup/jquery.magnific-popup.min.js');
        if (is_rtl() || $rtl=='on') {
            wp_enqueue_style('elementor-rtl-style', ST_ESSENTIAL_PLUGIN_URL. 'assets/css/rtl.css');
        }
        $translation_array = array(
            'ajax_url' => admin_url('admin-ajax.php')
        );
        wp_localize_script('main', 'cpm_object', $translation_array);
    }
    function before_enqueue_scripts()
    {
        wp_enqueue_script('st-library-mypluginscript', ST_ESSENTIAL_PLUGIN_URL . 'assets/js/st-library-myscript.js', '', '', true);
    }
    function before_enqueue_styles()
    {
        wp_enqueue_style('st-library-template-style', ST_ESSENTIAL_PLUGIN_URL. 'assets/css/st-library-template-style.css');
    }
    function enqueue_preview_styles()
    {
        wp_enqueue_style('st-library-style-preview', ST_ESSENTIAL_PLUGIN_URL. 'assets/css/st-library-style-preview.css');
        
    }
}

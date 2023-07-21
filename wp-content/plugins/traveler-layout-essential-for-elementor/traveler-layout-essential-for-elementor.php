<?php
/**
 * @package Traveler layout essential for elementor
 */
/*
Plugin Name: Traveler layout essential for elementor
Plugin URI: https://www.facebook.com/shinethemetoday
Description: Plugin only for Traveler theme
Version: 1.0.3
Author: ShineTheme
Author URI: https://www.facebook.com/shinethemetoday
License: GPLv2 or later
Text Domain: traveler-layout-essential
*/


defined('ABSPATH') or die('Hey, what are you doing here? You silly human!');

if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    include_once dirname(__FILE__) . '/vendor/autoload.php';
}
define('ST_ESSENTIA_PLUGIN_VERSION', '1.0.2');
define('ST_ESSENTIAL_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('ST_ESSENTIAL_PLUGIN_URL', plugin_dir_url(__FILE__));

if (class_exists('Inc\\STEssentialInit')) {
    Inc\STEssentialInit::registerServices();
}
//Function is called in theme Traveler
if (!function_exists('ste_loadTemplate')) {
    function ste_loadTemplate($name, $data = null)
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
            include $template;
            $html = ob_get_clean();
            return $html;
        }
    }
}

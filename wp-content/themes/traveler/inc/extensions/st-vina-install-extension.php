<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
final class STExtensions
{
    protected static $_instance = null;
    public static function instance()
	{
		if (is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
    }
    public function __construct()
	{
		$this->define_constants();
		$this->includes_and_requires();
		$this->init_hooks();
    }
    private function define_constants()
	{
		define('ST_EXTENSIONS_FILE', __FILE__);
		define('ST_ADMIN_PATH', ABSPATH . 'wp-admin/');
		define('ST_EXTENSIONS_PATH', dirname(__FILE__) . 'process/extensions/');
	}
    private function init_hooks()
	{
		register_activation_hook(ST_EXTENSIONS_FILE, array('STInstall', 'st_install'));

    }
    private function includes_and_requires()
	{
        // Support library		
		require_once(ABSPATH . WPINC . '/pluggable.php');
		require_once(ST_ADMIN_PATH . 'includes/image.php');
        require_once(ST_ADMIN_PATH . 'includes/plugin.php');
        $page_extendsion = isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
        $action_extendsion = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
        $action_extendsion = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
		$action_type = isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
		require_once(ST_TRAVELER_DIR . '/inc/extensions/process/class.reg.extension.php');
        if (is_admin() && (($page_extendsion === 'st-vina-extensions') || ($action_extendsion === 'st_install_plugin') || ($action_type === 'extendsion') || ($action_type === 'addon') )) {
			require_once(ST_TRAVELER_DIR . '/inc/extensions/process/class-init-extension.php');
			//require_once( __DIR__ . '/process/class-table-extensions.php');  
			//require_once (get_template_directory(). 'inc/extensions/process/class-table-extensions.php');
		}
    }
}
function st_vina_run_main_class()
{
	return STExtensions::instance();
}

st_vina_run_main_class();
function st_vina_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	if ( ! empty( $args ) && is_array( $args ) ) {
		extract( $args );
	}
	$located = st_vina_locate_template( $template_name, $template_path, $default_path );	
	include_once($located);
}
function st_vina_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name,
		)
	);
	if ( ! $template ) {
		$template = $default_path . $template_name;
	}
	return  $template;
}
// function st_vina_display_extensions(){
// 	do_action('st_vina_display_extensions');
// }

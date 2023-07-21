<?php
/**
 *
 */
namespace Inc\API;

use \Callbacks\AdminCallbacks;
use Elementor\Plugin as ElementorPlugin;
use Elementor\TemplateLibrary\Source_Local;

class SettingsApi
{
    public $admin_pages = array();

    public $admin_subpages = array();

    public function register()
    {
        if (! empty($this->admin_pages) || ! empty($this->admin_subpages)) {
            add_action('admin_menu', array( $this, 'addAdminMenu' ));
        }
        add_action('wp_ajax_get_item_template', [$this, '_getItemTemplate']);
        add_action('wp_ajax_nopriv_get_item_template', [$this, '_getItemTemplate']);
        add_action('wp_ajax_get_item_type', [$this, '_getItemType']);
        add_action('wp_ajax_nopriv_get_item_type', [$this, '_getItemType']);
        add_action('wp_ajax_import_template', [$this, '_importTemplate']);
        add_action('wp_ajax_nopriv_import_template', [$this, '_importTemplate']);
        add_action('wp_ajax_preview_template', [$this, '_previewTemplate']);
        add_action('wp_ajax_nopriv_preview_template', [$this, '_previewTemplate']);
    }
    
    public function _getItemTemplate()
    {
        $type = 'page';
        $admincallback = new Callbacks\AdminCallbacks;
        $data_items = $admincallback->get_item_template_api($type);
        ob_start(); ?>
        <div class="traveler-essential-modal-traveler-essential">
            <div class="traveler-essential-modal-header">
                <div class="traveler-essential-logo"><img src="<?php echo ST_ESSENTIAL_PLUGIN_URL.'/assets/images/logo.svg';?>"></div>
                <div class="traveler-essential-modal-menu">
                    <ul class="travler_nav">
                        <li class="traveler-essential-active"><a href="#pages" data-type="page"><?php echo __("Pages", "traveler-layout-essential") ?></a></li>
                        <li class=""><a href="#section" data-type="section"><?php echo __("Section", "traveler-layout-essential") ?></a></li>
                        <li class=""><a href="#blocks" data-type="container"><?php echo __("Blocks", "traveler-layout-essential") ?></a></li>
                    </ul>
                </div>
                <div class="traveler-essential-modal-action-button">
                    <button class="traveler-essential-button traveler-essential-close">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 352 512" color="#a4b0c1" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg" style="color: rgb(164, 176, 193);">
                            <path d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z">  
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="traveler-essential-modal-body traveler-essential-elementor-platform ">
                <?php include(ST_ESSENTIAL_PLUGIN_PATH . 'templates/template-item.php'); ?>   
            </div>
        </div>
        <?php
        $result = ob_get_clean();
        wp_send_json_success($result);
        die();
    }
    public function _getItemType()
    {
        $type = (isset($_POST['value'])) ? ($_POST['value']) : '';
        $admincallback = new Callbacks\AdminCallbacks;
        $data_items = $admincallback->get_item_template_api($type);
        ob_start(); ?>
            
        <?php include(ST_ESSENTIAL_PLUGIN_PATH . 'templates/template-item.php'); ?>
        <?php
        $result = ob_get_clean();
        wp_send_json_success($result);
        die();
    }

    public static function get_template_content($args, $import = false)
    {
        
        if (isset($args['item_id']) && ! empty($args['item_id'])) {
            $id = $args['item_id'];
        }
        
        if (is_null($id)) {
            echo __('Something went wrong.', 'traveler-essential');
        }
        /**
         * Item will come from remote server.
         */
        $_purchase_code= get_option('envato_purchasecode');
        $admincallback = new Callbacks\AdminCallbacks;
        $data_items = $admincallback->get_template_item_api($id, $_purchase_code);
        return $data_items;
        
        if ($import) {
            return null;
        }
    }
    
    public function _importTemplate()
    {
        $id = isset($_POST['id']) ? intval($_POST['id']) : null;
        
        if (is_null($id)) {
            echo  __('Templates ID Not Found.', 'traveler-essential') ;
        }
    
        $default_args = array (
            'editor_post_id' => false,
            'item_id'        => $id,
        );
    
    
        $importer = new Importer;
        
        $template = $importer->get_data($default_args);
    
        wp_send_json_success($template);
    }

    public function _previewTemplate()
    {
        $url = (isset($_POST['url'])) ? ($_POST['url']) : '';
        $id = (isset($_POST['id'])) ? ($_POST['id']) : '';
        ob_start();?>
        <?php include(ST_ESSENTIAL_PLUGIN_PATH . 'templates/template-preview.php'); ?>
        <?php
        $result = ob_get_clean();
        wp_send_json_success($result);
        die();
    }

    public function addPages(array $pages)
    {
        $this->admin_pages = $pages;

        return $this;
    }

    public function withSubPage(string $title = null)
    {
        if (empty($this->admin_pages)) {
            return $this;
        }

        $admin_page = $this->admin_pages[0];

        $subpage = array(
            array(
                'parent_slug' => $admin_page['menu_slug'],
                'page_title' => $admin_page['page_title'],
                'menu_title' => ($title) ? $title : $admin_page['menu_title'],
                'capability' => $admin_page['capability'],
                'menu_slug' => $admin_page['menu_slug'],
                'callback' => $admin_page['callback']
            )
        );

        $this->admin_subpages = $subpage;

        return $this;
    }

    public function addSubPages(array $pages)
    {
        $this->admin_subpages = array_merge($this->admin_subpages, $pages);

        return $this;
    }

    public function addAdminMenu()
    {
        foreach ($this->admin_pages as $page) {
            add_submenu_page('st_traveler_option', $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback']);
        }
    }
}
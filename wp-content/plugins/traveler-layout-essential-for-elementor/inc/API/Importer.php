<?php

namespace Inc\API;

use Elementor\TemplateLibrary\Source_Local;
use Elementor\Plugin as ElementorPlugin;

class Importer extends Source_Local
{
    /**
     * Get template data.
     *
     * @inheritDoc
     *
     * @param array       $args    Custom template arguments.
     * @param string      $context Optional. The context. Default is `display`.
     *
     * @return array Remote Template data.
     */
    public function get_data(array $args, $context = 'display')
    {

        $data = SettingsApi::get_template_content($args, true);
        
        if (is_wp_error($data)) {
            return $data;
        }
        ElementorPlugin::$instance->editor->set_edit_mode(true);
        

        $data['content'] = $this->replace_elements_ids($data['content']);
    
    
        $data['content'] = $this->process_export_import_content($data['content'], 'on_import');
        
        $post_id  = $args['editor_post_id'];
        
        $document = ElementorPlugin::$instance->documents->get($post_id);
        
        if ($document) {
            $data['content'] = $document->get_elements_raw_data($data['content'], true);
        }
        return $data;
    }
}

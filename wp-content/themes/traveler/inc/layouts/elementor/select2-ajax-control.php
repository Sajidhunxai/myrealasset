<?php
use Elementor\Base_Data_Control;
class ST_Select2_Ajax_Control extends \Elementor\Base_Data_Control
{
    public function get_type()
    {
        return 'select2_ajax';
    }

    protected function get_default_settings()
    {
        return [
            'post_type'       => 'post',
            'delay'           => 250,
            'callback'        => '',       // class:method
            'minimum_text'    => 3,
            'placeholder'     => '',
            'multiple'        => 1,
            'close_on_select' => true,
            'cache'           => true,
            'allow_clear'     => true,
        ];
    }

    public function enqueue()
    {
        wp_enqueue_script('st-select2-ajax-control', get_template_directory_uri() . '/v3/js/admin/widget/select2-ajax.js', ['jquery'], null, true);
    }

    public function content_template()
    {
        $control_uid = $this->get_control_uid();
        ?>
        <div class="elementor-control-field">
            <label for="<?php echo esc_attr($control_uid); ?>" class="elementor-control-title">{{{ data.label
                }}}</label>
            <div class="elementor-control-input-wrapper">
                <select id="<?php echo esc_attr($control_uid); ?>" class="st-select2-control"
                        data-post-type="{{ data.post_type }}"
                        data-delay="{{ data.delay }}"
                        data-action="{{ data.action }}"
                        data-callback="{{ data.callback }}"
                        data-minimum-character="{{data.minimum_text}}"
                        data-placeholder="{{data.placeholder}}"
                        placeholder="{{ data.placeholder }}"
                        data-multiple="{{ data.multiple }}"
                        data-close-on-select="{{ data.close_on_select }}"
                        data-cache="{{ data.cache }}"
                        data-allow-clear="{{ data.allow_clear }}"
                    >
                </select>
            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
        <?php
    }

    public function not()
    {
    }
}

<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 02/05/2018
 * Time: 10:58 SA
 */
class ST_Admin_Settings extends STAdmin
{

    public static $_inst;
    private static $_allSettings = [];

    public function __construct()
    {
        add_action('admin_menu', [$this, '__registerPage'], 9);
        add_action('admin_enqueue_scripts', [$this, '__addScripts']);
        add_action('wp_ajax_traveler.settings.schema', [$this, '__getSchema']);
        add_action('wp_ajax_traveler.settings.section_schema', [$this, '__getSectionSchema']);
        add_action('wp_ajax_traveler.settings.save', [$this, '__saveSettings']);
        add_action('wp_ajax_traveler.settings.post_select', [$this, '__getPostsAjax']);
        add_action('wp_ajax_traveler.settings.term_select', [$this, '__getTermsAjax']);
        add_action('wp_ajax_traveler.settings.term_update', [$this, '__updateTermsAjax']);
        add_action('admin_notices', [$this, '__adminNoticeUpdateData']);
        add_action('wp_ajax_traveler.settings.email_document', [$this, '__getEmailDocument']);

        add_action('admin_init', [$this, 'removeThemeOptionMenu']);

        add_action('wp_ajax_st_get_icon_new', [$this, 'st_get_icon_new']);

        add_action('admin_init', array($this, '__updateThemeSettingsArr'));
    }

    public function tp_locale_default_filter()
    {
        $tp_locale_default = [
            [
                'value' => 'ar',
                'label' => esc_html__('Arabic', 'traveler')
            ],
            [
                'value' => 'ez',
                'label' => esc_html__('Azerbaijan', 'traveler')
            ],
            [
                'value' => 'ms',
                'label' => esc_html__('Bahasa Melayu', 'traveler')
            ],
            [
                'value' => 'br',
                'label' => esc_html__('Brazilian', 'traveler')
            ],
            [
                'value' => 'bg',
                'label' => esc_html__('Bulgarian', 'traveler')
            ],
            [
                'value' => 'zh',
                'label' => esc_html__('Chinese', 'traveler')
            ],
            [
                'value' => 'da',
                'label' => esc_html__('Danish', 'traveler')
            ],
            [
                'value' => 'de',
                'label' => esc_html__('Deutsch (DE)', 'traveler')
            ],
            [
                'value' => 'en',
                'label' => esc_html__('English', 'traveler')
            ],
            [
                'value' => 'en-AU',
                'label' => esc_html__('English (AU)', 'traveler')
            ],
            [
                'value' => 'en-GB',
                'label' => esc_html__('English (GB)', 'traveler')
            ],
            [
                'value' => 'fr',
                'label' => esc_html__('French', 'traveler')
            ],
            [
                'value' => 'ka',
                'label' => esc_html__('Georgian', 'traveler')
            ],
            [
                'value' => 'el',
                'label' => esc_html__('Greek (Modern Greek)', 'traveler')
            ],
            [
                'value' => 'it',
                'label' => esc_html__('Italian', 'traveler')
            ],
            [
                'value' => 'ja',
                'label' => esc_html__('Japanese', 'traveler')
            ],
            [
                'value' => 'lv',
                'label' => esc_html__('Latvian', 'traveler')
            ],
            [
                'value' => 'pl',
                'label' => esc_html__('Polish', 'traveler')
            ],
            [
                'value' => 'pt',
                'label' => esc_html__('Portuguese', 'traveler')
            ],
            [
                'value' => 'ro',
                'label' => esc_html__('Romanian', 'traveler')
            ],
            [
                'value' => 'ru',
                'label' => esc_html__('Russian', 'traveler')
            ],
            [
                'value' => 'sr',
                'label' => esc_html__('Serbian', 'traveler')
            ],
            [
                'value' => 'es',
                'label' => esc_html__('Spanish', 'traveler')
            ],
            [
                'value' => 'th',
                'label' => esc_html__('Thai', 'traveler')
            ],
            [
                'value' => 'tr',
                'label' => esc_html__('Turkish', 'traveler')
            ],
            [
                'value' => 'uk',
                'label' => esc_html__('Ukrainian', 'traveler')
            ],
            [
                'value' => 'vi',
                'label' => esc_html__('Vietnamese', 'traveler')
            ],
        ];
        return apply_filters('tp_locale_default', $tp_locale_default);
    }

    public function __updateThemeSettingsArr()
    {

        $current_version = '1.1';
        $db_version = get_option('st_option_tree_settings_output_css_version');
        if (empty($db_version) or $db_version != $current_version) {
            $this->getAllSettings();
            $arr = self::$_allSettings;
            $options = [];
            $options_output_css = [];
            $allows_output_css = [];

            if (class_exists('STCustomCSSOutput')) {
                $cls_st_custom_css_output = new STCustomCSSOutput();
                if (method_exists($cls_st_custom_css_output, '_options_allow_output')) {
                    $allows_output_css = STCustomCSSOutput::_options_allow_output();
                }
            }

            if (!empty($arr)) {
                foreach ($arr as $k => $v) {
                    $options_old = $options;
                    $func = $v['settings'][1];
                    $options = array_merge($options_old, $this->$func());

                    if (!empty($allows_output_css)) {
                        $current_options = $this->$func();
                        $ids = array_column($current_options, 'id');
                        $types = array_column($current_options, 'type');
                        $output_id = array_column($current_options, 'output', 'id');
                        $type_id = array_column($current_options, 'type', 'id');
                        $intersect = array_intersect($types, $allows_output_css);
                        if (!empty($intersect)) {
                            foreach ($intersect as $setting_type) {
                                if (!empty($type_id)) {
                                    foreach ($type_id as $id => $type) {
                                        $tmp = [];
                                        if ($type === $setting_type) {
                                            $setting_key = $id;
                                            if (isset($output_id[$setting_key])) {
                                                $output = $output_id[$setting_key];
                                                $tmp = [
                                                    'id' => $setting_key,
                                                    'output' => $output,
                                                    'type' => $setting_type
                                                ];
                                                $options_output_css[$setting_key] = $tmp;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }

            update_option('st_option_tree_settings_output_css', $options_output_css);
            update_option('st_option_tree_settings_output_css_version', $current_version);
        }

        $remove_st_option_tree_settings_new = '1';
        $db_version_remove = get_option('remove_st_option_tree_settings_new');
        if (empty($db_version_remove) or $db_version_remove != $remove_st_option_tree_settings_new) {
            delete_option('st_option_tree_settings_new');
            delete_option('st_option_tree_settings_new_version');
            update_option('remove_st_option_tree_settings_new', $remove_st_option_tree_settings_new, 'no');
        }
    }

    public function st_get_icon_new()
    {
        global $text;
        $text = STInput::post('text');
        $text = strtolower(trim($text));
        if (empty($text)) {
            echo json_encode([
                'status' => 0,
                'data' => __('Not found icons', 'traveler')
            ]);
            die;
        }
        include get_template_directory() . '/v2/fonts/fonts.php';
        if (!isset($fonts)) {
            echo json_encode([
                'status' => 0,
                'data' => __('Not found icons data', 'traveler')
            ]);
            die;
        }
        $results = array_filter($fonts, function ($key) {
            global $text;
            if (strpos($key, $text) === false) {
                return false;
            } else {
                return true;
            }
        }, ARRAY_FILTER_USE_KEY);
        if (empty($results)) {
            echo json_encode([
                'status' => 0,
                'data' => __('Not found icons', 'traveler')
            ]);
            die;
        } else {
            echo json_encode([
                'status' => 1,
                'data' => $results
            ]);
            die;
        }
    }

    public function removeThemeOptionMenu()
    {
        remove_submenu_page('themes.php', 'ot-theme-options');
    }

    public function changeLinkThemeOption()
    {
        return 'st_traveler_option';
    }

    public function __adminNoticeUpdateData()
    {
        $last_sync_time = get_option('st_last_sync_availability');
        $st_import_setting_reading = get_option('st_import_setting_reading');
        if (empty($last_sync_time) and ($st_import_setting_reading == 'completed')) {
            ?>
            <div class="updated" style="padding: 10px !important;">
                <?php echo __('<b>Traveler data update</b> – We need to update your database to the latest version.', 'traveler'); ?>
                <br/><br/>
                <?php echo '<a href="' . esc_url(admin_url('admin.php?page=st_sync_availability')) . '" class="button-primary">' . __('Run the updater', 'traveler') . '</a>' ?>
            </div>
            <?php
        }
    }

    public function __updateTermsAjax()
    {
        $this->verifyRequest();
        $term_id = isset($_POST['term_id']) ? $_POST['term_id'] : '';
        $image_id = isset($_POST['image_id']) ? $_POST['image_id'] : '';
        $image_url = isset($_POST['image_url']) ? $_POST['image_url'] : '';
        $action_type = isset($_POST['action_type']) ? $_POST['action_type'] : 'update';

        if ($action_type == 'update') {
            update_term_meta($term_id, 'term_image_id', $image_id);
            update_term_meta($term_id, 'term_image_url', $image_url);
        } else {
            delete_term_meta($term_id, 'term_image_id', '');
            delete_term_meta($term_id, 'term_image_url', '');
        }
    }

    public function __getTermsAjax()
    {
        $this->verifyRequest();
        $term = isset($_POST['term']) ? $_POST['term'] : '';

        $rows = [];

        $terms = get_terms(array(
            'taxonomy' => $term,
            'hide_empty' => false,
        ));

        if (!is_wp_error($rows) && !empty($terms)) {
            foreach ($terms as $item) {
                $image_id = get_term_meta($item->term_id, 'term_image_id', true);
                $image_url = get_term_meta($item->term_id, 'term_image_url', true);
                $rows[] = [
                    'term_id' => $item->term_id,
                    'name' => $item->name,
                    'image_id' => $image_id,
                    'image_url' => $image_url
                ];
            }
        }

        $this->sendJson([
            'rows' => $rows
        ]);
    }

    public function __getPostsAjax()
    {
        $this->verifyRequest();
        $q = isset($_POST['q']) ? $_POST['q'] : '';
        $post_type = isset($_POST['post_type']) ? $_POST['post_type'] : 'page';
        $sparam = isset($_POST['sparam']) ? $_POST['sparam'] : 'page';

        $rows = [];
        switch ($sparam) {
            case 'page':
                $query = new WP_Query([
                    'post_type' => $post_type,
                    's' => $q,
                    'posts_per_page' => -1,
                    'post_status' => 'publish'
                ]);

                while ($query->have_posts()) {
                    $query->the_post();
                    $rows[] = [
                        'id' => get_the_ID(),
                        'name' => get_the_title(),
                    ];
                }
                wp_reset_postdata();
                break;
            case 'layout':
                $data_layout = st_get_layout($post_type, $q);
                if (!empty($data_layout)) {
                    foreach ($data_layout as $k => $v) {
                        $rows[] = [
                            'id' => $v['value'],
                            'name' => $v['label'],
                        ];
                    }
                }
                break;
            case 'sidebar':
                $data_sidebar = $GLOBALS['wp_registered_sidebars'];
                if (!empty($data_sidebar)) {
                    $sidebar_arr = [];
                    foreach ($data_sidebar as $k => $v) {
                        $sidebar_arr[$k] = strtolower($v['name']);
                    }

                    $input = preg_quote(strtolower($q), '~');
                    $result = preg_grep('~' . $input . '~', $sidebar_arr);

                    if (!empty($result)) {
                        foreach ($result as $k => $v) {
                            $rows[] = [
                                'id' => $k,
                                'name' => $data_sidebar[$k]['name'],
                            ];
                        }
                    }
                }

                break;
            case 'posttype_select':
                $data_post_type_select = TravelHelper::get_list_all_item_in_services($post_type, $q);
                if (!empty($data_post_type_select)) {
                    foreach ($data_post_type_select as $k => $v) {
                        $rows[] = [
                            'id' => $v['value'],
                            'name' => $v['label'],
                        ];
                    }
                }
                break;
        }
        $this->sendJson([
            'rows' => $rows
        ]);
    }

    public function __saveSettings()
    {
        $this->verifyRequest();
        $s = isset($_POST['settings']) ? $_POST['settings'] : '';
        $settings = json_decode(wp_unslash($s), true);
        if (empty($settings))
            $this->sendError(esc_html__('Empty settings', 'traveler'));

        $old = get_option(st_options_id());

        $old = wp_parse_args($settings, $old);

        update_option(st_options_id(), $old);

        $this->sendJson(['message' => esc_html__('Settings Saved', 'traveler')]);
    }

    public function __addScripts()
    {
        if (!empty($_GET['page']) and $_GET['page'] == 'st_traveler_option') {
            $debug = (defined('SCRIPT_DEBUG') and SCRIPT_DEBUG) ? '' : '.min';

            $theme = wp_get_theme();
            $title = esc_html($theme->display('Name'));
            $title .= ' - ' . sprintf(__('Version %s', 'traveler'), $theme->display('Version'));

            // if wpml
            if (defined('ICL_LANGUAGE_CODE') and defined('ICL_SITEPRESS_VERSION')) {
                $text = ICL_LANGUAGE_NAME ? ICL_LANGUAGE_NAME : ICL_LANGUAGE_CODE;
                $title .= ' ' . sprintf(__('for %s', 'traveler'), $text);
            } else {
                // if qtranslate
                if (function_exists('qtranxf_init_language')) {
                    global $q_config;
                    $lan = $q_config['language'];
                    $title .= " " . sprintf(__('for %s', 'traveler'), $q_config['language_name'][$lan]);
                }
            }

            wp_localize_script('jquery', 'traveler_settings', [
                '_s' => wp_create_nonce('traveler_settings_security'),
                'ajax_url' => admin_url('admin-ajax.php'),
                'info' => [
                    'blog_info' => get_bloginfo('title'),
                    'logo' => get_template_directory_uri() . '/css/admin/logo-st.png',
                    'name' => $title,
                ],
                'i18n' => [
                    'saveChanges' => esc_html__('Save Changes', 'traveler'),
                    'loading' => esc_html__('Loading...', 'traveler'),
                    'typing' => esc_html__('Typing to search your page...', 'traveler'),
                    'addNew' => esc_html__('Add New', 'traveler'),
                    'confirmDelete' => esc_html__('Do you want to delete', 'traveler'),
                    'language' => esc_html__('Languages', 'traveler'),
                    'defaultCurrency' => esc_html__('Default currency', 'traveler'),
                    'selectCurrency' => esc_html__('Select currency', 'traveler')
                ],
                'sections' => $this->getSections(),
            ]);
            wp_enqueue_media();
            wp_enqueue_script('tinymce_js', get_template_directory_uri() . '/js/admin/tinymce/tinymce.min.js', ['jquery'], false, true);
            wp_enqueue_style('traveler-spectrum', get_template_directory_uri() . '/assets/dist/spectrum/spectrum.css');
            wp_enqueue_script('traveler-spectrum', get_template_directory_uri() . '/assets/dist/spectrum/spectrum.js', [], null, true);
            wp_enqueue_script('traveler-settings', get_template_directory_uri() . '/assets/dist/traveler-settings' . $debug . '.js', [], null, true);
        }
        if (check_using_elementor()) {
            if (get_current_screen()->base === 'nav-menus') {
                wp_enqueue_style('wp-color-picker');
                wp_enqueue_script('wp-color-picker');
                wp_enqueue_media();
                wp_enqueue_script('mega-menu', get_template_directory_uri() . '/v3/js/admin/menu-admin.js', [], null, true);
                wp_enqueue_style('mega-menu-new', get_template_directory_uri() . '/v3/css/admin/menu-admin.css');
            }
        }

    }

    public function __registerPage()
    {
        if (class_exists('Envato_WP_Toolkit')) {
            $pos = 59;
        } else
            $pos = 58;
        add_menu_page('Theme Settings', 'Theme Settings ', 'manage_options', 'st_traveler_option', [$this, '__showPage'], 'dashicons-st-traveler', $pos);
        add_submenu_page('st_traveler_option', __('Theme Options', 'traveler'), __('Theme Options', 'traveler'), 'manage_options', 'st_traveler_option', [$this, '__showPage']);
    }

    public function __showPage()
    {
        ?>
        <div class="wrap">
            <div id="traveler_settings_app"></div>
        </div>
        <?php
    }

    public function __getSchema()
    {
        $this->verifyRequest();
        $this->sendJson($this->getSchema());
    }

    public function __getSectionSchema()
    {
        $this->verifyRequest();
        $section = isset($_POST['section']) ? $_POST['section'] : '';

        $s = $this->findSection($section);
        $rs = [
            'tabs' => [],
            'fields' => [],
        ];
        $all = get_option(st_options_id());
        $model = [];
        $default = [];
        if ($s and is_callable($s['settings'])) {
            $settings = call_user_func($s['settings']);
            $lastTab = '';
            $lastSection = '';
            foreach ($settings as $index => $field) {
                if ($field['section'] != $section)
                    continue;


                switch ($field['type']) {
                    case "list-item":
                        if (!is_array($all[$field['id']]))
                            $all[$field['id']] = [];
                        $all[$field['id']] = array_values($all[$field['id']]);
                        break;
                    case "checkbox":
                        $all[$field['id']] = isset($all[$field['id']]) ? array_values($all[$field['id']]) : [];
                        break;
                }
                $model[$field['id']] = isset($all[$field['id']]) ? $all[$field['id']] : '';

                $field = $this->filterSettingsField($field);

                if ($field['type'] == 'tab') {
                    $lastTab = $field['id'];
                    $rs['tabs'][$lastTab] = [
                        'id' => $lastTab,
                        'title' => $field['label'],
                        'fields' => []
                    ];
                } else {
                    if ($lastTab and $lastSection == $field['section']) {
                        $rs['tabs'][$lastTab]['fields'][] = $field;
                    } else {
                        $rs['fields'][] = $field;
                    }
                }


                if (isset($field['std']))
                    $default[$field['id']] = $field['std'];

                $lastSection = $field['section'];
            }
        }


        $rs['fields'] = array_values($rs['fields']);
        $rs['tabs'] = array_values($rs['tabs']);
        $model = wp_parse_args($model, $default);
        $this->sendJson(['schema' => $rs, 'model' => $model]);
    }

    protected function filterSettingsField($field)
    {
        if (!empty($field['desc'])) {
            if (empty($field['v_hint'])) {
                $field['hint'] = $field['desc'];
            } else {
                if ($field['v_hint'] != 'yes') {
                    $field['hint'] = $field['desc'];
                }
            }
        }
        if ($field['type'] == 'post-select-ajax') {
            $field['sld'] = TravelHelper::getNamePropertyByID($field);
            $field['type'] = 'postSelectAjax';
        }

        if ($field['type'] == 'list-item') {
            $field['type'] = 'listItem';
        }
        if ($field['type'] == 'checkbox') {
            $field['type'] = 'checklist';
        }
        if ($field['type'] == 'upload') {
            $field['type'] = 'stUpload';
        }
        if ($field['type'] == 'colorpicker') {
            $field['type'] = 'spectrum';
        }

        if ($field['type'] == 'radio-image') {
            $field['type'] = 'radioimage';
        }

        if ($field['type'] == 'email_template_document') {
            $field['type'] = 'emailTemplateDocument';
        }

        if ($field['type'] == 'st_mapping_currency') {
            $field['type'] = 'mappingCurrency';
        }

        if ($field['type'] == 'custom-text') {
            $field['type'] = 'customText';
        }

        if ($field['type'] == 'custom-select') {
            $field['type'] = 'customSelect';
        }

        if ($field['type'] == 'select_ui') {
            $field['type'] = 'selectUI';
        }

        if ($field['type'] == 'term_image') {
            $field['type'] = 'termImage';

            $attribute = new STAttribute();
            $field['options'] = $attribute->get_attributes();
        }

        switch ($field['type']) {
            case "text":
                $field['type'] = 'textNew';
                break;
            case "number":
                $field["inputType"] = $field['type'];
                $field['type'] = 'input';
                break;
            case "textarea":
                $field['type'] = 'textAreaTiny';
                break;
            case "textarea-simple":
                $field['type'] = 'textAreaNew';
                break;
            case "select":
                $values = [];
                if (!empty($field['choices'])) {
                    foreach ($field['choices'] as $c) {
                        $values[] = [
                            'id' => $c['value'],
                            'name' => $c['label'],
                        ];
                    }
                    $field['values'] = $values;
                }
                $field['type'] = 'customSelect';
                break;
            case "checklist":
                $field['listBox'] = true;
                $values = [];
                if (!empty($field['choices'])) {
                    foreach ($field['choices'] as $c) {
                        $values[] = [
                            'value' => $c['value'],
                            'name' => $c['label'],
                        ];
                    }
                    $field['values'] = $values;
                }
                break;
            case "on-off":
                $field['type'] = 'switchNew';
                $field['textOn'] = esc_html__('On', 'traveler');
                $field['textOff'] = esc_html__('Off', 'traveler');
                $field['valueOn'] = 'on';
                $field['valueOff'] = 'off';
                break;
            case "listItem":
                if (!empty($field['settings'])) {
                    $field['settings'] = array_merge([
                        [
                            'type' => 'text',
                            'label' => esc_html__('Title', 'traveler'),
                            'id' => 'title'
                        ]
                    ], $field['settings']);
                    foreach ($field['settings'] as $k => $v) {
                        $field['settings'][$k] = $this->filterSettingsField($v);
                    }
                }
                break;
            case "st_select_tax":
                $field['type'] = 'select';
                $choices = st_get_post_taxonomy($field['post_type']);
                $values = [];
                if (!empty($choices)) {
                    foreach ($choices as $c) {
                        $values[] = [
                            'id' => $c['value'],
                            'name' => $c['label'],
                        ];
                    }
                }
                $field['values'] = $values;
                break;
        }
        $field['type'] = str_replace('-', '', $field['type']);
        $field['model'] = $field['id'];

        return $field;
    }

    public function findSection($section)
    {
        $all = $this->getAllSettings();

        foreach ($all as $v) {
            if ($v['id'] == $section)
                return $v;
        }

        return false;
    }

    protected function getSchema()
    {
        $schema = [];
        $model = get_option(st_options_id());
        $default = [];

        //include_once ST_TRAVELER_DIR . '/inc/st-theme-options.php';
        if (!empty($custom_settings)) {
            foreach ($custom_settings['sections'] as $section) {
                $section['fields'] = [];
                $section['tabs'] = [];
                $schema[$section['id']] = $section;
            }
        }
        $model = wp_parse_args($model, $default);

        return [
            'schema' => $schema,
            'model' => $model
        ];
    }

    protected function getSections()
    {
        $all = $this->getAllSettings();

        foreach ($all as $k => $v) {
            unset($all[$k]['settings']);
        }

        return $all;
    }

    public function __socialLoginSettings()
    {
        if (!is_plugin_active('traveler-social-login/traveler-social-login.php')){
            $settings = [[
                'id' => 'social_notice',
                'label' => __('Notice', 'traveler-social-login'),
                'desc' => __('Kindly install Theme Settings > Extensions > Traveler Social Login and setup in here'),
                'section' => 'option_social'
            ]];
        }else {
            $settings = [];
        }


        return apply_filters('social_setting', $settings);
    }

    public function __otherSettings()
    {
        return apply_filters('stOtherSetings',[
            /* [
              'id'      => 'gen_enable_smscroll',
              'label'   => __( 'Enable Nice Scroll', 'traveler' ),
              'desc'    => __( 'This allows you to turn on or off "Nice Scroll Effect"', 'traveler' ),
              'type'    => 'on-off',
              'section' => 'option_bc',
              'std'     => 'off'
              ],
              [
              'id'      => 'sp_disable_javascript',
              'label'   => __( 'Support Disable javascript', 'traveler' ),
              'desc'    => __( 'This allows css friendly with browsers what disable javascript', 'traveler' ),
              'type'    => 'on-off',
              'section' => 'option_bc',
              'std'     => 'off'
              ], */


            // [
            //     'id' => 'st_googlemap_enabled',
            //     'label' => __('Enable Google map', 'traveler'),
            //     'type' => 'on-off',
            //     'desc' => __('Document get key https://developers.google.com/maps/documentation/javascript/get-api-key', 'traveler'),
            //     'std' => 'on',
            //     'section' => 'option_bc',
            // ],
            [
                'id' => 'st_googlemap_enabled',
                'label' => __('Map API', 'traveler'),
                'type' => 'select',
                'desc' => __('Document get map API key https://travelerwp.com/documents/other-features/map-api/', 'traveler'),
                'std' => 'on',
                'choices' => [
                    [
                        'value' => 'on',
                        'label' => esc_html__('Google map', 'traveler')
                    ],
                    [
                        'value' => 'off',
                        'label' => esc_html__('Mapbox', 'traveler')
                    ],
                ],
                'section' => 'option_bc',
            ],
            [
                'id' => 'st_token_mapbox',
                'label' => __('Token MapBox', 'traveler'),
                'desc' => __('Input your Token key ', 'traveler') . "<a target='_blank' href='https://account.mapbox.com'>How to get it?</a>",
                'type' => 'text',
                'section' => 'option_bc',
                'std' => 'pk.eyJ1IjoidGhvYWluZ28iLCJhIjoiY2p3dTE4bDFtMDAweTQ5cm5rMXA5anUwMSJ9.RkIx76muBIvcZ5HDb2g0Bw',
                'v_hint' => 'yes',
                'condition' => 'st_googlemap_enabled:is(off)'
            ],
            [
                'id' => 'google_api_key',
                'label' => __('Google API key', 'traveler'),
                'desc' => __('Input your Google API key ', 'traveler') . "<a target='_blank' href='https://developers.google.com/maps/documentation/javascript/get-api-key'>How to get it?</a>",
                'type' => 'text',
                'section' => 'option_bc',
                'std' => 'AIzaSyA1l5FlclOzqDpkx5jSH5WBcC0XFkqmYOY',
                'v_hint' => 'yes',
                'condition' => 'st_googlemap_enabled:is(on)'
            ],
            [
                'id' => 'google_font_api_key',
                'label' => __('Google Fonts API key', 'traveler'),
                'desc' => __('Input your Google Fonts API key ', 'traveler') . "<a target='_blank' href='https://developers.google.com/fonts/docs/developer_api'>How to get it?</a>",
                'type' => 'text',
                'section' => 'option_bc',
                'v_hint' => 'yes'
            ],
            /* [
              'id'      => 'weather_api_key',
              'label'   => __( 'Weather API key', 'traveler' ),
              'desc'    => __( 'Input your Weather API key ', 'traveler' ) . "<a target='_blank' href='https://home.openweathermap.org/api_keys'>openweathermap.org</a>",
              'type'    => 'custom-text',
              'section' => 'option_bc',
              'std'     => 'a82498aa9918914fa4ac5ba584a7e623',
              'v_hint'  => 'yes'
              ], */
        ]);
    }

    public function __apiConfigureSettings()
    {
        return apply_filters('api_configure_setting', [

            /* [
              'id'        => 'st_api_external_booking',
              'section'   => 'option_api_update',
              'label'     => __( 'External Booking', 'traveler' ),
              'desc'      => __( 'External Booking', 'traveler' ),
              'type'      => 'on-off',
              'std'       => 'off',
              'condition' => ""
              ], */
            /* [
              'id'      => 'show_only_room_by',
              'label'   => __( 'Show Only Room By', 'traveler' ),
              'type'    => 'checkbox',
              'section' => 'option_api_update',
              'choices' => [
              [
              'label' => __( 'All', 'traveler' ),
              'value' => 'all'
              ],
              [
              'label' => __( 'Roomorama', 'traveler' ),
              'value' => 'st_roomorama'
              ],
              ],
              'std'     => 'all',
              ], */
            //TravelPayouts
            [
                'id' => 'travelpayouts_option',
                'label' => esc_html__('TravelPayouts', 'traveler'),
                'type' => 'tab',
                'section' => 'option_api_update'
            ],
            [
                'id' => 'tp_marker',
                'label' => esc_html__('Travelpayouts ID', 'traveler'),
                'type' => 'text',
                'desc' => esc_html__('Enter your Travelpayouts ID', 'traveler'),
                'section' => 'option_api_update'
            ],
            [
                'id' => 'tp_locale_default',
                'label' => esc_html__('Default Language', 'traveler'),
                'type' => 'select',
                'operator' => 'and',
                'choices' => $this->tp_locale_default_filter(),
                'section' => 'option_api_update',
                'std' => 'en'
            ],
            [
                'id' => 'tp_currency_default',
                'label' => esc_html__('Default Currency', 'traveler'),
                'type' => 'select',
                'choices' => [
                    [
                        'value' => 'amd',
                        'label' => esc_html__('UAE dirham (AED)', 'traveler')
                    ],
                    [
                        'value' => 'amd',
                        'label' => esc_html__('Armenian Dram (AMD)', 'traveler')
                    ], [
                        'value' => 'ars',
                        'label' => esc_html__('Argentine peso (ARS)', 'traveler')
                    ], [
                        'value' => 'aud',
                        'label' => esc_html__('Australian Dollar (AUD)', 'traveler')
                    ], [
                        'value' => 'azn',
                        'label' => esc_html__('Azerbaijani Manat (AZN)', 'traveler')
                    ], [
                        'value' => 'bdt',
                        'label' => esc_html__('Bangladeshi taka (BDT)', 'traveler')
                    ], [
                        'value' => 'bgn',
                        'label' => esc_html__('Bulgarian lev (BGN)', 'traveler')
                    ], [
                        'value' => 'brl',
                        'label' => esc_html__('Brazilian real (BRL)', 'traveler')
                    ], [
                        'value' => 'byr',
                        'label' => esc_html__('Belarusian ruble (BYR)', 'traveler')
                    ], [
                        'value' => 'chf',
                        'label' => esc_html__('Swiss Franc (CHF)', 'traveler')
                    ], [
                        'value' => 'clp',
                        'label' => esc_html__('Chilean peso (CLP)', 'traveler')
                    ], [
                        'value' => 'cny',
                        'label' => esc_html__('Chinese Yuan (CNY)', 'traveler')
                    ], [
                        'value' => 'cop',
                        'label' => esc_html__('Colombian peso (COP)', 'traveler')
                    ], [
                        'value' => 'dkk',
                        'label' => esc_html__('Danish krone (DKK)', 'traveler')
                    ], [
                        'value' => 'egp',
                        'label' => esc_html__('Egyptian Pound (EGP)', 'traveler')
                    ], [
                        'value' => 'eur',
                        'label' => esc_html__('Euro (EUR)', 'traveler')
                    ], [
                        'value' => 'gbp',
                        'label' => esc_html__('British Pound Sterling (GBP)', 'traveler')
                    ], [
                        'value' => 'gel',
                        'label' => esc_html__('Georgian lari (GEL)', 'traveler')
                    ], [
                        'value' => 'hkd',
                        'label' => esc_html__('Hong Kong Dollar (HKD)', 'traveler')
                    ], [
                        'value' => 'huf',
                        'label' => esc_html__('Hungarian forint (HUF)', 'traveler')
                    ], [
                        'value' => 'idr',
                        'label' => esc_html__('Indonesian Rupiah (IDR)', 'traveler')
                    ],
                    [
                        'value' => 'inr',
                        'label' => esc_html__('Indian Rupee (INR)', 'traveler')
                    ],
                    [
                        'value' => 'iqd',
                        'label' => esc_html__('Iraqi Dinar (IQD)', 'traveler')
                    ],
                    [
                        'value' => 'jpy',
                        'label' => esc_html__('Japanese Yen (JPY)', 'traveler')
                    ], [
                        'value' => 'kgs',
                        'label' => esc_html__('Som (KGS)', 'traveler')
                    ], [
                        'value' => 'krw',
                        'label' => esc_html__('South Korean won (KRW)', 'traveler')
                    ], [
                        'value' => 'mxn',
                        'label' => esc_html__('Mexican peso (MXN)', 'traveler')
                    ], [
                        'value' => 'myr',
                        'label' => esc_html__('Malaysian ringgit (MYR)', 'traveler')
                    ], [
                        'value' => 'nok',
                        'label' => esc_html__('Norwegian Krone (NOK)', 'traveler')
                    ], [
                        'value' => 'kzt',
                        'label' => esc_html__('Kazakhstani Tenge (KZT)', 'traveler')
                    ], [
                        'value' => 'ltl',
                        'label' => esc_html__('Latvian Lat (LTL)', 'traveler')
                    ], [
                        'value' => 'nzd',
                        'label' => esc_html__('New Zealand Dollar (NZD)', 'traveler')
                    ], [
                        'value' => 'pen',
                        'label' => esc_html__('Peruvian sol (PEN)', 'traveler')
                    ], [
                        'value' => 'php',
                        'label' => esc_html__('Philippine Peso (PHP)', 'traveler')
                    ], [
                        'value' => 'pkr',
                        'label' => esc_html__('Pakistan Rupee (PKR)', 'traveler')
                    ], [
                        'value' => 'pln',
                        'label' => esc_html__('Polish zloty (PLN)', 'traveler')
                    ], [
                        'value' => 'ron',
                        'label' => esc_html__('Romanian leu (RON)', 'traveler')
                    ], [
                        'value' => 'rsd',
                        'label' => esc_html__('Serbian dinar (RSD)', 'traveler')
                    ], [
                        'value' => 'rub',
                        'label' => esc_html__('Russian Ruble (RUB)', 'traveler')
                    ], [
                        'value' => 'sar',
                        'label' => esc_html__('Saudi riyal (SAR)', 'traveler')
                    ], [
                        'value' => 'sek',
                        'label' => esc_html__('Swedish krona (SEK)', 'traveler')
                    ], [
                        'value' => 'sgd',
                        'label' => esc_html__('Singapore Dollar (SGD)', 'traveler')
                    ], [
                        'value' => 'thb',
                        'label' => esc_html__('Thai Baht (THB)', 'traveler')
                    ], [
                        'value' => 'try',
                        'label' => esc_html__('Turkish lira (TRY)', 'traveler')
                    ], [
                        'value' => 'uah',
                        'label' => esc_html__('Ukrainian Hryvnia (UAH)', 'traveler')
                    ], [
                        'value' => 'usd',
                        'label' => esc_html__('US Dollar (USD)', 'traveler')
                    ], [
                        'value' => 'vnd',
                        'label' => esc_html__('Vietnamese dong (VND)', 'traveler')
                    ], [
                        'value' => 'xof',
                        'label' => esc_html__('CFA Franc (XOF)', 'traveler')
                    ], [
                        'value' => 'zar',
                        'label' => esc_html__('South African Rand (ZAR)', 'traveler')
                    ],
                ],
                'section' => 'option_api_update',
                'std' => 'usd'
            ],
            [
                'id' => 'tp_redirect_option',
                'label' => esc_html__('Use Whitelabel', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_api_update',
                'std' => 'off'
            ],
            [
                'id' => 'tp_whitelabel',
                'label' => esc_html__('Whitelabel Name', 'traveler'),
                'type' => 'text',
                'section' => 'option_api_update',
                'condition' => 'tp_redirect_option:is(on)'
            ],
            [
                'id' => 'tp_whitelabel_page',
                'label' => esc_html__('Whitelabel Page Search', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'posttype_select',
                'section' => 'option_api_update',
                'condition' => 'tp_redirect_option:is(on)',
            ],
            [
                'id' => 'tp_show_api_info',
                'label' => esc_html__('Show API Info', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_api_update',
                'std' => 'on'
            ],

            //Hotelscombined
            // [
            //     'id' => 'hotelscb_option',
            //     'label' => esc_html__('HotelsCombined', 'traveler'),
            //     'type' => 'tab',
            //     'section' => 'option_api_update',
            // ],
            // [
            //     'id' => 'hotelscb_aff_id',
            //     'label' => esc_html__('Affiliate ID', 'traveler'),
            //     'type' => 'text',
            //     'desc' => esc_html__('Enter your affiliate ID', 'traveler'),
            //     'section' => 'option_api_update',
            // ],
            // [
            //     'id' => 'hotelscb_searchbox_id',
            //     'label' => esc_html__('Searchbox ID', 'traveler'),
            //     'type' => 'text',
            //     'desc' => esc_html__('Enter your search box ID', 'traveler'),
            //     'section' => 'option_api_update',
            // ],
            //Booking.com
            [
                'id' => 'bookingdc_option',
                'label' => esc_html__('Booking.com', 'traveler'),
                'type' => 'tab',
                'section' => 'option_api_update',
            ],
            [
                'id' => 'bookingdc_iframe',
                'label' => __('Using iframe search form', 'traveler'),
                'desc' => __('Enable iframe search form', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_api_update',
                'std' => 'on',
            ],
            [
                'id' => 'bookingdc_iframe_code',
                'label' => __('Search form code', 'traveler'),
                'desc' => __('Enter your search box code from booking.com', 'traveler'),
                'type' => 'textarea-simple',
                'rows' => '4',
                'condition' => 'bookingdc_iframe:is(on)',
                'section' => 'option_api_update',
            ],
            [
                'id' => 'bookingdc_aid',
                'label' => __('Your affiliate ID', 'traveler'),
                'desc' => __('Enter your affiliate ID from booking.com', 'traveler'),
                'type' => 'text',
                'condition' => 'bookingdc_iframe:is(off)',
                'section' => 'option_api_update',
            ],
            /* array(
              'id' => 'bookingdc_cname',
              'label' => __('Cname', 'traveler'),
              'desc' => __('Enter your Cname for search box', 'traveler'),
              'type' => 'text',
              'condition' => 'bookingdc_iframe:is(off)',
              'section' => 'option_api_update',
              ), */
            /* [
              'id'        => 'bookingdc_lang',
              'label'     => esc_html__( 'Default Language', 'traveler' ),
              'type'      => 'select',
              'operator'  => 'and',
              'choices'   => [
              [
              'value' => 'ez',
              'label' => esc_html__( 'Azerbaijan', 'traveler' )
              ],
              [
              'value' => 'ms',
              'label' => esc_html__( 'Bahasa Melayu', 'traveler' )
              ],
              [
              'value' => 'br',
              'label' => esc_html__( 'Brazilian', 'traveler' )
              ],
              [
              'value' => 'bg',
              'label' => esc_html__( 'Bulgarian', 'traveler' )
              ],
              [
              'value' => 'zh',
              'label' => esc_html__( 'Chinese', 'traveler' )
              ],
              [
              'value' => 'da',
              'label' => esc_html__( 'Danish', 'traveler' )
              ],
              [
              'value' => 'de',
              'label' => esc_html__( 'Deutsch (DE)', 'traveler' )
              ],
              [
              'value' => 'en',
              'label' => esc_html__( 'English', 'traveler' )
              ],
              [
              'value' => 'en-AU',
              'label' => esc_html__( 'English (AU)', 'traveler' )
              ],
              [
              'value' => 'en-GB',
              'label' => esc_html__( 'English (GB)', 'traveler' )
              ],
              [
              'value' => 'fr',
              'label' => esc_html__( 'French', 'traveler' )
              ],
              [
              'value' => 'ka',
              'label' => esc_html__( 'Georgian', 'traveler' )
              ],
              [
              'value' => 'el',
              'label' => esc_html__( 'Greek (Modern Greek)', 'traveler' )
              ],
              [
              'value' => 'it',
              'label' => esc_html__( 'Italian', 'traveler' )
              ],
              [
              'value' => 'ja',
              'label' => esc_html__( 'Japanese', 'traveler' )
              ],
              [
              'value' => 'lv',
              'label' => esc_html__( 'Latvian', 'traveler' )
              ],
              [
              'value' => 'pl',
              'label' => esc_html__( 'Polish', 'traveler' )
              ],
              [
              'value' => 'pt',
              'label' => esc_html__( 'Portuguese', 'traveler' )
              ],
              [
              'value' => 'ro',
              'label' => esc_html__( 'Romanian', 'traveler' )
              ],
              [
              'value' => 'ru',
              'label' => esc_html__( 'Russian', 'traveler' )
              ],
              [
              'value' => 'sr',
              'label' => esc_html__( 'Serbian', 'traveler' )
              ],
              [
              'value' => 'es',
              'label' => esc_html__( 'Spanish', 'traveler' )
              ],
              [
              'value' => 'th',
              'label' => esc_html__( 'Thai', 'traveler' )
              ],
              [
              'value' => 'tr',
              'label' => esc_html__( 'Turkish', 'traveler' )
              ],
              [
              'value' => 'uk',
              'label' => esc_html__( 'Ukrainian', 'traveler' )
              ],
              [
              'value' => 'vi',
              'label' => esc_html__( 'Vietnamese', 'traveler' )
              ],

              ],
              'section'   => 'option_api_update',
              'std'       => 'en',
              'condition' => 'bookingdc_iframe:is(off)',
              ], */
            [
                'id' => 'bookingdc_currency',
                'label' => esc_html__('Default Currency', 'traveler'),
                'type' => 'select',
                'choices' => [
                    [
                        'value' => 'amd',
                        'label' => esc_html__('UAE dirham (AED)', 'traveler')
                    ],
                    [
                        'value' => 'amd',
                        'label' => esc_html__('Armenian Dram (AMD)', 'traveler')
                    ], [
                        'value' => 'ars',
                        'label' => esc_html__('Argentine peso (ARS)', 'traveler')
                    ], [
                        'value' => 'aud',
                        'label' => esc_html__('Australian Dollar (AUD)', 'traveler')
                    ], [
                        'value' => 'azn',
                        'label' => esc_html__('Azerbaijani Manat (AZN)', 'traveler')
                    ], [
                        'value' => 'bdt',
                        'label' => esc_html__('Bangladeshi taka (BDT)', 'traveler')
                    ], [
                        'value' => 'bgn',
                        'label' => esc_html__('Bulgarian lev (BGN)', 'traveler')
                    ], [
                        'value' => 'brl',
                        'label' => esc_html__('Brazilian real (BRL)', 'traveler')
                    ], [
                        'value' => 'byr',
                        'label' => esc_html__('Belarusian ruble (BYR)', 'traveler')
                    ], [
                        'value' => 'chf',
                        'label' => esc_html__('Swiss Franc (CHF)', 'traveler')
                    ], [
                        'value' => 'clp',
                        'label' => esc_html__('Chilean peso (CLP)', 'traveler')
                    ], [
                        'value' => 'cny',
                        'label' => esc_html__('Chinese Yuan (CNY)', 'traveler')
                    ], [
                        'value' => 'cop',
                        'label' => esc_html__('Colombian peso (COP)', 'traveler')
                    ], [
                        'value' => 'dkk',
                        'label' => esc_html__('Danish krone (DKK)', 'traveler')
                    ], [
                        'value' => 'egp',
                        'label' => esc_html__('Egyptian Pound (EGP)', 'traveler')
                    ], [
                        'value' => 'eur',
                        'label' => esc_html__('Euro (EUR)', 'traveler')
                    ], [
                        'value' => 'gbp',
                        'label' => esc_html__('British Pound Sterling (GBP)', 'traveler')
                    ], [
                        'value' => 'gel',
                        'label' => esc_html__('Georgian lari (GEL)', 'traveler')
                    ], [
                        'value' => 'hkd',
                        'label' => esc_html__('Hong Kong Dollar (HKD)', 'traveler')
                    ], [
                        'value' => 'huf',
                        'label' => esc_html__('Hungarian forint (HUF)', 'traveler')
                    ], [
                        'value' => 'idr',
                        'label' => esc_html__('Indonesian Rupiah (IDR)', 'traveler')
                    ], [
                        'value' => 'inr',
                        'label' => esc_html__('Indian Rupee (INR)', 'traveler')
                    ],
                    [
                        'value' => 'iqd',
                        'label' => esc_html__('Iraqi Dinar (IQD)', 'traveler')
                    ],
                    [
                        'value' => 'jpy',
                        'label' => esc_html__('Japanese Yen (JPY)', 'traveler')
                    ], [
                        'value' => 'kgs',
                        'label' => esc_html__('Som (KGS)', 'traveler')
                    ], [
                        'value' => 'krw',
                        'label' => esc_html__('South Korean won (KRW)', 'traveler')
                    ], [
                        'value' => 'mxn',
                        'label' => esc_html__('Mexican peso (MXN)', 'traveler')
                    ], [
                        'value' => 'myr',
                        'label' => esc_html__('Malaysian ringgit (MYR)', 'traveler')
                    ], [
                        'value' => 'nok',
                        'label' => esc_html__('Norwegian Krone (NOK)', 'traveler')
                    ], [
                        'value' => 'kzt',
                        'label' => esc_html__('Kazakhstani Tenge (KZT)', 'traveler')
                    ], [
                        'value' => 'ltl',
                        'label' => esc_html__('Latvian Lat (LTL)', 'traveler')
                    ], [
                        'value' => 'nzd',
                        'label' => esc_html__('New Zealand Dollar (NZD)', 'traveler')
                    ], [
                        'value' => 'pen',
                        'label' => esc_html__('Peruvian sol (PEN)', 'traveler')
                    ], [
                        'value' => 'php',
                        'label' => esc_html__('Philippine Peso (PHP)', 'traveler')
                    ], [
                        'value' => 'pkr',
                        'label' => esc_html__('Pakistan Rupee (PKR)', 'traveler')
                    ], [
                        'value' => 'pln',
                        'label' => esc_html__('Polish zloty (PLN)', 'traveler')
                    ], [
                        'value' => 'ron',
                        'label' => esc_html__('Romanian leu (RON)', 'traveler')
                    ], [
                        'value' => 'rsd',
                        'label' => esc_html__('Serbian dinar (RSD)', 'traveler')
                    ], [
                        'value' => 'rub',
                        'label' => esc_html__('Russian Ruble (RUB)', 'traveler')
                    ], [
                        'value' => 'sar',
                        'label' => esc_html__('Saudi riyal (SAR)', 'traveler')
                    ], [
                        'value' => 'sek',
                        'label' => esc_html__('Swedish krona (SEK)', 'traveler')
                    ], [
                        'value' => 'sgd',
                        'label' => esc_html__('Singapore Dollar (SGD)', 'traveler')
                    ], [
                        'value' => 'thb',
                        'label' => esc_html__('Thai Baht (THB)', 'traveler')
                    ], [
                        'value' => 'try',
                        'label' => esc_html__('Turkish lira (TRY)', 'traveler')
                    ], [
                        'value' => 'uah',
                        'label' => esc_html__('Ukrainian Hryvnia (UAH)', 'traveler')
                    ], [
                        'value' => 'usd',
                        'label' => esc_html__('US Dollar (USD)', 'traveler')
                    ], [
                        'value' => 'vnd',
                        'label' => esc_html__('Vietnamese dong (VND)', 'traveler')
                    ], [
                        'value' => 'xof',
                        'label' => esc_html__('CFA Franc (XOF)', 'traveler')
                    ], [
                        'value' => 'zar',
                        'label' => esc_html__('South African Rand (ZAR)', 'traveler')
                    ],
                ],
                'section' => 'option_api_update',
                'std' => 'usd',
                'condition' => 'bookingdc_iframe:is(off)',
            ],
            //Expedia
            [
                'id' => 'expedia_option',
                'label' => esc_html__('Expedia', 'traveler'),
                'type' => 'tab',
                'section' => 'option_api_update',
            ],
            [
                'id' => 'expedia_iframe_code',
                'label' => __('Search form code', 'traveler'),
                'desc' => __('Enter your search box code from expedia', 'traveler'),
                'type' => 'textarea-simple',
                'rows' => '4',
                'section' => 'option_api_update',
            ],
        ]);
    }

    public function __searchSettings()
    {
        $choices = get_list_posttype();

        return [/* ------------- Search Option ----------------- */
            [
                'id' => 'search_results_view',
                'label' => __('Select default search result layout', 'traveler'),
                'type' => 'select',
                'section' => 'option_search',
                'desc' => __('List view or Grid view', 'traveler'),
                'choices' => [
                    [
                        'value' => 'list',
                        'label' => __('List view', 'traveler')
                    ],
                    [
                        'value' => 'grid',
                        'label' => __('Grid view', 'traveler')
                    ],
                ]
            ],
            [
                'id' => 'search_tabs',
                'label' => __('Display searching tabs', 'traveler'),
                'desc' => __('Search Tabs on home page', 'traveler'),
                'type' => 'list-item',
                'section' => 'option_search',
                'settings' => [
                    [
                        'id' => 'check_tab',
                        'label' => __('Show tab', 'traveler'),
                        'type' => 'on-off',
                    ],
                    [
                        'id' => 'tab_icon',
                        'label' => __('Icon', 'traveler'),
                        'type' => 'text',
                        'desc' => __('This allows you to change icon next to the title', 'traveler')
                    ],
                    [
                        'id' => 'tab_search_title',
                        'label' => __('Form Title', 'traveler'),
                        'type' => 'text',
                        'desc' => __('This allows you to change the text above the form', 'traveler')
                    ],
                    [
                        'id' => 'tab_name',
                        'label' => __('Choose Tab', 'traveler'),
                        'type' => 'select',
                        'choices' => [
                            [
                                'value' => 'hotel',
                                'label' => __('Hotel', 'traveler')
                            ],
                            [
                                'value' => 'rental',
                                'label' => __('Rental', 'traveler')
                            ],
                            [
                                'value' => 'tour',
                                'label' => __('Tour', 'traveler')
                            ],
                            [
                                'value' => 'cars',
                                'label' => __('Car', 'traveler')
                            ],
                            [
                                'value' => 'activities',
                                'label' => __('Activities', 'traveler')
                            ],
                            [
                                'value' => 'hotel_room',
                                'label' => __('Room', 'traveler')
                            ],
                            [
                                'value' => 'flight',
                                'label' => __('Flight', 'traveler')
                            ],
                            [
                                'value' => 'all_post_type',
                                'label' => __('All Post Type', 'traveler')
                            ],
                            [
                                'value' => 'tp_flight',
                                'label' => esc_html__('TravelPayouts Flight', 'traveler')
                            ],
                            [
                                'value' => 'tp_hotel',
                                'label' => esc_html__('TravelPayout Hotel', 'traveler')
                            ],
                            [
                                'value' => 'car_transfer',
                                'label' => esc_html__('Car Transfer', 'traveler')
                            ],
                            [
                                'value' => 'bookingdc',
                                'label' => esc_html__('Booking.com', 'traveler')
                            ],
                            [
                                'value' => 'expedia',
                                'label' => esc_html__('Expedia', 'traveler')
                            ],
                        ]
                    ],
                    [
                        'id' => 'tab_html_custom',
                        'label' => __('Use HTML bellow', 'traveler'),
                        'type' => 'textarea-simple',
                        'rows' => 7,
                        'desc' => __('This allows you to do short code or HTML', 'traveler')
                    ],
                ],
                'std' => [
                    [
                        'title' => 'Hotel',
                        'check_tab' => 'on',
                        'tab_icon' => 'fa-building-o',
                        'tab_search_title' => 'Search and Save on Hotels',
                        'tab_name' => 'hotel'
                    ],
                    [
                        'title' => 'Cars',
                        'check_tab' => 'on',
                        'tab_icon' => 'fa-car',
                        'tab_search_title' => 'Search for Cheap Rental Cars',
                        'tab_name' => 'cars'
                    ],
                    [
                        'title' => 'Tours',
                        'check_tab' => 'on',
                        'tab_icon' => 'fa-flag-o',
                        'tab_search_title' => 'Tours',
                        'tab_name' => 'tour'
                    ],
                    [
                        'title' => 'Rentals',
                        'check_tab' => 'on',
                        'tab_icon' => 'fa-home',
                        'tab_search_title' => 'Find Your Perfect Home',
                        'tab_name' => 'rental'
                    ],
                    [
                        'title' => 'Activity',
                        'check_tab' => 'on',
                        'tab_icon' => 'fa-bolt',
                        'tab_search_title' => 'Find Your Perfect Activity',
                        'tab_name' => 'activities'
                    ],
                ]
            ],
            [
                'id' => 'all_post_type_search_result_page',
                'label' => __('Select page display search results for all services', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_search',
            ],
            [
                'id' => 'all_post_type_search_fields',
                'label' => __('Custom search form for all services', 'traveler'),
                'desc' => __('Custom search form for all services', 'traveler'),
                'type' => 'list-item',
                'section' => 'option_search',
                'settings' => [
                    [
                        'id' => 'field_search',
                        'label' => __('Field Type', 'traveler'),
                        'type' => 'select',
                        'operator' => 'and',
                        'choices' => [
                            [
                                'value' => 'address',
                                'label' => __('Address', 'traveler')
                            ],
                            [
                                'value' => 'item_name',
                                'label' => __('Name', 'traveler')
                            ],
                            [
                                'value' => 'post_type',
                                'label' => __('Post Type', 'traveler')
                            ],
                        ]
                    ],
                    [
                        'id' => 'placeholder',
                        'label' => __('Placeholder', 'traveler'),
                        'desc' => __('Placeholder', 'traveler'),
                        'type' => 'text',
                        'operator' => 'and',
                    ],
                    [
                        'id' => 'layout_col',
                        'label' => __('Layout 1 size', 'traveler'),
                        'type' => 'select',
                        'operator' => 'and',
                        'choices' => [
                            [
                                'value' => '1',
                                'label' => __('column 1', 'traveler')
                            ],
                            [
                                'value' => '2',
                                'label' => __('column 2', 'traveler')
                            ],
                            [
                                'value' => '3',
                                'label' => __('column 3', 'traveler')
                            ],
                            [
                                'value' => '4',
                                'label' => __('column 4', 'traveler')
                            ],
                            [
                                'value' => '5',
                                'label' => __('column 5', 'traveler')
                            ],
                            [
                                'value' => '6',
                                'label' => __('column 6', 'traveler')
                            ],
                            [
                                'value' => '7',
                                'label' => __('column 7', 'traveler')
                            ],
                            [
                                'value' => '8',
                                'label' => __('column 8', 'traveler')
                            ],
                            [
                                'value' => '9',
                                'label' => __('column 9', 'traveler')
                            ],
                            [
                                'value' => '10',
                                'label' => __('column 10', 'traveler')
                            ],
                            [
                                'value' => '11',
                                'label' => __('column 11', 'traveler')
                            ],
                            [
                                'value' => '12',
                                'label' => __('column 12', 'traveler')
                            ],
                        ],
                        'std' => 4
                    ],
                    [
                        'id' => 'is_required',
                        'label' => __('Field required', 'traveler'),
                        'type' => 'on-off',
                        'operator' => 'and',
                        'std' => 'on',
                    ],
                ],
                'std' => [
                    [
                        'title' => 'Address',
                        'layout_col' => 12,
                        'field_search' => 'address'
                    ],
                ]
            ],
            [
                'id' => 'search_header_onoff',
                'label' => __('Allow header search', 'traveler'),
                'desc' => __('Allow header search', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_search',
                'std' => 'on'
            ],
            [
                'id' => 'search_header_orderby',
                'label' => __('Header search - Order by', 'traveler'),
                'type' => 'select',
                'section' => 'option_search',
                'desc' => __('Header search - Order by', 'traveler'),
                'condition' => 'search_header_onoff:is(on)',
                'choices' => [
                    [
                        'value' => 'none',
                        'label' => __('None', 'traveler')
                    ],
                    [
                        'id' => 'setting_partner',
                        'label' => __('Disable user option ', 'traveler'),
                        'section' => 'option_partner',
                        'type' => 'on-off',
                        'desc' => __('ON: Disable partner, OFF: Able partner', 'traveler'),
                        'std' => 'off'
                    ],
                    [
                        'value' => 'ID',
                        'label' => __('ID', 'traveler')
                    ],
                    [
                        'value' => 'author',
                        'label' => __('Author', 'traveler')
                    ],
                    [
                        'value' => 'title',
                        'label' => __('Title', 'traveler')
                    ],
                    [
                        'value' => 'name',
                        'label' => __('Name', 'traveler')
                    ],
                    [
                        'value' => 'date',
                        'label' => __('Date', 'traveler')
                    ],
                    [
                        'value' => 'rand',
                        'label' => __('Random', 'traveler')
                    ],
                ],
            ],
            [
                'id' => 'search_header_order',
                'label' => __('Header search - order', 'traveler'),
                'type' => 'select',
                'section' => 'option_search',
                'desc' => __('Header search - order', 'traveler'),
                'condition' => 'search_header_onoff:is(on)',
                'choices' => [
                    [
                        'value' => 'ASC',
                        'label' => __('ASC', 'traveler')
                    ],
                    [
                        'value' => 'DESC',
                        'label' => __('DESC', 'traveler')
                    ],
                ],
            ],
            [
                'id' => 'search_header_list',
                'label' => __('Header search - Search by', 'traveler'),
                'type' => 'checkbox',
                'section' => 'option_search',
                'desc' => __('Header search - Search by', 'traveler'),
                'condition' => 'search_header_onoff:is(on)',
                'choices' => $choices,
            ],
        ];
    }

    public function __emailPartnerSettings()
    {
        return [/* ------------- Email Partner Template -------------------- */
            [
                'id' => 'tab_partner_email_for_admin',
                'label' => __('[Register] Email For Admin', 'traveler'),
                'type' => 'tab',
                'section' => 'option_email_partner',
            ],
            [
                'id' => 'partner_email_for_admin',
                'label' => __('[Register] Email to administrator', 'traveler'),
                'type' => 'post-select-ajax',
                'desc' => __('Email need approval', 'traveler'),
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_partner',
            ],
            [
                'id' => 'partner_resend_email_for_admin',
                'label' => __('[Register] Resend email to administrator', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_partner',
            ],
            [
                'id' => 'user_register_email_for_admin',
                'label' => __('[Register normal user] Email to administrator', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_partner',
            ],
            [
                'id' => 'tab_partner_email_for_customer',
                'label' => __('[Register] Email Partner', 'traveler'),
                'type' => 'tab',
                'section' => 'option_email_partner',
            ],
            [
                'id' => 'partner_email_for_customer',
                'label' => __('Email to partner (when waiting for approved register)', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_partner',
            ],
            [
                'id' => 'partner_email_approved',
                'label' => __('[Register] Email to partner (when approved register)', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_partner',
            ],
            [
                'id' => 'partner_email_cancel',
                'label' => __('[Register] Email for cancellation', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_partner',
            ],
            [
                'id' => 'tab_withdrawal_email_for_admin',
                'label' => __('[Withdrawal] Email For Admin', 'traveler'),
                'type' => 'tab',
                'section' => 'option_email_partner',
            ],

            [
                'id' => 'send_admin_new_request_withdrawal',
                'label' => __('[Request] Email to administrator request withdrawal', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_partner',
            ],
            [
                'id' => 'send_admin_approved_withdrawal',
                'label' => __('[Approved] Email to administrator request withdrawal', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_partner',
            ],
            [
                'id' => 'tab_withdrawal_email_for_customer',
                'label' => __('[Withdrawal] Email Partner', 'traveler'),
                'type' => 'tab',
                'section' => 'option_email_partner',
            ],
            [
                'id' => 'send_user_new_request_withdrawal',
                'label' => __('[Request] Email to partner withdrawal', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_partner',
            ],

            [
                'id' => 'send_user_approved_withdrawal',
                'label' => __('[Approved] Email to partner withdrawal', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_partner',
            ],

            [
                'id' => 'send_user_cancel_withdrawal',
                'label' => __('[Cancel] Email to partner withdrawal', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_partner',
            ],
            [
                'id' => 'member_packages_tab',
                'label' => __('[Membership] Email For Admin', 'traveler'),
                'type' => 'tab',
                'section' => 'option_email_partner',
            ],
            [
                'id' => 'membership_email_admin',
                'label' => __('Email for admin when have a new membership', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_partner',
            ],
            [
                'id' => 'membership_email_partner',
                'label' => __('Email for partner when have a new membership.', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_partner',
            ],
            /* ------------- End Email Partner Template -------------------- */
        ];
    }

    public function __partnerSettings()
    {
        $member_packages_layout = [
            [
                'id' => '1',
                'alt' => __('Layout 1', 'traveler'),
                'src' => get_template_directory_uri() . '/img/style-1.png',
            ],

        ];
        if (check_using_elementor()) {
            $array_modern = array([
                'id' => '2',
                'alt' => __('Layout 2', 'traveler'),
                'src' => get_template_directory_uri() . '/img/style-2.png',
            ],);
            $member_packages_layout = array_merge($member_packages_layout, $array_modern);
        }

        return [/* ------------- Option Partner Option -------------------- */
            [
                'id' => 'partner_general_tab',
                'label' => __("General Options", 'traveler'),
                'type' => 'tab',
                'section' => 'option_partner',
            ],
            [
                'id' => 'setting_partner',
                'label' => __('User registration option ', 'traveler'),
                'section' => 'option_partner',
                'type' => 'on-off',
                'desc' => __('ON: Allow partner, OFF: Not allow partner', 'traveler'),
                'std' => 'on'
            ],
            [
                'id' => 'patner_page_header_bg',
                'label' => __('Header background', 'traveler'),
                'desc' => __('Header background of the partner page.', 'traveler'),
                'type' => 'upload',
                'section' => 'option_partner'
            ],
            [
                'id' => 'enable_automatic_approval_partner',
                'label' => __('Automatic approval', 'traveler'),
                'desc' => __('Partner be automatic approval (register account).', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'section' => 'option_partner'
            ],
            [
                'id' => 'partner_show_contact_info',
                'label' => __('Show email contact info', 'traveler'),
                'desc' => __('ON: Show email of author(who posts service) in single, email page. OFF: Show email entered in metabox of service', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_partner',
                'std' => 'off',
            ],
            [
                'id' => 'partner_enable_feature',
                'label' => __('Enable Partner Feature', 'traveler'),
                'desc' => __('ON: Show services for partner. OFF: Turn off services, partner is not allowed to register service, it is not displayed in dashboard', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_partner',
                'std' => 'off',
            ],
            [
                'id' => 'partner_post_by_admin',
                'label' => __('Partner\'s post must be approved by admin', 'traveler'),
                'desc' => __('ON: When partner posts a service, it needs to be approved by administrator ', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_partner',
                'std' => 'on'
            ],
            [
                'id' => 'admin_menu_partner',
                'label' => __('Partner menubar', 'traveler'),
                'desc' => __('ON: Turn on partner menubar. OFF: Turn off partner menubar', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_partner',
                'std' => 'off'
            ],
            [
                'id' => 'partner_commission',
                'label' => __('Commission(%)', 'traveler'),
                'desc' => __('Enter commission of partner for admin after each item is booked ', 'traveler'),
                'type' => 'number',
                'min' => 0,
                'max' => 100,
                'step' => 1,
                'section' => 'option_partner',
            ],
            [
                'id' => 'partner_set_feature',
                'label' => __('Partner can set featured', 'traveler'),
                'section' => 'option_partner',
                'type' => 'on-off',
                'desc' => __('It allows partner to set an item to be featured', 'traveler'),
                'std' => 'off'
            ],
            [
                'id' => 'partner_set_external_link',
                'label' => __('Partner can set external link for services', 'traveler'),
                'section' => 'option_partner',
                'type' => 'on-off',
                'desc' => __('It allows partner to set external link for services', 'traveler'),
                'std' => 'off'
            ],
            //1.3.0
            [
                'id' => 'avatar_in_list_service',
                'label' => __('Show avatar user in list services', 'traveler'),
                'section' => 'option_partner',
                'type' => 'on-off',
                'std' => 'off'
            ],
            //
            [
                'id' => 'display_list_partner_info',
                'label' => __("Show contact info of partner", 'traveler'),
                'desc' => __('Display or hide contact information of partner in the partner page', 'traveler'),
                'type' => 'checkbox',
                'section' => 'option_partner',
                'choices' => [
                    [
                        'label' => __('All', 'traveler'),
                        'value' => 'all'
                    ],
                    [
                        'label' => __('Email', 'traveler'),
                        'value' => 'email'
                    ],
                    [
                        'label' => __('Phone', 'traveler'),
                        'value' => 'phone'
                    ],
                    [
                        'label' => __('Email PayPal', 'traveler'),
                        'value' => 'email_paypal'
                    ],
                    [
                        'label' => __('Home Airport', 'traveler'),
                        'value' => 'home_airport'
                    ],
                    [
                        'label' => __('Address', 'traveler'),
                        'value' => 'address'
                    ],
                    [
                        'label' => __('Description', 'traveler'),
                        'value' => 'bio'
                    ]
                ],
                'std' => 'all'
            ],
            [
                'id' => 'membership_tab',
                'label' => __('Membership', 'traveler'),
                'section' => 'option_partner',
                'type' => 'tab'
            ],
            [
                'id' => 'enable_membership',
                'label' => __('Enable Membership', 'traveler'),
                'type' => 'on-off',
                'std' => 'on',
                'section' => 'option_partner',
            ],
            [
                'id' => 'member_packages_layout',
                'label' => __('Member Packages Layout', 'traveler'),
                'desc' => __('Select the layout packages', 'traveler'),
                'type' => 'radio-image',
                'section' => 'option_partner',
                'std' => '1',
                'choices' => $member_packages_layout,
            ],

            [
                'id' => 'member_packages_page',
                'label' => __('Member Packages Page', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'desc' => __('Select a page for member packages page', 'traveler'),
                'section' => 'option_partner'
            ],
            [
                'id' => 'member_checkout_page',
                'label' => __('Member Checkout Page', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'desc' => __('Select a checkout page for member packages', 'traveler'),
                'section' => 'option_partner'
            ],
            [
                'id' => 'member_success_page',
                'label' => __('Member Checkout Success Page', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'desc' => __('Select a checkout success page for member packages', 'traveler'),
                'section' => 'option_partner'
            ],
            [
                'id' => 'partner_custom_layout_tab',
                'label' => __("Layout Dashboard", 'traveler'),
                'type' => 'tab',
                'section' => 'option_partner',
            ],
            [
                'id' => 'partner_custom_layout',
                'label' => __('Configuration partner profile info', 'traveler'),
                'desc' => __('Show/hide sections for partner dashboard', 'traveler'),
                'section' => 'option_partner',
                'type' => 'on-off',
                'std' => 'off'
            ],
            [
                'id' => 'partner_custom_layout_total_earning',
                'label' => __('Show total earning', 'traveler'),
                'type' => 'on-off',
                'desc' => __('ON: Display earnings information in accordance with time periods', 'traveler'),
                'std' => "on",
                'condition' => 'partner_custom_layout:is(on)',
                'section' => 'option_partner'
            ],
            [
                'id' => 'partner_custom_layout_service_earning',
                'label' => __('Show each service earning', 'traveler'),
                'type' => 'on-off',
                'desc' => __('ON: Display earnings according to each service', 'traveler'),
                'std' => "on",
                'condition' => 'partner_custom_layout:is(on)',
                'section' => 'option_partner'
            ],
            [
                'id' => 'partner_custom_layout_chart_info',
                'label' => __('Show chart info', 'traveler'),
                'type' => 'on-off',
                'desc' => __('ON: Display visual graphs to follow your earnings through each time', 'traveler'),
                'std' => "on",
                'condition' => 'partner_custom_layout:is(on)',
                'section' => 'option_partner'
            ],
            [
                'id' => 'partner_custom_layout_booking_history',
                'label' => __('Show booking history', 'traveler'),
                'type' => 'on-off',
                'desc' => __('ON: Show book ing history of partner', 'traveler'),
                'std' => "on",
                'condition' => 'partner_custom_layout:is(on)',
                'section' => 'option_partner'
            ],
            [
                'id' => 'partner_withdrawal_options',
                'label' => __("Withdrawal Options", 'traveler'),
                'type' => 'tab',
                'section' => 'option_partner',
            ],
            [
                'id' => 'enable_withdrawal',
                'label' => __('Allow request withdrawal', 'traveler'),
                'desc' => __('ON: Partner is allowed to withdraw money', 'traveler'),
                'type' => 'on-off',
                'std' => 'on',
                'section' => 'option_partner'
            ],
            [
                'id' => 'partner_withdrawal_payout_price_min',
                'label' => __('Minimum value request when withdrawal', 'traveler'),
                'type' => 'text',
                'section' => 'option_partner',
                'desc' => __('Enter minimum value when a withdrawal is conducted', 'traveler'),
                'std' => '100'
            ],
            [
                'id' => 'partner_date_payout_this_month',
                'label' => __('Date of sucessful payment in current month', 'traveler'),
                'type' => 'text',
                'section' => 'option_partner',
                'desc' => __('Enter the date monthly payment. Ex: 25', 'traveler'),
                'std' => '25'
            ],
            [
                'id' => 'partner_inbox_options',
                'label' => __("Inbox Options", 'traveler'),
                'type' => 'tab',
                'section' => 'option_partner',
            ],
            [
                'id' => 'enable_inbox',
                'label' => __('Allow request inbox', 'traveler'),
                'desc' => __('ON: Partner is allowed to inbox', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'section' => 'option_partner'
            ],
            [
                'id' => 'enable_send_email_partner',
                'label' => __('Allow send to partner', 'traveler'),
                'desc' => __('It allows partner to receive email when there is a new message', 'traveler'),
                'type' => 'on-off',
                'std' => 'on',
                'section' => 'option_partner'
            ],
            [
                'id' => 'enable_send_email_buyer',
                'label' => __('Allow send to buyer', 'traveler'),
                'desc' => __('It allows users to receive email when there is a new message', 'traveler'),
                'type' => 'on-off',
                'std' => 'on',
                'section' => 'option_partner'
            ],
            /* ------------- End Option Partner Option -------------------- */
        ];
    }

    public function __tourModernSettings()
    {
        return [
            [
                'id' => 'tour_modern_general',
                'type' => 'tab',
                'label' => __('General Options', 'traveler'),
                'section' => 'option_tour_modern',
            ],
            [
                'id' => 'tour_modern_topbar_menu',
                'label' => __('Topbar menu options', 'traveler'),
                'type' => 'list-item',
                'section' => 'option_tour_modern',
                'desc' => __('Select topbar item shown in topbar', 'traveler'),
                'settings' => [
                    [
                        'id' => 'topbar_item',
                        'label' => __('Item', 'traveler'),
                        'type' => 'select',
                        'desc' => __('Select item', 'traveler'),
                        'choices' => [
                            [
                                'value' => 'login',
                                'label' => __('Login', 'traveler')
                            ],
                            [
                                'value' => 'currency',
                                'label' => __('Currency', 'traveler')
                            ],
                            [
                                'value' => 'language',
                                'label' => __('Language', 'traveler')
                            ],
                            [
                                'value' => 'link',
                                'label' => __('Custom Link', 'traveler')
                            ],
                        ]
                    ],
                    [
                        'id' => 'topbar_custom_link',
                        'label' => __('Link', 'traveler'),
                        'type' => 'text',
                        'condition' => 'topbar_item:is(link)'
                    ],
                    [
                        'id' => 'topbar_custom_link_title',
                        'label' => __('Title Link', 'traveler'),
                        'type' => 'text',
                        'condition' => 'topbar_item:is(link)'
                    ],
                    [
                        'id' => 'topbar_custom_link_icon',
                        'label' => __('Icon', 'traveler'),
                        'type' => 'upload',
                        'condition' => 'topbar_item:is(link)'
                    ],
                    [
                        'id' => 'topbar_position',
                        'label' => __('Position', 'traveler'),
                        'type' => 'select',
                        'choices' => [
                            [
                                'value' => 'left',
                                'label' => __('Left', 'traveler')
                            ],
                            [
                                'value' => 'right',
                                'label' => __('Right', 'traveler')
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function __hotelAloneSettings()
    {
        return [/* ----------- Hotel Alone Options-------------- */
            /* ----------------Begin Header -------------------- */

            [
                'id' => 'hotel_alone_general_setting',
                'label' => esc_html__('General Options', 'traveler'),
                'type' => 'tab',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'st_room_taxonomy',
                'label' => __('Room taxonomy', 'traveler'),
                'type' => 'term_image',
                'section' => 'option_hotel_alone',
                'std' => ''
            ],
            [
                'id' => 'hotel_alone_assign_hotel',
                'label' => __('Select Single Hotel', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_hotel',
                'sparam' => 'posttype_select',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'hotel_alone_logo',
                'label' => __('Logo options', 'traveler'),
                'desc' => __('To change logo', 'traveler'),
                'type' => 'upload',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'hotel_alone_logo_light',
                'label' => __('Logo Light options', 'traveler'),
                'desc' => __('To change logo', 'traveler'),
                'type' => 'upload',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'st_hotel_activity_topbar_contact_number',
                'label' => esc_html__('Contact Number', 'traveler'),
                'type' => 'text',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'st_hotel_alone_main_color',
                'label' => __('Main Color', 'traveler'),
                'desc' => __('To change the main color for web', 'traveler'),
                'type' => 'colorpicker',
                'section' => 'option_hotel_alone',
                'std' => '#ed8323',
            ],
            [
                'id' => 'st_hotel_alone_footer_page',
                'label' => __('Select footer page', 'traveler'),
                'desc' => __('Select the page to display as footer', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'st_hotel_alone_room_search_page',
                'label' => __('Select room search page', 'traveler'),
                'desc' => __('Select the page to display room result', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'st_hotel_alone_list_of_rooms_page',
                'label' => __('Select list of rooms page', 'traveler'),
                'desc' => __('Select the page to display list of rooms ', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'st_hotel_alone_room_search_page_number',
                'label' => __('Number of posts per page room list', 'traveler'),
                'type' => 'text',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'st_hotel_alone_max_adult',
                'label' => __('Maximum number of adult in form search', 'traveler'),
                'type' => 'text',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'st_hotel_alone_max_child',
                'label' => __('Maximum number of children in form search', 'traveler'),
                'type' => 'text',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'st_hotel_alone_directly_book_now',
                'label' => esc_html__('Booking directly in room list page', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'st_hotel_alone_single_blog',
                'label' => esc_html__('Turn on/of single blog', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'st_hotel_alone_tax_in_room_page',
                'label' => __('Select taxonomy in page list of rooms', 'traveler'),
                'type' => 'st_select_tax',
                'post_type' => 'hotel_room',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'st_hotel_alone_tax_in_room_details',
                'label' => __('Select taxonomy in room detail page', 'traveler'),
                'type' => 'checkbox',
                'section' => 'option_hotel_alone',
                'choices' => st_get_post_taxonomy('hotel_room')
            ],
            [
                'id' => 'st_hotel_alone_blog_list_style',
                'label' => esc_html__('Blog style', 'traveler'),
                'section' => 'option_hotel_alone',
                'type' => 'select',
                'choices' => [
                    [
                        'value' => 'list',
                        'label' => esc_html__('List', 'traveler'),
                    ],
                    [
                        'value' => 'grid',
                        'label' => esc_html__('Grid', 'traveler'),
                    ],
                ]
            ],
            [
                'id' => 'st_hotel_alone_social_facebook_url',
                'label' => __('Sidebar: Facebook URL', 'traveler'),
                'type' => 'text',
                'desc' => __('Example: https://example.com', 'traveler'),
                'std' => '',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'st_hotel_alone_social_instagram_url',
                'label' => __('Sidebar: Instagram URL', 'traveler'),
                'type' => 'text',
                'desc' => __('Example: https://example.com', 'traveler'),
                'std' => '',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'st_hotel_alone_social_twitter_url',
                'label' => __('Sidebar: Twitter URL', 'traveler'),
                'type' => 'text',
                'desc' => __('Example: https://example.com', 'traveler'),
                'std' => '',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'hotel_alone_menu_setting',
                'label' => esc_html__('Menu Options', 'traveler'),
                'type' => 'tab',
                'section' => 'option_hotel_alone',
            ],
            [
                'id' => 'st_hotel_alone_menu_location',
                'label' => esc_html__('Menu Select', 'traveler'),
                'section' => 'option_hotel_alone',
                'type' => 'post-select-ajax',
                'post_type' => 'nav_menu',
                'sparam' => 'posttype_select',
            ],
            [
                'id' => 'st_hotel_alone_menu_position',
                'label' => __('Select menu style', 'traveler'),
                'desc' => __('Select  styles of menu ( it is default as style 1)', 'traveler'),
                'type' => 'radio-image',
                'section' => 'option_hotel_alone',
                'std' => 'menu-center',
                'choices' => [
                    [
                        'id' => 'menu-center',
                        'alt' => __('Default', 'traveler'),
                        'src' => get_template_directory_uri() . '/img/singlemenu.jpg'
                    ],
                    [
                        'id' => 'menu-left',
                        'alt' => __('Menu Left', 'traveler'),
                        'src' => get_template_directory_uri() . '/img/nav6.png'
                    ],
                    [
                        'id' => 'menu-style-3',
                        'alt' => __('Menu Style 3', 'traveler'),
                        'src' => get_template_directory_uri() . '/img/nav_sinhotel.png'
                    ],
                ],
            ],
            /* ----------- End Hotel Alone Options-------------- */
        ];
    }

    public function __carsTransferSettings()
    {
        return [
            [
                'id' => 'car_transfer_search_page',
                'label' => __('Select page to show search results for transfer', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_car_transfer',
            ],
        ];
    }

    public function __activitySettings()
    {
        return [/* ------------- Activity Option  ----------------- */

            [
                'id' => 'activity_search_result_page',
                'label' => __('Activity Search Result Page', 'traveler'),
                'desc' => __('Select page to show search results for activity', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_activity',
            ],
            [
                'id' => 'activity_posts_per_page',
                'label' => __('Items per page', 'traveler'),
                'desc' => __('Number of items on a activity results search page', 'traveler'),
                'type' => 'number',
                'max' => 50,
                'min' => 1,
                'step' => 1,
                'section' => 'option_activity',
                'std' => '12'
            ],
            [
                'id' => 'activity_review',
                'label' => __('Review options', 'traveler'),
                'desc' => __('ON: Turn on the mode for reviewing activity', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_activity',
                'std' => 'on'
            ],
            [
                'id' => 'activity_information_contact',
                'label' => __(' Show information contact', 'traveler'),
                'desc' => __('ON: Show information contact box in sidebar single activity', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_activity',
                'std' => 'on'
            ],
            [
                'id' => 'activity_review_stats',
                'label' => __('Review criteria', 'traveler'),
                'desc' => __('You can add, sort review criteria for activity', 'traveler'),
                'type' => 'list-item',
                'section' => 'option_activity',
                'condition' => 'activity_review:is(on)',
                'settings' => [
                    [
                        'id' => 'name',
                        'label' => __('Stat Name', 'traveler'),
                        'type' => 'text',
                        'operator' => 'and',
                    ]
                ],
                'std' => [
                    ['title' => 'Sleep'],
                    ['title' => 'Location'],
                    ['title' => 'Service'],
                    ['title' => 'Cleanliness'],
                    ['title' => 'Room(s)'],
                ]
            ],
            [
                'id' => 'is_featured_search_activity',
                'label' => __('Show featured activities on top of search result', 'traveler'),
                'desc' => __('ON: Show featured activities on top of default result search page', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'section' => 'option_activity'
            ],
            [
                'id' => 'attribute_search_form_activity',
                'label' => __('Advance search', 'traveler'),
                'type' => 'select',
                'std' => '',
                'choices' => TravelHelper::st_get_attribute_advance('st_activity'),
                'section' => 'option_activity',
            ],
            [
                'id' => 'type_filter_option_attribute',
                'label' => __('Type filter Option Attribute', 'traveler'),
                'type' => 'select',
                'std' => '',
                'choices' => array(
                    [
                        'label' => 'AND',
                        'value' => 'and'
                    ],
                    [
                        'label' => 'OR',
                        'value' => 'or'
                    ]
                ),
                'section' => 'option_activity',
            ],
            [
                'id' => 'st_activity_icon_map_marker',
                'label' => __('Map marker icon', 'traveler'),
                'desc' => __('Select map icon to show service on Map Google', 'traveler'),
                'type' => 'upload',
                'section' => 'option_activity',
                'std' => 'http://maps.google.com/mapfiles/marker_yellow.png'
            ],
            [
                'id' => 'activity_guest_adult',
                'label' => __('Age restriction for Adult', 'traveler'),
                'type' => 'text',
                'section' => 'option_activity',
                'std' => __('Age 18+', 'traveler'),
            ],
            [
                'id' => 'activity_guest_childrent',
                'label' => __('Age restriction for Children', 'traveler'),
                'type' => 'text',
                'section' => 'option_activity',
                'std' => __('Age 6-17', 'traveler'),
            ],
            [
                'id' => 'activity_guest_infant',
                'label' => __('Age restriction for Infant', 'traveler'),
                'type' => 'text',
                'section' => 'option_activity',
                'std' => __('Age 0-5', 'traveler'),
            ],
            [
                'id' => 'icon_duration_single_activity',
                'label' => __('Icon Duration Single Activity', 'traveler'),
                'desc' => __('Example: <i class="lar la-clock"></i> : Link search icon : https://icons8.com/line-awesome', 'traveler'),
                'type' => 'text',
                'section' => 'option_activity',
                'std' => '<i class="lar la-clock"></i>'
            ],
            [
                'id' => 'icon_cancel_single_activity',
                'label' => __('Icon activity cancel single', 'traveler'),
                'desc' => __('Example: <i class="las la-ban"></i> : Link search icon : https://icons8.com/line-awesome', 'traveler'),
                'type' => 'text',
                'section' => 'option_activity',
                'std' => '<i class="las la-ban"></i>'
            ],
            [
                'id' => 'icon_groupsize_single_activity',
                'label' => __('Icon Group Size Single Activity', 'traveler'),
                'desc' => __('Example: <i class="las la-user-friends"></i> : Link search icon : https://icons8.com/line-awesome', 'traveler'),
                'type' => 'text',
                'section' => 'option_activity',
                'std' => '<i class="las la-user-friends"></i>'
            ],
            [
                'id' => 'icon_language_single_activity',
                'label' => __('Icon Language Single Activity', 'traveler'),
                'desc' => __('Example: <i class="las la-language"></i> : Link search icon : https://icons8.com/line-awesome', 'traveler'),
                'type' => 'text',
                'section' => 'option_activity',
                'std' => '<i class="las la-language"></i>'
            ],
            [
                'id' => 'st_show_activity_nearby',
                'label' => esc_html__('Show Activity Nearby', 'traveler'),
                'desc' => esc_html__('ON: Show activity nearby on the map', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'section' => 'option_activity',
            ],
            /* ------------- Activity  Option  ----------------- */
        ];
    }

    public function __tourSettings()
    {
        return [/* ------------- Activity - Tour Option  ----------------- */

            [
                'id' => 'tour_form_fields',
                'label' => __('Setting Form Field(Only use for element [ST] Slider Tour With Search Form style 2)', 'traveler'),
                'desc' => esc_html__('Display fields in the form(Maximum of 4 field)', 'traveler'),
                'type' => 'select_ui',
                'section' => 'option_activity_tour',
                'max_choice' => 4,
                'left_label' => __('Choose form field', 'traveler'),
                'right_label' => __('Show field', 'traveler'),
                'choices' => [
                    [
                        'label' => __('Location', 'traveler'),
                        'value' => 'st_location'
                    ],
                    [
                        'label' => __('Date', 'traveler'),
                        'value' => 'st_date'
                    ],
                    [
                        'label' => __('Guests', 'traveler'),
                        'value' => 'st_guests'
                    ],
                    [
                        'label' => __('Tour Type', 'traveler'),
                        'value' => 'st_tour_type'
                    ],
                    [
                        'label' => __('Duration', 'traveler'),
                        'value' => 'st_duration'
                    ],
                    [
                        'label' => __('Price', 'traveler'),
                        'value' => 'st_price'
                    ],
                ],
                'std' => []
            ],
            [
                'id' => 'activity_tour_review',
                'label' => __('Review options', 'traveler'),
                'desc' => __('ON: Turn on the mode for reviewing tour', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_activity_tour',
                'std' => 'on'
            ],
            [
                'id' => 'tour_information_contact',
                'label' => __(' Show information contact', 'traveler'),
                'desc' => __('ON: Show information contact box in sidebar single tour', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_activity_tour',
                'std' => 'on'
            ],
            [
                'id' => 'tour_review_stats',
                'label' => __('Review criteria', 'traveler'),
                'desc' => __('You can add, sort review criteria for tour', 'traveler'),
                'type' => 'list-item',
                'section' => 'option_activity_tour',
                'condition' => 'activity_tour_review:is(on)',
                'settings' => [
                    [
                        'id' => 'name',
                        'label' => __('Stat Name', 'traveler'),
                        'type' => 'text',
                        'operator' => 'and',
                    ]
                ],
                'std' => [
                    ['title' => 'Sleep'],
                    ['title' => 'Location'],
                    ['title' => 'Service'],
                    ['title' => 'Cleanliness'],
                    ['title' => 'Room(s)'],
                ]
            ],
            [
                'id' => 'tours_search_result_page',
                'label' => __('Tour Search Result Page', 'traveler'),
                'desc' => __('Select page to show search results for tour', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_activity_tour',
            ],

            [
                'id' => 'tour_posts_per_page',
                'label' => __('Items per page', 'traveler'),
                'desc' => __('Number of items on a tour results search page', 'traveler'),
                'type' => 'number',
                'max' => 50,
                'min' => 1,
                'step' => 1,
                'section' => 'option_activity_tour',
                'std' => '12'
            ],
            [
                'id' => 'is_featured_search_tour',
                'label' => __('Show featured tours on top of search result', 'traveler'),
                'desc' => __('ON: Show featured tours on top of default result search page', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'section' => 'option_activity_tour'
            ],
            [
                'id' => 'attribute_search_form_tour',
                'label' => __('Advance search', 'traveler'),
                'type' => 'select',
                'std' => '',
                'choices' => TravelHelper::st_get_attribute_advance('st_tours'),
                'section' => 'option_activity_tour',
            ],
            [
                'id' => 'type_filter_option_attribute_tour',
                'label' => __('Type filter Option Attribute', 'traveler'),
                'type' => 'select',
                'std' => '',
                'choices' => array(
                    [
                        'label' => 'AND',
                        'value' => 'and'
                    ],
                    [
                        'label' => 'OR',
                        'value' => 'or'
                    ]
                ),
                'section' => 'option_activity_tour',
            ],
            [
                'id' => 'st_tours_icon_map_marker',
                'label' => __('Map marker icon', 'traveler'),
                'desc' => __('Select map icon to show service on Map Google', 'traveler'),
                'type' => 'upload',
                'section' => 'option_activity_tour',
                'std' => 'http://maps.google.com/mapfiles/marker_purple.png'
            ],
            [
                'id' => 'tour_guest_adult',
                'label' => __('Age restriction for Adult', 'traveler'),
                'type' => 'text',
                'section' => 'option_activity_tour',
                'std' => __('Age 18+', 'traveler'),
            ],
            [
                'id' => 'tour_guest_childrent',
                'label' => __('Age restriction for Children', 'traveler'),
                'type' => 'text',
                'section' => 'option_activity_tour',
                'std' => __('Age 6-17', 'traveler'),
            ],
            [
                'id' => 'tour_guest_infant',
                'label' => __('Age restriction for Infant', 'traveler'),
                'type' => 'text',
                'section' => 'option_activity_tour',
                'std' => __('Age 0-5', 'traveler'),
            ],
            ['id' => 'tour_package_service_with',
                'label' => __('Accompanied service', 'traveler'),
                'type' => 'text',
                'section' => 'option_activity_tour',
                'std' => __('Hotel, Car, Flight...', 'traveler'),
            ],
            /* ------------- Activity - Tour Option  ----------------- */

            [
                'id' => 'icon_duration_single_tour',
                'label' => __('Icon Duration Single Tour', 'traveler'),
                'desc' => __('Example: <i class="lar la-clock"></i> : Link search icon : https://icons8.com/line-awesome', 'traveler'),
                'type' => 'text',
                'section' => 'option_activity_tour',
                'std' => '<i class="lar la-clock"></i>'
            ],
            [
                'id' => 'icon_tourtype_single_tour',
                'label' => __('Icon Tour Type Single Tour', 'traveler'),
                'desc' => __('Example: <i class="las la-shoe-prints"></i> : Link search icon : https://icons8.com/line-awesome', 'traveler'),
                'type' => 'text',
                'section' => 'option_activity_tour',
                'std' => '<i class="las la-shoe-prints"></i>'
            ],
            [
                'id' => 'icon_groupsize_single_tour',
                'label' => __('Icon Group size Single Tour', 'traveler'),
                'desc' => __('Example: <i class="las la-user-friends"></i> : Link search icon : https://icons8.com/line-awesome', 'traveler'),
                'type' => 'text',
                'section' => 'option_activity_tour',
                'std' => '<i class="las la-user-friends"></i>'
            ],
            [
                'id' => 'icon_language_single_tour',
                'label' => __('Icon Language Single Tour', 'traveler'),
                'desc' => __('Example: <i class="las la-language"></i> : Link search icon : https://icons8.com/line-awesome', 'traveler'),
                'type' => 'text',
                'section' => 'option_activity_tour',
                'std' => '<i class="las la-language"></i>'
            ],
            [
                'id' => 'st_show_tour_nearby',
                'label' => esc_html__('Show Tour Nearby', 'traveler'),
                'desc' => esc_html__('ON: Show tour nearby on the map', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'section' => 'option_activity_tour',
            ],
        ];
    }

    public function __emailTemplateSettings()
    {
        return [/* -------------Email Template ---------------- */

            [
                'id' => 'tab_email_for_admin',
                'label' => __('Email For Admin', 'traveler'),
                'type' => 'tab',
                'section' => 'option_email_template',
            ],

            [
                'id' => 'email_for_admin',
                'label' => __('Email template send to administrator booking.', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_template',
            ],

            [
                'id' => 'tab_email_for_partner',
                'label' => __('Email For Partner', 'traveler'),
                'type' => 'tab',
                'section' => 'option_email_template',
            ],
            [
                'id' => 'email_for_partner',
                'label' => __('Email template send to partner/owner booking.', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_template',
            ],


            //Email to partner when expired date

            [
                'id' => 'email_for_partner_expired_date',
                'label' => __('Email template send to partner when package is expired date', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_template',
            ],

            [
                'id' => 'tab_email_for_customer',
                'label' => __('Email For Customer', 'traveler'),
                'type' => 'tab',
                'section' => 'option_email_template',
            ],

            [
                'id' => 'email_for_customer',
                'label' => __('Email template for booking info send to customer', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_template',
            ],


            //Email to custommer when out of date
            [
                'id' => 'email_for_customer_out_of_depature_date',
                'label' => __('Email template for notification of departure date send to customer', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_template',
            ],

            [
                'id' => 'tab_email_confirm',
                'label' => __('Email Confirm', 'traveler'),
                'type' => 'tab',
                'section' => 'option_email_template',
            ],

            [
                'id' => 'email_confirm',
                'label' => __('Email template for confirm send to customer', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_template',
            ],

            [
                'id' => 'tab_email_approved',
                'label' => __('Email Approved', 'traveler'),
                'type' => 'tab',
                'section' => 'option_email_template',
            ],

            [
                'id' => 'email_approved',
                'label' => __('Email template to admin about item needs to be approved', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_template',
            ],

            [
                'id' => 'tab_email_cancel_booking',
                'label' => __('Email Cancel Booking', 'traveler'),
                'type' => 'tab',
                'section' => 'option_email_template',
            ],
            [
                'id' => 'email_has_refund',
                'label' => __('Email template for cancel booking send to administrator', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_template',
            ],


            [
                'id' => 'email_has_refund_for_partner',
                'label' => __('Email template for cancel booking send to partner', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_template',
            ],


            [
                'id' => 'email_cancel_booking_success_for_partner',
                'label' => __('Email template for successful canceled send to partner', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_template',
            ],


            [
                'id' => 'email_cancel_booking_success',
                'label' => __('Email template for successful canceled send to customer', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'st_template_email',
                'sparam' => 'page',
                'section' => 'option_email_template',
            ],

            /* ------------- End Email Template ---------------- */
        ];
    }

    public function __emailSettings()
    {
        return [
            /* ------------ Begin Email Option -------------- */

            [
                'id' => 'email_from',
                'label' => __('From name', 'traveler'),
                'desc' => __('Email from name', 'traveler'),
                'type' => 'text',
                'section' => 'option_email',
                'std' => 'Traveler Shinetheme'
            ],
            [
                'id' => 'email_from_address',
                'label' => __('From address', 'traveler'),
                'desc' => __('Email from address', 'traveler'),
                'type' => 'text',
                'section' => 'option_email',
                'std' => 'traveler@shinetheme.com'
            ],
            [
                'id' => 'email_logo',
                'label' => __('Select logo in email', 'traveler'),
                'type' => 'upload',
                'section' => 'option_email',
                'desc' => __('Logo in Email', 'traveler'),
                'std' => get_template_directory_uri() . '/img/logo.png'
            ],
            [
                'id' => 'enable_email_for_custommer',
                'label' => __('Email to customer after booking', 'traveler'),
                'desc' => __('Email to customer after booking', 'traveler'),
                'type' => 'on-off',
                'std' => 'on',
                'section' => 'option_email',
            ],
            [
                'id' => 'enable_email_confirm_for_customer',
                'label' => __('Email confirm to customer after booking', 'traveler'),
                'desc' => __('Email confirm to customer after booking', 'traveler'),
                'type' => 'on-off',
                'std' => 'on',
                'section' => 'option_email',
                //'condition' => 'enable_email_for_custommer:is(on)' ,
            ],
            [
                'id' => 'enable_email_for_admin',
                'label' => __('Email to administrator after booking', 'traveler'),
                'desc' => __('Email to administrator after booking', 'traveler'),
                'type' => 'on-off',
                'std' => 'on',
                'section' => 'option_email',
            ],
            [
                'id' => 'email_admin_address',
                'label' => __('Input administrator email', 'traveler'),
                'desc' => __('Booking information will be sent to here', 'traveler'),
                'type' => 'text',
                'condition' => '',
                'section' => 'option_email',
            ],
            [
                'id' => 'enable_email_for_owner_item',
                'label' => __('Email after booking for partner/owner item', 'traveler'),
                'desc' => __('Email after booking for partner/owner item', 'traveler'),
                'type' => 'on-off',
                'std' => 'on',
                'section' => 'option_email',
            ],
            [
                'id' => 'enable_email_approved_item',
                'label' => __('Email template to admin about item needs to be approved', 'traveler'),
                'desc' => __('Email template to admin about item needs to be approved', 'traveler'),
                'type' => 'on-off',
                'std' => 'on',
                'section' => 'option_email',
            ],
            [
                'id' => 'enable_email_cancel',
                'label' => __('Email to administrator when have an cancel booking', 'traveler'),
                'type' => 'on-off',
                'std' => 'on',
                'desc' => __('Email to administrator when have an cancel booking', 'traveler'),
                'section' => 'option_email'
            ],
            [
                'id' => 'enable_partner_email_cancel',
                'label' => __('Email to partner when have an cancel booking', 'traveler'),
                'type' => 'on-off',
                'std' => 'on',
                'desc' => __('Email to partner when have an cancel booking', 'traveler'),
                'section' => 'option_email'
            ],
            [
                'id' => 'enable_email_cancel_success',
                'label' => __('Email to user when booking is cancelled', 'traveler'),
                'type' => 'on-off',
                'std' => 'on',
                'desc' => __('Email to user when booking is cancelled', 'traveler'),
                'section' => 'option_email'
            ],
            /* ------------ End Email Option -------------- */
        ];
    }

    public function __carSettings()
    {
        return [/* ------------- Cars Option ----------------- */

            [
                'id' => 'cars_search_result_page',
                'label' => __('Search Result Page', 'traveler'),
                'desc' => __('Select page to show search results for car', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_car',
            ],

            [
                'id' => 'cars_price_unit',
                'label' => __('Price unit', 'traveler'),
                'desc' => __('The unit to calculate the price of car<br/>Day: The price is calculated according to day<br/>Hour: The price is calculated according to hour<br/>', 'traveler'),
                'type' => 'custom-select',
                'section' => 'option_car',
                'choices' => class_exists('STCars') ? STCars::get_option_price_unit() : [],
                'std' => 'day',
                'v_hint' => 'yes'
            ],

            [
                'id' => 'car_posts_per_page',
                'label' => __('Items per page', 'traveler'),
                'desc' => __('Number of items on a car results search page', 'traveler'),
                'type' => 'number',
                'max' => 50,
                'min' => 1,
                'step' => 1,
                'section' => 'option_car',
                'std' => '12'
            ],
            [
                'id' => 'is_featured_search_car',
                'label' => __('Show featured cars on top of search results', 'traveler'),
                'desc' => __('Show featured cars on top of default result search page', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'section' => 'option_car'
            ],
            [
                'id' => 'attribute_search_form_car',
                'label' => __('Advance search', 'traveler'),
                'type' => 'select',
                'std' => '',
                'choices' => TravelHelper::st_get_attribute_advance('st_cars'),
                'section' => 'option_car',
            ],
            [
                'id' => 'car_review',
                'label' => __('Review options', 'traveler'),
                'desc' => __('ON: Turn on the mode of car review', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_car',
                'std' => 'on'
            ],
            [
                'id' => 'car_information_contact',
                'label' => __(' Show information contact', 'traveler'),
                'desc' => __('ON: Show information contact box in sidebar single car', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_car',
                'std' => 'on'
            ],
            [
                'id' => 'car_review_stats',
                'label' => __('Review criterias', 'traveler'),
                'desc' => __('You can add, sort review criteria for car', 'traveler'),
                'type' => 'list-item',
                'section' => 'option_car',
                'condition' => 'car_review:is(on)',
                'settings' => [
                    [
                        'id' => 'name',
                        'label' => __('Stat Name', 'traveler'),
                        'type' => 'text',
                        'operator' => 'and',
                    ]
                ],
                'std' => [
                    ['title' => 'stat name 1'],
                    ['title' => 'stat name 2'],
                    ['title' => 'stat name 3'],
                    ['title' => 'stat name 4'],
                    ['title' => 'stat name 5'],
                ]
            ],

            [
                'id' => 'st_cars_icon_map_marker',
                'label' => __('Map marker icon', 'traveler'),
                'desc' => __('Select map icon to show car on Map Google', 'traveler'),
                'type' => 'upload',
                'section' => 'option_car',
                'std' => 'http://maps.google.com/mapfiles/marker_green.png'
            ],
            [
                'id' => 'st_show_car_nearby',
                'label' => esc_html__('Show Car Nearby', 'traveler'),
                'desc' => esc_html__('ON: Show car nearby on the map', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'section' => 'option_car',
            ],

            /* ------------ End Car Option -------------- */
        ];
    }

    public function __rentalSettings()
    {
        return [/* ------------- Rental Option ----------------- */
            [
                'id' => 'rental_availability_check',
                'label' => esc_html__('Availability Check', 'traveler'),
                'desc' => esc_html__('Check availability in search results.', 'traveler'),
                'type' => 'on-off',
                'std' => 'on',
                'section' => 'option_rental',
            ],
            [
                'id' => 'rental_search_result_page',
                'label' => __('Select Search Result Page', 'traveler'),
                'desc' => __('Select page to show search results page for rental', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_rental',
            ],
            [
                'id' => 'rental_review',
                'label' => __('Review options', 'traveler'),
                'desc' => __('ON: Turn on review feature for rental', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_rental',
                'std' => 'on'
            ],
            [
                'id' => 'rental_information_contact',
                'label' => __(' Show information contact', 'traveler'),
                'desc' => __('ON: Show information contact box in sidebar single rental', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_rental',
                'std' => 'on'
            ],
            [
                'id' => 'rental_posts_per_page',
                'label' => __('Items per page', 'traveler'),
                'desc' => __('Number of items on a rental results search page', 'traveler'),
                'type' => 'number',
                'max' => 50,
                'min' => 1,
                'step' => 1,
                'section' => 'option_rental',
                'std' => '12'
            ],
            [
                'id' => 'rental_review_stats',
                'label' => __('Rental Review Criteria', 'traveler'),
                'desc' => __('You can add, delete, sort review criteria for rental', 'traveler'),
                'type' => 'list-item',
                'section' => 'option_rental',
                'condition' => 'rental_review:is(on)',
                'settings' => [
                    [
                        'id' => 'name',
                        'label' => __('Stat Name', 'traveler'),
                        'type' => 'text',
                    ]
                ],
                'std' => [
                    ['title' => 'Sleep'],
                    ['title' => 'Location'],
                    ['title' => 'Service'],
                    ['title' => 'Cleanliness'],
                    ['title' => 'Room(s)'],
                ]
            ],
            [
                'id' => 'is_featured_search_rental',
                'label' => __('Show featured rentals on top of search result', 'traveler'),
                'desc' => __('ON: Show featured items on top of default result search page', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'section' => 'option_rental'
            ],
            [
                'id' => 'attribute_search_form_rental',
                'label' => __('Advance search', 'traveler'),
                'type' => 'select',
                'std' => '',
                'choices' => TravelHelper::st_get_attribute_advance('st_rental'),
                'section' => 'option_rental',
            ],
            [
                'id' => 'type_filter_option_attribute_rental',
                'label' => __('Type filter Option Attribute', 'traveler'),
                'type' => 'select',
                'std' => '',
                'choices' => array(
                    [
                        'label' => 'AND',
                        'value' => 'and'
                    ],
                    [
                        'label' => 'OR',
                        'value' => 'or'
                    ]
                ),
                'section' => 'option_rental',
            ],
            [
                'id' => 'st_rental_icon_map_marker',
                'label' => __('Map marker icon', 'traveler'),
                'desc' => __('Select map icon to show rental on Map Google', 'traveler'),
                'type' => 'upload',
                'section' => 'option_rental',
                'std' => 'http://maps.google.com/mapfiles/marker_brown.png'
            ],
            [
                'id' => 'st_show_rental_nearby',
                'label' => esc_html__('Show Rental Nearby', 'traveler'),
                'desc' => esc_html__('ON: Show rental nearby on the map', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'section' => 'option_rental',
            ],
            /* ------------ End Rental Option -------------- */
        ];
    }

    public function __advanceSettings()
    {
        return [
            [
                'id' => 'datetime_format',
                'label' => __('Input date format', 'traveler'),
                'type' => 'custom-text',
                'std' => '{mm}/{dd}/{yyyy}',
                'section' => 'option_advance',
                'desc' => __('The date format, combination of d, dd, mm, yy, yyyy. It is surrounded by <code>\'{}\'</code>. Ex: {dd}/{mm}/{yyyy}.
                <ul>
                <li><code>d, dd</code>: Numeric date, no leading zero and leading zero, respectively. Eg, 5, 05.</li>
                <li><code>m, mm</code>: Numeric month, no leading zero and leading zero, respectively. Eg, 7, 07.</li>
                <li><code>yy, yyyy:</code> 2- and 4-digit years, respectively. Eg, 12, 2012.</li>
                </ul>
                ', 'traveler'),
                'v_hint' => 'yes'
            ],
            [
                'id' => 'time_format',
                'label' => __('Select time format', 'traveler'),
                'type' => 'select',
                'std' => '12h',
                'choices' => [
                    [
                        'value' => '12h',
                        'label' => __('12h', 'traveler')
                    ],
                    [
                        'value' => '24h',
                        'label' => __('24h', 'traveler')
                    ],
                ],
                'section' => 'option_advance',
            ],
            [
                'id' => 'start_week',
                'label' => __('Start Week', 'traveler'),
                'type' => 'select',
                'choices' => [
                    [
                        'value' => '0',
                        'label' => __('Sunday', 'traveler')
                    ],
                    [
                        'value' => '1',
                        'label' => __('Monday', 'traveler')
                    ],
                    [
                        'value' => '2',
                        'label' => __('Tuesday', 'traveler')
                    ],
                    [
                        'value' => '3',
                        'label' => __('Wednesday', 'traveler')
                    ],
                    [
                        'value' => '4',
                        'label' => __('Thursday', 'traveler')
                    ],
                    [
                        'value' => '5',
                        'label' => __('Friday', 'traveler')
                    ],
                    [
                        'value' => '6',
                        'label' => __('Saturday', 'traveler')
                    ],
                ],
                'std' => 0,
                'section' => 'option_advance',
            ],
            [
                'id' => 'adv_before_body_content',
                'label' => __('Inside head tag Content', 'traveler'),
                'desc' => __("Input content before </head> tag.", 'traveler'),
                'type' => 'textarea-simple',
                'section' => 'option_advance',
            ],

            [
                'id' => 'mailchimp_shortcode',
                'label' => __('MailChimp Shortcode Form', 'traveler'),
                'type' => 'text',
                'section' => 'option_advance',
                'std' => '',
            ],

            [
                'id' => 'inquiry_shortcode',
                'label' => __('Inquiry Shortcode Contact Form 7', 'traveler'),
                'type' => 'text',
                'section' => 'option_advance',
                'std' => '',
            ],

        ];
    }



    public function __colibriSettings()
    {
        return [
            /* ------------------- Colibri API ---------------------- */
            [
                'id' => 'colibri_api_option',
                'label' => esc_html__('Traveler PMS', 'traveler'),
                'type' => 'tab',
                'section' => 'option_api_update',
            ],
            [
                'id' => 'cba_enable',
                'label' => esc_html__('Turn on Traveler PMS', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_api_update',
                'std' => 'off'
            ],
            [
                'id' => 'cba_id',
                'label' => esc_html__('Username', 'traveler'),
                'type' => 'text',
                'desc' => esc_html__('Enter your username', 'traveler'),
                'section' => 'option_api_update',
                'condition' => 'cba_enable:is(on)'
            ],
            [
                'id' => 'cba_pw',
                'label' => esc_html__('Password', 'traveler'),
                'type' => 'text',
                'desc' => esc_html__('Enter your password', 'traveler'),
                'section' => 'option_api_update',
                'condition' => 'cba_enable:is(on)'
            ],
            [
                'id' => 'cba_page_list_hotel',
                'label' => __('List hotel page', 'traveler'),
                'desc' => __('Select the page to display list hotel', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_api_update',
                'condition' => 'cba_enable:is(on)'
            ],
            [
                'id' => 'cba_page_detail_hotel',
                'label' => __('Detail hotel page', 'traveler'),
                'desc' => __('Select the page to display detail hotel', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_api_update',
                'condition' => 'cba_enable:is(on)'
            ],
            [
                'id' => 'cba_number_post_list_hotel',
                'label' => __('Number of items in list hotels', 'traveler'),
                'desc' => __('Default number of posts are shown in list hotels page', 'traveler'),
                'type' => 'number',
                'min' => 1,
                'max' => 20,
                'step' => 1,
                'section' => 'option_api_update',
                'std' => 10,
                'condition' => 'cba_enable:is(on)'
            ],
            [
                'id' => 'cba_room_checkout',
                'label' => __('Check out popup form', 'traveler'),
                'desc' => __('Turn on popup form for checkout', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_api_update',
                'std' => 'off',
                'condition' => 'cba_enable:is(on)'
            ],
            [
                'id' => 'cba_page_checkout',
                'label' => __('Checkout page', 'traveler'),
                'desc' => __('Select checkout page', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_api_update',
                'condition' => 'cba_enable:is(on),cba_room_checkout:is(off)'
            ],
            [
                'id' => 'cba_room_gallery_type',
                'label' => __('Select room gallery style', 'traveler'),
                'desc' => __('Choose Grid or Slider room gallery', 'traveler'),
                'type' => 'select',
                'section' => 'option_api_update',
                'condition' => 'cba_enable:is(on)',
                'std' => 'slider',
                'choices' => [
                    [
                        'label' => __('Slider', 'traveler'),
                        'value' => 'slider'
                    ],
                    [
                        'label' => __('Grid', 'traveler'),
                        'value' => 'grid'
                    ]
                ],
            ],
            [
                'id' => 'cba_default_country',
                'label' => __('Select default country', 'traveler'),
                'type' => 'select',
                'section' => 'option_api_update',
                'condition' => 'cba_enable:is(on)',
                'std' => 'PT',
                'choices' => PMS_City_Controller::inst()->getCountryDataOptionTree(),
            ],
            [
                'id' => 'cba_curency',
                'label' => __('Select curency format', 'traveler'),
                'type' => 'select',
                'section' => 'option_api_update',
                'condition' => 'cba_enable:is(on)',
                'std' => '1',
                'choices' => [
                    [
                        'label' => __('$500', 'traveler'),
                        'value' => '1'
                    ],
                    [
                        'label' => __('$ 500', 'traveler'),
                        'value' => '2'
                    ],
                    [
                        'label' => __('500$', 'traveler'),
                        'value' => '3'
                    ],
                    [
                        'label' => __('500 $', 'traveler'),
                        'value' => '4'
                    ],
                ],
            ],
            /* ----------------- End Colibri API -------------------- */
        ];
    }

    public function __hotelCombinedSettings()
    {
        return [
            /* ------------------- HotelsCombined API ---------------------- */
            [
                'id' => 'hotelscb_option',
                'label' => esc_html__('HotelsCombined', 'traveler'),
                'type' => 'tab',
                'section' => 'option_api_update',
            ],
            [
                'id' => 'hotelscb_aff_id',
                'label' => esc_html__('Affiliate ID', 'traveler'),
                'type' => 'text',
                'desc' => esc_html__('Enter your affiliate ID', 'traveler'),
                'section' => 'option_api_update',
            ],
            [
                'id' => 'hotelscb_searchbox_id',
                'label' => esc_html__('Searchbox ID', 'traveler'),
                'type' => 'text',
                'desc' => esc_html__('Enter your search box ID', 'traveler'),
                'section' => 'option_api_update',
            ],
            /* ------------------- HotelsCombined API ---------------------- */
        ];
    }

    public function __bookingdotcomSettings()
    {
        return [
            /* ------------------- Booking.com API ---------------------- */
            [
                'id' => 'bookingdc_option',
                'label' => esc_html__('Booking.com', 'traveler'),
                'type' => 'tab',
                'section' => 'option_api_update',
            ],
            [
                'id' => 'bookingdc_iframe',
                'label' => __('Using iframe search form', 'traveler'),
                'desc' => __('Enable iframe search form', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_api_update',
                'std' => 'on',
            ],
            [
                'id' => 'bookingdc_iframe_code',
                'label' => __('Search form code', 'traveler'),
                'desc' => __('Enter your search box code from booking.com', 'traveler'),
                'type' => 'textarea-simple',
                'rows' => '4',
                'condition' => 'bookingdc_iframe:is(on)',
                'section' => 'option_api_update',
            ],
            [
                'id' => 'bookingdc_aid',
                'label' => __('Your affiliate ID', 'traveler'),
                'desc' => __('Enter your affiliate ID from booking.com', 'traveler'),
                'type' => 'text',
                'condition' => 'bookingdc_iframe:is(off)',
                'section' => 'option_api_update',
            ],
            [
                'id' => 'bookingdc_cname',
                'label' => __('Cname', 'traveler'),
                'desc' => __('Enter your Cname for search box', 'traveler'),
                'type' => 'text',
                'condition' => 'bookingdc_iframe:is(off)',
                'section' => 'option_api_update',
            ],
            [
                'id' => 'bookingdc_lang',
                'label' => esc_html__('Default Language', 'traveler'),
                'type' => 'select',
                'operator' => 'and',
                'choices' => [
                    [
                        'value' => 'ez',
                        'label' => esc_html__('Azerbaijan', 'traveler')
                    ],
                    [
                        'value' => 'ms',
                        'label' => esc_html__('Bahasa Melayu', 'traveler')
                    ],
                    [
                        'value' => 'br',
                        'label' => esc_html__('Brazilian', 'traveler')
                    ],
                    [
                        'value' => 'bg',
                        'label' => esc_html__('Bulgarian', 'traveler')
                    ],
                    [
                        'value' => 'zh',
                        'label' => esc_html__('Chinese', 'traveler')
                    ],
                    [
                        'value' => 'da',
                        'label' => esc_html__('Danish', 'traveler')
                    ],
                    [
                        'value' => 'de',
                        'label' => esc_html__('Deutsch (DE)', 'traveler')
                    ],
                    [
                        'value' => 'en',
                        'label' => esc_html__('English', 'traveler')
                    ],
                    [
                        'value' => 'en-AU',
                        'label' => esc_html__('English (AU)', 'traveler')
                    ],
                    [
                        'value' => 'en-GB',
                        'label' => esc_html__('English (GB)', 'traveler')
                    ],
                    [
                        'value' => 'fr',
                        'label' => esc_html__('French', 'traveler')
                    ],
                    [
                        'value' => 'ka',
                        'label' => esc_html__('Georgian', 'traveler')
                    ],
                    [
                        'value' => 'el',
                        'label' => esc_html__('Greek (Modern Greek)', 'traveler')
                    ],
                    [
                        'value' => 'it',
                        'label' => esc_html__('Italian', 'traveler')
                    ],
                    [
                        'value' => 'ja',
                        'label' => esc_html__('Japanese', 'traveler')
                    ],
                    [
                        'value' => 'lv',
                        'label' => esc_html__('Latvian', 'traveler')
                    ],
                    [
                        'value' => 'pl',
                        'label' => esc_html__('Polish', 'traveler')
                    ],
                    [
                        'value' => 'pt',
                        'label' => esc_html__('Portuguese', 'traveler')
                    ],
                    [
                        'value' => 'ro',
                        'label' => esc_html__('Romanian', 'traveler')
                    ],
                    [
                        'value' => 'ru',
                        'label' => esc_html__('Russian', 'traveler')
                    ],
                    [
                        'value' => 'sr',
                        'label' => esc_html__('Serbian', 'traveler')
                    ],
                    [
                        'value' => 'es',
                        'label' => esc_html__('Spanish', 'traveler')
                    ],
                    [
                        'value' => 'th',
                        'label' => esc_html__('Thai', 'traveler')
                    ],
                    [
                        'value' => 'tr',
                        'label' => esc_html__('Turkish', 'traveler')
                    ],
                    [
                        'value' => 'uk',
                        'label' => esc_html__('Ukrainian', 'traveler')
                    ],
                    [
                        'value' => 'vi',
                        'label' => esc_html__('Vietnamese', 'traveler')
                    ],
                ],
                'section' => 'option_api_update',
                'std' => 'en',
                'condition' => 'bookingdc_iframe:is(off)',
            ],
            [
                'id' => 'bookingdc_currency',
                'label' => esc_html__('Default Currency', 'traveler'),
                'type' => 'select',
                'choices' => [
                    [
                        'value' => 'amd',
                        'label' => esc_html__('UAE dirham (AED)', 'traveler')
                    ],
                    [
                        'value' => 'amd',
                        'label' => esc_html__('Armenian Dram (AMD)', 'traveler')
                    ], [
                        'value' => 'ars',
                        'label' => esc_html__('Argentine peso (ARS)', 'traveler')
                    ], [
                        'value' => 'aud',
                        'label' => esc_html__('Australian Dollar (AUD)', 'traveler')
                    ], [
                        'value' => 'azn',
                        'label' => esc_html__('Azerbaijani Manat (AZN)', 'traveler')
                    ], [
                        'value' => 'bdt',
                        'label' => esc_html__('Bangladeshi taka (BDT)', 'traveler')
                    ], [
                        'value' => 'bgn',
                        'label' => esc_html__('Bulgarian lev (BGN)', 'traveler')
                    ], [
                        'value' => 'brl',
                        'label' => esc_html__('Brazilian real (BRL)', 'traveler')
                    ], [
                        'value' => 'byr',
                        'label' => esc_html__('Belarusian ruble (BYR)', 'traveler')
                    ], [
                        'value' => 'chf',
                        'label' => esc_html__('Swiss Franc (CHF)', 'traveler')
                    ], [
                        'value' => 'clp',
                        'label' => esc_html__('Chilean peso (CLP)', 'traveler')
                    ], [
                        'value' => 'cny',
                        'label' => esc_html__('Chinese Yuan (CNY)', 'traveler')
                    ], [
                        'value' => 'cop',
                        'label' => esc_html__('Colombian peso (COP)', 'traveler')
                    ], [
                        'value' => 'dkk',
                        'label' => esc_html__('Danish krone (DKK)', 'traveler')
                    ], [
                        'value' => 'egp',
                        'label' => esc_html__('Egyptian Pound (EGP)', 'traveler')
                    ], [
                        'value' => 'eur',
                        'label' => esc_html__('Euro (EUR)', 'traveler')
                    ], [
                        'value' => 'gbp',
                        'label' => esc_html__('British Pound Sterling (GBP)', 'traveler')
                    ], [
                        'value' => 'gel',
                        'label' => esc_html__('Georgian lari (GEL)', 'traveler')
                    ], [
                        'value' => 'hkd',
                        'label' => esc_html__('Hong Kong Dollar (HKD)', 'traveler')
                    ], [
                        'value' => 'huf',
                        'label' => esc_html__('Hungarian forint (HUF)', 'traveler')
                    ], [
                        'value' => 'idr',
                        'label' => esc_html__('Indonesian Rupiah (IDR)', 'traveler')
                    ], [
                        'value' => 'inr',
                        'label' => esc_html__('Indian Rupee (INR)', 'traveler')
                    ],
                    [
                        'value' => 'iqd',
                        'label' => esc_html__('Iraqi Dinar (IQD)', 'traveler')
                    ],
                    [
                        'value' => 'jpy',
                        'label' => esc_html__('Japanese Yen (JPY)', 'traveler')
                    ], [
                        'value' => 'kgs',
                        'label' => esc_html__('Som (KGS)', 'traveler')
                    ], [
                        'value' => 'krw',
                        'label' => esc_html__('South Korean won (KRW)', 'traveler')
                    ], [
                        'value' => 'mxn',
                        'label' => esc_html__('Mexican peso (MXN)', 'traveler')
                    ], [
                        'value' => 'myr',
                        'label' => esc_html__('Malaysian ringgit (MYR)', 'traveler')
                    ], [
                        'value' => 'nok',
                        'label' => esc_html__('Norwegian Krone (NOK)', 'traveler')
                    ], [
                        'value' => 'kzt',
                        'label' => esc_html__('Kazakhstani Tenge (KZT)', 'traveler')
                    ], [
                        'value' => 'ltl',
                        'label' => esc_html__('Latvian Lat (LTL)', 'traveler')
                    ], [
                        'value' => 'nzd',
                        'label' => esc_html__('New Zealand Dollar (NZD)', 'traveler')
                    ], [
                        'value' => 'pen',
                        'label' => esc_html__('Peruvian sol (PEN)', 'traveler')
                    ], [
                        'value' => 'php',
                        'label' => esc_html__('Philippine Peso (PHP)', 'traveler')
                    ], [
                        'value' => 'pkr',
                        'label' => esc_html__('Pakistan Rupee (PKR)', 'traveler')
                    ], [
                        'value' => 'pln',
                        'label' => esc_html__('Polish zloty (PLN)', 'traveler')
                    ], [
                        'value' => 'ron',
                        'label' => esc_html__('Romanian leu (RON)', 'traveler')
                    ], [
                        'value' => 'rsd',
                        'label' => esc_html__('Serbian dinar (RSD)', 'traveler')
                    ], [
                        'value' => 'rub',
                        'label' => esc_html__('Russian Ruble (RUB)', 'traveler')
                    ], [
                        'value' => 'sar',
                        'label' => esc_html__('Saudi riyal (SAR)', 'traveler')
                    ], [
                        'value' => 'sek',
                        'label' => esc_html__('Swedish krona (SEK)', 'traveler')
                    ], [
                        'value' => 'sgd',
                        'label' => esc_html__('Singapore Dollar (SGD)', 'traveler')
                    ], [
                        'value' => 'thb',
                        'label' => esc_html__('Thai Baht (THB)', 'traveler')
                    ], [
                        'value' => 'try',
                        'label' => esc_html__('Turkish lira (TRY)', 'traveler')
                    ], [
                        'value' => 'uah',
                        'label' => esc_html__('Ukrainian Hryvnia (UAH)', 'traveler')
                    ], [
                        'value' => 'usd',
                        'label' => esc_html__('US Dollar (USD)', 'traveler')
                    ], [
                        'value' => 'vnd',
                        'label' => esc_html__('Vietnamese dong (VND)', 'traveler')
                    ], [
                        'value' => 'xof',
                        'label' => esc_html__('CFA Franc (XOF)', 'traveler')
                    ], [
                        'value' => 'zar',
                        'label' => esc_html__('South African Rand (ZAR)', 'traveler')
                    ],
                ],
                'section' => 'option_api_update',
                'std' => 'usd',
                'condition' => 'bookingdc_iframe:is(off)',
            ],
            /* ------------------- End Booking.com API ---------------------- */
        ];
    }

    public function __expediaSettings()
    {
        return [
            /* ------------------- Expedia API ---------------------- */
            [
                'id' => 'expedia_option',
                'label' => esc_html__('Expedia', 'traveler'),
                'type' => 'tab',
                'section' => 'option_api_update',
            ],
            [
                'id' => 'expedia_iframe_code',
                'label' => __('Search form code', 'traveler'),
                'desc' => __('Enter your search box code from expedia', 'traveler'),
                'type' => 'textarea-simple',
                'rows' => '4',
                'section' => 'option_api_update',
            ],
            /* ------------------- End Expedia API ---------------------- */
        ];
    }

    public function __pageSettings()
    {
        $page_settings = [
            /* --------------Page Options------------ */

            [
                'id' => 'page_my_account_dashboard',
                'label' => __('Select user dashboard page', 'traveler'),
                'desc' => __('Select the page to display dashboard user page', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_page',
            ],
            [
                'id' => 'page_redirect_to_after_login',
                'label' => __('Redirect page after login', 'traveler'),
                'desc' => __('Select the page to display after users login to the system ', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_page',
            ],
            [
                'id' => 'page_redirect_to_after_logout',
                'label' => __('Redirect page after logout', 'traveler'),
                'desc' => __('Select the page to display after users logout from the system ', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_page',
            ],
            [
                'id' => 'enable_popup_login',
                'label' => esc_html__('Show popup when register', 'traveler'),
                'desc' => esc_html__('Enable/disable login/ register mode in form of popup', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_page',
                'std' => 'off'
            ],
            [
                'id' => 'page_user_login',
                'label' => __('User Login', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_page',
                'condition' => 'enable_popup_login:is(off)'
            ],
            [
                'id' => 'page_user_register',
                'label' => __('User Register', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_page',
                'condition' => 'enable_popup_login:is(off)'
            ],
            [
                'id' => 'page_reset_password',
                'label' => __('Select page for reset password', 'traveler'),
                'desc' => __('Select page for resetting password', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_page',
                'condition' => 'enable_popup_login:is(off)'
            ],
            [
                'id' => 'page_checkout',
                'label' => __('Select page for checkout', 'traveler'),
                'desc' => __('Select page for checkout', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_page',
            ],
            [
                'id' => 'page_payment_success',
                'label' => __('Select page for successfully booking', 'traveler'),
                'desc' => __('Select page for successful booking', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_page',
            ],
            [
                'id' => 'page_order_confirm',
                'label' => __('Order Confirmation Page', 'traveler'),
                'desc' => __('Select page to show booking order', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_page',
            ],
            [
                'id' => 'page_terms_conditions',
                'label' => __('Terms and Conditions Page', 'traveler'),
                'desc' => __('Select page to show Terms and Conditions', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_page',
            ],
            /* [
              'id'        => 'footer_template',
              'label'     => __( 'Footer Page', 'traveler' ),
              'desc'      => __( 'Select page to show Footer', 'traveler' ),
              'type'      => 'post-select-ajax',
              'post_type' => 'page',
              'sparam'    => 'page',
              'section'   => 'option_page',
              ], */
            [
                'id' => 'footer_template_new',
                'label' => __('Modern Footer Page', 'traveler'),
                'desc' => __('Select page to show Modern Footer', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_page',
            ],
            [
                'id' => 'partner_info_page',
                'label' => __('Page for All Author Information(Recommend for Solo Agency)', 'traveler'),
                'desc' => __('When click on all avatar of partner will show that page', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_page',
            ],
            /* --------------End Page Options------------ */
        ];

        return apply_filters('st_settings_page_options', $page_settings);
    }

    public function __blogSettings()
    {
        $blog_settings = [
            [
                'id' => '1',
                'alt' => __('Default', 'traveler'),
                'src' => get_template_directory_uri() . '/img/blog_style_1.png',
            ],
        ];
        if (!check_using_elementor()) {
            $blog_settings[] = [
                'id' => '2', //layouts/modern/blog/content
                'alt' => __('Blog Style solo', 'traveler'),
                'src' => get_template_directory_uri() . '/img/blog_style_2.png',
            ];
        }
        $blog_list_style_modern = apply_filters('st_blog_list_style', $blog_settings);

        //Style single
        $blog_single_settings = [
            [
                'id' => '1',
                'alt' => __('Default', 'traveler'),
                'src' => get_template_directory_uri() . '/img/blog_detail_1.png'
            ],
        ];
        if (!check_using_elementor()) {
            $blog_single_settings[] = [
                'id' => '2', //layouts/modern/blog/content
                'alt' => __('Blog Style solo', 'traveler'),
                'src' => get_template_directory_uri() . '/img/blog_style_2.png',
            ];
        }
        $blog_single_style_modern = apply_filters('st_blog_single_style', $blog_single_settings);


        return [
            /* --------------Blog Options------------ */
            [
                'id' => 'blog_sidebar_pos',
                'label' => __('Sidebar position', 'traveler'),
                'desc' => __('Select the position to show sidebar', 'traveler'),
                'type' => 'select',
                'section' => 'option_blog',
                'choices' => [
                    [
                        'value' => 'no',
                        'label' => __('No', 'traveler')
                    ],
                    [
                        'value' => 'left',
                        'label' => __('Left', 'traveler')
                    ],
                    [
                        'value' => 'right',
                        'label' => __('Right', 'traveler')
                    ]
                ],
                'std' => 'right'
            ],
            [
                'id' => 'blog_sidebar_id',
                'label' => __('Widget position on sidebar', 'traveler'),
                'desc' => __('You can choose from the list', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => '',
                'sparam' => 'sidebar',
                'section' => 'option_blog',
                'std' => 'blog-sidebar',
            ],
            [
                'id' => 'header_blog_image',
                'label' => __('Header Archive Background', 'traveler'),
                'type' => 'upload',
                'section' => 'option_blog',
            ],
            [
                'id' => 'blog_list_style_modern',
                'label' => __('Select Blog list style', 'traveler'),
                'desc' => __('Select styles of blog (it is default as style 1)', 'traveler'),
                'type' => 'radio-image',
                'section' => 'option_blog',
                'std' => '1',
                'choices' => $blog_list_style_modern,
            ],
            [
                'id' => 'blog_single_style_modern',
                'label' => __('Select Blog Single style', 'traveler'),
                'desc' => __('Select styles of blog (it is default as style 1)', 'traveler'),
                'type' => 'radio-image',
                'section' => 'option_blog',
                'std' => '1',
                'choices' => $blog_single_style_modern,
            ]
            /* --------------End Blog Options------------ */
        ];
    }

    public function __bookingSettings()
    {
        $r = [
            /* ------------- Booking Option -------------- */
            [
                'id' => 'booking_tab',
                'label' => __('Booking Options', 'traveler'),
                'type' => 'tab',
                'section' => 'option_booking'
            ],
            // [
            //     'id' => 'booking_modal',
            //     'label' => __('Show popup booking form', 'traveler'),
            //     'desc' => __('Show/hide booking mode with popup form. This option only works when turning off Woocommerce Checkout', 'traveler'),
            //     'type' => 'on-off',
            //     'std' => 'off',
            //     'section' => 'option_booking',
            //     'condition' => 'use_woocommerce_for_booking:is(off)'
            // ],
            [
                'id' => 'caculator_price_single_ajax',
                'label' => __('Show Calculated Ajax Price on Single Service Page', 'traveler'),
                'desc' => __('ON: The price automatically changes when editing the booking conditions in the sidebar', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'section' => 'option_booking',
            ],
            [
                'id' => 'booking_enable_captcha',
                'label' => __('Show captcha', 'traveler'),
                'desc' => __('Enable captcha for booking form. It is applied for normal booking form : link https://www.google.com/recaptcha/admin', 'traveler'),
                'type' => 'on-off',
                'std' => 'on',
                'section' => 'option_booking',
                'desc' => __('Only use for submit form booking', 'traveler'),
            ],
            [
                'id' => 'st_site_key_captcha',
                'label' => __('Site key', 'traveler'),
                'desc' => __('Use this Google reCAPTCHA V3 site key in the HTML code your site serves to users. : https://www.google.com/recaptcha/admin', 'traveler'),
                'type' => 'text',
                'section' => 'option_booking',
                'condition' => 'booking_enable_captcha:is(on)'
            ],
            [
                'id' => 'st_secret_key_captcha',
                'label' => __('Secret key', 'traveler'),
                'desc' => __('Use this secret key for communication between your site and reCAPTCHA', 'traveler'),
                'type' => 'text',
                'section' => 'option_booking',
                'condition' => 'booking_enable_captcha:is(on)'
            ],
            [
                'id' => 'booking_card_accepted',
                'label' => __('Accepted cards', 'traveler'),
                'desc' => __('Add, remove accepted payment cards ', 'traveler'),
                'type' => 'list-item',
                'settings' => [
                    [
                        'id' => 'image',
                        'label' => __('Image', 'traveler'),
                        'desc' => __('Image', 'traveler'),
                        'type' => 'upload'
                    ]
                ],
                'std' => [
                    [
                        'title' => 'Master Card',
                        'image' => get_template_directory_uri() . '/img/card/mastercard.png'
                    ],
                    [
                        'title' => 'JCB',
                        'image' => get_template_directory_uri() . '/img/card/jcb.png'
                    ],
                    [
                        'title' => 'Union Pay',
                        'image' => get_template_directory_uri() . '/img/card/unionpay.png'
                    ],
                    [
                        'title' => 'VISA',
                        'image' => get_template_directory_uri() . '/img/card/visa.png'
                    ],
                    [
                        'title' => 'American Express',
                        'image' => get_template_directory_uri() . '/img/card/americanexpress.png'
                    ],
                ],
                'section' => 'option_booking',
            ],
            [
                'id' => 'booking_currency',
                'label' => __('List of currencies', 'traveler'),
                'desc' => __('Add, remove a kind of currency for payment', 'traveler'),
                'type' => 'list-item',
                'section' => 'option_booking',
                'settings' => [
                    [
                        'id' => 'name',
                        'label' => __('Currency Name', 'traveler'),
                        'type' => 'select',
                        'operator' => 'and',
                        'choices' => TravelHelper::ot_all_currency()
                    ],
                    [
                        'id' => 'symbol',
                        'label' => __('Currency Symbol', 'traveler'),
                        'type' => 'text',
                        'operator' => 'and'
                    ],
                    [
                        'id' => 'rate',
                        'label' => __('Exchange rate', 'traveler'),
                        'type' => 'text',
                        'operator' => 'and',
                        'desc' => __('Exchange rate vs primary currency. Set "1" if it\'s already the primary currency', 'traveler')
                    ],
                    [
                        'id' => 'booking_currency_pos',
                        'label' => __('Currency Position', 'traveler'),
                        'desc' => __('This controls the position of the currency symbol.<br>Ex: $400 or 400 $', 'traveler'),
                        'type' => 'custom-select',
                        'choices' => [
                            [
                                'value' => 'left',
                                'label' => __('Left (£99.99)', 'traveler'),
                            ],
                            [
                                'value' => 'right',
                                'label' => __('Right (99.99£)', 'traveler'),
                            ],
                            [
                                'value' => 'left_space',
                                'label' => __('Left with space (£ 99.99)', 'traveler'),
                            ],
                            [
                                'value' => 'right_space',
                                'label' => __('Right with space (99.99 £)', 'traveler'),
                            ]
                        ],
                        'std' => 'left',
                        'v_hint' => 'yes'
                    ],
                    [
                        'id' => 'currency_rtl_support',
                        'type' => "on-off",
                        'label' => __("This currency is use for RTL languages?", 'traveler'),
                        'std' => 'off'
                    ],
                    [
                        'id' => 'thousand_separator',
                        'label' => __('Thousand Separator', 'traveler'),
                        'type' => 'text',
                        'std' => '.',
                        'desc' => __('Optional. Specifies what string to use for thousands separator.', 'traveler')
                    ],
                    [
                        'id' => 'decimal_separator',
                        'label' => __('Decimal Separator', 'traveler'),
                        'type' => 'text',
                        'std' => ',',
                        'desc' => __('Optional. Specifies what string to use for decimal point', 'traveler')
                    ],
                    [
                        'id' => 'booking_currency_precision',
                        'label' => __('Currency decimal', 'traveler'),
                        'desc' => __('Sets the number of decimal points.', 'traveler'),
                        'type' => 'number',
                        'min' => 0,
                        'max' => 5,
                        'step' => 1,
                        'std' => 2
                    ],
                ],
                'std' => [
                    [
                        'title' => 'USD',
                        'name' => 'USD',
                        'symbol' => '$',
                        'rate' => 1,
                        'booking_currency_pos' => 'left',
                        'thousand_separator' => '.',
                        'decimal_separator' => ',',
                        'booking_currency_precision' => 2,
                    ],
                    [
                        'title' => 'EUR',
                        'name' => 'EUR',
                        'symbol' => '€',
                        'rate' => 0.796491,
                        'booking_currency_pos' => 'left',
                        'thousand_separator' => '.',
                        'decimal_separator' => ',',
                        'booking_currency_precision' => 2,
                    ],
                    [
                        'title' => 'GBP',
                        'name' => 'GBP',
                        'symbol' => '£',
                        'rate' => 0.636169,
                        'booking_currency_pos' => 'right',
                        'thousand_separator' => ',',
                        'decimal_separator' => ',',
                        'booking_currency_precision' => 2,
                    ],
                ]
            ],
            [
                'id' => 'booking_primary_currency',
                'label' => __('Primary Currency', 'traveler'),
                'desc' => __('Select a unit of currency as main currency', 'traveler'),
                'type' => 'select',
                'section' => 'option_booking',
                'choices' => TravelHelper::get_currency(true),
                'std' => 'USD'
            ],
            [
                'id' => 'booking_currency_conversion',
                'label' => __('Currency conversion', 'traveler'),
                'desc' => __('It is used to convert any currency into dollars (USD) when booking in paypal with the currencies having not been supported yet.', 'traveler'),
                'type' => 'list-item',
                'section' => 'option_booking',
                'settings' => [
                    [
                        'id' => 'name',
                        'label' => __('Currency Name', 'traveler'),
                        'type' => 'select',
                        'operator' => 'and',
                        'choices' => TravelHelper::ot_all_currency()
                    ],
                    [
                        'id' => 'rate',
                        'label' => __('Exchange rate', 'traveler'),
                        'type' => 'text',
                        'operator' => 'and',
                        'desc' => __('Exchange rate vs primary currency. Set "1" if it\'s already the primary currency', 'traveler')
                    ],
                ]
            ],
            [
                'id' => 'is_guest_booking',
                'label' => __('Allow guest booking', 'traveler'),
                'desc' => __("Enable/disable this mode to allow users who have not logged in to book", 'traveler'),
                'section' => 'option_booking',
                'type' => 'on-off',
                'std' => 'off'
            ],
            [
                'id' => 'st_booking_enabled_create_account',
                'label' => __('Enable create account option', 'traveler'),
                'desc' => __('Enable create account option in checkout page. Default: Enabled', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'section' => 'option_booking',
                'condition' => 'is_guest_booking:is(on)'
            ],
            array(
                'id' => 'hotel_max_adult',
                'label' => __('Max Adults in search field of Hotel', 'traveler'),
                'desc' => __('Select max adults for search field', 'traveler'),
                'type' => 'text',
                'section' => 'option_booking',
                'std' => 14

            ),
            array(
                'id' => 'hotel_max_child',
                'label' => __('Max Children in search field of Hotel', 'traveler'),
                'desc' => __('Select max children for search field', 'traveler'),
                'type' => 'text',
                'section' => 'option_booking',
                'std' => 14

            ),
            [
                'id' => 'guest_create_acc_required',
                'label' => __('Always create new account after checkout', 'traveler'),
                'desc' => __('This options required input checker "Create new account" for Guest booking ', 'traveler'),
                'section' => 'option_booking',
                'type' => 'on-off',
                'std' => 'off',
                'condition' => 'is_guest_booking:is(on),st_booking_enabled_create_account:is(on)'
            ],
            [
                'id' => 'woocommerce_tab',
                'label' => __('Woocommerce Options', 'traveler'),
                'type' => 'tab',
                'section' => 'option_booking',
            ],
            [
                'id' => 'use_woocommerce_for_booking',
                'section' => 'option_booking',
                'label' => __('Use WooCommerce checkout', 'traveler'),
                'desc' => __('Enable/disable Woocomerce for Booking. If you use single currency, set same currency rate in both Theme Settings > Booking Option > List of currencies and WooCommerces > Settings > General - Currency. If you use multi currencies, install WOOCS - WooCommerce Currency Switcher plugin then set up same currency rate in both Theme Settings > Booking Option > List of currencies and WooCommerces > Settings > Currency. And WOOCS - WooCommerce Currency Switcher free allow 2 currency only', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
            ],
            [
                'id' => 'multi_item_in_cart',
                'section' => 'option_booking',
                'label' => __('Multi item in cart', 'traveler'),
                'desc' => __('If enabled, the customer cannot cancel the booking. Only the admin can cancel the whole order in WPAdmin. If disable multi-item-cart, the customer can cancel the booking in the User Dashboard. ', 'traveler'),
                'type' => 'on-off',
                'condition' => "use_woocommerce_for_booking:is(on)",
                'std' => 'off',
            ],
            [
                'id' => 'woo_checkout_show_shipping',
                'section' => 'option_booking',
                'label' => __('Show Shipping Information', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'condition' => "use_woocommerce_for_booking:is(on)"
            ],
            [
                'id' => 'st_woo_cart_is_collapse',
                'section' => 'option_booking',
                'label' => __('Show Cart item Information collapsed', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'condition' => "use_woocommerce_for_booking:is(on)"
            ],
            [
                'id' => 'tax_tab',
                'label' => __('Tax Options', 'traveler'),
                'type' => 'tab',
                'section' => 'option_booking',
            ],
            [
                'id' => 'tax_enable',
                'label' => __('Enable tax', 'traveler'),
                'desc' => __('Enable/disable the Tax feature. This feature does not support WooCommerce Checkout', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_booking',
                'std' => 'off'
            ],
            [
                'id' => 'st_tax_include_enable',
                'label' => __('Price included tax', 'traveler'),
                'desc' => __('ON: Tax has been included in the price of product - OFF: Tax has not been included in the price of product', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_booking',
                'condition' => 'tax_enable:is(on)',
                'std' => 'off'
            ],
            [
                'id' => 'tax_value',
                'label' => __('Tax value (%)', 'traveler'),
                'desc' => __('Tax percentage', 'traveler'),
                'type' => 'text',
                'section' => 'option_booking',
                'condition' => 'tax_enable:is(on)',
                'std' => 10
            ],
            [
                'id' => 'booking_fee_tab',
                'label' => __('Booking Fee Options', 'traveler'),
                'type' => 'tab',
                'section' => 'option_booking',
            ],
            [
                'id' => 'booking_fee_enable',
                'label' => __('Enable Booking Fee', 'traveler'),
                'desc' => __('Enable/disable the booking fee feature. This feature does not support WooCommerce Checkout', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_booking',
                'std' => 'off'
            ],
            [
                'id' => 'booking_fee_type',
                'label' => __("Fee Type", 'traveler'),
                'type' => 'select',
                'choices' => [
                    [
                        'value' => 'percent',
                        'label' => __('Fee by percent', 'traveler')
                    ],
                    [
                        'value' => 'amount',
                        'label' => __('Fee by amount', 'traveler')
                    ],
                ],
                'section' => 'option_booking',
                'condition' => 'booking_fee_enable:is(on)',
            ],
            [
                'id' => 'booking_fee_amount',
                'label' => __('Fee amount', 'traveler'),
                'desc' => __('Leave empty for disallow booking fee', 'traveler'),
                'type' => 'text',
                'section' => 'option_booking',
                'std' => '0',
                'condition' => 'booking_fee_enable:is(on)',
            ],
            /* ------------- End Booking Option -------------- */
        ];
        if (function_exists('icl_get_languages')) {
            $custom_settings_currency_mapping = [
                [
                    'id' => 'booking_currency_mapping_detect',
                    'label' => __('Auto detect currency by language', 'traveler'),
                    'type' => 'on-off',
                    'section' => 'option_booking',
                    'std' => 'off'
                ],
                [
                    'id' => 'booking_currency_mapping',
                    'label' => __('Mapping currencies', 'traveler'),
                    'desc' => __('Mapping currency with language', 'traveler'),
                    'type' => 'st_mapping_currency',
                    'condition' => 'booking_currency_mapping_detect:is(on)',
                    'section' => 'option_booking',
                    'sdata' => [
                        'langs' => icl_get_languages('skip_missing=0'),
                        'list_currency' => st()->get_option('booking_currency'),
                        'mapping_currency' => get_option('mapping_currency_' . ICL_LANGUAGE_CODE)
                    ]
                ]
            ];
            array_splice($r, 5, 0, $custom_settings_currency_mapping);
        }

        return $r;
    }

    public function __locationSettings()
    {
        return [/* --------------Location options ---------- */
            [
                'id' => 'bc_show_location_tree',
                'label' => __('Build locations by tree structure', 'traveler'),
                'desc' => __('Build locations by tree structure', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_location',
                'std' => 'off'
            ],
            [
                'id' => 'style_location_detail',
                'label' => __("Style location", 'traveler'),
                'desc' => __('Choose style detail location page', 'traveler'),
                'type' => 'select',
                'choices' => [
                    [
                        'value' => 'style_1',
                        'label' => __('Style 1', 'traveler')
                    ],
                    [
                        'value' => 'style_2',
                        'label' => __('Style 2', 'traveler')
                    ],
                ],
                'section' => 'option_location',
                'std' => 'style_1',
                'v_hint' => 'yes'
            ],
            /* --------------End Location options ---------- */
        ];
    }

    public function __reviewSettings()
    {
        return [/* --------------Review Options------------ */

            [
                'id' => 'is_review_must_approved',
                'label' => __('Review approved', 'traveler'),
                'desc' => __('ON: Review must be approved by admin - OFF: Review is automatically approved', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_review',
                'std' => 'off'
            ],
            /* --------------End Review Options------------ */
        ];
    }

    public function __hotelSettings()
    {
        $r = [
            /* ------------- Hotel Option -------------- */
            [
                'id' => 'disable_availability_check',
                'label' => esc_html__('Availability Check', 'traveler'),
                'desc' => esc_html__('ON: Do not check availability in search results.', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'section' => 'option_hotel',
            ],
            [
                'id' => 'distance_for_nearby',
                'label' => esc_html__('Distance to Nearby hotels', 'traveler'),
                'type' => 'text',
                'std' => '25',
                'section' => 'option_hotel',
            ],
            [
                'id' => 'hotel_show_min_price',
                'label' => __("Price show on listing", 'traveler'),
                'desc' => __('AVG: Show average price on results search page <br>MIN: Show minimum price on results search page', 'traveler'),
                'type' => 'custom-select',
                'choices' => [
                    [
                        'value' => 'price_avg',
                        'label' => __('Avg Price', 'traveler')
                    ],
                    [
                        'value' => 'min_price',
                        'label' => __('Min Price', 'traveler')
                    ],
                ],
                'section' => 'option_hotel',
                'v_hint' => 'yes'
            ],
            [
                'id' => 'hotel_search_result_page',
                'label' => __('Hotel search result page', 'traveler'),
                'desc' => __('Select page to show hotel results search page', 'traveler'),
                'type' => 'post-select-ajax',
                'post_type' => 'page',
                'sparam' => 'page',
                'section' => 'option_hotel',
            ],
            [
                'id' => 'hotel_posts_per_page',
                'label' => __('Items per page', 'traveler'),
                'desc' => __('Number of items on a hotel results search page', 'traveler'),
                'type' => 'number',
                'max' => 50,
                'min' => 1,
                'step' => 1,
                'section' => 'option_hotel',
                'std' => '12'
            ],

            [
                'id' => 'hotel_review',
                'label' => __('Review option', 'traveler'),
                'desc' => __('ON: Users can review for hotel  - OFF: User can not review for hotel', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_hotel',
                'std' => 'on'
            ],
            [
                'id' => 'hotel_information_contact',
                'label' => __(' Show information contact', 'traveler'),
                'desc' => __('ON: Show information contact box in sidebar single hotel', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_hotel',
                'std' => 'on'
            ],
            [
                'id' => 'hotel_review_stats',
                'label' => __('Review criterias', 'traveler'),
                'desc' => __('You can add, edit, delete an review criteria for hotel', 'traveler'),
                'type' => 'list-item',
                'section' => 'option_hotel',
                'condition' => 'hotel_review:is(on)',
                'settings' => [
                    [
                        'id' => 'name',
                        'label' => __('Stat Name', 'traveler'),
                        'type' => 'text',
                        'operator' => 'and',
                    ],
                    [
                        'id' => 'icon',
                        'label' => __('Icon review', 'traveler'),
                        'type' => 'upload',
                        'operator' => 'and',
                    ]
                ],
                'std' => [
                    ['title' => 'Sleep'],
                    ['title' => 'Location'],
                    ['title' => 'Service'],
                    ['title' => 'Cleanliness'],
                    ['title' => 'Room(s)'],
                ]
            ],
            [
                'id' => 'is_featured_search_hotel',
                'label' => __('Show featured hotels on top of search result', 'traveler'),
                'desc' => __('ON: Show featured items on top of default result search page', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'section' => 'option_hotel'
            ],
            [
                'id' => 'attribute_search_form_hotel',
                'label' => __('Advance search', 'traveler'),
                'type' => 'select',
                'std' => '',
                'choices' => TravelHelper::st_get_attribute_advance('st_hotel'),
                'section' => 'option_hotel',
            ],
            [
                'id' => 'type_filter_option_attribute_hotel',
                'label' => __('Type filter Option Attribute', 'traveler'),
                'type' => 'select',
                'std' => '',
                'choices' => array(
                    [
                        'label' => 'OR',
                        'value' => 'and'
                    ],
                    [
                        'label' => 'AND',
                        'value' => 'or'
                    ]
                ),
                'section' => 'option_hotel',
            ],
            [
                'id' => 'st_hotel_icon_map_marker',
                'label' => __('Map marker icon', 'traveler'),
                'desc' => __('Select map icon to show service on Map Google', 'traveler'),
                'type' => 'upload',
                'section' => 'option_hotel',
                'std' => 'http://maps.google.com/mapfiles/marker_black.png'
            ],
            [
                'id' => 'st_show_hotel_nearby',
                'label' => esc_html__('Show Hotel Nearby', 'traveler'),
                'desc' => esc_html__('ON: Show hotel nearby on the map', 'traveler'),
                'type' => 'on-off',
                'std' => 'off',
                'section' => 'option_hotel',
            ],
            /* ------------- End Hotel Option -------------- */
        ];
        $taxonomy_hotel = st_get_post_taxonomy('st_hotel');
        if (!empty($taxonomy_hotel)) {
            foreach ($taxonomy_hotel as $k => $v) {
                $terms_hotel = get_terms($v['value']);
                $ids = [];
                if (!empty($terms_hotel)) {
                    foreach ($terms_hotel as $key => $value) {
                        $ids[] = [
                            'value' => $value->term_id . "|" . $value->name,
                            'label' => $value->name,
                        ];
                    }
                    $rt['flied_hotel']['settings'][] = [
                        'id' => 'custom_terms_' . $v['value'],
                        'label' => $v['label'],
                        'condition' => 'name:is(taxonomy),taxonomy:is(' . $v['value'] . ')',
                        'operator' => 'and',
                        'type' => 'checkbox',
                        'choices' => $ids,
                        'desc' => __('It will show all Hotel theme If you don\'t have any choose.', 'traveler'),
                    ];
                    $ids = [];
                }
            }
        }

        return $r;
    }

    public function getAllSettings()
    {
        $allSetings = [
            [
                'id' => 'option_general',
                'title' => __('<i class="fa fa-tachometer"></i> General Options', 'traveler'),
                'settings' => [$this, '__generalSettings']
            ],
            [
                'id' => 'option_style',
                'title' => __('<i class="fa fa-paint-brush"></i> Styling Options', 'traveler'),
                'settings' => [$this, '__styleSettings']
            ],
            [
                'id' => 'option_page',
                'title' => __('<i class="fa fa-file-text"></i> Page Options', 'traveler'),
                'settings' => [$this, '__pageSettings']
            ],
            [
                'id' => 'option_blog',
                'title' => __('<i class="fa fa-bold"></i> Blog Options', 'traveler'),
                'settings' => [$this, '__blogSettings']
            ],
            [
                'id' => 'option_booking',
                'title' => __('<i class="fa fa-book"></i> Booking Options', 'traveler'),
                'settings' => [$this, '__bookingSettings']
            ],
            [
                'id' => 'option_location',
                'title' => __('<i class="fa fa-location-arrow"></i> Location Options', 'traveler'),
                'settings' => [$this, '__locationSettings']
            ],
            [
                'id' => 'option_review',
                'title' => __('<i class="fa fa-comments-o"></i> Review Options', 'traveler'),
                'settings' => [$this, '__reviewSettings']
            ],
            [
                'id' => 'option_hotel',
                'title' => __('<i class="fa fa-building"></i> Hotel Options', 'traveler'),
                'settings' => [$this, '__hotelSettings']
            ],
            [
                'id' => 'option_rental',
                'title' => __('<i class="fa fa-home"></i> Rental Options', 'traveler'),
                'settings' => [$this, '__rentalSettings']
            ],
            [
                'id' => 'option_car',
                'title' => __('<i class="fa fa-car"></i> Car Options', 'traveler'),
                'settings' => [$this, '__carSettings']
            ],
            [
                'id' => 'option_activity_tour',
                'title' => __('<i class="fa fa-suitcase"></i> Tour Options', 'traveler'),
                'settings' => [$this, '__tourSettings']
            ],
            [
                'id' => 'option_activity',
                'title' => __('<i class="fa fa-ticket"></i> Activity Options', 'traveler'),
                'settings' => [$this, '__activitySettings']
            ],
            [
                'id' => 'option_car_transfer',
                'title' => __('<i class="fa fa-car"></i> Transfer Options', 'traveler'),
                'settings' => [$this, '__carsTransferSettings']
            ],
            [
                'id' => 'option_hotel_alone',
                'title' => __('<i class="fa fa-building"></i> Hotel Alone Options', 'traveler'),
                'settings' => [$this, '__hotelAloneSettings']
            ],

            [
                'id' => 'option_partner',
                'title' => __('<i class="fa fa-users"></i> Partner Options', 'traveler'),
                'settings' => [$this, '__partnerSettings']
            ],
            [
                'id' => 'option_email_partner',
                'title' => __('<i class="fa fa-users"></i> Email Partner', 'traveler'),
                'settings' => [$this, '__emailPartnerSettings']
            ],

            [
                'id' => 'option_email',
                'title' => __('<i class="fa fa-envelope"></i> Email Options', 'traveler'),
                'settings' => [$this, '__emailSettings']
            ],
            [
                'id' => 'option_email_template',
                'title' => __('<i class="fa fa-envelope"></i> Email Templates', 'traveler'),
                'settings' => [$this, '__emailTemplateSettings']
            ],
            [
                'id' => 'option_social',
                'title' => __('<i class="fa fa-facebook-official"></i> Social Options', 'traveler'),
                'settings' => [$this, '__socialLoginSettings']
            ],
            [
                'id' => 'option_advance',
                'title' => __('<i class="fa fa-cogs"></i> Advance Options', 'traveler'),
                'settings' => [$this, '__advanceSettings']
            ],
            [
                'id' => 'option_api_update',
                'title' => __('<i class="fa fa-download"></i> Affiliate Configure', 'traveler'),
                'settings' => [$this, '__apiConfigureSettings']
            ],
            [
                'id' => 'option_bc',
                'title' => __('<i class="fa fa-info"></i> Other options', 'traveler'),
                'settings' => [$this, '__otherSettings']
            ],
        ];

        self::$_allSettings = $allSetings;

        return apply_filters('traveler_all_settings', $allSetings);
    }

    public function __styleSettings()
    {
        $array_theme_style = [];
        $theme_style_option = [
            'value' => 'modern',
            'label' => __('Modern', 'traveler')
        ];
        array_push($array_theme_style, $theme_style_option);
        $theme_style = apply_filters('st_theme_style', $array_theme_style);
        $list_menu_style = apply_filters('st_list_menu_style', [
            [
                'id' => '1',
                'alt' => __('Default', 'traveler'),
                'src' => get_template_directory_uri() . '/img/nav3.png'
            ],
            [
                'id' => '2',
                'alt' => __('Transparent', 'traveler'),
                'src' => get_template_directory_uri() . '/img/nav4.png'
            ],
            [
                'id' => '3',
                'alt' => __('Header Lite', 'traveler'),
                'src' => get_template_directory_uri() . '/img/nav5.png'
            ]
        ]);

        if (!check_using_elementor()) {
            $array_modern = array([
                'id' => '4',
                'alt' => __('Header Transparent Tour Style1', 'traveler'),
                'src' => get_template_directory_uri() . '/img/nav7.png'
            ],
                [
                    'id' => '5',
                    'alt' => __('Header Transparent Tour Style2', 'traveler'),
                    'src' => get_template_directory_uri() . '/img/nav8.png'
                ],
                [
                    'id' => '6',
                    'alt' => __('Header Transparent Tour Style3', 'traveler'),
                    'src' => get_template_directory_uri() . '/img/nav9.png'
                ],
                [
                    'id' => '7',
                    'alt' => __('Header Lite Style 2', 'traveler'),
                    'src' => get_template_directory_uri() . '/img/header-style7.png'
                ],
                [
                    'id' => '8', //auto load layout.modern.common.header
                    'alt' => __('Header Style solo', 'traveler'),
                    'src' => get_template_directory_uri() . '/img/header-style8.png' //update lại ảnh
                ]);
            $list_menu_style = array_merge($list_menu_style, $array_modern);
        }
        $array_menu_header_style = apply_filters('st_menu_header_style', $list_menu_style);
        return [
            /* ---- .START STYLE OPTIONS ---- */
            [
                'id' => 'general_style_tab',
                'label' => __('General', 'traveler'),
                'type' => 'tab',
                'section' => 'option_style',
            ],
            [
                'id' => 'st_theme_style',
                'label' => __('Theme style', 'traveler'),
                'desc' => __('Choose style for theme.', 'traveler'),
                'type' => 'select',
                'section' => 'option_style',
                'choices' => $theme_style,
                'std' => 'modern',
            ],
            [
                'id' => 'option_style_page_builder',
                'label' => __('WPBakery Page Builder/Elementor', 'traveler'),
                'desc' => __('Using for build page with Theme style modern. If the website is being built by WPBakery Page Builder then when you select to Elementor, so need build page again. And same to vice versa', 'traveler'),
                'type' => 'select',
                'section' => 'option_style',
                'choices' => [
                    [
                        'value' => 'wp_page_builder',
                        'label' => __('WPBakery Page Builder', 'traveler')
                    ],
                    [
                        'value' => 'elementor',
                        'label' => __('Elementor', 'traveler')
                    ]
                ],
                'std' => 'wp_page_builder',
                'condition' => 'st_theme_style:is(modern)'
            ],
            [
                'id' => 'right_to_left',
                'label' => __('Right to left mode', 'traveler'),
                'desc' => __('Enable "Right to left" displaying mode for content', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_style',
                'output' => '',
                'std' => 'off'
            ],
            [
                'id' => 'typography',
                'label' => __('Typography, Google Fonts', 'traveler'),
                'desc' => __('To change the display of text', 'traveler'),
                'type' => 'typography',
                'section' => 'option_style',
                'output' => 'body',
                'fonts' => st()->get_option('google_fonts')
            ],
            [
                'id' => 'google_fonts',
                'label' => __('Google Fonts', 'traveler'),
                'type' => 'google-fonts',
                'section' => 'option_style',
                'choose' => $this->getGoogleFontsData(),
                'std' => st()->get_option('google_fonts')
            ],
            [
                'id' => 'star_color',
                'label' => __('Star color', 'traveler'),
                'desc' => __('To change the color of star hotel', 'traveler'),
                'type' => 'colorpicker',
                'section' => 'option_style',
            ],
            [
                'id' => 'main_color',
                'label' => __('Main Color', 'traveler'),
                'desc' => __('To change the main color for web', 'traveler'),
                'type' => 'colorpicker',
                'section' => 'option_style',
                'std' => '#1A2B48',
            ],
            [
                'id' => 'body_color',
                'label' => __('Body Color', 'traveler'),
                'desc' => __('To change the body color for web', 'traveler'),
                'type' => 'colorpicker',
                'section' => 'option_style',
                'std' => '#1A232B',
            ],
            [
                'id' => 'heading_color',
                'label' => __('Heading Color', 'traveler'),
                'desc' => __('To change the heading color for web', 'traveler'),
                'type' => 'colorpicker',
                'section' => 'option_style',
                'std' => '#232323',
            ],
            [
                'id' => 'grey_color',
                'label' => __('Grey Color', 'traveler'),
                'desc' => __('To change the grey color for web', 'traveler'),
                'type' => 'colorpicker',
                'section' => 'option_style',
                'std' => '#5E6D77',
            ],
            [
                'id' => 'link_color',
                'label' => __('Link Color', 'traveler'),
                'desc' => __('To change the link color for web', 'traveler'),
                'type' => 'colorpicker',
                'section' => 'option_style',
                'std' => '#5191FA',
            ],
            [
                'id' => 'custom_css',
                'label' => __('CSS custom', 'traveler'),
                'desc' => __('Use CSS Code to customize the interface', 'traveler'),
                'type' => 'css',
                'section' => 'option_style',
            ],
            [
                'id' => 'header_tab',
                'label' => __('Header', 'traveler'),
                'type' => 'tab',
                'section' => 'option_style',
            ],
            [
                'id' => 'banner_transparent',
                'label' => __('Banner transparent', 'traveler'),
                'desc' => __('Banner settings hotel transparent - Header style 4(MOD) only', 'traveler'),
                'type' => 'upload',
                'section' => 'option_style',
            ],
            [
                'id' => 'sort_header_menu',
                'label' => __('Header menu items', 'traveler'),
                'type' => 'list-item',
                'section' => 'option_style',
                'desc' => __('Select  items displaying at the right of main menu', 'traveler'),
                'settings' => [
                    [
                        'id' => 'header_item',
                        'label' => __('Item', 'traveler'),
                        'type' => 'select',
                        'desc' => __('Select header item shown in header right', 'traveler'),
                        'choices' => [
                            [
                                'value' => 'login',
                                'label' => __('Login', 'traveler')
                            ],
                            [
                                'value' => 'currency',
                                'label' => __('Currency', 'traveler')
                            ],
                            [
                                'value' => 'language',
                                'label' => __('Language', 'traveler')
                            ],
                            [
                                'value' => 'search',
                                'label' => __('Search Header', 'traveler')
                            ],
                            [
                                'value' => 'shopping_cart',
                                'label' => __('Shopping Cart', 'traveler')
                            ],
                            [
                                'value' => 'link',
                                'label' => __('Custom Link', 'traveler')
                            ],
                        ]
                    ],
                    [
                        'id' => 'header_custom_link',
                        'label' => __('Link', 'traveler'),
                        'type' => 'text',
                        'condition' => 'header_item:is(link)'
                    ],
                    [
                        'id' => 'header_custom_link_title',
                        'label' => __('Title Link', 'traveler'),
                        'type' => 'text',
                        'condition' => 'header_item:is(link)'
                    ],
                    [
                        'id' => 'header_custom_link_icon',
                        'label' => __('Icon Link', 'traveler'),
                        'type' => 'text',
                        'desc' => __('Enter a Font Awesome icon - Apply for Custom Link Item only', 'traveler'),
                        'condition' => 'header_item:is(link)'
                    ]
                ],
            ],
            [
                'id' => 'menu_bar',
                'label' => __('Menu', 'traveler'),
                'type' => 'tab',
                'section' => 'option_style',
            ],

            [
                'id' => 'menu_style',
                'label' => __('Select menu style', 'traveler'),
                'desc' => __('Select  styles of menu ( it is default as style 1)', 'traveler'),
                'type' => 'radio-image',
                'section' => 'option_style',
                'std' => '1',
                'choices' => [
                    [
                        'id' => '1',
                        'alt' => __('Default', 'traveler'),
                        'src' => get_template_directory_uri() . '/img/nav1.png'
                    ],
                    [
                        'id' => '2',
                        'alt' => __('Logo Center', 'traveler'),
                        'src' => get_template_directory_uri() . '/img/nav2-new.png'
                    ],
                ],
                'condition' => 'st_theme_style:is(classic)'
            ],
            [
                'id' => 'menu_style_modern',
                'label' => __('Select menu style', 'traveler'),
                'desc' => __('Select  styles of menu ( it is default as style 1)', 'traveler'),
                'type' => 'radio-image',
                'section' => 'option_style',
                'std' => '1',
                'choices' => $array_menu_header_style,
                'condition' => 'st_theme_style:is(modern)'
            ],
            [
                'id' => 'menu_transparent',
                'label' => __('Menu transparent', 'traveler'),
                'desc' => __('Enable menu transparent. Apply for style 4 (MOD) only', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_style',
                'condition' => 'menu_style_modern:is(9)',
                'std' => 'on'
            ],
            //Turn On/Off Mega menu
            [
                'id' => 'allow_megamenu',
                'label' => __('Mega menu', 'traveler'),
                'desc' => __('Enable Mega Menu', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_style',
                'std' => 'on',
                'condition' => 'option_style_page_builder:is(wp_page_builder)'

            ],

            [
                'id' => 'top_bar',
                'label' => __('Top Bar', 'traveler'),
                'type' => 'tab',
                'section' => 'option_style',
            ],
            [
                'id' => 'enable_topbar',
                'label' => __('Topbar menu', 'traveler'),
                'desc' => __('On to Enable Top bar ', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_style',
                'std' => 'off',
            ],
            [
                'id' => 'sort_topbar_menu',
                'label' => __('Topbar menu options', 'traveler'),
                'type' => 'list-item',
                'section' => 'option_style',
                'desc' => __('Select topbar item shown in topbar right', 'traveler'),
                'settings' => [
                    [
                        'id' => 'topbar_item',
                        'label' => __('Item', 'traveler'),
                        'type' => 'select',
                        'desc' => __('Select item shown in topbar', 'traveler'),
                        'choices' => [
                            [
                                'value' => 'login',
                                'label' => __('Login', 'traveler')
                            ],
                            [
                                'value' => 'currency',
                                'label' => __('Currency', 'traveler')
                            ],
                            [
                                'value' => 'language',
                                'label' => __('Language', 'traveler')
                            ],
                            [
                                'value' => 'search',
                                'label' => __('Search Topbar', 'traveler')
                            ],
                            [
                                'value' => 'shopping_cart',
                                'label' => __('Shopping Cart', 'traveler')
                            ],
                            [
                                'value' => 'link',
                                'label' => __('Custom Link', 'traveler')
                            ],
                        ]
                    ],
                    [
                        'id' => 'topbar_custom_link',
                        'label' => __('Link', 'traveler'),
                        'type' => 'text',
                        'condition' => 'topbar_item:is(link)'
                    ],
                    [
                        'id' => 'topbar_custom_link_title',
                        'label' => __('Title Link', 'traveler'),
                        'type' => 'text',
                        'condition' => 'topbar_item:is(link)'
                    ],
                    [
                        'id' => 'topbar_custom_link_icon',
                        'label' => __('Icon Link', 'traveler'),
                        'type' => 'text',
                        'desc' => __('Enter a Font Awesome icon - Apply for Custom Link Item only', 'traveler'),
                        'condition' => 'topbar_item:is(link)'
                    ],
                    [
                        'id' => 'topbar_custom_link_target',
                        'label' => __('Open new window', 'traveler'),
                        'type' => 'on-off',
                        'desc' => __('Open new window', 'traveler'),
                        'condition' => 'topbar_item:is(link)'
                    ],
                    [
                        'id' => 'topbar_position',
                        'label' => __('Position', 'traveler'),
                        'type' => 'select',
                        'choices' => [
                            [
                                'value' => 'left',
                                'label' => __('Left', 'traveler')
                            ],
                            [
                                'value' => 'right',
                                'label' => __('Right', 'traveler')
                            ],
                        ],
                    ],
                    [
                        'id' => 'topbar_is_social',
                        'label' => __('is Social Link', 'traveler'),
                        'type' => 'on-off',
                        'std' => 'off'
                    ],
                    [
                        'id' => 'topbar_custom_class',
                        'label' => __('Custom Class', 'traveler'),
                        'type' => 'text',
                        'desc' => __('Add your Custom Class', 'traveler'),
                    ],
                ],
            ],
            [
                'id' => 'hidden_topbar_in_mobile',
                'label' => esc_html__('Hidden topbar in mobile', 'traveler'),
                'desc' => __('Hidden top bar in mobile', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_style',
                'std' => 'on',
                'condition' => 'enable_topbar:is(on)'
            ],
            [
                'id' => 'featured_tab',
                'label' => __('Featured', 'traveler'),
                'type' => 'tab',
                'section' => 'option_style',
            ],
            [
                'id' => 'st_text_featured',
                'label' => __("Feature text", 'traveler'),
                'desc' => __("To change text to display featured content:", 'traveler') . "<br>Example: <br>-  Feature<xmp>- BEST <br><small>CHOICE</small></xmp>",
                'type' => 'custom-text',
                'section' => 'option_style',
                'class' => '',
                'std' => 'Featured',
                'v_hint' => 'yes'
            ],
            [
                'id' => 'st_text_featured_bg',
                'label' => __('Feature background color', 'traveler'),
                'desc' => __('Text color of featured word', 'traveler'),
                'type' => 'colorpicker',
                'section' => 'option_style',
                'class' => '',
                'std' => '#19A1E5',
            ],
            [
                'id' => 'footer_tab',
                'label' => __('Footer', 'traveler'),
                'type' => 'tab',
                'section' => 'option_style',
            ],
            [
                'id' => 'st_text_copyright',
                'label' => __("Copyright Text", 'traveler'),
                'desc' => __("Copyright text", 'traveler'),
                'type' => 'textarea-simple',
                'section' => 'option_style',
                'class' => '',
                'std' => 'Copyright © 2020 by Shinetheme'
            ],
            [
                'id' => 'st_card_accept',
                'label' => __("Card Accept", 'traveler'),
                'desc' => __("Card Accept", 'traveler'),
                'type' => 'upload',
                'section' => 'option_style',
                'class' => '',
                'std' => get_template_directory_uri() . '/v2/images/svg/ico_paymethod.svg'
            ],
            /* ---- ./END STYLE OPTIONS ---- */
        ];
    }

    public function __generalSettings()
    {
        return [
            /* ---- .START GENERAL OPTIONS ---- */
            [
                'id' => 'general_tab',
                'label' => __('General Options', 'traveler'),
                'type' => 'tab',
                'section' => 'option_general',
            ],
            [
                'id' => 'admin_menu_normal_user',
                'label' => __('Normal user adminbar', 'traveler'),
                'desc' => __('Show/hide adminbar for user', 'traveler'),
                'type' => 'on-off',
                'section' => 'option_general',
                'std' => 'off'
            ],
            [
                'id' => 'list_disabled_feature',
                'label' => __('Disable Theme Service Option', 'traveler'),
                'desc' => __('Hide one or many services of theme. In order to disable services (holtel, tour,..) you do not use, please tick the checkbox', 'traveler'),
                'type' => 'checkbox',
                'section' => 'option_general',
                'choices' => [
                    [
                        'label' => __('Hotel', 'traveler'),
                        'value' => 'st_hotel'
                    ],
                    [
                        'label' => __('Car', 'traveler'),
                        'value' => 'st_cars'
                    ],
                    [
                        'label' => __('Rental', 'traveler'),
                        'value' => 'st_rental'
                    ],
                    [
                        'label' => __('Tour', 'traveler'),
                        'value' => 'st_tours'
                    ],
                    [
                        'label' => __('Activity', 'traveler'),
                        'value' => 'st_activity'
                    ]
                ],
            ],
            [
                'id' => 'logo_tab',
                'label' => __('Logo', 'traveler'),
                'type' => 'tab',
                'section' => 'option_general',
            ],
            [
                'id' => 'logo_new',
                'label' => __('Modern Logo', 'traveler'),
                'desc' => __('To change modern logo', 'traveler'),
                'type' => 'upload',
                'section' => 'option_general',
            ],
            [
                'id' => 'logo_dashboard',
                'label' => __('Logo user dashboard', 'traveler'),
                'desc' => __('To change user dashboard logo', 'traveler'),
                'type' => 'upload',
                'section' => 'option_general',
            ],
            [
                'id' => 'logo_retina',
                'label' => __('Retina logo', 'traveler'),
                'desc' => __('Note: You MUST re-name Logo Retina to logo-name@2x.ext-name. Example:<br>
                                    Logo is: <em>my-logo.jpg</em><br>Logo Retina must be: <em>my-logo@2x.jpg</em>  ', 'traveler'),
                'v_hint' => 'yes',
                'type' => 'upload',
                'section' => 'option_general',
                'std' => get_template_directory_uri() . '/img/logo@2x.png'
            ],
            [
                'id' => 'logo_mobile',
                'label' => __('Mobile logo', 'traveler'),
                'type' => 'upload',
                'section' => 'option_general',
                'std' => '',
                "desc" => __("To change logo used for mobile screen", 'traveler')
            ],
            [
                'id' => '404_tab',
                'label' => __('404 Options', 'traveler'),
                'type' => 'tab',
                'section' => 'option_general',
            ],
            [
                'id' => '404_style',
                'label' => __('404 Style Layout', 'traveler'),
                'desc' => __('Select layout to 404 page ', 'traveler'),
                'type' => 'custom-select',
                'section' => 'option_general',
                'choices' => [
                    [
                        'value' => '1',
                        'label' => __('Layout 1', 'traveler')
                    ],
                    [
                        'value' => '2',
                        'label' => __('Layout 2', 'traveler')
                    ],
                ],
                'std' => '1'
            ],
            [
                'id' => '404_text',
                'label' => __('Text of 404 page', 'traveler'),
                'desc' => __('To change text for 404 page', 'traveler'),
                'type' => 'textarea',
                'rows' => '3',
                'section' => 'option_general',
            ],
            [
                'id' => '404_bg_color',
                'label' => __('Background color of 404 page', 'traveler'),
                'desc' => __('To change background color for 404 page', 'traveler'),
                'type' => 'colorpicker',
                'section' => 'option_general',
            ],
            [
                'id' => '404_img',
                'label' => __('Image of 404 page', 'traveler'),
                'desc' => __('To change image for 404 page', 'traveler'),
                'type' => 'upload',
                'section' => 'option_general',
            ],



            /* ---- .END GENERAL OPTIONS ---- */
        ];
    }

    public function __getEmailDocument()
    {
        ob_start();
        echo '<div class="format-setting type-textblock wide-desc">';

        echo '<div class="description">';
        ?>
        <style>
            table {
                border: 1px solid #CCC;
            }

            table tr:not(:last-child) td {
                border-bottom: 1px solid #CCC;
            }

            xmp {
                margin: 0;
            }
        </style>
        <p>
            <?php echo __('From version 1.1.9 you can edit email template for Admin, Partner, Customer by use our shortcodes system with some layout we ready build in. Below is the list shortcodes you can use', 'traveler'); ?>
            :
        </p>
        <h4><?php echo __('List All Shortcode:', 'traveler'); ?></h4>
        <ul>
            <li>
                <h5><?php echo __('Customer Information:', 'traveler'); ?></h5>
                <table width="95%" style="margin-left: 20px;">
                    <tr style="background: #CCC;">
                        <th align="center" width="33.3333%"><?php echo __('Name', 'traveler'); ?></th>
                        <th align="center" width="33.3333%"><?php echo __('Code', 'traveler'); ?></th>
                        <th align="center" width="33.3333%"><?php echo __('Description', 'traveler'); ?></th>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('First Name', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_first_name]</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Last Name', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_last_name]</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Email', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_email]</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Address', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_address]</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Phone Number', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_phone]</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('City', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_city]</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Province', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_province]</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Zipcode', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_zip_code]</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Apt/Unit', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_apt_unit]</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Country', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_country]</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Custom field (ST form builder)', 'traveler'); ?>:</strong>
                        </td>
                        <td>[st_email_booking_custom_field]</td>
                        <td><i>@param 'field_name' 'string'.<br/>
                                Eg: field_name="st_media_upload"</i></td>
                    </tr>
                </table>
            </li>
            <li>
                <h5><?php echo __('Item booking Information', 'traveler'); ?></h5>
                <table width="95%" style="margin-left: 20px;">
                    <tr style="background: #CCC;">
                        <th align="center" width="33.3333%"><?php echo __('Name', 'traveler'); ?></th>
                        <th align="center" width="33.3333%"><?php echo __('Code', 'traveler'); ?></th>
                        <th align="center" width="33.3333%"><?php echo __('Description', 'traveler'); ?></th>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Post type name', 'traveler'); ?></strong></td>
                        <td>[st_email_booking_posttype]</td>
                        <td><em><?php echo __('Show post-type name.', 'traveler'); ?></em></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('ID', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_id]</td>
                        <td>
                            <em><?php echo __('Display the Order ID', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Thumbnail Image', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_thumbnail]</td>
                        <td>
                            <em><?php echo __('Display the product\'s thumbnail image (if have)', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Date', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_date]</td>
                        <td>
                            <em><?php echo __('Display the booking date', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Special Requirements', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_note]</td>
                        <td>
                            <em><?php echo __('Display the information of the \'Special Requirements\' when booking', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Payment Method', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_payment_method]</td>
                        <td>
                            <em><?php echo __('Display the booking method', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Item Name', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_item_name]</td>
                        <td>
                            <em><?php echo __('Display item name of service.', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Item Link', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_item_link]</td>
                        <td>
                            <em><?php echo __('Display the item title with a link under.', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Item Number', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_number_item]</td>
                        <td>
                            <em><?php echo __('Display number of items when booking.', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong><?php echo __('Check In', 'traveler'); ?>:</strong><br/>
                            <strong><?php echo __('Check Out', 'traveler'); ?>:</strong>
                        </td>
                        <td>
                            [st_email_booking_check_in]<br/>
                            [st_email_booking_check_out]<br/>
                            [st_check_in_out_title] <br/>
                            [st_check_in_out_value]
                        </td>
                        <td>
                            <em>
                                1. <?php echo __('Display check in, check out with Hotel and Rental', 'traveler'); ?>
                                <br/>
                                2. <?php echo __('Display Pick-up Date and Drop-off Date with Car', 'traveler'); ?>
                                <br/>
                                3. <?php echo __('Display Departure date and Return date with Tour and Activity', 'traveler'); ?>
                            </em>
                        </td>
                    </tr>
                    <!-- Since 2.0.0 Start Time Order Shortcode -->
                    <tr>
                        <td><strong><?php echo __('Start Time', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_start_time]</td>
                        <td>
                            <em><?php echo __('Display Start Time with Tour', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Item Price', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_item_price]</td>
                        <td>
                            <em><?php echo __('Display item price (not included Tour and Activity)', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Item Origin Price', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_origin_price]</td>
                        <td>
                            <em>
                                <?php echo __('Display original price of the item (not included custom price, sale price and tax)', 'traveler'); ?>
                            </em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Item Sale Price', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_sale_price]</td>
                        <td>
                            <em><?php echo __('Display the sale price.', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Item Tax Price', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_price_with_tax]</td>
                        <td>
                            <em><?php echo __('Display the price with tax.', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Item Deposit Price', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_deposit_price]</td>
                        <td>
                            <em><?php echo __('Display the deposit require. ', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Item Total Price', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_total_price]</td>
                        <td>
                            <em><?php echo __('Display the total price (included sale price and tax).', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Item Tax Percent', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_total_price]</td>
                        <td>
                            <em><?php echo __('Display the total amount payment.', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Item Address', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_item_address]</td>
                        <td>
                            <em><?php echo __('Display the address.', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Item Website', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_item_website]</td>
                        <td>
                            <em><?php echo __('Display the website.', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Item Email', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_item_email]</td>
                        <td>
                            <em><?php echo __('Display the email.', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Item Phone', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_item_phone]</td>
                        <td>
                            <em><?php echo __('Display the phone.', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Item Fax', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_item_fax]</td>
                        <td>
                            <em><?php echo __('Display the fax.', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Booking Status', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_status]</td>
                        <td>
                            <em><?php echo __('Display the booking status.', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Booking Payment method', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_payment_method]</td>
                        <td>
                            <em><?php echo __('Display the booking payment method.', 'traveler'); ?></em>
                        </td>
                    </tr>

                    <tr>
                        <td><strong><?php echo __('Booking Guest Name', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_guest_name]</td>
                        <td>
                            <em><?php echo __('Display the booking guest name.', 'traveler'); ?></em>
                        </td>
                    </tr>

                </table>
            </li>
            <li>
                <h5><?php echo __('Use for Hotel', 'traveler'); ?></h5>
                <table width="95%" style="margin-left: 20px;">
                    <tr style="background: #CCC;">
                        <th align="center" width="33.3333%"><?php echo __('Name', 'traveler'); ?></th>
                        <th align="center" width="33.3333%"><?php echo __('Code', 'traveler'); ?></th>
                        <th align="center" width="33.3333%"><?php echo __('Description', 'traveler'); ?></th>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Room Name', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_room_name]</td>
                        <td>
                            <em>
                                <?php echo __('Display the room name of hotel.', 'traveler'); ?>
                                <br/>
                                @param 'title' 'string'.<br/>
                                <xmp> Eg: title="Room Name"</xmp>
                            </em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Extra Items', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_extra_items]</td>
                        <td>
                            <em><?php echo __('Display all service/facillities inside a room.', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Extra Price', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_extra_price]</td>
                        <td>
                            <em><?php echo __('Display total price of service in room.', 'traveler'); ?></em>
                        </td>
                    </tr>
                </table>
            </li>
            <li>
                <h5><?php echo __('Use for Car', 'traveler'); ?></h5>
                <table width="95%" style="margin-left: 20px;">
                    <tr style="background: #CCC;">
                        <th align="center" width="33.3333%"><?php echo __('Name', 'traveler'); ?></th>
                        <th align="center" width="33.3333%"><?php echo __('Code', 'traveler'); ?></th>
                        <th align="center" width="33.3333%"><?php echo __('Description', 'traveler'); ?></th>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Car Time', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_check_in_out_time]</td>
                        <td>
                            <em>
                                <?php echo __('Display Pick up and Drop off time.', 'traveler'); ?>
                            </em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Car pick up from', 'traveler'); ?>:</strong></td>
                        <td>[st_email_pick_up_from]</td>
                        <td>
                            <em>
                                <?php echo __('Display Pick up from.', 'traveler'); ?>
                            </em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Car Drop off to ', 'traveler'); ?>:</strong></td>
                        <td>[st_email_drop_off_to]</td>
                        <td>
                            <em>
                                <?php echo __('Car Drop off to ', 'traveler'); ?>
                            </em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Car Driver Informations', 'traveler'); ?>:</strong></td>
                        <td>[st_email_car_driver]</td>
                        <td>
                            <em>
                                <?php echo __('Car Driver Informations  ', 'traveler'); ?>
                            </em>
                        </td>
                    </tr>

                    <tr>
                        <td><strong><?php echo __('Car Equipments', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_equipments]</td>
                        <td>
                            <em>
                                <?php echo __('Display equipment list in a car.', 'traveler'); ?>
                                </br />
                                @param 'tag' 'string'.<br/>
                                <xmp> Eg: tag="<h3>"</xmp>
                                <br/>
                                @param 'title' 'string'.<br/>
                                <xmp> Eg: title="Equipments"</xmp>
                            </em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Car Equipments Price', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_equipment_price]</td>
                        <td>
                            <em>
                                <?php echo __('Display total price of equipment in car.', 'traveler'); ?>
                                <br/>
                                @param 'title' 'string'.<br/>
                                <xmp> Eg: title="Equipments Price"</xmp>
                            </em>
                        </td>
                    </tr>

                    <tr>
                        <td><strong><?php echo __('Car Transfer Information', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_car_transfer_info]</td>
                        <td>
                            <em>
                                <?php echo __('Arrival Date', 'traveler'); ?><br/>
                                <?php echo __('Departure Date', 'traveler'); ?><br/>
                                <?php echo __('Passengers', 'traveler'); ?><br/>
                                <?php echo __('Estimated distance', 'traveler'); ?>
                            </em>
                        </td>
                    </tr>
                </table>
            </li>
            <li>
                <h5><?php echo __('Use for Tour and Activity', 'traveler'); ?></h5>
                <table width="95%" style="margin-left: 20px;">
                    <tr style="background: #CCC;">
                        <th align="center" width="33.3333%"><?php echo __('Name', 'traveler'); ?></th>
                        <th align="center" width="33.3333%"><?php echo __('Code', 'traveler'); ?></th>
                        <th align="center" width="33.3333%"><?php echo __('Description', 'traveler'); ?></th>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Adult Information', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_adult_info]</td>
                        <td>
                            <em>
                                <?php echo __('Display info of adult (number and price)', 'traveler'); ?>
                                </br />
                                @param 'title' 'string'.<br/>
                                <xmp> Eg: title="No. Adults"</xmp>
                            </em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Children Information', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_children_info]</td>
                        <td>
                            <em>
                                <?php echo __('Display info of adult (number and price)', 'traveler'); ?>
                                </br />
                                @param 'title' 'string'.<br/>
                                <xmp> Eg: title="No. Children"</xmp>
                            </em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Infant Information', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_infant_info]</td>
                        <td>
                            <em>
                                <?php echo __('Display info of infant  (number and price)', 'traveler'); ?>
                                </br />
                                @param 'title' 'string'.<br/>
                                <xmp> Eg: title="No. Infant"</xmp>
                            </em>
                        </td>
                    </tr>
                </table>
            </li>
            <li>
                <h5><?php echo __('Use for Flight', 'traveler'); ?></h5>
                <table width="95%" style="margin-left: 20px;">
                    <tr>
                        <td><strong><?php echo __('Flight Information', 'traveler'); ?>:</strong></td>
                        <td>[st_email_booking_flight_extra_info]</td>
                        <td></td>
                    </tr>
                </table>
            </li>
            <li>
                <h5><?php echo __('Use for Confirm Email ', 'traveler'); ?></h5>
                <table width="95%" style="margin-left: 20px;">
                    <tr>
                        <td><strong><?php echo __('Confirm Link', 'traveler'); ?></strong></td>
                        <td>[st_email_confirm_link]</td>
                        <td><em><?php echo __('Get confirm email link', 'traveler'); ?></em></td>
                    </tr>
                </table>
            </li>
            <li>
                <h5><?php echo __('Use for Approved Email', 'traveler'); ?></h5>
                <table width="95%" style="margin-left: 20px;">
                    <tr>
                        <td><strong><?php echo __('Account name', 'traveler'); ?></strong></td>
                        <td>[st_approved_email_admin_name]</td>
                        <td>
                            <em><?php echo __('Returns the name of the accounts was approved', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Post type', 'traveler'); ?></strong></td>
                        <td>[st_approved_email_item_type]</td>
                        <td>
                            <em><?php echo __('Returns type is type approved post (Hotel, Rental, Car, ...)', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Item name', 'traveler'); ?></strong></td>
                        <td>[st_approved_email_item_name]</td>
                        <td>
                            <em><?php echo __('Returns the name of the item has been approved', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Item link', 'traveler'); ?></strong></td>
                        <td>[st_approved_email_item_link]</td>
                        <td><em><?php echo __('Returns link to item', 'traveler'); ?></em></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Approval date', 'traveler'); ?></strong></td>
                        <td>[st_approved_email_date]</td>
                        <td><em><?php echo __('Returns the Approval date', 'traveler'); ?></em></td>
                    </tr>
                </table>
            </li>
            <li>
                <h5><?php echo __('MemberShip', 'traveler'); ?></h5>
                <table width="95%" style="margin-left: 20px;">
                    <tr>
                        <td><strong><?php echo __('Partner\'s Name', 'traveler'); ?></strong></td>
                        <td>[st_email_package_partner_name]</td>
                        <td><em><?php echo __('Returns the name of the partner', 'traveler'); ?></em></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Partner\'s Email', 'traveler'); ?></strong></td>
                        <td>[st_email_package_partner_email]</td>
                        <td><em><?php echo __('Returns email of the partner', 'traveler'); ?></em></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Partner\'s Phone', 'traveler'); ?></strong></td>
                        <td>[st_email_package_partner_phone]</td>
                        <td><em><?php echo __('Returns phone number of the partner', 'traveler'); ?></em></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Package Name', 'traveler'); ?></strong></td>
                        <td>[st_email_package_name]</td>
                        <td><em><?php echo __('Returns name of the package', 'traveler'); ?></em></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Package Price', 'traveler'); ?></strong></td>
                        <td>[st_email_package_price]</td>
                        <td><em><?php echo __('Returns price of the package', 'traveler'); ?></em></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Package Commission', 'traveler'); ?></strong></td>
                        <td>[st_email_package_commission]</td>
                        <td><em><?php echo __('Returns commission of the package', 'traveler'); ?></em></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Package Time', 'traveler'); ?></strong></td>
                        <td>[st_email_package_time]</td>
                        <td><em><?php echo __('Returns time available of the package', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Package Item Upload', 'traveler'); ?></strong></td>
                        <td>[st_email_package_upload]</td>
                        <td>
                            <em><?php echo __('Returns number of item uploaded of the package', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Package Item Set Featured', 'traveler'); ?></strong></td>
                        <td>[st_email_package_featured]</td>
                        <td>
                            <em><?php echo __('Returns number of item set featured of the package', 'traveler'); ?></em>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><?php echo __('Package Description', 'traveler'); ?></strong></td>
                        <td>[st_email_package_description]</td>
                        <td><em><?php echo __('Returns description of the package', 'traveler'); ?></em></td>
                    </tr>
                </table>
            </li>
            <li>
                <h5><?php echo __('Invoice', 'traveler'); ?></h5>
                <table width="95%" style="margin-left: 20px;">
                    <tr>
                        <td><strong><?php echo __('Link Download Invoice', 'traveler'); ?></strong></td>
                        <td>[st_email_booking_url_download_invoice]</td>
                        <td><em><?php echo __('Returns link download invoice', 'traveler'); ?></em></td>
                    </tr>
                </table>
            </li>
        </ul>
        <?php
        echo '</div>';

        echo '</div>';
        $data = @ob_get_contents();
        ob_clean();
        ob_end_flush();
        $this->sendJson([
            'rows' => $data
        ]);
    }

    public function getGoogleFontsData()
    {
        return $this->__fetchGoogleFonts();
    }

    /**
     * @return ST_Admin_Settings
     * Google fonts
     * After one week will be reset google font
     */
    public function __fetchGoogleFonts()
    {

        $st_google_fonts_cache_key = 'st_google_fonts_cache';
        /* get the fonts from cache */
        $st_google_fonts = get_transient($st_google_fonts_cache_key);
        if (!is_array($st_google_fonts) or empty($st_google_fonts)) {
            $st_google_fonts = [];

            /* API url and key */
            $st_google_fonts_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts';
            $st_google_fonts_api_key = st()->get_option('google_font_api_key', 'AIzaSyDzH_BKnGaGm4h4ZplIuZkJYU9fij-XaqU');

            /* API arguments */
            $st_google_fonts_fields = ['family', 'variants', 'subsets'];
            $st_google_fonts_sort = 'alpha';

            /* Initiate API request */
            $st_google_fonts_query_args = [
                'key' => $st_google_fonts_api_key,
                'fields' => 'items(' . implode(',', $st_google_fonts_fields) . ')',
                'sort' => $st_google_fonts_sort
            ];

            /* Build and make the request */
            $st_google_fonts_query = esc_url_raw(add_query_arg($st_google_fonts_query_args, $st_google_fonts_api_url));
            $st_google_fonts_response = wp_safe_remote_get($st_google_fonts_query, ['sslverify' => false, 'timeout' => 15]);

            /* continue if we got a valid response */
            if (200 == wp_remote_retrieve_response_code($st_google_fonts_response)) {

                if ($response_body = wp_remote_retrieve_body($st_google_fonts_response)) {

                    /* JSON decode the response body and cache the result */
                    $st_google_fonts_data = json_decode(trim($response_body), true);

                    if (is_array($st_google_fonts_data) && isset($st_google_fonts_data['items'])) {

                        $st_google_fonts = $st_google_fonts_data['items'];

                        // Normalize the array key
                        $st_google_fonts_tmp = [];
                        foreach ($st_google_fonts as $key => $value) {
                            $id = remove_accents($value['family']);
                            $id = strtolower($id);
                            $id = preg_replace('/[^a-z0-9_\-]/', '', $id);
                            $st_google_fonts_tmp[$id] = $value;
                        }

                        $st_google_fonts = $st_google_fonts_tmp;

                        set_transient($st_google_fonts_cache_key, $st_google_fonts, MONTH_IN_SECONDS);
                    }
                }
            }
        }

        $current_version = '1';
        $db_version = get_theme_mod('remove_theme_mod_st_google_fonts');
        if (empty($db_version) or $db_version != $current_version) {
            remove_theme_mod('st_google_fonts');
            set_theme_mod('remove_theme_mod_st_google_fonts', $current_version);
        }

        return $st_google_fonts;
    }

    public static function inst()
    {
        if (!self::$_inst)
            self::$_inst = new self();

        return self::$_inst;
    }

}

ST_Admin_Settings::inst();

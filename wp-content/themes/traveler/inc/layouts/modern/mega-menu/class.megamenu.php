<?php

class ST_Menu_Mega_New
{
    public function __construct()
    {
        add_action('wp_nav_menu_item_custom_fields', array($this, 'st_custom_fields'), 10, 2);
        add_action('wp_update_nav_menu_item', array($this, 'st_nav_update'), 10, 2);
        add_filter('nav_menu_css_class', array($this, 'st_custom_nav_menu_css_class'), 10, 4);
        add_filter('nav_menu_item_title', array($this, 'st_custom_nav_menu_item_title'), 12, 4);
        $this->st_menu_transient_cache();
    }

    public function st_custom_fields($item_id, $item)
    {

        $menu_item_megamenu = get_post_meta($item_id, '_menu_item_megamenu', true);
        $menu_item_megamenu_columns = get_post_meta($item_id, '_menu_item_megamenu_columns', true);
        $menu_item_menutitle = get_post_meta($item_id, '_menu_item_menutitle', true);
        $menu_item_menulabel = get_post_meta($item_id, '_menu_item_menulabel', true);
        $menu_item_menulabelcolor = get_post_meta($item_id, '_menu_item_menulabelcolor', true);
        $menu_item_menuimage = get_post_meta($item_id, '_menu_item_menuimage', true);

        ?>

        <div class="st_menu_options">
            <div class="st-field-link-mega description description-thin">
                <label for="menu_item_megamenu-<?php echo esc_attr($item_id); ?>">
                    <?php esc_html_e('Show as Mega Menu', 'traveler'); ?><br/>
                    <?php
                    $value = $menu_item_megamenu;
                    if ($value != ""){
                        $value = "checked='checked'";
                    }
                    ?>
                    <input type="checkbox" value="enabled" id="menu_item_megamenu-<?php echo esc_attr($item_id); ?>"
                           name="menu_item_megamenu[<?php echo esc_attr($item_id); ?>]" <?php echo esc_attr($value); ?> />
                    <?php esc_html_e('Enable', 'traveler'); ?>
                </label>
            </div>
            <div class="st-field-link-mega description description-thin">
                <label for="menu_item_megamenu-columns-<?php echo esc_attr($item_id); ?>">
                    <?php esc_html_e('Main menu columns', 'traveler'); ?><br/>
                    <select class="widefat code edit-menu-item-custom"
                            id="menu_item_megamenu_columns-<?php echo esc_attr($item_id); ?>"
                            name="menu_item_megamenu_columns[<?php echo esc_attr($item_id); ?>]">
                        <?php $value = $menu_item_megamenu_columns;
                        if (!$value) {
                            $value = 4;
                        }
                        for ($i = 3; $i <= 5; $i++) { ?>
                            <option value="<?php echo (int)$i ?>" <?php if ($value == $i) echo "selected='selected'"; ?>><?php echo esc_attr($i) ?></option>
                        <?php } ?>
                    </select>
                </label>
            </div>
            <div class="st-field-link-title description description-wide">
                <label for="menu_item_menutitle-<?php echo esc_attr($item_id); ?>">
                    <?php esc_html_e('Show as Title', 'traveler'); ?><br/>
                    <?php
                    $value = $menu_item_menutitle;
                    if ($value != "") $value = "checked='checked'";
                    ?>
                    <input type="checkbox" value="enabled" id="menu_item_menutitle-<?php echo esc_attr($item_id); ?>"
                           name="menu_item_menutitle[<?php echo esc_attr($item_id); ?>]" <?php echo esc_attr($value); ?> />
                    <?php esc_html_e('Enable', 'traveler'); ?>
                </label>
            </div>
            <div class="st-field-link-label description description-wide">
                <label for="menu_item_menulabel-<?php echo esc_attr($item_id); ?>">
                    <?php esc_html_e('Highlight Label', 'traveler'); ?><br/>
                    <input type="text" class="widefat code edit-menu-item-custom"
                           id="menu_item_menulabel-<?php echo esc_attr($item_id); ?>"
                           name="menu_item_menulabel[<?php echo esc_attr($item_id); ?>]"
                           value="<?php echo esc_attr($menu_item_menulabel); ?>"/>
                </label>
            </div>
            <div class="st-field-link-labelcolor description description-wide">
                <label for="menu_item_menulabelcolor-<?php echo esc_attr($item_id); ?>">
                    <?php _e('Label Highlight Color', 'traveler'); ?><br/>
                    <span class="wrap-color">
                        <input type="text" class="widefat code edit-menu-item-custom st-color-field"
                               id="menu_item_menulabelcolor-<?php echo esc_attr($item_id); ?>"
                               name="menu_item_menulabelcolor[<?php echo esc_attr($item_id); ?>]"
                               value="<?php echo esc_attr($menu_item_menulabelcolor); ?>"/>
                    </span>
                </label>
            </div>
            <div class="st-field-link-image description description-wide">

                <label for="menu_item_menuimage-<?php echo esc_attr($item_id); ?>">
                    <?php esc_html_e('Menu Image', 'traveler'); ?>
                </label>

                <div class='image-preview-wrapper'>
                    <?php $image_attributes = wp_get_attachment_image_src($menu_item_menuimage, 'thumbnail');
                    if ($image_attributes != '') { ?>
                        <img id='image-preview-<?php echo esc_attr($item_id); ?>' class="image-preview"
                             src="<?php echo esc_attr($image_attributes[0]); ?>"/>
                    <?php } ?>
                </div>
                <?php
                $attrs = [
                    'style' => [
                        'display: none'
                    ]
                ];
                ?>
                <input id="remove_image_button-<?php echo esc_attr($item_id); ?>" type="button"
                       class="remove_image_button button" value="<?php esc_attr_e('Remove', 'traveler'); ?>"
                    <?php echo st_render_html_attributes($attrs) ?>/>
                <input id="upload_image_button-<?php echo esc_attr($item_id); ?>" type="button"
                       class="upload_image_button button" value="<?php esc_attr_e('Select image', 'traveler'); ?>"/>

                <input type="hidden" class="widefat code edit-menu-item-custom image_attachment_id"
                       id="menu_item_menuimage-<?php echo esc_attr($item_id); ?>"
                       name="menu_item_menuimage[<?php echo esc_attr($item_id); ?>]"
                       value="<?php echo esc_attr($menu_item_menuimage); ?>"/>


            </div>

        </div>

        <?php
    }

    /**
     * @param $menu_id
     * @param $menu_item_db_id
     * @return mixed
     */
    public function st_nav_update($menu_id, $menu_item_db_id)
    {
        if (isset($_POST['demo'])) {
            return $menu_item_db_id;
        }
        if (!isset($_REQUEST['menu_item_megamenu'][$menu_item_db_id])) {
            $_REQUEST['menu_item_megamenu'][$menu_item_db_id] = '';
        }
        $menumega_enabled_value = $_REQUEST['menu_item_megamenu'][$menu_item_db_id];
        update_post_meta($menu_item_db_id, '_menu_item_megamenu', $menumega_enabled_value);

        if (isset($menumega_enabled_value) && !empty($_REQUEST['menu_item_megamenu_columns'])) {
            $menumega_columns_enabled_value = $_REQUEST['menu_item_megamenu_columns'][$menu_item_db_id];
            update_post_meta($menu_item_db_id, '_menu_item_megamenu_columns', $menumega_columns_enabled_value);
        }

        if (!isset($_REQUEST['menu_item_menutitle'][$menu_item_db_id])) {
            $_REQUEST['menu_item_menutitle'][$menu_item_db_id] = '';
        }
        $menutitle_enabled_value = $_REQUEST['menu_item_menutitle'][$menu_item_db_id];
        update_post_meta($menu_item_db_id, '_menu_item_menutitle', $menutitle_enabled_value);

        if (!empty($_REQUEST['menu_item_menulabel'])) {
            $menulabel_enabled_value = $_REQUEST['menu_item_menulabel'][$menu_item_db_id];
            update_post_meta($menu_item_db_id, '_menu_item_menulabel', $menulabel_enabled_value);
        }

        if (!empty($_REQUEST['menu_item_menulabelcolor'])) {
            $menulabelcolor_enabled_value = $_REQUEST['menu_item_menulabelcolor'][$menu_item_db_id];
            update_post_meta($menu_item_db_id, '_menu_item_menulabelcolor', $menulabelcolor_enabled_value);
        }

        if (!empty($_REQUEST['menu_item_menuimage'])) {
            $menuimage_enabled_value = $_REQUEST['menu_item_menuimage'][$menu_item_db_id];
            update_post_meta($menu_item_db_id, '_menu_item_menuimage', $menuimage_enabled_value);
        }

    }

    function st_custom_nav_menu_css_class($classes, $item, $args, $depth)
    {
        $item->active_megamenu = get_post_meta($item->ID, '_menu_item_megamenu', true);
        if ($depth === 0) {
            $mega_columns = get_post_meta($item->ID, '_menu_item_megamenu_columns', true);
            if ($item->active_megamenu) {
                $classes[] = 'menu-item-mega-parent';
                $classes[] = 'menu-item-mega-column-' . $mega_columns;
            }
        } else {
            $classes[] = get_post_meta($item->ID, '_menu_item_menutitle', true) === 'enabled' ? ' title-item' : '';
        }
        if ($depth === 1 && $item->active_megamenu) {
            $classes[] = 'mega-menu-title';
        }

        return $classes;
    }

    function st_custom_nav_menu_item_title($title, $item, $args, $depth)
    {
        if (is_object($item) && isset($item->ID) && ! $item instanceof WPML_LS_Menu_Item) {

            $item->menuimage = get_post_meta($item->ID, '_menu_item_menuimage', true);
           
            $item->menulabel = get_post_meta($item->ID, '_menu_item_menulabel', true);
            $item->menu_label_color = get_post_meta($item->ID, '_menu_item_menulabelcolor', true);
            $style_label_height = [
                'style' => [
                    'background-color: ' . $item->menu_label_color,
                    'border-color: ' . $item->menu_label_color,
                ],
            ];
            $menu_label_color = ($item->menu_label_color != '') ? ' ' . st_render_html_attributes($style_label_height) : '';
            $menu_image = wp_get_attachment_image($item->menuimage, 'medium_large', '', array('class' => 'skip-webp'));

            $original_title = $title;
            $title = ($item->menuimage != '' && $depth > 0) ? '<span class="item-thumb">' . $menu_image . '</span><span class="item-caption">' : '';
            $title .= ($item->menulabel != '') ? '<span class="title-menu">'.esc_html($original_title).'<span class="label-highlight"' . $menu_label_color . '>' . $item->menulabel . '</span></span>' : esc_html($original_title);
            $title .= ($item->menuimage != '') ? '</span>' : '';

        }

        return $title;
    }

    public function st_menu_transient_cache()
    {
        if (get_theme_mod('menu_transient_cache', false) == true && get_option('st_menu_cache_deleted') != '1') {
            global $wpdb;
            $sql = "SELECT * FROM $wpdb->options WHERE `option_name` LIKE ('%\_transient_menu-cache%') LIMIT 1";
            $results = $wpdb->get_results($sql);
            if (is_array($results) && !empty($results)) {
                $this->st_clear_menu_transients();
                update_option('st_menu_cache_deleted', '0');
            } else {
                update_option('st_menu_cache_deleted', '1');
            }
        }
    }


    public function st_clear_menu_transients()
    {
        global $wpdb;
        $sql = "DELETE FROM $wpdb->options WHERE `option_name` LIKE ('%\_transient_menu-cache%') OR `option_name` LIKE ('%\_transient_timeout_menu-cache%') LIMIT 1000";
        return $wpdb->query($sql);
    }
}

new ST_Menu_Mega_New();
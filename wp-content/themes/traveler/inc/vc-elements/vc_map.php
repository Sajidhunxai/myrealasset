<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 10/04/2018
 * Time: 14:46 CH
 */
add_action('vc_before_init', 'st_map_base_shortcodes');

function st_map_base_shortcodes() {
    vc_map(array(
        "name" => __("ST About Icon", 'traveler'),
        "base" => "st_about_icon",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Icon", 'traveler'),
                "param_name" => "st_icon",
                "description" => "",
                'edit_field_class' => 'st_iconpicker vc_col-sm-12'
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "heading" => __("Icon color", 'traveler'),
                "param_name" => "st_color_icon",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-3'
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("To Icon color", 'traveler'),
                "param_name" => "st_to_color",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-3',
                'value' => 'black'
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Position Icon", 'traveler'),
                "param_name" => "st_pos_icon",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-3',
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Top', 'traveler') => 'top',
                    __('Left', 'traveler') => 'left',
                    __('Right', 'traveler') => 'right'
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Size Icon", 'traveler'),
                "param_name" => "st_size_icon",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-3',
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Small', 'traveler') => 'box-icon-sm',
                    __('Medium', 'traveler') => 'box-icon-md',
                    __('Big', 'traveler') => 'box-icon-big'
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Text Align", 'traveler'),
                "param_name" => "st_text_align",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-3',
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Center', 'traveler') => 'text-center',
                    __('Left', 'traveler') => 'text-left',
                    __('Right', 'traveler') => 'text-right'
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Icon Box border", 'traveler'),
                "param_name" => "st_border",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-3',
                'value' => array(
                    __('No', 'traveler') => '',
                    __('Yes', 'traveler') => 'box-icon-border',
                )
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Animation", 'traveler'),
                "param_name" => "st_animation",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-6',
                'value' => 'animate-icon-top-to-bottom'
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Name", 'traveler'),
                "param_name" => "st_name",
                "description" => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Link", 'traveler'),
                "param_name" => "st_link",
                "description" => "",
            ),
            array(
                "type" => "textarea",
                "holder" => "div",
                "heading" => __("Description", 'traveler'),
                "param_name" => "st_description",
                "description" => "",
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Accordion", 'traveler'),
        "base" => "st_accordion",
        "as_parent" => array('only' => 'st_accordion_item'),
        "content_element" => true,
        "show_settings_on_create" => false,
        "js_view" => 'VcColumnView',
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Element style", 'traveler'),
                "param_name" => "style",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Tour box style', 'traveler') => 'st_tour_ver',
                ),
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Accordion item", 'traveler'),
        "base" => "st_accordion_item",
        "content_element" => true,
        "as_child" => array('only' => 'st_accordion'),
        "icon" => "icon-st",
        "params" => array(
            // add params same as with any other content element
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => "",
            ),
            array(
                "type" => "textfield",
                "heading" => __("Date time", 'traveler'),
                "param_name" => "st_date",
                "description" => "",
            ),
            array(
                "type" => "textarea_html",
                "heading" => __("Content", 'traveler'),
                "param_name" => "content",
                "description" => "",
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Alert", 'traveler'),
        "base" => "st_alert",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "textarea",
                "holder" => "div",
                "heading" => __("Content Alert", 'traveler'),
                "param_name" => "st_content",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12'
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Type Alert", 'traveler'),
                "param_name" => "st_type",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Success', 'traveler') => 'alert-success',
                    __('Info', 'traveler') => 'alert-info',
                    __('Warning', 'traveler') => 'alert-warning',
                    __('Danger', 'traveler') => 'alert-danger',
                )
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST All Post Type Search Results", 'traveler'),
        "base" => "st_all_post_type_content_search",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => 'Shinetheme',
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Number Items", 'traveler'),
                "param_name" => "st_number",
                "description" => "",
                "value" => 5,
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Style", 'traveler'),
                "param_name" => "st_style",
                "description" => "",
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('List', 'traveler') => '1',
                    __('Grid', 'traveler') => '2',
                ),
            )
        )
    ));
    vc_map(array(
        "name" => __("[Ajax] ST All Post Type Search Results", 'traveler'),
        "base" => "st_all_post_type_content_search_ajax",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => 'Shinetheme',
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Number Items", 'traveler'),
                "param_name" => "st_number",
                "description" => "",
                "value" => 5,
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Style", 'traveler'),
                "param_name" => "st_style",
                "description" => "",
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('List', 'traveler') => '1',
                    __('Grid', 'traveler') => '2',
                ),
            )
        )
    ));
    vc_map(array(
        "name" => __("ST Search with background gallery", 'traveler'),
        "base" => "st_bg_gallery",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "attach_images",
                "holder" => "div",
                "heading" => __("Images in", 'traveler'),
                "param_name" => "st_images_in",
                "description" => "",
            ),
            array(
                "type" => "attach_images",
                "holder" => "div",
                "heading" => __("Images not in", 'traveler'),
                "param_name" => "st_images_not_in",
                "description" => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Effect Speed", 'traveler'),
                "param_name" => "st_speed",
                "description" => __('Example : 1200ms', 'traveler'),
                'edit_field_class' => 'vc_col-sm-6',
                'value' => 1200
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Columns", 'traveler'),
                "param_name" => "st_col",
                "description" => __('Example : 8', 'traveler'),
                'edit_field_class' => 'vc_col-sm-6',
                'value' => 8
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Rows", 'traveler'),
                "param_name" => "st_row",
                "description" => __('Example : 4', 'traveler'),
                'edit_field_class' => 'vc_col-sm-6',
                'value' => 4
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Opacity Background", 'traveler'),
                "param_name" => "opacity",
                "description" => __(" Enter value form 0 - 0.5 - 1 ", 'traveler'),
                'value' => '0.5'
            ),
            array(
                'type' => 'st_checkbox',
                'admin_label' => true,
                'heading' => __('Select Tabs Search', 'traveler'),
                'param_name' => 'tabs_search',
                'description' => __('Please choose tab name to display in page', 'traveler'),
                'stype' => 'get_option',
                'sparam' => 'search_tabs',
                'std' => 'all'
            )
        )
    ));
    vc_map(array(
        "name" => __("ST Blog", 'traveler'),
        "base" => "st_blog",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Style", 'traveler'),
                "param_name" => "st_style",
                "value" => array(
                    __("Style one", 'traveler') => "style1",
                    __("Style two", 'traveler') => "style2",
                    __("Style three", 'traveler') => "style3",
                    __("Style four", 'traveler') => "style4",
                    __("Style five", 'traveler') => "style5",
                    __("Style six", 'traveler') => "style6",
                    __("Style seven", 'traveler') => "style7",
                )
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Number of Posts", 'traveler'),
                "param_name" => "st_blog_number_post",
                "value" => 4,
                "description" => __("Post number", 'traveler')
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Number post of row", 'traveler'),
                "param_name" => "st_blog_style",
                "value" => '',
                "description" => __("Colums per row", 'traveler'),
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Four', 'traveler') => '4',
                    __('Three', 'traveler') => '3',
                    __('Two', 'traveler') => '2',
                ),
            ),
            array(
                "type" => "st_checkbox",
                "holder" => "div",
                "heading" => __("Category", 'traveler'),
                "param_name" => "st_category",
                'stype' => 'list_tax_id',
                'sparam' => 'category',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Order", 'traveler'),
                "param_name" => "st_blog_order",
                'value' => array(
                    __('Asc', 'traveler') => 'asc',
                    __('Desc', 'traveler') => 'desc'
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Order By", 'traveler'),
                "param_name" => "st_blog_orderby",
                "value" => st_get_list_order_by(),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("List IDs of posts", 'traveler'),
                "param_name" => "st_ids",
                "description" => __("Ids separated by commas", 'traveler'),
                'value' => "",
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Breadcrumb", 'traveler'),
        "base" => "st_breadcrumb",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        'show_settings_on_create' => false,
        'params' => array(
            array(
                'type' => 'textfield',
                'heading' => esc_html__('There is no option in this element', 'traveler'),
                'param_name' => 'description_field',
                'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
            )
        )
    ));
    vc_map(array(
        "name" => __("ST Button", 'traveler'),
        "base" => "st_button",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Text Button", 'traveler'),
                "param_name" => "st_title",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12'
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Link Buttons", 'traveler'),
                "param_name" => "st_link",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Type Button", 'traveler'),
                "param_name" => "st_type",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-4',
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Default', 'traveler') => 'btn-default',
                    __('Primary', 'traveler') => 'btn-primary',
                    __('Success', 'traveler') => 'btn-success',
                    __('Info', 'traveler') => 'btn-info',
                    __('Warning', 'traveler') => 'btn-warning',
                    __('Danger', 'traveler') => 'btn-danger',
                    __('Link', 'traveler') => 'btn-link',
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Button size", 'traveler'),
                "param_name" => "st_size",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-4',
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Normal', 'traveler') => 'btn-normal',
                    __('Large', 'traveler') => 'btn-lg',
                    __('Small', 'traveler') => 'btn-sm',
                    __('Extra small', 'traveler') => 'btn-xs',
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Ghost button", 'traveler'),
                "param_name" => "st_ghost",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-4',
                'value' => array(
                    __('No', 'traveler') => '',
                    __('Yes', 'traveler') => 'btn-ghost',
                )
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Flickr", 'traveler'),
        "base" => "st_flickr",
        "content_element" => true,
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Number", 'traveler'),
                "param_name" => "st_number",
                "description" => "",
            ),
            array(
                "type" => "textfield",
                "heading" => __("User", 'traveler'),
                "param_name" => "st_user",
                "description" => ""
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Gallery", 'traveler'),
        "base" => "st_gallery",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Number of images", 'traveler'),
                "param_name" => "st_number_image",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-6 vc_col-md-6',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Number of Columns", 'traveler'),
                "param_name" => "st_col",
                'edit_field_class' => 'vc_col-sm-6 vc_col-md-6',
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Four', 'traveler') => '4',
                    __('Three', 'traveler') => '3',
                    __('Two', 'traveler') => '2',
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Animation effect", 'traveler'),
                "param_name" => "st_effect",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-6 vc_col-md-6',
                'value' => array(
                    __('Default', 'traveler') => '',
                    __('Zoom out', 'traveler') => 'mfp-zoom-out',
                    __('Zoom in', 'traveler') => 'mfp-zoom-in',
                    __('Fade', 'traveler') => 'mfp-fade',
                    __('Move horizontal', 'traveler') => 'mfp-move-horizontal',
                    __('Move from top', 'traveler') => 'mfp-move-from-top',
                    __('Newspaper', 'traveler') => 'mfp-newspaper',
                    __('3D unfold', 'traveler') => 'mfp-3d-unfold',
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Show Image Title", 'traveler'),
                "param_name" => "st_image_title",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-6 vc_col-md-6',
                'value' => array(
                    __('--Select --', 'traveler') => '',
                    __('Yes', 'traveler') => 'y',
                    __('No', 'traveler') => 'n',
                )
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Icon hover", 'traveler'),
                "param_name" => "st_icon",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-4 vc_col-md-4',
                'value' => "fa-plus"
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Margin Item", 'traveler'),
                "param_name" => "margin_item",
                'edit_field_class' => 'vc_col-sm-4 vc_col-md-4',
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Normal', 'traveler') => 'normal',
                    __('Full width', 'traveler') => 'full',
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Image Size", 'traveler'),
                "param_name" => "image_size",
                'edit_field_class' => 'vc_col-sm-4 vc_col-md-4',
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Thumbnail', 'traveler') => 'thumbnail',
                    __('Medium', 'traveler') => 'medium',
                    __('Large', 'traveler') => 'large',
                    __('Full', 'traveler') => 'full',
                ),
            ),
            array(
                "type" => "attach_images",
                "holder" => "div",
                "heading" => __("List Image", 'traveler'),
                "param_name" => "st_images_in",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                "type" => "attach_images",
                "holder" => "div",
                "heading" => __("Images not in", 'traveler'),
                "param_name" => "st_images_not_in",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Gird", 'traveler'),
        "base" => "st_gird",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "heading" => __("Color", 'traveler'),
                "param_name" => "st_color",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
                'value' => '#999'
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Size", 'traveler'),
                "param_name" => "st_size",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('col-1', 'traveler') => 'col-md-1',
                    __('col-2', 'traveler') => 'col-md-2',
                    __('col-3', 'traveler') => 'col-md-3',
                    __('col-4', 'traveler') => 'col-md-4',
                    __('col-5', 'traveler') => 'col-md-5',
                    __('col-6', 'traveler') => 'col-md-6',
                    __('col-7', 'traveler') => 'col-md-7',
                    __('col-8', 'traveler') => 'col-md-8',
                    __('col-9', 'traveler') => 'col-md-9',
                    __('col-10', 'traveler') => 'col-md-10',
                    __('col-11', 'traveler') => 'col-md-11',
                    __('col-12', 'traveler') => 'col-md-12',
                )
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Icon", 'traveler'),
        "base" => "st_icon",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Position Tooltip", 'traveler'),
                "param_name" => "st_pos_tooltip",
                'edit_field_class' => 'vc_col-sm-6',
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('No', 'traveler') => 'none',
                    __('Top', 'traveler') => 'top',
                    __('Bottom', 'traveler') => 'bottom',
                    __('Left', 'traveler') => 'left',
                    __('Right', 'traveler') => 'right'
                )
            ), array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Tooltip", 'traveler'),
                "param_name" => "st_tooltips",
                "description" => __("Place your tooltip", 'traveler'),
                'edit_field_class' => 'vc_col-sm-6'
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Icon", 'traveler'),
                "param_name" => "st_icon",
                "description" => "",
                'edit_field_class' => 'st_iconpicker vc_col-sm-6'
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Text Content", 'traveler'),
                "param_name" => "st_text_content",
                "description" => __("Must be empty Icon to use this Param" . 'traveler'),
                'edit_field_class' => 'st_iconpicker vc_col-sm-6'
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "heading" => __("Icon color", 'traveler'),
                "param_name" => "st_color_icon",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-3'
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "heading" => __("To Icon color", 'traveler'),
                "param_name" => "st_to_color",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-3',
                'value' => ''
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Alignment", 'traveler'),
                "param_name" => "st_aligment",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-3',
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('No', 'traveler') => 'box-icon-none',
                    __('Left', 'traveler') => 'box-icon-left',
                    __('Right', 'traveler') => 'box-icon-right',
                    __('Center', 'traveler') => 'box-icon-center'
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Size Icon", 'traveler'),
                "param_name" => "st_size_icon",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-3',
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Small', 'traveler') => 'box-icon-sm',
                    __('Medium', 'traveler') => 'box-icon-md',
                    __('Big', 'traveler') => 'box-icon-big',
                    __('Large', 'traveler') => 'box-icon-large',
                    __('Huge', 'traveler') => 'box-icon-huge',
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Round Icon", 'traveler'),
                "param_name" => "st_round",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-3',
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('No', 'traveler') => '',
                    __('Yes', 'traveler') => 'round',
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Icon Box border", 'traveler'),
                "param_name" => "st_border",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-3',
                'value' => array(
                    __('No', 'traveler') => '',
                    __('Normal', 'traveler') => 'box-icon-border',
                    __('Dashed', 'traveler') => 'box-icon-border-dashed',
                )
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Animation", 'traveler'),
                "param_name" => "st_animation",
                "description" => __("http://daneden.github.io/animate.css/", 'traveler'),
                'edit_field_class' => 'vc_col-sm-6',
                'value' => ''
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("CSS Display", 'traveler'),
                "param_name" => "st_icon_display",
                'edit_field_class' => 'vc_col-sm-6',
                'value' => array(
                    __('Block', 'traveler') => 'block',
                    __('Inline', 'traveler') => 'inline',
                    __('Inline-block', 'traveler') => 'inline-block',
                )
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Image Effect", 'traveler'),
        "base" => "st_image_effect",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "attach_image",
                "holder" => "div",
                "heading" => __("image", 'traveler'),
                "param_name" => "st_image",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Type Hover", 'traveler'),
                "param_name" => "st_type",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
                'value' => array(
                    __('Simple Hover', 'traveler') => '',
                    __('Icon', 'traveler') => 'icon',
                    __('Icon Group', 'traveler') => 'icon-group',
                    __('Title', 'traveler') => 'title',
                    __('Inner Full', 'traveler') => 'inner-full',
                    __('Inner Block', 'traveler') => 'inner-block',
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Position Layout", 'traveler'),
                "param_name" => "st_pos_layout",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-4',
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __("Top Left", 'traveler') => "-top-left",
                    __("Top Right", 'traveler') => "-top-right",
                    __("Bottom Left", 'traveler') => "-bottom-left",
                    __("Bottom Right", 'traveler') => "-bottom-right",
                    __("Center", 'traveler') => "-center",
                    __("Center Top", 'traveler') => "-center-top",
                    __("Center Bottom", 'traveler') => "-center-bottom",
                    __("Top", 'traveler') => "-top",
                    __("Bottom", 'traveler') => "-bottom",
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Hover Hold", 'traveler'),
                "param_name" => "st_hover_hold",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-4',
                'value' => array(
                    __("No", 'traveler') => "",
                    __("Yes", 'traveler') => "hover-hold",
                )
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Url", 'traveler'),
                "param_name" => "url",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Class Icon", 'traveler'),
                "param_name" => "st_class_icon",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                "type" => "textarea",
                "holder" => "div",
                "heading" => __("Icon Group", 'traveler'),
                "param_name" => "content",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
                'value' => ''
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Inbox Form", 'traveler'),
        "base" => "st_inbox_form",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Title Form", 'traveler'),
                "param_name" => "title",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12'
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Active Form", 'traveler'),
                "param_name" => "active",
                'value' => array(
                    esc_html__("No", 'traveler') => '',
                    esc_html__("Yes", 'traveler') => 'active',
                ),
                'edit_field_class' => 'vc_col-sm-12'
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Owner Listing", 'traveler'),
        "base" => "st_info_owner",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Config show/hide avatar", 'traveler'),
                "param_name" => "show_avatar",
                'value' => array(
                    __('Show', 'traveler') => 'true',
                    __('Hide', 'traveler') => 'false',
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Config show/hide email, social icons", 'traveler'),
                "param_name" => "show_social",
                'value' => array(
                    __('Show', 'traveler') => 'true',
                    __('Hide', 'traveler') => 'false',
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Config show/hide: Member since", 'traveler'),
                "param_name" => "show_member_since",
                'value' => array(
                    __('Show', 'traveler') => 'true',
                    __('Hide', 'traveler') => 'false',
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Config show/hide: Short Description", 'traveler'),
                "param_name" => "show_short_info",
                'value' => array(
                    __('Show', 'traveler') => 'true',
                    __('Hide', 'traveler') => 'false',
                )
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Last Minute Deal", 'traveler'),
        "base" => "st_last_minute_deal",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "st_dropdown",
                'admin_label' => true,
                "heading" => __("Post type", 'traveler'),
                "param_name" => "st_post_type",
                "description" => "",
                'stype' => 'list_post_type',
                'sparam' => false,
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Lightbox", 'traveler'),
        "base" => "st_lightbox",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Type Lightbox", 'traveler'),
                "param_name" => "st_type",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-4',
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Image', 'traveler') => 'image',
                    __('Iframe', 'traveler') => 'iframe',
                    __('HTML', 'traveler') => 'html',
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Animation effect", 'traveler'),
                "param_name" => "st_effect",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-4',
                'value' => array(
                    __('Default', 'traveler') => '',
                    __('Zoom out', 'traveler') => 'mfp-zoom-out',
                    __('Zoom in', 'traveler') => 'mfp-zoom-in',
                    __('Fade', 'traveler') => 'mfp-fade',
                    __('Move horizontal', 'traveler') => 'mfp-move-horizontal',
                    __('Move from top', 'traveler') => 'mfp-move-from-top',
                    __('Newspaper', 'traveler') => 'mfp-newspaper',
                    __('3D unfold', 'traveler') => 'mfp-3d-unfold',
                )
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Icon hover", 'traveler'),
                "param_name" => "st_icon",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-4',
                'value' => "fa-plus"
            ),
            array(
                "type" => "attach_image",
                "holder" => "div",
                "heading" => __("image", 'traveler'),
                "param_name" => "st_image",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-2',
            ),
            array(
                "type" => "textarea",
                "holder" => "div",
                "heading" => __("Link Iframe", 'traveler'),
                "param_name" => "st_link",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-10',
                'value' => ''
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
                'value' => ''
            ),
            array(
                "type" => "textarea",
                "holder" => "div",
                "heading" => __("Content html", 'traveler'),
                "param_name" => "content",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
                'value' => ''
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST List of Location", 'traveler'),
        "base" => "st_list_location",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("List IDs in Location", 'traveler'),
                "param_name" => "st_ids",
                "description" => __("Ids separated by commas", 'traveler'),
                'value' => "",
            ),
            array(
                "type" => "st_checkbox",
                "holder" => "div",
                "heading" => __("Location type", 'traveler'),
                "param_name" => "st_location_type",
                "description" => "",
                'stype' => 'list_location_terms',
                'sparam' => '',
            ),
            array(
                "type" => "st_dropdown",
                "holder" => "div",
                "heading" => __("Post type", 'traveler'),
                "param_name" => "st_type",
                "description" => "",
                'stype' => 'list_post_type',
                'sparam' => false,
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Link To", 'traveler'),
                "param_name" => "link_to",
                "description" => __("Link To", 'traveler'),
                'value' => array(
                    __("Page Search", 'traveler') => 'page_search',
                    __("Single", 'traveler') => 'single'
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Number Location", 'traveler'),
                "param_name" => "st_number",
                "description" => __("Number Location", 'traveler'),
                'value' => 4,
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Show Only Featured Location", 'traveler'),
                "param_name" => "is_featured",
                "description" => __("Show Only Featured Location", 'traveler'),
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __("No", 'traveler') => 'no',
                    __("Yes", 'traveler') => 'yes',
                ),
                'edit_field_class' => 'vc_col-sm-6 clear',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Items per row", 'traveler'),
                "param_name" => "st_col",
                "description" => "",
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Four', 'traveler') => '4',
                    __('Three', 'traveler') => '3',
                    __('Two', 'traveler') => '2',
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Style location", 'traveler'),
                "param_name" => "st_style",
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Normal', 'traveler') => 'normal',
                    __('Curved', 'traveler') => 'curved',
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Show Logo", 'traveler'),
                "param_name" => "st_show_logo",
                'edit_field_class' => 'vc_col-sm-6',
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Yes', 'traveler') => 'yes',
                    __('No', 'traveler') => 'no',
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Logo Position", 'traveler'),
                "param_name" => "st_logo_position",
                'edit_field_class' => 'vc_col-sm-6',
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Left', 'traveler') => 'left',
                    __('Right', 'traveler') => 'right',
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Order By", 'traveler'),
                "param_name" => "st_orderby",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-6',
                'value' => function_exists('st_get_list_order_by') ? st_get_list_order_by(
                                array(
                                    __('Sale', 'traveler') => 'sale',
                                    __('Rate', 'traveler') => 'rate',
                                    __('Min Price', 'traveler') => 'price',
                                )
                        ) : array(),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Order", 'traveler'),
                "param_name" => "st_order",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Asc', 'traveler') => 'asc',
                    __('Desc', 'traveler') => 'desc'
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST List Map New", 'traveler'),
        "base" => "st_list_map_new",
        "class" => "",
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "st_dropdown",
                "holder" => "div",
                "heading" => __("Select Location", 'traveler'),
                "param_name" => "st_list_location",
                "description" => "",
                'stype' => 'list_location',
                'sparam' => '',
            ),
            array(
                "type" => "checkbox",
                "holder" => "div",
                "heading" => __("Type", 'traveler'),
                "param_name" => "st_type",
                "description" => "",
                'value' => array(
                    __('All Post Type', 'traveler') => 'st_hotel,st_cars,st_tours,st_rental,st_activity',
                    __('Hotel', 'traveler') => 'st_hotel',
                    __('Car', 'traveler') => 'st_cars',
                    __('Tour', 'traveler') => 'st_tours',
                    __('Rental', 'traveler') => 'st_rental',
                    __('Activities', 'traveler') => 'st_activity',
                ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Number", 'traveler'),
                "param_name" => "number",
                "value" => 12,
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Zoom", 'traveler'),
                "param_name" => "zoom",
                "value" => 13,
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Map Height", 'traveler'),
                "param_name" => "height",
                "description" => "pixels",
                "value" => 500,
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Show Circle", 'traveler'),
                "param_name" => "show_circle",
                "description" => "",
                "value" => array(
                    __("No", 'traveler') => "no",
                    __("Yes", 'traveler') => "yes"
                ),
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Range", 'traveler'),
                "param_name" => "range",
                "description" => "Km",
                "value" => "20",
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Style Map", 'traveler'),
                "param_name" => "style_map",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Normal', 'traveler') => 'normal',
                    __('Midnight', 'traveler') => 'midnight',
                    __('Family Fest', 'traveler') => 'family_fest',
                    __('Open Dark', 'traveler') => 'open_dark',
                    __('Riverside', 'traveler') => 'riverside',
                    __('Ozan', 'traveler') => 'ozan',
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST List Partner", 'traveler'),
        "base" => "st_list_partner",
        "content_element" => true,
        "show_settings_on_create" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                'type' => 'textfield',
                'param_name' => 'speed_slider',
                'holder' => 'div',
                'heading' => __('Speed of slider', 'traveler'),
                'value' => '3000',
            ),
            array(
                'heading' => __('Auto play', 'traveler'),
                'param_name' => 'autoplay',
                'type' => 'checkbox',
                'value' => array(
                    __('Yes', 'traveler') => 'yes',
                ),
            ),
        ),
    ));
    vc_map(array(
        "name" => __("ST List Review", 'traveler'),
        "base" => "st_list_review",
        "content_element" => true,
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "dropdown",
                "heading" => __("Style", 'traveler'),
                "param_name" => "st_style",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Default', 'traveler') => 'html',
                /* __( 'Tour box style' , 'traveler' )       => 'st_tour_ver' */
                ),
            ),
            array(
                "type" => "textfield",
                "heading" => __("Max Number", 'traveler'),
                "param_name" => "number",
                "description" => "",
            ),
            array(
                "type" => "textfield",
                "heading" => __("Max length", 'traveler'),
                "param_name" => "st_max_len",
                "description" => "",
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Location count rate ", 'traveler'),
        "base" => "st_location_header_rate_count",
        "content_element" => true,
        "icon" => "icon-st",
        "params" => array(
            // add params same as with any other content element
            array(
                "type" => "checkbox",
                "holder" => "div",
                "heading" => __("Post type select ?", 'traveler'), //
                "param_name" => "post_type",
                "description" => __("Select your post types which you want ?", 'traveler'),
                "value" => array(
                    __('--- All ---', 'traveler') => 'all',
                    __('Hotel', 'traveler') => 'st_hotel',
                    __('Car', 'traveler') => 'st_cars',
                    __('Rental', 'traveler') => 'st_rental',
                    __('Activity', 'traveler') => 'st_activity',
                    __('Tour', 'traveler') => 'st_tours',
                )
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Location statistical", 'traveler'),
        "base" => "st_location_header_static",
        "content_element" => true,
        "icon" => "icon-st",
        "params" => array(
            // add params same as with any other content element
            array(
                "type" => "checkbox",
                "holder" => "div",
                "heading" => __("Post type select ?", 'traveler'), //
                "param_name" => "post_type",
                "description" => __("Select your post types", 'traveler'),
                "value" => array(
                    __('--- All ---', 'traveler') => 'all',
                    __('Hotel', 'traveler') => 'st_hotel',
                    __('Car', 'traveler') => 'st_cars',
                    __('Rental', 'traveler') => 'st_rental',
                    __('Activity', 'traveler') => 'st_activity',
                    __('Tour', 'traveler') => 'st_tours',
                )
            ),
            array(
                "type" => "checkbox",
                "holder" => "div",
                "heading" => __("Select star list ", 'traveler'), //
                "param_name" => "star_list",
                "description" => __("Select star list to static and show", 'traveler'),
                "value" => array(
                    __('--- All ---<br>', 'traveler') => 'all',
                    __('<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> (5)<br> ', 'traveler') => '5',
                    __('<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> (4)<br> ', 'traveler') => '4',
                    __('<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> (3)<br> ', 'traveler') => '3',
                    __('<i class="fa fa-star"></i><i class="fa fa-star"></i> (2) <br> ', 'traveler') => '2',
                    __('<i class="fa fa-star"></i> (1)  ', 'traveler') => '1',
                )
            ),
        )
    ));
    vc_map(
            array(
                "name" => __("ST Gallery slider ", 'traveler'),
                "base" => "st_location_slider",
                "content_element" => true,
                "icon" => "icon-st",
                "category" => "Shinetheme",
                "params" => array(
                    array(
                        "type" => "attach_images",
                        "holder" => "div",
                        "heading" => __("Gallery slider ", 'traveler'), //
                        "param_name" => "st_location_list_image"
                    )
                )
            )
    );
    $location_list_params = array(
        array(
            "type" => "dropdown",
            "holder" => "div",
            "heading" => __("Style", 'traveler'),
            "param_name" => "st_location_style",
            "description" => "Default style",
            'value' => array(
                __('--Select --', 'traveler') => '',
                __('List', 'traveler') => 'list',
                __('Grid', 'traveler') => 'grid')
        ),
        array(
            "type" => "textfield",
            "holder" => "div",
            "heading" => __("No. items per page", 'traveler'),
            "param_name" => "st_location_num",
            "description" => "Number of items shown",
            'value' => 4,
        ),
        array(
            "type" => "dropdown",
            "holder" => "div",
            "heading" => __("Order By", 'traveler'),
            "param_name" => "st_location_orderby",
            "description" => "",
            'value' => st_get_list_order_by()
        ),
        array(
            "type" => "dropdown",
            "holder" => "div",
            "heading" => __("Order", 'traveler'),
            "param_name" => "st_location_order",
            'value' => array(
                __('--Select--', 'traveler') => '',
                __('Asc', 'traveler') => 'asc',
                __('Desc', 'traveler') => 'desc'
            ),
        )
    );
    vc_map(
            array(
                "name" => __("ST Location map", 'traveler'),
                "base" => "st_location_map",
                "content_element" => true,
                "icon" => "icon-st",
                "category" => "Shinetheme",
                'params' => array(
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "heading" => __("Number", 'traveler'),
                        "param_name" => "map_spots",
                    )
                )
            )
    );
    vc_map(array(
        "name" => __("ST Google Map", 'traveler'),
        "base" => "st_google_map",
        "class" => "",
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => __("Type", 'traveler'),
                "param_name" => "type",
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Use Address', 'traveler') => 1,
                    __('User Latitude and Longitude', 'traveler') => 2,
                ),
                "description" => __("Address or using Latitude and Longitude", 'traveler')
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Address", 'traveler'),
                "param_name" => "address",
                "value" => "",
                "description" => __("Address", 'traveler')
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Latitude", 'traveler'),
                "param_name" => "latitude",
                "value" => "",
                "description" => __("Latitude, you can get it from  <a target='_blank' href='http://www.latlong.net/convert-address-to-lat-long.html'>here</a>", 'traveler')
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Longitude", 'traveler'),
                "param_name" => "longitude",
                "value" => "",
                "description" => __("Longitude", 'traveler')
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Lightness", 'traveler'),
                "param_name" => "lightness",
                "value" => 0,
                "description" => __("(a floating point value between -100 and 100) indicates the percentage change in brightness of the element.", 'traveler')
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Saturation", 'traveler'),
                "param_name" => "saturation",
                "value" => "-100",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Gamma", 'traveler'),
                "param_name" => "gama",
                "value" => 0.5,
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Zoom", 'traveler'),
                "param_name" => "zoom",
                "value" => 13,
            ),
            array(
                "type" => "attach_image",
                "holder" => "div",
                "class" => "",
                "heading" => __("Custom Marker Icon", 'traveler'),
                "param_name" => "marker",
                "value" => "",
                "description" => __("Custom Marker Icon", 'traveler')
            ),
    )));
    vc_map(array(
        'name' => __('ST Room Map', 'traveler'),
        'base' => 'st_room_map',
        'class' => '',
        'icon' => 'icon-st',
        'category' => 'Shinetheme',
        'params' => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Range", 'traveler'),
                "param_name" => "range",
                "description" => "Km",
                "value" => "20",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Number", 'traveler'),
                "param_name" => "number",
                "description" => "",
                "value" => "12",
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Show Circle", 'traveler'),
                "param_name" => "show_circle",
                "description" => "",
                "value" => array(
                    __("No", 'traveler') => "no",
                    __("Yes", 'traveler') => "yes"
                ),
            )
        ),
    ));
    vc_map(array(
        "name" => __("ST Progress Bar", 'traveler'),
        "base" => "st_progress_bar",
        "as_parent" => array('only' => 'st_progress_bar_item'),
        "content_element" => true,
        "show_settings_on_create" => false,
        "js_view" => 'VcColumnView',
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Element style", 'traveler'),
                "param_name" => "style",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                /* __('Tour box style (Vertical ) ','traveler')=>'vertical',
                  __('Tour box style (Horizontal ) ','traveler')=>'horizontal', */
                ),
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Progress Bar item", 'traveler'),
        "base" => "st_progress_bar_item",
        "content_element" => true,
        "as_child" => array('only' => 'st_progress_bar'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => "",
            ),
            /* array(
              "type" => "textarea_html",
              "heading" => __("Content", 'traveler'),
              "param_name" => "content",
              "description" =>"",
              ), */
            array(
                "type" => "textfield",
                "heading" => __("Value percentage", 'traveler'),
                "param_name" => "value",
                "description" => "",
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Promotion", 'traveler'),
        "base" => "st_promotion",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Icon ", 'traveler'),
                "param_name" => "st_icon",
                "description" => "",
                'value' => 'fa-clock-o',
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Discount", 'traveler'),
                "param_name" => "st_discount",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "attach_image",
                "holder" => "div",
                "heading" => __("Background Image", 'traveler'),
                "param_name" => "st_bg_img",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "heading" => __("Background Color", 'traveler'),
                "param_name" => "st_bg",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-4',
                'value' => '#002ca8'
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Opacity", 'traveler'),
                "param_name" => "st_opacity",
                "description" => __("Opacity : 0-100", 'traveler'),
                'edit_field_class' => 'vc_col-sm-4',
                'value' => '50',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Sub", 'traveler'),
                "param_name" => "st_sub",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Link", 'traveler'),
                "param_name" => "st_link",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
            )
        )
    ));
    vc_map(array(
        "name" => __("ST Rating Count", 'traveler'),
        "base" => "st_rating_count",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Icon ", 'traveler'),
                "param_name" => "st_icon",
                "description" => "",
                'value' => 'fa-flag',
                'edit_field_class' => 'vc_col-sm-12',
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Search", 'traveler'),
        "base" => "st_search",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Style", 'traveler'),
                "param_name" => "st_style_search",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Style 1', 'traveler') => 'style_1',
                    __('Style 2', 'traveler') => 'style_2'
                ),
            ),
            array(
                "type" => "dropdown",
                "admin_label" => true,
                "heading" => __("Show box shadow", 'traveler'),
                "param_name" => "st_box_shadow",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('No', 'traveler') => 'no',
                    __('Yes', 'traveler') => 'yes'
                ),
            ),
            array(
                "type" => "dropdown",
                "admin_label" => true,
                "heading" => __("Field size", 'traveler'),
                "param_name" => "field_size",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Large', 'traveler') => 'lg',
                    __('Medium', 'traveler') => 'md'
                ),
            ),
            array(
                'type' => 'st_checkbox',
                'admin_label' => true,
                'heading' => __('Select Tabs Search', 'traveler'),
                'param_name' => 'tabs_search',
                'description' => __('Please choose tab name to display in page', 'traveler'),
                'stype' => 'get_option',
                'sparam' => 'search_tabs',
                'std' => 'all'
            )
        )
    ));
    vc_map(array(
        "name" => __("ST Search Filter", 'traveler'),
        "base" => "st_search_filter",
        "as_parent" => array('only' => 'st_filter_price,st_filter_rate,st_filter_hotel_rate,st_filter_taxonomy'),
        "content_element" => true,
        "show_settings_on_create" => true,
        "js_view" => 'VcColumnView',
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Style", 'traveler'),
                "param_name" => "style",
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Dark', 'traveler') => 'dark',
                    __('Light', 'traveler') => 'light',
                ),
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Filter Price", 'traveler'),
        "base" => "st_filter_price",
        "content_element" => true,
        "as_child" => array('only' => 'st_search_filter'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Post Type", 'traveler'),
                "param_name" => "post_type",
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Hotel', 'traveler') => 'st_hotel',
                    __('Hotel Room', 'traveler') => 'hotel_room',
                    __('Rental', 'traveler') => 'st_rental',
                    __('Car', 'traveler') => 'st_cars',
                    __('Car Transfer', 'traveler') => 'car_transfer',
                    __('Tour', 'traveler') => 'st_tours',
                    __('Activity', 'traveler') => 'st_activity',
                    __('All Post Type', 'traveler') => 'all',
                ),
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Filter Rate", 'traveler'),
        "base" => "st_filter_rate",
        "content_element" => true,
        "as_child" => array('only' => 'st_search_filter'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title"
            )
        )
    ));
    vc_map(array(
        "name" => __("ST Filter Hotel Star Rating", 'traveler'),
        "base" => "st_filter_hotel_rate",
        "content_element" => true,
        "as_child" => array('only' => 'st_search_filter'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
            ),
        )
    ));

    $param_taxonomy = array(
        array(
            "type" => "textfield",
            "heading" => __("Title", 'traveler'),
            "param_name" => "title",
            "description" => "",
        ),
        array(
            "type" => "dropdown",
            "holder" => "div",
            "heading" => __("Post Type", 'traveler'),
            "param_name" => "st_post_type",
            "value" => array(
                __('--Select--', 'traveler') => '',
                __('Hotel', 'traveler') => 'st_hotel',
                __('Room Hotel', 'traveler') => 'hotel_room',
                __('Rental', 'traveler') => 'st_rental',
                __('Car', 'traveler') => 'st_cars',
                __('Tour', 'traveler') => 'st_tours',
                __('Activity', 'traveler') => 'st_activity',
            ),
        )
    );

    $list_post_type = array(
        __('Hotel', 'traveler') => 'st_hotel',
        __('Room Hotel', 'traveler') => 'hotel_room',
        __('Rental', 'traveler') => 'st_rental',
        __('Car', 'traveler') => 'st_cars',
        __('Tour', 'traveler') => 'st_tours',
        __('Activity', 'traveler') => 'st_activity',
    );
    foreach ($list_post_type as $k => $v) {
        $_param = array(
            "type" => "st_dropdown",
            "holder" => "div",
            "heading" => sprintf(__("Taxonomy %s", 'traveler'), $k),
            "param_name" => "taxonomy_" . $v,
            'stype' => 'list_tax',
            'sparam' => $v,
            'dependency' => array(
                'element' => 'st_post_type',
                'value' => array($v)
            ),
        );
        $param_taxonomy[] = $_param;
    }

    vc_map(array(
        "name" => __("ST Filter Taxonomy", 'traveler'),
        "base" => "st_filter_taxonomy",
        "content_element" => true,
        "as_child" => array('only' => 'st_search_filter'),
        "icon" => "icon-st",
        "params" => $param_taxonomy
    ));
    vc_map(array(
        "name" => __("[Ajax] ST Search Filter", 'traveler'),
        "base" => "st_search_filter_ajax",
        "as_parent" => array('only' => 'st_filter_price_ajax,st_filter_rate_ajax,st_filter_hotel_rate_ajax,st_filter_taxonomy_ajax'),
        "content_element" => true,
        "show_settings_on_create" => true,
        "js_view" => 'VcColumnView',
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Style", 'traveler'),
                "param_name" => "style",
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Dark', 'traveler') => 'dark',
                    __('Light', 'traveler') => 'light',
                ),
            ),
        )
    ));
    vc_map(array(
        "name" => __("[Ajax] ST Filter Price", 'traveler'),
        "base" => "st_filter_price_ajax",
        "content_element" => true,
        "as_child" => array('only' => 'st_search_filter_ajax'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Post Type", 'traveler'),
                "param_name" => "post_type",
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Hotel', 'traveler') => 'st_hotel',
                    __('Hotel Room', 'traveler') => 'hotel_room',
                    __('Rental', 'traveler') => 'st_rental',
                    __('Car', 'traveler') => 'st_cars',
                    __('Tour', 'traveler') => 'st_tours',
                    __('Activity', 'traveler') => 'st_activity',
                    __('All Post Type', 'traveler') => 'all',
                ),
            ),
        )
    ));
    vc_map(array(
        "name" => __("[Ajax] ST Filter Rate", 'traveler'),
        "base" => "st_filter_rate_ajax",
        "content_element" => true,
        "as_child" => array('only' => 'st_search_filter_ajax'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title"
            )
        )
    ));
    vc_map(array(
        "name" => __("[Ajax] ST Filter Hotel Star Rating", 'traveler'),
        "base" => "st_filter_hotel_rate_ajax",
        "content_element" => true,
        "as_child" => array('only' => 'st_search_filter_ajax'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Simple Location", 'traveler'),
        "base" => "st_simple_location",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Type", 'traveler'),
                "param_name" => "st_type",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Hotel', 'traveler') => 'st_hotel',
                    __('Car', 'traveler') => 'st_cars',
                    __('Tour', 'traveler') => 'st_tours',
                    __('Rental', 'traveler') => 'st_rental',
                    __('Activities', 'traveler') => 'st_activity',
                ),
            ),
            array(
                'type' => 'autocomplete',
                'heading' => esc_html__( 'Select Location', 'traveler' ),
                'param_name' => 'id',
                'settings' => array(
                    'multiple' => false,
                    'sortable' => true,
                    'groups' => true,
                ),
                'dependency' => array(
                    'element' => 'post_type',
                    'value' => array( 'ids' ),
                ),
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Single Search", 'traveler'),
        "base" => "st_single_search",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Title form search", 'traveler'),
                "param_name" => "st_title_search",
                "description" => "",
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Select form search", 'traveler'),
                "param_name" => "st_list_form",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Hotel', 'traveler') => 'hotel',
                    __('Rental', 'traveler') => 'rental',
                    __('Cars', 'traveler') => 'cars',
                    __('Activities', 'traveler') => 'activities',
                    __('Tours', 'traveler') => 'tours',
                    __('Hotel Room', 'traveler') => 'hotel_room',
                    __('All Post Type', 'traveler') => 'all-post-type'
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Form's direction", 'traveler'),
                "param_name" => "st_direction",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Vertical form', 'traveler') => 'vertical',
                    __('Horizontal form', 'traveler') => 'horizontal'
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Style", 'traveler'),
                "param_name" => "st_style_search",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Large', 'traveler') => 'style_1',
                    __('Normal', 'traveler') => 'style_2',
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Show box shadow", 'traveler'),
                "param_name" => "st_box_shadow",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('No', 'traveler') => 'no',
                    __('Yes', 'traveler') => 'yes'
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Field Size", 'traveler'),
                "param_name" => "field_size",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Large', 'traveler') => 'lg',
                    __('Normal', 'traveler') => 'sm',
                )
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Slide Location", 'traveler'),
        "base" => "st_slide_location",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Explore type", 'traveler'),
                "param_name" => "st_type",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Hotel', 'traveler') => 'st_hotel',
                    __('Car', 'traveler') => 'st_cars',
                    __('Tour', 'traveler') => 'st_tours',
                    __('Rental', 'traveler') => 'st_rental',
                    __('Activities', 'traveler') => 'st_activity',
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Show Only Featured Location", 'traveler'),
                "param_name" => "is_featured",
                "description" => __("Show Only Featured Location", 'traveler'),
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __("No", 'traveler') => 'no',
                    __("Yes", 'traveler') => 'yes',
                ),
            ),
            array(
                "type" => "st_checkbox",
                "holder" => "div",
                "heading" => __("Location type", 'traveler'),
                "param_name" => "st_location_type",
                "description" => "",
                'stype' => 'list_location_terms',
                'sparam' => '',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Number Location", 'traveler'),
                "param_name" => "st_number",
                "description" => "",
                'value' => 4,
                'dependency' => array(
                    'element' => 'is_featured',
                    'value' => array('yes')
                ),
            ),
            array(
                "type" => "st_post_type_location",
                "holder" => "div",
                "heading" => __("Select Location ", 'traveler'),
                "param_name" => "st_list_location",
                "description" => "",
                'dependency' => array(
                    'element' => 'is_featured',
                    'value' => array('no')
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Style show ", 'traveler'),
                "param_name" => "st_style",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Text info center', 'traveler') => 'style_1',
                    __('Show Search Box', 'traveler') => 'style_2',
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Effect", 'traveler'),
                "param_name" => "effect",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('None', 'traveler') => 'false',
                    __('Fade', 'traveler') => 'fade',
                    __('Back Slide', 'traveler') => 'backSlide',
                    __('Go Down', 'traveler') => 'goDown',
                    __('Fade Up', 'traveler') => 'fadeUp',
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Weather show ", 'traveler'),
                "param_name" => "st_weather",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Yes', 'traveler') => 'yes',
                    __('No', 'traveler') => 'no',
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Height", 'traveler'),
                'dependency' => array(
                    'element' => 'st_style',
                    'value' => 'style_1'
                ),
                "param_name" => "st_height",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Full height', 'traveler') => 'full',
                    __('Half height', 'traveler') => 'half',
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Link To", 'traveler'),
                "param_name" => "link_to",
                "description" => __("Link To", 'traveler'),
                'value' => array(
                    __("Page Search", 'traveler') => 'page_search',
                    __("Single", 'traveler') => 'single'
                ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Opacity Background", 'traveler'),
                "param_name" => "opacity",
                "description" => __(" Enter value form 0 - 0.5 - 1 ", 'traveler'),
                'value' => '0.5'
            ),
            array(
                'type' => 'st_checkbox',
                'admin_label' => true,
                'heading' => __('Select Tabs Search', 'traveler'),
                'param_name' => 'tabs_search',
                'description' => __('Please choose tab name to display in page', 'traveler'),
                'stype' => 'get_option',
                'sparam' => 'search_tabs',
                'std' => 'all'
            )
        )
    ));
    vc_map(
            array(
                "name" => __("ST Testimonial Slide", 'traveler'),
                "category" => "Shinetheme",
                "base" => "st_slide_testimonial",
                "as_parent" => array('only' => 'st_testimonial_item'),
                "content_element" => true,
                "show_settings_on_create" => true,
                "js_view" => 'VcColumnView',
                "icon" => "icon-st",
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "heading" => __("Effect", 'traveler'),
                        "param_name" => "effect",
                        "description" => "",
                        'value' => array(
                            __('--Select--', 'traveler') => '',
                            __('None', 'traveler') => 'false',
                            __('Fade', 'traveler') => 'fade',
                            __('Back Slide', 'traveler') => 'backSlide',
                            __('Go Down', 'traveler') => 'goDown',
                            __('Fade Up', 'traveler') => 'fadeUp',
                        ),
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "heading" => __("Speed", 'traveler'),
                        "param_name" => "st_speed",
                        "description" => __("Ex : 500ms", 'traveler'),
                        'value' => '500'
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "heading" => __("Auto Play Time", 'traveler'),
                        "param_name" => "st_play",
                        "description" => __("Set 0 to turn off autoplay", 'traveler'),
                        'value' => '4500'
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "heading" => __("Show form", 'traveler'),
                        "param_name" => "is_form",
                        "description" => __("Yes to show form search", 'traveler'),
                        'value' => array(
                            __('--Select--', 'traveler') => '',
                            __('Yes', 'traveler') => 'yes',
                            __('No', 'traveler') => 'no',
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "heading" => __("Background", 'traveler'),
                        "param_name" => "is_bgr",
                        "description" => __("No to tranparent background", 'traveler'),
                        'value' => array(
                            __('--Select--', 'traveler') => '',
                            __('Yes', 'traveler') => 'yes',
                            __('No', 'traveler') => 'no',
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "heading" => __("Items in screen", 'traveler'),
                        "param_name" => "items_per_row",
                        "description" => __("Items number in a carousel item", 'traveler'),
                        'value' => array(
                            __('--Select--', 'traveler') => '',
                            __('1', 'traveler') => '1',
                            __('2', 'traveler') => '2',
                            __('3', 'traveler') => '3',
                            __('4', 'traveler') => '4',
                        ),
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "heading" => __("Navigation", 'traveler'),
                        "param_name" => "navigation",
                        "description" => __("No to hide navigation", 'traveler'),
                        'value' => array(
                            __('--Select--', 'traveler') => '',
                            __('Yes', 'traveler') => 'true',
                            __('No', 'traveler') => 'false',
                        ),
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "heading" => __("Opacity Background", 'traveler'),
                        "param_name" => "opacity",
                        "description" => __(" Enter value form 0 - 0.5 - 1 ", 'traveler'),
                        'value' => '0.5'
                    ),
                    array(
                        'type' => 'st_checkbox',
                        'admin_label' => true,
                        'heading' => __('Select Tabs Search', 'traveler'),
                        'param_name' => 'tabs_search',
                        'description' => __('Please choose tab name to display in page', 'traveler'),
                        'stype' => 'get_option',
                        'sparam' => 'search_tabs',
                        'std' => 'all'
                    )
                )
            )
    );
    vc_map(
            array(
                "name" => __("Testimonial Item", 'traveler'),
                "base" => "st_testimonial_item",
                "content_element" => true,
                "as_child" => array('only' => 'st_slide_testimonial'),
                "icon" => "icon-st",
                "params" => array(
                    array(
                        "type" => "attach_image",
                        "holder" => "div",
                        "heading" => __("Avatar", 'traveler'),
                        "param_name" => "st_avatar",
                        "description" => "",
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "heading" => __("Name", 'traveler'),
                        "param_name" => "st_name",
                        "description" => "",
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "heading" => __("Sub", 'traveler'),
                        "param_name" => "st_sub",
                        "description" => "",
                    ),
                    array(
                        "type" => "textarea",
                        "holder" => "div",
                        "heading" => __("Description", 'traveler'),
                        "param_name" => "st_desc",
                        "description" => "",
                    ),
                    array(
                        "type" => "attach_image",
                        "holder" => "div",
                        "heading" => __("Background", 'traveler'),
                        "param_name" => "st_bg",
                        "description" => "",
                    ),
                )
            )
    );
    vc_map(array(
        "name" => __("ST Tab", 'traveler'),
        "base" => "st_tab",
        "as_parent" => array('only' => 'st_tab_item'),
        "content_element" => true,
        "show_settings_on_create" => false,
        "js_view" => 'VcColumnView',
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Element style", 'traveler'),
                "param_name" => "style",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Tour box style (Vertical ) ', 'traveler') => 'vertical',
                    __('Tour box style (Horizontal ) ', 'traveler') => 'horizontal',
                ),
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Tab item", 'traveler'),
        "base" => "st_tab_item",
        "content_element" => true,
        "as_child" => array('only' => 'st_tab'),
        "icon" => "icon-st",
        "params" => array(
            // add params same as with any other content element
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => "",
            ),
            array(
                "type" => "textfield",
                "heading" => __("icon", 'traveler'),
                "param_name" => "st_icon",
                "description" => "Example: fa fa-home" . "<a href='https://fortawesome.github.io/Font-Awesome/icons/'> Read more</a>",
            ),
            array(
                "type" => "textarea_html",
                "heading" => __("Content", 'traveler'),
                "param_name" => "content",
                "description" => "",
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Team", 'traveler'),
        "base" => "st_team",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Element style", 'traveler'),
                "param_name" => "st_style",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-12',
                'value' => array(
                    __('--Default--', 'traveler') => '',
                    __("Tour box style", 'traveler') => "st_tour_ver",
                )
            ),
            array(
                "type" => "attach_image",
                "holder" => "div",
                "heading" => __("Avatar", 'traveler'),
                "param_name" => "st_avatar",
                "description" => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Name", 'traveler'),
                "param_name" => "st_name",
                "description" => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Position", 'traveler'),
                "param_name" => "st_position",
                "description" => "",
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Social Effect ", 'traveler'),
                "param_name" => "st_effect",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-6',
                'value' => array(
                    __("Hover", 'traveler') => "",
                    __("Hold", 'traveler') => "hover-hold",
                )
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Position Social", 'traveler'),
                "param_name" => "st_position_social",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-6',
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __("Top Left", 'traveler') => "-top-left",
                    __("Top Right", 'traveler') => "-top-right",
                    __("Bottom Left", 'traveler') => "-bottom-left",
                    __("Bottom Right", 'traveler') => "-bottom-right",
                    __("Center", 'traveler') => "",
                    __("Center Top", 'traveler') => "-center-top",
                    __("Center Bottom", 'traveler') => "-center-bottom",
                )
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Facebook", 'traveler'),
                "param_name" => "st_facebook",
                "description" => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Twitter", 'traveler'),
                "param_name" => "st_twitter",
                "description" => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Google Plus", 'traveler'),
                "param_name" => "st_google",
                "description" => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Instagram", 'traveler'),
                "param_name" => "st_instagram",
                "description" => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("LinkedIn", 'traveler'),
                "param_name" => "st_linkedin",
                "description" => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Youtube", 'traveler'),
                "param_name" => "st_youtube",
                "description" => "",
            ),
            array(
                "type" => "textarea",
                "holder" => "div",
                "heading" => __("Other Social Link", 'traveler'),
                "param_name" => "st_other_social",
                "description" => "Ex : " . htmlentities("<li><a href='#' class='fa fa-facebook box-icon-normal round'></a></li>") . '<br>Social icons <a target="_blank"  href="http://fortawesome.github.io/Font-Awesome/icons/" >click here</a>',
            ),
            array(
                'type' => 'textarea',
                'holder' => 'div',
                'heading' => "Description",
                'param_name' => 'st_description',
                'description' => ''
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Testimonial", 'traveler'),
        "base" => "st_testimonial",
        "content_element" => true,
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Style", 'traveler'),
                "param_name" => "st_style",
                "description" => "",
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __("Style 1", 'traveler') => "style1",
                    __("Style 2", 'traveler') => "style2"
                )
            ),
            array(
                "type" => "attach_image",
                "holder" => "div",
                "heading" => __("Avatar", 'traveler'),
                "param_name" => "st_avatar",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                "type" => "colorpicker",
                "holder" => "div",
                "heading" => __("Text Color", 'traveler'),
                "param_name" => "st_color",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-4',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Testimonial color", 'traveler'),
                "param_name" => "st_testimonial_color",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-4',
                'value' => array(
                    __('No', 'traveler') => '',
                    __('Yes', 'traveler') => 'testimonial-color',
                )
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Name", 'traveler'),
                "param_name" => "st_name",
                "description" => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Sub", 'traveler'),
                "param_name" => "st_sub",
                "description" => "",
            ),
            array(
                "type" => "textarea",
                "holder" => "div",
                "heading" => __("Description", 'traveler'),
                "param_name" => "st_desc",
                "description" => "",
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Text Slide", 'traveler'),
        "base" => "st_text_slide",
        "category" => "Shinetheme",
        "content_element" => true,
        "show_settings_on_create" => true,
        "icon" => "icon-st",
        "params" => array(
            // add params same as with any other content element
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
            ),
            array(
                "type" => "textarea",
                "heading" => __("HTML Code", 'traveler'),
                "param_name" => "st_html_code",
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Show form search", 'traveler'),
                "param_name" => "show_search",
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __("Yes", 'traveler') => 'yes',
                    __("No", 'traveler') => 'no',
                )
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Opacity Background", 'traveler'),
                "param_name" => "opacity",
                "description" => __(" Enter value form 0 - 0.5 - 1 ", 'traveler'),
                'value' => '0.5'
            ),
            array(
                "type" => "attach_images",
                "heading" => __("Background", 'traveler'),
                "param_name" => "st_background",
            ),
            array(
                'type' => 'st_checkbox',
                'admin_label' => true,
                'heading' => __('Select Tabs Search', 'traveler'),
                'param_name' => 'tabs_search',
                'description' => __('Please choose tab name to display in page', 'traveler'),
                'stype' => 'get_option',
                'sparam' => 'search_tabs',
                'std' => 'all'
            )
        )
    ));
    vc_map(array(
        "name" => __("ST Title", 'traveler'),
        "base" => "st_title",
        "icon" => "icon-st",
        "category" => 'Shinetheme',
        'params' => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Heading", 'traveler'),
                "param_name" => "heading",
                'edit_field_class' => 'vc_col-sm-12',
                "description" => __("type 1 to H1", 'traveler'),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Text align", 'traveler'),
                "param_name" => "align",
                'edit_field_class' => 'vc_col-sm-12',
                "description" => __("http://www.w3schools.com/cssref/pr_text_text-align.asp", 'traveler'),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Color", 'traveler'),
                "param_name" => "color",
                'edit_field_class' => 'vc_col-sm-12',
                "description" => __("http://www.w3schools.com/cssref/css_colors.asp", 'traveler'),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Font Weight", 'traveler'),
                "param_name" => "font_weight",
                'edit_field_class' => 'vc_col-sm-12',
            ),
        ),
    ));
    vc_map(array(
        "name" => esc_html__("ST TravelPayouts API Widget", 'traveler'),
        "base" => "st_tp_widgets",
        "content_element" => true,
        'description' => esc_html__('Get widgets from TravelPayouts API', 'traveler'),
        "icon" => "icon-st",
        'category' => 'Shinetheme',
        "params" => array(
            // add params same as with any other content element
            array(
                "type" => "dropdown",
                "heading" => esc_html__("Widget Type", 'traveler'),
                "param_name" => "widget_type",
                'admin_label' => true,
                "description" => esc_html__('Select a widget type', 'traveler'),
                'value' => array(
                    esc_html__('Widget popular routes', 'traveler') => 'popular-router',
                    esc_html__('Flights Map', 'traveler') => 'flights-map',
                    esc_html__('Hotels Map', 'traveler') => 'hotels-map',
                    esc_html__('Calendar Widget', 'traveler') => 'calendar',
                    esc_html__('Hotel Widget', 'traveler') => 'hotel',
                    esc_html__('Hotels Selections', 'traveler') => 'hotel-selections',
                ),
                'std' => 'popular-router'
            ),
            array(
                "type" => "st_tp_locations",
                "heading" => esc_html__("Default Origin", 'traveler'),
                "param_name" => "pr_origin",
                "description" => esc_html__('Find a origin', 'traveler'),
                'location_type' => 'flight',
                'dependency' => array(
                    'element' => 'widget_type',
                    'value' => array('calendar')
                )
            ),
            array(
                "type" => "st_tp_locations",
                "heading" => esc_html__("Default Destination", 'traveler'),
                "param_name" => "pr_destination",
                "description" => esc_html__('Find a destination', 'traveler'),
                'location_type' => 'flight',
                'dependency' => array(
                    'element' => 'widget_type',
                    'value' => array('popular-router', 'flights-map', 'calendar')
                )
            ),
            array(
                "type" => "st_tp_locations",
                "heading" => esc_html__("Hotel", 'traveler'),
                "param_name" => "hotel_id",
                "description" => esc_html__('Find a hotel', 'traveler'),
                'location_type' => 'hotel_id',
                'dependency' => array(
                    'element' => 'widget_type',
                    'value' => array('hotel')
                )
            ),
            array(
                "type" => "st_tp_locations",
                "heading" => esc_html__("Location", 'traveler'),
                "param_name" => "map_lat_lon",
                "description" => esc_html__('Find a location', 'traveler'),
                'location_type' => 'hotel_map',
                'dependency' => array(
                    'element' => 'widget_type',
                    'value' => array('hotels-map')
                )
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Language', 'traveler'),
                'param_name' => 'language',
                'description' => esc_html__('Select a language', 'traveler'),
                'dependency' => array(
                    'element' => 'widget_type',
                    'value' => array('popular-router', 'hotel', 'hotels-map')
                ),
                'value' => array(
                    esc_html__('Russian', 'traveler') => 'ru',
                    esc_html__('English (Great Britan)', 'traveler') => 'en',
                    esc_html__('Thai', 'traveler') => 'th',
                ),
                'std' => 'en'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Locale', 'traveler'),
                'param_name' => 'language1',
                'description' => esc_html__('Select a locale', 'traveler'),
                'dependency' => array(
                    'element' => 'widget_type',
                    'value' => array('flights-map')
                ),
                'value' => array(
                    esc_html__('Deutsch (DE)', 'traveler') => 'de',
                    esc_html__('English', 'traveler') => 'en',
                    esc_html__('French', 'traveler') => 'fr',
                    esc_html__('Italian', 'traveler') => 'it',
                    esc_html__('Russian', 'traveler') => 'ru',
                    esc_html__('Thai', 'traveler') => 'th',
                ),
                'std' => 'en'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Language', 'traveler'),
                'param_name' => 'language2',
                'description' => esc_html__('Select a language', 'traveler'),
                'dependency' => array(
                    'element' => 'widget_type',
                    'value' => array('calendar')
                ),
                'value' => array(
                    esc_html__('Deutsch (DE)', 'traveler') => 'de',
                    esc_html__('English', 'traveler') => 'en',
                    esc_html__('French', 'traveler') => 'fr',
                    esc_html__('Italian', 'traveler') => 'it',
                    esc_html__('Russian', 'traveler') => 'ru',
                    esc_html__('Thai', 'traveler') => 'th',
                    esc_html__('Spanish', 'traveler') => 'es',
                    esc_html__('Chinese', 'traveler') => 'zh',
                    esc_html__('Brazilian', 'traveler') => 'br',
                    esc_html__('Japanese', 'traveler') => 'ja',
                    esc_html__('Portuguese', 'traveler') => 'pt',
                    esc_html__('Polish', 'traveler') => 'pl',
                ),
                'std' => 'en'
            ),
            // Hotel selection
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Widget\'s layout', 'traveler'),
                'param_name' => 'w_layout',
                'value' => array(
                    esc_html__('Full', 'traveler') => 'full',
                    esc_html__('Compact', 'traveler') => 'compact'
                ),
                'std' => 'full',
                'dependency' => array(
                    'element' => 'widget_type',
                    'value' => array('hotel-selections')
                ),
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Language', 'traveler'),
                'param_name' => 'language3',
                'description' => esc_html__('Select a language', 'traveler'),
                'dependency' => array(
                    'element' => 'widget_type',
                    'value' => array('hotel-selections')
                ),
                'value' => array(
                    esc_html__('Deutsch (DE)', 'traveler') => 'de',
                    esc_html__('English', 'traveler') => 'en',
                    esc_html__('French', 'traveler') => 'fr',
                    esc_html__('Italian', 'traveler') => 'it',
                    esc_html__('Russian', 'traveler') => 'ru',
                    esc_html__('Thai', 'traveler') => 'th',
                    esc_html__('Chinese', 'traveler') => 'zh',
                    esc_html__('Japanese', 'traveler') => 'ja',
                ),
                'std' => 'en'
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Max hotels in list', 'traveler'),
                'param_name' => 'limit',
                'value' => array(
                    esc_html__('1', 'traveler') => '1',
                    esc_html__('2', 'traveler') => '2',
                    esc_html__('3', 'traveler') => '3',
                    esc_html__('4', 'traveler') => '4',
                    esc_html__('5', 'traveler') => '5',
                    esc_html__('6', 'traveler') => '6',
                    esc_html__('7', 'traveler') => '7',
                    esc_html__('8', 'traveler') => '8',
                    esc_html__('9', 'traveler') => '9',
                    esc_html__('10', 'traveler') => '10'
                ),
                'std' => '10',
                'dependency' => array(
                    'element' => 'widget_type',
                    'value' => array('hotel-selections')
                ),
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Direct Flights Only', 'traveler'),
                'param_name' => 'direct',
                'value' => array(
                    esc_html__('Yes', 'traveler') => 'yes'
                ),
                'dependency' => array(
                    'element' => 'widget_type',
                    'value' => array('flights-map')
                ),
                'std' => 'yes'
            ),
            array(
                "type" => "textfield",
                "heading" => esc_html__("Additional marker", 'traveler'),
                "param_name" => "add_marker",
                'dependency' => array(
                    'element' => 'widget_type',
                    'value' => array('hotel', 'hotels-map', 'hotel-selections')
                )
            ),
            array(
                'type' => 'checkbox',
                'heading' => esc_html__('Map Controls', 'traveler'),
                'param_name' => 'map_control',
                'value' => array(
                    esc_html__('Draggable', 'traveler') => 'drag',
                    esc_html__('Disable zoom', 'traveler') => 'disable_zoom',
                    esc_html__('Scroll wheel', 'traveler') => 'scroll',
                    esc_html__('Map styled', 'traveler') => 'map_styled'
                ),
                'std' => 'drag',
                'dependency' => array(
                    'element' => 'widget_type',
                    'value' => array('hotels-map')
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Map Zoom', 'traveler'),
                'param_name' => 'map_zoom',
                'value' => '12',
                'std' => '12',
                'dependency' => array(
                    'element' => 'widget_type',
                    'value' => array('hotels-map')
                )
            ),
            array(
                'type' => 'textfield',
                'heading' => esc_html__('Marker Size', 'traveler'),
                'param_name' => 'marker_size',
                'value' => '16',
                'std' => '16',
                'dependency' => array(
                    'element' => 'widget_type',
                    'value' => array('hotels-map')
                )
            ),
            array(
                'type' => 'colorpicker',
                'heading' => esc_html__('Color Schema', 'traveler'),
                'param_name' => 'color_schema',
                'value' => '#00b1dd',
                'std' => '#00b1dd',
                'dependency' => array(
                    'element' => 'widget_type',
                    'value' => array('hotels-map')
                )
            ),
            array(
                'type' => 'dropdown',
                'heading' => esc_html__('Find By', 'traveler'),
                'param_name' => 'find_by',
                'value' => array(
                    esc_html__('Hotels', 'traveler') => 'hotels',
                    esc_html__('City', 'traveler') => 'city'
                ),
                'std' => 'city',
                'dependency' => array(
                    'element' => 'widget_type',
                    'value' => array('hotel-selections')
                ),
            ),
            array(
                "type" => "st_tp_locations",
                "heading" => esc_html__("City", 'traveler'),
                "param_name" => "city_data",
                "description" => esc_html__('Find a city', 'traveler'),
                'location_type' => 'city',
                'dependency' => array(
                    'element' => 'find_by',
                    'value' => array('city')
                )
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__('List Hotels', 'traveler'),
                'param_name' => 'list_hotel',
                'value' => '',
                'params' => array(
                    array(
                        "type" => "st_tp_locations",
                        "heading" => esc_html__("Hotel", 'traveler'),
                        "param_name" => "s_hotel_id",
                        'location_type' => 'hotel_id'
                    ),
                ),
                'callbacks' => array(
                    'after_add' => 'vcChartParamAfterAddCallback'
                ),
                'dependency' => array(
                    'element' => 'find_by',
                    'value' => array('hotels')
                ),
            )
        )
    ));
    vc_map(array(
        "name" => __("ST Twitter", 'traveler'),
        "base" => "st_twitter",
        "content_element" => true,
        "icon" => "icon-st",
        "params" => array(
            // add params same as with any other content element
            array(
                "type" => "textfield",
                "heading" => __("Number", 'traveler'),
                "param_name" => "st_twitter_number",
                "description" => "",
            ),
            array(
                "type" => "textfield",
                "heading" => __("User Twitter", 'traveler'),
                "param_name" => "st_twitter_user",
                "description" => ""
            ),
            array(
                "type" => "colorpicker",
                "heading" => __("Color text", 'traveler'),
                "param_name" => "st_color",
                "description" => "",
            ),
        )
    ));
    vc_map(array(
        "name" => __("ST Under construction", 'traveler'),
        "base" => "st_under_construction",
        "content_element" => true,
        "icon" => "icon-st",
        "params" => array(
            // add params same as with any other content element
            array(
                "type" => "textfield",
                "heading" => __("Short description", 'traveler'),
                "param_name" => "st_text",
                "description" => "",
            ),
            array(
                "type" => "textfield",
                "heading" => __("End Date", 'traveler'),
                "param_name" => "st_enddate",
                "description" => "",
            ),
        )
    ));


    vc_map(array(
        "name" => __("[Ajax] ST Filter Taxonomy", 'traveler'),
        "base" => "st_filter_taxonomy_ajax",
        "content_element" => true,
        "as_child" => array('only' => 'st_search_filter_ajax'),
        "icon" => "icon-st",
        "params" => $param_taxonomy
    ));

// List HALFT MAP
    vc_map(array(
        "name" => __("ST List Half Map", 'traveler'),
        "base" => "st_list_half_map",
        "class" => "",
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "content_element" => true,
        "show_settings_on_create" => true,
        "js_view" => 'VcColumnView',
        "as_parent" => array(
            'only' => 'st_list_half_map_field_hotel,st_list_half_map_field_rental,st_list_half_map_field_car,st_list_half_map_field_tour,st_list_half_map_field_activity,st_list_half_map_field_range_km',
        ),
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "value" => '',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => __("Type", 'traveler'),
                "param_name" => "type",
                "value" => array(
                    __("Normal", 'traveler') => 'normal',
                    __("Use for Search Result Page", 'traveler') => 'page_search'
                ),
            ),
            array(
                "type" => "st_post_type_location",
                "holder" => "div",
                "heading" => __("Select Location", 'traveler'),
                "param_name" => "st_list_location",
                "description" => "",
                /* "value"       => $list_location_data , */
                "dependency" =>
                array(
                    "element" => "type",
                    "value" => "normal"
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Type", 'traveler'),
                "param_name" => "st_type",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Hotel', 'traveler') => 'st_hotel',
                    __('Car', 'traveler') => 'st_cars',
                    __('Tour', 'traveler') => 'st_tours',
                    __('Rental', 'traveler') => 'st_rental',
                    __('Activities', 'traveler') => 'st_activity',
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Show Search Box", 'traveler'),
                "param_name" => "show_search_box",
                "description" => "",
                'value' => array(
                    __('Yes', 'traveler') => 'yes',
                    __('No', 'traveler') => 'no',
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Number", 'traveler'),
                "param_name" => "number",
                "value" => 12,
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Zoom", 'traveler'),
                "param_name" => "zoom",
                "value" => 13,
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => __("Map Position", 'traveler'),
                "param_name" => "map_position",
                "description" => "Map Position",
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Left', 'traveler') => "left",
                    __('Right', 'traveler') => "right",
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => __("Map Height", 'traveler'),
                "param_name" => "auto_height",
                "description" => "",
                'value' => array(
                    __("-- Select -- ", 'traveler') => '',
                    __('Auto', 'traveler') => 'auto',
                    __('Fixed', 'traveler') => 'fixed',
                ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Value", 'traveler'),
                "param_name" => "height",
                "description" => "pixels",
                "value" => 500,
                'edit_field_class' => 'vc_col-sm-12',
            /* 'dependency' => array(
              'element' => 'auto_height',
              'value' => array( 'auto' )
              ), */
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => __("Fit Bounds", 'traveler'),
                "param_name" => "fit_bounds",
                "description" => "on|off",
                'value' => array(
                    __('Off', 'traveler') => 'off',
                    __('On', 'traveler') => 'on',
                ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Style Map", 'traveler'),
                "param_name" => "style_map",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Normal', 'traveler') => 'normal',
                    __('Midnight', 'traveler') => 'midnight',
                    __('Family Fest', 'traveler') => 'family_fest',
                    __('Open Dark', 'traveler') => 'open_dark',
                    __('Riverside', 'traveler') => 'riverside',
                    __('Ozan', 'traveler') => 'ozan',
                ),
                'edit_field_class' => 'vc_col-sm-12',
            ),
        )
    ));
    /*
     * HOTEL
     * */
    vc_map(array(
        "name" => __("ST Search Field Hotel", 'traveler'),
        "base" => "st_list_half_map_field_hotel",
        "content_element" => true,
        "admin_label" => true,
        "as_child" => array('only' => 'st_list_half_map'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => __("Title field", 'traveler'),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Placeholder", 'traveler'),
                "param_name" => "placeholder",
                "value" => '',
            ),
            array(
                "type" => "dropdown",
                "heading" => "Select field",
                "param_name" => "st_select_field",
                "description" => __("Select field", 'traveler'),
                "value" => TravelHelper::st_get_field_search("st_hotel"),
            ),
            array(
                "type" => "st_dropdown",
                "heading" => "Select taxonomy",
                "param_name" => "st_select_taxonomy",
                "description" => __("Select taxonomy", 'traveler'),
                'stype' => 'list_post_tax',
                'sparam' => 'st_hotel',
                'dependency' => array(
                    'element' => 'st_select_field',
                    'value' => array('taxonomy')
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Advance fields",
                "param_name" => "st_advance_field",
                "description" => __("Advance fields", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "no",
                    __("Yes", 'traveler') => "yes",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Field required",
                "param_name" => "is_required",
                "description" => __("Field required", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "off",
                    __("Yes", 'traveler') => "on",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Size Col", 'traveler'),
                "param_name" => "st_col",
                "description" => __("Size Col", 'traveler'),
                'value' => array(
                    __("1 column", 'traveler') => 'col-md-1',
                    __("2 columns", 'traveler') => 'col-md-2',
                    __("3 columns", 'traveler') => 'col-md-3',
                    __("4 columns", 'traveler') => 'col-md-4',
                    __("5 columns", 'traveler') => 'col-md-5',
                    __("6 columns", 'traveler') => 'col-md-6',
                    __("7 columns", 'traveler') => 'col-md-7',
                    __("8 columns", 'traveler') => 'col-md-8',
                    __("9 columns", 'traveler') => 'col-md-9',
                    __("10 columns", 'traveler') => 'col-md-10',
                    __("11 columns", 'traveler') => 'col-md-11',
                    __("12 columns", 'traveler') => 'col-md-12',
                ),
            ),
        )
    ));
    /*
     * RENTAL
     * */
    vc_map(array(
        "name" => __("ST Search Field Rental", 'traveler'),
        "base" => "st_list_half_map_field_rental",
        "content_element" => true,
        "as_child" => array('only' => 'st_list_half_map'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => __("Title field", 'traveler'),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Placeholder", 'traveler'),
                "param_name" => "placeholder",
                "value" => '',
            ),
            array(
                "type" => "dropdown",
                "heading" => "Select field",
                "param_name" => "st_select_field",
                "description" => __("Select field", 'traveler'),
                "value" => TravelHelper::st_get_field_search("st_rental"),
            ),
            array(
                "type" => "st_dropdown",
                "heading" => "Select taxonomy",
                "param_name" => "st_select_taxonomy",
                "description" => __("Select taxonomy", 'traveler'),
                'stype' => 'list_post_tax',
                'sparam' => 'st_rental',
                'dependency' => array(
                    'element' => 'st_select_field',
                    'value' => array('taxonomy')
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Advance fields",
                "param_name" => "st_advance_field",
                "description" => __("Advance fields", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "no",
                    __("Yes", 'traveler') => "yes",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Field required",
                "param_name" => "is_required",
                "description" => __("Field required", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "off",
                    __("Yes", 'traveler') => "on",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Size Col", 'traveler'),
                "param_name" => "st_col",
                "description" => __("Size Col", 'traveler'),
                'value' => array(
                    __("1 column", 'traveler') => 'col-md-1',
                    __("2 columns", 'traveler') => 'col-md-2',
                    __("3 columns", 'traveler') => 'col-md-3',
                    __("4 columns", 'traveler') => 'col-md-4',
                    __("5 columns", 'traveler') => 'col-md-5',
                    __("6 columns", 'traveler') => 'col-md-6',
                    __("7 columns", 'traveler') => 'col-md-7',
                    __("8 columns", 'traveler') => 'col-md-8',
                    __("9 columns", 'traveler') => 'col-md-9',
                    __("10 columns", 'traveler') => 'col-md-10',
                    __("11 columns", 'traveler') => 'col-md-11',
                    __("12 columns", 'traveler') => 'col-md-12',
                ),
            ),
        )
    ));
    /*
     * CAR
     * */
    vc_map(array(
        "name" => __("ST Search Field Car", 'traveler'),
        "base" => "st_list_half_map_field_car",
        "content_element" => true,
        "as_child" => array('only' => 'st_list_half_map'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => __("Title field", 'traveler'),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Placeholder", 'traveler'),
                "param_name" => "placeholder",
                "value" => '',
            ),
            array(
                "type" => "dropdown",
                "heading" => "Select field",
                "param_name" => "st_select_field",
                "description" => __("Select field", 'traveler'),
                "value" => TravelHelper::st_get_field_search("st_cars"),
            ),
            array(
                "type" => "st_dropdown",
                "heading" => "Select taxonomy",
                "param_name" => "st_select_taxonomy",
                "description" => __("Select taxonomy", 'traveler'),
                'stype' => 'list_post_tax',
                'sparam' => 'st_cars',
                'dependency' => array(
                    'element' => 'st_select_field',
                    'value' => array('taxonomy')
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Advance fields",
                "param_name" => "st_advance_field",
                "description" => __("Advance fields", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "no",
                    __("Yes", 'traveler') => "yes",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Field required",
                "param_name" => "is_required",
                "description" => __("Field required", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "off",
                    __("Yes", 'traveler') => "on",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Size Col", 'traveler'),
                "param_name" => "st_col",
                "description" => __("Size Col", 'traveler'),
                'value' => array(
                    __("1 column", 'traveler') => 'col-md-1',
                    __("2 columns", 'traveler') => 'col-md-2',
                    __("3 columns", 'traveler') => 'col-md-3',
                    __("4 columns", 'traveler') => 'col-md-4',
                    __("5 columns", 'traveler') => 'col-md-5',
                    __("6 columns", 'traveler') => 'col-md-6',
                    __("7 columns", 'traveler') => 'col-md-7',
                    __("8 columns", 'traveler') => 'col-md-8',
                    __("9 columns", 'traveler') => 'col-md-9',
                    __("10 columns", 'traveler') => 'col-md-10',
                    __("11 columns", 'traveler') => 'col-md-11',
                    __("12 columns", 'traveler') => 'col-md-12',
                ),
            ),
        )
    ));
    /*
     * TOUR
     * */
    vc_map(array(
        "name" => __("ST Search Field Tour", 'traveler'),
        "base" => "st_list_half_map_field_tour",
        "content_element" => true,
        "as_child" => array('only' => 'st_list_half_map'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => __("Title field", 'traveler'),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Placeholder", 'traveler'),
                "param_name" => "placeholder",
                "value" => '',
            ),
            array(
                "type" => "dropdown",
                "heading" => "Select field",
                "param_name" => "st_select_field",
                "description" => __("Select field", 'traveler'),
                "value" => TravelHelper::st_get_field_search("st_tours"),
            ),
            array(
                "type" => "st_dropdown",
                "heading" => "Select taxonomy",
                "param_name" => "st_select_taxonomy",
                "description" => __("Select taxonomy", 'traveler'),
                'stype' => 'list_post_tax',
                'sparam' => 'st_tours',
                'dependency' => array(
                    'element' => 'st_select_field',
                    'value' => array('taxonomy')
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Advance fields",
                "param_name" => "st_advance_field",
                "description" => __("Advance fields", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "no",
                    __("Yes", 'traveler') => "yes",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Field required",
                "param_name" => "is_required",
                "description" => __("Field required", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "off",
                    __("Yes", 'traveler') => "on",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Size Col", 'traveler'),
                "param_name" => "st_col",
                "description" => __("Size Col", 'traveler'),
                'value' => array(
                    __("1 column", 'traveler') => 'col-md-1',
                    __("2 columns", 'traveler') => 'col-md-2',
                    __("3 columns", 'traveler') => 'col-md-3',
                    __("4 columns", 'traveler') => 'col-md-4',
                    __("5 columns", 'traveler') => 'col-md-5',
                    __("6 columns", 'traveler') => 'col-md-6',
                    __("7 columns", 'traveler') => 'col-md-7',
                    __("8 columns", 'traveler') => 'col-md-8',
                    __("9 columns", 'traveler') => 'col-md-9',
                    __("10 columns", 'traveler') => 'col-md-10',
                    __("11 columns", 'traveler') => 'col-md-11',
                    __("12 columns", 'traveler') => 'col-md-12',
                ),
            ),
        )
    ));
    /*
     * ACTIVITY
     * */
    vc_map(array(
        "name" => __("ST Search Field Activity", 'traveler'),
        "base" => "st_list_half_map_field_activity",
        "content_element" => true,
        "as_child" => array('only' => 'st_list_half_map'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => __("Title field", 'traveler'),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Placeholder", 'traveler'),
                "param_name" => "placeholder",
                "value" => '',
            ),
            array(
                "type" => "dropdown",
                "heading" => "Select field",
                "param_name" => "st_select_field",
                "description" => __("Select field", 'traveler'),
                "value" => TravelHelper::st_get_field_search("st_activity"),
            ),
            array(
                "type" => "st_dropdown",
                "heading" => "Select taxonomy",
                "param_name" => "st_select_taxonomy",
                "description" => __("Select taxonomy", 'traveler'),
                'stype' => 'list_post_tax',
                'sparam' => 'st_activity',
                'dependency' => array(
                    'element' => 'st_select_field',
                    'value' => array('taxonomy')
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Advance fields",
                "param_name" => "st_advance_field",
                "description" => __("Advance fields", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "no",
                    __("Yes", 'traveler') => "yes",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Field required",
                "param_name" => "is_required",
                "description" => __("Field required", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "off",
                    __("Yes", 'traveler') => "on",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Size Col", 'traveler'),
                "param_name" => "st_col",
                "description" => __("Size Col", 'traveler'),
                'value' => array(
                    __("1 column", 'traveler') => 'col-md-1',
                    __("2 columns", 'traveler') => 'col-md-2',
                    __("3 columns", 'traveler') => 'col-md-3',
                    __("4 columns", 'traveler') => 'col-md-4',
                    __("5 columns", 'traveler') => 'col-md-5',
                    __("6 columns", 'traveler') => 'col-md-6',
                    __("7 columns", 'traveler') => 'col-md-7',
                    __("8 columns", 'traveler') => 'col-md-8',
                    __("9 columns", 'traveler') => 'col-md-9',
                    __("10 columns", 'traveler') => 'col-md-10',
                    __("11 columns", 'traveler') => 'col-md-11',
                    __("12 columns", 'traveler') => 'col-md-12',
                ),
            ),
        )
    ));
    /*
     * Range KM
     * */
    vc_map(array(
        "name" => __("ST Search Field Range Kilometers", 'traveler'),
        "base" => "st_list_half_map_field_range_km",
        "content_element" => true,
        "admin_label" => true,
        "as_child" => array('only' => 'st_list_half_map'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => __("Title field", 'traveler'),
            ),
            array(
                "type" => "textfield",
                "heading" => __("Max Range Kilometers", 'traveler'),
                "param_name" => "max_range_km",
                "description" => __("Kilometer", 'traveler'),
                "value" => 20,
            ),
            array(
                "type" => "dropdown",
                "heading" => "Advance fields",
                "param_name" => "st_advance_field",
                "description" => __("Advance fields", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "no",
                    __("Yes", 'traveler') => "yes",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Size Col", 'traveler'),
                "param_name" => "st_col",
                "description" => __("Size Col", 'traveler'),
                'value' => array(
                    __("1 column", 'traveler') => 'col-md-1',
                    __("2 columns", 'traveler') => 'col-md-2',
                    __("3 columns", 'traveler') => 'col-md-3',
                    __("4 columns", 'traveler') => 'col-md-4',
                    __("5 columns", 'traveler') => 'col-md-5',
                    __("6 columns", 'traveler') => 'col-md-6',
                    __("7 columns", 'traveler') => 'col-md-7',
                    __("8 columns", 'traveler') => 'col-md-8',
                    __("9 columns", 'traveler') => 'col-md-9',
                    __("10 columns", 'traveler') => 'col-md-10',
                    __("11 columns", 'traveler') => 'col-md-11',
                    __("12 columns", 'traveler') => 'col-md-12',
                ),
            ),
        )
    ));

// END LIST HALF MAP---------------------------------------------------------------------------------------------
// ST List Map ---------------------------------------------------------------------------------------------
    vc_map(array(
        "name" => __("ST List Map", 'traveler'),
        "base" => "st_list_map",
        "class" => "",
        "icon" => "icon-st",
        "category" => "Shinetheme",
        "content_element" => true,
        "show_settings_on_create" => true,
        "js_view" => 'VcColumnView',
        "as_parent" => array(
            'only' => 'st_list_map_field_hotel,st_list_map_field_rental,st_list_map_field_car,st_list_map_field_tour,st_list_map_field_activity,st_list_map_field_range_km',
        ),
        "params" => array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "value" => '',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => __("Type", 'traveler'),
                "param_name" => "type",
                "value" => array(
                    __("Normal", 'traveler') => 'normal',
                    __("Use for Search Result Page", 'traveler') => 'page_search'
                ),
            ),
            array(
                "type" => "st_post_type_location",
                "holder" => "div",
                "heading" => __("Select Location", 'traveler'),
                "param_name" => "st_list_location",
                "description" => "",
                "dependency" =>
                array(
                    "element" => "type",
                    "value" => "normal"
                ),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Post Type", 'traveler'),
                "param_name" => "st_type",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Hotel', 'traveler') => 'st_hotel',
                    __('Car', 'traveler') => 'st_cars',
                    __('Tour', 'traveler') => 'st_tours',
                    __('Rental', 'traveler') => 'st_rental',
                    __('Activities', 'traveler') => 'st_activity',
                // __( 'All Post Type' , 'traveler' ) => 'st_hotel,st_cars,st_tours,st_rental,st_activity' ,
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Show Search Box", 'traveler'),
                "param_name" => "show_search_box",
                "description" => "",
                'value' => array(
                    __('Yes', 'traveler') => 'yes',
                    __('No', 'traveler') => 'no',
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Number", 'traveler'),
                "param_name" => "number",
                "value" => 12,
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Zoom", 'traveler'),
                "param_name" => "zoom",
                "value" => 13,
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "class" => "",
                "heading" => __("Fit Bounds", 'traveler'),
                "param_name" => "fit_bounds",
                "description" => "on|off",
                'value' => array(
                    __('Off', 'traveler') => 'off',
                    __('On', 'traveler') => 'on',
                ),
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Map Height", 'traveler'),
                "param_name" => "height",
                "description" => "pixels",
                "value" => 500,
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Style Map", 'traveler'),
                "param_name" => "style_map",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Normal', 'traveler') => 'normal',
                    __('Midnight', 'traveler') => 'midnight',
                    __('Family Fest', 'traveler') => 'family_fest',
                    __('Open Dark', 'traveler') => 'open_dark',
                    __('Riverside', 'traveler') => 'riverside',
                    __('Ozan', 'traveler') => 'ozan',
                ),
                'edit_field_class' => 'vc_col-sm-12 clear',
            ),
        )
    ));

    /*
     * HOTEL
     * */
    vc_map(array(
        "name" => __("ST Search Field Hotel", 'traveler'),
        "base" => "st_list_map_field_hotel",
        "content_element" => true,
        "admin_label" => true,
        "as_child" => array('only' => 'st_list_map'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => __("Title field", 'traveler'),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Placeholder", 'traveler'),
                "param_name" => "placeholder",
                "value" => '',
            ),
            array(
                "type" => "dropdown",
                "heading" => "Select field",
                "param_name" => "st_select_field",
                "description" => __("Select field", 'traveler'),
                "value" => TravelHelper::st_get_field_search("st_hotel"),
            ),
            array(
                "type" => "st_dropdown",
                "heading" => "Select taxonomy",
                "param_name" => "st_select_taxonomy",
                "description" => __("Select taxonomy", 'traveler'),
                'stype' => 'list_post_tax',
                'sparam' => 'st_hotel',
                'dependency' => array(
                    'element' => 'st_select_field',
                    'value' => array('taxonomy')
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Advance fields",
                "param_name" => "st_advance_field",
                "description" => __("Advance fields", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "no",
                    __("Yes", 'traveler') => "yes",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Field required",
                "param_name" => "is_required",
                "description" => __("Field required", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "off",
                    __("Yes", 'traveler') => "on",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Size Col", 'traveler'),
                "param_name" => "st_col",
                "description" => __("Size Col", 'traveler'),
                'value' => array(
                    __("1 column", 'traveler') => 'col-md-1',
                    __("2 columns", 'traveler') => 'col-md-2',
                    __("3 columns", 'traveler') => 'col-md-3',
                    __("4 columns", 'traveler') => 'col-md-4',
                    __("5 columns", 'traveler') => 'col-md-5',
                    __("6 columns", 'traveler') => 'col-md-6',
                    __("7 columns", 'traveler') => 'col-md-7',
                    __("8 columns", 'traveler') => 'col-md-8',
                    __("9 columns", 'traveler') => 'col-md-9',
                    __("10 columns", 'traveler') => 'col-md-10',
                    __("11 columns", 'traveler') => 'col-md-11',
                    __("12 columns", 'traveler') => 'col-md-12',
                ),
            ),
        )
    ));
    /*
     * RENTAL
     * */
    vc_map(array(
        "name" => __("ST Search Field Rental", 'traveler'),
        "base" => "st_list_map_field_rental",
        "content_element" => true,
        "as_child" => array('only' => 'st_list_map'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => __("Title field", 'traveler'),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Placeholder", 'traveler'),
                "param_name" => "placeholder",
                "value" => '',
            ),
            array(
                "type" => "dropdown",
                "heading" => "Select field",
                "param_name" => "st_select_field",
                "description" => __("Select field", 'traveler'),
                "value" => TravelHelper::st_get_field_search("st_rental"),
            ),
            array(
                "type" => "st_dropdown",
                "heading" => "Select taxonomy",
                "param_name" => "st_select_taxonomy",
                "description" => __("Select taxonomy", 'traveler'),
                'stype' => 'list_post_tax',
                'sparam' => 'st_rental',
                'dependency' => array(
                    'element' => 'st_select_field',
                    'value' => array('taxonomy')
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Advance fields",
                "param_name" => "st_advance_field",
                "description" => __("Advance fields", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "no",
                    __("Yes", 'traveler') => "yes",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Field required",
                "param_name" => "is_required",
                "description" => __("Field required", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "off",
                    __("Yes", 'traveler') => "on",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Size Col", 'traveler'),
                "param_name" => "st_col",
                "description" => __("Size Col", 'traveler'),
                'value' => array(
                    __("1 column", 'traveler') => 'col-md-1',
                    __("2 columns", 'traveler') => 'col-md-2',
                    __("3 columns", 'traveler') => 'col-md-3',
                    __("4 columns", 'traveler') => 'col-md-4',
                    __("5 columns", 'traveler') => 'col-md-5',
                    __("6 columns", 'traveler') => 'col-md-6',
                    __("7 columns", 'traveler') => 'col-md-7',
                    __("8 columns", 'traveler') => 'col-md-8',
                    __("9 columns", 'traveler') => 'col-md-9',
                    __("10 columns", 'traveler') => 'col-md-10',
                    __("11 columns", 'traveler') => 'col-md-11',
                    __("12 columns", 'traveler') => 'col-md-12',
                ),
            ),
        )
    ));
    /*
     * CAR
     * */
    vc_map(array(
        "name" => __("ST Search Field Car", 'traveler'),
        "base" => "st_list_map_field_car",
        "content_element" => true,
        "as_child" => array('only' => 'st_list_map'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => __("Title field", 'traveler'),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Placeholder", 'traveler'),
                "param_name" => "placeholder",
                "value" => '',
            ),
            array(
                "type" => "dropdown",
                "heading" => "Select field",
                "param_name" => "st_select_field",
                "description" => __("Select field", 'traveler'),
                "value" => TravelHelper::st_get_field_search("st_cars"),
            ),
            array(
                "type" => "st_dropdown",
                "heading" => "Select taxonomy",
                "param_name" => "st_select_taxonomy",
                "description" => __("Select taxonomy", 'traveler'),
                'stype' => 'list_post_tax',
                'sparam' => 'st_cars',
                'dependency' => array(
                    'element' => 'st_select_field',
                    'value' => array('taxonomy')
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Advance fields",
                "param_name" => "st_advance_field",
                "description" => __("Advance fields", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "no",
                    __("Yes", 'traveler') => "yes",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Field required",
                "param_name" => "is_required",
                "description" => __("Field required", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "off",
                    __("Yes", 'traveler') => "on",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Size Col", 'traveler'),
                "param_name" => "st_col",
                "description" => __("Size Col", 'traveler'),
                'value' => array(
                    __("1 column", 'traveler') => 'col-md-1',
                    __("2 columns", 'traveler') => 'col-md-2',
                    __("3 columns", 'traveler') => 'col-md-3',
                    __("4 columns", 'traveler') => 'col-md-4',
                    __("5 columns", 'traveler') => 'col-md-5',
                    __("6 columns", 'traveler') => 'col-md-6',
                    __("7 columns", 'traveler') => 'col-md-7',
                    __("8 columns", 'traveler') => 'col-md-8',
                    __("9 columns", 'traveler') => 'col-md-9',
                    __("10 columns", 'traveler') => 'col-md-10',
                    __("11 columns", 'traveler') => 'col-md-11',
                    __("12 columns", 'traveler') => 'col-md-12',
                ),
            ),
        )
    ));
    /*
     * TOUR
     * */
    vc_map(array(
        "name" => __("ST Search Field Tour", 'traveler'),
        "base" => "st_list_map_field_tour",
        "content_element" => true,
        "as_child" => array('only' => 'st_list_map'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => __("Title field", 'traveler'),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Placeholder", 'traveler'),
                "param_name" => "placeholder",
                "value" => '',
            ),
            array(
                "type" => "dropdown",
                "heading" => "Select field",
                "param_name" => "st_select_field",
                "description" => __("Select field", 'traveler'),
                "value" => TravelHelper::st_get_field_search("st_tours"),
            ),
            array(
                "type" => "st_dropdown",
                "heading" => "Select taxonomy",
                "param_name" => "st_select_taxonomy",
                "description" => __("Select taxonomy", 'traveler'),
                'stype' => 'list_post_tax',
                'sparam' => 'st_tours',
                'dependency' => array(
                    'element' => 'st_select_field',
                    'value' => array('taxonomy')
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Advance fields",
                "param_name" => "st_advance_field",
                "description" => __("Advance fields", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "no",
                    __("Yes", 'traveler') => "yes",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Field required",
                "param_name" => "is_required",
                "description" => __("Field required", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "off",
                    __("Yes", 'traveler') => "on",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Size Col", 'traveler'),
                "param_name" => "st_col",
                "description" => __("Size Col", 'traveler'),
                'value' => array(
                    __("1 column", 'traveler') => 'col-md-1',
                    __("2 columns", 'traveler') => 'col-md-2',
                    __("3 columns", 'traveler') => 'col-md-3',
                    __("4 columns", 'traveler') => 'col-md-4',
                    __("5 columns", 'traveler') => 'col-md-5',
                    __("6 columns", 'traveler') => 'col-md-6',
                    __("7 columns", 'traveler') => 'col-md-7',
                    __("8 columns", 'traveler') => 'col-md-8',
                    __("9 columns", 'traveler') => 'col-md-9',
                    __("10 columns", 'traveler') => 'col-md-10',
                    __("11 columns", 'traveler') => 'col-md-11',
                    __("12 columns", 'traveler') => 'col-md-12',
                ),
            ),
        )
    ));
    /*
     * ACTIVITY
     * */
    vc_map(array(
        "name" => __("ST Search Field Activity", 'traveler'),
        "base" => "st_list_map_field_activity",
        "content_element" => true,
        "as_child" => array('only' => 'st_list_map'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => __("Title field", 'traveler'),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Placeholder", 'traveler'),
                "param_name" => "placeholder",
                "value" => '',
            ),
            array(
                "type" => "dropdown",
                "heading" => "Select field",
                "param_name" => "st_select_field",
                "description" => __("Select field", 'traveler'),
                "value" => TravelHelper::st_get_field_search("st_activity"),
            ),
            array(
                "type" => "st_dropdown",
                "heading" => "Select taxonomy",
                "param_name" => "st_select_taxonomy",
                "description" => __("Select taxonomy", 'traveler'),
                'stype' => 'list_post_tax',
                'sparam' => 'st_activity',
                'dependency' => array(
                    'element' => 'st_select_field',
                    'value' => array('taxonomy')
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Advance fields",
                "param_name" => "st_advance_field",
                "description" => __("Advance fields", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "no",
                    __("Yes", 'traveler') => "yes",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Field required",
                "param_name" => "is_required",
                "description" => __("Field required", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "off",
                    __("Yes", 'traveler') => "on",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Size Col", 'traveler'),
                "param_name" => "st_col",
                "description" => __("Size Col", 'traveler'),
                'value' => array(
                    __("1 column", 'traveler') => 'col-md-1',
                    __("2 columns", 'traveler') => 'col-md-2',
                    __("3 columns", 'traveler') => 'col-md-3',
                    __("4 columns", 'traveler') => 'col-md-4',
                    __("5 columns", 'traveler') => 'col-md-5',
                    __("6 columns", 'traveler') => 'col-md-6',
                    __("7 columns", 'traveler') => 'col-md-7',
                    __("8 columns", 'traveler') => 'col-md-8',
                    __("9 columns", 'traveler') => 'col-md-9',
                    __("10 columns", 'traveler') => 'col-md-10',
                    __("11 columns", 'traveler') => 'col-md-11',
                    __("12 columns", 'traveler') => 'col-md-12',
                ),
            ),
        )
    ));
    /*
     * Range KM
     * */
    vc_map(array(
        "name" => __("ST Search Field Range Kilometers", 'traveler'),
        "base" => "st_list_map_field_range_km",
        "content_element" => true,
        "admin_label" => true,
        "as_child" => array('only' => 'st_list_map'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => __("Title field", 'traveler'),
            ),
            array(
                "type" => "textfield",
                "heading" => __("Max Range Kilometers", 'traveler'),
                "param_name" => "max_range_km",
                "description" => __("Kilometer", 'traveler'),
                "value" => 20,
            ),
            array(
                "type" => "dropdown",
                "heading" => "Advance fields",
                "param_name" => "st_advance_field",
                "description" => __("Advance fields", 'traveler'),
                "value" => array(
                    __("No", 'traveler') => "no",
                    __("Yes", 'traveler') => "yes",
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Size Col", 'traveler'),
                "param_name" => "st_col",
                "description" => __("Size Col", 'traveler'),
                'value' => array(
                    __("1 column", 'traveler') => 'col-md-1',
                    __("2 columns", 'traveler') => 'col-md-2',
                    __("3 columns", 'traveler') => 'col-md-3',
                    __("4 columns", 'traveler') => 'col-md-4',
                    __("5 columns", 'traveler') => 'col-md-5',
                    __("6 columns", 'traveler') => 'col-md-6',
                    __("7 columns", 'traveler') => 'col-md-7',
                    __("8 columns", 'traveler') => 'col-md-8',
                    __("9 columns", 'traveler') => 'col-md-9',
                    __("10 columns", 'traveler') => 'col-md-10',
                    __("11 columns", 'traveler') => 'col-md-11',
                    __("12 columns", 'traveler') => 'col-md-12',
                ),
            ),
        )
    ));
// End ST List Map ---------------------------------------------------------------------------------------------
//------------------------ ST SEarch FOrm --------------------------------------------------
    vc_map(array(
        "name" => __("ST Search Form", 'traveler'),
        "base" => "st_search_form",
        "as_parent" => array(
            'only' => 'st_search_field_hotel,st_search_field_rental,st_search_field_car,st_search_field_tour,st_search_field_activity',
        ),
        "content_element" => true,
        "show_settings_on_create" => true,
        "js_view" => 'VcColumnView',
        "icon" => "icon-st",
        'params' => array(
            array(
                "type" => "textfield",
                "heading" => __("Title Form", 'traveler'),
                "param_name" => "st_title_form",
                "description" => __("Title Form", 'traveler'),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Post Type", 'traveler'),
                "param_name" => "st_post_type",
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Hotel', 'traveler') => 'st_hotel',
                    __('Rental', 'traveler') => 'st_rental',
                    __('Car', 'traveler') => 'st_cars',
                    __('Tour', 'traveler') => 'st_tours',
                    __('Activity', 'traveler') => 'st_activity',
                ),
            ),
            array(
                "type" => "textfield",
                "heading" => __("Button search text", 'traveler'),
                "param_name" => "st_button_search",
                "description" => __("Button search text", 'traveler'),
                "value" => __("Search", 'traveler'),
            ),
        )
    ));

    /*
     * HOTEL
     * */
    vc_map(array(
        "name" => __("ST Search Field Hotel", 'traveler'),
        "base" => "st_search_field_hotel",
        "content_element" => true,
        "as_child" => array('only' => 'st_search_form'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => __("Title field", 'traveler'),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Select field",
                "param_name" => "st_select_field",
                "description" => __("Select field", 'traveler'),
                "value" => TravelHelper::st_get_field_search("st_hotel"),
            ),
            array(
                "type" => "st_dropdown",
                "heading" => "Select taxonomy",
                "param_name" => "st_select_taxonomy",
                "description" => __("Select taxonomy", 'traveler'),
                'stype' => 'list_post_tax',
                'sparam' => 'st_hotel',
                'dependency' => array(
                    'element' => 'st_select_field',
                    'value' => array('taxonomy')
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Size Col", 'traveler'),
                "param_name" => "st_col",
                "description" => __("Size Col", 'traveler'),
                'value' => array(
                    __("1 column", 'traveler') => 'col-md-1',
                    __("2 columns", 'traveler') => 'col-md-2',
                    __("3 columns", 'traveler') => 'col-md-3',
                    __("4 columns", 'traveler') => 'col-md-4',
                    __("5 columns", 'traveler') => 'col-md-5',
                    __("6 columns", 'traveler') => 'col-md-6',
                    __("7 columns", 'traveler') => 'col-md-7',
                    __("8 columns", 'traveler') => 'col-md-8',
                    __("9 columns", 'traveler') => 'col-md-9',
                    __("10 columns", 'traveler') => 'col-md-10',
                    __("11 columns", 'traveler') => 'col-md-11',
                    __("12 columns", 'traveler') => 'col-md-12',
                ),
            ),
        )
    ));
    /*
     * RENTAL
     * */
    vc_map(array(
        "name" => __("ST Search Field Rental", 'traveler'),
        "base" => "st_search_field_rental",
        "content_element" => true,
        "as_child" => array('only' => 'st_search_form'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => __("Title field", 'traveler'),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Select field",
                "param_name" => "st_select_field",
                "description" => __("Select field", 'traveler'),
                "value" => TravelHelper::st_get_field_search("st_rental"),
            ),
            array(
                "type" => "st_dropdown",
                "heading" => "Select taxonomy",
                "param_name" => "st_select_taxonomy",
                "description" => __("Select taxonomy", 'traveler'),
                'stype' => 'list_post_tax',
                'sparam' => 'st_rental',
                'dependency' => array(
                    'element' => 'st_select_field',
                    'value' => array('taxonomy')
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Size Col", 'traveler'),
                "param_name" => "st_col",
                "description" => __("Size Col", 'traveler'),
                'value' => array(
                    __("1 column", 'traveler') => 'col-md-1',
                    __("2 columns", 'traveler') => 'col-md-2',
                    __("3 columns", 'traveler') => 'col-md-3',
                    __("4 columns", 'traveler') => 'col-md-4',
                    __("5 columns", 'traveler') => 'col-md-5',
                    __("6 columns", 'traveler') => 'col-md-6',
                    __("7 columns", 'traveler') => 'col-md-7',
                    __("8 columns", 'traveler') => 'col-md-8',
                    __("9 columns", 'traveler') => 'col-md-9',
                    __("10 columns", 'traveler') => 'col-md-10',
                    __("11 columns", 'traveler') => 'col-md-11',
                    __("12 columns", 'traveler') => 'col-md-12',
                ),
            ),
        )
    ));
    /*
     * CAR
     * */
    vc_map(array(
        "name" => __("ST Search Field Car", 'traveler'),
        "base" => "st_search_field_car",
        "content_element" => true,
        "as_child" => array('only' => 'st_search_form'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => __("Title field", 'traveler'),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Select field",
                "param_name" => "st_select_field",
                "description" => __("Select field", 'traveler'),
                "value" => TravelHelper::st_get_field_search("st_cars"),
            ),
            array(
                "type" => "st_dropdown",
                "heading" => "Select taxonomy",
                "param_name" => "st_select_taxonomy",
                "description" => __("Select taxonomy", 'traveler'),
                'stype' => 'list_post_tax',
                'sparam' => 'st_cars',
                'dependency' => array(
                    'element' => 'st_select_field',
                    'value' => array('taxonomy')
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Size Col", 'traveler'),
                "param_name" => "st_col",
                "description" => __("Size Col", 'traveler'),
                'value' => array(
                    __("1 column", 'traveler') => 'col-md-1',
                    __("2 columns", 'traveler') => 'col-md-2',
                    __("3 columns", 'traveler') => 'col-md-3',
                    __("4 columns", 'traveler') => 'col-md-4',
                    __("5 columns", 'traveler') => 'col-md-5',
                    __("6 columns", 'traveler') => 'col-md-6',
                    __("7 columns", 'traveler') => 'col-md-7',
                    __("8 columns", 'traveler') => 'col-md-8',
                    __("9 columns", 'traveler') => 'col-md-9',
                    __("10 columns", 'traveler') => 'col-md-10',
                    __("11 columns", 'traveler') => 'col-md-11',
                    __("12 columns", 'traveler') => 'col-md-12',
                ),
            ),
        )
    ));
    /*
     * TOUR
     * */
    vc_map(array(
        "name" => __("ST Search Field Tour", 'traveler'),
        "base" => "st_search_field_tour",
        "content_element" => true,
        "as_child" => array('only' => 'st_search_form'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => __("Title field", 'traveler'),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Select field",
                "param_name" => "st_select_field",
                "description" => __("Select field", 'traveler'),
                "value" => TravelHelper::st_get_field_search("st_tours"),
            ),
            array(
                "type" => "st_dropdown",
                "heading" => "Select taxonomy",
                "param_name" => "st_select_taxonomy",
                "description" => __("Select taxonomy", 'traveler'),
                'stype' => 'list_post_tax',
                'sparam' => 'st_tours',
                'dependency' => array(
                    'element' => 'st_select_field',
                    'value' => array('taxonomy')
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Size Col", 'traveler'),
                "param_name" => "st_col",
                "description" => __("Size Col", 'traveler'),
                'value' => array(
                    __("1 column", 'traveler') => 'col-md-1',
                    __("2 columns", 'traveler') => 'col-md-2',
                    __("3 columns", 'traveler') => 'col-md-3',
                    __("4 columns", 'traveler') => 'col-md-4',
                    __("5 columns", 'traveler') => 'col-md-5',
                    __("6 columns", 'traveler') => 'col-md-6',
                    __("7 columns", 'traveler') => 'col-md-7',
                    __("8 columns", 'traveler') => 'col-md-8',
                    __("9 columns", 'traveler') => 'col-md-9',
                    __("10 columns", 'traveler') => 'col-md-10',
                    __("11 columns", 'traveler') => 'col-md-11',
                    __("12 columns", 'traveler') => 'col-md-12',
                ),
            ),
        )
    ));
    /*
     * ACTIVITY
     * */
    vc_map(array(
        "name" => __("ST Search Field Activity", 'traveler'),
        "base" => "st_search_field_activity",
        "content_element" => true,
        "as_child" => array('only' => 'st_search_form'),
        "icon" => "icon-st",
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __("Title", 'traveler'),
                "param_name" => "st_title",
                "description" => __("Title field", 'traveler'),
            ),
            array(
                "type" => "dropdown",
                "heading" => "Select field",
                "param_name" => "st_select_field",
                "description" => __("Select field", 'traveler'),
                "value" => TravelHelper::st_get_field_search("st_activity"),
            ),
            array(
                "type" => "st_dropdown",
                "heading" => "Select taxonomy",
                "param_name" => "st_select_taxonomy",
                "description" => __("Select taxonomy", 'traveler'),
                'stype' => 'list_post_tax',
                'sparam' => 'st_activity',
                'dependency' => array(
                    'element' => 'st_select_field',
                    'value' => array('taxonomy')
                ),
            ),
            array(
                "type" => "dropdown",
                "heading" => __("Size Col", 'traveler'),
                "param_name" => "st_col",
                "description" => __("Size Col", 'traveler'),
                'value' => array(
                    __("1 column", 'traveler') => 'col-md-1',
                    __("2 columns", 'traveler') => 'col-md-2',
                    __("3 columns", 'traveler') => 'col-md-3',
                    __("4 columns", 'traveler') => 'col-md-4',
                    __("5 columns", 'traveler') => 'col-md-5',
                    __("6 columns", 'traveler') => 'col-md-6',
                    __("7 columns", 'traveler') => 'col-md-7',
                    __("8 columns", 'traveler') => 'col-md-8',
                    __("9 columns", 'traveler') => 'col-md-9',
                    __("10 columns", 'traveler') => 'col-md-10',
                    __("11 columns", 'traveler') => 'col-md-11',
                    __("12 columns", 'traveler') => 'col-md-12',
                ),
            ),
        )
    ));
//------------------------ End ST SEarch FOrm --------------------------------------------------
// Activity
    if (st_check_service_available('st_activity')) {
        vc_map(array(
            "name" => __("ST Sum of Activity Search Results", 'traveler'),
            "base" => "st_search_activity_title",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Search Modal", 'traveler'),
                    "param_name" => "search_modal",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Yes', 'traveler') => '1',
                        __('No', 'traveler') => '0',
                    ),
                )
            )
        ));
        vc_map(array(
            "name" => __("ST Activity Detail Attribute", 'traveler'),
            "base" => "st_activity_detail_attribute",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Title", 'traveler'),
                    "param_name" => "title",
                    "description" => "",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Font Size", 'traveler'),
                    "param_name" => "font_size",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __("H1", 'traveler') => '1',
                        __("H2", 'traveler') => '2',
                        __("H3", 'traveler') => '3',
                        __("H4", 'traveler') => '4',
                        __("H5", 'traveler') => '5',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    "type" => "st_dropdown",
                    "holder" => "div",
                    "heading" => __("Select Taxonomy", 'traveler'),
                    "param_name" => "taxonomy",
                    "description" => "",
                    'stype' => 'list_tax',
                    'sparam' => 'st_activity',
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Item Size", 'traveler'),
                    "param_name" => "item_col",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        2 => 2,
                        3 => 3,
                        4 => 4,
                        5 => 5,
                        6 => 6,
                        7 => 7,
                        8 => 8,
                        9 => 9,
                        10 => 10,
                        11 => 11,
                        12 => 12,
                    ),
                )
            )
        ));
        vc_map(array(
            "name" => __("ST Activity Search Results", 'traveler'),
            "base" => "st_activiry_content_search",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "st_style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('List', 'traveler') => '1',
                        __('Grid', 'traveler') => '2',
                    ),
                ),
                array(
                    "type" => "st_checkbox",
                    "holder" => "div",
                    "heading" => __("Select Taxonomy Show", 'traveler'),
                    "param_name" => "taxonomy",
                    "description" => "",
                    'stype' => 'list_tax',
                    'sparam' => 'st_activity',
                )
            )
        ));
        vc_map(array(
            "name" => __("[Ajax] ST Activity Search Results", 'traveler'),
            "base" => "st_activiry_content_search_ajax",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "st_style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('List', 'traveler') => '1',
                        __('Grid', 'traveler') => '2',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("OrderBy Default", 'traveler'),
                    "param_name" => "st_orderby",
                    "description" => "",
                    "value" => array(
                        __('---None---', 'traveler') => '-1',
                        __('New', 'traveler') => 'new',
                        __('Random', 'traveler') => 'random',
                        __('Price', 'traveler') => 'price',
                        __('Featured', 'traveler') => 'featured',
                        __('Name', 'traveler') => 'name',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Sort By", 'traveler'),
                    "param_name" => "st_sortby",
                    "description" => "",
                    "value" => array(
                        __('Ascending', 'traveler') => 'asc',
                        __('Descending', 'traveler') => 'desc'
                    ),
                ),
                array(
                    "type" => "st_checkbox",
                    "holder" => "div",
                    "heading" => __("Select Taxonomy Show", 'traveler'),
                    "param_name" => "taxonomy",
                    "description" => "",
                    'stype' => 'list_tax',
                    'sparam' => 'st_activity',
                )
            )
        ));
        vc_map(array(
            "name" => __("ST Detailed Activity Gallery", 'traveler'),
            "base" => "st_activity_detail_photo",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Slide', 'traveler') => 'slide',
                        __('Grid', 'traveler') => 'grid',
                    ),
                )
            )
        ));

        $params = array(
            array(
                "type" => "textfield",
                'admin_label' => true,
                "heading" => __("List IDs of Activity (Optional)", 'traveler'),
                "param_name" => "st_ids",
                "description" => __("Ids separated by commas", 'traveler'),
                'value' => "",
            ),
            array(
                "type" => "textfield",
                'admin_label' => true,
                "heading" => __("Number", 'traveler'),
                "param_name" => "st_number",
                "description" => "",
                'value' => 4,
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Order By", 'traveler'),
                "param_name" => "st_orderby",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-3',
                'value' => function_exists('st_get_list_order_by') ? st_get_list_order_by(
                        array(
                            __('Price', 'traveler') => 'sale',
                            __('Rate', 'traveler') => 'rate',
                            __('Featured', 'traveler') => 'featured',
                        /* __( 'Discount rate' , 'traveler' ) => 'discount' */
                        )
                ) : array(),
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Order", 'traveler'),
                "param_name" => "st_order",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Asc', 'traveler') => 'asc',
                    __('Desc', 'traveler') => 'desc'
                ),
                'edit_field_class' => 'vc_col-sm-3',
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Item per row", 'traveler'),
                "param_name" => "st_of_row",
                'edit_field_class' => 'vc_col-sm-3',
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('One', 'traveler') => '1',
                    __('Four', 'traveler') => '4',
                    __('Three', 'traveler') => '3',
                    __('Two', 'traveler') => '2',
                ),
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Only in Featured Location", 'traveler'),
                "param_name" => "only_featured_location",
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('No', 'traveler') => 'no',
                    __('Yes', 'traveler') => 'yes',
                ),
            ),
            array(
                "type" => "st_list_location",
                'admin_label' => true,
                "heading" => __("Location", 'traveler'),
                "param_name" => "st_location",
                "description" => __("Location", 'traveler'),
                "dependency" =>
                array(
                    "element" => "only_featured_location",
                    "value" => "no"
                ),
            ),
        );
        $list_tax = TravelHelper::get_object_taxonomies_service('st_activity');
        if (!empty($list_tax)) {
            foreach ($list_tax as $name => $label) {
                $params[] = array(
                    'type' => 'st_checkbox',
                    'heading' => $label,
                    'param_name' => 'taxonomies' . '--' . $name,
                    'stype' => 'list_terms',
                    'sparam' => $name,
                );
            }
        }

        vc_map(array(
            "name" => __("ST List of Activities", 'traveler'),
            "base" => "st_list_activity",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => $params
        ));

        $params = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
                "value" => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("List ID in Tour", 'traveler'),
                "param_name" => "st_ids",
                "description" => __("Ids separated by commas", 'traveler'),
                'value' => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Number of Posts", 'traveler'),
                "param_name" => "posts_per_page",
                "description" => "",
                "value" => "",
            ),
            array(
                "type" => "st_dropdown",
                "holder" => "div",
                "heading" => __("Sort By Taxonomy", 'traveler'),
                "param_name" => "sort_taxonomy",
                "description" => "",
                'stype' => 'list_tax',
                'sparam' => 'st_activity',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Order By", 'traveler'),
                "param_name" => "st_orderby",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-6',
                'value' => function_exists('st_get_list_order_by') ? st_get_list_order_by() : array(),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Order", 'traveler'),
                "param_name" => "st_order",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Asc', 'traveler') => 'asc',
                    __('Desc', 'traveler') => 'desc'
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
        );
        $data_vc = STActivity::get_taxonomy_and_id_term_tour();
        $params = array_merge($params, $data_vc['list_vc']);
        vc_map(array(
            "name" => __("ST List activity related", 'traveler'),
            "base" => "st_list_activity_related",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => $params
        ));


        vc_map(
                array(
                    "name" => __("ST Location list activity ", 'traveler'),
                    "base" => "st_location_list_activity",
                    "content_element" => true,
                    "icon" => "icon-st",
                    "category" => "Shinetheme",
                    "params" => $location_list_params
        ));
    }
// End Activity
// ST CARS
    if (st_check_service_available('st_cars')) {
        vc_map(array(
            "name" => __("ST Cars Attribute", 'traveler'),
            "base" => "st_cars_attribute",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Title", 'traveler'),
                    "param_name" => "title",
                    "description" => "",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Font Size", 'traveler'),
                    "param_name" => "font_size",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __("H1", 'traveler') => '1',
                        __("H2", 'traveler') => '2',
                        __("H3", 'traveler') => '3',
                        __("H4", 'traveler') => '4',
                        __("H5", 'traveler') => '5',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    "type" => "st_dropdown",
                    "holder" => "div",
                    "heading" => __("Select Taxonomy", 'traveler'),
                    "param_name" => "taxonomy",
                    "description" => "",
                    'stype' => 'list_tax',
                    'sparam' => 'st_cars',
                ),
            )
        ));
        vc_map(array(
            "name" => __("ST Cars Search Results", 'traveler'),
            "base" => "st_cars_content_search",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "st_style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('List', 'traveler') => '1',
                        __('Grid', 'traveler') => '2',
                    ),
                )
            )
        ));
        vc_map(array(
            "name" => __("[Ajax] ST Cars Search Results", 'traveler'),
            "base" => "st_cars_content_search_ajax",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "st_style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('List', 'traveler') => '1',
                        __('Grid', 'traveler') => '2',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("OrderBy Default", 'traveler'),
                    "param_name" => "st_orderby",
                    "description" => "",
                    "value" => array(
                        __('---None---', 'traveler') => '-1',
                        __('New', 'traveler') => 'new',
                        __('Random', 'traveler') => 'random',
                        __('Price', 'traveler') => 'price',
                        __('Featured', 'traveler') => 'featured',
                        __('Name', 'traveler') => 'name',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Sort By", 'traveler'),
                    "param_name" => "st_sortby",
                    "description" => "",
                    "value" => array(
                        __('Ascending', 'traveler') => 'asc',
                        __('Descending', 'traveler') => 'desc'
                    ),
                ),
            )
        ));
        vc_map(array(
            "name" => __("ST Sum of Cars Search Results", 'traveler'),
            "base" => "st_search_cars_title",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Search Modal", 'traveler'),
                    "param_name" => "search_modal",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Yes', 'traveler') => '1',
                        __('No', 'traveler') => '0',
                    ),
                )
            )
        ));
        vc_map(array(
            "name" => __("ST Detailed Car Gallery", 'traveler'),
            "base" => "st_car_detail_photo",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Slide', 'traveler') => 'slide',
                        __('Grid', 'traveler') => 'grid',
                    ),
                )
            )
        ));
        vc_map(array(
            "name" => __("ST Cars Price ", 'traveler'),
            "base" => "st_cars_price",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "st_style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Style 1 column', 'traveler') => '1',
                        __('Style 2 column', 'traveler') => '2'
                    ),
                )
            )
        ));
        vc_map(array(
            "name" => __("ST Cruise Photo", 'traveler'),
            "base" => "st_cruise_photo",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Slide', 'traveler') => 'slide',
                        __('Grid', 'traveler') => 'grid',
                    ),
                )
            )
        ));

        $param = array(
            array(
                "type" => "textfield",
                'admin_label' => true,
                "heading" => __("List ID in Car", 'traveler'),
                "param_name" => "st_ids",
                "description" => __("Ids separated by commas", 'traveler'),
                'value' => "",
            ),
            array(
                "type" => "textfield",
                'admin_label' => true,
                "heading" => __("Number cars", 'traveler'),
                "param_name" => "st_number_cars",
                "description" => "",
                'value' => 4,
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Order By", 'traveler'),
                "param_name" => "st_orderby",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-6',
                'value' => function_exists('st_get_list_order_by') ? st_get_list_order_by(
                        array(
                            __('Sale', 'traveler') => 'sale',
                            __('Featured', 'traveler') => 'featured',
                        )
                ) : array(),
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Order", 'traveler'),
                "param_name" => "st_order",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Asc', 'traveler') => 'asc',
                    __('Desc', 'traveler') => 'desc'
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Items per row", 'traveler'),
                "param_name" => "st_cars_of_row",
                'edit_field_class' => 'vc_col-sm-12',
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Four', 'traveler') => 4,
                    __('Three', 'traveler') => 3,
                    __('Two', 'traveler') => 2,
                ),
            ),
            array(
                "type" => "st_list_location",
                'admin_label' => true,
                "heading" => __("Location", 'traveler'),
                "param_name" => "st_location",
                "description" => __("Location", 'traveler')
            ),
        );

        $list_tax = TravelHelper::get_object_taxonomies_service('st_cars');
        if (!empty($list_tax)) {
            foreach ($list_tax as $name => $label) {
                $param[] = array(
                    'type' => 'st_checkbox',
                    'heading' => $label,
                    'param_name' => 'taxonomies' . '--' . $name,
                    'stype' => 'list_terms',
                    'sparam' => $name,
                );
            }
        }

        vc_map(array(
            "name" => __("ST List of Cars", 'traveler'),
            "base" => "st_list_cars",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => $param
        ));

        $params = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
                "value" => "",
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("List ID in Tour", 'traveler'),
                "param_name" => "st_ids",
                "description" => __("Ids separated by commas", 'traveler'),
                'value' => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Number of Posts", 'traveler'),
                "param_name" => "posts_per_page",
                "description" => "",
                "value" => "",
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "st_dropdown",
                "holder" => "div",
                "heading" => __("Sort By Taxonomy", 'traveler'),
                "param_name" => "sort_taxonomy",
                "description" => "",
                'stype' => 'list_tax',
                'sparam' => 'st_cars',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Order By", 'traveler'),
                "param_name" => "st_orderby",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-6',
                'value' => function_exists('st_get_list_order_by') ? st_get_list_order_by() : array(),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Order", 'traveler'),
                "param_name" => "st_order",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Asc', 'traveler') => 'asc',
                    __('Desc', 'traveler') => 'desc'
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
        );
        $data_vc = STCars::get_taxonomy_and_id_term_tour();
        $params = array_merge($params, $data_vc['list_vc']);
        vc_map(array(
            "name" => __("ST List cars related", 'traveler'),
            "base" => "st_list_car_related",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => $params
        ));


        vc_map(
                array(
                    "name" => __("ST Location list car ", 'traveler'),
                    "base" => "st_location_list_car",
                    "content_element" => true,
                    "icon" => "icon-st",
                    "category" => "Shinetheme",
                    "params" => $location_list_params
        ));


        vc_map(array(
            "name" => __("ST Car Transfer Search Result", 'traveler'),
            "base" => "st_search_car_transfer_result",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('List', 'traveler') => '1',
                        __('Grid', 'traveler') => '2',
                    ),
                )
            )
        ));
    }
// End ST CARS
// ST Hotel
    if (st_check_service_available('st_hotel')) {
        vc_map(array(
            "name" => __("ST Hotel Detail Attribute", 'traveler'),
            "base" => "st_hotel_detail_attribute",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Title", 'traveler'),
                    "param_name" => "title",
                    "description" => "",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Font Size", 'traveler'),
                    "param_name" => "font_size",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __("H1", 'traveler') => '1',
                        __("H2", 'traveler') => '2',
                        __("H3", 'traveler') => '3',
                        __("H4", 'traveler') => '4',
                        __("H5", 'traveler') => '5',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    "type" => "st_dropdown",
                    "holder" => "div",
                    "heading" => __("Select Taxonomy", 'traveler'),
                    "param_name" => "taxonomy",
                    "description" => "",
                    'stype' => 'list_tax',
                    'sparam' => 'st_hotel',
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Item Size", 'traveler'),
                    "param_name" => "item_col",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        2 => 2,
                        3 => 3,
                        4 => 4,
                        5 => 5,
                        6 => 6,
                        7 => 7,
                        8 => 8,
                        9 => 9,
                        10 => 10,
                        11 => 11,
                        12 => 12,
                    ),
                )
            )
        ));
        vc_map(array(
            "name" => __("ST Hotel Search Result", 'traveler'),
            "base" => "st_search_hotel_result",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('List', 'traveler') => '1',
                        __('Grid', 'traveler') => '2',
                    ),
                ),
                array(
                    "type" => "st_checkbox",
                    "holder" => "div",
                    "heading" => __("Select Taxonomy Show", 'traveler'),
                    "param_name" => "taxonomy",
                    "description" => "",
                    'stype' => 'list_tax',
                    'sparam' => 'st_hotel',
                ),
            )
        ));
        vc_map(array(
            "name" => __("[Ajax] ST Hotel Search Result", 'traveler'),
            "base" => "st_search_hotel_result_ajax",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('List', 'traveler') => '1',
                        __('Grid', 'traveler') => '2',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("OrderBy Default", 'traveler'),
                    "param_name" => "st_orderby",
                    "description" => "",
                    "value" => array(
                        __('---None---', 'traveler') => '-1',
                        __('New', 'traveler') => 'new',
                        __('Random', 'traveler') => 'random',
                        __('Price', 'traveler') => 'price',
                        __('Featured', 'traveler') => 'featured',
                        __('Name', 'traveler') => 'name',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Sort By", 'traveler'),
                    "param_name" => "st_sortby",
                    "description" => "",
                    "value" => array(
                        __('Ascending', 'traveler') => 'asc',
                        __('Descending', 'traveler') => 'desc'
                    ),
                ),
                array(
                    "type" => "st_checkbox",
                    "holder" => "div",
                    "heading" => __("Select Taxonomy Show", 'traveler'),
                    "param_name" => "taxonomy",
                    "description" => "",
                    'stype' => 'list_tax',
                    'sparam' => 'st_hotel',
                ),
            )
        ));
        vc_map(array(
            "name" => __("ST Sum of Hotel Search Results", 'traveler'),
            "base" => "st_search_hotel_title",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Search Modal", 'traveler'),
                    "param_name" => "search_modal",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Yes', 'traveler') => '1',
                        __('No', 'traveler') => '0',
                    ),
                )
            )
        ));
        vc_map(array(
            "name" => __("ST Hotel List Room", 'traveler'),
            "base" => "st_hotel_list_room",
            "content_element" => true,
            "category" => "Shinetheme",
            "icon" => "icon-st",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "heading" => __("Rows", 'traveler'),
                    "param_name" => "st_rows",
                    "value" => array(
                        __("--Select--", 'traveler') => "",
                        __("1", 'traveler') => "1",
                        __("2", 'traveler') => "2",
                        __("3", 'traveler') => "3",
                        __("4", 'traveler') => "4",
                        __("5", 'traveler') => "5",
                        __("6", 'traveler') => "6",
                    )
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Items in a row", 'traveler'),
                    "param_name" => "st_items_in_row",
                    "value" => array(
                        __("--Select--", 'traveler') => "",
                        __("1", 'traveler') => "1",
                        __("2", 'traveler') => "2",
                        __("3", 'traveler') => "3",
                        __("4", 'traveler') => "4",
                        __("6", 'traveler') => "6",
                    )
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Show Title", 'traveler'),
                    "param_name" => "is_title",
                    "description" => "",
                    "value" => array(
                        __("--Select--", 'traveler') => "",
                        __("Yes", 'traveler') => "yes",
                        __("No", 'traveler') => "no",
                    )
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Show Price", 'traveler'),
                    "param_name" => "is_price",
                    "description" => "",
                    "value" => array(
                        __("--Select--", 'traveler') => "",
                        __("Yes", 'traveler') => "yes",
                        __("No", 'traveler') => "no",
                    )
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Show Facilities", 'traveler'),
                    "param_name" => "is_facilities",
                    "description" => "",
                    "value" => array(
                        __("--Select--", 'traveler') => "",
                        __("Yes", 'traveler') => "yes",
                        __("No", 'traveler') => "no",
                    )
                ),
            )
        ));
        vc_map(array(
            "name" => __("ST Detailed Hotel Gallery", 'traveler'),
            "base" => "st_hotel_detail_photo",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Slide', 'traveler') => 'slide',
                        __('Grid', 'traveler') => 'grid',
                    ),
                )
            )
        ));
        vc_map(array(
            "name" => __("ST Hotel Room Search Result", 'traveler'),
            "base" => "st_search_hotel_room_result",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('List', 'traveler') => '1',
                        __('Grid', 'traveler') => '2',
                    ),
                ),
                array(
                    "type" => "st_checkbox",
                    "holder" => "div",
                    "heading" => __("Select Taxonomy Show", 'traveler'),
                    "param_name" => "taxonomy",
                    "description" => "",
                    'stype' => 'list_tax',
                    'sparam' => 'hotel_room',
                ),
            )
        ));
        vc_map(array(
            "name" => __("[Ajax] ST Hotel Room Search Result", 'traveler'),
            "base" => "st_search_hotel_room_result_ajax",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('List', 'traveler') => '1',
                        __('Grid', 'traveler') => '2',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("OrderBy Default", 'traveler'),
                    "param_name" => "st_orderby",
                    "description" => "",
                    "value" => array(
                        __('---None---', 'traveler') => '-1',
                        __('New', 'traveler') => 'new',
                        __('Random', 'traveler') => 'random',
                        __('Price', 'traveler') => 'price',
                        __('Featured', 'traveler') => 'featured',
                        __('Name', 'traveler') => 'name',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Sort By", 'traveler'),
                    "param_name" => "st_sortby",
                    "description" => "",
                    "value" => array(
                        __('Ascending', 'traveler') => 'asc',
                        __('Descending', 'traveler') => 'desc'
                    ),
                ),
                array(
                    "type" => "st_checkbox",
                    "holder" => "div",
                    "heading" => __("Select Taxonomy Show", 'traveler'),
                    "param_name" => "taxonomy",
                    "description" => "",
                    'stype' => 'list_tax',
                    'sparam' => 'hotel_room',
                ),
            )
        ));
        vc_map(array(
            "name" => __("ST Sum of Hotel Room Search Results", 'traveler'),
            "base" => "st_search_hotel_room_title",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Search Modal", 'traveler'),
                    "param_name" => "search_modal",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Yes', 'traveler') => '1',
                        __('No', 'traveler') => '0',
                    ),
                )
            )
        ));

        $params = array(
            array(
                "type" => "textfield",
                'admin_label' => true,
                "heading" => __("List ID in Hotel", 'traveler'),
                "param_name" => "st_ids",
                "description" => __("Ids separated by commas", 'traveler'),
                'value' => "",
            ),
            array(
                "type" => "textfield",
                'admin_label' => true,
                "heading" => __("Number hotel", 'traveler'),
                "param_name" => "st_number_ht",
                "description" => "",
                'value' => 4,
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Order By", 'traveler'),
                "param_name" => "st_orderby",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-6',
                'value' => function_exists('st_get_list_order_by') ? st_get_list_order_by(
                        array(
                            __('Sale', 'traveler') => 'sale',
                            __('Rate', 'traveler') => 'rate',
                            __('Discount rate', 'traveler') => 'discount',
                            __('Featured', 'traveler') => 'featured',
                        )
                ) : array(),
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Order", 'traveler'),
                "param_name" => "st_order",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Asc', 'traveler') => 'asc',
                    __('Desc', 'traveler') => 'desc'
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Style hotel", 'traveler'),
                "param_name" => "st_style_ht",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Hot Deals', 'traveler') => 'hot-deals',
                    __('Grid', 'traveler') => 'grid',
                    __('Grid Style 2', 'traveler') => 'grid2',
                ),
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Items per row", 'traveler'),
                "param_name" => "st_ht_of_row",
                'edit_field_class' => 'vc_col-sm-12',
                "description" => __('Noticed: the field "Items per row" only applicable to "Last Minute Deal" style', 'traveler'),
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Four', 'traveler') => 4,
                    __('Three', 'traveler') => 3,
                    __('Two', 'traveler') => 2,
                ),
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Only in Featured Location", 'traveler'),
                "param_name" => "only_featured_location",
                'edit_field_class' => 'vc_col-sm-12',
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('No', 'traveler') => 'no',
                    __('Yes', 'traveler') => 'yes',
                ),
            ),
            array(
                "type" => "st_list_location",
                'admin_label' => true,
                "heading" => __("Location", 'traveler'),
                "param_name" => "st_location",
                "description" => __("Location", 'traveler'),
                "dependency" =>
                array(
                    "element" => "only_featured_location",
                    "value" => "no"
                ),
            ),
        );

        $list_tax = TravelHelper::get_object_taxonomies_service('st_hotel');
        if (!empty($list_tax)) {
            foreach ($list_tax as $name => $label) {
                $params[] = array(
                    'type' => 'st_checkbox',
                    'heading' => $label,
                    'param_name' => 'taxonomies' . '--' . $name,
                    'stype' => 'list_terms',
                    'sparam' => $name,
                );
            }
        }
        vc_map(array(
            "name" => __("ST List of Hotels", 'traveler'),
            "base" => "st_list_hotel",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => $params
        ));

        $params = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
                "value" => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("List ID in hotel", 'traveler'),
                "param_name" => "st_ids",
                "description" => __("Ids separated by commas", 'traveler'),
                'value' => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Number of Posts", 'traveler'),
                "param_name" => "posts_per_page",
                "description" => "",
                "value" => "",
            ),
            array(
                "type" => "st_dropdown",
                "holder" => "div",
                "heading" => __("Sort By Taxonomy", 'traveler'),
                "param_name" => "sort_taxonomy",
                "description" => "",
                'stype' => 'list_tax',
                'sparam' => 'st_hotel',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Order By", 'traveler'),
                "param_name" => "st_orderby",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-6',
                'value' => function_exists('st_get_list_order_by') ? st_get_list_order_by() : array(),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Order", 'traveler'),
                "param_name" => "st_order",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Asc', 'traveler') => 'asc',
                    __('Desc', 'traveler') => 'desc'
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
        );
        $data_vc = STHotel::get_taxonomy_and_id_term_tour();
        $params = array_merge($params, $data_vc['list_vc']);
        vc_map(array(
            "name" => __("ST List hotel related", 'traveler'),
            "base" => "st_list_hotel_related",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => $params
        ));

        vc_map(
                array(
                    "name" => __("ST Location list hotel ", 'traveler'),
                    "base" => "st_location_list_hotel",
                    "content_element" => true,
                    "icon" => "icon-st",
                    "category" => "Shinetheme",
                    "params" => $location_list_params
        ));
    }
// End ST_HOtel
// ST REntal
    if (st_check_service_available('st_rental')) {
        vc_map(array(
            "name" => __("ST Rental Attribute", 'traveler'),
            "base" => "st_rental_attribute",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Title", 'traveler'),
                    "param_name" => "title",
                    "description" => "",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Font Size", 'traveler'),
                    "param_name" => "font_size",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __("H1", 'traveler') => '1',
                        __("H2", 'traveler') => '2',
                        __("H3", 'traveler') => '3',
                        __("H4", 'traveler') => '4',
                        __("H5", 'traveler') => '5',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    "type" => "st_dropdown",
                    "holder" => "div",
                    "heading" => __("Select Taxonomy", 'traveler'),
                    "param_name" => "taxonomy",
                    "description" => "",
                    'stype' => 'list_tax',
                    'sparam' => 'st_rental',
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Item Size", 'traveler'),
                    "param_name" => "item_col",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        2 => 2,
                        3 => 3,
                        4 => 4,
                        5 => 5,
                        6 => 6,
                        7 => 7,
                        8 => 8,
                        9 => 9,
                        10 => 10,
                        11 => 11,
                        12 => 12,
                    ),
                )
            )
        ));
        vc_map(array(
            "name" => __("ST Rental Search Results", 'traveler'),
            "base" => "st_search_rental_result",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Grid', 'traveler') => 'grid',
                        __('List', 'traveler') => 'list',
                    ),
                ),
                array(
                    "type" => "st_checkbox",
                    "holder" => "div",
                    "heading" => __("Select Taxonomy Show", 'traveler'),
                    "param_name" => "taxonomy",
                    "description" => "",
                    'stype' => 'list_tax',
                    'sparam' => 'st_rental',
                )
            )
        ));
        vc_map(array(
            "name" => __("[Ajax] ST Rental Search Results", 'traveler'),
            "base" => "st_search_rental_result_ajax",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Grid', 'traveler') => 'grid',
                        __('List', 'traveler') => 'list',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("OrderBy Default", 'traveler'),
                    "param_name" => "st_orderby",
                    "description" => "",
                    "value" => array(
                        __('---None---', 'traveler') => '-1',
                        __('New', 'traveler') => 'new',
                        __('Random', 'traveler') => 'random',
                        __('Price', 'traveler') => 'price',
                        __('Featured', 'traveler') => 'featured',
                        __('Name', 'traveler') => 'name',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Sort By", 'traveler'),
                    "param_name" => "st_sortby",
                    "description" => "",
                    "value" => array(
                        __('Ascending', 'traveler') => 'asc',
                        __('Descending', 'traveler') => 'desc'
                    ),
                ),
                array(
                    "type" => "st_checkbox",
                    "holder" => "div",
                    "heading" => __("Select Taxonomy Show", 'traveler'),
                    "param_name" => "taxonomy",
                    "description" => "",
                    'stype' => 'list_tax',
                    'sparam' => 'st_rental',
                )
            )
        ));
        vc_map(array(
            "name" => __("ST Rental Distance", 'traveler'),
            "base" => "st_rental_distance",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Title", 'traveler'),
                    "param_name" => "title",
                    "description" => "",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Font Size", 'traveler'),
                    "param_name" => "font_size",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __("H1", 'traveler') => '1',
                        __("H2", 'traveler') => '2',
                        __("H3", 'traveler') => '3',
                        __("H4", 'traveler') => '4',
                        __("H5", 'traveler') => '5',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Item Size", 'traveler'),
                    "param_name" => "item_col",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        2 => 2,
                        3 => 3,
                        4 => 4,
                        5 => 5,
                        6 => 6,
                        7 => 7,
                        8 => 8,
                        9 => 9,
                        10 => 10,
                        11 => 11,
                        12 => 12,
                    ),
                )
            )
        ));
        vc_map(array(
            "name" => __("ST Sum of Rental Search Results", 'traveler'),
            "base" => "st_search_rental_title",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Search Modal", 'traveler'),
                    "param_name" => "search_modal",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Yes', 'traveler') => '1',
                        __('No', 'traveler') => '0',
                    ),
                )
            )
        ));
        vc_map(array(
            "name" => __("ST Rental Photo", 'traveler'),
            "base" => "st_rental_photo",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Slide', 'traveler') => 'slide',
                        __('Grid', 'traveler') => 'grid',
                    ),
                )
            )
        ));


        $param = array(
            array(
                "type" => "textfield",
                'admin_label' => true,
                "heading" => __("List ID in Rental", 'traveler'),
                "param_name" => "st_ids",
                "description" => __("Ids separated by commas", 'traveler'),
                'value' => "",
            ),
            array(
                "type" => "textfield",
                'admin_label' => true,
                "heading" => __("Number", 'traveler'),
                "param_name" => "number",
                "description" => "",
                'value' => 4,
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Order By", 'traveler'),
                "param_name" => "st_orderby",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-6',
                'value' => function_exists('st_get_list_order_by') ? st_get_list_order_by(
                        array(
                            __('Sale', 'traveler') => 'sale',
                            __('Featured', 'traveler') => 'featured',
                        )
                ) : array(),
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Order", 'traveler'),
                "param_name" => "st_order",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Asc', 'traveler') => 'asc',
                    __('Desc', 'traveler') => 'desc'
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Number of rows", 'traveler'),
                "param_name" => "number_of_row",
                'edit_field_class' => 'vc_col-sm-12',
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Four', 'traveler') => '4',
                    __('Three', 'traveler') => '3',
                    __('Two', 'traveler') => '2',
                ),
            ),
            array(
                "type" => "st_list_location",
                'admin_label' => true,
                "heading" => __("Location", 'traveler'),
                "param_name" => "st_location",
                "description" => __("Location", 'traveler'),
            ),
        );
        $list_tax = TravelHelper::get_object_taxonomies_service('st_rental');
        if (!empty($list_tax)) {
            foreach ($list_tax as $name => $label) {
                $param[] = array(
                    'type' => 'st_checkbox',
                    'heading' => $label,
                    'param_name' => 'taxonomies' . '--' . $name,
                    'stype' => 'list_terms',
                    'sparam' => $name,
                );
            }
        }

        vc_map(array(
            "name" => __("ST List of Rentals", 'traveler'),
            "base" => "st_list_rental",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => $param
        ));

        $params = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
                "value" => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("List ID in Tour", 'traveler'),
                "param_name" => "st_ids",
                "description" => __("Ids separated by commas", 'traveler'),
                'value' => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Number of Posts", 'traveler'),
                "param_name" => "posts_per_page",
                "description" => "",
                "value" => "",
            ),
            array(
                "type" => "st_dropdown",
                "holder" => "div",
                "heading" => __("Sort By Taxonomy", 'traveler'),
                "param_name" => "sort_taxonomy",
                "description" => "",
                'stype' => 'list_tax',
                'sparam' => 'st_rental',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Order By", 'traveler'),
                "param_name" => "st_orderby",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-6',
                'value' => function_exists('st_get_list_order_by') ? st_get_list_order_by() : array(),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Order", 'traveler'),
                "param_name" => "st_order",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Asc', 'traveler') => 'asc',
                    __('Desc', 'traveler') => 'desc'
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
        );
        $data_vc = STRental::get_taxonomy_and_id_term_tour();
        $params = array_merge($params, $data_vc['list_vc']);
        vc_map(array(
            "name" => __("ST List Rental related", 'traveler'),
            "base" => "st_list_rental_related",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => $params
        ));


        vc_map(
                array(
                    "name" => __("ST Location list rental ", 'traveler'),
                    "base" => "st_location_list_rental",
                    "content_element" => true,
                    "icon" => "icon-st",
                    "category" => "Shinetheme",
                    "params" => $location_list_params
        ));
    }
// End ST Rental
// Tours
    if (st_check_service_available('st_tours')) {
        vc_map(array(
            "name" => __("ST Tour Detail Attribute", 'traveler'),
            "base" => "st_tour_detail_attribute",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            "params" => array(
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Title", 'traveler'),
                    "param_name" => "title",
                    "description" => "",
                    "value" => "",
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Font Size", 'traveler'),
                    "param_name" => "font_size",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __("H1", 'traveler') => '1',
                        __("H2", 'traveler') => '2',
                        __("H3", 'traveler') => '3',
                        __("H4", 'traveler') => '4',
                        __("H5", 'traveler') => '5',
                    ),
                    'edit_field_class' => 'vc_col-sm-6',
                ),
                array(
                    "type" => "st_dropdown",
                    "holder" => "div",
                    "heading" => __("Select Taxonomy", 'traveler'),
                    "param_name" => "taxonomy",
                    "description" => "",
                    'stype' => 'list_tax',
                    'sparam' => 'st_tours',
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Item col", 'traveler'),
                    "param_name" => "item_col",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        12 => 12,
                        11 => 11,
                        10 => 10,
                        9 => 9,
                        8 => 8,
                        7 => 7,
                        6 => 6,
                        5 => 5,
                        4 => 4,
                        3 => 3,
                        2 => 2,
                    ),
                )
            )
        ));
        vc_map(array(
            "name" => __("ST Tour Cards Accepted", 'traveler'),
            "base" => "st_tour_card_accepted",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
        ));
        vc_map(array(
            "name" => __("ST Tour Search Results", 'traveler'),
            "base" => "st_tour_content_search",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "st_style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('List', 'traveler') => '1',
                        __('Grid', 'traveler') => '2',
                    ),
                ),
                array(
                    "type" => "st_checkbox",
                    "holder" => "div",
                    "heading" => __("Select Taxonomy Show", 'traveler'),
                    "param_name" => "taxonomy",
                    "description" => "",
                    'stype' => 'list_tax',
                    'sparam' => 'st_tours',
                )
            )
        ));
        vc_map(array(
            "name" => __("[Ajax] ST Tour Search Results", 'traveler'),
            "base" => "st_tour_content_search_ajax",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "st_style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('List', 'traveler') => '1',
                        __('Grid', 'traveler') => '2',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("OrderBy Default", 'traveler'),
                    "param_name" => "st_orderby",
                    "description" => "",
                    "value" => array(
                        __('---None---', 'traveler') => '-1',
                        __('New', 'traveler') => 'new',
                        __('Random', 'traveler') => 'random',
                        __('Price', 'traveler') => 'price',
                        __('Featured', 'traveler') => 'featured',
                        __('Name', 'traveler') => 'name',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Sort By", 'traveler'),
                    "param_name" => "st_sortby",
                    "description" => "",
                    "value" => array(
                        __('Ascending', 'traveler') => 'asc',
                        __('Descending', 'traveler') => 'desc'
                    ),
                ),
                array(
                    "type" => "st_checkbox",
                    "holder" => "div",
                    "heading" => __("Select Taxonomy Show", 'traveler'),
                    "param_name" => "taxonomy",
                    "description" => "",
                    'stype' => 'list_tax',
                    'sparam' => 'st_tours',
                )
            )
        ));
        vc_map(array(
            "name" => __("ST Sum of Tour Search Results", 'traveler'),
            "base" => "st_search_tour_title",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Search Modal", 'traveler'),
                    "param_name" => "search_modal",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Yes', 'traveler') => '1',
                        __('No', 'traveler') => '0',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Is Ajax", 'traveler'),
                    "param_name" => "is_ajax",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Yes', 'traveler') => '1',
                        __('No', 'traveler') => '0',
                    ),
                )
            )
        ));
        vc_map(array(
            "name" => __("ST Detailed Tour Gallery", 'traveler'),
            "base" => "st_tour_detail_photo",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            "params" => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Style", 'traveler'),
                    "param_name" => "style",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Slide', 'traveler') => 'slide',
                        __('Grid', 'traveler') => 'grid',
                    ),
                )
            )
        ));
        vc_map(array(
            "name" => __("ST Tour Rewards", 'traveler'),
            "base" => "st_tour_rewards",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            'show_settings_on_create' => false,
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        ));

        $params = array(
            array(
                "type" => "textfield",
                'admin_label' => true,
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
                "value" => "",
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Font Size", 'traveler'),
                "param_name" => "font_size",
                "description" => "",
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __("H1", 'traveler') => '1',
                    __("H2", 'traveler') => '2',
                    __("H3", 'traveler') => '3',
                    __("H4", 'traveler') => '4',
                    __("H5", 'traveler') => '5',
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "textfield",
                'admin_label' => true,
                "heading" => __("List ID in Tour", 'traveler'),
                "param_name" => "st_ids",
                "description" => __("Ids separated by commas", 'traveler'),
                'value' => "",
            ),
            array(
                "type" => "textfield",
                'admin_label' => true,
                "heading" => __("Number tour", 'traveler'),
                "param_name" => "st_number_tour",
                "description" => "",
                'value' => 4,
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Order By", 'traveler'),
                "param_name" => "st_orderby",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-6',
                'value' => function_exists('st_get_list_order_by') ? st_get_list_order_by(
                        array(
                            __('Price', 'traveler') => 'sale',
                            __('Rate', 'traveler') => 'rate',
                            __('Featured', 'traveler') => 'featured',
                        /* __( 'Discount rate' , 'traveler' )    => 'discount' , */
                        //__( 'Last Minute Deal' , 'traveler' ) => 'last_minute_deal' ,
                        )
                ) : array(),
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Order", 'traveler'),
                "param_name" => "st_order",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Asc', 'traveler') => 'asc',
                    __('Desc', 'traveler') => 'desc'
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Style Tour", 'traveler'),
                "param_name" => "st_style",
                "description" => "",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Style 1', 'traveler') => 'style_1',
                    __('Style 2', 'traveler') => 'style_2',
                    __('Style 3', 'traveler') => 'style_3',
                    __('Style 4', 'traveler') => 'style_4',
                ),
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Items per row", 'traveler'),
                "param_name" => "st_tour_of_row",
                'edit_field_class' => 'vc_col-sm-12',
                "description" => __("only for style 1 , style 2 , style 3", 'traveler'),
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('Four', 'traveler') => '4',
                    __('Three', 'traveler') => '3',
                    __('Two', 'traveler') => '2',
                ),
            ),
            array(
                "type" => "dropdown",
                'admin_label' => true,
                "heading" => __("Only in Featured Location", 'traveler'),
                "param_name" => "only_featured_location",
                "value" => array(
                    __('--Select--', 'traveler') => '',
                    __('No', 'traveler') => 'no',
                    __('Yes', 'traveler') => 'yes',
                ),
            ),
            array(
                "type" => "st_list_location",
                'admin_label' => true,
                "heading" => __("Location", 'traveler'),
                "param_name" => "st_location",
                "description" => __("Location", 'traveler'),
                "dependency" =>
                array(
                    "element" => "only_featured_location",
                    "value" => "no"
                ),
            ),
        );
        $list_tax = TravelHelper::get_object_taxonomies_service('st_tours');
        if (!empty($list_tax)) {
            foreach ($list_tax as $name => $label) {
                $params[] = array(
                    'type' => 'st_checkbox',
                    'heading' => $label,
                    'param_name' => 'taxonomies' . '--' . $name,
                    'stype' => 'list_terms',
                    'sparam' => $name,
                );
            }
        }

        vc_map(array(
            "name" => __("ST List Tour", 'traveler'),
            "base" => "st_list_tour",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => $params
        ));

        $params = array(
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Title", 'traveler'),
                "param_name" => "title",
                "description" => "",
                "value" => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("List ID in Tour", 'traveler'),
                "param_name" => "st_ids",
                "description" => __("Ids separated by commas", 'traveler'),
                'value' => "",
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "heading" => __("Number of Posts", 'traveler'),
                "param_name" => "posts_per_page",
                "description" => "",
                "value" => "",
            ),
            array(
                "type" => "st_dropdown",
                "holder" => "div",
                "heading" => __("Sort By Taxonomy", 'traveler'),
                "param_name" => "sort_taxonomy",
                "description" => "",
                'stype' => 'list_tax',
                'sparam' => 'st_tours',
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Order By", 'traveler'),
                "param_name" => "st_orderby",
                "description" => "",
                'edit_field_class' => 'vc_col-sm-6',
                'value' => function_exists('st_get_list_order_by') ? st_get_list_order_by() : array(),
            ),
            array(
                "type" => "dropdown",
                "holder" => "div",
                "heading" => __("Order", 'traveler'),
                "param_name" => "st_order",
                'value' => array(
                    __('--Select--', 'traveler') => '',
                    __('Asc', 'traveler') => 'asc',
                    __('Desc', 'traveler') => 'desc'
                ),
                'edit_field_class' => 'vc_col-sm-6',
            ),
        );
        $data_vc = STTour::get_taxonomy_and_id_term_tour();
        $params = array_merge($params, $data_vc['list_vc']);
        vc_map(array(
            "name" => __("ST List Tour related", 'traveler'),
            "base" => "st_list_tour_related",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            "params" => $params
        ));


        vc_map(
                array(
                    "name" => __("ST Location list tour ", 'traveler'),
                    "base" => "st_location_list_tour",
                    "content_element" => true,
                    "icon" => "icon-st",
                    "category" => "Shinetheme",
                    "params" => $location_list_params
                )
        );


        vc_map(array(
            "name" => __("ST Tours Header", 'traveler'),
            "base" => "st_header",
            "icon" => "icon-st",
            "category" => 'Shinetheme',
            'params' => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Heading size", 'traveler'),
                    "param_name" => "heading_size",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('1', 'traveler') => '1',
                        __('2', 'traveler') => '2',
                        __('3', 'traveler') => '3',
                        __('4', 'traveler') => '4',
                        __('5', 'traveler') => '5',
                        __('6', 'traveler') => '6',
                    ),
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Font Weight", 'traveler'),
                    "param_name" => "font_weight",
                    "description" => "Example: bold<br> <a href='http://www.w3schools.com/cssref/pr_font_weight.asp'>Read More</a>",
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Show Location ?", 'traveler'),
                    "param_name" => "is_location",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Yes', 'traveler') => '1',
                        __('No', 'traveler') => '2',
                    ),
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "heading" => __("Show contact", 'traveler'),
                    "param_name" => "is_contact",
                    "description" => "",
                    "value" => array(
                        __('--Select--', 'traveler') => '',
                        __('Yes', 'traveler') => '1',
                        __('No', 'traveler') => '2',
                    ),
                ),
                array(
                    "type" => "textfield",
                    "holder" => "div",
                    "heading" => __("Extra Class", 'traveler'),
                    "param_name" => "extra_class",
                    "description" => __("Class for each patch", 'traveler'),
                ),
            ),
        ));
    }
// End Tours

    if (st_check_service_available('st_rental') and st_check_service_available('hotel_room')) {
        vc_map(array(
            "name" => __("ST Custom Discount List", 'traveler'),
            "base" => "st_custom_discount_list",
            "content_element" => true,
            "icon" => "icon-st",
            "category" => "Shinetheme",
            'show_settings_on_create' => false,
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('There is no option in this element', 'traveler'),
                    'param_name' => 'description_field',
                    'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
                )
            )
        ));
    }


    vc_map(array(
        "name" => __("[Singel Hotel] Table Membership", 'traveler'),
        "base" => "st_single_hotel_table",
        "icon" => "icon-st",
        "content_element" => true,
        "category" => "Shinetheme",
        "params" => array(
            array(
                "type" => "attach_image",
                "heading" => __("Icon", 'traveler'),
                "param_name" => "st_images_icon",
                "description" => "",
            ),
            array(
                'param_name' => 'id_package',
                'type' => 'dropdown',
                'value' => st_get_packpage(), // here I'm stuck
                'heading' => __('Choose package', 'traveler'),
                'description' => '',
                'holder' => 'div',
            ),
            array(
                'param_name' => 'sale_member',
                'type' => 'textfield',
                'value' => '', // here I'm stuck
                'heading' => __('Enter number sale', 'traveler'),
                'description' => '',
                'holder' => 'div',
            ),
            array(
                'type' => 'param_group',
                'heading' => esc_html__('Support', 'traveler'),
                'param_name' => 'list_support',
                'value' => '',
                'params' => array(
                    array(
                        "type" => "checkbox",
                        "class" => "",
                        "heading" => __("Support", 'traveler'),
                        "param_name" => "check",
                        "value" => __("", 'traveler'),
                        "description" => __("Enter description.", 'traveler')
                    ),
                    array(
                        "type" => "textfield",
                        "heading" => __("Title item", 'traveler'),
                        "param_name" => "title_items",
                        "description" => "",
                    ),
                ),
            )
        )
    ));


    /* vc_map(array(
      'name' => __('ST Title and content', 'traveler'),
      'base' => 'st_title_line',
      'content_element' => true,
      'icon' => 'icon-st',
      "category" => "Shinetheme",
      'params' => array(
      array(
      'type' => 'textfield',
      'heading' => __('Title text', 'traveler'),
      'param_name' => 'header_title',
      'value' => __('Title text', 'traveler')
      ),
      array(
      'type' => 'textarea_html',
      'heading' => __('Content', 'traveler'),
      'param_name' => 'content',
      'value' => ''
      ),
      array(
      "type" => "dropdown",
      "heading" => __("Layout default", 'traveler'),
      "param_name" => "layout_title",
      "value" => array(
      __('Default', 'traveler') => 'st_default',
      __('Center', 'traveler') => 'st_center',
      ),
      'std' => 'st_center'
      ),
      array(
      "type" => "dropdown",
      "heading" => __("Style layout", 'traveler'),
      "param_name" => "style_layout",
      "value" => array(
      __('Title and line', 'traveler') => 'style-1',
      __('Line and title', 'traveler') => 'style-2',
      __('No line', 'traveler') => 'style-3',
      __('Title line style 2', 'traveler') => 'style-4',
      __('With icon', 'traveler') => 'style-5',
      ),
      'std' => 'style-1'
      ),
      )
      )); */

    vc_map(array(
        'name' => __('ST Language & Currency', 'traveler'),
        'base' => 'st_language_currency_new',
        'icon' => 'icon-st',
        'category' => 'Modern Layout',
        'params' => array(
        )
    ));
}

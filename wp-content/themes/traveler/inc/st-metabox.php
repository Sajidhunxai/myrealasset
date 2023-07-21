<?php

/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Initialize the custom Meta Boxes.
 *
 * Created by ShineTheme
 *
 */
$custom_metabox[] = array(
    'id' => 'demo_meta_box',
    'title' => __('Demo Meta Box', 'traveler'),
    'pages' => array('post'),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'label' => __('Information', 'traveler'),
            'id' => 'infomation_tab',
            'type' => 'tab'
        ),
        array(
            'label' => __('Gallery', 'traveler'),
            'id' => 'gallery',
            'type' => 'gallery',
            'desc' => __('This is a gallery option type', 'traveler'),
        ), array(
            'label' => __('Media(video URL or audio URL)', 'traveler'),
            'id' => 'media',
            'type' => 'text',
            'desc' => __('This field for Audio and Video Post Format', 'traveler'),
        ), array(
            'label' => __('Link', 'traveler'),
            'id' => 'link',
            'type' => 'text',
            'desc' => __('This is a link option type', 'traveler'),
        ),
        array(
            'label' => __('Post sidebar setting', 'traveler'),
            'id' => 'sidebar_tab_post',
            'type' => 'tab'
        ),
        array(
            'id' => 'post_sidebar_pos',
            'label' => __('Sidebar position', 'traveler'),
            'desc' => __('You can choose no sidebar, left sidebar and right sidebar', 'traveler'),
            'type' => 'select',
            'section' => 'option_blog',
            'choices' => array(
                array(
                    'value' => '',
                    'label' => __('---Select---', 'traveler')
                ),
                array(
                    'value' => 'no',
                    'label' => __('No', 'traveler')
                ),
                array(
                    'value' => 'left',
                    'label' => __('Left', 'traveler')
                ),
                array(
                    'value' => 'right',
                    'label' => __('Right', 'traveler')
                )
            )
        ),
        array(
            'label' => __('Select sidebar', 'traveler'),
            'id' => 'post_sidebar',
            'type' => 'sidebar-select',
        ),
    )
);


//Pages
$custom_metabox[] = array(
    'id' => 'st_footer_social',
    'title' => __('Page Setting', 'traveler'),
    'desc' => '',
    'pages' => array('page'),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        /* array(
          'label'       => __( 'Header page Setting', 'traveler'),
          'id'          => 'header_tab',
          'type'        => 'tab'
          ),
          array(
          'id'      => 'header_position' ,
          'label'   => __( 'Header Position' , 'traveler' ) ,
          'desc'    => __( '<a href="http://www.w3schools.com/css/css_positioning.asp"><em>What is it ?</em></a>' , 'traveler' ) ,
          'type'    => 'select' ,
          'section' => 'option_header' ,
          'std'     => '',
          'choices'   => array(
          array('label' => __("Default" ,'traveler') , 'value'=> "default", ),
          array('label' => __("Absolute" ,'traveler') , 'value'=> "absolute", ),
          ),
          ) ,
          array(
          'label'       => __( 'Menu color', 'traveler'),
          'id'          => 'menu_color',
          'type'        => 'typography',
          'desc'        => __( 'Input ', 'traveler'),
          'std'           => '#333333'
          ), */
        array(
            'label' => __('Template coming soon setting', 'traveler'),
            'id' => 'detail_tab',
            'type' => 'tab'
        ),
        /* array(
          'label'         => __("Comingsoon style" , 'traveler'),
          'id'            => 'cs_style',
          'type'          =>  'select',
          'choices'   => array(
          array('label' => __("Default" ,'traveler') , 'value'=> "default", ),
          array('label' => __("Tour box style" ,'traveler') , 'value'=> "st_tour_ver", ),
          ),
          ), */
        array(
            'label' => __('Data date countdown', 'traveler'),
            'id' => 'data_countdown',
            'type' => 'date-picker',
            'desc' => __('Input ', 'traveler'),
        ),
        array(
            'label' => __('Footer social', 'traveler'),
            'id' => 'footer_social',
            'type' => 'textarea',
            'desc' => __('Input html social', 'traveler'),
            'rows' => 3,
        ),
        array(
            'label' => __('Body background', 'traveler'),
            'id' => 'cs_bgr',
            'type' => 'background',
            'desc' => __('Body background', 'traveler'),
        ),
        array(
            'label' => __('Login page Setting', 'traveler'),
            'id' => 'login_tab',
            'type' => 'tab'
        ),
        array(
            'label' => __('Button sign in', 'traveler'),
            'id' => 'btn_sing_in',
            'type' => 'text',
            'value' => __('Sign in', 'traveler'),
            'desc' => __('Input text', 'traveler'),
        ),
        array(
            'label' => __('Button register', 'traveler'),
            'id' => 'btn_register',
            'type' => 'text',
            'value' => __('Register', 'traveler'),
            'desc' => __('Input text', 'traveler'),
        ),
        array(
            'label' => __('Blog page setting', 'traveler'),
            'id' => 'blog_tab',
            'type' => 'tab'
        ),
        array(
            'label' => __('Blog style', 'traveler'),
            'id' => 'blog_style',
            'type' => 'select',
            'desc' => __('Template blog style', 'traveler'),
            'choices' => array(
                array('label' => __("List", 'traveler'), 'value' => "",),
                array('label' => __("Grid", 'traveler'), 'value' => "st_grid",),
                array('label' => __("Tour box grid", 'traveler'), 'value' => "st_tour_grid",),
                array('label' => __("Tour box list", 'traveler'), 'value' => "st_tour_list",),
            ),
        ),
    )
);

$custom_metabox[] = array(
    'id' => 'st_page_metabox_option',
    'title' => __('Page Options', 'traveler'),
    'pages' => array('page', 'product', 'location'),
    'context' => 'side',
    'priority' => 'default',
    'fields' => array(
        array(
            'label' => __('Footer template', 'traveler'),
            'id' => 'footer_template',
            'type' => 'page-select',
        ),
        array(
            'id' => 'post_sidebar_pos',
            'label' => __('Sidebar position', 'traveler'),
            'type' => 'select',
            'section' => 'option_blog',
            'choices' => array(
                array(
                    'value' => '',
                    'label' => __('--- Select ---', 'traveler')
                ),
                array(
                    'value' => 'no',
                    'label' => __('No', 'traveler')
                ),
                array(
                    'value' => 'left',
                    'label' => __('Left', 'traveler')
                ),
                array(
                    'value' => 'right',
                    'label' => __('Right', 'traveler')
                )
            )
        ),
        array(
            'label' => __('Select sidebar', 'traveler'),
            'id' => 'post_sidebar',
            'type' => 'sidebar-select',
        ),
        array(
            'label' => __('Header text', 'traveler'),
            'id' => 'page_header_text',
            'type' => 'textarea',
            'rows' => 3,
            'holder' => 'div',
            'desc' => '',
        ),
    )
);


$custom_metabox[] = array(
    'id' => 'st_custom_type_layout',
    'title' => __('Layout Options', 'traveler'),
    'desc' => '',
    'pages' => array('st_layouts'),
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'label' => __('Type layout options', 'traveler'),
            'id' => 'type_layout_tab',
            'type' => 'tab'
        ),
        array(
            'label' => __('Select layout type', 'traveler'),
            'id' => 'st_type_layout',
            'type' => 'select',
            'choices' => array(
                array(
                    'value' => 'st_hotel',
                    'label' => __('Hotel single', 'traveler')
                ),
                array(
                    'value' => 'st_hotel_search',
                    'label' => __('Hotel search', 'traveler')
                ),
                array(
                    'value' => 'hotel_room',
                    'label' => __('Hotel room', 'traveler')
                ),
                array(
                    'value' => 'hotel_alone_room',
                    'label' => __('Hotel alone room', 'traveler')
                ),
                array(
                    'value' => 'st_rental',
                    'label' => __('Rental single', 'traveler')
                ),
                array(
                    'value' => 'st_rental_search',
                    'label' => __('Rental search', 'traveler')
                ),
                array(
                    'value' => 'rental_room',
                    'label' => __('Rental room', 'traveler')
                ),
                array(
                    'value' => 'st_activity',
                    'label' => __('Activity single', 'traveler')
                ),
                array(
                    'value' => 'st_activity_search',
                    'label' => __('Activity search', 'traveler')
                ),
                array(
                    'value' => 'st_tours',
                    'label' => __('Tour single', 'traveler')
                ),
                array(
                    'value' => 'st_tours_search',
                    'label' => __('Tour search', 'traveler')
                ),
                array(
                    'value' => 'st_cars',
                    'label' => __('Car single', 'traveler')
                ),
                array(
                    'value' => 'st_cars_search',
                    'label' => __('Car search', 'traveler')
                )
            )
        ),
        array(
            'label' => __('Select footer template', 'traveler'),
            'id' => 'footer_template',
            'type' => 'page-select',
        ),
        array(
            'label' => __("Select layout size", 'traveler'),
            'id' => "layout_size",
            'type' => "select",
            'std' => 'container',
            'desc' => __("Select layout width size (<a href='http://getbootstrap.com/css/'>Read more </a>)", 'traveler'),
            'choices' => array(
                array(
                    'label' => __('Full width', 'traveler'),
                    'value' => 'full'
                ),
                array(
                    'label' => __('Bootstrap container', 'traveler'),
                    'value' => 'container'
                ),
                array(
                    'label' => __('Bootstrap container fluid', 'traveler'),
                    'value' => 'container-fluid'
                ), /*
              array(
              'label' => __('Customize  - building' , 'traveler'),
              'value' => 'customize'
              ), */
            ),
        ),
    /* array(
      'label' => __("Breadcrumb") ,
      'id'    => __("is_breadcrumb"),
      'type'  => "on-off" ,
      'std'   => 'on',
      'desc'  => __("Off to hide Breadcrumb" , 'traveler'),
      ), */
    ),
);



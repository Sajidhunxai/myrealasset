<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Custom option theme option
 *
 * Created by ShineTheme
 *
 */
if (!class_exists('TravelHelper') or !class_exists('STHotel'))
    return;


$custom_settings = array(

    'sections' => array(
        array(
            'id' => 'option_general',
            'title' => __('<i class="fa fa-tachometer"></i> General Options', 'traveler')
        ),
        array(
            'id' => 'option_style',
            'title' => __('<i class="fa fa-paint-brush"></i> Styling Options', 'traveler')
        ),
        array(
            'id' => 'option_page',
            'title' => __('<i class="fa fa-file-text"></i> Page Options', 'traveler')
        ),
        array(
            'id' => 'option_blog',
            'title' => __('<i class="fa fa-bold"></i> Blog Options', 'traveler')
        ),
        array(
            'id' => 'option_booking',
            'title' => __('<i class="fa fa-book"></i> Booking Options', 'traveler')
        ),
        array(
            'id' => 'option_location',
            'title' => __('<i class="fa fa-location-arrow"></i> Location Options', 'traveler')
        ),
        array(
            'id' => 'option_review',
            'title' => __('<i class="fa fa-comments-o"></i> Review Options', 'traveler')
        ),
        array(
            'id' => 'option_hotel',
            'title' => __('<i class="fa fa-building"></i> Hotel Options', 'traveler')
        ),
        array(
            'id' => 'option_hotel_room',
            'title' => __('<i class="fa fa-building"></i> Room Options', 'traveler')
        ),
        array(
            'id' => 'option_rental',
            'title' => __('<i class="fa fa-home"></i> Rental Options', 'traveler')
        ),
        array(
            'id' => 'option_car',
            'title' => __('<i class="fa fa-car"></i> Car Options', 'traveler')
        ),
        array(
            'id' => 'option_activity_tour',
            'title' => __('<i class="fa fa-suitcase"></i> Tour Options', 'traveler')
        ),
        array(
            'id' => 'option_activity',
            'title' => __('<i class="fa fa-ticket"></i> Activity Options', 'traveler')
        ),
        array(
            'id' => 'option_car_transfer',
            'title' => __('<i class="fa fa-car"></i> Transfer Options', 'traveler')
        ),
        array(
            'id' => 'option_hotel_alone',
            'title' => __('<i class="fa fa-building"></i> Hotel Alone Options', 'traveler')
        ),
        array(
            'id' => 'option_partner',
            'title' => __('<i class="fa fa-users"></i> Partner Options', 'traveler')
        ),
        array(
            'id' => 'option_email_partner',
            'title' => __('<i class="fa fa-users"></i> Email Partner', 'traveler')
        ),
        array(
            'id' => 'option_search',
            'title' => __('<i class="fa fa-search"></i> Search Options', 'traveler')
        ),
        array(
            'id' => 'option_email',
            'title' => __('<i class="fa fa-envelope"></i> Email Options', 'traveler')
        ),
        array(
            'id' => 'option_email_template',
            'title' => __('<i class="fa fa-envelope"></i> Email Templates', 'traveler')
        ),
        array(
            'id' => 'option_social',
            'title' => __('<i class="fa fa-facebook-official"></i> Social Options', 'traveler')
        ),
        array(
            'id' => 'option_advance',
            'title' => __('<i class="fa fa-cogs"></i> Advance Options', 'traveler')
        ),
        array(
            'id' => 'option_update',
            'title' => __('<i class="fa fa-download"></i> Auto Updater', 'traveler')
        ),
        array(
            'id' => 'option_api_update',
            'title' => __('<i class="fa fa-download"></i> Affiliate Configure', 'traveler')
        ),
        array(
            'id' => 'option_bc',
            'title' => __('<i class="fa fa-info"></i> Other options', 'traveler')
        ),
    ),
    'settings' => array(
        /*---- .START GENERAL OPTIONS ----*/
        array(
            'id' => 'general_tab',
            'label' => __('General Options', 'traveler'),
            'type' => 'tab',
            'section' => 'option_general',
        ),
        array(
            'id' => 'enable_user_online_noti',
            'label' => __('User notification info', 'traveler'),
            'desc' => __('Enable/disable online notification of user', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_general',
            'std' => 'on'
        ),
        array(
            'id' => 'enable_last_booking_noti',
            'label' => __('Last booking notification', 'traveler'),
            'desc' => __('Enable/disable notification of last booking', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_general',
            'std' => 'on'
        ),
        array(
            'id' => 'enable_user_nav',
            'label' => __('User navigator', 'traveler'),
            'desc' => __('Enable/disable user dashboard menu', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_general',
            'std' => 'on'
        ),
        array(
            'id' => 'noti_position',
            'label' => __('Notification position', 'traveler'),
            'desc' => __('The position to appear notices', 'traveler'),
            'type' => 'select',
            'section' => 'option_general',
            'std' => 'topRight',
            'choices' => array(
                array(
                    'label' => __('Top Right', 'traveler'),
                    'value' => 'topRight'
                ),
                array(
                    'label' => __('Top Left', 'traveler'),
                    'value' => 'topLeft'
                ),
                array(
                    'label' => __('Bottom Right', 'traveler'),
                    'value' => 'bottomRight'
                ),
                array(
                    'label' => __('Bottom Left', 'traveler'),
                    'value' => 'bottomLeft'
                )
            ),
        ),
        array(
            'id' => 'admin_menu_normal_user',
            'label' => __('Normal user adminbar', 'traveler'),
            'desc' => __('Show/hide adminbar for user', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_general',
            'std' => 'off'
        ),
        array(
            'id' => 'once_notification_per_each_session',
            'label' => __('Only show notification for per session', 'traveler'),
            'desc' => __('Only show the unique notification for each user\'s session', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_general',
            'std' => 'off'
        ),
        array(
            'id' => 'st_weather_temp_unit',
            'label' => __('Weather unit', 'traveler'),
            'desc' => __('The unit of weather- you can use Fahrenheit or Celsius or Kelvin', 'traveler'),
            'type' => 'select',
            'section' => 'option_general',
            'std' => 'c',
            'choices' => array(
                array(
                    'label' => __('Fahrenheit (f)', 'traveler'),
                    'value' => 'f'
                ),
                array(
                    'label' => __('Celsius (c)', 'traveler'),
                    'value' => 'c'
                ),
                array(
                    'label' => __('Kelvin (k)', 'traveler'),
                    'value' => 'k'
                ),
            ),
        ),
        array(
            'id' => 'search_enable_preload',
            'label' => __('Preload option', 'traveler'),
            'desc' => __('Enable Preload when loading site', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_general',
            'std' => 'on'
        ),
        array(
            'id' => 'search_preload_image',
            'label' => __('Preload image', 'traveler'),
            'desc' => __('This is the background for preload', 'traveler'),
            'type' => 'upload',
            'section' => 'option_general',
            'condition' => 'search_enable_preload:is(on)'
        ),
        array(
            'id' => 'search_preload_icon_default',
            'label' => __('Customize preloader icon', 'traveler'),
            'desc' => __('Using custom preload icon', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_general',
            'condition' => 'search_enable_preload:is(on)',
            'std' => 'off'
        ),
        array(
            'id' => 'search_preload_icon_custom',
            'label' => __('Upload custom preload image', 'traveler'),
            'desc' => __('This is the image for preload', 'traveler'),
            'type' => 'upload',
            'section' => 'option_general',
            'operator' => 'and',
            'condition' => 'search_preload_icon_default:is(on),search_enable_preload:is(on)'
        ),
        array(
            'id' => 'list_disabled_feature',
            'label' => __('Disable Theme Service Option', 'traveler'),
            'desc' => __('Hide one or many services of theme. In order to disable services (holtel, tour,..) you do not use, please tick the checkbox', 'traveler'),
            'type' => 'checkbox',
            'section' => 'option_general',
            'choices' => array(
                array(
                    'label' => __('Hotel', 'traveler'),
                    'value' => 'st_hotel'
                ),
                array(
                    'label' => __('Car', 'traveler'),
                    'value' => 'st_cars'
                ),
                array(
                    'label' => __('Rental', 'traveler'),
                    'value' => 'st_rental'
                ),
                array(
                    'label' => __('Tour', 'traveler'),
                    'value' => 'st_tours'
                ),
                array(
                    'label' => __('Activity', 'traveler'),
                    'value' => 'st_activity'
                )
            ),
        ),

        array(
            'id' => 'logo_tab',
            'label' => __('Logo', 'traveler'),
            'type' => 'tab',
            'section' => 'option_general',
        ),
        array(
            'id' => 'logo',
            'label' => __('Logo options', 'traveler'),
            'desc' => __('To change logo', 'traveler'),
            'type' => 'upload',
            'section' => 'option_general',
        ),
        array(
            'id' => 'logo_retina',
            'label' => __('Retina logo', 'traveler'),
            'desc' => __('Note: You MUST re-name Logo Retina to logo-name@2x.ext-name. Example:<br>
                                    Logo is: <em>my-logo.jpg</em><br>Logo Retina must be: <em>my-logo@2x.jpg</em>  ', 'traveler'),
            'type' => 'upload',
            'section' => 'option_general',
            'std' => get_template_directory_uri() . '/img/logo@2x.png'
        ),
        array(
            'id' => 'logo_mobile',
            'label' => __('Mobile logo', 'traveler'),
            'type' => 'upload',
            'section' => 'option_general',
            'std' => '',
            "desc" => __("To change logo used for mobile screen", 'traveler')
        ),
        array(
            'id' => 'favicon',
            'label' => __('Favicon', 'traveler'),
            'desc' => __('To change favicon', 'traveler'),
            'type' => 'upload',
            'section' => 'option_general',
        ),
        array(
            'id' => '404_tab',
            'label' => __('404 Options', 'traveler'),
            'type' => 'tab',
            'section' => 'option_general',
        ),
        array(
            'id' => '404_bg',
            'label' => __('Background for 404 page', 'traveler'),
            'desc' => __('To change background for 404 error page', 'traveler'),
            'type' => 'upload',
            'section' => 'option_general',
        ),
        array(
            'id' => '404_text',
            'label' => __('Text of 404 page', 'traveler'),
            'desc' => __('To change text for 404 page', 'traveler'),
            'type' => 'textarea',
            'rows' => '3',
            'section' => 'option_general',
        ),
       
        ),/*---- .END GENERAL OPTIONS ----*/
        array(
            'id' => 'login_tab',
            'label' => __('Login Options', 'traveler'),
            'type' => 'tab',
            'section' => 'option_general',
        ),
        array(
            'id' => 'enable_captcha_login',
            'label' => __('Enable Google Captcha Login', 'traveler'),
            'desc' => __('Show/hide google captcha for page login and register. Note: This function not support for popup login and popup register', 'traveler'),
            'std' => 'off',
            'type' => 'on-off',
            'section' => 'option_general',
            'class' => '',
        ),
        array(
            'id' => 'recaptcha_key',
            'label' => __('Re-Captcha Key', 'traveler'),
            'desc' => '',
            'std' => '',
            'type' => 'text',
            'section' => 'option_general',
            'class' => '',
            'condition' => 'enable_captcha_login:is(on)',
        ),
        array(
            'id' => 'recaptcha_secretkey',
            'label' => __('Re-Captcha Secret Key', 'traveler'),
            'desc' => '',
            'std' => '',
            'type' => 'text',
            'section' => 'option_general',
            'class' => '',
            'condition' => 'enable_captcha_login:is(on)',
        ),

        /*---- .START STYLE OPTIONS ----*/
        array(
            'id' => 'general_style_tab',
            'label' => __('General', 'traveler'),
            'type' => 'tab',
            'section' => 'option_style',
        ),
        array(
            'id' => 'right_to_left',
            'label' => __('Right to left mode', 'traveler'),
            'desc' => __('Enable "Right to left" displaying mode for content', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_style',
            'output' => '',
            'std' => 'off'
        ),
        array(
            'id' => 'style_layout',
            'label' => __('Layout', 'traveler'),
            'desc' => __('You can choose wide layout or boxed layout', 'traveler'),
            'type' => 'select',
            'section' => 'option_style',
            'choices' => array(
                array(
                    'value' => 'wide',
                    'label' => __('Wide', 'traveler')
                ),
                array(
                    'value' => 'boxed',
                    'label' => __('Boxed', 'traveler')
                )

            )
        ),
        array(
            'id' => 'typography',
            'label' => __('Typography, Google Fonts', 'traveler'),
            'desc' => __('To change the display of text', 'traveler'),
            'type' => 'typography',
            'section' => 'option_style',
            'output' => 'body'
        ),
        array(
            'id' => 'google_fonts',
            'label' => __('Google Fonts', 'traveler'),
            'type' => 'google-fonts',
            'section' => 'option_style',
        ),
        array(
            'id' => 'star_color',
            'label' => __('Star color', 'traveler'),
            'desc' => __('To change the color of star hotel', 'traveler'),
            'type' => 'colorpicker',
            'section' => 'option_style',
        ),
        array(
            'id' => 'body_background',
            'label' => __('Body Background', 'traveler'),
            'desc' => __('To change the color, background image of body', 'traveler'),
            'type' => 'background',
            'section' => 'option_style',
            'output' => 'body',
            'std' => array(
                'background-color' => "",
                'background-image' => "",
            )
        ),
        array(
            'id' => 'main_wrap_background',
            'label' => __('Wrap background', 'traveler'),
            'desc' => __('To change background color, bachground image of box surrounding the content', 'traveler'),
            'type' => 'background',
            'section' => 'option_style',
            'output' => '.global-wrap',
            'std' => array(
                'background-color' => "",
                'background-image' => "",
            )
        ),
        array(
            'id' => 'style_default_scheme',
            'label' => __('Default Color Scheme', 'traveler'),
            'desc' => __('Select  available color scheme to display', 'traveler'),
            'type' => 'select',
            'section' => 'option_style',
            'output' => '',
            'std' => '',
            'choices' => array(
                array('label' => '-- Please Select ---', 'value' => ''),
                array('label' => 'Bright Turquoise', 'value' => '#0EBCF2'),
                array('label' => 'Turkish Rose', 'value' => '#B66672'),
                array('label' => 'Salem', 'value' => '#12A641'),
                array('label' => 'Hippie Blue', 'value' => '#4F96B6'),
                array('label' => 'Mandy', 'value' => '#E45E66'),
                array('label' => 'Green Smoke', 'value' => '#96AA66'),
                array('label' => 'Horizon', 'value' => '#5B84AA'),
                array('label' => 'Cerise', 'value' => '#CA2AC6'),
                array('label' => 'Brick red', 'value' => '#cf315a'),
                array('label' => 'De-York', 'value' => '#74C683'),
                array('label' => 'Shamrock', 'value' => '#30BBB1'),
                array('label' => 'Studio', 'value' => '#7646B8'),
                array('label' => 'Leather', 'value' => '#966650'),
                array('label' => 'Denim', 'value' => '#1A5AE4'),
                array('label' => 'Scarlet', 'value' => '#FF1D13'),
            )
        ),
        array(
            'id' => 'main_color',
            'label' => __('Main Color', 'traveler'),
            'desc' => __('To change the main color for web', 'traveler'),
            'type' => 'colorpicker',
            'section' => 'option_style',
            'std' => '#ed8323',

        ),
        array(
            'id' => 'custom_css',
            'label' => __('CSS custom', 'traveler'),
            'desc' => __('Use CSS Code to customize the interface', 'traveler'),
            'type' => 'css',
            'section' => 'option_style',
        ),
        array(
            'id' => 'header_tab',
            'label' => __('Header', 'traveler'),
            'type' => 'tab',
            'section' => 'option_style',
        ),
        array(
            'id' => 'header_background',
            'label' => __('Header background', 'traveler'),
            'desc' => __('To change background color, background image of header section', 'traveler'),
            'type' => 'background',
            'section' => 'option_style',
            'output' => '.header-top, .menu-style-2 .header-top',
            'std' => array(
                'background-color' => "",
                'background-image' => "",
            )
        ),
        array(
            'id' => 'gen_enable_sticky_header',
            'label' => __('Sticky header', 'traveler'),
            'desc' => __('Enable fixed mode for header', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_style',
            'std' => 'off'
        ),
        array(
            'id' => 'sort_header_menu',
            'label' => __('Header menu items', 'traveler'),
            'type' => 'list-item',
            'section' => 'option_style',
            'desc' => __('Select  items displaying at the right of main menu', 'traveler'),
            'settings' => array(
                array(
                    'id' => 'header_item',
                    'label' => __('Item', 'traveler'),
                    'type' => 'select',
                    'desc' => __('Select header item shown in header right', 'traveler'),
                    'choices' => array(
                        array(
                            'value' => 'login',
                            'label' => __('Login', 'traveler')
                        ),
                        array(
                            'value' => 'currency',
                            'label' => __('Currency', 'traveler')
                        ),
                        array(
                            'value' => 'language',
                            'label' => __('Language', 'traveler')
                        ),
                        array(
                            'value' => 'search',
                            'label' => __('Search Header', 'traveler')
                        ),
                        array(
                            'value' => 'shopping_cart',
                            'label' => __('Shopping Cart', 'traveler')
                        ),
                        array(
                            'value' => 'link',
                            'label' => __('Custom Link', 'traveler')
                        ),
                    )
                ),
                array(
                    'id' => 'header_custom_link',
                    'label' => __('Link', 'traveler'),
                    'type' => 'text',
                    'condition' => 'header_item:is(link)'
                ),
                array(
                    'id' => 'header_custom_link_title',
                    'label' => __('Title Link', 'traveler'),
                    'type' => 'text',
                    'condition' => 'header_item:is(link)'
                ),
                array(
                    'id' => 'header_custom_link_icon',
                    'label' => __('Icon Link', 'traveler'),
                    'type' => 'text',
                    'desc' => __('Enter a Font Awesome icon - Apply for Custom Link Item only', 'traveler'),
                    'condition' => 'header_item:is(link)'
                )
            ),
        ),
        array(
            'id' => 'menu_bar',
            'label' => __('Menu', 'traveler'),
            'type' => 'tab',
            'section' => 'option_style',
        ),
        array(
            'id' => 'gen_enable_sticky_menu',
            'label' => __('Sticky menu', 'traveler'),
            'desc' => __('This allows you to turn on or off <em>Sticky Menu Feature</em>', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_style',
            'std' => 'off',
        ),
        array(
            'id' => 'menu_style',
            'label' => __('Select menu style', 'traveler'),
            'desc' => __('Select  styles of menu ( it is default as style 1)', 'traveler'),
            'type' => 'radio-image',
            'section' => 'option_style',
            'std' => '1',
            'choices' => array(
                array(
                    'value' => '1',
                    'label' => __('Default', 'traveler'),
                    'src' => get_template_directory_uri() . '/img/nav1.png'
                ),
                array(
                    'value' => '2',
                    'label' => __('Logo Center', 'traveler'),
                    'src' => get_template_directory_uri() . '/img/nav2-new.png'
                ),
            )
        ),
        //Turn On/Off Mega menu
        array(
            'id' => 'allow_megamenu',
            'label' => __('Mega menu', 'traveler'),
            'desc' => __('Enable Mega Menu', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_style',
            'std' => 'off'
        ),

        array(
            'id' => 'mega_menu_background',
            'label' => __('Mega Menu background', 'traveler'),
            'desc' => __('To change mega menu\'s background', 'traveler'),
            'type' => 'colorpicker',
            'section' => 'option_style',
            'std' => '#ffffff',

        ),

        array(
            'id' => 'mega_menu_color',
            'label' => __('Mega Menu color', 'traveler'),
            'desc' => __('To change mega menu\'s color', 'traveler'),
            'type' => 'colorpicker',
            'section' => 'option_style',
            'std' => '#333333',
        ),

        array(
            'id' => 'menu_color',
            'label' => __('Menu color', 'traveler'),
            'desc' => __('To change the color for menu', 'traveler'),
            'type' => 'typography',
            'section' => 'option_style',
            'std' => '#333333',
            'output' => '.st_menu ul.slimmenu li a, .st_menu ul.slimmenu li .sub-toggle>i,.menu-style-2 ul.slimmenu li a, .menu-style-2 ul.slimmenu li .sub-toggle>i, .menu-style-2 .nav .collapse-user'
        ),
        array(
            'id' => 'menu_background',
            'label' => __('Menu background', 'traveler'),
            'desc' => __('To change menu\'s background image', 'traveler'),
            'type' => 'background',
            'section' => 'option_style',
            'output' => '#menu1,#menu1 .menu-collapser, #menu2 .menu-wrapper, .menu-style-2 .user-nav-wrapper',
            'std' => array(
                'background-color' => "#ffffff",
                'background-image' => "",
            )
        ),
        array(
            'id' => 'top_bar',
            'label' => __('Top Bar', 'traveler'),
            'type' => 'tab',
            'section' => 'option_style',
        ),
        array(
            'id' => 'enable_topbar',
            'label' => __('Topbar menu', 'traveler'),
            'desc' => __('On to Enable Top bar ', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_style',
            'std' => 'off',
        ),
        array(
            'id' => 'sort_topbar_menu',
            'label' => __('Topbar menu options', 'traveler'),
            'type' => 'list-item',
            'section' => 'option_style',
            'desc' => __('Select topbar item shown in topbar right', 'traveler'),
            'settings' => array(
                array(
                    'id' => 'topbar_item',
                    'label' => __('Item', 'traveler'),
                    'type' => 'select',
                    'desc' => __('Select item shown in topbar', 'traveler'),
                    'choices' => array(
                        array(
                            'value' => 'login',
                            'label' => __('Login', 'traveler')
                        ),
                        array(
                            'value' => 'currency',
                            'label' => __('Currency', 'traveler')
                        ),
                        array(
                            'value' => 'language',
                            'label' => __('Language', 'traveler')
                        ),
                        array(
                            'value' => 'search',
                            'label' => __('Search Topbar', 'traveler')
                        ),
                        array(
                            'value' => 'shopping_cart',
                            'label' => __('Shopping Cart', 'traveler')
                        ),
                        array(
                            'value' => 'link',
                            'label' => __('Custom Link', 'traveler')
                        ),
                    )
                ),
                array(
                    'id' => 'topbar_custom_link',
                    'label' => __('Link', 'traveler'),
                    'type' => 'text',
                    'condition' => 'topbar_item:is(link)'
                ),
                array(
                    'id' => 'topbar_custom_link_title',
                    'label' => __('Title Link', 'traveler'),
                    'type' => 'text',
                    'condition' => 'topbar_item:is(link)'
                ),
                array(
                    'id' => 'topbar_custom_link_icon',
                    'label' => __('Icon Link', 'traveler'),
                    'type' => 'text',
                    'desc' => __('Enter a Font Awesome icon - Apply for Custom Link Item only', 'traveler'),
                    'condition' => 'topbar_item:is(link)'
                ),
                array(
                    'id' => 'topbar_custom_link_target',
                    'label' => __('Open new window', 'traveler'),
                    'type' => 'checkbox',
                    'choices' => array(
                        array(
                            'label' => __('Yes', 'traveler'),
                            'value' => 'yes'
                        )
                    ),
                    'desc' => __('Open new window', 'traveler'),
                    'condition' => 'topbar_item:is(link)'
                ),
                array(
                    'id' => 'topbar_position',
                    'label' => __('Position', 'traveler'),
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'left',
                            'label' => __('Left', 'traveler')
                        ),
                        array(
                            'value' => 'right',
                            'label' => __('Right', 'traveler')
                        ),
                    ),
                ),
            ),
        ),
        array(
            'id' => 'hidden_topbar_in_mobile',
            'label' => esc_html__('Hidden topbar in mobile', 'traveler'),
            'desc' => __('Hidden top bar in mobile', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_style',
            'std' => 'on',
            'condition' => 'enable_topbar:is(on)'
        ),
        array(
            'id' => 'gen_enable_sticky_topbar',
            'label' => __('Sticky topbar', 'traveler'),
            'desc' => __('Enable fixed mode for topbar', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_style',
            'std' => 'off',
        ),
        array(
            'id' => 'topbar_bgr',
            'label' => __('Topbar background', 'traveler'),
            'desc' => __('To change background color for topbar', 'traveler'),
            'type' => 'colorpicker',
            'condition' => 'enable_topbar:is(on)',
            'section' => 'option_style',
            'std' => '#333',
        ),/*---- ./END STYLE OPTIONS ----*/
        array(
            'id' => 'featured_tab',
            'label' => __('Featured', 'traveler'),
            'type' => 'tab',
            'section' => 'option_style',
        ),
        array(
            'id' => 'st_text_featured',
            'label' => __("Feature text", 'traveler'),
            'desc' => __("To change text to display featured content:", 'traveler') . "<br>Example: <br>-  Feature<xmp>- BEST <br><small>CHOICE</small></xmp>",
            'type' => 'text',
            'section' => 'option_style',
            'class' => '',
            'std' => 'Featured'
        ),

        array(
            'id' => 'st_ft_label_w',
            'label' => __("Label style fixed width (pixel)", 'traveler'),
            'desc' => __("Type label width, Default : automatic ", 'traveler'),
            'type' => 'text',
            'condition' => 'feature_style:is(label)',
            'section' => 'option_style',
        ),
        array(
            'id' => 'st_text_featured_bg',
            'label' => __('Feature background color', 'traveler'),
            'desc' => __('Text color of featured word', 'traveler'),
            'type' => 'colorpicker',
            'section' => 'option_style',
            'class' => '',
            'std' => '#19A1E5',
        ),
        array(
            'id' => 'st_sl_height',
            'label' => __("Sale label fixed height (pixel)", 'traveler'),
            'desc' => __("Type label height, Default : automatic ", 'traveler'),
            'type' => 'text',
            'condition' => 'sale_style:is(label)',
            'section' => 'option_style',
        ),
        array(
            'id' => 'st_text_sale_bg',
            'label' => __('Promotion background color', 'traveler'),
            'desc' => __('To change background color of the box displaying sale', 'traveler'),
            'type' => 'colorpicker',
            'section' => 'option_style',
            'class' => '',
            'std' => '#cc0033',
        ),
        /*--------------Location options ----------*/

        array(
            'id' => 'location_posts_per_page',
            'label' => __('Number of items in one location', 'traveler'),
            'desc' => __('Default number of posts are shown in Location tab', 'traveler'),
            'type' => 'numeric-slider',
            'min_max_step' => '1,15,1',
            'section' => 'option_location',
            'std' => 5
        ),

        array(
            'id' => 'bc_show_location_url',
            'label' => __('Location link options', 'traveler'),
            'desc' => __('ON: Link of items will redirect to results search page <br>OFF: Link of items will redirect to details page', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_location',
            'std' => 'on'
        ),
        array(
            'id' => 'bc_show_location_tree',
            'label' => __('Build locations by tree structure', 'traveler'),
            'desc' => __('Build locations by tree structure', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_location',
            'std' => 'off'
        ),

        /*--------------End Location options ----------*/

        /*--------------Review Options------------*/

        array(
            'id' => 'review_without_login',
            'label' => __('Write review', 'traveler'),
            'desc' => __('ON: Reviews can be written without logging in <br>OFF: Reviews cannot be written without logging in', 'traveler'),
            'section' => 'option_review',
            'type' => 'on-off',
            'std' => 'on'
        ),
        array(
            'id' => 'review_need_booked',
            'label' => __('User who booked can write review', 'traveler'),
            'desc' => __('ON: User booked can write review <br>OFF: Everyone can write review', 'traveler'),
            'section' => 'option_review',
            'type' => 'on-off',
            'std' => 'off'
        )
    ,
        array(
            'id' => 'review_once',
            'label' => __('Times for review', 'traveler'),
            'desc' => __('ON: Only one time for review <br>OFF: Many times for review', 'traveler'),
            'section' => 'option_review',
            'type' => 'on-off',
            'std' => 'off'
        ),
        array(
            'id' => 'is_review_must_approved',
            'label' => __('Review approved', 'traveler'),
            'desc' => __('ON: Review must be approved by admin <br>OFF: Review is automatically approved', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_review',
            'std' => 'off'
        ),
        /*--------------End Review Options------------*/


        /*--------------Blog Options------------*/
        array(
            'id' => 'blog_sidebar_pos',
            'label' => __('Sidebar position', 'traveler'),
            'desc' => __('Select the position to show sidebar', 'traveler'),
            'type' => 'select',
            'section' => 'option_blog',
            'choices' => array(
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

            ),
            'std' => 'right'
        )
    ,
        array(
            'id' => 'blog_sidebar_id',
            'label' => __('Widget position on sidebar', 'traveler'),
            'desc' => __('You can choose from the list', 'traveler'),
            'type' => 'sidebar-select',
            'section' => 'option_blog',
            'std' => 'blog-sidebar',
        ),
        /*--------------End Blog Options------------*/
        /*--------------Page Options------------*/

        array(
            'id' => 'page_my_account_dashboard',
            'label' => __('Select user dashboard page', 'traveler'),
            'desc' => __('Select the page to display dashboard user page', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_page',
        ),
        array(
            'id' => 'page_redirect_to_after_login',
            'label' => __('Redirect page after login', 'traveler'),
            'desc' => __('Select the page to display after users login to the system ', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_page',
        ),
        array(
            'id' => 'page_redirect_to_after_logout',
            'label' => __('Redirect page after logout', 'traveler'),
            'desc' => __('Select the page to display after users logout from the system ', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_page',
        ),
        array(
            'id' => 'enable_popup_login',
            'label' => esc_html__('Show popup when register', 'traveler'),
            'desc' => esc_html__('Enable/disable login/ register mode in form of popup', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_page',
            'std' => 'off'
        ),
        array(
            'id' => 'page_user_login',
            'label' => __('User Login', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_page',
            'condition' => 'enable_popup_login:is(off)'
        ),
        array(
            'id' => 'page_user_register',
            'label' => __('User Register', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_page',
            'condition' => 'enable_popup_login:is(off)'
        ),
        array(
            'id' => 'page_reset_password',
            'label' => __('Select page for reset password', 'traveler'),
            'desc' => __('Select page for resetting password', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_page',
            'condition' => 'enable_popup_login:is(off)'
        ),
        array(
            'id' => 'page_checkout',
            'label' => __('Select page for checkout', 'traveler'),
            'desc' => __('Select page for checkout', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_page',
        ),
        array(
            'id' => 'page_payment_success',
            'label' => __('Select page for successfully booking', 'traveler'),
            'desc' => __('Select page for successful booking', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_page',
        ),
        array(
            'id' => 'page_order_confirm',
            'label' => __('Order Confirmation Page', 'traveler'),
            'desc' => __('Select page to show booking order', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_page',
        ),
        array(
            'id' => 'page_terms_conditions',
            'label' => __('Terms and Conditions Page', 'traveler'),
            'desc' => __('Select page to show Terms and Conditions', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_page',
        ),

        array(
            'id' => 'footer_template',
            'label' => __('Footer Page', 'traveler'),
            'desc' => __('Select page to show Footer', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_page',
        ),

        array(
            'id' => 'partner_info_page',
            'label' => __('Page for All Author Information(Recommend for Solo Agency)', 'traveler'),
            'desc' => __('When click on all avatar of partner will show that page', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_page',
        ),
        /*--------------End Page Options------------*/

        array(
            'id' => 'datetime_format',
            'label' => __('Input date format', 'traveler'),
            'type' => 'text',
            'std' => '{mm}/{dd}/{yyyy}',
            'section' => 'option_advance',
            'desc' => __('The date format, combination of d, dd, mm, yy, yyyy. It is surrounded by <code>\'{}\'</code>. Ex: {dd}/{mm}/{yyyy}.
                <ul>
                <li><code>d, dd</code>: Numeric date, no leading zero and leading zero, respectively. Eg, 5, 05.</li>
                <li><code>m, mm</code>: Numeric month, no leading zero and leading zero, respectively. Eg, 7, 07.</li>
                <li><code>yy, yyyy:</code> 2- and 4-digit years, respectively. Eg, 12, 2012.</li>
                </ul>
                ', 'traveler'),
        ),
        array(
            'id' => 'time_format',
            'label' => __('Select time format', 'traveler'),
            'type' => 'select',
            'std' => '12h',
            'choices' => array(
                array(
                    'value' => '12h',
                    'label' => __('12h', 'traveler')
                ),
                array(
                    'value' => '24h',
                    'label' => __('24h', 'traveler')
                ),
            ),
            'section' => 'option_advance',
        ),
        array(
            'id' => 'update_weather_by',
            'label' => __('Weather auto update after:', 'traveler'),
            'type' => 'numeric-slider',
            'min_max_step' => '1,12,1',
            'std' => 12,
            'section' => 'option_advance',
            'desc' => __('Weather updates (Unit: hour)', 'traveler'),
        ),
        array(
            'id' => 'show_price_free',
            'label' => __('Show info when service is free', 'traveler'),
            'type' => 'on-off',
            'desc' => __('Price is not shown when accommodation is free', 'traveler'),
            'section' => 'option_advance',
            'std' => 'off'
        ),
        //        array(
        //            'id'      => 'adv_compress_html' ,
        //            'label'   => __( 'Compress HTML' , 'traveler' ) ,
        //            'desc'    => __( 'This allows you to compress HTML code.' , 'traveler' ) ,
        //            'type'    => 'on-off' ,
        //            'section' => 'option_advance' ,
        //            'std'     => 'off'
        //        )
        //        ,
        array(
            'id' => 'adv_before_body_content',
            'label' => __('Before Body Content', 'traveler'),
            'desc' => sprintf(__('Input content after %s tag.', 'traveler'), esc_html('<body>')),
            'type' => 'textarea-simple',
            'section' => 'option_advance',
            //'std'=>'off'
        )
    ,
        array(
            'id' => 'edv_enable_demo_mode',
            'label' => __('Show demo mode', 'traveler'),
            'desc' => __('Do some magical', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_advance',
            'std' => 'off',
            //'std'=>'off'
        ),
        array(
            'id' => 'envato_username',
            'label' => __("Envato username", 'traveler'),
            'desc' => __("Envato username", 'traveler'),
            'type' => 'text',
            'section' => 'option_update'
        ),
        array(
            'id' => 'envato_apikey',
            'label' => __("Envato API key", 'traveler'),
            'desc' => __("Envato API key", 'traveler'),
            'type' => 'text',
            'section' => 'option_update'
        ),
        array(
            'id' => 'envato_purchasecode',
            'label' => __("Purchase code", 'traveler'),
            'desc' => __("Purchase code", 'traveler'),
            'type' => 'text',
            'section' => 'option_update'
        ),
        /*------------- Booking Option --------------*/
        array(
            'id' => 'booking_tab',
            'label' => __('Booking Options', 'traveler'),
            'type' => 'tab',
            'section' => 'option_booking'
        ),
        array(
            'id' => 'booking_modal',
            'label' => __('Show popup booking form', 'traveler'),
            'desc' => __('Show/hide booking mode with popup form. This option only works when turning off Woocommerce Checkout', 'traveler'),
            'type' => 'on-off',
            'std' => 'off',
            'section' => 'option_booking',
            'condition' => 'use_woocommerce_for_booking:is(off)'
        ),
        array(
            'id' => 'booking_enable_captcha',
            'label' => __('Show captcha', 'traveler'),
            'desc' => __('Enable captcha for booking form. It is applied for normal booking form', 'traveler'),
            'type' => 'on-off',
            'std' => 'on',
            'section' => 'option_booking',
            'desc' => __('Only use for submit form booking', 'traveler'),
        ),
        array(
            'id' => 'booking_card_accepted',
            'label' => __('Accepted cards', 'traveler'),
            'desc' => __('Add, remove accepted payment cards ', 'traveler'),
            'type' => 'list-item',
            'settings' => array(
                array(
                    'id' => 'image',
                    'label' => __('Image', 'traveler'),
                    'desc' => __('Image', 'traveler'),
                    'type' => 'upload'
                )
            ),
            'std' => array(
                array(
                    'title' => 'Master Card',
                    'image' => get_template_directory_uri() . '/img/card/mastercard.png'
                ),
                array(
                    'title' => 'JCB',
                    'image' => get_template_directory_uri() . '/img/card/jcb.png'
                ),
                array(
                    'title' => 'Union Pay',
                    'image' => get_template_directory_uri() . '/img/card/unionpay.png'
                ),
                array(
                    'title' => 'VISA',
                    'image' => get_template_directory_uri() . '/img/card/visa.png'
                ),
                array(
                    'title' => 'American Express',
                    'image' => get_template_directory_uri() . '/img/card/americanexpress.png'
                ),
            ),
            'section' => 'option_booking',
        )
    ,
        array(
            'id' => 'booking_currency',
            'label' => __('List of currencies', 'traveler'),
            'desc' => __('Add, remove a kind of currency for payment', 'traveler'),
            'type' => 'list-item',
            'section' => 'option_booking',
            'settings' => array(
                array(

                    'id' => 'name',
                    'label' => __('Currency Name', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => TravelHelper::ot_all_currency()
                ),
                array(

                    'id' => 'symbol',
                    'label' => __('Currency Symbol', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and'
                ),
                array(

                    'id' => 'rate',
                    'label' => __('Exchange rate', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and',
                    'desc' => __('Exchange rate vs primary currency. Set "1" if it\'s already the primary currency', 'traveler')
                ),
                array(

                    'id' => 'booking_currency_pos',
                    'label' => __('Currency Position', 'traveler'),
                    'desc' => __('This controls the position of the currency symbol.<br>Ex: $400 or 400 $', 'traveler'),
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'left',
                            'label' => __('Left (£99.99)', 'traveler'),
                        ),
                        array(
                            'value' => 'right',
                            'label' => __('Right (99.99£)', 'traveler'),
                        ),
                        array(
                            'value' => 'left_space',
                            'label' => __('Left with space (£ 99.99)', 'traveler'),
                        ),
                        array(
                            'value' => 'right_space',
                            'label' => __('Right with space (99.99 £)', 'traveler'),
                        )
                    ),
                    'std' => 'left'
                ),
                array(
                    'id' => 'currency_rtl_support',
                    'type' => "on-off",
                    'label' => __("This currency is use for RTL languages?", 'traveler'),
                    'std' => 'off'
                ),
                array(

                    'id' => 'thousand_separator',
                    'label' => __('Thousand Separator', 'traveler'),
                    'type' => 'text',
                    'std' => '.',
                    'desc' => __('Optional. Specifies what string to use for thousands separator.', 'traveler')
                ),
                array(
                    'id' => 'decimal_separator',
                    'label' => __('Decimal Separator', 'traveler'),
                    'type' => 'text',
                    'std' => ',',
                    'desc' => __('Optional. Specifies what string to use for decimal point', 'traveler')

                ),
                array(
                    'id' => 'booking_currency_precision',
                    'label' => __('Currency decimal', 'traveler'),
                    'desc' => __('Sets the number of decimal points.', 'traveler'),
                    'type' => 'numeric-slider',
                    'min_max_step' => '0,5,1',
                    'std' => 2
                ),

            ),
            'std' => array(
                array(
                    'title' => 'USD',
                    'name' => 'USD',
                    'symbol' => '$',
                    'rate' => 1,
                    'booking_currency_pos' => 'left',
                    'thousand_separator' => '.',
                    'decimal_separator' => ',',
                    'booking_currency_precision' => 2,

                ),
                array(
                    'title' => 'EUR',
                    'name' => 'EUR',
                    'symbol' => '€',
                    'rate' => 0.796491,
                    'booking_currency_pos' => 'left',
                    'thousand_separator' => '.',
                    'decimal_separator' => ',',
                    'booking_currency_precision' => 2,
                ),
                array(
                    'title' => 'GBP',
                    'name' => 'GBP',
                    'symbol' => '£',
                    'rate' => 0.636169,
                    'booking_currency_pos' => 'right',
                    'thousand_separator' => ',',
                    'decimal_separator' => ',',
                    'booking_currency_precision' => 2,
                ),
            )

        ),
        array(
            'id' => 'booking_primary_currency',
            'label' => __('Primary Currency', 'traveler'),
            'desc' => __('Select a unit of currency as main currency', 'traveler'),
            'type' => 'select',
            'section' => 'option_booking',
            'choices' => TravelHelper::get_currency(true),
            'std' => 'USD'
        ),
        array(
            'id' => 'booking_currency_conversion',
            'label' => __('Currency conversion', 'traveler'),
            'desc' => __('It is used to convert any currency into dollars (USD) when booking in paypal with the currencies having not been supported yet.', 'traveler'),
            'type' => 'list-item',
            'section' => 'option_booking',
            'settings' => array(
                array(
                    'id' => 'name',
                    'label' => __('Currency Name', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => TravelHelper::ot_all_currency()
                ),
                array(
                    'id' => 'rate',
                    'label' => __('Exchange rate', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and',
                    'desc' => __('Exchange rate vs primary currency. Set "1" if it\'s already the primary currency', 'traveler')
                ),
            )
        ),
        array(
            'id' => 'is_guest_booking',
            'label' => __('Allow guest booking', 'traveler'),
            'desc' => __("Enable/disable this mode to allow users who have not logged in to book", 'traveler'),
            'section' => 'option_booking',
            'type' => 'on-off',
            'std' => 'off'
        ),

        array(
            'id' => 'st_booking_enabled_create_account',
            'label' => __('Enable create account option', 'traveler'),
            'desc' => __('Enable create account option in checkout page. Default: Enabled', 'traveler'),
            'type' => 'on-off',
            'std' => 'off',
            'section' => 'option_booking',
            'condition' => 'is_guest_booking:is(on)'
        ),
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
        array(
            'id' => 'guest_create_acc_required',
            'label' => __('Always create new account after checkout', 'traveler'),
            'desc' => __('This options required input checker <em>Create new account</em> for Guest booking ', 'traveler'),
            'section' => 'option_booking',
            'type' => 'on-off',
            'std' => 'off',
            'condition' => 'is_guest_booking:is(on)st_booking_enabled_create_account:is(on)'
        ),
        array(
            'id' => 'woocommerce_tab',
            'label' => __('Woocommerce Options', 'traveler'),
            'type' => 'tab',
            'section' => 'option_booking',
        ),
        array(
            'id' => 'use_woocommerce_for_booking',
            'section' => 'option_booking',
            'label' => __('Use WooCommerce checkout', 'traveler'),
            'desc' => __('Enable/disable Woocomerce for Booking. If you use single currency, set same currency rate in both Theme Settings > Booking Option > List of currencies and WooCommerces > Settings > General - Currency. If you use multi currencies, install WOOCS - WooCommerce Currency Switcher plugin then set up same currency rate in both Theme Settings > Booking Option > List of currencies and WooCommerces > Settings > Currency. And WOOCS - WooCommerce Currency Switcher free allow 2 currency only', 'traveler'),
            'type' => 'on-off',
            'condition' => "use_woocommerce_for_booking:is(on)",
            'std' => 'off',
        ),
        array(
            'id' => 'multi_item_in_cart',
            'section' => 'option_booking',
            'label' => __('Multi item in cart', 'traveler'),
            'desc' => __('If enabled, the customer cannot cancel the booking. Only the admin can cancel the whole order in WPAdmin. If disable multi-item-cart, the customer can cancel the booking in the User Dashboard.', 'traveler'),
            'type' => 'on-off',
            'condition' => "use_woocommerce_for_booking:is(on)",
            'std' => 'off',
        ),
        array(
            'id' => 'woo_checkout_show_shipping',
            'section' => 'option_booking',
            'label' => __('Show Shipping Information', 'traveler'),
            'type' => 'on-off',
            'std' => 'off',
            'condition' => "use_woocommerce_for_booking:is(on)"
        ),
        array(
            'id' => 'st_woo_cart_is_collapse',
            'section' => 'option_booking',
            'label' => __('Show Cart item Information collapsed', 'traveler'),
            'type' => 'on-off',
            'std' => 'off',
            'condition' => "use_woocommerce_for_booking:is(on)"
        ),
        array(
            'id' => 'tax_tab',
            'label' => __('Tax Options', 'traveler'),
            'type' => 'tab',
            'section' => 'option_booking',
        ),
        array(
            'id' => 'tax_enable',
            'label' => __('Enable tax', 'traveler'),
            'desc' => __('Enable/disable the Tax feature. This feature does not support WooCommerce Checkout', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_booking',
            'std' => 'off'
        )
    ,
        array(
            'id' => 'st_tax_include_enable',
            'label' => __('Price included tax', 'traveler'),
            'desc' => __('ON: Tax has been included in the price of product <br>OFF: Tax has not been included in the price of product', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_booking',
            'condition' => 'tax_enable:is(on)',
            'std' => 'off'
        )
    ,
        array(
            'id' => 'tax_value',
            'label' => __('Tax value (%)', 'traveler'),
            'desc' => __('Tax percentage', 'traveler'),
            'type' => 'text',
            'section' => 'option_booking',
            'condition' => 'tax_enable:is(on)',
            'std' => 10
        ),
        
        array(
            'id' => 'booking_fee_tab',
            'label' => __('Booking Fee Options', 'traveler'),
            'type' => 'tab',
            'section' => 'option_booking',
        ),
        array(
            'id' => 'booking_fee_enable',
            'label' => __('Enable Booking Fee', 'traveler'),
            'desc' => __('Enable/disable the booking fee feature. This feature does not support WooCommerce Checkout', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_booking',
            'std' => 'off'
        ),
        array(
            'id' => 'booking_fee_type',
            'label' => __("Fee Type", 'traveler'),
            'type' => 'select',
            'choices' => array(
                array(
                    'value' => 'percent',
                    'label' => __('Fee by percent', 'traveler')
                ),
                array(
                    'value' => 'amount',
                    'label' => __('Fee by amount', 'traveler')
                ),
            ),
            'section' => 'option_booking',
            'condition' => 'booking_fee_enable:is(on)',
        ),
        array(
            'id' => 'booking_fee_amount',
            'label' => __('Fee amount', 'traveler'),
            'desc' => __('Leave empty for disallow booking fee', 'traveler'),
            'type' => 'text',
            'section' => 'option_booking',
            'std' => '0',
            'condition' => 'booking_fee_enable:is(on)',
        ),

        /*------------- End Booking Option --------------*/


        /*------------- Hotel Option --------------*/
        array(
            'id' => 'hotel_single_book_room',
            'label' => __('Booking room in single hotel', 'traveler'),
            'desc' => '',
            'type' => 'on-off',
            'section' => 'option_hotel',
            'std' => 'off'
        ),
        array(
            'id' => 'hotel_show_min_price',
            'label' => __("Price show on listing", 'traveler'),
            'desc' => __('AVG: Show average price on results search page <br>MIN: Show minimum price on results search page', 'traveler'),
            'type' => 'select',
            'choices' => array(
                array(
                    'value' => 'avg_price',
                    'label' => __('Avg Price', 'traveler')

                ),
                array(
                    'value' => 'min_price',
                    'label' => __('Min Price', 'traveler')
                ),
            ),
            'section' => 'option_hotel',
        ),
        array(
            'id' => 'view_star_review',
            'label' => __('Show Hotel Stars or Hotel Reviews', 'traveler'),
            'desc' => __('Hotel star: Show hotel stars on elements of hotel list <br>Hotel review: Show the number of review stars on elements of hotel list ', 'traveler'),
            'type' => 'select',
            'section' => 'option_hotel',
            'choices' => array(
                array(
                    'label' => __('Hotel Stars', 'traveler'),
                    'value' => 'star'
                ),
                array(
                    'label' => __('Hotel Reviews', 'traveler'),
                    'value' => 'review'
                )
            ),
        ),
        array(
            'id' => 'hotel_search_result_page',
            'label' => __('Hotel search result page', 'traveler'),
            'desc' => __('Select page to show hotel results search page', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_hotel',
        ),
        array(
            'id' => 'hotel_posts_per_page',
            'label' => __('Items per page', 'traveler'),
            'desc' => __('Number of items on a hotel results search page', 'traveler'),
            'type' => 'numeric-slider',
            'min_max_step' => '1,50,1',
            'section' => 'option_hotel',
            'std' => '12'

        )
    ,
        array(
            'id' => 'hotel_single_layout',
            'label' => __('Hotel details layout', 'traveler'),
            'desc' => __('Select layout to display default single hotel', 'traveler'),
            'type' => 'st_select_layout',
            'post_type' => 'st_hotel',
            'section' => 'option_hotel'
        )
    ,
        array(
            'id' => 'hotel_search_layout',
            'label' => __('Hotel search layout', 'traveler'),
            'desc' => __('Select page to display hotel search page', 'traveler'),
            'type' => 'st_select_layout',
            'post_type' => 'st_hotel_search',
            'section' => 'option_hotel'
        ),


        
        array(
            'id' => 'hotel_review',
            'label' => __('Enable Review', 'traveler'),
            'desc' => __('ON: Users can review for hotel  <br>OFF: User can not review for hotel', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_hotel',
            'std' => 'on'
        ),

        array(
            'id' => 'hotel_review_stats',
            'label' => __('Review criterias', 'traveler'),
            'desc' => __('You can add, edit, delete an review criteria for hotel', 'traveler'),
            'type' => 'list-item',
            'section' => 'option_hotel',
            'condition' => 'hotel_review:is(on)',
            'settings' => array(
                array(
                    'id' => 'name',
                    'label' => __('Stat Name', 'traveler'),
                    'type' => 'textblock',
                    'operator' => 'and',
                ),
                array(
                    'id' => 'icon',
                    'label' => __('Icon review', 'traveler'),
                    'type' => 'upload',
                    'operator' => 'and',
                )
            ),
            'std' => array(

                array('title' => 'Sleep'),
                array('title' => 'Location'),
                array('title' => 'Service'),
                array('title' => 'Cleanliness'),
                array('title' => 'Room(s)'),
            )
        ),
        array(
            'id' => 'hotel_sidebar_pos',
            'label' => __('Hotel sidebar position', 'traveler'),
            'type' => 'select',
            'section' => 'option_hotel',
            'choices' => array(
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

            ),
            'std' => 'left'

        ),
        array(
            'id' => 'hotel_sidebar_area',
            'label' => __('Sidebar Area', 'traveler'),
            'type' => 'sidebar-select',
            'section' => 'option_hotel',
        ),
        array(
            'id' => 'is_featured_search_hotel',
            'label' => __('Show featured hotels on top of search result', 'traveler'),
            'desc' => __('ON: Show featured items on top of result search page', 'traveler'),
            'type' => 'on-off',
            'std' => 'off',
            'section' => 'option_hotel'
        ),
        'flied_hotel' => array(
            'id' => 'hotel_search_fields',
            'label' => __('Hotel custom search form', 'traveler'),
            'desc' => __('You can add, edit, delete or sort fields to make a search form for hotel', 'traveler'),
            'type' => 'list-item',
            'section' => 'option_hotel',
            'std' => array(
                array(
                    'title' => __('Where are you going?', 'traveler'),
                    'name' => 'location',
                    'placeholder' => __("Location/ Zipcode", 'traveler'),
                    'layout_col' => 12,
                    'layout2_col' => 12

                ),
                array(
                    'title' => __('Check in', 'traveler'),
                    'name' => 'checkin',
                    'layout_col' => 3,
                    'layout2_col' => 3
                ),
                array(
                    'title' => __('Check out', 'traveler'),
                    'name' => 'checkout',
                    'layout_col' => 3,
                    'layout2_col' => 3
                ),
                array(
                    'title' => __('Room(s)', 'traveler'),
                    'name' => 'room_num',
                    'layout_col' => 3,
                    'layout2_col' => 3
                ),
                array(
                    'title' => __('Adult', 'traveler'),
                    'name' => 'adult',
                    'layout_col' => 3,
                    'layout2_col' => 3
                )
            ),
            'settings' => array(
                array(
                    'id' => 'name',
                    'label' => __('Field Type', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => STHotel::get_search_fields_name()
                ),
                array(
                    'id' => 'placeholder',
                    'label' => __('Placeholder', 'traveler'),
                    'desc' => __('Placeholder', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and',
                ),
                array(
                    'id' => 'layout_col',
                    'label' => __('Layout 1 Size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'std' => 4,
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                ),
                array(
                    'id' => 'layout2_col',
                    'label' => __('Layout 2 Size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'std' => 4,
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                ),
                array(
                    'id' => 'taxonomy',
                    'label' => __('Taxonomy', 'traveler'),
                    'condition' => 'name:is(taxonomy)',
                    'operator' => 'or',
                    'type' => 'st_select_tax',
                    'post_type' => 'st_hotel'
                ),
                array(
                    'id' => 'type_show_taxonomy_hotel',
                    'label' => __('Type show', 'traveler'),
                    'condition' => 'name:is(taxonomy)',
                    'operator' => 'or',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'checkbox',
                            'label' => __('Checkbox', 'traveler'),
                        ),
                        array(
                            'value' => 'select',
                            'label' => __('Select', 'traveler'),
                        ),
                    )
                ),
                array(
                    'id' => 'taxonomy_room',
                    'label' => __('Taxonomy Room', 'traveler'),
                    'condition' => 'name:is(taxonomy_room)',
                    'operator' => 'or',
                    'type' => 'st_select_tax',
                    'post_type' => 'hotel_room'
                ),
                array(
                    'id' => 'type_show_taxonomy_hotel_room',
                    'label' => __('Type show', 'traveler'),
                    'condition' => 'name:is(taxonomy_room)',
                    'operator' => 'or',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'checkbox',
                            'label' => __('Checkbox', 'traveler'),
                        ),
                        array(
                            'value' => 'select',
                            'label' => __('Select', 'traveler'),
                        ),
                    )
                ),
                array(
                    'id' => 'max_num',
                    'label' => __("Max number", 'traveler'),
                    'condition' => 'name:is(list_name)',
                    'type' => "text",
                    'std' => 20
                ),
                array(
                    'id' => 'is_required',
                    'label' => __('Field required', 'traveler'),
                    'type' => 'on-off',
                    'operator' => 'and',
                    'std' => 'on',
                ),
            )
        ),
        array(
            'id' => 'hotel_allow_search_advance',
            'label' => __('Allow advanced search', 'traveler'),
            'desc' => __('ON: Turn on the mode to add advanced search field in hotel search form', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_hotel',
            'std' => 'off',
        ),
        array(
            'id' => 'hotel_search_advance',
            'label' => __('Hotel Advanced Search fields', 'traveler'),
            'type' => 'list-item',
            'section' => 'option_hotel',
            'condition' => 'hotel_allow_search_advance:is(on)',
            'desc' => __('You can add, edit, delete, drag and drop any field for settingup advanced search form', 'traveler'),
            'settings' => array(
                array(
                    'id' => 'name',
                    'label' => __('Field', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => STHotel::get_search_fields_name()

                ),
                array(
                    'id' => 'layout_col',
                    'label' => __('Layout 1 Size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'std' => 4,
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                ),
                array(
                    'id' => 'layout2_col',
                    'label' => __('Layout 2 Size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'std' => 4,
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                ),
                array(
                    'id' => 'taxonomy',
                    'label' => __('Taxonomy', 'traveler'),
                    'operator' => 'and',
                    'type' => 'st_select_tax',
                    'post_type' => 'st_hotel'
                ),
                array(
                    'id' => 'type_show_taxonomy_hotel',
                    'label' => __('Type show', 'traveler'),
                    'condition' => 'name:is(taxonomy)',
                    'operator' => 'or',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'checkbox',
                            'label' => __('Checkbox', 'traveler'),
                        ),
                        array(
                            'value' => 'select',
                            'label' => __('Select', 'traveler'),
                        ),
                    )
                ),
                array(
                    'id' => 'taxonomy_room',
                    'label' => __('Taxonomy Room', 'traveler'),
                    'condition' => 'name:is(taxonomy_room)',
                    'operator' => 'or',
                    'type' => 'st_select_tax',
                    'post_type' => 'hotel_room'
                ),
                array(
                    'id' => 'type_show_taxonomy_hotel_room',
                    'label' => __('Type show', 'traveler'),
                    'condition' => 'name:is(taxonomy_room)',
                    'operator' => 'or',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'checkbox',
                            'label' => __('Checkbox', 'traveler'),
                        ),
                        array(
                            'value' => 'select',
                            'label' => __('Select', 'traveler'),
                        ),
                    )
                ),
                array(
                    'id' => 'max_num',
                    'label' => __("Max number", 'traveler'),
                    'condition' => 'name:is(list_name)',
                    'type' => "text",
                    'std' => 20
                ),
                array(
                    'id' => 'is_required',
                    'label' => __('Field required', 'traveler'),
                    'type' => 'on-off',
                    'operator' => 'and',
                    'std' => 'on',
                ),
            ),
            'std' => array(
                array(
                    'title' => __('Hotel Theme', 'traveler'),
                    'name' => 'taxonomy',
                    'layout_col' => 12,
                    'layout2_col' => 12,
                    'taxonomy' => 'hotel_theme',


                ),
                array(
                    'title' => __('Room Facilitites', 'traveler'),
                    'name' => 'taxonomy_room',
                    'layout_col' => 12,
                    'layout2_col' => 12,
                    'taxonomy' => 'hotel_facilities',
                ),
            ),
        ),
        array(
            'id' => 'hotel_nearby_range',
            'label' => __('Hotel Nearby Range', 'traveler'),
            'type' => 'text',
            'section' => 'option_hotel',
            'desc' => __('You can input distance (km) to find nearby hotels ', 'traveler'),
            'std' => 10
        ),
        array(
            'id' => 'hotel_unlimited_custom_field',
            'label' => __('Hotel custom fields', 'traveler'),
            'type' => 'Slider',
            'section' => 'option_hotel',
            'desc' => __('You can add, edit, delete custom fields for hotel', 'traveler'),
            'settings' => array(
                array(
                    'id' => 'type_field',
                    'label' => __('Field type', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => 'text',
                            'label' => __('Text field', 'traveler')
                        ),
                        array(
                            'value' => 'textarea',
                            'label' => __('Textarea field', 'traveler')
                        ),
                        array(
                            'value' => 'date-picker',
                            'label' => __('Date field', 'traveler')
                        ),
                    )

                ),
                array(
                    'id' => 'default_field',
                    'label' => __('Default', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and'
                ),

            ),
        ),
        array(
            'id' => 'st_hotel_icon_map_marker',
            'label' => __('Map marker icon', 'traveler'),
            'desc' => __('Select map icon to show service on Map Google', 'traveler'),
            'type' => 'upload',
            'section' => 'option_hotel',
            'std' => 'http://maps.google.com/mapfiles/marker_black.png'
        ),
        /*------------- End Hotel Option --------------*/
        /*------------- Hotel Room Option --------------*/
        array(
            'id' => 'hotel_room_search_layout',
            'label' => __('Select room search layout', 'traveler'),
            'desc' => __('Select layout for searching room', 'traveler'),
            'type' => 'st_select_layout',
            'post_type' => 'st_hotel_room_search',
            'section' => 'option_hotel_room'
        ),
        array(
            'id' => 'hotel_room_search_result_page',
            'label' => __('Room Search Result Page', 'traveler'),
            'desc' => __('Select page to show room search results', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_hotel_room',
        ),
        array(
            'id' => 'hotel_single_room_layout',
            'label' => __('Single room layout', 'traveler'),
            'desc' => __('Select layout to show single room', 'traveler'),
            'type' => 'st_select_layout',
            'post_type' => 'hotel_room',
            'section' => 'option_hotel_room'
        ),
        'flied_room' => array(
            'id' => 'room_search_fields',
            'label' => __('Room advanced search fields', 'traveler'),
            'desc' => __('You can add, edit, delete, drag and drop any fields to setup advanced form', 'traveler'),
            'type' => 'list-item',
            'section' => 'option_hotel_room',
            'std' => array(
                array(
                    'title' => __('Where are you going?', 'traveler'),
                    'name' => 'location',
                    'placeholder' => __("Location/ Zipcode", 'traveler'),
                    'layout_col' => 12,
                    'layout2_col' => 12

                ),
                array(
                    'title' => __('Check in', 'traveler'),
                    'name' => 'checkin',
                    'layout_col' => 3,
                    'layout2_col' => 3
                ),
                array(
                    'title' => __('Check out', 'traveler'),
                    'name' => 'checkout',
                    'layout_col' => 3,
                    'layout2_col' => 3
                ),
                array(
                    'title' => __('Room(s)', 'traveler'),
                    'name' => 'room_num',
                    'layout_col' => 3,
                    'layout2_col' => 3
                )
            ),
            'settings' => array(
                array(
                    'id' => 'name',
                    'label' => __('Field Type', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => STRoom::get_search_fields_name()
                ),
                array(
                    'id' => 'placeholder',
                    'label' => __('Placeholder', 'traveler'),
                    'desc' => __('Placeholder', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and',
                ),
                array(
                    'id' => 'layout_col',
                    'label' => __('Layout 1 Size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'std' => 4,
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                ),
                array(
                    'id' => 'layout2_col',
                    'label' => __('Layout 2 Size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'std' => 4,
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                ),
                array(
                    'id' => 'taxonomy',
                    'label' => __('Taxonomy', 'traveler'),
                    'condition' => 'name:is(taxonomy)',
                    'operator' => 'or',
                    'type' => 'st_select_tax',
                    'post_type' => 'hotel_room'
                ),
                array(
                    'id' => 'type_show_taxonomy_hotel',
                    'label' => __('Type show', 'traveler'),
                    'condition' => 'name:is(taxonomy)',
                    'operator' => 'or',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'checkbox',
                            'label' => __('Checkbox', 'traveler'),
                        ),
                        array(
                            'value' => 'select',
                            'label' => __('Select', 'traveler'),
                        ),
                    )
                ),
                array(
                    'id' => 'taxonomy_room',
                    'label' => __('Taxonomy Room', 'traveler'),
                    'condition' => 'name:is(taxonomy_room)',
                    'operator' => 'or',
                    'type' => 'st_select_tax',
                    'post_type' => 'hotel_room'
                ),
                array(
                    'id' => 'type_show_taxonomy_hotel_room',
                    'label' => __('Type show', 'traveler'),
                    'condition' => 'name:is(taxonomy_room)',
                    'operator' => 'or',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'checkbox',
                            'label' => __('Checkbox', 'traveler'),
                        ),
                        array(
                            'value' => 'select',
                            'label' => __('Select', 'traveler'),
                        ),
                    )
                ),
                array(
                    'id' => 'max_num',
                    'label' => __("Max number", 'traveler'),
                    'condition' => 'name:is(list_name)',
                    'type' => "text",
                    'std' => 20
                ),
                array(
                    'id' => 'is_required',
                    'label' => __('Field required', 'traveler'),
                    'type' => 'on-off',
                    'operator' => 'and',
                    'std' => 'on',
                ),

            )
        ),
        array(
            'id' => 'hotel_room_allow_search_advance',
            'label' => __('Allow advanced search', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_hotel_room',
            'std' => 'off',
        ),
        array(
            'id' => 'hotel_room_search_advance',
            'label' => __('Room advanced search fields', 'traveler'),
            'type' => 'list-item',
            'section' => 'option_hotel_room',
            'condition' => 'hotel_room_allow_search_advance:is(on)',
            'desc' => __('You can add, edit, delete, drag and drop any field for setup advanced form', 'traveler'),
            'settings' => array(
                array(
                    'id' => 'name',
                    'label' => __('Field', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => STRoom::get_search_fields_name()

                ),
                array(
                    'id' => 'layout_col',
                    'label' => __('Layout 1 Size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'std' => 4,
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                ),
                array(
                    'id' => 'layout2_col',
                    'label' => __('Layout 2 Size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'std' => 4,
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                ),
                array(
                    'id' => 'taxonomy',
                    'label' => __('Taxonomy', 'traveler'),
                    'operator' => 'and',
                    'type' => 'st_select_tax',
                    'post_type' => 'hotel_room'
                ),
                array(
                    'id' => 'type_show_taxonomy_hotel',
                    'label' => __('Type show', 'traveler'),
                    'condition' => 'name:is(taxonomy)',
                    'operator' => 'or',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'checkbox',
                            'label' => __('Checkbox', 'traveler'),
                        ),
                        array(
                            'value' => 'select',
                            'label' => __('Select', 'traveler'),
                        ),
                    )
                ),
                array(
                    'id' => 'type_show_taxonomy_hotel_room',
                    'label' => __('Type show', 'traveler'),
                    'condition' => 'name:is(taxonomy_room)',
                    'operator' => 'or',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'checkbox',
                            'label' => __('Checkbox', 'traveler'),
                        ),
                        array(
                            'value' => 'select',
                            'label' => __('Select', 'traveler'),
                        ),
                    )
                ),
                array(
                    'id' => 'max_num',
                    'label' => __("Max number", 'traveler'),
                    'condition' => 'name:is(list_name)',
                    'type' => "text",
                    'std' => 20
                ),
                array(
                    'id' => 'is_required',
                    'label' => __('Field required', 'traveler'),
                    'type' => 'on-off',
                    'operator' => 'and',
                    'std' => 'on',
                ),
            ),
            'std' => "",
        ),

        /*------------- End Hotel Room Option --------------*/


        /*------------- Rental Option -----------------*/
        array(
            'id' => 'rental_search_result_page',
            'label' => __('Select Search Result Page', 'traveler'),
            'desc' => __('Select page to show search results page for rental', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_rental',
        ),
        array(
            'id' => 'rental_single_layout',
            'label' => __('Rental Single Layout', 'traveler'),
            'desc' => __('Select layout to show single rental', 'traveler'),
            'type' => 'st_select_layout',
            'post_type' => 'st_rental',
            'section' => 'option_rental'
        ),
        array(
            'id' => 'rental_search_layout',
            'label' => __('Rental Search Layout', 'traveler'),
            'desc' => __('Select layout to show rental search page', 'traveler'),
            'type' => 'st_select_layout',
            'post_type' => 'st_rental_search',
            'section' => 'option_rental'
        ),
        array(
            'id' => 'rental_room_layout',
            'label' => __('Rental Room Default Layout', 'traveler'),
            'desc' => __('Select layout to show single room rental page', 'traveler'),
            'type' => 'st_select_layout',
            'post_type' => 'rental_room',
            'section' => 'option_rental'
        ),
        array(
            'id' => 'rental_review',
            'label' => __('Review options', 'traveler'),
            'desc' => __('ON: Turn on review feature for rental', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_rental',
            'std' => 'on'

        ),

        array(
            'id' => 'rental_review_stats',
            'label' => __('Rental Review Criteria', 'traveler'),
            'desc' => __('You can add, delete, sort review criteria for rental', 'traveler'),
            'type' => 'list-item',
            'section' => 'option_rental',
            'condition' => 'rental_review:is(on)',
            'settings' => array(
                array(
                    'id' => 'name',
                    'label' => __('Stat Name', 'traveler'),
                    'type' => 'textblock',
                )
            ),
            'std' => array(

                array('title' => 'Sleep'),
                array('title' => 'Location'),
                array('title' => 'Service'),
                array('title' => 'Cleanliness'),
                array('title' => 'Room(s)'),
            )
        ),
        array(
            'id' => 'rental_sidebar_pos',
            'label' => __('Rental sidebar position', 'traveler'),
            'desc' => __('The position to show sidebar for rental', 'traveler'),
            'type' => 'select',
            'section' => 'option_rental',
            'choices' => array(
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

            ),
            'std' => 'left'

        ),
        array(
            'id' => 'rental_sidebar_area',
            'label' => __('Sidebar Area', 'traveler'),
            'desc' => __('Select a sidebar widget to display for rental', 'traveler'),
            'type' => 'sidebar-select',
            'section' => 'option_rental',
            'std' => 'rental-sidebar'

        ),
        array(
            'id' => 'is_featured_search_rental',
            'label' => __('Show featured rentals on top of search result', 'traveler'),
            'desc' => __('ON: Show featured items on top of result search page', 'traveler'),
            'type' => 'on-off',
            'std' => 'off',
            'section' => 'option_rental'
        ),
        array(
            'id' => 'rental_search_fields',
            'label' => __('Rental Search Fields', 'traveler'),
            'desc' => __('You can add, delete, sort rental search fields', 'traveler'),
            'type' => 'Slider',
            'section' => 'option_rental',
            'settings' => array(
                array(
                    'id' => 'name',
                    'label' => __('Field Type', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => TravelHelper::st_get_field_search('st_rental', 'option_tree')
                ),
                array(
                    'id' => 'placeholder',
                    'label' => __('Placeholder', 'traveler'),
                    'desc' => __('Placeholder', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and',
                ),
                array(
                    'id' => 'layout_col',
                    'label' => __('Large-box column size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                    'std' => 4
                ),
                array(
                    'id' => 'layout_col2',
                    'label' => __('Small-box column size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                    'std' => 4
                ),
                array(
                    'id' => 'taxonomy',
                    'label' => __('Taxonomy', 'traveler'),
                    'operator' => 'and',
                    'condition' => 'name:is(taxonomy)',
                    'type' => 'st_select_tax',
                    'post_type' => 'st_rental'
                ),
                array(
                    'id' => 'type_show_taxonomy_rental',
                    'label' => __('Type show', 'traveler'),
                    'condition' => 'name:is(taxonomy)',
                    'operator' => 'or',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'checkbox',
                            'label' => __('Checkbox', 'traveler'),
                        ),
                        array(
                            'value' => 'select',
                            'label' => __('Select', 'traveler'),
                        ),
                    )
                ),
                array(
                    'id' => 'max_num',
                    'label' => __('Max number', 'traveler'),
                    'type' => 'text',
                    'condition' => 'name:is(list_name)',
                    'operator' => 'and',
                    'std' => 20
                ),
                array(
                    'id' => 'is_required',
                    'label' => __('Field required', 'traveler'),
                    'type' => 'on-off',
                    'operator' => 'and',
                    'std' => 'on',
                ),
            ),
            'std' => array(
                array(
                    'title' => __('Where are you going?', 'traveler'),
                    'name' => 'location',
                    'placeholder' => __('Location/ Zipcode', 'traveler'),
                    'layout_col' => '12',
                    'layout_col2' => '12'
                ),
                array(
                    'title' => __('Check in', 'traveler'),
                    'name' => 'checkin',
                    'layout_col' => '3',
                    'layout_col2' => '3'
                ),
                array(
                    'title' => __('Check out', 'traveler'),
                    'name' => 'checkout',
                    'layout_col' => '3',
                    'layout_col2' => '3'
                ),
                array(
                    'title' => __('Room(s)', 'traveler'),
                    'name' => 'room_num',
                    'layout_col' => '3',
                    'layout_col2' => '3'
                ),
                array(
                    'title' => __('Adults', 'traveler'),
                    'name' => 'adult',
                    'layout_col' => '3',
                    'layout_col2' => '3'
                )
            )
        ),
        array(
            'id' => 'allow_rental_advance_search',
            'label' => __("Allowed Rental Advanced Search", 'traveler'),
            'desc' => __("ON: Turn on this mode to add advanced search fields", 'traveler'),
            'type' => 'on-off',
            'std' => "off",
            'section' => 'option_rental'
        ),
        array(
            'id' => 'rental_advance_search_fields',
            'label' => __('Rental advanced search fields', 'traveler'),
            'desc' => __('You can add, sort advanced search fields', 'traveler'),
            'type' => 'Slider',
            'section' => 'option_rental',
            'condition' => "allow_rental_advance_search:is(on)",
            'settings' => array(
                array(
                    'id' => 'name',
                    'label' => __('Field Type', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => TravelHelper::st_get_field_search('st_rental', 'option_tree')
                ),
                array(
                    'id' => 'placeholder',
                    'label' => __('Placeholder', 'traveler'),
                    'desc' => __('Placeholder', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and',
                ),
                array(
                    'id' => 'layout_col',
                    'label' => __('Large-box column size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                    'std' => 4
                ),
                array(
                    'id' => 'layout_col2',
                    'label' => __('Small-box column size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                    'std' => 4
                ),
                array(
                    'id' => 'taxonomy',
                    'label' => __('Taxonomy', 'traveler'),
                    'operator' => 'and',
                    'condition' => 'name:is(taxonomy)',
                    'type' => 'st_select_tax',
                    'post_type' => 'st_rental'
                ),
                array(
                    'id' => 'type_show_taxonomy_rental',
                    'label' => __('Type show', 'traveler'),
                    'condition' => 'name:is(taxonomy)',
                    'operator' => 'or',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'checkbox',
                            'label' => __('Checkbox', 'traveler'),
                        ),
                        array(
                            'value' => 'select',
                            'label' => __('Select', 'traveler'),
                        ),
                    )
                ),
                array(
                    'id' => 'max_num',
                    'label' => __('Max number', 'traveler'),
                    'type' => 'text',
                    'condition' => 'name:is(list_name)',
                    'operator' => 'and',
                    'std' => 20
                ),
                array(
                    'id' => 'is_required',
                    'label' => __('Field required', 'traveler'),
                    'type' => 'on-off',
                    'operator' => 'and',
                    'std' => 'on',
                ),
            ),
            'std' => array(
                array(
                    'title' => __('Amenities', 'traveler'),
                    'name' => 'taxonomy',
                    'layout_col' => '12',
                    'layout_col2' => '12',
                    'taxonomy' => 'amenities'
                ),
                array(
                    'title' => __('Suitabilities', 'traveler'),
                    'name' => 'taxonomy',
                    'layout_col' => '12',
                    'layout_col2' => '12',
                    'taxonomy' => 'suitability'
                ),
            )
        ),
        array(
            'id' => 'rental_unlimited_custom_field',
            'label' => __('Rental custom fields', 'traveler'),
            'type' => 'Slider',
            'section' => 'option_rental',
            'desc' => __('You can create, add custom fields for rental', 'traveler'),
            'settings' => array(
                array(
                    'id' => 'type_field',
                    'label' => __('Field type', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => 'text',
                            'label' => __('Text field', 'traveler')
                        ),
                        array(
                            'value' => 'textarea',
                            'label' => __('Textarea field', 'traveler')
                        ),
                        array(
                            'value' => 'date-picker',
                            'label' => __('Date field', 'traveler')
                        ),
                    )

                ),
                array(
                    'id' => 'default_field',
                    'label' => __('Default', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and'
                ),

            ),
        ),
        array(
            'id' => 'st_rental_icon_map_marker',
            'label' => __('Map marker icon', 'traveler'),
            'desc' => __('Select map icon to show rental on Map Google', 'traveler'),
            'type' => 'upload',
            'section' => 'option_rental',
            'std' => 'http://maps.google.com/mapfiles/marker_brown.png'
        ),
        /*------------ End Rental Option --------------*/

        /*------------- Cars Option -----------------*/
        array(
            'id' => 'car_equipment_info_limit',
            'label' => __('Equipment Limit', 'traveler'),
            'desc' => __('Number of equipment showing on search results', 'traveler'),
            'std' => 15,
            'type' => 'numeric-slider',
            'min_max_step' => '0,50, 1',
            'section' => 'option_car',
        ),
        array(
            'id' => 'cars_search_result_page',
            'label' => __('Search Result Page', 'traveler'),
            'desc' => __('Select page to show search results for car', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_car',
        ),
        array(
            'id' => 'cars_single_layout',
            'label' => __('Cars Single Layout', 'traveler'),
            'desc' => __('Select layout to show single car', 'traveler'),
            'type' => 'st_select_layout',
            'post_type' => 'st_cars',
            'section' => 'option_car',
        ),
        array(
            'id' => 'cars_layout_layout',
            'label' => __('Cars Search Layout', 'traveler'),
            'desc' => __('Select layout to show search page for car', 'traveler'),
            'type' => 'st_select_layout',
            'post_type' => 'st_cars_search',
            'section' => 'option_car',
        ),
        array(
            'id' => 'cars_price_unit',
            'label' => __('Price unit', 'traveler'),
            'desc' => __('The unit to calculate the price of car<br/>Day: The price is calculated according to day<br/>Hour: The price is calculated according to hour<br/>', 'traveler'),
            'type' => 'select',
            'section' => 'option_car',
            'choices' => STCars::get_option_price_unit(),
            'std' => 'day'
        ),
        array(
            'id' => 'cars_price_by_distance',
            'label' => __('Price by distance', 'traveler'),
            'type' => 'select',
            'section' => 'option_car',
            'choices' => array(
                array(
                    'value' => 'kilometer',
                    'label' => __('Kilometer', 'traveler')
                ),
                array(
                    'value' => 'mile',
                    'label' => __('Mile', 'traveler')
                )
            ),
            'std' => 'kilometer',
            'condition' => 'cars_price_unit:is(distance)'
        ),
        /*array(
            'id' => 'equipment_by_unit',
            'label' => __('Set equipment price by day/hour', 'traveler'),
            'type' => 'on-off',
            'std' => 'off',
            'section' => 'option_car',
            'operator' => 'or',
            'condition' => 'cars_price_unit:is(day),cars_price_unit:is(hour)'
        ),*/
        array(
            'id' => 'booking_days_included',
            'label' => __('Set default booking info', 'traveler'),
            'type' => 'on-off',
            'std' => 'off',
            'section' => 'option_car',
            'desc' => __("ON: Add one day / hour into day / hour for check in.<br/>For example: 22-23/11/2017 will be 2 days.", 'traveler')
        ),
        array(
            'id' => 'is_featured_search_car',
            'label' => __('Show featured cars on top of search results', 'traveler'),
            'desc' => __('Show featured cars on top of result search page', 'traveler'),
            'type' => 'on-off',
            'std' => 'off',
            'section' => 'option_car'
        ),
        array(
            'id' => 'car_search_fields',
            'label' => __('Car Search Fields', 'traveler'),
            'desc' => __('You can add, sort search fields for car', 'traveler'),
            'type' => 'Slider',
            'section' => 'option_car',
            'settings' => array(

                array(
                    'id' => 'field_atrribute',
                    'label' => __('Field Atrribute', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => STCars::get_search_fields_name()
                ),
                array(
                    'id' => 'placeholder',
                    'label' => __('Placeholder', 'traveler'),
                    'desc' => __('Placeholder', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and',
                ),
                array(
                    'id' => 'layout_col_normal',
                    'label' => __('Layout Normal size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                ),
                array(
                    'id' => 'taxonomy',
                    'label' => __('Taxonomy', 'traveler'),
                    'condition' => 'field_atrribute:is(taxonomy)',
                    'operator' => 'and',
                    'type' => 'st_select_tax',
                    'post_type' => 'st_cars'
                ),
                array(
                    'id' => 'type_show_taxonomy_cars',
                    'label' => __('Type show', 'traveler'),
                    'condition' => 'field_atrribute:is(taxonomy)',
                    'operator' => 'or',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'checkbox',
                            'label' => __('Checkbox', 'traveler'),
                        ),
                        array(
                            'value' => 'select',
                            'label' => __('Select', 'traveler'),
                        ),
                    )
                ),
                array(
                    'id' => 'max_num',
                    'label' => __('Max number', 'traveler'),
                    'condition' => 'field_atrribute:is(list_name)',
                    'type' => 'text',
                    'operator' => 'and',
                    'std' => 20
                ),
                array(
                    'id' => 'is_required',
                    'label' => __('Field required', 'traveler'),
                    'type' => 'on-off',
                    'operator' => 'and',
                    'std' => 'on',
                ),
            ),
            'std' => array(
                array('title' => 'Pick Up From, Drop Off To', 'layout_col_normal' => 12, 'field_atrribute' => 'location'),
                array('title' => 'Pick-up Date ,Pick-up Time',
                    'layout_col_normal' => 6,
                    'field_atrribute' => 'pick-up-date-time'
                ),
                array('title' => 'Drop-off Date ,Drop-off Time',
                    'layout_col_normal' => 6,
                    'field_atrribute' => 'drop-off-date-time'
                ),
            )
        ),
        array(
            'id' => 'car_allow_search_advance',
            'label' => __('Allow advanced search', 'traveler'),
            'type' => 'on-off',
            'std' => 'off',
            'section' => 'option_car'
        ),
        array(
            'id' => 'car_advance_search_fields',
            'label' => __('Allowed Advanced Search  ', 'traveler'),
            'desc' => __('ON: Turn on thiis mode to add advanced search  ', 'traveler'),
            'type' => 'Slider',
            'section' => 'option_car',
            'condition' => 'car_allow_search_advance:is(on)',
            'settings' => array(

                array(
                    'id' => 'field_atrribute',
                    'label' => __('Field Atrribute', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => STCars::get_search_fields_name()
                ),
                array(
                    'id' => 'placeholder',
                    'label' => __('Placeholder', 'traveler'),
                    'desc' => __('Placeholder', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and',
                ),
                array(
                    'id' => 'layout_col_normal',
                    'label' => __('Layout Normal size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                ),
                array(
                    'id' => 'taxonomy',
                    'label' => __('Taxonomy', 'traveler'),
                    'condition' => 'field_atrribute:is(taxonomy)',
                    'operator' => 'and',
                    'type' => 'st_select_tax',
                    'post_type' => 'st_cars'
                ),
                array(
                    'id' => 'type_show_taxonomy_cars',
                    'label' => __('Type show', 'traveler'),
                    'condition' => 'field_atrribute:is(taxonomy)',
                    'operator' => 'or',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'checkbox',
                            'label' => __('Checkbox', 'traveler'),
                        ),
                        array(
                            'value' => 'select',
                            'label' => __('Select', 'traveler'),
                        ),
                    )
                ),
                array(
                    'id' => 'max_num',
                    'label' => __('Max number', 'traveler'),
                    'condition' => 'field_atrribute:is(list_name)',
                    'type' => 'text',
                    'operator' => 'and',
                    'std' => 20
                ),
                array(
                    'id' => 'is_required',
                    'label' => __('Field required', 'traveler'),
                    'type' => 'on-off',
                    'operator' => 'and',
                    'std' => 'on',
                ),
            ),
            'std' => array(
                array('title' => __('Taxonomy', 'traveler'), 'layout_col_normal' => 12, 'field_atrribute' => 'taxonomy'),
                array('title' => __('Filter Price', 'traveler'),
                    'layout_col_normal' => 12,
                    'field_atrribute' => 'price_slider',
                ),
            )
        ),
        array(
            'id' => 'car_search_fields_box',
            'label' => __('Location & Date Change Box', 'traveler'),
            'desc' => __('You can add, sort fields in the change box for car search in the car single page', 'traveler'),
            'type' => 'Slider',
            'section' => 'option_car',
            'settings' => array(


                array(
                    'id' => 'field_atrribute',
                    'label' => __('Field Atrribute', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => STCars::get_search_fields_name()
                ),
                array(
                    'id' => 'placeholder',
                    'label' => __('Placeholder', 'traveler'),
                    'desc' => __('Placeholder', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and',
                ),
                array(
                    'id' => 'layout_col_box',
                    'label' => __('Layout Box size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1/12', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2/12', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3/12', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4/12', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5/12', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6/12', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7/12', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8/12', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9/12', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10/12', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11/12', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12/12', 'traveler')
                        ),
                    ),
                    'std' => 4
                ),
                array(
                    'id' => 'taxonomy',
                    'label' => __('Taxonomy', 'traveler'),
                    'condition' => 'field_atrribute:is(taxonomy)',
                    'operator' => 'and',
                    'type' => 'st_select_tax',
                    'post_type' => 'st_cars'
                ),
                array(
                    'id' => 'type_show_taxonomy_cars',
                    'label' => __('Type show', 'traveler'),
                    'condition' => 'field_atrribute:is(taxonomy)',
                    'operator' => 'or',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'checkbox',
                            'label' => __('Checkbox', 'traveler'),
                        ),
                        array(
                            'value' => 'select',
                            'label' => __('Select', 'traveler'),
                        ),
                    )
                ),
                array(
                    'id' => 'max_num',
                    'label' => __('Max number', 'traveler'),
                    'condition' => 'field_atrribute:is(list_name)',
                    'type' => 'text',
                    'operator' => 'and',
                    'std' => 20
                ),
                array(
                    'id' => 'is_required',
                    'label' => __('Field required', 'traveler'),
                    'type' => 'on-off',
                    'operator' => 'and',
                    'std' => 'on',
                ),
            ),
            'std' => array(
                array('title' => 'Pick Up From, Drop Off To', 'layout_col_box' => 6, 'field_atrribute' => 'location'),
                array('title' => 'Pick-up Date', 'layout_col_box' => 3, 'field_atrribute' => 'pick-up-date'),
                array('title' => 'Pick-up Time', 'layout_col_box' => 3, 'field_atrribute' => 'pick-up-time'),
                array('title' => 'Drop-off Date', 'layout_col_box' => 3, 'field_atrribute' => 'drop-off-date'),
                array('title' => 'Drop-off Time', 'layout_col_box' => 3, 'field_atrribute' => 'drop-off-time'),

            )
        ),
        array(
            'id' => 'car_review',
            'label' => __('Review options', 'traveler'),
            'desc' => __('ON: Turn on the mode of car review', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_car',
            'std' => 'on'

        ),
        array(
            'id' => 'car_review_stats',
            'label' => __('Review criterias', 'traveler'),
            'desc' => __('You can add, sort review criteria for car', 'traveler'),
            'type' => 'list-item',
            'section' => 'option_car',
            'condition' => 'car_review:is(on)',
            'settings' => array(
                array(
                    'id' => 'name',
                    'label' => __('Stat Name', 'traveler'),
                    'type' => 'textblock',
                    'operator' => 'and',
                )
            ),
            'std' => array(

                array('title' => 'stat name 1'),
                array('title' => 'stat name 2'),
                array('title' => 'stat name 3'),
                array('title' => 'stat name 4'),
                array('title' => 'stat name 5'),
            )
        ),
        array(
            'id' => 'st_cars_unlimited_custom_field',
            'label' => __('Car custom fields', 'traveler'),
            'type' => 'Slider',
            'section' => 'option_car',
            'desc' => __('You can create, add custom fields for car', 'traveler'),
            'settings' => array(
                array(
                    'id' => 'type_field',
                    'label' => __('Field type', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => 'text',
                            'label' => __('Text field', 'traveler')
                        ),
                        array(
                            'value' => 'textarea',
                            'label' => __('Textarea field', 'traveler')
                        ),
                        array(
                            'value' => 'date-picker',
                            'label' => __('Date field', 'traveler')
                        ),
                    )

                ),
                array(
                    'id' => 'default_field',
                    'label' => __('Default', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and'
                ),

            ),
        ),
        array(
            'id' => 'st_cars_icon_map_marker',
            'label' => __('Map marker icon', 'traveler'),
            'desc' => __('Select map icon to show car on Map Google', 'traveler'),
            'type' => 'upload',
            'section' => 'option_car',
            'std' => 'http://maps.google.com/mapfiles/marker_green.png'
        ),
        /*------------ End Car Option --------------*/


        /*------------ Begin Email Option --------------*/

        array(
            'id' => 'email_from',
            'label' => __('From name', 'traveler'),
            'desc' => __('Email from name', 'traveler'),
            'type' => 'text',
            'section' => 'option_email',
            'std' => 'Traveler Shinetheme'

        ),
        array(
            'id' => 'email_from_address',
            'label' => __('From address', 'traveler'),
            'desc' => __('Email from address', 'traveler'),
            'type' => 'text',
            'section' => 'option_email',
            'std' => 'traveler@shinetheme.com'

        )
    ,
        array(
            'id' => 'email_logo',
            'label' => __('Select logo in email', 'traveler'),
            'type' => 'upload',
            'section' => 'option_email',
            'desc' => __('Logo in Email', 'traveler'),
            'std' => get_template_directory_uri() . '/img/logo.png'

        ),

        array(
            'id' => 'enable_email_for_custommer',
            'label' => __('Email to customer after booking', 'traveler'),
            'desc' => __('Email to customer after booking', 'traveler'),
            'type' => 'on-off',
            'std' => 'on',
            'section' => 'option_email',
        ),
        array(
            'id' => 'enable_email_confirm_for_customer',
            'label' => __('Email confirm to customer after booking', 'traveler'),
            'desc' => __('Email confirm to customer after booking', 'traveler'),
            'type' => 'on-off',
            'std' => 'on',
            'section' => 'option_email',
            //'condition' => 'enable_email_for_custommer:is(on)' ,
        ),
        array(
            'id' => 'enable_email_for_admin',
            'label' => __('Email to administrator after booking', 'traveler'),
            'desc' => __('Email to administrator after booking', 'traveler'),
            'type' => 'on-off',
            'std' => 'on',
            'section' => 'option_email',
        ),
        array(
            'id' => 'email_admin_address',
            'label' => __('Input administrator email', 'traveler'),
            'desc' => __('Booking information will be sent to here', 'traveler'),
            'type' => 'text',
            'condition' => '',
            'section' => 'option_email',
        ),
        array(
            'id' => 'enable_email_for_owner_item',
            'label' => __('Email after booking for partner/owner item', 'traveler'),
            'desc' => __('Email after booking for partner/owner item', 'traveler'),
            'type' => 'on-off',
            'std' => 'on',
            'section' => 'option_email',
        ),
        array(
            'id' => 'enable_email_approved_item',
            'label' => __('Email template to admin about item needs to be approved', 'traveler'),
            'desc' => __('Email template to admin about item needs to be approved', 'traveler'),
            'type' => 'on-off',
            'std' => 'on',
            'section' => 'option_email',
        ),
        array(
            'id' => 'enable_email_cancel',
            'label' => __('Email to administrator when have an cancel booking', 'traveler'),
            'type' => 'on-off',
            'std' => 'on',
            'desc' => __('Email to administrator when have an cancel booking', 'traveler'),
            'section' => 'option_email'
        ),
        array(
            'id' => 'enable_partner_email_cancel',
            'label' => __('Email to partner when have an cancel booking', 'traveler'),
            'type' => 'on-off',
            'std' => 'on',
            'desc' => __('Email to partner when have an cancel booking', 'traveler'),
            'section' => 'option_email'
        ),
        array(
            'id' => 'enable_email_cancel_success',
            'label' => __('Email to user when booking is cancelled', 'traveler'),
            'type' => 'on-off',
            'std' => 'on',
            'desc' => __('Email to user when booking is cancelled', 'traveler'),
            'section' => 'option_email'
        ),
        /*------------ End Email Option --------------*/
        /*-------------Email Template ----------------*/
        // array(
        //     'id' => 'tab_email_document',
        //     'label' => __('Email Documents', 'traveler'),
        //     'type' => 'tab',
        //     'section' => 'option_email_template',
        // ),
        // array(
        //     'id' => 'email_document',
        //     'label' => __('Email Documents', 'traveler'),
        //     'type' => 'email_template_document',
        //     'section' => 'option_email_template',
        // ),
	    
	    
        array(
            'id' => 'tab_email_for_admin',
            'label' => __('Email For Admin', 'traveler'),
            'type' => 'tab',
            'section' => 'option_email_template',
        ),
        array(
            'id' => 'email_for_admin',
            'label' => __('Email template send to administrator', 'traveler'),
            'type' => 'textarea',
            'rows' => '10',
            'section' => 'option_email_template',
            'std' => function_exists('st_default_email_template_admin') ? st_default_email_template_admin() : false
        ),

        array(
            'id' => 'tab_email_for_partner',
            'label' => __('Email For Partner', 'traveler'),
            'type' => 'tab',
            'section' => 'option_email_template',
        ),
        array(
            'id' => 'email_for_partner',
            'label' => __('Email template send to partner/owner', 'traveler'),
            'type' => 'textarea',
            'rows' => '50',
            'section' => 'option_email_template',
            'std' => function_exists('st_default_email_template_partner') ? st_default_email_template_partner() : false
        ),
        //Email to partner when expired date
        array(
            'id' => 'email_for_partner_expired_date',
            'label' => __('Email template send to partner when package is expired date', 'traveler'),
            'type' => 'textarea',
            'rows' => '50',
            'section' => 'option_email_template',
            'std' => function_exists('st_default_email_template_partner_expired_date') ? st_default_email_template_partner_expired_date() : false
        ),
        array(
            'id' => 'tab_email_for_customer',
            'label' => __('Email For Customer', 'traveler'),
            'type' => 'tab',
            'section' => 'option_email_template',
        ),
        array(
            'id' => 'email_for_customer',
            'label' => __('Email template for booking info send to customer', 'traveler'),
            'type' => 'textarea',
            'rows' => '50',
            'section' => 'option_email_template',
            'std' => function_exists('st_default_email_template_customer') ? st_default_email_template_customer() : false
        ),
        //Email to custommer when out of date
        array(
            'id' => 'email_for_customer_out_of_depature_date',
            'label' => __('Email template for notification of departure date send to customer', 'traveler'),
            'type' => 'textarea',
            'rows' => '50',
            'section' => 'option_email_template',
            'std' => function_exists('st_default_email_template_notification_depature_customer') ? st_default_email_template_notification_depature_customer() : false
        ),
        array(
            'id' => 'tab_email_confirm',
            'label' => __('Email Confirm', 'traveler'),
            'type' => 'tab',
            'section' => 'option_email_template',
        ),
        array(
            'id' => 'email_confirm',
            'label' => __('Email template for confirm send to customer', 'traveler'),
            'type' => 'textarea',
            'rows' => '50',
            'section' => 'option_email_template',
            'std' => function_exists('get_email_confirm_template') ? get_email_confirm_template() : false
        ),
        array(
            'id' => 'tab_email_approved',
            'label' => __('Email Approved', 'traveler'),
            'type' => 'tab',
            'section' => 'option_email_template',
        ),
        array(
            'id' => 'email_approved',
            'label' => __('Email template to admin about item needs to be approved', 'traveler'),
            'type' => 'textarea',
            'rows' => '50',
            'section' => 'option_email_template',
            'std' => function_exists('get_email_approved_template') ? get_email_approved_template() : false
        ),
        array(
            'id' => 'tab_email_cancel_booking',
            'label' => __('Email Cancel Booking', 'traveler'),
            'type' => 'tab',
            'section' => 'option_email_template',
        ),
        array(
            'id' => 'email_has_refund',
            'label' => __('Email template for cancel booking send to administrator', 'traveler'),
            'type' => 'textarea',
            'rows' => '50',
            'section' => 'option_email_template',
            'std' => function_exists('get_email_has_refund_template') ? get_email_has_refund_template() : false
        ),
        array(
            'id' => 'email_has_refund_for_partner',
            'label' => __('Email template for cancel booking send to partner', 'traveler'),
            'type' => 'textarea',
            'rows' => '50',
            'section' => 'option_email_template',
            'std' => function_exists('get_email_has_refund_for_partner_template') ? get_email_has_refund_for_partner_template() : false
        ),
        array(
            'id' => 'email_cancel_booking_success_for_partner',
            'label' => __('Email template for successful canceled send to partner', 'traveler'),
            'type' => 'textarea',
            'rows' => '100',
            'section' => 'option_email_template',
            'std' => function_exists('get_email_cancel_booking_success_for_partner_template') ? get_email_cancel_booking_success_for_partner_template() : false
        ),
        array(
            'id' => 'email_cancel_booking_success',
            'label' => __('Email template for successful canceled send to customer', 'traveler'),
            'type' => 'textarea',
            'rows' => '100',
            'section' => 'option_email_template',
            'std' => function_exists('get_email_cancel_booking_success_template') ? get_email_cancel_booking_success_template() : false
        ),

        /*------------- End Email Template ----------------*/

        /*------------- Activity - Tour Option  -----------------*/
        array(
            'id' => 'tour_show_calendar',
            'label' => __('Show calendar', 'traveler'),
            'desc' => __('ON: Show calendar<br/>OFF: Show small calendar in form of popup', 'traveler'),
            'type' => 'select',
            'choices' => array(
                array(
                    'label' => __('Big calendar show in content', 'traveler'),
                    'value' => 'on'
                ),
                array(
                    'label' => __('Show calendar as date picker', 'traveler'),
                    'value' => 'off'
                ),
            ),
            'section' => 'option_activity_tour',
            'std' => 'on'

        ),
        array(
            'id' => 'tour_show_calendar_below',
            'label' => __('Calendar position', 'traveler'),
            'desc' => __('ON: Show calendar below book form<br/>OF: Show calendar above book form', 'traveler'),
            'type' => 'select',
            'choices' => array(
                array(
                    'label' => __('Under check availability', 'traveler'),
                    'value' => 'off'
                ),
                array(
                    'label' => __('Below check availability', 'traveler'),
                    'value' => 'on'
                ),
            ),
            'section' => 'option_activity_tour',
            'std' => 'off',
            'condition' => 'tour_show_calendar:is(on)',
        ),

        array(
            'id' => 'activity_tour_review',
            'label' => __('Review options', 'traveler'),
            'desc' => __('ON: Turn on the mode for reviewing tour', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_activity_tour',
            'std' => 'on'

        ),
        array(
            'id' => 'tour_review_stats',
            'label' => __('Review criteria', 'traveler'),
            'desc' => __('You can add, sort review criteria for tour', 'traveler'),
            'type' => 'list-item',
            'section' => 'option_activity_tour',
            'condition' => 'activity_tour_review:is(on)',
            'settings' => array(
                array(
                    'id' => 'name',
                    'label' => __('Stat Name', 'traveler'),
                    'type' => 'textblock',
                    'operator' => 'and',
                )
            ),
            'std' => array(

                array('title' => 'Sleep'),
                array('title' => 'Location'),
                array('title' => 'Service'),
                array('title' => 'Cleanliness'),
                array('title' => 'Room(s)'),
            )
        ),
        array(
            'id' => 'tours_search_result_page',
            'label' => __('Select layout for result page', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_activity_tour',
        ),
        array(
            'id' => 'tours_layout',
            'label' => __('Tour Layout', 'traveler'),
            'desc' => __('Select layout to show single tour ', 'traveler'),
            'type' => 'st_select_layout',
            'post_type' => 'st_tours',
            'section' => 'option_activity_tour',
        ),
        array(
            'id' => 'tours_search_layout',
            'label' => __('Tour Search Result Page', 'traveler'),
            'desc' => __('Select page to show search results for tour', 'traveler'),
            'type' => 'st_select_layout',
            'post_type' => 'st_tours_search',
            'section' => 'option_activity_tour',
        ),
        array(
            'id' => 'tour_sidebar_pos',
            'label' => __('Sidebar position', 'traveler'),
            'desc' => __('Just apply for default search layout', 'traveler'),
            'type' => 'select',
            'section' => 'option_activity_tour',
            'condition' => 'tours_search_layout:is()',
            'choices' => array(
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

            ),
            'std' => 'left'
        ),
        array(
            'id' => 'is_featured_search_tour',
            'label' => __('Show featured tours on top of search result', 'traveler'),
            'desc' => __('ON: Show featured tours on top of result search page', 'traveler'),
            'type' => 'on-off',
            'std' => 'off',
            'section' => 'option_activity_tour'
        ),
        array(
            'id' => 'activity_tour_search_fields',
            'label' => __('Tour Search Fields', 'traveler'),
            'desc' => __('You can add, sort search fields for tour', 'traveler'),
            'type' => 'Slider',
            'section' => 'option_activity_tour',
            'settings' => array(

                array(
                    'id' => 'tours_field_search',
                    'label' => __('Field Type', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => STTour::get_search_fields_name(),
                ),
                array(
                    'id' => 'placeholder',
                    'label' => __('Placeholder', 'traveler'),
                    'desc' => __('Placeholder', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and',
                ),
                array(
                    'id' => 'layout_col',
                    'label' => __('Layout 1 size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                    'std' => 4
                ),
                array(
                    'id' => 'layout2_col',
                    'label' => __('Layout 2 Size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'std' => 4,
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                    'std' => 4
                ),
                array(
                    'id' => 'taxonomy',
                    'label' => __('Taxonomy', 'traveler'),
                    'condition' => 'tours_field_search:is(taxonomy)',
                    'operator' => 'and',
                    'type' => 'st_select_tax',
                    'post_type' => 'st_tours'
                ),
                array(
                    'id' => 'type_show_taxonomy_tours',
                    'label' => __('Type show', 'traveler'),
                    'condition' => 'tours_field_search:is(taxonomy)',
                    'operator' => 'or',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'checkbox',
                            'label' => __('Checkbox', 'traveler'),
                        ),
                        array(
                            'value' => 'select',
                            'label' => __('Select', 'traveler'),
                        ),
                    )
                ),
                array(
                    'id' => 'max_num',
                    'label' => __("Max number", 'traveler'),
                    'condition' => 'tours_field_search:is(list_name)',
                    'type' => "text",
                    'std' => 20
                ),
                array(
                    'id' => 'is_required',
                    'label' => __('Field required', 'traveler'),
                    'type' => 'on-off',
                    'operator' => 'and',
                    'std' => 'on',
                ),
            ),
            'std' => array(
                array('title' => __('Where', 'traveler'),
                    'layout_col' => 6,
                    'layout2_col' => 6,
                    'tours_field_search' => 'address',
                    'placeholder' => __("Location/ Zipcode", 'traveler')
                ),
                array('title' => __('Departure date', 'traveler'),
                    'layout_col' => 3,
                    'layout2_col' => 3,
                    'tours_field_search' => 'check_in'
                ),
                array('title' => __('Arrival Date', 'traveler'),
                    'layout_col' => 3,
                    'layout2_col' => 3,
                    'tours_field_search' => 'check_out'
                ),
            )
        ),
        array(
            'id' => "tour_allow_search_advance",
            'label' => __("Allowed Tour  Advanced Search", 'traveler'),
            'desc' => __("ON: Turn on thiis mode to add advanced search of tour", 'traveler'),
            'type' => 'on-off',
            'std' => "off",
            'section' => 'option_activity_tour'
        ),
        array(
            'id' => 'tour_advance_search_fields',
            'label' => __('Tour advanced search fields', 'traveler'),
            'desc' => __('You can add, sort advanced search fields of tour', 'traveler'),
            'condition' => 'tour_allow_search_advance:is(on)',
            'type' => 'Slider',
            'section' => 'option_activity_tour',
            'settings' => array(

                array(
                    'id' => 'tours_field_search',
                    'label' => __('Field Type', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => STTour::get_search_fields_name(),
                ),
                array(
                    'id' => 'placeholder',
                    'label' => __('Placeholder', 'traveler'),
                    'desc' => __('Placeholder', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and',
                ),
                array(
                    'id' => 'layout_col',
                    'label' => __('Layout 1 size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                    'std' => 4
                ),
                array(
                    'id' => 'layout2_col',
                    'label' => __('Layout 2 Size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'std' => 4,
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                    'std' => 4
                ),
                array(
                    'id' => 'taxonomy',
                    'label' => __('Taxonomy', 'traveler'),
                    'condition' => 'tours_field_search:is(taxonomy)',
                    'operator' => 'and',
                    'type' => 'st_select_tax',
                    'post_type' => 'st_tours'
                ),
                array(
                    'id' => 'type_show_taxonomy_tours',
                    'label' => __('Type show', 'traveler'),
                    'condition' => 'tours_field_search:is(taxonomy)',
                    'operator' => 'or',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'checkbox',
                            'label' => __('Checkbox', 'traveler'),
                        ),
                        array(
                            'value' => 'select',
                            'label' => __('Select', 'traveler'),
                        ),
                    )
                ),
                array(
                    'id' => 'max_num',
                    'label' => __("Max number", 'traveler'),
                    'condition' => 'tours_field_search:is(list_name)',
                    'type' => "text",
                    'std' => 20
                ),
                array(
                    'id' => 'is_required',
                    'label' => __('Field required', 'traveler'),
                    'type' => 'on-off',
                    'operator' => 'and',
                    'std' => 'on',
                ),
            ),
            'std' => array(
                array('title' => __('Tour Duration ', 'traveler'),
                    'layout_col' => 12,
                    'layout2_col' => 12,
                    'tours_field_search' => 'duration-dropdown'
                ),
                array('title' => __('Taxonomy', 'traveler'),
                    'layout_col' => 12,
                    'layout2_col' => 12,
                    'tours_field_search' => 'taxonomy',
                    'taxonomy' => 'st_tour_type'
                ),
            )
        ),
        array(
            'id' => 'st_show_number_user_book',
            'label' => __('Number of tour booked users', 'traveler'),
            'desc' => __('ON: Show number of users who booked tour on each item in search results page', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_activity_tour',
            'std' => 'off'
        ),
        array(
            'id' => 'tours_unlimited_custom_field',
            'label' => __('Tour custom fields', 'traveler'),
            'type' => 'Slider',
            'section' => 'option_activity_tour',
            'desc' => __('You can create custom fields for tour. Fields will be displayed in metabox of single tour', 'traveler'),
            'settings' => array(
                array(
                    'id' => 'type_field',
                    'label' => __('Field type', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => 'text',
                            'label' => __('Text field', 'traveler')
                        ),
                        array(
                            'value' => 'textarea',
                            'label' => __('Textarea field', 'traveler')
                        ),
                        array(
                            'value' => 'date-picker',
                            'label' => __('Date field', 'traveler')
                        ),
                    )

                ),
                array(
                    'id' => 'default_field',
                    'label' => __('Default', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and'
                ),

            ),
        ),
        array(
            'id' => 'st_tours_icon_map_marker',
            'label' => __('Map marker icon', 'traveler'),
            'desc' => __('Select map icon to show service on Map Google', 'traveler'),
            'type' => 'upload',
            'section' => 'option_activity_tour',
            'std' => 'http://maps.google.com/mapfiles/marker_purple.png'
        ),
        /*------------- Activity - Tour Option  -----------------*/

        /*------------- Activity Option  -----------------*/
        array(
            'id' => 'activity_show_calendar',
            'label' => __('Show calendar', 'traveler'),
            'desc' => __('ON: Show calendar<br/>OFF: Show small calendar in form of popup', 'traveler'),
            'type' => 'select',
            'choices' => array(
                array(
                    'label' => __('Big calendar show in content', 'traveler'),
                    'value' => 'on'
                ),
                array(
                    'label' => __('Show calendar as date picker', 'traveler'),
                    'value' => 'off'
                ),
            ),
            'section' => 'option_activity',
            'std' => 'on'

        ),
        array(
            'id' => 'activity_show_calendar_below',
            'label' => __('Calendar position', 'traveler'),
            'desc' => __('ON: Show calendar below book form<br/>OFF: Show calendar above book form', 'traveler'),
            'type' => 'select',
            'choices' => array(
                array(
                    'label' => __('Under check availability', 'traveler'),
                    'value' => 'off'
                ),
                array(
                    'label' => __('Below check availability', 'traveler'),
                    'value' => 'on'
                ),
            ),
            'section' => 'option_activity',
            'std' => 'off',
            'condition' => 'activity_show_calendar:is(on)',
        ),
        array(
            'id' => 'activity_search_result_page',
            'label' => __('Activity Search Result Page', 'traveler'),
            'label' => __('Select page to show search results for activity', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_activity',
        ),
        array(
            'id' => 'activity_review',
            'label' => __('Review options', 'traveler'),
            'desc' => __('ON: Turn on the mode for reviewing activity', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_activity',
            'std' => 'on'
        ),
        array(
            'id' => 'activity_review_stats',
            'label' => __('Review criteria', 'traveler'),
            'desc' => __('You can add, sort review criteria for activity', 'traveler'),
            'type' => 'list-item',
            'section' => 'option_activity',
            'condition' => 'activity_review:is(on)',
            'settings' => array(
                array(
                    'id' => 'name',
                    'label' => __('Stat Name', 'traveler'),
                    'type' => 'textblock',
                    'operator' => 'and',
                )
            ),
            'std' => array(

                array('title' => 'Sleep'),
                array('title' => 'Location'),
                array('title' => 'Service'),
                array('title' => 'Cleanliness'),
                array('title' => 'Room(s)'),
            )
        ),
        array(
            'id' => 'activity_layout',
            'label' => __('Activity Layout', 'traveler'),
            'label' => __('Select layout to show single activity', 'traveler'),
            'type' => 'st_select_layout',
            'post_type' => 'st_activity',
            'section' => 'option_activity',
        ),
        array(
            'id' => 'activity_search_layout',
            'label' => __('Activity Search Layout', 'traveler'),
            'desc' => __('Select layout to show search results for activity', 'traveler'),
            'type' => 'st_select_layout',
            'post_type' => 'st_activity_search',
            'section' => 'option_activity',
        ),
        array(
            'id' => 'activity_sidebar_pos',
            'label' => __('Sidebar Position', 'traveler'),
            'desc' => __('Just apply for default search layout', 'traveler'),
            'type' => 'select',
            'section' => 'option_activity',
            'condition' => 'activity_search_layout:is()',
            'choices' => array(
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

            ),
            'std' => 'left'
        ),
        array(
            'id' => 'is_featured_search_activity',
            'label' => __('Show featured activities on top of search result', 'traveler'),
            'desc' => __('ON: Show featured activities on top of result search page', 'traveler'),
            'type' => 'on-off',
            'std' => 'off',
            'section' => 'option_activity'
        ),
        array(
            'id' => 'activity_search_fields',
            'label' => __('Activity  Search Fields', 'traveler'),
            'desc' => __('You can add, sort search fields for activity', 'traveler'),
            'type' => 'Slider',
            'section' => 'option_activity',
            'settings' => array(

                array(
                    'id' => 'activity_field_search',
                    'label' => __('Field Type', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => class_exists('STActivity')?STActivity::get_search_fields_name():[]
                ),
                array(
                    'id' => 'placeholder',
                    'label' => __('Placeholder', 'traveler'),
                    'desc' => __('Placeholder', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and',
                ),
                array(
                    'id' => 'layout_col',
                    'label' => __('Layout 1 size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                    'std' => 4
                ),
                array(
                    'id' => 'layout2_col',
                    'label' => __('Layout 2 Size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                    'std' => 4
                ),
                array(
                    'id' => 'taxonomy',
                    'label' => __('Taxonomy', 'traveler'),
                    'condition' => 'activity_field_search:is(taxonomy)',
                    'operator' => 'and',
                    'type' => 'st_select_tax',
                    'post_type' => 'st_activity'
                ),
                array(
                    'id' => 'type_show_taxonomy_activity',
                    'label' => __('Type show', 'traveler'),
                    'condition' => 'activity_field_search:is(taxonomy)',
                    'operator' => 'or',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'checkbox',
                            'label' => __('Checkbox', 'traveler'),
                        ),
                        array(
                            'value' => 'select',
                            'label' => __('Select', 'traveler'),
                        ),
                    )
                ),
                array(
                    'id' => 'max_num',
                    'label' => __('Max number', 'traveler'),
                    'condition' => 'activity_field_search:is(list_name)',
                    'type' => 'text',
                    'operator' => 'and',
                    'std' => '20'
                ),
                array(
                    'id' => 'is_required',
                    'label' => __('Field required', 'traveler'),
                    'type' => 'on-off',
                    'operator' => 'and',
                    'std' => 'on',
                ),
            ),
            'std' => array(
                array('title' => 'Address',
                    'layout_col' => 3,
                    'layout2_col' => 6,
                    'activity_field_search' => 'address',
                    'placeholder' => __("Location/ Zipcode", 'traveler'),
                ),
                array('title' => 'From',
                    'layout_col' => 3,
                    'layout2_col' => 3,
                    'activity_field_search' => 'check_in'
                ),
                array('title' => 'To',
                    'layout_col' => 3,
                    'layout2_col' => 3,
                    'activity_field_search' => 'check_out'
                ),
            )
        ),
        array(
            'id' => 'allow_activity_advance_search',
            'label' => __('Allowed Activity  Advanced Search', 'traveler'),
            'desc' => __('ON: Turn on thiis mode to add advanced search of activities', 'traveler'),
            'type' => 'on-off',
            'std' => 'off',
            'section' => 'option_activity'
        ),
        array(
            'id' => 'activity_advance_search_fields',
            'label' => __('Activity Advanced Search Fields', 'traveler'),
            'desc' => __('You can add, sort advanced search fields of activity', 'traveler'),
            'condition' => 'allow_activity_advance_search:is(on)',
            'type' => 'Slider',
            'section' => 'option_activity',
            'settings' => array(

                array(
                    'id' => 'activity_field_search',
                    'label' => __('Field Type', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => class_exists('STActivity')?STActivity::get_search_fields_name():[]
                ),
                array(
                    'id' => 'placeholder',
                    'label' => __('Placeholder', 'traveler'),
                    'desc' => __('Placeholder', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and',
                ),
                array(
                    'id' => 'layout_col',
                    'label' => __('Layout 1 size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                    'std' => 4
                ),
                array(
                    'id' => 'layout2_col',
                    'label' => __('Layout 2 Size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'std' => 4,
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                    'std' => 4
                ),
                array(
                    'id' => 'taxonomy',
                    'label' => __('Taxonomy', 'traveler'),
                    'condition' => 'activity_field_search:is(taxonomy)',
                    'operator' => 'and',
                    'type' => 'st_select_tax',
                    'post_type' => 'st_activity'
                ),
                array(
                    'id' => 'type_show_taxonomy_activity',
                    'label' => __('Type show', 'traveler'),
                    'condition' => 'activity_field_search:is(taxonomy)',
                    'operator' => 'or',
                    'type' => 'select',
                    'choices' => array(
                        array(
                            'value' => 'checkbox',
                            'label' => __('Checkbox', 'traveler'),
                        ),
                        array(
                            'value' => 'select',
                            'label' => __('Select', 'traveler'),
                        ),
                    )
                ),
                array(
                    'id' => 'max_num',
                    'label' => __('Max number', 'traveler'),
                    'condition' => 'activity_field_search:is(list_name)',
                    'type' => 'text',
                    'operator' => 'and',
                    'std' => '20'
                ),
                array(
                    'id' => 'is_required',
                    'label' => __('Field required', 'traveler'),
                    'type' => 'on-off',
                    'operator' => 'and',
                    'std' => 'on',
                ),
            ),
            'std' => array(
                array('title' => __('Taxonomy', 'traveler'),
                    'layout_col' => 12,
                    'layout2_col' => 12,
                    'activity_field_search' => 'taxonomy',
                    'taxonomy' => 'attractions'
                ),
                array('title' => __('Price Filter', 'traveler'),
                    'layout_col' => 12,
                    'layout2_col' => 12,
                    'activity_field_search' => 'price_slider'
                ),
            )
        ),
        array(
            'id' => 'st_activity_unlimited_custom_field',
            'label' => __('Activity custom fields', 'traveler'),
            'type' => 'Slider',
            'section' => 'option_activity',
            'desc' => __('You can create custom fields for activity. Fields will be displayed in metabox of single activity', 'traveler'),
            'settings' => array(
                array(
                    'id' => 'type_field',
                    'label' => __('Field type', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => 'text',
                            'label' => __('Text field', 'traveler')
                        ),
                        array(
                            'value' => 'textarea',
                            'label' => __('Textarea field', 'traveler')
                        ),
                        array(
                            'value' => 'date-picker',
                            'label' => __('Date field', 'traveler')
                        ),
                    )

                ),
                array(
                    'id' => 'default_field',
                    'label' => __('Default', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and'
                ),
            ),
        ),
        array(
            'id' => 'st_activity_icon_map_marker',
            'label' => __('Map marker icon', 'traveler'),
            'desc' => __('Select map icon to show service on Map Google', 'traveler'),
            'type' => 'upload',
            'section' => 'option_activity',
            'std' => 'http://maps.google.com/mapfiles/marker_yellow.png'
        ),
        /*------------- Activity  Option  -----------------*/
        array(
            'id' => 'car_transfer_search_page',
            'label' => __('Select page to show search results for transfer', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_car_transfer',
        ),
        array(
            'id' => 'car_transfer_search_fields',
            'label' => __('Transfer Search Fields', 'traveler'),
            'desc' => __('You can add, sort search fields for transfer', 'traveler'),
            'type' => 'Slider',
            'section' => 'option_car_transfer',
            'settings' => array(
                array(
                    'id' => 'name',
                    'label' => __('Field Type', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => STCarTransfer::get_search_fields_name(),
                ),
                array(
                    'id' => 'placeholder',
                    'label' => __('Placeholder', 'traveler'),
                    'desc' => __('Placeholder', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and',
                ),
                array(
                    'id' => 'layout_col',
                    'label' => __('Layout 1 size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                    'std' => 4
                ),
                array(
                    'id' => 'layout2_col',
                    'label' => __('Layout 2 Size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'std' => 4,
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                    'std' => 4
                ),
                array(
                    'id' => 'is_required',
                    'label' => __('Field required', 'traveler'),
                    'type' => 'on-off',
                    'operator' => 'and',
                    'std' => 'on',
                ),
            ),
        ),
        /*----------- Hotel Alone Options--------------*/
        /*----------------Begin Header --------------------*/
        array(
            'id' => 'hotel_alone_general_setting',
            'label' => esc_html__('General Options','traveler' ),
            'type' => 'tab',
            'section' => 'option_hotel_alone' ,
        ),
        array(
            'id' => 'hotel_alone_logo',
            'label' => __('Logo options', 'traveler'),
            'desc' => __('To change logo', 'traveler'),
            'type' => 'upload',
            'section' => 'option_hotel_alone',
        ),
        array(
            'id' => 'st_hotel_alone_main_color',
            'label' => __('Main Color', 'traveler'),
            'desc' => __('To change the main color for web', 'traveler'),
            'type' => 'colorpicker',
            'section' => 'option_hotel_alone',
            'std' => '#ed8323',

        ),
        array(
            'id' => 'st_hotel_alone_footer_page',
            'label' => __('Select footer page', 'traveler'),
            'desc' => __('Select the page to display as footer', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_hotel_alone',
        ),
        array(
            'id' => 'st_hotel_alone_room_search_page',
            'label' => __('Select room search page', 'traveler'),
            'desc' => __('Select the page to display room result', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_hotel_alone',
        ),
        array(
            'id'          => 'st_hotel_alone_blog_list_style',
            'label'       => esc_html__( 'Blog style', 'traveler' ),
            'section'     => 'option_hotel_alone',
            'type' => 'select',
            'choices' => array(
                array(
                    'value' => 'list',
                    'label' => esc_html__('List', 'traveler'),
                ),
                array(
                    'value' => 'grid',
                    'label' => esc_html__('Grid', 'traveler'),
                ),
            )
        ),

        array(
            'id' => 'hotel_alone_topbar_setting',
            'label' => esc_html__('Topbar Options','traveler' ),
            'type' => 'tab',
            'section' => 'option_hotel_alone' ,
        ),
        array(
            'id' => 'st_hotel_alone_topbar_style',
            'label' => esc_html__('TopBar style', 'traveler'),
            'desc' => esc_html__('Choose a layout for your theme', 'traveler'),
            'type' => 'radio-image',
            'section' => 'option_hotel_alone',
            'std'=>'none',
            'choices' => array(
                array(
                    'value' => 'none',
                    'label' => esc_html__('No Topbar', 'traveler'),
                    'src'     => st_hotel_alone_load_assets_dir().'/images/topbar/no_topbar.jpg'
                ),
                array(
                    'value' => 'style_1',
                    'label' => esc_html__('Style 1', 'traveler'),
                    'src'     => st_hotel_alone_load_assets_dir().'/images/topbar/topbar1.jpg'
                ),
                array(
                    'value' => 'style_2',
                    'label' => esc_html__('Style 2', 'traveler'),
                    'src'     => st_hotel_alone_load_assets_dir().'/images/topbar/topbar2.jpg'
                ),
                array(
                    'value' => 'style_3',
                    'label' => esc_html__('Style 3', 'traveler'),
                    'src'     => st_hotel_alone_load_assets_dir().'/images/topbar/topbar3.jpg'
                ),
                array(
                    'value' => 'style_4',
                    'label' => esc_html__('Style 4', 'traveler'),
                    'src'     => st_hotel_alone_load_assets_dir().'/images/topbar/topbar4.jpg'
                ),
            )
        ),
        array(
            'id' => 'st_hotel_alone_topbar_background_transparent',
            'label' => esc_html__("Topbar Background Transparent", 'traveler'),
            'type' => 'on-off',
            'std'=>'off',
            'section' => 'option_hotel_alone'
        ),
        array(
            'id' => 'st_hotel_alone_topbar_background',
            'label' => esc_html__("Topbar Background", 'traveler'),
            'desc' => esc_html__("Topbar Background", 'traveler'),
            'type' => 'colorpicker_opacity',
            'section' => 'option_hotel_alone',
            'condition' => 'st_hotel_alone_topbar_background_transparent:is(off)',
            'operator' => 'or',
            'std'=>'#ffffff'
        ),
        array(
            'id' => 'st_hotel_alone_topbar_contact_number',
            'label' => esc_html__('Contact Number', 'traveler'),
            'type' => 'text',
            'section' => 'option_hotel_alone',
        ),
        array(
            'id' => 'st_hotel_alone_topbar_email_address',
            'label' => esc_html__('Email Address', 'traveler'),
            'type' => 'text',
            'section' => 'option_hotel_alone',
        ),
        array(
            'id'          => 'st_hotel_alone_topbar_location',
            'label'       => esc_html__( 'Location Select', 'traveler' ),
            'section'     => 'option_hotel_alone',
            'type' => 'st_post_type_select',
            'post_type' => 'location'
        ),

        //Search form topbar
        array(
            'id' => 'hotel_alone_form_search_setting',
            'label' => esc_html__('Form Search On Topbar Options','traveler' ),
            'type' => 'tab',
            'section' => 'option_hotel_alone' ,
        ),
        array(
            'id' => 'st_hotel_alone_topbar_title_search_form',
            'label' => esc_html__('Title Form Search', 'traveler'),
            'type' => 'text',
            'section' => 'option_hotel_alone',
        ),
        array(
            'id'       => 'st_hotel_alone_topbar_search_form' ,
            'label'    => esc_html__( 'Room search form' , 'traveler' ) ,
            'desc'     => esc_html__( 'Room search fields' , 'traveler' ) ,
            'type'     => 'list-item' ,
            'section'  => 'option_hotel_alone' ,
            'std' => array(
                array(
                    'title'       => esc_html__( 'Check in' , 'traveler' ) ,
                    'placeholder'       => esc_html__( 'Check in' , 'traveler' ) ,
                    'name'        => 'check_in' ,
                    'layout_size' => 6 ,
                ) ,
                array(
                    'title'       => esc_html__( 'Check out' , 'traveler' ) ,
                    'placeholder'       => esc_html__( 'Check out' , 'traveler' ) ,
                    'name'        => 'check_out' ,
                    'layout_size' => 6 ,
                ) ,
                array(
                    'title'       => esc_html__( 'Room' , 'traveler' ) ,
                    'name'        => 'room_number' ,
                    'layout_size' => 6 ,
                ) ,
                array(
                    'title'       => esc_html__( 'Adult' , 'traveler' ) ,
                    'name'        => 'adults' ,
                    'layout_size' => 6 ,
                )
            ) ,
            'settings' => array(
                array(
                    'id'       => 'name' ,
                    'label'    => esc_html__( 'Field Type' , 'traveler' ) ,
                    'type'     => 'select' ,
                    'operator' => 'and' ,
                    'choices'  => st_hotel_alone_option_tree_convert_array(st_hotel_alone_get_search_fields_for_element())
                ) ,
                array(
                    'id'       => 'placeholder' ,
                    'label'    => esc_html__( 'Placeholder' , 'traveler' ) ,
                    'desc'     => esc_html__( 'Placeholder' , 'traveler' ) ,
                    'type'     => 'text' ,
                    'operator' => 'and' ,
                ) ,
                array(
                    'id'       => 'layout_size' ,
                    'label'    => esc_html__( 'Layout Normal Size' , 'traveler' ) ,
                    'type'     => 'select' ,
                    'operator' => 'and' ,
                    'std'      => 6 ,
                    'choices'  => array(
                        array(
                            'value' => '1' ,
                            'label' => esc_html__( 'column 1' , 'traveler' )
                        ) ,
                        array(
                            'value' => '2' ,
                            'label' => esc_html__( 'column 2' , 'traveler' )
                        ) ,
                        array(
                            'value' => '3' ,
                            'label' => esc_html__( 'column 3' , 'traveler' )
                        ) ,
                        array(
                            'value' => '4' ,
                            'label' => esc_html__( 'column 4' , 'traveler' )
                        ) ,
                        array(
                            'value' => '5' ,
                            'label' => esc_html__( 'column 5' , 'traveler' )
                        ) ,
                        array(
                            'value' => '6' ,
                            'label' => esc_html__( 'column 6' , 'traveler' )
                        ) ,
                        array(
                            'value' => '7' ,
                            'label' => esc_html__( 'column 7' , 'traveler' )
                        ) ,
                        array(
                            'value' => '8' ,
                            'label' => esc_html__( 'column 8' , 'traveler' )
                        ) ,
                        array(
                            'value' => '9' ,
                            'label' => esc_html__( 'column 9' , 'traveler' )
                        ) ,
                        array(
                            'value' => '10' ,
                            'label' => esc_html__( 'column 10' , 'traveler' )
                        ) ,
                        array(
                            'value' => '11' ,
                            'label' => esc_html__( 'column 11' , 'traveler' )
                        ) ,
                        array(
                            'value' => '12' ,
                            'label' => esc_html__( 'column 12' , 'traveler' )
                        ) ,
                    ) ,
                ) ,

            )
        ) ,
        array(
            'id' => 'st_hotel_alone_topbar_desc_search_form',
            'label' => esc_html__('Description', 'traveler'),
            'type' => 'text',
            'section' => 'option_hotel_alone',
        ),
        //----------------------------------------------------------------------------------------------------

        array(
            'id' => 'hotel_alone_menu_setting',
            'label' => esc_html__('Menu Options','traveler' ),
            'type' => 'tab',
            'section' => 'option_hotel_alone' ,
        ),
        array(
            'id'          => 'st_hotel_alone_menu_location',
            'label'       => esc_html__( 'Menu Select', 'traveler' ),
            'section'     => 'option_hotel_alone',
            'type' => 'st_post_type_select',
            'post_type' => 'nav_menu'
        ),
        array(
            'id' => 'st_hotel_alone_menu_style',
            'label' => esc_html__('Menu style', 'traveler'),
            'desc' => esc_html__('Choose a layout for your theme', 'traveler'),
            'type' => 'radio-image',
            'section' => 'option_hotel_alone',
            'choices' => array(
                array(
                    'value' => 'none',
                    'label' => esc_html__('None', 'traveler'),
                    'src'     => st_hotel_alone_load_assets_dir().'/images/menu/menu_none.jpg'
                ),
                array(
                    'value' => 'style_1',
                    'label' => esc_html__('Style 1', 'traveler'),
                    'src'     => st_hotel_alone_load_assets_dir().'/images/menu/menu1.jpg'
                ),
                array(
                    'value' => 'style_2',
                    'label' => esc_html__('Style 2', 'traveler'),
                    'src'     => st_hotel_alone_load_assets_dir().'/images/menu/menu2.jpg'
                ),
                array(
                    'value' => 'style_3',
                    'label' => esc_html__('Style 3', 'traveler'),
                    'src'     => st_hotel_alone_load_assets_dir().'/images/menu/menu3.jpg'
                ),
            ),
            'std' => 'style_2'
        ),

        array(
            'id' => 'st_hotel_alone_left_menu',
            'label' => esc_html__('Left Menu', 'traveler'),
            'section' => 'option_hotel_alone',
            'condition' => 'st_hotel_alone_menu_style:is(style_1)',
            'type' => 'st_post_type_select',
            'post_type' => 'nav_menu'
        ),
        array(
            'id' => 'st_hotel_alone_right_menu',
            'label' => esc_html__('Right Menu', 'traveler'),
            'section' => 'option_hotel_alone',
            'condition' => 'st_hotel_alone_menu_style:is(style_1)',
            'type' => 'st_post_type_select',
            'post_type' => 'nav_menu'
        ),
        array(
            'id' => 'st_hotel_alone_menu_color',
            'label' => esc_html__('Menu color', 'traveler'),
            'type' => 'colorpicker',
            'section' => 'option_hotel_alone',
            'std' => '#fff',
        ),
        array(
            'id' => 'st_hotel_alone_fixed_menu',
            'label' => esc_html__('Sticky Menu', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_hotel_alone',
            'std' => 'off',
        ),
        /*----------- End Hotel Alone Options--------------*/

        /*------------- Option Partner Option --------------------*/
        array(
            'id' => 'partner_general_tab',
            'label' => __("General Options", 'traveler'),
            'type' => 'tab',
            'section' => 'option_partner',
        ),
        array(
            'id' => 'enable_automatic_approval_partner',
            'label' => __('Automatic approval', 'traveler'),
            'desc' => __('Partner be automatic approval (register account).', 'traveler'),
            'type' => 'on-off',
            'std' => 'off',
            'section' => 'option_partner'
        ),
        array(
            'id' => 'enable_pretty_link_partner',
            'label' => __('Allowed custom sort link for partner page', 'traveler'),
            'desc' => __('ON: show link of partner page in form of pretty link', 'traveler'),
            'type' => 'on-off',
            'std' => 'off',
            'section' => 'option_partner'
        ),
        array(
            'id' => 'slug_partner_page',
            'label' => __('Slug of the partner page', 'traveler'),
            'type' => 'text',
            'std' => 'page-user-setting',
            'desc' => __('Enter slug name of partner page to show pretty link', 'traveler'),
            'condition' => 'enable_pretty_link_partner:is(on)',
            'section' => 'option_partner'
        ),
        array(
            'id' => 'partner_show_contact_info',
            'label' => __('Show email contact info', 'traveler'),
            'desc' => __('ON: Show email of author(who posts service) in single, email page<br/>OFF: Show email entered in metabox of service', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_partner',
            'std' => 'off',
        ),
        array(
            'id' => 'partner_enable_feature',
            'label' => __('Enable Partner Feature', 'traveler'),
            'desc' => __('ON: Show services for partner.<br/>OFF: Turn off services, partner is not allowed to register service, it is not displayed in dashboard', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_partner',
            'std' => 'off',
        ),
        array(
            'id' => 'partner_post_by_admin',
            'label' => __('Partner\'s post must be approved by admin', 'traveler'),
            'desc' => __('ON: When partner posts a service, it needs to be approved by administrator ', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_partner',
            'std' => 'on'
        ),
        array(
            'id' => 'admin_menu_partner',
            'label' => __('Partner menubar', 'traveler'),
            'desc' => __('ON: Turn on partner menubar <br/>OFF: Turn off partner menubar', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_partner',
            'std' => 'off'
        ),

        array(
            'id' => 'partner_commission',
            'label' => __('Commission(%)', 'traveler'),
            'desc' => __('Enter commission of partner for admin after each item is booked ', 'traveler'),
            'type' => 'numeric-slider',
            'section' => 'option_partner',
            'min_max_step' => '0,100,1',
        ),
        /*array(
            'id'      => 'partner_commission_required' ,
            'label'   => __( 'Commission Required' , 'traveler' ) ,
            'desc'   => __( 'The payment amount must be greater than the commission' , 'traveler' ) ,
            'type'    => 'on-off' ,
            'section' => 'option_partner' ,
            'std'     => 'off'
        ) ,*/
        array(
            'id' => 'partner_set_feature',
            'label' => __('Partner can set featured', 'traveler'),
            'section' => 'option_partner',
            'type' => 'on-off',
            'desc' => __('It allows partner to set an item to be featured', 'traveler'),
            'std' => 'off'
        ),
        array(
            'id' => 'partner_set_external_link',
            'label' => __('Partner can set external link for services', 'traveler'),
            'section' => 'option_partner',
            'type' => 'on-off',
            'desc' => __('It allows partner to set external link for services', 'traveler'),
            'std' => 'off'
        ),
        //1.3.0
        array(
            'id' => 'avatar_in_list_service',
            'label' => __('Show avatar user in list services', 'traveler'),
            'section' => 'option_partner',
            'type' => 'on-off',
            'std' => 'off'
        ),
        array(
            'id' => 'membership_tab',
            'label' => __('Membership', 'traveler'),
            'section' => 'option_partner',
            'type' => 'tab'
        ),
        array(
            'id' => 'enable_membership',
            'label' => __('Enable Membership', 'traveler'),
            'type' => 'on_off',
            'std' => 'on',
            'section' => 'option_partner',
        ),
        array(
            'id' => 'member_packages_page',
            'label' => __('Member Packages Page', 'traveler'),
            'type' => 'page-select',
            'desc' => __('Select a page for member packages page', 'traveler'),
            'section' => 'option_partner'
        ),
        array(
            'id' => 'member_checkout_page',
            'label' => __('Member Checkout Page', 'traveler'),
            'type' => 'page-select',
            'desc' => __('Select a checkout page for member packages', 'traveler'),
            'section' => 'option_partner'
        ),
        array(
            'id' => 'member_success_page',
            'label' => __('Member Checkout Success Page', 'traveler'),
            'type' => 'page-select',
            'desc' => __('Select a checkout success page for member packages', 'traveler'),
            'section' => 'option_partner'
        ),
        array(
            'id' => 'partner_custom_layout_tab',
            'label' => __("Layout Dashboard", 'traveler'),
            'type' => 'tab',
            'section' => 'option_partner',
        ),
        array(
            'id' => 'partner_custom_layout',
            'label' => __('Configuration partner profile info', 'traveler'),
            'desc' => __('Show/hide sections for partner dashboard', 'traveler'),
            'section' => 'option_partner',
            'type' => 'on-off',
            'std' => 'off'
        ),
        array(
            'id' => 'partner_custom_layout_total_earning',
            'label' => __('Show total earning', 'traveler'),
            'type' => 'on-off',
            'desc' => __('ON: Display earnings information in accordance with time periods', 'traveler'),
            'std' => "on",
            'condition' => 'partner_custom_layout:is(on)',
            'section' => 'option_partner'
        ),
        array(
            'id' => 'partner_custom_layout_service_earning',
            'label' => __('Show each service earning', 'traveler'),
            'type' => 'on-off',
            'desc' => __('ON: Display earnings according to each service', 'traveler'),
            'std' => "on",
            'condition' => 'partner_custom_layout:is(on)',
            'section' => 'option_partner'
        ),
        array(
            'id' => 'partner_custom_layout_chart_info',
            'label' => __('Show chart info', 'traveler'),
            'type' => 'on-off',
            'desc' => __('ON: Display visual graphs to follow your earnings through each time', 'traveler'),
            'std' => "on",
            'condition' => 'partner_custom_layout:is(on)',
            'section' => 'option_partner'
        ),
        array(
            'id' => 'partner_custom_layout_booking_history',
            'label' => __('Show booking history', 'traveler'),
            'type' => 'on-off',
            'desc' => __('ON: Show book ing history of partner', 'traveler'),
            'std' => "on",
            'condition' => 'partner_custom_layout:is(on)',
            'section' => 'option_partner'
        ),
        array(
            'id' => 'partner_withdrawal_options',
            'label' => __("Withdrawal Options", 'traveler'),
            'type' => 'tab',
            'section' => 'option_partner',
        ),
        array(
            'id' => 'enable_withdrawal',
            'label' => __('Allow request withdrawal', 'traveler'),
            'desc' => __('ON: Partner is allowed to withdraw money', 'traveler'),
            'type' => 'on-off',
            'std' => 'on',
            'section' => 'option_partner'
        ),
        array(
            'id' => 'partner_withdrawal_payout_price_min',
            'label' => __('Minimum value request when withdrawal', 'traveler'),
            'type' => 'text',
            'section' => 'option_partner',
            'desc' => __('Enter minimum value when a withdrawal is conducted', 'traveler'),
            'std' => '100'
        ),
        array(
            'id' => 'partner_date_payout_this_month',
            'label' => __('Date of sucessful payment in current month', 'traveler'),
            'type' => 'text',
            'section' => 'option_partner',
            'desc' => __('Enter the date monthly payment. Ex: 25', 'traveler'),
            'std' => '25'
        ),
        array(
            'id' => 'partner_inbox_options',
            'label' => __("Inbox Options", 'traveler'),
            'type' => 'tab',
            'section' => 'option_partner',
        ),
        array(
            'id' => 'enable_inbox',
            'label' => __('Allow request inbox', 'traveler'),
            'desc' => __('ON: Partner is allowed to inbox', 'traveler'),
            'type' => 'on-off',
            'std' => 'off',
            'section' => 'option_partner'
        ),

        array(
            'id' => 'enable_send_email_partner',
            'label' => __('Allow send to partner', 'traveler'),
            'desc' => __('It allows partner to receive email when there is a new message', 'traveler'),
            'type' => 'on-off',
            'std' => 'on',
            'section' => 'option_partner'
        ),

        array(
            'id' => 'enable_send_email_buyer',
            'label' => __('Allow send to buyer', 'traveler'),
            'desc' => __('It allows users to receive email when there is a new message', 'traveler'),
            'type' => 'on-off',
            'std' => 'on',
            'section' => 'option_partner'
        ),


        /*------------- End Option Partner Option --------------------*/
        /*------------- Email Partner Template --------------------*/
        array(
            'id' => 'tab_partner_email_for_admin',
            'label' => __('[Register] Email For Admin', 'traveler'),
            'type' => 'tab',
            'section' => 'option_email_partner',
        ),
        array(
            'id' => 'partner_email_for_admin',
            'label' => __('[Register] Email to administrator', 'traveler'),
            'type' => 'textarea',
            'rows' => '10',
            'section' => 'option_email_partner',
            'std' => function_exists('st_default_email_template_for_admin_partner') ? st_default_email_template_for_admin_partner() : false
        ),
        array(
            'id' => 'partner_resend_email_for_admin',
            'label' => __('[Register] Resend email to administrator', 'traveler'),
            'type' => 'textarea',
            'rows' => '10',
            'section' => 'option_email_partner',
            'std' => function_exists('st_default_email_template_for_resend_admin_partner') ? st_default_email_template_for_resend_admin_partner() : false
        ),
        array(
            'id' => 'user_register_email_for_admin',
            'label' => __('[Register normal user] Email to administrator', 'traveler'),
            'type' => 'textarea',
            'rows' => '10',
            'section' => 'option_email_partner',
            'std' => function_exists('st_default_email_register_user_normal_template_for_admin') ? st_default_email_register_user_normal_template_for_admin() : false
        ),
        array(
            'id' => 'tab_partner_email_for_customer',
            'label' => __('[Register] Email Partner', 'traveler'),
            'type' => 'tab',
            'section' => 'option_email_partner',
        ),
        array(
            'id' => 'partner_email_for_customer',
            'label' => __('[Register] Email to partner (when waiting for approved register)', 'traveler'),
            'type' => 'textarea',
            'rows' => '10',
            'section' => 'option_email_partner',
            'std' => function_exists('st_default_email_template_for_customer_partner') ? st_default_email_template_for_customer_partner() : false
        ),
        array(
            'id' => 'partner_email_approved',
            'label' => __('[Register] Email to partner (when approved register)', 'traveler'),
            'type' => 'textarea',
            'rows' => '10',
            'section' => 'option_email_partner',
            'std' => function_exists('st_default_email_template_for_customer_approved_partner') ? st_default_email_template_for_customer_approved_partner() : false
        ),
        array(
            'id' => 'partner_email_cancel',
            'label' => __('[Register] Email for cancellation', 'traveler'),
            'type' => 'textarea',
            'rows' => '10',
            'section' => 'option_email_partner',
            'std' => function_exists('st_default_email_template_for_customer_cancel_partner') ? st_default_email_template_for_customer_cancel_partner() : false
        ),
        array(
            'id' => 'tab_withdrawal_email_for_admin',
            'label' => __('[Withdrawal] Email For Admin', 'traveler'),
            'type' => 'tab',
            'section' => 'option_email_partner',
        ),
        array(
            'id' => 'send_admin_new_request_withdrawal',
            'label' => __('[Request] Email to administrator', 'traveler'),
            'type' => 'textarea',
            'rows' => '10',
            'section' => 'option_email_partner',
            'std' => function_exists('st_default_admin_new_request_withdrawal') ? st_default_admin_new_request_withdrawal() : false
        ),
        array(
            'id' => 'send_admin_approved_withdrawal',
            'label' => __('[Approved] Email to administrator', 'traveler'),
            'type' => 'textarea',
            'rows' => '10',
            'section' => 'option_email_partner',
            'std' => function_exists('st_default_send_admin_approved_withdrawal') ? st_default_send_admin_approved_withdrawal() : false
        ),
        array(
            'id' => 'tab_withdrawal_email_for_customer',
            'label' => __('[Withdrawal] Email Partner', 'traveler'),
            'type' => 'tab',
            'section' => 'option_email_partner',
        ),
        array(
            'id' => 'send_user_new_request_withdrawal',
            'label' => __('[Request] Email to user', 'traveler'),
            'type' => 'textarea',
            'rows' => '10',
            'section' => 'option_email_partner',
            'std' => function_exists('st_default_send_user_new_request_withdrawal') ? st_default_send_user_new_request_withdrawal() : false

        ),
        array(
            'id' => 'send_user_approved_withdrawal',
            'label' => __('[Approved] Email to user', 'traveler'),
            'type' => 'textarea',
            'rows' => '10',
            'section' => 'option_email_partner',
            'std' => function_exists('st_default_send_user_approved_withdrawal') ? st_default_send_user_approved_withdrawal() : false
        ),
        array(
            'id' => 'send_user_cancel_withdrawal',
            'label' => __('[Cancel] Email to partner', 'traveler'),
            'type' => 'textarea',
            'rows' => '10',
            'section' => 'option_email_partner',
            'std' => function_exists('st_default_send_user_cancel_withdrawal') ? st_default_send_user_cancel_withdrawal() : false
        ),
        array(
            'id' => 'member_packages_tab',
            'label' => __('[Membership] Email For Admin', 'traveler'),
            'type' => 'tab',
            'section' => 'option_email_partner',
        ),
        array(
            'id' => 'membership_email_admin',
            'label' => __('Email for admin when have a new membership', 'traveler'),
            'type' => 'textarea',
            'section' => 'option_email_partner',
            'std' => function_exists('st_email_member_packages_admin') ? st_email_member_packages_admin() : false
        ),
        array(
            'id' => 'membership_email_partner',
            'label' => __('Email for partner when have a new member.', 'traveler'),
            'type' => 'textarea',
            'section' => 'option_email_partner',
            'std' => function_exists('st_email_member_packages_partner') ? st_email_member_packages_partner() : false
        ),
        /*------------- End Email Partner Template --------------------*/

        /*------------- Search Option -----------------*/
        array(
            'id' => 'search_results_view',
            'label' => __('Select default search result layout', 'traveler'),
            'type' => 'select',
            'section' => 'option_search',
            'desc' => __('List view or Grid view', 'traveler'),
            'choices' => array(
                array(
                    'value' => 'list',
                    'label' => __('List view', 'traveler')
                ),
                array(
                    'value' => 'grid',
                    'label' => __('Grid view', 'traveler')
                ),
            )
        ),
        array(
            'id' => 'search_tabs',
            'label' => __('Display searching tabs', 'traveler'),
            'desc' => __('Search Tabs on home page', 'traveler'),
            'type' => 'list-item',
            'section' => 'option_search',
            'settings' => array(
                array(
                    'id' => 'check_tab',
                    'label' => __('Show tab', 'traveler'),
                    'type' => 'on-off',
                ),
                array(
                    'id' => 'tab_icon',
                    'label' => __('Icon', 'traveler'),
                    'type' => 'text',
                    'desc' => __('This allows you to change icon next to the title', 'traveler')
                ),
                array(
                    'id' => 'tab_search_title',
                    'label' => __('Form Title', 'traveler'),
                    'type' => 'text',
                    'desc' => __('This allows you to change the text above the form', 'traveler')
                ),
	            array(
		            'id' => 'tab_name',
		            'label' => __('Choose Tab', 'traveler'),
		            'type' => 'select',
		            'choices' => array(
			            array(
				            'value' => 'hotel',
				            'label' => __('Hotel', 'traveler')
			            ),
			            array(
				            'value' => 'rental',
				            'label' => __('Rental', 'traveler')
			            ),
			            array(
				            'value' => 'tour',
				            'label' => __('Tour', 'traveler')
			            ),
			            array(
				            'value' => 'cars',
				            'label' => __('Car', 'traveler')
			            ),
			            array(
				            'value' => 'activities',
				            'label' => __('Activities', 'traveler')
			            ),
			            array(
				            'value' => 'hotel_room',
				            'label' => __('Room', 'traveler')
			            ),
			            array(
				            'value' => 'flight',
				            'label' => __('Flight', 'traveler')
			            ),
			            array(
				            'value' => 'all_post_type',
				            'label' => __('All Post Type', 'traveler')
			            ),
			            array(
				            'value' => 'tp_flight',
				            'label' => esc_html__('TravelPayouts Flight', 'traveler')
			            ),
			            array(
				            'value' => 'tp_hotel',
				            'label' => esc_html__('TravelPayout Hotel', 'traveler')
			            ),
			            array(
				            'value' => 'car_transfer',
				            'label' => esc_html__('Car Transfer', 'traveler')
			            ),
			            array(
				            'value' => 'bookingdc',
				            'label' => esc_html__('Booking.com', 'traveler')
			            ),
			            array(
				            'value' => 'expedia',
				            'label' => esc_html__('Expedia', 'traveler')
			            ),
		            )
	            ),
                array(
                    'id' => 'tab_html_custom',
                    'label' => __('Use HTML bellow', 'traveler'),
                    'type' => 'textarea',
                    'desc' => __('This allows you to do short code or HTML', 'traveler')
                ),
            ),
            'std' => array(
                array(
                    'title' => 'Hotel',
                    'check_tab' => 'on',
                    'tab_icon' => 'fa-building-o',
                    'tab_search_title' => 'Search and Save on Hotels',
                    'tab_name' => 'hotel'
                ),
                array(
                    'title' => 'Cars',
                    'check_tab' => 'on',
                    'tab_icon' => 'fa-car',
                    'tab_search_title' => 'Search for Cheap Rental Cars',
                    'tab_name' => 'cars'
                ),
                array(
                    'title' => 'Tours',
                    'check_tab' => 'on',
                    'tab_icon' => 'fa-flag-o',
                    'tab_search_title' => 'Tours',
                    'tab_name' => 'tour'
                ),
                array(
                    'title' => 'Rentals',
                    'check_tab' => 'on',
                    'tab_icon' => 'fa-home',
                    'tab_search_title' => 'Find Your Perfect Home',
                    'tab_name' => 'rental'
                ),
                array(
                    'title' => 'Activity',
                    'check_tab' => 'on',
                    'tab_icon' => 'fa-bolt',
                    'tab_search_title' => 'Find Your Perfect Activity',
                    'tab_name' => 'activities'
                ),
            )
        ),
        array(
            'id' => 'all_post_type_search_result_page',
            'label' => __('Select page display search results for all services', 'traveler'),
            'type' => 'page-select',
            'section' => 'option_search',
        ),
        array(
            'id' => 'all_post_type_search_fields',
            'label' => __('Custom search form for all services', 'traveler'),
            'desc' => __('Custom search form for all services', 'traveler'),
            'type' => 'Slider',
            'section' => 'option_search',
            'settings' => array(
                array(
                    'id' => 'field_search',
                    'label' => __('Field Type', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => 'address',
                            'label' => __('Address', 'traveler')
                        ),
                        array(
                            'value' => 'item_name',
                            'label' => __('Name', 'traveler')
                        ),
                        array(
                            'value' => 'post_type',
                            'label' => __('Post Type', 'traveler')
                        ),
                    )
                ),
                array(
                    'id' => 'placeholder',
                    'label' => __('Placeholder', 'traveler'),
                    'desc' => __('Placeholder', 'traveler'),
                    'type' => 'text',
                    'operator' => 'and',
                ),
                array(
                    'id' => 'layout_col',
                    'label' => __('Layout 1 size', 'traveler'),
                    'type' => 'select',
                    'operator' => 'and',
                    'choices' => array(
                        array(
                            'value' => '1',
                            'label' => __('column 1', 'traveler')
                        ),
                        array(
                            'value' => '2',
                            'label' => __('column 2', 'traveler')
                        ),
                        array(
                            'value' => '3',
                            'label' => __('column 3', 'traveler')
                        ),
                        array(
                            'value' => '4',
                            'label' => __('column 4', 'traveler')
                        ),
                        array(
                            'value' => '5',
                            'label' => __('column 5', 'traveler')
                        ),
                        array(
                            'value' => '6',
                            'label' => __('column 6', 'traveler')
                        ),
                        array(
                            'value' => '7',
                            'label' => __('column 7', 'traveler')
                        ),
                        array(
                            'value' => '8',
                            'label' => __('column 8', 'traveler')
                        ),
                        array(
                            'value' => '9',
                            'label' => __('column 9', 'traveler')
                        ),
                        array(
                            'value' => '10',
                            'label' => __('column 10', 'traveler')
                        ),
                        array(
                            'value' => '11',
                            'label' => __('column 11', 'traveler')
                        ),
                        array(
                            'value' => '12',
                            'label' => __('column 12', 'traveler')
                        ),
                    ),
                    'std' => 4
                ),
                array(
                    'id' => 'is_required',
                    'label' => __('Field required', 'traveler'),
                    'type' => 'on-off',
                    'operator' => 'and',
                    'std' => 'on',
                ),
            ),
            'std' => array(
                array('title' => 'Address',
                    'layout_col' => 12,
                    'field_search' => 'address'
                ),
            )
        ),
        array(
            'id' => 'search_header_onoff',
            'label' => __('Allow header search', 'traveler'),
            'desc' => __('Allow header search', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_search',
            'std' => 'on'
        ),
        array(
            'id' => 'search_header_orderby',
            'label' => __('Header search - Order by', 'traveler'),
            'type' => 'select',
            'section' => 'option_search',
            'desc' => __('Header search - Order by', 'traveler'),
            'condition' => 'search_header_onoff:is(on)',
            'choices' => array(
                array(
                    'value' => 'none',
                    'label' => __('None', 'traveler')
                ),
                array(
                    'value' => 'ID',
                    'label' => __('ID', 'traveler')
                ),
                array(
                    'value' => 'author',
                    'label' => __('Author', 'traveler')
                ),
                array(
                    'value' => 'title',
                    'label' => __('Title', 'traveler')
                ),
                array(
                    'value' => 'name',
                    'label' => __('Name', 'traveler')
                ),
                array(
                    'value' => 'date',
                    'label' => __('Date', 'traveler')
                ),
                array(
                    'value' => 'rand',
                    'label' => __('Random', 'traveler')
                ),
            ),
        ),
        array(
            'id' => 'search_header_order',
            'label' => __('Header search - order', 'traveler'),
            'type' => 'select',
            'section' => 'option_search',
            'desc' => __('Header search - order', 'traveler'),
            'condition' => 'search_header_onoff:is(on)',
            'choices' => array(
                array(
                    'value' => 'ASC',
                    'label' => __('ASC', 'traveler')
                ),
                array(
                    'value' => 'DESC',
                    'label' => __('DESC', 'traveler')
                ),
            ),
        ),
        array(
            'id' => 'search_header_list',
            'label' => __('Header search - Search by', 'traveler'),
            'type' => 'st_checkbox_posttype',
            'section' => 'option_search',
            'desc' => __('Header search - Search by', 'traveler'),
            'condition' => 'search_header_onoff:is(on)',
        ),
        /*------------- End User Option  --------------------*/

        /*------------- Begin Social Option  --------------------*/
        defined('WORDPRESS_SOCIAL_LOGIN_PLUGIN_URL') ? array(
            'id' => 'social_fb_login',
            'label' => __('Facebook Login', 'traveler'),
            'type' => 'on-off',
            'std' => 'on',
            'section' => 'option_social'
        ) : array('id' => 'social_fb_login_tmp', 'type' => '', 'section' => '', 'label' => '')
    ,
        defined('WORDPRESS_SOCIAL_LOGIN_PLUGIN_URL') ? array(
            'id' => 'social_gg_login',
            'label' => __('Google Login', 'traveler'),
            'type' => 'on-off',
            'std' => 'on',
            'section' => 'option_social'
        ) : array('id' => 'social_fb_login_tmp', 'type' => '', 'section' => '', 'label' => '')
    ,
        defined('WORDPRESS_SOCIAL_LOGIN_PLUGIN_URL') ? array(
            'id' => 'social_tw_login',
            'label' => __('Twitter Login', 'traveler'),
            'type' => 'on-off',
            'std' => 'on',
            'section' => 'option_social'
        ) : array(
            'id' => 'st_check_login_social',
            'type' => 'text',
            'section' => 'option_social',
            'label' => esc_html__('Please Active WordPress Social Login Plugin', 'traveler'),
            'class' => 'st_hidden_input_field'
        ),
        array(
            'id' => 'sp_disable_javascript',
            'label' => __('Support Disable javascript', 'traveler'),
            'desc' => __('This allows css friendly with browsers what disable javascript', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_bc',
            'std' => 'off'
        ),
        array(
            'id' => 'google_api_key',
            'label' => __('Google API key', 'traveler'),
            'desc' => __('Input your Google API key ', 'traveler') . "<a target='_blank' href='https://developers.google.com/maps/documentation/javascript/get-api-key'>How to get it?</a>",
            'type' => 'text',
            'section' => 'option_bc',
            'std' => 'AIzaSyA1l5FlclOzqDpkx5jSH5WBcC0XFkqmYOY'
        ),
        array(
            'id' => 'google_font_api_key',
            'label' => __('Google Fonts API key', 'traveler'),
            'desc' => __('Input your Google Fonts API key ', 'traveler') . "<a target='_blank' href='https://developers.google.com/fonts/docs/developer_api'>How to get it?</a>",
            'type' => 'text',
            'section' => 'option_bc',
            //'std' => 'AIzaSyCpAufmacc0zw76gZDkpNsEFldyRyr1J_o'
        ),
        array(
            'id' => 'weather_api_key',
            'label' => __('Weather API key', 'traveler'),
            'desc' => __('Input your Weather API key ', 'traveler') . "<a target='_blank' href='https://home.openweathermap.org/api_keys'>openweathermap.org</a>",
            'type' => 'text',
            'section' => 'option_bc',
            'std' => 'a82498aa9918914fa4ac5ba584a7e623'
        ),

        array(
            'id' => 'tab_general_document',
            'label' => __(' General Configure', 'traveler'),
            'type' => 'tab',
            'section' => 'option_api_update',
        ),
        array(
            'id' => 'booking_room_by',
            'label' => __('Booking immediately in search result page', 'traveler'),
            'desc' => __('Booking immediately in search result page without go to single page', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_api_update',
            'std' => 'on',
        ),
        array(
            'id' => 'st_api_external_booking',
            'section' => 'option_api_update',
            'label' => __('External Booking', 'traveler'),
            'desc' => __('External Booking', 'traveler'),
            'type' => 'on-off',
            'std' => 'off',
            'condition' => ""
        ),
        array(
            'id' => 'show_only_room_by',
            'label' => __('Show Only Room By', 'traveler'),
            'type' => 'checkbox',
            'section' => 'option_api_update',
            'choices' => array(
                array(
                    'label' => __('All', 'traveler'),
                    'value' => 'all'
                ),
                array(
                    'label' => __('Roomorama', 'traveler'),
                    'value' => 'st_roomorama'
                ),
            ),
            'std' => 'all',
        ),
        array(
            'id' => 'tab_eroomorama_document',
            'label' => __(' Roomorama.com', 'traveler'),
            'type' => 'tab',
            'section' => 'option_api_update',
        ),
        array(
            'id' => 'st_client_identifier',
            'section' => 'option_api_update',
            'label' => __('Client Identifier', 'traveler'),
            'desc' => __('Client Identifier', 'traveler'),
            'type' => 'text',
            'std' => '',
            'condition' => ""
        ),
        array(
            'id' => 'st_client_secret',
            'section' => 'option_api_update',
            'label' => __('Client secret', 'traveler'),
            'desc' => __('Client secret', 'traveler'),
            'type' => 'text',
            'std' => '',
            'condition' => ""
        ),
        array(
            'id' => 'st_roomorama_token',
            'section' => 'option_api_update',
            'label' => __('Token Access', 'traveler'),
            'desc' => __('Token Access : https://www.roomorama.com/account/api', 'traveler'),
            'type' => 'text',
            'std' => '',
            'condition' => ""
        ),
        array(
            'id' => 'show_content_api_roomorama',
            'section' => 'option_api_update',
            'label' => __('Content', 'traveler'),
            'desc' => __('Content', 'traveler'),
            'type' => 'show_content_api_roomorama',
            'std' => '',
            'condition' => ""
        ),
        array(
            'id' => 'travelpayouts_option',
            'label' => esc_html__('TravelPayouts', 'traveler'),
            'type' => 'tab',
            'section' => 'option_api_update'
        ),
        [
            'id' => 'tp_marker',
            'label' => esc_html__('Travelpayouts ID', 'traveler'),
            'type' => 'text',
            'desc' => esc_html__('Enter your Travelpayouts ID', 'traveler'),
            'section' => 'option_api_update'
        ],
        array(
            'id' => 'tp_locale_default',
            'label' => esc_html__('Default Language', 'traveler'),
            'type' => 'select',
            'operator' => 'and',
            'choices' => array(
                array(
                    'value' => 'ez',
                    'label' => esc_html__('Azerbaijan', 'traveler')
                ),
                array(
                    'value' => 'ms',
                    'label' => esc_html__('Bahasa Melayu', 'traveler')
                ),
                array(
                    'value' => 'br',
                    'label' => esc_html__('Brazilian', 'traveler')
                ),
                array(
                    'value' => 'bg',
                    'label' => esc_html__('Bulgarian', 'traveler')
                ),
                array(
                    'value' => 'zh',
                    'label' => esc_html__('Chinese', 'traveler')
                ),
                array(
                    'value' => 'da',
                    'label' => esc_html__('Danish', 'traveler')
                ),
                array(
                    'value' => 'de',
                    'label' => esc_html__('Deutsch (DE)', 'traveler')
                ),
                array(
                    'value' => 'en',
                    'label' => esc_html__('English', 'traveler')
                ),
                array(
                    'value' => 'en-AU',
                    'label' => esc_html__('English (AU)', 'traveler')
                ),
                array(
                    'value' => 'en-GB',
                    'label' => esc_html__('English (GB)', 'traveler')
                ),
                array(
                    'value' => 'fr',
                    'label' => esc_html__('French', 'traveler')
                ),
                array(
                    'value' => 'ka',
                    'label' => esc_html__('Georgian', 'traveler')
                ),
                array(
                    'value' => 'el',
                    'label' => esc_html__('Greek (Modern Greek)', 'traveler')
                ),
                array(
                    'value' => 'it',
                    'label' => esc_html__('Italian', 'traveler')
                ),
                array(
                    'value' => 'ja',
                    'label' => esc_html__('Japanese', 'traveler')
                ),
                array(
                    'value' => 'lv',
                    'label' => esc_html__('Latvian', 'traveler')
                ),
                array(
                    'value' => 'pl',
                    'label' => esc_html__('Polish', 'traveler')
                ),
                array(
                    'value' => 'pt',
                    'label' => esc_html__('Portuguese', 'traveler')
                ),
                array(
                    'value' => 'ro',
                    'label' => esc_html__('Romanian', 'traveler')
                ),
                array(
                    'value' => 'ru',
                    'label' => esc_html__('Russian', 'traveler')
                ),
                array(
                    'value' => 'sr',
                    'label' => esc_html__('Serbian', 'traveler')
                ),
                array(
                    'value' => 'es',
                    'label' => esc_html__('Spanish', 'traveler')
                ),
                array(
                    'value' => 'th',
                    'label' => esc_html__('Thai', 'traveler')
                ),
                array(
                    'value' => 'tr',
                    'label' => esc_html__('Turkish', 'traveler')
                ),
                array(
                    'value' => 'uk',
                    'label' => esc_html__('Ukrainian', 'traveler')
                ),
                array(
                    'value' => 'vi',
                    'label' => esc_html__('Vietnamese', 'traveler')
                ),

            ),
            'section' => 'option_api_update',
            'std' => 'en'
        ),

        array(
            'id' => 'tp_currency_default',
            'label' => esc_html__('Default Currency', 'traveler'),
            'type' => 'select',
            'choices' => array(
                array(
                    'value' => 'amd',
                    'label' => esc_html__('UAE dirham (AED)', 'traveler')
                ),
                array(
                    'value' => 'amd',
                    'label' => esc_html__('Armenian Dram (AMD)', 'traveler')
                ), array(
                    'value' => 'ars',
                    'label' => esc_html__('Argentine peso (ARS)', 'traveler')
                ), array(
                    'value' => 'aud',
                    'label' => esc_html__('Australian Dollar (AUD)', 'traveler')
                ), array(
                    'value' => 'azn',
                    'label' => esc_html__('Azerbaijani Manat (AZN)', 'traveler')
                ), array(
                    'value' => 'bdt',
                    'label' => esc_html__('Bangladeshi taka (BDT)', 'traveler')
                ), array(
                    'value' => 'bgn',
                    'label' => esc_html__('Bulgarian lev (BGN)', 'traveler')
                ), array(
                    'value' => 'brl',
                    'label' => esc_html__('Brazilian real (BRL)', 'traveler')
                ), array(
                    'value' => 'byr',
                    'label' => esc_html__('Belarusian ruble (BYR)', 'traveler')
                ), array(
                    'value' => 'chf',
                    'label' => esc_html__('Swiss Franc (CHF)', 'traveler')
                ), array(
                    'value' => 'clp',
                    'label' => esc_html__('Chilean peso (CLP)', 'traveler')
                ), array(
                    'value' => 'cny',
                    'label' => esc_html__('Chinese Yuan (CNY)', 'traveler')
                ), array(
                    'value' => 'cop',
                    'label' => esc_html__('Colombian peso (COP)', 'traveler')
                ), array(
                    'value' => 'dkk',
                    'label' => esc_html__('Danish krone (DKK)', 'traveler')
                ), array(
                    'value' => 'egp',
                    'label' => esc_html__('Egyptian Pound (EGP)', 'traveler')
                ), array(
                    'value' => 'eur',
                    'label' => esc_html__('Euro (EUR)', 'traveler')
                ), array(
                    'value' => 'gbp',
                    'label' => esc_html__('British Pound Sterling (GBP)', 'traveler')
                ), array(
                    'value' => 'gel',
                    'label' => esc_html__('Georgian lari (GEL)', 'traveler')
                ), array(
                    'value' => 'hkd',
                    'label' => esc_html__('Hong Kong Dollar (HKD)', 'traveler')
                ), array(
                    'value' => 'huf',
                    'label' => esc_html__('Hungarian forint (HUF)', 'traveler')
                ), array(
                    'value' => 'idr',
                    'label' => esc_html__('Indonesian Rupiah (IDR)', 'traveler')
                ), array(
                    'value' => 'inr',
                    'label' => esc_html__('Indian Rupee (INR)', 'traveler')
                ), array(
                    'value' => 'jpy',
                    'label' => esc_html__('Japanese Yen (JPY)', 'traveler')
                ), array(
                    'value' => 'kgs',
                    'label' => esc_html__('Som (KGS)', 'traveler')
                ), array(
                    'value' => 'krw',
                    'label' => esc_html__('South Korean won (KRW)', 'traveler')
                ), array(
                    'value' => 'mxn',
                    'label' => esc_html__('Mexican peso (MXN)', 'traveler')
                ), array(
                    'value' => 'myr',
                    'label' => esc_html__('Malaysian ringgit (MYR)', 'traveler')
                ), array(
                    'value' => 'nok',
                    'label' => esc_html__('Norwegian Krone (NOK)', 'traveler')
                ), array(
                    'value' => 'kzt',
                    'label' => esc_html__('Kazakhstani Tenge (KZT)', 'traveler')
                ), array(
                    'value' => 'ltl',
                    'label' => esc_html__('Latvian Lat (LTL)', 'traveler')
                ), array(
                    'value' => 'nzd',
                    'label' => esc_html__('New Zealand Dollar (NZD)', 'traveler')
                ), array(
                    'value' => 'pen',
                    'label' => esc_html__('Peruvian sol (PEN)', 'traveler')
                ), array(
                    'value' => 'php',
                    'label' => esc_html__('Philippine Peso (PHP)', 'traveler')
                ), array(
                    'value' => 'pkr',
                    'label' => esc_html__('Pakistan Rupee (PKR)', 'traveler')
                ), array(
                    'value' => 'pln',
                    'label' => esc_html__('Polish zloty (PLN)', 'traveler')
                ), array(
                    'value' => 'ron',
                    'label' => esc_html__('Romanian leu (RON)', 'traveler')
                ), array(
                    'value' => 'rsd',
                    'label' => esc_html__('Serbian dinar (RSD)', 'traveler')
                ), array(
                    'value' => 'rub',
                    'label' => esc_html__('Russian Ruble (RUB)', 'traveler')
                ), array(
                    'value' => 'sar',
                    'label' => esc_html__('Saudi riyal (SAR)', 'traveler')
                ), array(
                    'value' => 'sek',
                    'label' => esc_html__('Swedish krona (SEK)', 'traveler')
                ), array(
                    'value' => 'sgd',
                    'label' => esc_html__('Singapore Dollar (SGD)', 'traveler')
                ), array(
                    'value' => 'thb',
                    'label' => esc_html__('Thai Baht (THB)', 'traveler')
                ), array(
                    'value' => 'try',
                    'label' => esc_html__('Turkish lira (TRY)', 'traveler')
                ), array(
                    'value' => 'uah',
                    'label' => esc_html__('Ukrainian Hryvnia (UAH)', 'traveler')
                ), array(
                    'value' => 'usd',
                    'label' => esc_html__('US Dollar (USD)', 'traveler')
                ), array(
                    'value' => 'vnd',
                    'label' => esc_html__('Vietnamese dong (VND)', 'traveler')
                ), array(
                    'value' => 'xof',
                    'label' => esc_html__('CFA Franc (XOF)', 'traveler')
                ), array(
                    'value' => 'zar',
                    'label' => esc_html__('South African Rand (ZAR)', 'traveler')
                ),
            ),
            'section' => 'option_api_update',
            'std' => 'usd'
        ),

        array(
            'id' => 'tp_redirect_option',
            'label' => esc_html__('Use Whitelabel', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_api_update',
            'std' => 'off'
        ),
        array(
            'id' => 'tp_whitelabel',
            'label' => esc_html__('Whitelabel Name', 'traveler'),
            'type' => 'text',
            'section' => 'option_api_update',
            'condition' => 'tp_redirect_option:is(on)'
        ),
        array(
            'id' => 'tp_whitelabel_page',
            'label' => esc_html__('Whitelabel Page Search', 'traveler'),
            'type' => 'st_post_type_select',
            'post_type' => 'travel_payout',
            'section' => 'option_api_update',
            'condition' => 'tp_redirect_option:is(on)',
        ),
        array(
            'id' => 'tp_show_api_info',
            'label' => esc_html__('Show API Info', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_api_update',
            'std' => 'on'
        ),
        
        

        /*------------------- Booking.com API ----------------------*/
        array(
            'id' => 'bookingdc_option',
            'label' => esc_html__('Booking.com', 'traveler'),
            'type' => 'tab',
            'section' => 'option_api_update',
        ),
        array(
            'id' => 'bookingdc_iframe',
            'label' => __('Using iframe search form', 'traveler'),
            'desc' => __('Enable iframe search form', 'traveler'),
            'type' => 'on-off',
            'section' => 'option_api_update',
            'std' => 'on',
        ),
        array(
            'id' => 'bookingdc_iframe_code',
            'label' => __('Search form code', 'traveler'),
            'desc' => __('Enter your search box code from booking.com', 'traveler'),
            'type' => 'textarea-simple',
            'rows' => '4',
            'condition' => 'bookingdc_iframe:is(on)',
            'section' => 'option_api_update',
        ),
        array(
            'id' => 'bookingdc_aid',
            'label' => __('Your affiliate ID', 'traveler'),
            'desc' => __('Enter your affiliate ID from booking.com', 'traveler'),
            'type' => 'text',
            'condition' => 'bookingdc_iframe:is(off)',
            'section' => 'option_api_update',
        ),
        array(
            'id' => 'bookingdc_cname',
            'label' => __('Cname', 'traveler'),
            'desc' => __('Enter your Cname for search box', 'traveler'),
            'type' => 'text',
            'condition' => 'bookingdc_iframe:is(off)',
            'section' => 'option_api_update',
        ),
        array(
            'id' => 'bookingdc_lang',
            'label' => esc_html__('Default Language', 'traveler'),
            'type' => 'select',
            'operator' => 'and',
            'choices' => array(
                array(
                    'value' => 'ez',
                    'label' => esc_html__('Azerbaijan', 'traveler')
                ),
                array(
                    'value' => 'ms',
                    'label' => esc_html__('Bahasa Melayu', 'traveler')
                ),
                array(
                    'value' => 'br',
                    'label' => esc_html__('Brazilian', 'traveler')
                ),
                array(
                    'value' => 'bg',
                    'label' => esc_html__('Bulgarian', 'traveler')
                ),
                array(
                    'value' => 'zh',
                    'label' => esc_html__('Chinese', 'traveler')
                ),
                array(
                    'value' => 'da',
                    'label' => esc_html__('Danish', 'traveler')
                ),
                array(
                    'value' => 'de',
                    'label' => esc_html__('Deutsch (DE)', 'traveler')
                ),
                array(
                    'value' => 'en',
                    'label' => esc_html__('English', 'traveler')
                ),
                array(
                    'value' => 'en-AU',
                    'label' => esc_html__('English (AU)', 'traveler')
                ),
                array(
                    'value' => 'en-GB',
                    'label' => esc_html__('English (GB)', 'traveler')
                ),
                array(
                    'value' => 'fr',
                    'label' => esc_html__('French', 'traveler')
                ),
                array(
                    'value' => 'ka',
                    'label' => esc_html__('Georgian', 'traveler')
                ),
                array(
                    'value' => 'el',
                    'label' => esc_html__('Greek (Modern Greek)', 'traveler')
                ),
                array(
                    'value' => 'it',
                    'label' => esc_html__('Italian', 'traveler')
                ),
                array(
                    'value' => 'ja',
                    'label' => esc_html__('Japanese', 'traveler')
                ),
                array(
                    'value' => 'lv',
                    'label' => esc_html__('Latvian', 'traveler')
                ),
                array(
                    'value' => 'pl',
                    'label' => esc_html__('Polish', 'traveler')
                ),
                array(
                    'value' => 'pt',
                    'label' => esc_html__('Portuguese', 'traveler')
                ),
                array(
                    'value' => 'ro',
                    'label' => esc_html__('Romanian', 'traveler')
                ),
                array(
                    'value' => 'ru',
                    'label' => esc_html__('Russian', 'traveler')
                ),
                array(
                    'value' => 'sr',
                    'label' => esc_html__('Serbian', 'traveler')
                ),
                array(
                    'value' => 'es',
                    'label' => esc_html__('Spanish', 'traveler')
                ),
                array(
                    'value' => 'th',
                    'label' => esc_html__('Thai', 'traveler')
                ),
                array(
                    'value' => 'tr',
                    'label' => esc_html__('Turkish', 'traveler')
                ),
                array(
                    'value' => 'uk',
                    'label' => esc_html__('Ukrainian', 'traveler')
                ),
                array(
                    'value' => 'vi',
                    'label' => esc_html__('Vietnamese', 'traveler')
                ),

            ),
            'section' => 'option_api_update',
            'std' => 'en',
            'condition' => 'bookingdc_iframe:is(off)',
        ),

        array(
            'id' => 'bookingdc_currency',
            'label' => esc_html__('Default Currency', 'traveler'),
            'type' => 'select',
            'choices' => array(
                array(
                    'value' => 'amd',
                    'label' => esc_html__('UAE dirham (AED)', 'traveler')
                ),
                array(
                    'value' => 'amd',
                    'label' => esc_html__('Armenian Dram (AMD)', 'traveler')
                ), array(
                    'value' => 'ars',
                    'label' => esc_html__('Argentine peso (ARS)', 'traveler')
                ), array(
                    'value' => 'aud',
                    'label' => esc_html__('Australian Dollar (AUD)', 'traveler')
                ), array(
                    'value' => 'azn',
                    'label' => esc_html__('Azerbaijani Manat (AZN)', 'traveler')
                ), array(
                    'value' => 'bdt',
                    'label' => esc_html__('Bangladeshi taka (BDT)', 'traveler')
                ), array(
                    'value' => 'bgn',
                    'label' => esc_html__('Bulgarian lev (BGN)', 'traveler')
                ), array(
                    'value' => 'brl',
                    'label' => esc_html__('Brazilian real (BRL)', 'traveler')
                ), array(
                    'value' => 'byr',
                    'label' => esc_html__('Belarusian ruble (BYR)', 'traveler')
                ), array(
                    'value' => 'chf',
                    'label' => esc_html__('Swiss Franc (CHF)', 'traveler')
                ), array(
                    'value' => 'clp',
                    'label' => esc_html__('Chilean peso (CLP)', 'traveler')
                ), array(
                    'value' => 'cny',
                    'label' => esc_html__('Chinese Yuan (CNY)', 'traveler')
                ), array(
                    'value' => 'cop',
                    'label' => esc_html__('Colombian peso (COP)', 'traveler')
                ), array(
                    'value' => 'dkk',
                    'label' => esc_html__('Danish krone (DKK)', 'traveler')
                ), array(
                    'value' => 'egp',
                    'label' => esc_html__('Egyptian Pound (EGP)', 'traveler')
                ), array(
                    'value' => 'eur',
                    'label' => esc_html__('Euro (EUR)', 'traveler')
                ), array(
                    'value' => 'gbp',
                    'label' => esc_html__('British Pound Sterling (GBP)', 'traveler')
                ), array(
                    'value' => 'gel',
                    'label' => esc_html__('Georgian lari (GEL)', 'traveler')
                ), array(
                    'value' => 'hkd',
                    'label' => esc_html__('Hong Kong Dollar (HKD)', 'traveler')
                ), array(
                    'value' => 'huf',
                    'label' => esc_html__('Hungarian forint (HUF)', 'traveler')
                ), array(
                    'value' => 'idr',
                    'label' => esc_html__('Indonesian Rupiah (IDR)', 'traveler')
                ), array(
                    'value' => 'inr',
                    'label' => esc_html__('Indian Rupee (INR)', 'traveler')
                ), array(
                    'value' => 'jpy',
                    'label' => esc_html__('Japanese Yen (JPY)', 'traveler')
                ), array(
                    'value' => 'kgs',
                    'label' => esc_html__('Som (KGS)', 'traveler')
                ), array(
                    'value' => 'krw',
                    'label' => esc_html__('South Korean won (KRW)', 'traveler')
                ), array(
                    'value' => 'mxn',
                    'label' => esc_html__('Mexican peso (MXN)', 'traveler')
                ), array(
                    'value' => 'myr',
                    'label' => esc_html__('Malaysian ringgit (MYR)', 'traveler')
                ), array(
                    'value' => 'nok',
                    'label' => esc_html__('Norwegian Krone (NOK)', 'traveler')
                ), array(
                    'value' => 'kzt',
                    'label' => esc_html__('Kazakhstani Tenge (KZT)', 'traveler')
                ), array(
                    'value' => 'ltl',
                    'label' => esc_html__('Latvian Lat (LTL)', 'traveler')
                ), array(
                    'value' => 'nzd',
                    'label' => esc_html__('New Zealand Dollar (NZD)', 'traveler')
                ), array(
                    'value' => 'pen',
                    'label' => esc_html__('Peruvian sol (PEN)', 'traveler')
                ), array(
                    'value' => 'php',
                    'label' => esc_html__('Philippine Peso (PHP)', 'traveler')
                ), array(
                    'value' => 'pkr',
                    'label' => esc_html__('Pakistan Rupee (PKR)', 'traveler')
                ), array(
                    'value' => 'pln',
                    'label' => esc_html__('Polish zloty (PLN)', 'traveler')
                ), array(
                    'value' => 'ron',
                    'label' => esc_html__('Romanian leu (RON)', 'traveler')
                ), array(
                    'value' => 'rsd',
                    'label' => esc_html__('Serbian dinar (RSD)', 'traveler')
                ), array(
                    'value' => 'rub',
                    'label' => esc_html__('Russian Ruble (RUB)', 'traveler')
                ), array(
                    'value' => 'sar',
                    'label' => esc_html__('Saudi riyal (SAR)', 'traveler')
                ), array(
                    'value' => 'sek',
                    'label' => esc_html__('Swedish krona (SEK)', 'traveler')
                ), array(
                    'value' => 'sgd',
                    'label' => esc_html__('Singapore Dollar (SGD)', 'traveler')
                ), array(
                    'value' => 'thb',
                    'label' => esc_html__('Thai Baht (THB)', 'traveler')
                ), array(
                    'value' => 'try',
                    'label' => esc_html__('Turkish lira (TRY)', 'traveler')
                ), array(
                    'value' => 'uah',
                    'label' => esc_html__('Ukrainian Hryvnia (UAH)', 'traveler')
                ), array(
                    'value' => 'usd',
                    'label' => esc_html__('US Dollar (USD)', 'traveler')
                ), array(
                    'value' => 'vnd',
                    'label' => esc_html__('Vietnamese dong (VND)', 'traveler')
                ), array(
                    'value' => 'xof',
                    'label' => esc_html__('CFA Franc (XOF)', 'traveler')
                ), array(
                    'value' => 'zar',
                    'label' => esc_html__('South African Rand (ZAR)', 'traveler')
                ),
            ),
            'section' => 'option_api_update',
            'std' => 'usd',
            'condition' => 'bookingdc_iframe:is(off)',
        ),
        /*------------------- End Booking.com API ----------------------*/

        /*------------------- Expedia API ----------------------*/
        array(
            'id' => 'expedia_option',
            'label' => esc_html__('Expedia', 'traveler'),
            'type' => 'tab',
            'section' => 'option_api_update',
        ),
        array(
            'id' => 'expedia_iframe_code',
            'label' => __('Search form code', 'traveler'),
            'desc' => __('Enter your search box code from expedia', 'traveler'),
            'type' => 'textarea-simple',
            'rows' => '4',
            'section' => 'option_api_update',
        ),
        /*------------------- End Expedia API ----------------------*/
    )
);

if(function_exists('icl_get_languages') || function_exists('qtranxf_init_language')) {
    $custom_settings_currency_mapping =
        array(
            array(
                'id'      => 'booking_currency_mapping_detect' ,
                'label'   => __( 'Auto detect currency by language' , 'traveler' ) ,
                'type'    => 'on-off' ,
                'section' => 'option_booking' ,
                'std'     => 'off'
            ) ,
            array(
                'id'      => 'booking_currency_mapping',
                'label'   => __( 'Mapping currencies', 'traveler' ),
                'desc'    => __( 'Mapping currency with language', 'traveler' ),
                'type'    => 'st_mapping_currency',
                'condition' => 'booking_currency_mapping_detect:is(on)',
                'section' => 'option_booking',
            )
        );
    array_splice( $custom_settings['settings'], 102, 0, $custom_settings_currency_mapping );
}

$taxonomy_hotel = st_get_post_taxonomy('st_hotel');
if (!empty($taxonomy_hotel)) {
    foreach ($taxonomy_hotel as $k => $v) {
        $terms_hotel = get_terms($v['value']);
        $ids = array();
        if (!empty($terms_hotel)) {
            foreach ($terms_hotel as $key => $value) {
                $ids[] = array(
                    'value' => $value->term_id . "|" . $value->name,
                    'label' => $value->name,
                );
            }
            $custom_settings['settings']['flied_hotel']['settings'][] = array(
                'id' => 'custom_terms_' . $v['value'],
                'label' => $v['label'],
                'condition' => 'name:is(taxonomy),taxonomy:is(' . $v['value'] . ')',
                'operator' => 'and',
                'type' => 'checkbox',
                'choices' => $ids,
                'desc' => __('It will show all Hotel theme If you don\'t have any choose.', 'traveler'),
            );
            $ids = array();
        }
    }
}
$custom_settings = apply_filters('st_option_tree_settings', $custom_settings);

function ot_type_email_template_document()
{

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
                    <td><strong><?php echo __('Country', 'traveler'); ?>:</strong></td>
                    <td>[st_email_booking_country]</td>
                    <td></td>
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
                            2. <?php echo __('Display Pick-up Date and Drop-off Date with Car', 'traveler'); ?><br/>
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
                    <td><strong><?php echo __('Address', 'traveler'); ?>:</strong></td>
                    <td>[st_email_pick_up_from]</td>
                    <td>
                        <em>
                            <?php echo __('Address Rental Car.', 'traveler'); ?>
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
                    <td><em><?php echo __('Returns the name of the accounts was approved', 'traveler'); ?></em></td>
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
                    <td><em><?php echo __('Returns the name of the item has been approved', 'traveler'); ?></em></td>
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
                    <td><em><?php echo __('Returns time available of the package', 'traveler'); ?></em></td>
                </tr>
                <tr>
                    <td><strong><?php echo __('Package Item Upload', 'traveler'); ?></strong></td>
                    <td>[st_email_package_upload]</td>
                    <td><em><?php echo __('Returns number of item uploaded of the package', 'traveler'); ?></em></td>
                </tr>
                <tr>
                    <td><strong><?php echo __('Package Item Set Featured', 'traveler'); ?></strong></td>
                    <td>[st_email_package_featured]</td>
                    <td><em><?php echo __('Returns number of item set featured of the package', 'traveler'); ?></em>
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

}

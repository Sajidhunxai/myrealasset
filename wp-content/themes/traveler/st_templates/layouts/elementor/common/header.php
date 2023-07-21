<?php
/**
 * @package    WordPress
 * @subpackage Traveler
 * @since      1.0
 *
 * Header
 *
 * Created by ShineTheme
 *
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php echo (!is_rtl() && st()->get_option('right_to_left') == 'on') ? 'dir="rtl"' : '' ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport"
          content="width=device-width, height=device-height, initial-scale=1, maximum-scale=2, minimum-scale=1 , user-scalable=0">
    <meta name="theme-color" content="<?php echo st()->get_option('main_color', '#ED8323'); ?>"/>
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <?php if (defined('ST_TRAVELER_VERSION')) { ?>
        <meta name="traveler" content="<?php echo esc_attr(ST_TRAVELER_VERSION) ?>"/>  <?php }; ?>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php if (!function_exists('_wp_render_title_tag')): ?>
        <title><?php wp_title('|', true, 'right') ?></title>
    <?php endif; ?>
    <?php wp_head(); ?>
    <script>
        // Load the SDK asynchronously
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
                return;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        window.fbAsyncInit = function () {
            FB.init({
                appId: st_params.facbook_app_id,
                cookie: true, // enable cookies to allow the server to access
                // the session
                xfbml: true, // parse social plugins on this page
                version: 'v3.1' // use graph api version 2.8
            });

        };
    </script>
    <?php do_action('before_body_content') ?>
</head>
<?php
$class = '';
$menu_style = st()->get_option('menu_style_modern', '');
$menu_transparent = st()->get_option('menu_transparent', "off");

if (!empty(st_is_elementor_preview_mode()) && $menu_style == '2') {
    $class .= ' st-header-1';
} else {
    $class .= ' st-header-' . $menu_style;
}
$class .= ' body-header-elementor-' . $menu_style;
if(!empty($menu_transparent) && ($menu_transparent === 'on')){
    $class .= ' stt-menu-transparent';
}
if(st_check_single_style_mod() || $menu_style == '9'){
    $class .= ' st-mod-style';
}
?>
<body <?php body_class($class); ?>>
<?php do_action('before_body_content')?>
<?php
echo apply_filters('st_header_component', st()->load_template('layouts/elementor/common/header/style', $menu_style), ['style' => $menu_style]);

?>
        
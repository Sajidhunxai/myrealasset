<?php
echo stt_elementorv2()->loadView('components/topbar');

$logo_url = st()->get_option('logo_new');
$logo_mobile_url = st()->get_option('logo_mobile', $logo_url);
if (empty($logo_mobile_url)){
    $logo_mobile_url = $logo_url;
}
    
$header_items = st()->get_option('sort_header_menu', '');
?>
<header class="header d-flex align-items-center justify-content-between">
    <div class="header__left">
        <div class="menu-toggle">

        </div>
        <a href="<?php echo home_url('/') ?>" class="logo d-none d-sm-none d-lg-block">
            <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo get_bloginfo('description'); ?>">
        </a>
        <a href="<?php echo home_url('/') ?>" class="logo d-block  d-lg-none">
            <img src="<?php echo esc_url($logo_mobile_url); ?>" alt="<?php echo get_bloginfo('description'); ?>">
        </a>
        <?php if (is_front_page()) : ?>
            <h1 class="tag_h1 d-none d-lg-none"><?php bloginfo( 'name' ); ?></h1>
        <?php endif; ?>
    </div>
    <div class="header__center">
        <nav id="st-main-menu">
            <a href="#" class="back-menu"><span class="stt-icon stt-icon-arrow-left"></span></a>
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    "container" => "",
                    'items_wrap' => '<ul id="main-menu" class="%2$s main-menu">%3$s</ul>',
                    'depth' => 10,
                    'walker' => new st_menu_walker_v3(),
                ));
            }
            ?>
        </nav>
        <div class="overlay"></div>
    </div>
    <div class="header__right">
        <?php
        if (!empty($header_items) and is_array($header_items)) {
            echo '<ul class="items d-flex align-items-center flex-wrap">';
            foreach ($header_items as $key => $val) {
                if (!empty($val['header_item'])) {
                    if ($val['header_item'] == 'login') {
                        echo stt_elementorv2()->loadView('components/header-items/account');
                    }
                    if ($val['header_item'] == 'currency') {
                        echo st()->load_template('layouts/elementor/common/header/topbar-items/currency', '', ['show' => true]);
                    }
                    if ($val['header_item'] == 'language') {
                        echo st()->load_template('layouts/elementor/common/header/topbar-items/language', '', ['show' => true]);
                    }
                    if ($val['header_item'] == 'link') {
                        $icon = '';
                        if (!empty($val['header_custom_link_icon'])) {
                            $icon = esc_html($val['header_custom_link_icon']);
                        }
                        echo '<li class="d-none d-sm-block d-md-block st-header-link"><a href="' . esc_url($val['header_custom_link']) . '"> <i class="' . esc_attr($icon) . ' mr5"></i>' . esc_html($val['header_custom_link_title']) . '</a></li>';
                    }
                    if ($val['header_item'] == 'shopping_cart') {
                        echo st()->load_template('layouts/elementor/common/header/topbar-items/cart', '', ['icon' => '<span class="stt-icon stt-icon-bag02"></span>']);
                    }
                    if ($val['header_item'] == 'search') {
                        $search_header_onoff = st()->get_option('search_header_onoff', 'on');
                        if ($search_header_onoff == 'on'):
                            echo st()->load_template('layouts/elementor/common/header/topbar-items/search', '');
                        endif;
                    }
                }
            }
            echo '</ul>';
        }
        ?>
    </div>
</header>

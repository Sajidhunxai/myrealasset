<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12-11-2018
 * Time: 11:47 AM
 * Since: 1.0.0
 * Updated: 1.0.0
 */
?>
<header id="header" class="header-style-4">
    <div class="container">
        <?php
        $enable_topbar = st()->get_option('enable_topbar', 'on');
        if ($enable_topbar == 'on') {
            $hidden_topbar_in_mobile = st()->get_option('hidden_topbar_in_mobile', 'on');
            if ($hidden_topbar_in_mobile == 'off' || ($hidden_topbar_in_mobile == 'on' && !wp_is_mobile())) {
                ?>
                <div id="topbar">
                    <?php
                    $sort_topbar_menu = st()->get_option('sort_topbar_menu', false);
                    if ($sort_topbar_menu) {
                        ?>
                        <div class="topbar-left">
                            <ul class="st-list socials">
                                <li>
                                    <?php
                                    foreach ($sort_topbar_menu as $key => $val) {
                                        $target = '';
                                        if (!empty($val['topbar_custom_link_target']) && $val['topbar_custom_link_target'] == 'on') {
                                            $target = '_blank';
                                        }else {
                                            $target = '_self';
                                        }
                                        $icon = esc_html($val['topbar_custom_link_icon']);
                                        if (!empty($val['topbar_item']) && $val['topbar_position'] == 'left' && isset($val['topbar_is_social']) && $val['topbar_is_social'] == 'on') {
                                            echo '<a href="' . esc_url($val['topbar_custom_link']) . '" target="' . esc_attr($target) . '"><i class="fa ' . esc_attr($icon) . '"></i><span>'. esc_html($val['title']) .'</span></a>';
                                        }

                                    }
                                    ?>
                                </li>
                            </ul>
                            <ul class="st-list topbar-items">
                                <?php
                                foreach ( $sort_topbar_menu as $key => $val ) {
                                    if ( !empty( $val[ 'topbar_item' ] ) && $val[ 'topbar_position' ] == 'left' && (empty( $val[ 'topbar_is_social' ] ) || $val[ 'topbar_is_social' ] == 'off') ) {
                                        if ($val['topbar_item'] == 'search') {
                                            echo st()->load_template('layouts/modern/common/header/topbar-items/search', '');
                                        } elseif ( $val[ 'topbar_item' ] == 'currency' ) {
                                            echo st()->load_template( 'layouts/modern/common/header/topbar-items/currency', '' );
                                        } elseif ( $val[ 'topbar_item' ] == 'language' ) {
                                            echo st()->load_template( 'layouts/modern/common/header/topbar-items/language', '' );
                                        }else {
                                            echo '<li class="hidden-xs hidden-sm"><a href="' . esc_url( $val[ 'topbar_custom_link' ] ) . '" target="' . esc_attr($target) . '">' . esc_html( $val[ 'topbar_custom_link_title' ] ) . '</a></li>';
                                        }
                                        
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="topbar-right">
                        <ul class="st-list socials">
                            <li>
                                <?php
                                foreach ($sort_topbar_menu as $key => $val) {
                                    $target = '';
                                    if (!empty($val['topbar_custom_link_target']) && $val['topbar_custom_link_target'] == 'on') {
                                        $target = '_blank';
                                    }else {
                                        $target = '_self';
                                    }
                                    $icon = esc_html($val['topbar_custom_link_icon']);
                                    if (!empty($val['topbar_item']) && $val['topbar_position'] == 'right' && isset($val['topbar_is_social']) && $val['topbar_is_social'] == 'on') {
                                        echo '<a href="' . esc_url($val['topbar_custom_link']) . '" target="' . esc_attr($target) . '"><i class="fa ' . esc_attr($icon) . '"></i></a>';

                                    }


                                }
                                ?>
                            </li>
                        </ul>
                        <ul class="st-list topbar-items">
                                <?php
                                foreach ( $sort_topbar_menu as $key => $val ) {
                                    if ( !empty( $val[ 'topbar_item' ] ) && $val[ 'topbar_position' ] == 'right' ) {
                                        if ( $val[ 'topbar_item' ] == 'login' ) {
                                            echo st()->load_template( 'layouts/modern/common/header/topbar-items/login', '' );
                                        }elseif ( $val[ 'topbar_item' ] == 'currency' ) {
                                            echo st()->load_template( 'layouts/modern/common/header/topbar-items/currency', '' );
                                        } elseif ( $val[ 'topbar_item' ] == 'language' ) {
                                            echo st()->load_template( 'layouts/modern/common/header/topbar-items/language', '' );
                                        } elseif ($val['topbar_item'] == 'search') {
                                            echo st()->load_template('layouts/modern/common/header/topbar-items/search', '');
                                        } else if ( $val[ 'topbar_item' ] == 'link' && (empty( $val[ 'topbar_is_social' ] ) || $val[ 'topbar_is_social' ] == 'off') ) {
                                            $topbar_custom_class = isset( $val[ 'topbar_custom_class' ] ) ? $val[ 'topbar_custom_class' ] : ''; ?>
                                            <li class="d-none d-sm-none d-md-inline-block topbar-item link-item <?php echo esc_attr($topbar_custom_class);?>">
                                                <a href="<?php echo esc_url($val['topbar_custom_link']); ?>" class="login"><?php echo esc_html($val[ 'topbar_custom_link_title' ]); ?></a>
                                            </li>
                                        <?php }
                                    }
                                }
                                ?>
                            </ul>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <div class="header">
            <a href="#" class="toggle-menu">
                <?php
                $menu_style = st()->get_option('menu_style_modern', "");
                if ($menu_style == '2') {
                    echo TravelHelper::getNewIcon('Ico_off_menu', '#fff', '', '', true);
                } else {
                    echo TravelHelper::getNewIcon('Ico_off_menu');
                }
                ?>
            </a>
            <div class="header-left">
                <?php
                $logo_url = st()->get_option('logo_new');
                $logo_mobile_url = st()->get_option('logo_mobile', $logo_url);
                if (empty($logo_mobile_url))
                    $logo_mobile_url = $logo_url;
                ?>
                <a href="<?php echo home_url('/') ?>" class="logo hidden-xs">
                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo get_bloginfo('description'); ?>">
                </a>
                <a href="<?php echo home_url('/') ?>" class="logo hidden-lg hidden-md hidden-sm">
                    <img src="<?php echo esc_url($logo_mobile_url); ?>"
                         alt="<?php echo get_bloginfo('description'); ?>">
                </a>
                <?php if (is_front_page()) : ?>
                <h1 class="tag_h1  hidden-lg hidden-md hidden-sm hidden-xs"><?php bloginfo( 'name' ); ?></h1>
            <?php endif; ?>
            </div>
            <div class="header-right">
                <nav id="st-main-menu">
                    <a href="#" class="back-menu"><i class="fa fa-angle-left"></i></a>
                    <?php
                    if (has_nav_menu('primary')) {
                        $mega_menu = st()->get_option('allow_megamenu', 'off');
                        if ($mega_menu == 'on') {
                            wp_nav_menu(array(
                                'theme_location' => 'primary',
                                "container" => "",
                                'items_wrap' => '<ul id="main-menu" class="%2$s main-menu">%3$s</ul>',
                                'depth' => 10,
                                'walker' => new ST_Mega_Menu_Walker_New(),
                            ));
                            ?>

                            <?php if(!is_user_logged_in()){ ?>
                                <div class="advance-menu">
                                    <a  href="#" class="login" data-toggle="modal" data-target="#st-login-form"><?php echo esc_html__('Login','traveler') ?></a>

                                    <a href="#" class="signup" data-toggle="modal" data-target="#st-register-form"><?php echo esc_html__('Sign Up','traveler') ?></a>
                                </div>
                            <?php } ?>
                            <?php
                        } else {
                            wp_nav_menu([
                                'theme_location' => 'primary',
                                "container" => "",
                                'items_wrap' => '<ul id="main-menu" class="%2$s main-menu">%3$s</ul>',
                                'walker' => new st_menu_walker_new(),
                            ]);
                            ?>
                            <?php if(!is_user_logged_in()){ ?>
                                <div class="advance-menu">
                                    <a  href="#" class="login" data-toggle="modal" data-target="#st-login-form"><?php echo esc_html__('Login','traveler') ?></a>

                                    <a href="#" class="signup" data-toggle="modal" data-target="#st-register-form"><?php echo esc_html__('Sign Up','traveler') ?></a>
                                </div>
                            <?php } ?>
                            <?php
                        }
                    }
                    ?>
                </nav>
                <?php
                $sort_header_menu = st()->get_option('sort_header_menu', '');
                if (!empty($sort_header_menu) and is_array($sort_header_menu)) {
                    ?>
                    <ul class="st-list">
                        <?php
                        foreach ($sort_header_menu as $key => $val) {
                            if (!empty($val['header_item'])) {
                                if ($val['header_item'] == 'login') {
                                    echo st()->load_template('layouts/modern/common/header/topbar-items/login', '', array('in_header' => true));
                                }
                                if ($val['header_item'] == 'currency') {
                                    echo st()->load_template('layouts/modern/common/header/topbar-items/currency', '');
                                }
                                if ($val['header_item'] == 'language') {
                                    echo st()->load_template('layouts/modern/common/header/topbar-items/language', '');
                                }
                                if ($val['header_item'] == 'link') {
                                    $icon = '';
                                    if (!empty($val['header_custom_link_icon'])) {
                                        $icon = esc_html($val['header_custom_link_icon']);
                                    }
                                    echo '<li class="st-header-link"><a href="' . esc_url($val['header_custom_link']) . '"> <i class="fa ' . esc_attr($icon) . ' mr5"></i>' . esc_html($val['header_custom_link_title']) . '</a></li>';
                                }
                                if ($val['header_item'] == 'shopping_cart') {
                                    echo st()->load_template('layouts/modern/common/header/topbar-items/cart', '');
                                }
                                if ($val['header_item'] == 'search') {
                                    echo st()->load_template('layouts/modern/common/header/topbar-items/search', '');
                                }
                            }
                        }
                        ?>

                    </ul>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</header>

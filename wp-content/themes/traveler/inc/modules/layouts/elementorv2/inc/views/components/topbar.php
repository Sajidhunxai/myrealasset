<?php
$enable_topbar = st()->get_option('enable_topbar', 'on');
if ($enable_topbar == 'on') {
    $classes = '';
    $hidden_topbar_in_mobile = st()->get_option('hidden_topbar_in_mobile', 'on');
    if ($hidden_topbar_in_mobile == 'on') {
        $classes .= ' mobile-hidden';
    }
    if ($hidden_topbar_in_mobile == 'off' || ($hidden_topbar_in_mobile == 'on' && !wp_is_mobile())) {
        ?>
        <div id="topbar" class="style-elementor <?php echo esc_attr($classes) ?>">
            <?php
            $sort_topbar_menu = st()->get_option('sort_topbar_menu', false);
            if ($sort_topbar_menu) {
                ?>
                <div class="topbar-left">
                    <ul class="st-list topbar-items">
                        <?php
                        foreach ($sort_topbar_menu as $key => $val) {
                            if (!empty($val['topbar_item']) && $val['topbar_position'] == 'left') {
                                if($val['topbar_item'] == 'search') {
                                    echo st()->load_template('layouts/modern/common/header/topbar-items/search', '');
                                }
                                if($val['topbar_item'] == 'login') {
                                    echo stt_elementorv2()->loadView("components/topbar-items/account" );
                                }
                                if($val['topbar_item'] == 'currency') {
                                    echo st()->load_template("menu/currency_select" , null ,  array('container' =>"li"  , "class"=>"nav-drop nav-symbol"));
                                }
                                if($val['topbar_item'] == 'language') {
                                    echo st()->load_template("menu/language_select" , null ,  array('container' =>"li"  , "class"=>"top-user-area-lang nav-drop"));
                                }
                                if($val['topbar_item'] == 'shopping_cart') {
                                    echo st()->load_template("menu/shopping_cart" , null ,  array('container' =>"li"  , "class"=>"top-user-area-shopping"));
                                }
                                if($val['topbar_item'] == 'link') {
                                    if($val['topbar_item'] == 'link') {
                                        $icon = '';
                                        if( !empty( $val['topbar_custom_link_icon'] ) ){
                                            $icon = esc_html( $val['topbar_custom_link_icon'] );
                                        }
                                        $target= '';
                                        if( !empty($val['topbar_custom_link_target']) && $val['topbar_custom_link_target'] == 'on'){
                                            $target = '_blank';
                                        }else {
                                            $target = '_self';
                                        }
                                        if(isset($val['topbar_is_social']) && $val['topbar_is_social'] == 'on') {
                                            echo '<li class="topbar-item link social"><a href="'. esc_url( $val['topbar_custom_link'] ).'" target="'.esc_attr($target).'"> '. (!empty($icon) ? '<i class="'. esc_attr($icon) .'"></i>' : '') .'</a></li>';
                                        } else {
                                            echo '<li class="topbar-item link normal"><a href="'. esc_url( $val['topbar_custom_link'] ).'" target="'.esc_attr($target).'"> '. (!empty($icon) ? '<i class="'. esc_attr($icon) .'"></i>' : '') . esc_html( $val['topbar_custom_link_title'] ).'</a></li>';
                                        }
                                    }
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
                <ul class="st-list topbar-items">
                    <?php
                    if(!empty($sort_topbar_menu)){
                        foreach ($sort_topbar_menu as $key => $val) {
                            if (!empty($val['topbar_item']) && $val['topbar_position'] == 'right') {
                                if($val['topbar_item'] == 'search') {
                                    echo st()->load_template('layouts/modern/common/header/topbar-items/search', '');
                                }
                                if($val['topbar_item'] == 'login') {
                                    echo stt_elementorv2()->loadView("components/topbar-items/account" );
                                }
                                if($val['topbar_item'] == 'currency') {
                                    echo st()->load_template("menu/currency_select" , null ,  array('container' =>"li"  , "class"=>"nav-drop nav-symbol"));
                                }
                                if($val['topbar_item'] == 'language') {
                                    echo st()->load_template("menu/language_select" , null ,  array('container' =>"li"  , "class"=>"top-user-area-lang nav-drop"));
                                }
                                if($val['topbar_item'] == 'shopping_cart') {
                                    echo st()->load_template("menu/shopping_cart" , null ,  array('container' =>"li"  , "class"=>"top-user-area-shopping"));
                                }
                                if($val['topbar_item'] == 'link') {
                                    if($val['topbar_item'] == 'link') {
                                        $icon = '';
                                        if( !empty( $val['topbar_custom_link_icon'] ) ){
                                            $icon = esc_html( $val['topbar_custom_link_icon'] );
                                        }
                                        $target= '';
                                        if( !empty($val['topbar_custom_link_target']) && $val['topbar_custom_link_target'] == 'on'){
                                            $target = '_blank';
                                        }else {
                                            $target = '_self';
                                        }
                                        if(isset($val['topbar_is_social']) && $val['topbar_is_social'] == 'on') {
                                            echo '<li class="topbar-item link social"><a href="'. esc_url( $val['topbar_custom_link'] ).'" target="'.esc_attr($target).'"> '. (!empty($icon) ? '<i class="'. esc_attr($icon) .'"></i>' : '') .'</a></li>';
                                        } else {
                                            echo '<li class="topbar-item link normal"><a href="'. esc_url( $val['topbar_custom_link'] ).'" target="'.esc_attr($target).'"> ' . (!empty($icon) ? '<i class="'. esc_attr($icon) .'"></i>' : '') . esc_html( $val['topbar_custom_link_title'] ).'</a></li>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                    ?>
                </ul>
            </div>
        </div>
        <?php
    }
}

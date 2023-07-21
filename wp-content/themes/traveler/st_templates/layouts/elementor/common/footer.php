<?php

$menu_style = st()->get_option('menu_style_modern', '');
$footer_class = '';
if($menu_style == 8){
    $footer_class = 'main-footer--solo';
}
$copyright = st()->get_option('st_text_copyright');
wp_reset_postdata();
wp_reset_query();
$id_template_footer = st()->get_option('footer_template_new');
if ($id_template_footer) {
    $el_content = st_get_elementor_content_page($id_template_footer);
    if ($el_content) {
        echo '<footer id="main-footer" class="clearfix '. esc_attr($footer_class) .' ">';
        echo balanceTags($el_content);
        echo ' </footer>';
    }
} else {
    ?>
    <footer id="main-footer" class="container-fluid">
        <div class="container text-center">
            <p><?php _e('Copy &copy; 2022 Shinetheme. All Rights Reserved', 'traveler') ?></p>
        </div>

    </footer>
<?php } ?>
<?php if($menu_style !=8 && !empty($copyright)){
    
    $card_accept = st()->get_option('st_card_accept');
    if(!empty($copyright) && !empty($card_accept)){
    ?>
    <div class="container main-footer-sub">
        <div class="d-block  d-sm-flex d-md-flex justify-content-between align-items-center">
            <div class="left mt20">
                <div class="f14">
                    <?php
                    echo wp_kses($copyright, array('p' => ['class' => []], 'a' => ['class' => [], 'href' => []], 'br' => [], 'em' => [], 'strong' => []));
                    ?>
                </div>
            </div>
            <div class="right mt20">
                <?php
                if (!empty($card_accept)) { ?>
                    <?php
                    
                    if (!empty($card_accept)) {
                        $class = Assets::build_css('height: 40px');
                        ?>
                        <img src="<?php echo esc_url($card_accept) ?>" width="240" height="40" alt="<?php echo esc_attr__('Trust badges','traveler');?>"
                            class="img-responsive st_trustbase <?php echo esc_attr($class) ?>">
                        <?php
                    }
                } ?>
            </div>
        </div>
    </div>
<?php } } ?>

<?php
if ($menu_style == 8) { //solo layout
    echo st()->load_template('layouts/elementor/common/loginForm', 'solo');
    echo st()->load_template('layouts/elementor/common/registerForm', 'solo');
} else {
    echo apply_filters('st_get_popup_login_form', st()->load_template('layouts/elementor/common/loginForm', ''), ['style' => $menu_style]);
    echo apply_filters('st_get_popup_register_form', st()->load_template('layouts/elementor/common/registerForm', ''), ['style' => $menu_style]);
}
echo apply_filters('st_get_popup_reset_password_form', st()->load_template('layouts/elementor/common/resetPasswordForm', ''), ['style' => $menu_style]);
?>
<div id="gotop" title="<?php echo esc_attr__('Go to top','traveler');?>">
    <i class="stt-icon-arrow-up"></i>
</div>
<?php do_action('stt_compare_link'); ?>
<?php do_action('stt_compare_popup'); ?>
<?php wp_footer(); ?>
<?php do_action('st_after_footer');?>
</body>
</html>

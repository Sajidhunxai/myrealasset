<?php
$menu_style = st()->get_option('menu_style_modern', '');
$footer_class = '';
if($menu_style == 8){
    $footer_class = 'main-footer--solo';
}
wp_reset_postdata();
wp_reset_query();
$footer_template = TravelHelper::st_get_template_footer(get_the_ID(), true);

if ($footer_template) {
    $vc_content = STTemplate::get_vc_pagecontent($footer_template);
    if ($vc_content) {
        echo '<footer id="main-footer" class="clearfix '. esc_attr($footer_class) .' ">';
        echo balanceTags($vc_content);
        echo ' </footer>';
    }
} else {
    ?>
    <footer id="main-footer" class="container-fluid">
        <div class="container text-center">
            <p><?php echo sprintf(__('Copy &copy; %s Shinetheme. All Rights Reserved', 'traveler'),date("Y")); ?></p>
        </div>

    </footer>
<?php } ?>

<?php if($menu_style !=8){
    $copyright = st()->get_option('st_text_copyright');
    $card_accept = st()->get_option('st_card_accept');
    ?>
    <div class="container main-footer-sub">
        <div class="st-flex space-between">
            <div class="left mt20">
                <div class="f14">
                    <?php
                    if (empty($copyright)) {
                        echo sprintf( esc_html__( 'Copyright © %s by', 'traveler' ), date( 'Y' ) ); ?> <a
                            href="<?php echo esc_url( home_url( '/' ) ) ?>"
                            class="st-link"><?php bloginfo( 'name' ) ?></a>
                        <?php
                    } else {
                        echo wp_kses($copyright, array('p' => ['class' => []], 'a' => ['class' => [], 'href' => []], 'br' => [], 'em' => [], 'strong' => []));
                    } ?>
                </div>
            </div>
            <div class="right mt20">
                <?php
                if (!empty($card_accept)) { ?>
                    <?php
                    $image_id = attachment_url_to_postid($card_accept);
                    $thumb_card_accept = wp_get_attachment_image_src($image_id, ['', '40']);
                    if (isset($thumb_card_accept[0]) && !empty($thumb_card_accept[0])) {
                        $class = Assets::build_css('height: 40px');
                        ?>
                        <img width="240" height="40" src="<?php echo esc_url($card_accept) ?>" alt="<?php echo esc_attr__('Trust badges','traveler');?>"
                            class="img-responsive st_trustbase <?php echo esc_attr($class) ?>">
                        <?php
                    }
                } ?>
            </div>
        </div>
    </div>
<?php } ?>

<?php
if ($menu_style == 8) { //solo layout
    echo st()->load_template('layouts/modern/common/loginForm', 'solo');
    echo st()->load_template('layouts/modern/common/registerForm', 'solo');
} else {
    echo st()->load_template('layouts/modern/common/loginForm', '');
    echo st()->load_template('layouts/modern/common/registerForm', '');
}
echo st()->load_template('layouts/modern/common/resetPasswordForm', '');
?>
<?php do_action('stt_compare_link'); ?>
<?php do_action('stt_compare_popup'); ?>
<?php wp_footer(); ?>
<?php do_action('st_after_footer');?>
</body>
</html>

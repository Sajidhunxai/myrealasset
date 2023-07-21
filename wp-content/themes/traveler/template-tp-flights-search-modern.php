<?php
/**
 * Template Name: TravelPayout Search Modern
 */

get_header();

?>
<div id="st-content-wrapper" class="search-result-page <?php if(check_using_elementor()){echo'st-style-elementor ';} ?>">
        <?php echo st()->load_template('layouts/template-banner-page'); ?>
        <?php st_breadcrumbs_new() ?>
            <?php
            $whitelabel_name = st()->get_option('tp_whitelabel', 'whilelabel.travelerwp.com');
            if(isset($_SERVER['HTTPS'])){
                if ($_SERVER['HTTPS'] != "on") {
                    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
                }else{
                    $protocol = '//';
                }
            }else{
                $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,strpos( $_SERVER["SERVER_PROTOCOL"],'/'))).'://';
            }
            ?>
            <script data-optimize="0" data-no-optimize="1" charset="utf-8" type="text/javascript" src="<?php echo ($protocol.$whitelabel_name); ?>/iframe.js"></script>
    </div>
<?php
get_footer();
?>
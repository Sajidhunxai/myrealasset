<?php
get_header();
$option_404 = st()->get_option('404_text');
$img_404 = st()->get_option('404_img', '');
$bg_color_404 = st()->get_option('404_bg_color', '#fff');
if(check_using_elementor()){ ?>
    <div id="st-content-wrapper" class="st-style-elementor st-404-page" style="background-color: <?php echo esc_attr($bg_color_404); ?>">
        <?php
        $inner_style = '';
        $menu_transparent = st()->get_option('menu_transparent', '');

        if($menu_transparent == 'on'){
            $banner_transparent = st()->get_option('banner_transparent', '');
            if(!empty($banner_transparent)){
                $inner_style = Assets::build_css("background-image: url(" . esc_url($banner_transparent) . ") !important;");
            }
    
            ?>
            <div class="banner st-bg-feature <?php echo esc_attr($inner_style) ?>">
                <div class="container">
                    <div class="st-banner-search-form style_2">
                        <?php 
                            if($img_404){ ?>
                                <img src="<?php echo esc_url($img_404); ?>" alt="404 Page">
                            <?php }else{ ?>
                                <img class="img-404" src="<?php echo get_template_directory_uri() . '/v3/images/404.png' ?>" alt="404 Page">
                            <?php }?>
                            <?php
                            if (!empty($option_404)) {
                                echo st()->get_option('404_text');
                                if($img_404){ ?>
                                    <img src="<?php echo esc_url($img_404); ?>" alt="404 Page">
                                <?php }else{ ?>
                                    <img src="<?php echo get_template_directory_uri() . '/v2/images/404.jpg' ?>" alt="404 Page">
                                <?php }
                            } else {
                                ?>
                                <h1><?php echo __('Oops! Look like you\'re lost', 'traveler'); ?></h1>
                                <h3><?php echo __('Either something went wrong or the page doesn\'t exist anymore.', 'traveler'); ?></h3>
                                
                                <p><a href="<?php echo site_url('/'); ?>"><?php echo __('Go to home', 'traveler'); ?></a></p>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        <?php } else {?>
            <div class="container container-404-style-2">
                <?php 
                if($img_404){ ?>
                    <img src="<?php echo esc_url($img_404); ?>" alt="404 Page">
                <?php }else{ ?>
                    <img class="img-404" src="<?php echo get_template_directory_uri() . '/v3/images/404.png' ?>" alt="404 Page">
                <?php }?>


                <?php
                if (!empty($option_404)) {
                    echo st()->get_option('404_text');
                    if($img_404){ ?>
                        <img src="<?php echo esc_url($img_404); ?>" alt="404 Page">
                    <?php }else{ ?>
                        <img src="<?php echo get_template_directory_uri() . '/v2/images/404.jpg' ?>" alt="404 Page">
                    <?php }
                } else {
                    ?>
                    <h1><?php echo __('Oops! Look like you\'re lost', 'traveler'); ?></h1>
                    <h3><?php echo __('Either something went wrong or the page doesn\'t exist anymore.', 'traveler'); ?></h3>
                    
                    <p><a href="<?php echo site_url('/'); ?>"><?php echo __('Go to home', 'traveler'); ?></a></p>
                    <?php
                }
                ?>
            </div>
        <?php }?>
    </div>
<?php } else { ?>
    <div class="st-404-page" style="background-color: <?php echo esc_attr($bg_color_404); ?>">
    <div class="container">
        <?php
        if (!empty($option_404)) {
            echo st()->get_option('404_text');
            if($img_404){ ?>
                <img src="<?php echo esc_url($img_404); ?>" alt="404 Page">
            <?php }else{ ?>
                <img src="<?php echo get_template_directory_uri() . '/v2/images/404.jpg' ?>" alt="404 Page">
            <?php }
        } else {
            ?>
            <h1><?php echo __('OOPS...', 'traveler'); ?></h1>
            <h3><?php echo __('Something went wrong here :(', 'traveler'); ?></h3>
            <?php if($img_404){ ?>
                <img src="<?php echo esc_url($img_404); ?>" alt="404 Page">
            <?php }else{ ?>
                <img src="<?php echo get_template_directory_uri() . '/v2/images/404.jpg' ?>" alt="404 Page">
            <?php } ?>
            <p><?php echo __('Sorry, we couldn\'t find the page you\'re looking for.&nbsp;', 'traveler'); ?></p>
            <p><strong><?php echo __('Try returning to the', 'traveler'); ?></strong> <a href="<?php echo site_url('/'); ?>"><?php echo __('Homepage', 'traveler'); ?></a></p>
            <?php
        }
        ?>
    </div>
</div>
<?php }
?>

<?php
get_footer();

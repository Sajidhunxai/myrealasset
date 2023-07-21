<?php
get_header();
$option_404 = st()->get_option('404_text', '');
$bg_color_404 = st()->get_option('404_bg_color', '#fff');
$img_404 = st()->get_option('404_img', '');
$class = $img_404 ? 'col-lg-6 col-md-6 col-sm-6 col-xs-12' : 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
?>
<div class="st-404-page--solo" style="background-color: <?php echo esc_attr($bg_color_404); ?>">
    <div class="container">
        <div class="row">
            <div class="item-content <?php echo esc_attr($class); ?>">
                <?php
                if ($option_404) {
                    echo balanceTags($option_404);
                } else {
                    ?>
                    <h1><?php echo __('404, Page Not Found!', 'traveler'); ?></h1>
                    <p><?php echo __("Something's wrong here. You have traveled out of the world", 'traveler'); ?></p>
                    <p><a href="<?php echo site_url('/'); ?>"><?php echo __('BACK TO HOMEPAGE', 'traveler'); ?></a></p>
                <?php } ?>
            </div>
            <?php if ($img_404) { ?>
                <div class="item-img  <?php echo esc_attr($class); ?>">
                    <img src="<?php echo esc_url($img_404); ?>" alt="404 Page">
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php
get_footer();

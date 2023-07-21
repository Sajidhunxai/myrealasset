<?php
/**
 * Created by PhpStorm.
 * User: HanhDo
 * Date: 3/14/2019
 * Time: 10:34 AM
 */
get_header('hotel-activity');
$option_404 = st()->get_option('404_text');
?>
    <div class="st-404-page">
        <div class="container">
            <?php
            if(!empty($option_404)){
                echo st()->get_option('404_text');
            }else{
                ?>
                <h1><?php echo __('OOPS...', 'traveler'); ?></h1>
                <h3><?php echo __('Something went wrong here :(', 'traveler'); ?></h3>
                <img src="<?php echo get_template_directory_uri() . '/v2/images/404.jpg' ?>" alt="404 Page">
                <p><?php echo __('Sorry, we couldn\'t find the page you\'re looking for.&nbsp;', 'traveler'); ?></p>
                <p><strong><?php echo __('Try returning to the', 'traveler'); ?></strong> <a href="<?php echo site_url('/'); ?>"><?php echo __('Homepage', 'traveler'); ?></a></p>
                <?php
            }
            ?>
        </div>
    </div>
<?php
get_footer('hotel-activity');
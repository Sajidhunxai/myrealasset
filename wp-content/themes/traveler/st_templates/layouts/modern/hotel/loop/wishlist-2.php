
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 30-11-2018
 * Time: 10:51 AM
 * Since: 1.0.0
 * Updated: 1.0.0
 */

$data = STUser_f::get_icon_wishlist();

?>
<?php if(is_user_logged_in()){ ?>
    <?php $data = STUser_f::get_icon_wishlist();
    ?>
    <div class="service-add-wishlist login <?php echo ($data['status']) ? 'added' : ''; ?>" data-id="<?php echo get_the_ID(); ?>" data-type="<?php echo get_post_type(get_the_ID()); ?>" title="<?php echo $data['status'] ? __('Remove from wishlist', 'traveler') : __('Add to wishlist', 'traveler'); ?>">
        <i class="fa fa-heart"></i>
        <div class="lds-dual-ring"></div>
    </div>
<?php }else{ ?>
    <a href="#" class="login" data-toggle="modal" data-target="#st-login-form">
        <div class="service-add-wishlist" title="<?php echo __('Add to wishlist', 'traveler'); ?>">
            <i class="fa fa-heart"></i>
            <div class="lds-dual-ring"></div>
        </div>
    </a>
<?php } ?>
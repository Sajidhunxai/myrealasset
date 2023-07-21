<?php
$_purchase_code= get_option('envato_purchasecode');
$has_error = STInput::get('has_error', '');
$has_domain = STInput::get('domain', '');
$deregister = STInput::get('deregister', '');
$has_register = STAdminlandingpage::checkValidatePurchaseCode($_purchase_code);
if(empty($has_error)):
    if(!empty($_purchase_code)){
        if($has_register){
            ?>
            <div class="updated" style="padding: 8px 10px 5px 10px !important; margin-left: 0px; margin-top: 15px;">
                <?php _e('Thank you for registration our theme','traveler')?>
            </div>
            <?php
        }else{
            ?>
            <div class="error" style="padding: 8px 10px 5px 10px !important; margin-left: 0px; margin-top: 15px;">
                <?php _e('Your Purchase Code is invalid','traveler')?>
            </div>
            <?php
        }
    }
    ?>
<?php
else:
    if(in_array($has_error, array('1', '2', '3', '5'))) {
        ?>
        <div class="error" style="padding: 8px 10px 5px 10px !important; margin-left: 0px; margin-top: 15px;">
            <?php
            if ($has_error == '1') {
                _e('Your Purchase Code is empty', 'traveler');
            } elseif ($has_error == '2') {
                _e('Your Purchase Code is invalid', 'traveler');
            } elseif($has_error == '3'){
                _e('Purchase code has been used by another site', 'traveler'); echo ' '.$has_domain;
            } elseif ($has_error == '5'){ 
                _e('Your Purchase Code is invalid','traveler');
            }
            ?>
        </div>
        <?php
    }
endif;
if(in_array($deregister, array('1', '2'))) {
    if($deregister == '1'){
        ?>
        <div class="updated" style="padding: 8px 10px 5px 10px !important; margin-left: 0px; margin-top: 15px;">
            <?php
            _e('Deregistration you purchase code successfully.', 'traveler');
            ?>
        </div>
        <?php
    }else{
        ?>
        <div class="error" style="padding: 8px 10px 5px 10px !important; margin-left: 0px; margin-top: 15px;">
            <?php
            _e('Have an error when you deregister purchase code.', 'traveler');
            ?>
        </div>
        <?php
    }
}
?>
<div class="traveler-registration-steps">
    <div class="feature-section col three-col">
        <div>
            <h4><?php echo __("Purchase code registration", 'traveler') ; ?></h4>
            <form id="traveler_product_registration" method="post" action="<?php echo admin_url('admin.php?page=st_product_reg') ?>">
                <div class="traveler-registration-form">
                    <?php wp_nonce_field( 'traveler_update_registration','traveler_update_registration_nonce' ); ?>
                    <input autocomplete="off" type="text" name="tf_purchase_code" id="tf_purchase_code" placeholder="<?php _e('Enter Themeforest Purchase Code','traveler')?>" value="<?php echo ($_purchase_code) ?>">
                </div>
                <?php if(empty($_purchase_code) or !$has_register){ ?>
                    <input type="hidden" name="st_action" value="save_product_registration">
                    <button class="button button-large button-primary traveler-large-button traveler-register" type="submit"><?php echo __("Submit", 'traveler' ) ; ?></button>
                <?php }else{ ?>
                    <input type="hidden" name="st_action" value="un_save_product_registration">
                    <button class="button button-large button-default traveler-large-button traveler-register" type="submit"><?php echo __("Deregistration", 'traveler' ) ; ?></button>
                <?php } ?>
                <span class="traveler-loader"><i class="dashicons dashicons-update loader-icon"></i><span></span></span>
            </form>
            <a href="https://shinehelp.travelerwp.com/deregistration-purchasecode/" target="_blank" style="font-size:20px">In case you have used your purchase code on other sites before, kindly deregister it first.</a>
        </div>
    </div>
</div>
<br />
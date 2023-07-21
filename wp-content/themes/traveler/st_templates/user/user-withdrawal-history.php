<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User Withdrawal
 *
 * Created by ShineTheme
 *
 */
$html = STWithdrawal::get_list_withdrawal();
?>
<div class="row div-partner-page-title">
    <div class="col-md-12 st-create">
        <h2  class="pull-left"><?php _e("Withdrawal History",'traveler') ?></h2>
    </div>
    <div class="msg"></div>
</div>
<?php
if(!empty($html)) {
    ?>
    <table class="table table-bordered table-striped table-booking-history">
        <thead>
        <tr class="bg-green">
            <th width="10%"><?php _e( "Created" , 'traveler' ) ?></th>
            <th width="10%"><?php _e( "Price" , 'traveler' ) ?></th>
            <th width="20%"><?php _e( "Payment gateway" , 'traveler' ) ?></th>
            <th width="20%"><?php _e( "Payment info" , 'traveler' ) ?></th>
            <th width="10%"><?php _e( "Status" , 'traveler' ) ?></th>
            <th width="10%"><?php _e( "Control" , 'traveler' ) ?></th>
        </tr>
        </thead>
        <tbody id="data_history_withdrawal">
        <?php echo balanceTags($html) ?>
        </tbody>
    </table>
    <span data-per="2" class="btn btn-primary btn_load_his_withdrawal"><?php _e( "Load More" , 'traveler' ) ?></span>
<?php
}else{
    echo '<h5>'.__("No Withdrawal History",'traveler').'</h5>';
}
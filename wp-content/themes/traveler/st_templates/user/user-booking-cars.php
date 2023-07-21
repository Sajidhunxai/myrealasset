<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.1.0
 *
 * User hotel booking
 *
 * Created by ShineTheme
 *
 */
$format = TravelHelper::getDateFormat();
$st_tab = STInput::request('car_type','normal');
$page_link = get_permalink();
?>
<div class="st-create">
    <h2><?php _e("Cars Bookings", 'traveler') ?></h2>

    <?php
    $arr_query_arg = array(
        'sc' => 'booking-cars',
        'scaction' => 'email-notification'
    );
    if (STInput::get('scaction') != 'email-notification') {
        ?>
        <a class="st_button_send_mail" href="<?php echo add_query_arg($arr_query_arg, get_permalink()); ?>"
           class="btn btn-primary btn-sm btn-sendmail-notice-link"
           title="<?php echo __('Send email notification depart date', 'traveler'); ?>"><?php echo __('Send email notification', 'traveler'); ?></a>
    <?php } ?>
</div>
<?php
$paged = get_query_var('paged') ? intval(get_query_var('paged')) : 1;
$limit = 10;
$offset = ($paged - 1) * $limit;
if (STInput::get('scaction') != 'email-notification') {
    if($st_tab == 'normal')
        $data_post = STUser_f::get_history_bookings('st_cars', $offset, $limit, $data->ID);
    else
	    $data_post = STUser_f::get_history_bookings('car_transfer', $offset, $limit, $data->ID);
} else {
	if($st_tab == 'normal')
        $data_post = STUser_f::get_history_bookings_send_mail('st_cars', $offset, $limit, $data->ID);
	else
		$data_post = STUser_f::get_history_bookings_send_mail('car_transfer', $offset, $limit, $data->ID);
}
$posts = $data_post['rows'];
$total = ceil($data_post['total'] / $limit);

if (STInput::get('scaction') == 'email-notification') {
    echo st()->load_template('user/user-booking-cars', 'email', array('posts' => $posts, 'offset' => $offset));
} else {
    ?>
    <?php 
    $screen = "st_cars";
    do_action('export_booking_history_button',$screen) ?>
    <div class="form-group list-car-type st_button_send_mail">
        <a href="<?php echo add_query_arg('car_type', 'normal', TravelHelper::get_user_dashboared_link($page_link, 'booking-cars')) ?>" class="<?php if($st_tab=="normal") echo "current"; ?>"><i class="fa fa-car"></i> <?php echo __('Car normal', 'traveler'); ?></a>&nbsp; &nbsp; &nbsp;
        <a href="<?php echo add_query_arg('car_type', 'transfer', TravelHelper::get_user_dashboared_link($page_link, 'booking-cars')) ?>" class="<?php if($st_tab=="transfer") echo "current"; ?>"><i class="fa fa-tachometer"></i> <?php echo __('Car transfer', 'traveler'); ?></a>
    </div>
<div class="infor-st-setting">
    <table class="table table-bordered table-striped table-booking-history">
        <thead>
        <tr>
            <th class="hidden-xs"><?php echo __('#ID', 'traveler'); ?></th>
            <th class="hidden-xs"><?php _e("Customer", 'traveler') ?></th>
            <th><?php _e("Car Name", 'traveler') ?></th>
            <th class="hidden-xs"><?php _e("From/To date", 'traveler') ?></th>
            <th class="hidden-xs"><?php _e("Price", 'traveler') ?></th>
            <th class="hidden-xs" width="10%"><?php _e("Order Date", 'traveler') ?></th>
            <th><?php _e("Status", 'traveler') ?></th>
            <th width="10%"><?php _e("Action", 'traveler') ?></th>
            <?php do_action('export_booking_item_title') ?>
        </tr>
        </thead>
        <tbody id="data_history_book booking-history-title">
        <?php if (!empty($posts)) {
            $i = 1 + $offset;
            foreach ($posts as $key => $value) {
                $post_id = $value->wc_order_id;
                $item_id = $value->st_booking_id;
                ?>
                <tr>
                    <td class="hidden-xs"><?php echo esc_attr($value->wc_order_id); ?></td>
                    <td class="booking-history-type hidden-xs">
                        <?php
                        if ($post_id) {
                            $name = get_post_meta($post_id, 'st_first_name', true);
                            if (!empty($name)) {
                                $name .= " " . get_post_meta($post_id, 'st_last_name', true);
                            }
                            if (!$name) {
                                $name = get_post_meta($post_id, 'st_name', true);
                            }
                            if (!$name) {
                                $name = get_post_meta($post_id, 'st_email', true);
                            }
                            if (!$name) {
                                $name = get_post_meta($post_id, '_billing_first_name', true);
                                $name .= " " . get_post_meta($post_id, '_billing_last_name', true);
                            }
                            echo esc_html($name);
                        }
                        ?>
                    </td>
                    <td class=""> <?php
                        if ($item_id) {
                            if ($item_id) {
                                echo "<a href='" . esc_attr(get_the_permalink($item_id)) . "' target='_blank'>" . esc_html(get_the_title($item_id)) . "</a>";
                            }
                        }
                        ?>
                    </td>
                    <td class="hidden-xs">
                        <?php $date = $value->check_in;
                        if ($date) echo date('d/m/Y', strtotime($date)); ?><br>
                        <i class="fa fa-long-arrow-right"></i><br>
                        <?php $date = $value->check_out;
                        if ($date) echo date('d/m/Y', strtotime($date)); ?>
                    </td>
                    <td class="hidden-xs"> <?php
                        if ($value->type == "normal_booking") {
                            $total_price = get_post_meta($post_id, 'total_price', true);
                        } else {
                            $total_price = get_post_meta($post_id, '_order_total', true);
                        }

                        $currency = TravelHelper::_get_currency_book_history($post_id);
                        echo TravelHelper::format_money_raw($total_price, $currency);
                        ?>
                    </td>
                    <td class="hidden-xs"><?php echo date_i18n($format, strtotime($value->created)) ?></td>
                    <td class="">
                        <?php
                        $data_status = STUser_f::_get_order_statuses();
                        $status = 'pending';
                        if ($value->type == "normal_booking") {
                            $status = esc_html(get_post_meta($value->order_item_id, 'status', true));
                        } else {
                            $status = esc_html($value->status);
                        }
                        $data_status_all = STUser_f::_get_all_order_statuses();
                        $status_string = '';
                        if(array_key_exists($status, $data_status)){
	                        $status_string = $data_status[$status];
                        }else{
	                        if(array_key_exists($status, $data_status_all)){
		                        $status_string = $data_status_all[$status];
	                        }
                        }
                        switch ( $status_string ) {
                            case "Pending":
                            $status_string = '<span style="color:#E02020">'.__( 'Pending', 'traveler' ).'</span>';
                            break;
                            case "Completed":
                            $status_string = '<span style="color:#10CD78">'.__( 'Completed', 'traveler' ).'</span>';
                            break;
                            case "Incomplete":
                            $status_string = '<span style="color:#FFAD19">'.__( 'Incomplete', 'traveler' ).'</span>';
                            break;
                            case "Cancelled":
                            $status_string = '<span style="color:#7A7A7A">'.__( 'Cancelled', 'traveler' ).'</span>';
                            break;
                            default:
                        }
                        echo '<span class="suser-status">' . balanceTags($status_string) . '</span>';
                        if(($status == 'incomplete' || $status == 'pending' || $status == 'wc-processing' || $status == 'wc-on-hold') && (in_array('administrator',  wp_get_current_user()->roles)) ){
                            ?>
                            <a data-order-id="<?php echo esc_attr($value->order_item_id) ?>" data-id="<?php echo esc_attr($value->id); ?>" href="#" class="suser-approve"><?php echo __('Approve', 'traveler'); ?> </a>
                            <div class="suser-message"><div class="spinner"></div></div>
                        <?php } ?>
                    </td>
                    <td class="">
                        <a data-toggle="modal" data-target="#info-booking-modal"
                           class="btn btn-xs btn-primary mt5 btn-info-booking"
                           data-service_id='<?php echo esc_html($item_id) ?>'
                           data-order_id="<?php echo esc_html($post_id) ?>" href="javascript: void(0);"><i
                                    class="fa fa-info-circle"></i><span class="hidden-xs"><?php _e('Details', 'traveler') ?></span></a>
                    </td>
                    <?php do_action( 'export_booking_item_buttons', $value->order_item_id ); ?>
                </tr>
                <?php
                $i++;
            }
        } else {
            echo '<h5>' . __('No Car', 'traveler') . '</h5>';
        }
        ?>
        </tbody>
    </table>
</div>
<?php } ?>
<?php st_paging_nav('', null, $total) ?>
<div class="modal fade modal-cancel-booking modal-info-booking" id="info-booking-modal" tabindex="-1" role="dialog"
     aria-labelledby="cancelBookingLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="<?php echo __('Close', 'traveler'); ?>"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="cancelBookingLabel"><?php echo __('Booking Details', 'traveler'); ?></h4>
            </div>
            <div class="modal-body">
                <div style="display: none;" class="overlay-form"><i class="fa fa-spinner text-color"></i></div>
                <div class="modal-content-inner"></div>
            </div>
        </div>
    </div>
</div>

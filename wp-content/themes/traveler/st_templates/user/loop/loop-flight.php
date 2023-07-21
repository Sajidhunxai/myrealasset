<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User loop tours
 *
 * Created by ShineTheme
 *
 */

$status = get_post_status(get_the_ID());
$icon_class = STUser_f::st_get_icon_status_partner();
$page_my_account_dashboard = st()->get_option('page_my_account_dashboard');
?>
<li <?php post_class() ?>>
    <a rel="tooltip" data-original-title="<?php st_the_language('user_edit') ?>"
       href="<?php echo esc_url(add_query_arg(array('sc' => 'edit-flight', 'id' => get_the_ID()), get_the_permalink($page_my_account_dashboard))) ?>"
       class="btn_remove_post_type cursor fa fa-edit booking-item-wishlist-remove"
       style="background: #ed8323 ; color: #fff"></a>
    <a data-id="<?php the_ID() ?>" data-id-user="<?php echo esc_attr($data['ID']) ?>" data-placement="top" rel="tooltip"
       class="btn_remove_post_type cursor fa fa-times booking-item-wishlist-remove"
       data-original-title="<?php st_the_language('user_remove') ?>" style="top:60px;"></a>
   
    

    <a data-id="<?php the_ID() ?>" data-id-user="<?php echo esc_attr($data['ID']) ?>"
       data-status="<?php if ($status == 'trash') echo "on"; else echo 'off'; ?>" data-placement="top" rel="tooltip"
       class="btn_on_off_post_type_partner cursor fa <?php if ($status == 'trash') echo "fa-eye-slash"; else echo 'fa-eye'; ?> booking-item-wishlist-remove"
       data-original-title="<?php _e("On/Off", 'traveler') ?>" style="top:60px"></a>

    <div class="spinner user_img_loading ">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
    <div <?php post_class('booking-item') ?>>
        <div class="row">
            <div class="col-md-2 st-flight-ccv">
                <?php
                $airline = get_post_meta(get_the_ID(), 'airline', true);
                if (!empty($airline)) {
                    $logo = get_tax_meta($airline, 'airline_logo');
                    echo wp_get_attachment_image($logo);
                }
                ?>
            </div>
            <div class="col-md-10">
                <div class="color-inherit">
                    <a href="<?php the_permalink() ?>">
                        <?php
                        $origin = get_post_meta(get_the_ID(), 'origin', true);
                        $destination = get_post_meta(get_the_ID(), 'destination', true);
                        $location_origin = get_tax_meta($origin, 'location_id');
                        $origin_iata = get_tax_meta($origin, 'iata_airport');
                        $location_des = get_tax_meta($destination, 'location_id');
                        $destination_iata = get_tax_meta($destination, 'iata_airport');
                        if (!empty($location_origin) && !empty($location_des)) {
                            echo '<h5 class="booking-item-title">' . esc_html(get_the_title($location_origin) . ' (' . $origin_iata . ') - ' . get_the_title($location_des) . ' (' . $destination_iata) . ')</h5>';
                        }
                        ?>
                    </a>
                    <p class="booking-item-address">
                        <?php $flight_type = get_post_meta(get_the_ID(), 'flight_type', true);
                        $types = array(
                            'direct' => esc_html__('Direct', 'traveler'),
                            'one_stop' => esc_html__('One stop', 'traveler'),
                            'two_stops' => esc_html__('Two stop', 'traveler')
                        );
                        if (!empty($types[$flight_type])) {
                            echo '<i class="fa fa-plane"></i> ' . esc_html__('Flight type: ', 'traveler') . esc_html($types[$flight_type]);
                        }
                        ?>
                    </p>
                    <p class="package-info">
                        <?php $depart_time = get_post_meta(get_the_ID(), 'departure_time', true) ?>
                        <i class="fa fa-clock-o"></i>
                        <span class=""><?php echo esc_html__('Departure time') ?> : </span>
                        <?php echo strtoupper($depart_time) ?>
                    </p>
                    <div class="package-info">
                        <?php $total_time = get_post_meta(get_the_ID(), 'total_time', true) ?>
                        <i class="fa fa-clock-o"></i>
                        <span class=""><?php echo esc_html__('Total time') ?> : </span>
                        <?php echo esc_html($total_time['hour']) . esc_html__('h ', 'traveler') . esc_html($total_time['minute']) . esc_html__('m', 'traveler'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</li>


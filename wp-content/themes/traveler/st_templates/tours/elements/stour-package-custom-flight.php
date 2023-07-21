<?php
$tour_package_custom = get_post_meta($post_id, 'tour_packages_custom_flight', true);
?>
<div class="custom-hotel-data-item">
    <table class="wp-list-table widefat fixed striped stour-list-custom-hotel" data-type="flight">
        <thead>
        <tr>
            <td class="manage-column column-cb check-column"></td>
            <td><?php echo __('Origin/Destination', 'traveler'); ?></td>
            <td><?php echo __('Departure time', 'traveler'); ?></td>
            <td><?php echo __('Duration', 'traveler'); ?></td>
            <td><?php echo __('Price', 'traveler'); ?></td>
        </tr>
        </thead>
        <tbody>
        <tr class="parent-row">
            <td>
                <a href="#del-item" class="hotel-del">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </a>
            </td>
            <td data-name="<?php echo __('Origin/Destination', 'traveler'); ?>">
                <input type="text" class="flight-origin" value=""/>
                <br />
                <i class="fa fa-long-arrow-right"></i>
                <br />
                <input type="text" class="flight-destination" value=""/>
            </td>
            <td data-name="<?php echo __('Departure time', 'traveler'); ?>"><input type="text" class="flight-depature-time" value=""/></td>
            <td data-name="<?php echo __('Duration', 'traveler'); ?>"><input type="text" class="flight-duration" value=""/></td>
            <td data-name="<?php echo __('Price', 'traveler'); ?>">
               <label><?php echo __('Economy', 'traveler') ?><br /><input type="text" class="flight-price-economy" value=""/></label>
                <label><?php echo __('Business', 'traveler') ?><br /><input type="text" class="flight-price-business" value=""/></label>
            </td>
        </tr>
        <?php
        if(is_object($tour_package_custom)) {
            if (!empty((array)$tour_package_custom)) {
                foreach ($tour_package_custom as $k => $v) {
                    ?>
                    <tr>
                        <td>
                            <a href="#del-item" class="hotel-del">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                        </td>
                        <td data-name="<?php echo __('Origin/Destination', 'traveler'); ?>">
                            <input type="text" class="flight-origin" value="<?php echo esc_html($v->flight_origin); ?>"/>
                            <br />
                            <i class="fa fa-long-arrow-right"></i>
                            <br />
                            <input type="text" class="flight-destination" value="<?php echo esc_html($v->flight_destination); ?>"/>
                        </td>
                        <td data-name="<?php echo __('Departure time', 'traveler'); ?>"><input type="text" class="flight-depature-time" value="<?php echo esc_html($v->flight_departure_time); ?>"/></td>
                        <td data-name="<?php echo __('Duration', 'traveler'); ?>"><input type="text" class="flight-duration" value="<?php echo esc_html($v->flight_duration); ?>"/></td>
                        <td data-name="<?php echo __('Price', 'traveler'); ?>">
                            <label><?php echo __('Economy', 'traveler') ?><br /><input type="text" class="flight-price-economy" value="<?php echo esc_html($v->flight_price_economy); ?>"/></label>
                            <label><?php echo __('Business', 'traveler') ?><br /><input type="text" class="flight-price-business" value="<?php echo esc_html($v->flight_price_business); ?>"/></label>
                        </td>
                    </tr>
                    <?php
                }
            }
        }
        ?>
        </tbody>
    </table>
    <input type="submit" class="option-tree-ui-button button button-primary btn-add-custom-package btn btn-primary btn-sm"
           value="<?php echo __('Add new', 'traveler'); ?>">
</div>

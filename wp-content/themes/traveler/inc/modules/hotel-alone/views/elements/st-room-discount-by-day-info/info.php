<?php

extract($atts);

$discount_by_day = get_post_meta( get_the_ID(), 'discount_by_day', true);

$discount_type = get_post_meta( get_the_ID(), 'discount_type_no_day', true);

if( !$discount_type || $discount_type == 'percent' )

    $discount_type = '%';

else $discount_type = TravelHelper::get_current_currency('symbol');

if( !empty( $discount_by_day ) ){

?>



<div class="helios-room-facilities-info">

    <div class="title">

        <?php echo esc_html($title) ?>

    </div>

    <div class="info">

        <div class="list-discount-by-day">

            <table class="table">

                <tr>

                    <th>#</th>

                    <th><?php echo __('Package', 'traveler'); ?></th>

                    <th><?php echo __('No. day (s)', 'traveler'); ?></th>

                    <th><?php echo __('Discount','traveler'); ?> <?php if( $discount_type ) echo '( '. $discount_type . ' )'; ?></th>

                </tr>

                <?php $i = 1; foreach( $discount_by_day as $item ): ?>

                    <tr>

                        <td><?php echo esc_html($i); ?></td>

                        <td><?php echo esc_html($item['title']); ?></td>

                        <td><?php echo esc_html($item['number_day']); ?></td>

                        <td><?php echo esc_html($item['discount']); ?></td>

                    </tr>

                    <?php $i++; endforeach; ?>

            </table>

        </div>

    </div>

</div>

<?php } ?>
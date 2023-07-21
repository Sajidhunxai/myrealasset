<?php $discount_by_day = !empty(get_post_meta(get_the_ID(),'discount_by_day')) ? get_post_meta(get_the_ID(),'discount_by_day',true) : '';
if(!empty($discount_by_day)){
    $discount_type_no_day = !empty(get_post_meta(get_the_ID(),'discount_type_no_day')) ? get_post_meta(get_the_ID(),'discount_type_no_day',true) : '';
    if($discount_type_no_day == 'percent'){
        $text_discount_type_no_day = __('by Percent','traveler');
    } else {
        $text_discount_type_no_day = __('by Amount','traveler');
    }
    ?>
    <div class="st-hr large"></div>
    <div class="accordion-item stt-discount">
        <h2 class="st-heading-section">
            <?php echo __('Bulk discount', 'traveler') .' ('.esc_html($text_discount_type_no_day).')'; ?>
        </h2>
        <div class="st-program">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"><?php echo esc_html__('Discount group','traveler');?></th>
                    <th scope="col"><?php echo esc_html__('From No. days','traveler');?></th>
                    <th scope="col"><?php echo esc_html__('To No. days', 'traveler');?></th>
                    <th scope="col"><?php echo esc_html__('Value', 'traveler');?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($discount_by_day as $key=>$discount_day){?>
                    <tr>
                        <th scope="row"><?php echo intval($key + 1)?></th>
                        <td><?php echo esc_html(!empty($discount_day['title']) ? $discount_day['title'] : '');?></td>
                        <td><?php echo esc_html(!empty($discount_day['number_day'])? $discount_day['number_day'] : '');?></td>
                        <td><?php echo esc_html(!empty($discount_day['number_day_to']) ? $discount_day['number_day_to'] : '');?></td>
                        <td>
                            <?php
                                if($discount_type_no_day == 'percent'){
                                    echo floatval($discount_day['discount']).'%';
                                } else {
                                    echo TravelHelper::format_money(!empty($discount_day['discount']) ? $discount_day['discount'] : 0);
                                }
                            ?>    
                        </td>
                    </tr>
                <?php }
                ?>

                </tbody>
            </table>
        </div>
    </div>
<?php }?>
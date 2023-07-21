<!--Table Discount group -->
<?php
    $discount_by_day = !empty(get_post_meta(get_the_ID(),'discount_by_day')) ? get_post_meta(get_the_ID(),'discount_by_day',true) : '';
    if(!empty($discount_by_day)){
        $discount_type_no_day = !empty(get_post_meta(get_the_ID(),'discount_type_no_day')) ? get_post_meta(get_the_ID(),'discount_type_no_day',true) : '';
        if($discount_type_no_day == 'percent'){
            $text_discount_type_no_day = __('by Percent','traveler');
        } else {
            $text_discount_type_no_day = __('by Amount','traveler');
        }
    ?>
        <div class="st-program">
            <div class="st-title-wrapper">
                <h3 class="st-section-title"><?php echo __('Discount by number of days', 'traveler').' ('.$text_discount_type_no_day.')'; ?></h3>
            </div>
            <?php if(!empty($discount_by_day)){?>
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
                            foreach($discount_by_day as $key=>$discount){
                                ?>
                                <tr>
                                    <th scope="row"><?php echo intval($key + 1)?></th>
                                    <td><?php echo esc_html($discount['title']);?></td>
                                    <td><?php echo esc_html($discount['number_day']);?></td>
                                    <td><?php echo esc_html($discount['number_day_to']);?></td>
                                    <td>
                                    <?php
                                        if($discount_type_no_day == 'percent'){
                                            echo esc_html($discount['discount']).'%';
                                        } else {
                                            echo TravelHelper::format_money($discount['discount']);
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php }
                        ?>
                        
                    </tbody>
                </table>
            <?php }?>
        </div>
    <?php }?>
<!--End Table Discount group -->
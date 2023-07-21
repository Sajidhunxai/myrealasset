<?php

$langs=icl_get_languages('skip_missing=0');

$currency_list = st()->get_option('booking_currency');

$mapping_currency = get_option('mapping_currency_' . ICL_LANGUAGE_CODE);

?>

<div class="">

    <!--<button class="btn btn-primary"><?php echo __('Reload', 'traveler'); ?></button>-->

    <div class="mapping-currency">

        <div class="row-mapping">

            <div class="col-mapping-lang mapping-lang-head">

                <?php echo __('Languages', 'traveler'); ?>

            </div>

            <div class="col-mapping-currency mapping-currency-head">

                <?php echo __('Default currency', 'traveler'); ?>

            </div>

        </div>

        <?php $i = 0; foreach ($langs as $item): ?>

            <div class="row-mapping-content" data-lang-code="<?php echo esc_attr($item['language_code']); ?>">

                <div class="col-mapping-lang" >

                    <img src="<?php echo esc_attr($item['country_flag_url']); ?>" class="img-responsive"/>

                    <?php echo esc_attr($item['native_name']); ?>

                    <?php echo '( ' . $item['language_code'] . ' ) '; ?>

                </div>

                <div class="col-mapping-currency" >

                    <div class="">

                        <?php

                        $cur_option = '';

                        if(!empty($mapping_currency)) {

                            $cur = $mapping_currency[$i][0];

                            if ($cur == $item['language_code']) {

                                $cur_option = $mapping_currency[$i][1];

                            }

                        }

                        ?>

                        <select name="" class="mapping-currency-list">

                            <option value="-1"><?php echo __('--- Select currency ---'); ?></option>

                            <?php

                            foreach ($currency_list as $item_currency){

                                if($item_currency['name'] == $cur_option){

                                    echo '<option selected value="'. $item_currency['name'] .'">'. $item_currency['name'] .'</option>';

                                }else{

                                    echo '<option value="'. $item_currency['name'] .'">'. $item_currency['name'] .'</option>';

                                }

                            }

                            ?>

                        </select>

                        <span class="spinner mapping-loading"></span>

                    </div>

                </div>

            </div>

            <?php $i++;  endforeach; ?>

    </div>

</div>
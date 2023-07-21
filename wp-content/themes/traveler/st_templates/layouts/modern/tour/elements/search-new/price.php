<?php

if (!isset($position))
    $position = '';
$price_range = STInput::request('price_range');
$class_hide_render = '';
if (!empty($price_range)) {
    $price_range = explode(';', $price_range);
    if (!empty($price_range[0])) {
        $price_min = $price_range[0];
    }
    if (!empty($price_range[1])) {
        $price_max = $price_range[1];
    }
} else {
    $class_hide_render = 'hide';
    $price_min = '';
    $price_max = '';
}

?>
<div class=" form-group form-extra-field dropdown clearfix st-price-field ">
    <?php
    if ( $has_icon ) {
        echo TravelHelper::getNewIcon('coin-price','#5E6D77');
    }
    ?>
    <div class="dropdown" data-toggle="dropdown" id="dropdown-price">
        <?php ?>
        <label class=" label <?php echo ($class_hide_render == 'hide') ? '' : 'hide' ?>"><?php echo __('Price', 'traveler'); ?></label>
        <div class="render <?php echo esc_attr($class_hide_render) ?>">
                    <span><?php echo TravelHelper::get_current_currency('symbol'); ?><span
                                class="price-min"><?php echo esc_html($price_min) ?></span>
                    <span><?php echo esc_html__('-', 'traveler'); ?></span>
                    <span><?php echo TravelHelper::get_current_currency('symbol'); ?></span><span
                                class="price-max"><?php echo esc_html($price_max) ?></span></span>
        </div>
        <?php ?>

    </div>
    <div class="dropdown-menu" aria-labelledby="dropdown-price">
        <div class="row">
            <div class="col-lg-12">
                <?php
                $data_min_max = TravelerObject::get_min_max_price('st_tours');
                $max = ((float)$data_min_max['price_max'] > 0) ? (float)$data_min_max['price_max'] : 0;
                $min = ((float)$data_min_max['price_min'] > 0) ? (float)$data_min_max['price_min'] : 0;

                $rate_change = false;
                if (TravelHelper::get_default_currency('rate') != 0 and TravelHelper::get_default_currency('rate')) {
                    $rate_change = TravelHelper::get_current_currency('rate') / TravelHelper::get_default_currency('rate');
                    $max = round($rate_change * $max);
                    if ((float)$max < 0) $max = 0;

                    $min = round($rate_change * $min);
                    if ((float)$min < 0) $min = 0;
                }
                $value_show = $min . ";" . $max; // default if error

                if ($rate_change) {
                    if (STInput::request('price_range')) {
                        $price_range = explode(';', STInput::request('price_range'));

                        $value_show = $price_range[0] . ";" . $price_range[1];
                    } else {

                        $value_show = $min . ";" . $max;
                    }
                }
                ?>
                <div class="price-item range-slider">
                    <div class="item-title">
                        <h4><?php echo esc_html__('Filter Price', 'traveler') ?></h4>
                    </div>
                    <div class="item-content">
                        <input type="text" class="price_range" name="price_range"
                               value="<?php echo esc_attr($value_show); ?>"
                               data-symbol="<?php echo TravelHelper::get_current_currency('symbol'); ?>"
                               data-min="<?php echo esc_attr($min); ?>"
                               data-max="<?php echo esc_attr($max); ?>"
                               data-step="<?php echo st()->get_option('search_price_range_step', 0); ?>"/>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

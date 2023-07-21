<?php
$data_min_max = TravelerObject::get_min_max_price('st_rental');
$start = STInput::get('start');
$end = STInput::get('end');
$start = TravelHelper::convertDateFormat($start);
$end = TravelHelper::convertDateFormat($end);
$numberday = (STDate::dateDiff($start, $end) == 0) ? 1 : STDate::dateDiff($start, $end) ;
$max = ((float)$data_min_max['price_max'] > 0) ? (float)$data_min_max['price_max'] : 0;
$min = ((float)$data_min_max['price_min'] > 0) ? (float)$data_min_max['price_min'] : 0;

$value_show = $min*$numberday . ";" . $max*$numberday; // default if error

if (STInput::request('price_range')) {
        $price_range = explode(';', STInput::request('price_range'));

        $value_show = $price_range[0]*$numberday . ";" . $price_range[1]*$numberday;
    } else {

        $value_show = $min*$numberday . ";" . $max*$numberday;
    }
?>
<li class="filter-price">
    <div class="form-extra-field">
        <button class="btn btn-link dropdown" type="button" id="dropdownMenuFilterPrice" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
            <span data-text="<?php echo esc_attr($title); ?>"><?php echo esc_html($title); ?></span> <span class="stt-icon stt-icon-arrow-down"></span>
        </button>
        <div class="dropdown-menu range-slider" aria-labelledby="dropdownMenuFilterPrice">
            <div class="dropdown-title"><?php echo esc_html__('Filter price', 'traveler'); ?></div>
            <input type="text" class="price_range" name="price_range" value="<?php echo esc_attr($value_show); ?>" data-symbol="<?php echo TravelHelper::get_current_currency('symbol'); ?>" data-min="<?php echo esc_attr($min*$numberday); ?>" data-max="<?php echo esc_attr($max*$numberday); ?>" data-step="<?php echo st()->get_option('search_price_range_step',0); ?>"/>
            <div class="min-max-value">
                <div class="item-value">
                    <?php echo esc_html__('Min price', 'traveler'); ?>
                    <span><?php echo esc_html(TravelHelper::format_money(((float)$data_min_max['price_min']*$numberday > 0) ? (float)$data_min_max['price_min']*$numberday : 0)); ?></span>
                </div>
                <div class="item-value">
                    <?php echo esc_html__('Max price', 'traveler'); ?>
                    <span><?php echo esc_html(TravelHelper::format_money(((float)$data_min_max['price_max']*$numberday > 0) ? (float)$data_min_max['price_max']*$numberday : 0)); ?></span>
                </div>
            </div>
            <div class="price-action">
                <a href="javascript:void(0);" class="clear-price"><?php echo esc_html__('Clear', 'traveler'); ?></a>
                <button class="btn btn-link btn-apply-price-range"><?php echo __('Apply', 'traveler'); ?></button>
            </div>
        </div>
    </div>
</li>

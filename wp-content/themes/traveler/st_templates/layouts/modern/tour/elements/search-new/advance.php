<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 13-11-2018
 * Time: 3:00 PM
 * Since: 1.0.0
 * Updated: 1.0.0
 */

if(!isset($position))
    $position = '';
?>
<div class="form-button">
    <div class="advance advance-new">
        <div class=" form-extra-field dropdown clearfix field-advance">
            <div class="dropdown" data-toggle="dropdown" id="dropdown-advance">
                <?php if($position != 'sidebar'){ ?>
                    <label class="hidden-xs"><?php echo __('Advance', 'traveler'); ?></label>
                    <div class="render">
                        <span class="hidden-xs"><?php echo __('More', 'traveler'); ?> <i class="fa fa-caret-down"></i></span>
                        <span class="hidden-lg hidden-md hidden-sm"><?php echo __('More option', 'traveler'); ?> <i
                                class="fa fa-caret-down"></i></span>
                    </div>
                <?php }else{ ?>
                    <div class="render">
                        <span><?php echo __('More option', 'traveler'); ?> <i class="fa fa-caret-down"></i></span>
                    </div>
                <?php } ?>
            </div>
            <div class="dropdown-menu" aria-labelledby="dropdown-advance">
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $data_min_max = TravelerObject::get_min_max_price( 'st_tours' );
                        $max          = ( (float)$data_min_max[ 'price_max' ] > 0 ) ? (float)$data_min_max[ 'price_max' ] : 0;
                        $min          = ( (float)$data_min_max[ 'price_min' ] > 0 ) ? (float)$data_min_max[ 'price_min' ] : 0;

                        $rate_change = false;
                        if ( TravelHelper::get_default_currency( 'rate' ) != 0 and TravelHelper::get_default_currency( 'rate' ) ) {
                            $rate_change = TravelHelper::get_current_currency( 'rate' ) / TravelHelper::get_default_currency( 'rate' );
                            $max         = round( $rate_change * $max );
                            if ( (float)$max < 0 ) $max = 0;

                            $min = round( $rate_change * $min );
                            if ( (float)$min < 0 ) $min = 0;
                        }
                        $value_show = $min . ";" . $max; // default if error

                        if ( $rate_change ) {
                            if ( STInput::request( 'price_range' ) ) {
                                $price_range = explode( ';', STInput::request( 'price_range' ) );

                                $value_show = $price_range[ 0 ] . ";" . $price_range[ 1 ];
                            } else {

                                $value_show = $min . ";" . $max;
                            }
                        }
                        ?>
                        <div class="advance-item range-slider">
                            <div class="item-title">
                                <h4><?php echo esc_html__( 'Filter Price', 'traveler' ) ?></h4>
                            </div>
                            <div class="item-content">
                                <input type="text" class="price_range" name="price_range"
                                       value="<?php echo esc_attr($value_show); ?>"
                                       data-symbol="<?php echo TravelHelper::get_current_currency( 'symbol' ); ?>"
                                       data-min="<?php echo esc_attr( $min ); ?>"
                                       data-max="<?php echo esc_attr( $max ); ?>"
                                       data-step="<?php echo st()->get_option( 'search_price_range_step', 0 ); ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="advance-item facilities st-icheck">
                            <?php
                            $search_tax_advance = st()->get_option( 'attribute_search_form_tour', 'st_tour_type' );
                            $get_label_tax = get_taxonomy($search_tax_advance);
                            $tax = STInput::get('taxonomy');
                            $in_facilities = [];
                            $temp_facilities = '';
                            if(!empty($tax)){
                                if(isset($tax[$search_tax_advance])){
                                    if(!empty($tax[$search_tax_advance])){
                                        $temp_facilities = $tax[$search_tax_advance];
                                        $in_facilities = explode(',', $tax[$search_tax_advance]);
                                    }
                                }
                            }
                            ?>
                            <div class="item-title">
                                <?php
                                    if(!empty($get_label_tax)){
                                        echo '<h4>'.esc_html($get_label_tax->label).'</h4>';
                                    }
                                ?>
                            </div>
                            <div class="item-content">
                                <div class="row">
                                    <div class="ovscroll" tabindex="1">
                                        <?php
                                        $facilities = get_terms(
                                            [
                                                'taxonomy'   => $search_tax_advance,
                                                'hide_empty' => false
                                            ]
                                        );
                                        if ( !is_wp_error($facilities) ) {
                                            foreach ( $facilities as $term ) {
                                                ?>
                                                <div class="<?php echo ($position == 'sidebar') ? 'col-lg-12' : 'col-lg-4 col-sm-6'; ?>">
                                                    <div class="st-icheck-item">
                                                        <label><?php echo esc_html($term->name); ?><input
                                                                type="checkbox"
                                                                name="" value="<?php echo esc_attr($term->term_id); ?>" <?php echo in_array($term->term_id, $in_facilities) ? 'checked' : ''; ?>><span
                                                                class="checkmark fcheckbox"></span>
                                                        </label></div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" class="data_taxonomy" name="taxonomy[st_tour_type]" value="<?php echo esc_attr($temp_facilities); ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

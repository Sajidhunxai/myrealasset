<?php
$has_icon = ( isset( $has_icon ) ) ? $has_icon : false;
$tax = STInput::get('taxonomy');
$temp_facilities = '';
if(!empty($tax)){
    if(isset($tax['durations'])){
        if(!empty($tax['durations'])){
            $temp_facilities = $tax['durations'];
            $tour_type = get_term($temp_facilities,'durations');
            $tour_type_name = $tour_type->name;

        }
    }
}

$facilities = get_terms(
    [
        'taxonomy'   => 'durations',
        'hide_empty' => false
    ]
);

?>
<div class="form-group form-extra-field dropdown clearfix field-durations ">
    <?php
    if ( $has_icon ) {
        echo TravelHelper::getNewIcon('ico_clock','#5E6D77','24px' ,'24px');

    }
    ?>
    <div class="dropdown" data-toggle="dropdown" id="dropdown-durations">
        <div class="render render-new">
            <span class="durations">
                <?php
                if(empty($temp_facilities)) {
                    ?>
                    <label class="label"><?php echo esc_html__( 'Duration', 'traveler' ); ?></label>
                    <?php
                }else{
                    echo esc_html($tour_type_name);
                }
                ?>
            </span>
        </div>
        <input type="hidden" class="data_taxonomy" name="taxonomy[durations]" value="<?php echo esc_attr($temp_facilities); ?>">
    </div>
    <ul class="dropdown-menu" aria-labelledby="dropdown-durations">
        <?php
        foreach ($facilities as $value){
            ?>
            <li class="item" data-value="<?php echo esc_attr($value->term_id); ?>">
                <span><?php echo esc_attr($value->name); ?></span></li>
            </li>
            <?php
        }
        ?>
    </ul>

</div>


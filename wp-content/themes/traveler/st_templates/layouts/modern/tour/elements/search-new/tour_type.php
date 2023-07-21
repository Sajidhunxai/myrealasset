<?php
$has_icon = ( isset( $has_icon ) ) ? $has_icon : false;
$tax = STInput::get('taxonomy');
$temp_facilities = '';
if(!empty($tax)){
    if(isset($tax['st_tour_type'])){
        if(!empty($tax['st_tour_type'])){
            $temp_facilities = $tax['st_tour_type'];
            $tour_type = get_term($temp_facilities,'st_tour_type');
            $tour_type_name = $tour_type->name;

        }
    }
}

$facilities = get_terms(
    [
        'taxonomy'   => 'st_tour_type',
        'hide_empty' => false
    ]
);

?>
<div class="form-group form-extra-field dropdown clearfix field-tour-type ">
    <?php
    if ( $has_icon ) {
        echo TravelHelper::getNewIcon('ico_tour_type','#5E6D77');
    }
    ?>
    <div class="dropdown" data-toggle="dropdown" id="dropdown-tour-type">

        <div class="render render-new">
            <span class="tour-type">
                <?php
                if(empty($temp_facilities)) {
                    ?>
                    <label class="label"><?php echo esc_html__( 'Tour Type', 'traveler' ); ?></label>
                    <?php
                }else{
                    echo esc_html($tour_type_name);
                }
                ?>
            </span>
        </div>
        <input type="hidden" class="data_taxonomy" name="taxonomy[st_tour_type]" value="<?php echo esc_attr($temp_facilities); ?>">
    </div>
    <ul class="dropdown-menu" aria-labelledby="dropdown-tour-type">
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


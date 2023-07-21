<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Activity element search check in
 *
 * Created by ShineTheme
 *
 */
wp_enqueue_script( 'bootstrap-datepicker.js' ); wp_enqueue_script( 'bootstrap-datepicker-lang.js' ); 

$default=array(
    'title'=>'',
    'is_required'=>'',
    'placeholder'=> ''
);

if(isset($data)){
    extract(wp_parse_args($data,$default));
}else{
    extract($default);
}

if(!isset($field_size)) $field_size='lg';
if($is_required == 'on'){
    $is_required = 'required';
}
?>
<div data-date-format="<?php echo TravelHelper::getDateFormatJs(); ?>" class="form-group input-daterange  form-group-<?php echo esc_attr($field_size)?> form-group-icon-left">
    <label for="field-st-checkin"><?php echo balanceTags( $title)?></label>
    <i class="fa fa-calendar input-icon input-icon-highlight"></i>
    <input  readonly class="form-control <?php echo esc_attr($is_required) ?> bookingdc-start" name="start" type="text" placeholder="<?php echo TravelHelper::getDateFormatJs(); ?>" value="<?php echo STInput::get('start') ?>" />
</div>

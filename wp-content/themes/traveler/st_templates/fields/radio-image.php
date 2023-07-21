<?php
/**
 * Created by PhpStorm.
 * User: HanhDo
 * Date: 3/27/2019
 * Time: 9:35 AM
 */
$require_text = '';
if(isset($data['required']) && $data['required'])
    $require_text = '<span class="required">*</span>';

$value_std = '';
if(!empty($post_id)){
    if(!isset($list_val) || empty($list_val)) {
        $value_std = get_post_meta($post_id, $data['name'], true);
        if($data['name'] == 'total_time[hour]'){
            $meta_data = get_post_meta($post_id, 'total_time', true);
            $value_std = $meta_data['hour'];
        }
        if($data['name'] == 'total_time[minute]'){
            $meta_data = get_post_meta($post_id, 'total_time', true);
            $value_std = $meta_data['minute'];
        }
    }else{
        $value_std = $list_val;
    }
}


$name_input = esc_attr($data['name']);
if(isset($list)){
    $name_input = esc_attr($data['name']) . '[]';
}

$condition = isset($data['condition']) ? $data['condition'] : '';
$operator = isset($data['operator']) ? $data['operator'] : 'or';
?>
<div class="form-group st-field-<?php echo esc_attr($data['type']); ?>">
    <label for="<?php echo 'st-field-' . esc_attr($data['name']); ?>"><?php echo balanceTags($data['label'] . ' ' . $require_text); ?></label>
    <div id="<?php echo 'st-field-' . esc_attr($data['name']); ?>" class="row">
        <?php
        if(!empty($data['choices'])){
            foreach ($data['choices'] as $k => $v){
                $selected = '';
                $radio_image_selected = '';
                if($value_std == $v['value']){
                    $selected = 'checked="checked"';
                    $radio_image_selected = 'radio-image-selected';
                }?>
                <div class="partner-item-image col-md-3">
                    <div class="flex-item-radio-label">
                        <input type="radio" name="<?php echo esc_attr($data['name']);?>" id="<?php echo esc_attr($data['name']);?>-<?php echo esc_attr($k);?>" value="<?php echo esc_attr($v['value'])?>" <?php echo esc_html($selected);?> class="st-partner-field form-control">
                        <label for="<?php echo esc_attr($data['name']);?>-<?php echo esc_attr($k);?>"><?php echo  esc_html($v['label'])?></label>
                    </div>
                    
                    <img src="<?php echo esc_url($v['src']);?>" alt="<?php echo esc_attr($v['label'])?>" title="<?php echo esc_attr($v['label'])?>" class="custom-radio-image <?echo esc_attr($radio_image_selected);?>">
                </div>
                
            <?php }
        }
        ?>
    </div>
    <div class="st_field_msg"></div>
</div>
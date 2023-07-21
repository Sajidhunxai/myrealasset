<?php
$has_icon = (isset($has_icon)) ? $has_icon : false;
$room_num_search = STInput::get('room_num_search', 1);
$adult_number = STInput::get('adult_number', 1);
$child_number = STInput::get('child_number', 0);
$adult_max = st()->get_option('hotel_max_adult', 14);
$child_max = st()->get_option('hotel_max_child', 14);
?>
<div class="field-guest form-group">
    <div class="form-extra-field dropdown dropdown-toggle <?php if ($has_icon) echo ' has-icon '; ?>" role="menu" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
        <?php
        if ($has_icon) {
            echo '<span class="stt-icon stt-icon-user2"></span>';
        }
        ?>
        <div class="st-form-dropdown-icon">
            <label><?php echo esc_html__('Guests', 'traveler'); ?></label>
            <div class="render">
                <span data-text="<?php echo esc_attr(json_encode([
                    'guest' => esc_attr__('guest', 'traveler'),
                    'guests' => esc_attr__('guests', 'traveler')
                ])); ?>">
                    <?php 
                        if(!empty($adult_number) || !empty($child_number)){
                            echo sprintf (_n( '%s guest', '%s guests', (intval($adult_number + $child_number)), 'traveler' ), ( intval($adult_number + $child_number) ));
                        } else {
                            echo esc_html__('Add guests', 'traveler');
                        }
                    ?>
                </span>
            </div>
        </div>
    </div>
    <ul class="dropdown-menu st-modern-style">
        
        <li class="item d-flex align-items-center justify-content-between">
            <label><?php echo esc_html__('Adults', 'traveler') ?></label>
            <div class="select-wrapper">
                <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                    <input type="text" name="adult_number" value="<?php echo esc_attr($adult_number); ?>"
                           class="form-control st-input-number" autocomplete="off" readonly data-min="1"
                           data-max="<?php echo esc_attr($adult_max); ?>"/>
                </div>
            </div>
        </li>
        <li class="item d-flex align-items-center justify-content-between">
            <label><?php echo esc_html__('Children', 'traveler') ?></label>
            <div class="select-wrapper">
                <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                    <input type="text" name="child_number" value="<?php echo esc_attr($child_number); ?>"
                           class="form-control st-input-number" autocomplete="off" readonly data-min="0"
                           data-max="<?php echo esc_attr($child_max); ?>"/>
                </div>
            </div>
        </li>
    </ul>
    <?php 
    if(get_post_meta(get_the_ID(), 'disable_adult_name', true) == 'off'){ ?>
        <div class="guest_name_input d-none"
            data-placeholder="<?php echo esc_html__('Guest %d name', 'traveler') ?>"
            data-hide-adult="<?php echo get_post_meta(get_the_ID(), 'disable_adult_name', true) ?>"
            data-hide-children="<?php echo get_post_meta(get_the_ID(), 'disable_children_name', true) ?>"
            >
            <label><span><?php echo esc_html__('Guest Name', 'traveler') ?></span> <span class="required">*</span></label>
            <div class="guest_name_control">
                <?php
                $controls = STInput::request('guest_name');
                $guest_titles = STInput::request('guest_title');
                if (!empty($controls) and is_array($controls)) {
                    foreach ($controls as $k => $control) {
                        ?>
                        <div class="control-item mb10">
                            <select name="guest_title[]" class="form-control">
                                <option value="mr" <?php selected('mr', isset($guest_titles[$k]) ? $guest_titles[$k] : '') ?>><?php echo esc_html__('Mr', 'traveler') ?></option>
                                <option value="miss" <?php selected('miss', isset($guest_titles[$k]) ? $guest_titles[$k] : '') ?> ><?php echo esc_html__('Miss', 'traveler') ?></option>
                                <option value="mrs" <?php selected('mrs', isset($guest_titles[$k]) ? $guest_titles[$k] : '') ?>><?php echo esc_html__('Mrs', 'traveler') ?></option>
                            </select>
                            <?php printf('<input class="form-control " placeholder="%s" name="guest_name[]" value="%s">', sprintf(esc_html__('Guest %d name', 'traveler'), $k + 2), esc_attr($control)); ?>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <script type="text/html" id="guest_name_control_item">
                <div class="control-item mb10">
                    <select name="guest_title[]" class="form-control">
                        <option value="mr"><?php echo esc_html__('Mr', 'traveler') ?></option>
                        <option value="miss"><?php echo esc_html__('Miss', 'traveler') ?></option>
                        <option value="mrs"><?php echo esc_html__('Mrs', 'traveler') ?></option>
                    </select>
                    <?php printf('<input class="form-control " placeholder="%s" name="guest_name[]" value="">', esc_html__('Guest  name', 'traveler')); ?>
                </div>
            </script>
        </div>
    <?php }
?>
</div>



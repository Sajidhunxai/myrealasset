<?php 
    if(get_post_meta(get_the_ID(), 'disable_adult_name', true) == 'off'){ ?>
        <div class="guest_name_input"
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
<input type="hidden" name="adult_price" id="adult_price">
<input type="hidden" name="child_price" id="child_price">
<input type="hidden" name="infant_price" id="infant_price">
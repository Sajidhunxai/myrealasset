<?php
    $has_icon        = ( isset( $has_icon ) ) ? $has_icon : false;
    $room_num_search = STInput::get( 'room_num_search', 1 );
    $adult_number    = STInput::get( 'adult_number', 1 );
    $child_number    = STInput::get( 'child_number', 0 );

    $rental_number = get_post_meta(get_the_ID(), 'rental_max_adult', true);
    $rental_max_children = get_post_meta(get_the_ID(), 'rental_max_children', true);
    $min_people = get_post_meta(get_the_ID(), 'min_people', true);
    if (empty($min_people) ||  $min_people <= 0){
        $min_people = 1;
    }
    if (empty($rental_number) or $rental_number <= 0){
        $rental_number = 20;
    }


?>
<div class="field-guest form-group">
    <div class="form-extra-field form-group dropdown dropdown-toggle <?php if ( $has_icon ) echo ' has-icon '; ?>" role="menu" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
        <?php
            if ( $has_icon ) {
                echo TravelHelper::getNewIcon( 'ico_guest_search_box' );
            }
        ?>
        <div class="st-form-dropdown-icon">
            <label><?php echo __( 'Guests', 'traveler' ); ?></label>
            <div class="render">
                <span class="adult" data-text="<?php echo __( 'Adult', 'traveler' ); ?>"
                    data-text-multi="<?php echo __( 'Adults', 'traveler' ); ?>"><?php echo sprintf( _n( '%s Adult', '%s Adults', esc_attr($adult_number), 'traveler' ), esc_attr($adult_number) ) ?></span>
                -
                <span class="children" data-text="<?php echo __( 'Child', 'traveler' ); ?>"
                    data-text-multi="<?php echo __( 'Children', 'traveler' ); ?>"><?php echo sprintf( _n( '%s Child', '%s Children', esc_attr($child_number), 'traveler' ), esc_attr($child_number) ); ?></span>
            </div>
        </div>

        <i class="fa fa-angle-down arrow"></i>
    </div>
    <ul class="dropdown-menu">
        <li class="item d-flex align-items-center justify-content-between">
            <label><?php echo esc_html__( 'Adults', 'traveler' ) ?></label>
            <div class="select-wrapper">
                <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                    <input type="text" name="adult_number" value="<?php echo esc_attr($adult_number); ?>" class="form-control st-input-number" autocomplete="off" readonly data-min="<?php echo esc_attr($min_people);?>" data-max="<?php echo esc_attr($rental_number);?>"/>
                </div>
            </div>
        </li>
        <li class="item d-flex align-items-center justify-content-between">
            <label><?php echo esc_html__( 'Children', 'traveler' ) ?></label>
            <div class="select-wrapper">
                <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                    <input type="text" name="child_number" value="<?php echo esc_attr($child_number); ?>" class="form-control st-input-number" autocomplete="off" readonly data-min="0" data-max="<?php echo esc_attr($rental_max_children);?>"/>
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

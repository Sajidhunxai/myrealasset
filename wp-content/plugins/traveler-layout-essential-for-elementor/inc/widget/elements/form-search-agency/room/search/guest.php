<?php
    $has_icon        = ( !empty($has_icon) ) ? $has_icon : false;
    $room_num_search = STInput::get('room_num_search', 1);
    $adult_number    = STInput::get('adult_num_search', 1);
    $child_number    = STInput::get('children_num_search', 0);
    $adult_max=st()->get_option('hotel_max_adult', 14);
    $child_max=st()->get_option('hotel_max_child', 14);
?>
<div class="field-guest form-group">
    <div class="form-extra-field dropdown dropdown-toggle <?php if ($has_icon) {
        echo ' has-icon ';
                                                          } ?>" id="dropdown-1" role="menu" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
        <?php
        if ($has_icon) { ?>
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_182_5652)">
                <path d="M7.5 13.5C6.60998 13.5 5.73995 13.2361 4.99993 12.7416C4.25991 12.2472 3.68314 11.5443 3.34254 10.7221C3.00195 9.89981 2.91283 8.99501 3.08647 8.1221C3.2601 7.24918 3.68868 6.44736 4.31802 5.81802C4.94736 5.18869 5.74918 4.7601 6.62209 4.58647C7.49501 4.41284 8.39981 4.50195 9.22208 4.84254C10.0443 5.18314 10.7471 5.75991 11.2416 6.49994C11.7361 7.23996 12 8.10999 12 9C11.9987 10.1931 11.5241 11.3369 10.6805 12.1805C9.83689 13.0241 8.69307 13.4987 7.5 13.5ZM7.5 6.5C7.00555 6.5 6.5222 6.64663 6.11107 6.92133C5.69995 7.19603 5.37952 7.58648 5.1903 8.04329C5.00108 8.50011 4.95157 9.00278 5.04804 9.48773C5.1445 9.97268 5.3826 10.4181 5.73223 10.7678C6.08186 11.1174 6.52732 11.3555 7.01227 11.452C7.49723 11.5484 7.99989 11.4989 8.45671 11.3097C8.91352 11.1205 9.30397 10.8001 9.57867 10.3889C9.85338 9.97781 10 9.49446 10 9C10 8.33696 9.73661 7.70108 9.26777 7.23224C8.79893 6.76339 8.16304 6.5 7.5 6.5ZM15 20.5C14.9984 19.1744 14.4711 17.9036 13.5338 16.9662C12.5964 16.0289 11.3256 15.5016 10 15.5H5C3.67441 15.5016 2.40356 16.0289 1.46622 16.9662C0.528882 17.9036 0.00158786 19.1744 0 20.5L0 24.5H2V20.5C2 19.7044 2.31607 18.9413 2.87868 18.3787C3.44129 17.8161 4.20435 17.5 5 17.5H10C10.7956 17.5 11.5587 17.8161 12.1213 18.3787C12.6839 18.9413 13 19.7044 13 20.5V24.5H15V20.5ZM17.5 9.5C16.61 9.5 15.74 9.23608 14.9999 8.74162C14.2599 8.24715 13.6831 7.54435 13.3425 6.72208C13.0019 5.89981 12.9128 4.99501 13.0865 4.1221C13.2601 3.24918 13.6887 2.44736 14.318 1.81802C14.9474 1.18869 15.7492 0.760102 16.6221 0.586468C17.495 0.412835 18.3998 0.50195 19.2221 0.842544C20.0443 1.18314 20.7471 1.75991 21.2416 2.49994C21.7361 3.23996 22 4.10999 22 5C21.9987 6.19307 21.5241 7.33689 20.6805 8.18052C19.8369 9.02415 18.6931 9.49868 17.5 9.5ZM17.5 2.5C17.0055 2.5 16.5222 2.64662 16.1111 2.92133C15.7 3.19603 15.3795 3.58648 15.1903 4.04329C15.0011 4.50011 14.9516 5.00278 15.048 5.48773C15.1445 5.97268 15.3826 6.41814 15.7322 6.76777C16.0819 7.1174 16.5273 7.3555 17.0123 7.45197C17.4972 7.54843 17.9999 7.49892 18.4567 7.3097C18.9135 7.12048 19.304 6.80005 19.5787 6.38893C19.8534 5.97781 20 5.49446 20 5C20 4.33696 19.7366 3.70108 19.2678 3.23224C18.7989 2.76339 18.163 2.5 17.5 2.5ZM24 16.5C23.9984 15.1744 23.4711 13.9036 22.5338 12.9662C21.5964 12.0289 20.3256 11.5016 19 11.5H15V13.5H19C19.7956 13.5 20.5587 13.8161 21.1213 14.3787C21.6839 14.9413 22 15.7044 22 16.5V20.5H24V16.5Z" fill="#7B7B7B"/>
                </g>
                <defs>
                <clipPath id="clip0_182_5652">
                <rect width="24" height="24" fill="white" transform="translate(0 0.5)"/>
                </clipPath>
                </defs>
                </svg>
        <?php }
        ?>
        <div class="st-form-dropdown-icon">
            <label><?php echo __('Guests', 'traveler-layout-essential'); ?></label>
            <div class="render">
                <span class="adult" data-text="<?php echo __('Adult', 'traveler-layout-essential'); ?>"
                    data-text-multi="<?php echo __('Adults', 'traveler-layout-essential'); ?>"><?php echo sprintf(_n('%s Adult', '%s Adults', esc_attr($adult_number), 'traveler-layout-essential'), esc_attr($adult_number)) ?></span>
                -
                <span class="children" data-text="<?php echo __('Child', 'traveler-layout-essential'); ?>"
                    data-text-multi="<?php echo __('Children', 'traveler-layout-essential'); ?>"><?php echo sprintf(_n('%s Child', '%s Children', esc_attr($child_number), 'traveler-layout-essential'), esc_attr($child_number)); ?></span>
            </div>
        </div>
     
    </div>
    <ul class="dropdown-menu st-modern-style" aria-labelledby="dropdown-1">
        <li class="item d-flex align-items-center justify-content-between">
            <label><?php echo esc_html__('Rooms', 'traveler-layout-essential') ?></label>
            <div class="select-wrapper">
                <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                    <input type="text" name="room_num_search" value="<?php echo esc_attr($room_num_search); ?>" class="form-control st-input-number" autocomplete="off" readonly data-min="1" data-max="<?php echo esc_attr($adult_max);?>"/>
                </div>
            </div>
        </li>
        <li class="item d-flex align-items-center justify-content-between">
            <label><?php echo esc_html__('Adults', 'traveler-layout-essential') ?></label>
            <div class="select-wrapper">
                <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                    <input type="text" name="adult_num_search" value="<?php echo esc_attr($adult_number); ?>" class="form-control st-input-number" autocomplete="off" readonly data-min="1" data-max="<?php echo esc_attr($adult_max);?>"/>
                </div>
            </div>
        </li>
        <li class="item d-flex align-items-center justify-content-between">
            <label><?php echo esc_html__('Children', 'traveler-layout-essential') ?></label>
            <div class="select-wrapper">
                <div class="st-number-wrapper d-flex align-items-center justify-content-between">
                    <input type="text" name="children_num_search" value="<?php echo esc_attr($child_number); ?>" class="form-control st-input-number" autocomplete="off" readonly data-min="0" data-max="<?php echo esc_attr($child_max);?>"/>
                </div>
            </div>
        </li>
    </ul>
</div>

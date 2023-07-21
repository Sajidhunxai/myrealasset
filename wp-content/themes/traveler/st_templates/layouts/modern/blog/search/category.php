<div class="form-group form-extra-field dropdown clearfix field-detination">
    <div class="dropdown" data-toggle="dropdown" id="dropdown-destination">
        <div class="render render-new">
            <span class="destination">
                <label class="st-location-new"><?php echo esc_html__('Categories', 'traveler'); ?></label>
            </span>
        </div>
        <input type="hidden" name="cat" id="cat" value=""/>
    </div>
    <ul class="dropdown-menu" aria-labelledby="dropdown-destination">
        <?php
        $categories = get_categories();
        if (is_array($categories) && count($categories)) {
            foreach ($categories as $item) {
                ?>
                <li class="item" data-value="<?php echo esc_attr($item->term_id); ?>">
                    <span><?php echo esc_attr($item->name); ?></span>
                </li>
                <?php
            }
        }
        ?>
    </ul>
</div>

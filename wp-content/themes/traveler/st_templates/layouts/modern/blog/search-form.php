<form role="search" method="get" class="search search--blog-solo" action="<?php echo esc_url(get_pagenum_link()); ?>">
    <input type="text" class="form-text" name="post_title" placeholder="<?php echo esc_attr__('Search ...', 'traveler'); ?>" value="<?php echo esc_attr(STInput::get('post_title', '')); ?>">
    <div class="form-icon-fa">
        <select name="cat" id="cat" class="form-select form-slelect-2">
            <option value=""><?php echo esc_html__('Categories', 'traveler'); ?></option>
            <?php
            $cats = get_categories();
            foreach ($cats as $cat) {
                if ($cat->category_parent == 0) {
                    $selected = ($cat->term_id == trim(STInput::get('cat', 0))) ? 'selected="selected"' : '';
                    ?>
                    <option value="<?php echo esc_html($cat->term_id) ?>" <?php echo esc_html($selected); ?>><?php echo esc_html($cat->name) ?></option>   ;
                    <?php
                }
            }
            ?>
        </select>
        <i class="fa fa-angle-down"></i>
    </div>
    <!--<i class="fa fa-angle-up"></i>-->
</form>
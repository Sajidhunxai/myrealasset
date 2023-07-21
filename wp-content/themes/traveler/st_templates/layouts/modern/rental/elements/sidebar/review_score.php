<div class="sidebar-item st-icheck">
    <div class="item-title">
        <label><?php echo esc_html($title); ?></label>
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </div>
    <div class="item-content">
        <ul>
            <li class="st-icheck-item"><label><?php echo __('Excellent', 'traveler'); ?><input type="checkbox" name="review_score" value="4" class="filter-item" data-type="star_rate"/><span class="checkmark fcheckbox"></span></label></li>
            <li class="st-icheck-item"><label><?php echo __('Very Good', 'traveler'); ?><input type="checkbox" name="review_score" value="3" class="filter-item" data-type="star_rate"/><span class="checkmark fcheckbox"></span></label></li>
            <li class="st-icheck-item"><label><?php echo __('Average', 'traveler'); ?><input type="checkbox" name="review_score" value="2" class="filter-item" data-type="star_rate"/><span class="checkmark fcheckbox"></span></label></li>
            <li class="st-icheck-item"><label><?php echo __('Poor', 'traveler'); ?><input type="checkbox" name="review_score" value="1" class="filter-item" data-type="star_rate"/><span class="checkmark fcheckbox"></span></label></li>
            <li class="st-icheck-item"><label><?php echo __('Terrible', 'traveler'); ?><input type="checkbox" name="review_score" value="zero" class="filter-item" data-type="star_rate"/><span class="checkmark fcheckbox"></span></label></li>
        </ul>
    </div>
</div>
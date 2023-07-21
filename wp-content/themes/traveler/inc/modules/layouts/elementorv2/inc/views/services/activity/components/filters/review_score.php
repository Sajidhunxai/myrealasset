<li class="filter-review-score">
    <div class="form-extra-field">
        <button class="btn btn-link dropdown dropdown-toggle" type="button" id="dropdownMenuReviewScore" data-bs-toggle="dropdown" data-bs-auto-close="outside"  aria-haspopup="true" aria-expanded="false">
            <?php echo esc_html($title); ?> <span class="count"></span> <span class="stt-icon stt-icon-arrow-down"></span>
        </button>
        <div class="dropdown-menu st-icheck" aria-labelledby="dropdownMenuReviewScore">
            <div class="dropdown-title"><?php echo esc_html__('Review score', 'traveler'); ?></div>
            <ul>
                <li class="st-icheck-item"><label><?php echo __('Excellent', 'traveler'); ?><input type="checkbox" name="review_score" value="4" class="filter-item" data-type="star_rate"/><span class="checkmark fcheckbox"></span></label></li>
                <li class="st-icheck-item"><label><?php echo __('Very Good', 'traveler'); ?><input type="checkbox" name="review_score" value="3" class="filter-item" data-type="star_rate"/><span class="checkmark fcheckbox"></span></label></li>
                <li class="st-icheck-item"><label><?php echo __('Average', 'traveler'); ?><input type="checkbox" name="review_score" value="2" class="filter-item" data-type="star_rate"/><span class="checkmark fcheckbox"></span></label></li>
                <li class="st-icheck-item"><label><?php echo __('Poor', 'traveler'); ?><input type="checkbox" name="review_score" value="1" class="filter-item" data-type="star_rate"/><span class="checkmark fcheckbox"></span></label></li>
                <li class="st-icheck-item"><label><?php echo __('Terrible', 'traveler'); ?><input type="checkbox" name="review_score" value="zero" class="filter-item" data-type="star_rate"/><span class="checkmark fcheckbox"></span></label></li>
            </ul>
        </div>
    </div>
</li>
<li class="filter-review-score">
    <div class="form-extra-field">
        <button class="btn btn-link dropdown dropdown-toggle" type="button" id="dropdownMenuReviewScore" data-bs-toggle="dropdown" data-bs-auto-close="outside"  aria-haspopup="true" aria-expanded="false">
            <?php echo esc_html($title); ?> <span class="count"></span> <span class="stt-icon stt-icon-arrow-down"></span>
        </button>
        <div class="dropdown-menu st-icheck" aria-labelledby="dropdownMenuReviewScore">
            <div class="dropdown-title"><?php echo esc_html__('Review score', 'traveler'); ?></div>
            <ul>
                <?php
                for ($i = 5; $i > 0; $i--){
                    ?>
                    <li class="st-icheck-item">
                        <label>
                            <?php
                            for ($j = 1; $j <= 5; $j++){
                                if($j <= $i) {
                                    echo '<span class="real-star"><i class="stt-icon-star1"></i></span>';
                                }else{
                                    echo '<span class="fake-star"><i class="stt-icon-star1"></i></span>';
                                }
                            }
                            ?>
                            <input type="checkbox" name="review_score" value="<?php echo esc_attr($i); ?>" class="filter-item" data-type="star_rate"/>
                            <span class="checkmark fcheckbox"></span>
                        </label>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</li>
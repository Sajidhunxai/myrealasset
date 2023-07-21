<li class="filter-review-score">
    <div class="form-extra-field dropdown">
        <button class="btn btn-link dropdown" type="button" id="dropdownMenuReviewScore" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
            <?php echo esc_html($title); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
        </button>
        <div class="dropdown-menu st-icheck" aria-labelledby="dropdownMenuReviewScore">
            <ul>
                <?php
                for ($i = 5; $i > 0; $i--){
                    ?>
                    <li class="st-icheck-item">
                        <label>
                            <?php
                            for ($j = 1; $j <= 5; $j++){
                                if($j <= $i) {
                                    echo '<span class="real-star"><i class="fa fa-star"></i></span>';
                                }else{
                                    echo '<span class="fake-star"><i class="fa fa-star"></i></span>';
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
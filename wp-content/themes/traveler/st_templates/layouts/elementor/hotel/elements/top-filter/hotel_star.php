<li class="filter-review-score">
    <div class="form-extra-field dropdown">
        <button class="btn btn-link dropdown dropdown-toggle" type="button" id="dropdownMenuHotelStar" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
            <?php echo esc_html($title); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
        </button>
        <div class="dropdown-menu st-icheck" aria-labelledby="dropdownMenuHotelStar">
            <ul>
                <?php
                for ($i = 5; $i >= 1; $i--) {
                    echo '<li class="st-icheck-item"><label>';
                    $star = '';
                    for ($j = 1; $j <= $i; $j++) {
                        $star .= '<i class="fa fa-star"></i> ';
                    }
                    echo balanceTags($star);
                    echo '<input type="checkbox" name="review_score" data-type="hotel_rate" value="' . esc_attr($i) . '" class="filter-item"/><span class="checkmark fcheckbox"></span>
                    </label>
                    </li>';
                }
                ?>
            </ul>
        </div>
    </div>
</li>
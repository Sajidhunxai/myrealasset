<div class="sidebar-item top-filter pag st-icheck st-border-radius">
    <div class="item-title d-flex justify-content-between align-items-center">
        <div><?php echo esc_html($title); ?></div>
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </div>
    <div class="item-content filter-review-score">
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
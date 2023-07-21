<li class="filter-review-score taxonomy">
    <div class="form-extra-field">
        <button class="btn btn-link dropdown dropdown-toggle" type="button" id="dropdownMenuFacilities" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
            <?php echo esc_html($title); ?> <span class="count"></span> <span class="stt-icon stt-icon-arrow-down"></span>
        </button>
        <div class="dropdown-menu st-icheck" aria-labelledby="dropdownMenuFacilities">
            <div class="st-scrollbar dropdown-menu-inner">
                <div class="dropdown-title"><?php echo esc_html($title); ?></div>
                <ul>
                    <?php New_Layout_Helper::listTaxTreeFilter($taxonomy, 0, -1, 'st_cars', false); ?>
                </ul>
            </div>
        </div>
    </div>
</li>
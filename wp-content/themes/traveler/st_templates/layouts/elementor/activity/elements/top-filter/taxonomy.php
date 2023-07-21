<li class="filter-review-score">
    <div class="form-extra-field dropdown">
        <button class="btn btn-link dropdown" type="button" id="dropdownMenuFacilities" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
            <?php echo esc_html($title); ?> <i class="fa fa-angle-down" aria-hidden="true"></i>
        </button>
        <div class="dropdown-menu st-icheck" aria-labelledby="dropdownMenuFacilities">
            <?php New_Layout_Helper::listTaxTreeFilter($taxonomy, 0, -1, 'st_activity', false); ?>
        </div>
    </div>
</li>
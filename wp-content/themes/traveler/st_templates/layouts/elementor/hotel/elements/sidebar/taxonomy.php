<div class="sidebar-item pag st-icheck st-border-radius">
    <div class="item-title d-flex justify-content-between align-items-center">
        <h4><?php echo esc_html($title); ?></h4>
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </div>
    <div class="item-content">
            <?php New_Layout_Helper::listTaxTreeFilter($taxonomy, 0, -1, 'st_hotel'); ?>
        <button class="btn btn-link btn-more-item"><?php echo __('More', 'traveler'); ?> <i class="fa fa-caret-down"></i></button>
    </div>
</div>
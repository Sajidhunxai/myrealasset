<div class="sidebar-item pag st-icheck st-border-radius">
    <div class="item-title d-flex justify-content-between align-items-center">
        <div><?php echo esc_html($title); ?></div>
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </div>
    <div class="item-content">
            <?php $term_parent = 0; New_Layout_Helper::listTaxTreeFilter($taxonomy, 0, -1, 'st_hotel', true, $term_parent, 0, 4); ?>
        <button class="btn btn-link btn-more-item"><?php echo __('See more', 'traveler'); ?> <span class="stt-icon stt-icon-arrow-down"></span></button>
    </div>
</div>
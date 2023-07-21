<?php
$filters = get_post_meta(get_the_ID(), 'rs_filter_activity', true);
if (!isset($format))
    $format = '';
if (!empty($filters)) {
    ?>
    <div class="top-filter">
        <div class="btn-clear-filter">
            <?php echo esc_html__('Clear filter', 'traveler'); ?>
            <span class="stt-icon stt-icon-close"></span>
        </div>
        <ul>
            <?php
            foreach ($filters as $k => $v) {
                $filter_taxonomy = isset($v['rs_filter_type_taxonomy']) ? $v['rs_filter_type_taxonomy'] : [];
                echo stt_elementorv2()->loadView('services/activity/components/filters/' . esc_attr($v['rs_filter_type']), ['title' => $v['title'], 'taxonomy' => $filter_taxonomy]);
            }
            ?>
        </ul>
    </div>
<?php }
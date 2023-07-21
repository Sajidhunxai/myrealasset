<?php
$result_page = st()->get_option( 'tours_search_result_page' );
$class = '';
$id = 'id="sticky-nav"';
if(isset($in_tab)) {
    $class = 'in_tab';
    $id = '';
}
?>
<div class="search-form st-border-radius">
    <form action="<?php echo esc_url(get_the_permalink($result_page)); ?>" class="form" method="get">
        <div class="row">
            <div class="col-md-4 border-right">
                <?php echo st()->load_template('layouts/elementor/tour/elements/search/location', '', ['has_icon' => true]); ?>
            </div>
            <div class="<?php echo isset($in_tab) ? 'col-md-5' : 'col-md-4' ?> ">
                <?php echo st()->load_template('layouts/elementor/tour/elements/search/date', '', ['has_icon' => true]); ?>
            </div>
            <div class="<?php echo isset($in_tab) ? 'col-md-3' : 'col-md-4' ?>">
                <?php echo st()->load_template('layouts/elementor/tour/elements/search/advanced', '') ?>
            </div>
        </div>
    </form>
</div>
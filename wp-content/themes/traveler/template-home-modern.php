<?php
/*
  Template Name: Home Modern
 */

get_header();

$class = 'search-result-page search-result-page--custom';
$menu_style = st()->get_option('menu_style_modern', '');
switch ($menu_style) {
    case 8: //solo layout
        $class = 'search-result-page search-result-page--custom st-content-wrapper--solo';
        break;
    default :
        break;
}
?>
<div id="st-content-wrapper" class="<?php echo $class; ?>">
    <?php if (!is_front_page()) { ?>
        <div class="search-result-page--heading">
            <?php echo st()->load_template('layouts/modern/hotel/elements/banner'); ?>
            <?php st_breadcrumbs_new() ?>
        </div>
    <?php } ?>
    <div class="container">
        <?php
        while (have_posts()) {
            the_post();
            the_content();
        }
        ?>
    </div>
</div>
<?php
get_footer();

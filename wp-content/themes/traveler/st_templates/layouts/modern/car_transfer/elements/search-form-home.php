<?php
$result_page = st_get_page_search_result('st_cars');
$id_page = st()->get_option('car_transfer_search_page');
  if(isset($id_page) && !empty($id_page)){
      $link_action = get_the_permalink($id_page);
  }else{
      $link_action = home_url( '/' );
  }
$class = '';
$id = 'id="sticky-nav"';
if (isset($in_tab)) {
    $class = 'in_tab';
    $id = '';
}

?>
<div class="search-form hotel-search-form-home hotel-search-form <?php echo esc_attr($class); ?>" <?php echo ($id); ?>>
    <form action="<?php echo esc_url($link_action); ?>" class="form" method="get">
        <div class="row">
            <?php echo st()->load_template('layouts/modern/car_transfer/elements/search/location', '', ['has_icon' => true]) ?>
            
            <div class="col-md-4">
                <?php echo st()->load_template('layouts/modern/car_transfer/elements/search/advanced', '') ?>
            </div>
        </div>
    </form>
</div>
<?php
if (isset($feature_item) && !empty($feature_item)) {
    ?>
    <div class="st-feature-items row">
        <?php
        foreach ($feature_item as $item) {
            ?>
            <div class="col col-xs-12 col-sm-4">
                <div class="item">
                    <h3 class="title"><?php echo esc_html($item['heading']); ?></h3>
                    <div class="desc"><?php echo esc_html($item['description']); ?></div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
<?php } ?>

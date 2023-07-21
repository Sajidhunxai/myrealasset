<?php

use Inc\Base\ST_Elementor_Widget;

$stElementorWidget = new ST_Elementor_Widget;
$link_page_search_scr = get_page_link($link_page_search);
$class_ver = ($layout != 'style1') ? 'search-form-v2' : '';
?>
<div class="st-search-form-el st_search_room st-border-radius <?php echo esc_attr($layout); ?>">
    <div class="st-search-el <?php echo $class_ver ?>">
        <?php
        $class = '';
        $id = 'id="sticky-nav"';
        ?>
        <div class="search-form <?php echo esc_attr($class); ?> st-border-radius" <?php echo ($id); ?>>
            <form action="<?php echo esc_url($link_page_search_scr); ?>" class="form" method="get">
                <div class="row">
                    <?php switch ($type) {
                        case 'search_room':
                            ?>
                            <?php if ($layout == 'style1') { ?>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                    <?php echo $stElementorWidget->loadTemplate('form-search-agency/room/search/date', [ 'has_icon' => true]) ?>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                                    <?php echo $stElementorWidget->loadTemplate('form-search-agency/room/search/guest', [ 'has_icon' => true]) ?>
                            </div>
                            <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                                    <?php echo $stElementorWidget->loadTemplate('form-search-agency/room/search/advanced', '') ?>
                            </div>
                            <?php } elseif ($layout == 'style2' || $layout == 'style3') { ?>
                            <div class="col-12 col-sm-8 col-md-8 col-lg-6 date">
                                    <?php echo $stElementorWidget->loadTemplate('form-search-agency/room/search-2/date-style2', [ 'has_icon' => true ]) ?>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4 col-lg-3 guest">
                                    <?php echo $stElementorWidget->loadTemplate('form-search-agency/room/search-2/guest-style2', [ 'has_icon' => true ]) ?>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 advanced">
                                    <?php echo $stElementorWidget->loadTemplate('form-search-agency/room/search/advanced', '') ?>
                            </div>
                            <?php } ?>
                            <?php
                            break;
                        case 'search_rental':
                            ?>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                <?php echo $stElementorWidget->loadTemplate('form-search-agency/rental/search/date', [ 'has_icon' => true ]) ?>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                                <?php echo $stElementorWidget->loadTemplate('form-search-agency/rental/search/guest', [ 'has_icon' => true ]) ?>
                            </div>
                            <div class="col-md-12 col-lg-4">
                                <?php echo $stElementorWidget->loadTemplate('form-search-agency/rental/search/advanced', '') ?>
                            </div>

                        <?php
                            break;
                    } ?>
                </div>
            </form>
        </div>
    </div>
</div>
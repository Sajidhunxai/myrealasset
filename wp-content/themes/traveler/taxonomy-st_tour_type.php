<?php 
get_header();
$tours_layout_v2 = st()->get_option('tours_layout_v2', '');
if($tours_layout_v2 == '7'){ ?>
    <div id="st-content-wrapper" class="search-result-page st-tours st-tour--solo">
        <div class="st-tour--solo__banner">
            <?php  echo st()->load_template('layouts/modern/hotel/elements/banner'); ?>
            <?php st_breadcrumbs_new() ?>
        </div>
        <div class="container">
            <div class="st-hotel-result style-full-map">
                <div class="row">
                    <?php 
                        echo st()->load_template('layouts/modern/tour/elements/content','default', array('tours_layout_v2' => $tours_layout_v2)); 
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php get_footer();
} else { ?>
    <div id="st-content-wrapper" class="search-result-page st-tours">
        <?php 
        echo st()->load_template('layouts/modern/hotel/elements/banner'); ?>
        <div class="container">
            <div class="st-hotel-result style-full-map">
                <div class="row">
                    <?php 
                        echo st()->load_template('layouts/modern/tour/elements/content','default', array('tours_layout_v2' => $tours_layout_v2)); 
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php get_footer();
}
?>

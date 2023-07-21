<?php

use Elementor\Widget_Image_Gallery;

$widget_image_gallery = new Elementor\Widget_Image_Gallery;
$i = 0;
?>
<div class="st-gallery-lightbox">
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <?php
        foreach ($list_gallery as $item_gallery) {
            $i++;
            $active = ($i == 1) ? 'active' : '';
            echo '<button class="nav-link ' . $active . '" id="nav-' . $i . '-tab" data-bs-toggle="tab" data-bs-target="#nav-' . $i . '" type="button" role="tab" aria-controls="nav-' . $i . '" aria-selected="true">' . $item_gallery['name_tab_gallery'] . '</button>';
        } ?>
    </div>
    <div class="tab-content" id="nav-tabContent">
        <?php
        $j = 0;
        foreach ($list_gallery as $item_gallery) {
            $j++;
            $show = ($j == 1) ? 'active show' : '';
            echo '<div class="tab-pane fade ' . $show . '" id="nav-' . $j . '" role="tabpanel" aria-labelledby="nav-' . $j . '-tab" tabindex="0">';
            echo '<div class="popup-st-gallery">';
            echo '<div class="row">';
            foreach ($item_gallery['st_gallery'] as $a) {
                echo '<div class="col-6 col-sm-6 col-lg-4">';
                echo '<a href="' . $a['url'] . '"  title="' . $item_gallery['name_tab_gallery'] . '" data-elementor-open-lightbox="no"><img src="' . $a['url'] . '"></a>';
                echo '</div>';
            }
            echo '</div>';

            echo '</div>';
            echo '</div>';
            ?>
        <?php } ?>
    </div>
</div>
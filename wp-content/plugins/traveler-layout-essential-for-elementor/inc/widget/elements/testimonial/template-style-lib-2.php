<?php
$class_col = $row_class = $html = '';
$item_in_row = $slides_per_view;

if ($item_in_row == 2) {
    $class_col = 'col-12 col-sm-6 col-md-6';
} elseif ($item_in_row == 3) {
    $class_col = 'col-12 col-sm-4 col-md-4';
} elseif ($item_in_row == 4) {
    $class_col = 'col-12 col-sm-3 col-md-3';
}

$row_class = ' row';

if (!empty($list_testimonial)) { ?>
    <div class="st-testimonial">

        <div class="testimonial-wrapper <?php echo esc_attr($row_class); ?>">
            <?php
            foreach ($list_testimonial as $item_tes) { ?>
                <div class="item-testimonial <?php echo esc_attr($st_style_testimonial); ?> <?php echo esc_attr($class_col); ?>">

                    <div class="item service-border-lib st-border-radius-lib">
                        <div>
                            <?php
                            if (!empty($item_tes["st_avatar_testimonial"]['url'])) {
                                ?>
                                <div class="st-avatar-lib"><img src="<?php echo esc_url($item_tes["st_avatar_testimonial"]['url']); ?>" alt="<?php echo esc_attr($item_tes["name_testimonial"]); ?>"></div>
                            <?php }
                            ?>
                            <div class="box-content">
                                <div class="st-content-lib">
                                    <?php echo esc_html($item_tes["content_testimonial"]); ?>
                                </div>

                                <div class="author-meta-lib">

                                    <h4><?php echo esc_html($item_tes["name_testimonial"]); ?></h4>
                                    <div class="office-testimonial-lib"><?php echo esc_html($item_tes["office_testimonial"]); ?></div>

                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            <?php }

            ?>

        </div>
        <?php
        echo balanceTags($html);
        ?>
    </div>
<?php } ?>
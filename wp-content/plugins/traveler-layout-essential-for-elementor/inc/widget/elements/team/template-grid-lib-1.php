<?php
$class_col = $row_class = $html = '';
$item_in_row = $slides_per_view;

if ($item_in_row == 2) {
    $class_col = 'col-12 col-sm-6 col-md-6';
} elseif ($item_in_row == 3) {
    $class_col = 'col-12 col-sm-6 col-lg-4 col-xl-4';
} elseif ($item_in_row == 4) {
    $class_col = 'col-12 col-sm-6 col-lg-4 col-xl-3';
}

$row_class = ' row';

if (!empty($list_team)) { ?>
    <div class="st-list-service st-sliders">

        <div class="service-list-wrapper <?php echo esc_attr($row_class); ?>">
            <?php
            foreach ($list_team as $item_tes) {
                $link_facebook = $item_tes['link_facebook'];
                $link_instagram = $item_tes['link_instagram'];
                $link_youtube = $item_tes['link_youtube'];
                $link_twitter = $item_tes['link_twitter'];
                ?>
                <div class="item-team st-style-<?php echo esc_attr($st_style_team); ?> <?php echo esc_attr($class_col); ?>">

                    <div class="item border-radius-10">
                        <div class="box-team-lib">
                            <?php
                            if (!empty($item_tes["st_avatar_team"]['url'])) {
                                ?>
                                <div class="st-avatar-team-lib"><img src="<?php echo esc_url($item_tes["st_avatar_team"]['url']); ?>" alt="<?php echo esc_attr($item_tes["name_team"]); ?>"></div>
                            <?php }
                            ?>
                            <div class="author-meta-lib service-border-lib border-radius-10">

                                <h4><?php echo esc_html($item_tes["name_team"]); ?></h4>
                                <div class="office-team-lib"><?php echo esc_html($item_tes["office_team"]); ?></div>
                                <?php
                                if (!empty($link_facebook['url']) || !empty($link_instagram['url']) || !empty($link_youtube) || !empty($link_twitter['url'])) { ?>
                                    <div class="social">
                                        <ul>
                                            <?php if (!empty($link_facebook['url'])) { ?>
                                                <li style="background:#3D52A6;"><a href="<?php echo esc_url($link_facebook['url']); ?>"><i class="fab fa-facebook-f"></i></a></li>
                                            <?php } ?>
                                            <?php if (!empty($link_twitter['url'])) { ?>
                                                <li style="background:#58B1F7;"><a href="<?php echo esc_url($link_twitter['url']); ?>"><i class="fab fa-twitter"></i></a></li>
                                            <?php } ?>
                                            <?php if (!empty($link_instagram['url'])) { ?>
                                                <li style="background:#D9498C;"><a href="<?php echo esc_url($link_instagram['url']); ?>"><i class="fab fa-instagram"></i></a></li>
                                            <?php } ?>


                                            <?php if (!empty($link_youtube['url'])) { ?>
                                                <li><a href="<?php echo esc_url($link_youtube['url']); ?>"><i class="fab fa-youtube"></i></a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                <?php }
                                ?>

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
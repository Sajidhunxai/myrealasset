<?php
$attrs = [];
$attrs = [
    'data-duration' => [
        esc_attr($duration)
    ],
    'data-to-value' => [
        esc_attr($ending_number)
    ],
    'data-from-value' => [
        esc_attr($starting_number)
    ]
];

if ($icon_position === "absolute") {
    $style_class = "position:absolute;";
    $style_box = "display: block;";
} elseif ($icon_position === "top") {
    $style_class = "position:relative;";
    $style_box = "display: block;";
} elseif ($icon_position === "left") {
    $style_class = "position:relative;";
    $style_box = "display: flex;align-items: center;justify-content: space-between;";
}
?>
<div class="elementor-box" style="<?php echo esc_attr($style_box); ?>">
    <?php
    if (!empty($icon_counter['value'])) {
        if ($icon_counter['library'] === 'svg') {
            echo '<div class="st-icon-counter" style="' . esc_attr($style_class) . '"><img src="' . esc_attr($icon_counter['value']['url']) . '"></div>';
        } else {
            echo '<div class="st-icon-counter"><i class="' . esc_attr($icon_counter['value']) . '"></i></div>';
        }
    }

    ?>

    <div class="elementor-counter">
        <div class="elementor-counter-number-wrapper">
            <?php if ($prefix) { ?>
                <span class="elementor-counter-number-prefix"><?php echo esc_html($prefix); ?></span>
            <?php } ?>
            <span class="elementor-counter-number" <?php echo st_render_html_attributes($attrs); ?>>
                <?php echo esc_html($starting_number); ?>
            </span>
            <?php if ($suffix) { ?>
                <span class="elementor-counter-number-suffix"><?php echo esc_html($suffix); ?></span>
            <?php } ?>
        </div>
        <?php if ($title) : ?>
            <div class="elementor-counter-title"><?php echo esc_html($title); ?></div>
        <?php endif; ?>
    </div>
</div>
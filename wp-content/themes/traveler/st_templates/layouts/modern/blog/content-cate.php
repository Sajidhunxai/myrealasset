<?php
$category_detail = get_the_category(get_the_ID());
if (!empty($category_detail)) {
    ?>
    <div class="cate">
        <ul>
            <?php
            $v = $category_detail[0];
            $color = get_term_meta($v->term_id, '_category_color', true);
            $inline_css = '';
            if (!empty($color)) {
                $inline_css = 'style="background: #' . esc_attr($color) . '"';
            }
            echo '<li ' . ($inline_css) . '><a href="' . get_category_link($v->term_id) . '">' . esc_html($v->name) . '</a></li>';
            ?>
        </ul>
    </div>
    <?php
}
?>
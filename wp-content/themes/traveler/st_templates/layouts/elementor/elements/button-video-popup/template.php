<?php
if (empty($lightbox_url)) {
    return false;
}
?>
<div class="st-button-popup-video <?php echo esc_attr($layout_style);?>">
    <button <?php echo ($_element->get_render_attribute_string('image-overlay')); ?>><span class="stt-icon-play"></span></button>
</div>
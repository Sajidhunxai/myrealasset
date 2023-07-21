<div class="stt-subscribe-form-wrapper stt-subscribe-form-<?php echo esc_attr($st_style_form); ?> relative">
    <form class="traveler-form form-action" data-validation-id="<?php echo esc_attr($id); ?>" id="form-subscribe-<?php echo esc_attr($id); ?>" method="post">

        <div class="form-row g-0">
            <div class="control-group">
                <input class="form-input" placeholder="<?php echo esc_html($text_email) ?>" type="email" name="EMAIL" id="EMAIL-<?php echo esc_attr($id); ?>">
            </div>
            <button type="submit" class="submit">
                <?php
                if (!empty($text_button)) {
                    echo '<span class="button-text">' . esc_html($text_button) . '</span>';
                }
                if (!empty($icon_button['value'])) {
                    if ($icon_button['library'] === 'svg') {
                        echo '<span class="button-icon"><img src=' . esc_attr($icon_button['value']['url']) . '></span>';
                    } else {
                        echo '<span class="button-icon"><i class="' . esc_attr($icon_button['value']) . '"></i></span>';
                    }
                }
                ?>
            </button>
        </div>
        <div class="form-message mt-4"></div>
        <input type="hidden" name="api_key" class="api_key" value="<?php echo esc_attr($key_api_mailchimp); ?>" disabled>
        <input type="hidden" name="id_list_mailchimp" class="id_list_mailchimp" value="<?php echo esc_attr($id_list_mailchimp); ?>" disabled>
        <input type="hidden" name="status" class="status_email" value="<?php echo esc_attr($status_email); ?>" disabled>

    </form>
</div>

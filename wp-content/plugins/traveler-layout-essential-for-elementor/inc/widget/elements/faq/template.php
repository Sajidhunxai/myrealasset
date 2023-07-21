<?php
if (!empty($list_faq)) { ?>
    <div class="accordion faq-lib st-<?php echo esc_attr($layout_style) ?>" id="accordion_list_<?php echo esc_attr($id) ?>">
        <?php foreach ($list_faq as $item_faq) {
            $section_id_faq = trim(st_convert_characers_to_slug($ask_faq));
            ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading_<?php echo esc_attr($section_id_faq); ?>">
                    <button class="accordion-button   <?php echo ($item_faq['open_faq'] == 'true') ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr($section_id_faq) ?>" aria-expanded="<?php echo esc_attr($item_faq['open_faq']) ?>" aria-controls="<?php echo esc_attr($section_id_faq) ?>">
                        <span class="label"><?php echo esc_html($item_faq['label_faq']); ?></span>
                        <?php echo esc_html($item_faq['ask_faq']); ?>
                        <i class="stt-icon"></i>
                    </button>
                </h2>
                <div id="<?php echo esc_attr($section_id_faq) ?>" class="accordion-collapse collapse <?php echo ($item_faq['open_faq'] == 'true') ? 'show' : '' ?>" aria-labelledby="heading_<?php echo esc_attr($section_id_faq); ?>" data-bs-parent="#accordion_list_<?php echo esc_attr($id) ?>">
                    <div class="accordion-body">
                        <?php echo esc_html($item_faq['question_faq']); ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
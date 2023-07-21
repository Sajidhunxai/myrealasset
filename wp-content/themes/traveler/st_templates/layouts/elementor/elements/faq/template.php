<?php
if(isset($settings)) :
    $content = apply_filters('stt_elementor_faq_view', '', $settings);

    if($content){
        echo $content;
        return;
    }
endif;
 $section_id_faq = trim(st_convert_characers_to_slug($ask_faq));
?>
<div class="accordion faq style1" id="accordion_<?php echo esc_attr($section_id_faq);?>">
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading_<?php echo esc_attr($section_id_faq);?>">
            <button class="accordion-button   <?php echo ($open_faq == 'true') ? '' : 'collapsed' ?>" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#<?php echo esc_attr($section_id_faq)?>" 
                aria-expanded="<?php echo esc_attr($open_faq)?>" 
                aria-controls="<?php echo esc_attr($section_id_faq)?>"
            >
                <?php echo esc_html($ask_faq);?>
            </button>
        </h2>
        <div id="<?php echo esc_attr($section_id_faq)?>" class="accordion-collapse collapse <?php echo ($open_faq == 'true') ? 'show' : '' ?>" 
            aria-labelledby="heading_<?php echo esc_attr($section_id_faq);?>" 
            data-bs-parent="#accordion_<?php echo esc_attr($section_id_faq);?>"
        >
            <div class="accordion-body">
                <?php echo esc_html($question_faq);?>
            </div>
        </div>
    </div>
</div>

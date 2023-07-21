<?php $tours_faq = get_post_meta(get_the_ID(), 'activity_faq', true);
if(!empty($tours_faq)){
?>
<div class="st-hr"></div>
<h2 class="st-heading-section" id="st-faq">
    <?php echo __('Frequently asked questions', 'traveler'); ?>
</h2>
<div class="st-faq-list">
    <?php
        $i = 0;
        foreach ($tours_faq as $k => $v){
            $section_id = trim(st_convert_characers_to_slug(esc_html($v['title'])));
            ?>
            <div class="accordion faq st-program style1" id="accordion_<?php echo esc_attr($section_id);?>">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading_<?php echo esc_attr($section_id);?>">
                        <button class="accordion-button<?php echo ($i == 0) ? '' : ' collapsed' ?> " 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#<?php echo esc_attr($section_id)?>" 
                            aria-expanded="true"
                            aria-controls="<?php echo esc_attr($section_id)?>"
                        >
                            <?php echo '<i class="icon-question stt-icon-question"></i>' . balanceTags($v['title']);?>
                        </button>
                    </h2>
                    <div id="<?php echo esc_attr($section_id)?>" class="accordion-collapse collapse <?php echo ($i == 0) ? 'show' : '' ?>" 
                        aria-labelledby="heading_<?php echo esc_attr($section_id);?>" 
                        data-bs-parent="#accordion_<?php echo esc_attr($section_id);?>"
                    >
                        <div class="accordion-body">
                            <?php
                                echo '<p>';
                                echo balanceTags($v['desc']);
                                echo '</p>';
                            ?>
                            
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $i++;
        }
    ?>
</div>
<?php 
    }
?>
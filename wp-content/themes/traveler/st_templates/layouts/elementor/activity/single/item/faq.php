<?php
    $tour_faq = get_post_meta( get_the_ID(), 'activity_faq', true );
if (!empty($tour_faq)) {
    ?>
    <div class="st-hr large"></div>
    <div class="accordion-item">
        <h2 class="st-heading-section" id="headingFaq">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaq" aria-expanded="false" aria-controls="collapseFaq">
                <?php echo __('FAQs', 'traveler'); ?>
            </button>
        </h2>
        <div id="collapseFaq" class="accordion-collapse collapse show" aria-labelledby="headingFaq" data-bs-parent="#headingFaq">
            <div class="accordion-body">
                <div class="st-program-list">
                    <?php $i = 0;
                    foreach ($tour_faq as $k => $v) { ?>
                        <div class="item <?php echo ($i == 0) ? 'active' : ''; ?>">
                            <div class="header">
                                <?php echo TravelHelper::getNewIcon('question-help-message', '#5E6D77', '18px', '18px'); ?>
                                <h5><?php echo balanceTags($v['title']); ?></h5>
                                
                                <span class="arrow">
                                    <i class="fa fa-angle-down"></i>
                                </span>
                            </div>
                            <div class="body">
                                <?php echo balanceTags(nl2br($v['desc'])); ?>
                            </div>
                        </div>
                        <?php $i++;
                    } ?>
                </div>
                
            </div>
        </div>
    </div>
    <?php
}?>
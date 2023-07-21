<div class="st-hr large"></div>
<div class="accordion-item">
    <h2 class="st-heading-section" id="headingRules">
    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRules" aria-expanded="true" aria-controls="collapseRules">
        <?php echo esc_html__('Rules', 'traveler') ?>
    </button>
    </h2>
    <div id="collapseRules" class="accordion-collapse collapse show" aria-labelledby="headingRules" data-bs-parent="#headingRules">
        <div class="accordion-body">
            <table class="table st-properties" data-toggle-section="st-properties">
                <tr>
                    <th><?php echo esc_html__('Check In', 'traveler') ?></th>
                    <td>
                        <?php echo get_post_meta($post_id, 'check_in_time', true); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo esc_html__('Check Out', 'traveler') ?></th>
                    <td>
                        <?php echo get_post_meta($post_id, 'check_out_time', true); ?>
                    </td>
                </tr>
                <?php
                $policies = get_post_meta($post_id, 'hotel_policy', true);
                if ($policies) {
                    ?>
                    <tr>
                        <th><?php echo esc_html__('Hotel Policies', 'traveler') ?></th>
                        <td>
                            <div data-show-all="st-policies"
                                data-height="100">
                                <?php
                                foreach ($policies as $policy) {
                                    ?>
                                    <h4 class="f18"><?php echo esc_html($policy['title']); ?></h4>
                                    <div><?php echo balanceTags($policy['policy_description']) ?></div>
                                    <?php
                                }
                                ?>
                            </div>
                            <a href="#" class="st-link block mt20 " data-show-target="st-policies"
                            data-text-less="<?php echo esc_html__('Show Less', 'traveler') ?>"
                            data-text-more="<?php echo esc_html__('Show All', 'traveler') ?>"><span
                                        class="text"><?php echo esc_html__('Show All', 'traveler') ?></span>
                                <i class="fa fa-caret-down ml3"></i></a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
</div>
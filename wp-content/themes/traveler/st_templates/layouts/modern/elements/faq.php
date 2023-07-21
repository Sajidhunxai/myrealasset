<div class="st-faq-new st-faq">
    <h3><?php echo esc_html($attr['title']); ?></h3>
    <?php
    if (isset($attr['list_faq'])) {
        $list_team = vc_param_group_parse_atts($attr['list_faq']);
        if (!empty($list_team)) {
            ?>
            <?php $i = 0;
            foreach ($list_team as $k => $v) { ?>
                <div class="item <?php echo ($i == 0) ? 'active' : ''; ?>">
                    <div class="header">
                        <?php echo TravelHelper::getNewIcon('question-help-message', '#5E6D77', '18px', '18px'); ?>
                        <h5><?php echo balanceTags($v['title']); ?></h5>
                        <span class="arrow">
                            <i class="fa fa-angle-down"></i>
                        </span>
                    </div>
                    <div class="body">
                        <?php echo htmlspecialchars_decode($v['content']); ?>
                    </div>
                </div>
                <?php $i++;
            } ?>
            <?php
        }
    }
    ?>
</div>

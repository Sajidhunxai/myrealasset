<div class="st-faq-new st-faq st-faq--solo st-faq">
    <h3><?php echo esc_html($attr['title']); ?></h3>
    <?php
    if (isset($attr['list_faq'])) {
        $list_team = vc_param_group_parse_atts($attr['list_faq']);
        if (!empty($list_team)) {
            $number1 = $number2 = 0;
            $columns = count($list_team);
            $number1 = round((int)$columns/2);
            $number2 = (int)($columns) - $number1;
            ?>
           <div class="st-flex--faq row">
                            <div class="col-md-6 st-faq--content st-left">
                            <?php 
                                 for($i=0; $i < $number1 ; $i++){
                                    ?>
                                     <div class="item <?php echo ($i == 0) ? 'active' : ''; ?>">
                                        <div class="header">
                                            <h5><?php echo esc_html($list_team[$i]['title']); ?></h5>
                                            <span class="arrow">
                                                <i class="fa fa-angle-down"></i>
                                            </span>
                                        </div>
                                        <div class="body">
                                            <?php echo balanceTags(nl2br($list_team[$i]['content'])); ?>
                                        </div>
                                     </div>
                                     <?php
                                 }
                                 ?>
                            </div>
                            <div class="col-md-6  st-right">
                                 <?php 
                                    if($columns > 1){
                                        for($i = $number1; $i < $columns; $i++){
                                            ?>
                                            <div class="item">
                                                <div class="header">
                                                    <h5><?php echo esc_html($list_team[$i]['title']); ?></h5>
                                                    <span class="arrow">
                                                        <i class="fa fa-angle-down"></i>
                                                    </span>
                                                </div>
                                                <div class="body">
                                                    <?php echo balanceTags(nl2br($list_team[$i]['content'])); ?>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                 ?>
                            </div>
                           
                        </div>
            <?php
        }
    }
    ?>
</div>

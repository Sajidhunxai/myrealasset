<?php 
$cls_packages = STAdminPackages::get_inst();
if($id_package!='no'){
    $packages = $cls_packages->get_packages_by_id($id_package);
}
$position_currency_symbol = TravelHelper::get_current_currency('booking_currency_pos');
if (!$position_currency_symbol) {
	$position_currency_symbol = 'left';
}
$curency_symbol = TravelHelper::get_current_currency('symbol');
if ($id_package!='no' && isset($packages) && !empty($packages)) {
	foreach ($packages as $key => $pack) {
        $pack = $pack;
		if (!empty($pack->package_name)) {
			$package_name =  $pack->package_name;
		} else {
			$package_name =  "";
		}
		if (!empty($pack->package_name)) {
			$package_price =  $pack->package_price;
		} else {
			$package_price =  0;
		}

		if (!empty($pack->package_time)) {
			$package_time =  $pack->package_time;
		} else {
			$package_time =  0;
		}
		$cls_packages = STAdminPackages::get_inst();
		
	} ?>
<?php }
?>
<div class="item-member-ship st-border-radius <?php echo esc_attr($layout);?>">
    <div class="item-st">
        
        <?php 
            if($id_package!='no' && !empty($package_name)){ ?>
                <div class="title">
                    <?php echo esc_html($package_name); ?>
                </div>
            <?php } else {
                if(!empty($title_table)){ ?>
                    <div class="title">
                        <?php echo esc_html($title_table); ?>
                    </div>
                <?php }?>
                
            <?php }
        ?>
        
        <div class="price">
            <span class="price">
                <?php
                if (!empty($position_currency_symbol) && $position_currency_symbol == 'right' or $position_currency_symbol == 'right_space') :?>
                    <span class="currency">
                        <?php 
                            if($id_package!='no'){
                                echo esc_html(TravelHelper::convert_money($package_price));
                                
                            } else {
                                echo esc_html(TravelHelper::convert_money($sale_member));
                            }
                        ?>
                    </span>
                    <span class="sign">
                        <?php echo esc_attr($curency_symbol) ?>
                    </span>
                <?php
                else : ?>
                    <span class="sign"><?php echo esc_attr($curency_symbol) ?></span>
                    <span class="currency">
                        <?php 
                            if($id_package!='no'){
                                echo esc_html(TravelHelper::convert_money($package_price));
                                
                            } else {
                                echo esc_html(TravelHelper::convert_money($sale_member));
                            }
                        ?>
                    </span>
                    <?php
                endif; ?>
            </span>
            <?php if($id_package!='no'){ ?>
                <span class="time-packpage">
                    <?php echo '/&nbsp'.__("per ", 'traveler'); ?> <?php echo esc_html($cls_packages->convert_item($package_time, true)); ?>
                </span>
             <?php }?>
        </div>
       
        <?php 
        if(!empty($list_support)){ ?>
            <div class="pricingContent">
                <ul class="list-unstyled">
                    <?php foreach ($list_support as $sp) {
                        if (!empty($sp["check"]) && ($sp["check"] =='check') ) {
                            $icon = 'stt-icon-check';
                        } else {
                            $icon = 'stt-icon-close';
                        }
                        ?>
                        <li><span class="<?php echo esc_attr($icon);?>"></span><?php echo esc_html($sp["title_items"]) ?></li>
                    <?php } ?>
                </ul>
            </div>
        <?php }
        ?>
        <div class="button-get">
            <div class="clearfix">
                <?php if($id_package != 'no'){
                    if(isset($pack) && !empty($pack)){ ?>
                        <form action="#" method="post">
                            <input type="hidden" name="package_new" value="<?php echo esc_attr($pack->id); ?>">
                            <input type="hidden" name="iconpackage_new" value="<?php echo esc_url($icon); ?>">
                            <input type="hidden" name="package_encrypt_new" value="<?php echo TravelHelper::st_encrypt($pack->id); ?>">
                            <input type="submit" name="add_cart_package_new" value="<?php echo __('Get started', 'traveler'); ?>" class="btn btn-get add_cart_package_new">
                        </form>
                    <?php } ?>
                <?php } else { ?>
                    <a href="<?php echo esc_url($url_button['url']);?>" class="btn btn-get add_cart_package_new"><?php echo esc_html($text_button); ?></a>
                <?php }?>
            </div>
        </div>
        
    </div>
</div>



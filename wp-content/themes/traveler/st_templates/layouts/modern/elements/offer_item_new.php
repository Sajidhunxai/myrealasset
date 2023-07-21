<?php extract(shortcode_atts(array(
    'background_image'          => '',
    'link'          => '',
    'style'          => '',
  ), $attr));
$bg = '';
if(!empty($background_image)){
    $background = wp_get_attachment_image_url($background_image, 'full');
    $class = Assets::build_css('background: url(' . esc_url($background) . ')');
}
?>
<div class="st-offer-new st-offer-item-new item has-matchHeight">
	<?php  echo balanceTags($content);?>
	<?php $link = vc_build_link($link);
    if(!empty($link)){
    	$target = '';
    	if($link['target'] == '_blank')$target = 'target="_blank"'; ?>
        <p class="st_but">
        	<a href="<?php echo esc_url($link['url']);?>" class="btn btn-default <?php echo ($style);?>" <?php echo esc_html($target) ;?>><?php echo esc_attr($link['title'])?></a>
        </p>
    <?php } ?>
    <div class="img-cover <?php echo esc_attr($class) ?>"></div>
</div>
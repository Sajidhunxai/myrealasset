<?php extract(shortcode_atts(array(
    'title'         => '',
    'content_over'         => '',
    'link'         => '',
  ), $attr));
?>
<div class="st-overview-content">
	<div class="st-content-over">
		<div class="st-content">
			<div class="title">
				<h3><?php echo esc_html($title); ?></h3>
			</div>
			<div class="content">
				<?php echo esc_html($content_over); ?>
			</div>
			<div class="read_more">
				<a href="<?php echo (vc_build_link($link)['url']);?>" <?php if (isset(vc_build_link($link)['target']) && !empty(vc_build_link($link)['target'])) { echo ' target="'. vc_build_link($link)['target'] .'"'; }?>><?php echo (vc_build_link($link)['title']);?></a>
			</div>
		</div>
	</div>
</div>

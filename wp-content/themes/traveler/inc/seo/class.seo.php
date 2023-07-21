<?php
if (!class_exists('STTravelerSeo')) {
	class STTravelerSeo { 
		public $st_webp_img;
		public $st_optimize_css;
		public $st_optimize_js;
		function __construct() {

			add_filter( 'style_loader_src', array($this,'remove_css_js_ver'), 10, 2 );
			add_filter( 'the_content',array($this,'seo_friendly_images'));
			add_shortcode( 'toc',array($this,'output_toc'));
        }

		 //* TN - Remove Query String from Static Resources
		function remove_css_js_ver( $src ) {
		if( strpos( $src, '?ver=' ) )
		$src = remove_query_arg( 'ver', $src );
		return $src;
		}
		

		function seo_friendly_images_process( $matches ) {
			
			
		
			# take care of unusual endings
			$matches[0] = preg_replace( '|([\'"])[/ ]*$|', '\1 /', $matches[0] );
			
			### Normalize spacing around attributes.
			$matches[0] = preg_replace( '/\s*=\s*/', '=', substr( $matches[0], 0, strlen( $matches[0] ) - 2 ) );
			### Get source.
			
			preg_match( '/src\s*=\s*([\'"])?((?(1).+?|[^\s>]+))(?(1)\1)/', $matches[0], $source );
			
			$saved = $source[2];
			
			### Swap with file's base name.
			preg_match( '%[^/]+(?=\.[a-z]{3}(\z|(?=\?)))%', $source[2], $source );
			### Separate URL by attributes.
			$pieces = preg_split( '/(\w+=)/', $matches[0], -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY );
			$url = preg_replace( '/-([0-9]{1,5})x([0-9]{1,5})\./i', '.', $saved );
			$rm_image_id = attachment_url_to_postid($url);
			$alttext_rep = get_post_meta( $rm_image_id, '_wp_attachment_image_alt', true );
			
			if (  !empty($alttext_rep) || !in_array('alt=', $pieces)) {
			
				
				if ( ! in_array( 'alt=', $pieces ) ) {
					array_push( $pieces, ' alt="' . $alttext_rep . '"' );
				} else {
					$index			  = array_search( 'alt=', $pieces );
					$pieces[$index+1] = '"' . $alttext_rep . '" ';
				}
			}
			
			return implode( '', $pieces ) . ' /';
		}   
		function seo_friendly_images( $content ) {
		  
			$replaced = preg_replace_callback( '/<img[^>]+/', array($this,'seo_friendly_images_process') , $content, 20 );
			
			return $replaced;
		
			
			return $content;
		}
		
		function output_toc( ) {
			ob_start(); ?>
			<div class="anchorific"><div><?php echo esc_html__( 'Table of Contents', 'traveler' )?></div></div>
		<?php 
		return ob_get_clean();
		}
	}
	new STTravelerSeo();
}



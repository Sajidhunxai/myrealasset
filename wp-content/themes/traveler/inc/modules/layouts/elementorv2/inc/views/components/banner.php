<?php
$inner_style      = '';
$thumb_id         = get_post_thumbnail_id( get_the_ID() );
$menu_transparent = st()->get_option( 'menu_transparent', '' );
if ( $menu_transparent === 'on' ) {
	$banner_transparent = st()->get_option( 'banner_transparent', '' );
	if ( ! empty( $img_url ) ) {
		$inner_style = Assets::build_css( 'background-image: url(' . esc_url( $img_url ) . ') !important;' );
	} elseif ( ! empty( $banner_transparent ) ) {
			$inner_style = Assets::build_css( 'background-image: url(' . esc_url( $banner_transparent ) . ') !important;' );
	}
} elseif ( ! empty( $thumb_id ) ) {
	$img         = wp_get_attachment_image_url( $thumb_id, 'full' );
	$inner_style = Assets::build_css( 'background-image: url(' . esc_url( $img ) . ') !important;' );
}

if ( $menu_transparent == 'on' || is_page_template( 'template-blog.php' ) || is_archive() ) {?>
<div class="banner st-bg-feature <?php echo esc_attr( $inner_style ) ?>">
	<div class="container">
		<div class="st-banner-search-form style_2">
			<?php if ( empty( $type_page ) ) { ?>
				<h1 class="st-banner-search-form__title">
					<?php if ( is_archive() ) { ?>
						<?php the_archive_title( '', '' ); ?>

						<?php
					} else {
						echo get_the_title();
					}
					?>
				</h1>
				<?php echo st_breadcrumbs_new(); ?>
			<?php } else { ?>
				<h1 class="st-banner-search-form__title">
					<?php echo __( 'Partner Page', 'traveler' ); ?>
				</h1>
			<?php } ?>

		</div>
	</div>
</div>
<?php } else {
	st_breadcrumbs_new();
}
?>

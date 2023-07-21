<?php
get_header();
?>
<div id="st-content-wrapper" class="st-style-elementor blog-style3">
	<?php
	$banner_blog = st()->get_option( 'header_blog_image', '' );
	echo stt_elementorv2()->loadView( 'components/banner', [ 'img_url' => $banner_blog ] );
	?>
	<div class="container">
		<div class="st-blog">
			<div class="row">
					<!--Sidebar-->
					<?php
					$sidebar_pos = apply_filters( 'st_blog_sidebar', 'right' );
					if ( $sidebar_pos == 'left' ) {
						echo "<div class='col-12 col-md-12 col-lg-4'><aside class='sidebar-left sticky-top'>";
						?>
						<?php dynamic_sidebar( apply_filters( 'st_blog_sidebar_id', 'blog-sidebar' ) ); ?>
					</aside>
				</div>
				<?php } ?>
				<div class="<?php echo ( $sidebar_pos == 'no' ) ? 'col-12 col-md-12 col-lg-12' : 'col-12 col-md-12 col-lg-8'; ?> ">
					<div class="content">
						<?php
							$args  = [
								'post_type' => 'post',
								'paged'     => get_query_var( 'paged' ),
							];
							$query = new WP_Query( $args );
							if ( $query->have_posts() ) :
								echo '<div class="blog-wrapper">';
								while ( $query->have_posts() ) {
									$query->the_post();
									echo stt_elementorv2()->loadView( 'blog/content' );
								}
								echo '</div><div class="pagination">';
								TravelHelper::paging( $query, false );
								echo '</div>';
						else :
							echo st()->load_template( 'layouts/modern/blog/content', 'none' );
						endif;
						wp_reset_query();
						?>
					</div>
				</div>
					<!--Sidebar-->
					<?php
					$sidebar_pos = apply_filters( 'st_blog_sidebar', 'right' );
					if ( $sidebar_pos == 'right' ) {
						echo "<div class='col-12 col-md-12 col-lg-4'><aside class='sidebar-right sticky-top'>";
						?>
						<?php dynamic_sidebar( apply_filters( 'st_blog_sidebar_id', 'blog-sidebar' ) ); ?>
					</aside>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php
get_footer()
?>

<?php
	/**
	 * Created by PhpStorm.
	 * User: Administrator
	 * Date: 30-11-2018
	 * Time: 9:24 AM
	 * Since: 1.0.0
	 * Updated: 1.0.0
	 */
while ( have_posts() ) :
	the_post();
	?>
		<div id="st-content-wrapper" class="st-style-elementor blog-style3">
	<?php
		$menu_transparent = st()->get_option( 'menu_transparent', '' );
	if ( $menu_transparent === 'on' ) {
		$banner_blog = st()->get_option( 'header_blog_image', '' );
		$thumb_id    = get_post_thumbnail_id( get_the_ID() );
		if ( ! empty( $thumb_id ) ) {
			$banner_blog = wp_get_attachment_image_url( $thumb_id, 'full' );
		}
		echo stt_elementorv2()->loadView( 'components/banner', [ 'img_url' => $banner_blog ] );
	} else {
		st_breadcrumbs_new();
	}
	?>
			<div class=" st-blog ">
				<div class="container">
					<div class="blog-content content">
						<div class="row">
							<div class="col-12 col-md-12 col-lg-8">
								<div class="article-style3">
									<div class="header">
										<header class="post-header">
										<?php
											$format = get_post_format();
										if ( ! $format ) {
											$format = 'image';
										}
											echo st()->load_template( 'layouts/modern/blog/single/loop/loop', $format );
										?>
										</header>
										<?php
										$category_detail = get_the_category( get_the_ID() );
										if ( ! empty( $category_detail ) ) {
											?>
											<div class="cate category-color">
												<ul>
													<?php
													$v          = $category_detail[0];
													$color      = get_term_meta( $v->term_id, '_category_color', true );
													$bg_rgba    = st_hex2rgb_new( $color, 0.06 );
													$text_rgba  = st_hex2rgb_new( $color, 1 );
													$inline_css = '';
													if ( ! empty( $color ) ) {
														$inline_css = 'style="background:' . esc_attr( $bg_rgba ) . '"';
													}
													echo '<li ' . ( $inline_css ) . '><a href="' . get_category_link( $v->term_id ) . '" style="color:' . esc_attr( $text_rgba ) . '">' . esc_html( $v->name ) . '</a></li>';
													?>
												</ul>
											</div>
										<?php } ?>
									</div>
									<div class="post-inner">

										<?php
										$menu_transparent = st()->get_option( 'menu_transparent', '' );
										if ( $menu_transparent !== 'on' ) :
											?>
											<h1 class="title"><?php the_title(); ?></h1>
										<?php endif; ?>

										<?php echo st()->load_template( 'layouts/modern/blog/content', 'meta' ); ?>
									</div>
									<div class="post-content"><?php the_content() ?></div>
									<div class="d-flex  justify-content-between tags-share">
										<div class="tags d-flex">

											<?php
											$tags = get_the_tags();
											if ( $tags ) {
												echo '<span class="stt-icon stt-icon-tag"></span>';
												echo '<div class="box-list">';
												foreach ( $tags as $tag ) {
													?>
														<a href="<?php echo get_tag_link( $tag->term_id ) ?>"
															class="tag-item"><?php echo esc_html( $tag->name ) ?></a>
														<?php
												}
												echo '</div>';
											}
											?>
										</div>
										<div class="share">
											<a class="share-item"
												href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
												target="_blank" rel="noopener" original-title="Facebook"><i
														class="stt-icon stt-icon-facebook"></i></a>
											<a class="share-item"
												href="https://twitter.com/share?url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
												target="_blank" rel="noopener" original-title="Twitter"><i
														class="stt-icon stt-icon-twitter"></i></a>
										</div>
									</div>

									<div class="pagination clearfix">
										<?php

										$next_post     = get_next_post();
										$previous_post = get_previous_post();
										the_post_navigation( [
											'next_text' => $next_post ? '<div class="box"><span class="meta-nav" aria-hidden="true">' . __( 'Next', 'traveler' ) . '<span class="stt-icon stt-icon-arrow-right"></span></span> ' .
												'<span class="screen-reader-text">' . __( 'Next post:', 'traveler' ) . '</span> ' .
												'<span class="post-title">%title</span></div>' . get_the_post_thumbnail( $next_post->ID, 'thumbnail' ) : '',
											'prev_text' => $previous_post ? get_the_post_thumbnail( $previous_post->ID, 'thumbnail' ) . '<div class="box"><span class="meta-nav" aria-hidden="true"><span class="stt-icon stt-icon-arrow-left"></span>' . __( 'Previous', 'traveler' ) . '</span> ' .
											'<span class="screen-reader-text">' . __( 'Previous post:', 'traveler' ) . '</span>' .
											'<span class="post-title">%title</span></div>' : '',
										] );
										?>
									</div>
									<div id="comment-wrapper">
										<h2 class="title"><?php comments_number( __( '0 Comment', 'traveler' ), __( '1 Comment', 'traveler' ), __( '% Comments', 'traveler' ) ); ?></h2>
										<ol class="comment-list">
										<?php
											$comment_per_page = (int) get_option( 'comments_per_page', 10 );
											$paged            = ( get_query_var( 'cpage' ) ) ? get_query_var( 'cpage' ) : 1;

											$offset = ( $paged - 1 ) * $comment_per_page;
											$args   = [
												'number'  => $comment_per_page,
												'offset'  => $offset,
												'post_id' => get_the_ID(),
												'status'  => [ 'approve' ],
											];
											global $sitepress;
											remove_filter( 'comments_clauses', [ $sitepress, 'comments_clauses' ], 10, 2 );
											$comments_query = new WP_Comment_Query;
											$comments       = $comments_query->query( $args );

											wp_list_comments( [
												'style'    => 'ol',
												'short_ping' => true,
												'avatar_size' => 50,
												'page'     => $paged,
												'per_page' => $comment_per_page,
												'callback' => [ 'TravelHelper', 'comments_list_new' ],
											], $comments );
											add_filter( 'comments_clauses', [ $sitepress, 'comments_clauses' ], 10, 2 );
										?>
										</ol>
										<?php
										if ( comments_open() ) {

											wp_enqueue_script( 'comment-reply' )
											?>
												<div id="write-comment">
												<?php
													STT_Hotelv2_General::comment_form_post();
												?>
												</div>
												<?php
										}
										?>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-4">
								<!--Sidebar-->
								<aside class='sidebar-right sticky-top'>
									<?php dynamic_sidebar( apply_filters( 'st_blog_sidebar_id', 'blog-sidebar' ) ); ?>
								</aside>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endwhile; ?>

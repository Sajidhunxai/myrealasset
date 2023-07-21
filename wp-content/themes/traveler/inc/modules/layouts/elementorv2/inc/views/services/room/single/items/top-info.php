<div class="st-service-header2">
	<div class="left">

		<?php
		$menu_transparent = st()->get_option( 'menu_transparent', '' );
		if ( $menu_transparent !== 'on' ) : ?>
			<h1 class="st-heading"><?php the_title(); ?></h1>
		<?php endif; ?>

		<?php if ( $address ) { ?>
		<div class="sub-heading">
			<div class="d-flex align-items-center">
				<div class="st-address d-flex align-items-center"><i class="stt-icon-location1"></i><?php echo esc_html( $address ); ?> </div>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="right">
		<div class="shares dropdown">
			<a href="javascript:void(0);" class="share-item social-share">
				<span class="stt-icon stt-icon-share"></span>
			</a>
			<ul class="share-wrapper">
				<li><a class="facebook"
						href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
						target="_blank" rel="noopener" original-title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
				<li><a class="twitter"
						href="https://twitter.com/share?url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
						target="_blank" rel="noopener" original-title="Twitter"><i class="fab fa-twitter"></i></a></li>
				<li><a class="no-open pinterest"
						href="http://pinterest.com/pin/create/bookmarklet/?url=<?php the_permalink() ?>&is_video=false&description=<?php the_title() ?>&media=<?php echo get_the_post_thumbnail_url( get_the_ID() ) ?>"
						target="_blank" rel="noopener" original-title="Pinterest"><i class="fab fa-pinterest-p"></i></a></li>
				<li><a class="linkedin"
						href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink() ?>&amp;title=<?php the_title() ?>"
						target="_blank" rel="noopener" original-title="LinkedIn"><i class="fab fa-linkedin-in"></i></a></li>
			</ul>
		</div>
	</div>
</div>

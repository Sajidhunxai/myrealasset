<?php
$main_color       = st()->get_option( 'main_color', '#5191FA' );
$link_color       = st()->get_option( 'link_color', '#1A2B48' );
$grey_color       = st()->get_option( 'grey_color', '#5E6D77' );
$heading_color    = st()->get_option( 'heading_color', '#232323' );
$body_color       = st()->get_option( 'body_color', '#232323' );
$link_color_hover = st_hex2rgb_new( $main_color, 0.9 );


$star_color  = st()->get_option( 'star_color', '#FA5636' );
$bg_featured = st()->get_option( 'st_text_featured_bg', '#ed0925' );

$bg_sale = st()->get_option( 'st_text_sale_bg', '#3366cc' );
?>

@media screen and (max-width: 782px) {
	html {
	margin-top: 0px !important;
	}
	<?php if ( ! check_using_elementor() ) { ?>
	.admin-bar.logged-in #header {
		padding-top: 45px;
	}
<?php } ?>
	.logged-in #header {
	margin-top: 0;
	}
}
<?php
$menu_style = st()->get_option( 'menu_style_modern', 1 );
if ( $menu_style == 9 ) {
	$main_color = st()->get_option( 'main_color', '#232323' );
}
?>

:root {
	--main-color: <?php echo esc_attr( $main_color ); ?>;
	--body-color: <?php echo esc_attr( $body_color ); ?>;
	--link-color: <?php echo esc_attr( $link_color ); ?>;
	--link-color-hover: <?php echo esc_attr( $link_color_hover ); ?>;
	--grey-color: <?php echo esc_attr( $grey_color ); ?>;
	--heading-color: <?php echo esc_attr( $heading_color ); ?>;
	--light-grey-color: #EAEEF3;
	--orange-color: #FA5636;
}

<?php if ( $star_color ) : ?>
	.booking-item-rating .fa ,
	.booking-item.booking-item-small .booking-item-rating-stars,
	.comment-form .add_rating,
	.booking-item-payment .booking-item-rating-stars .fa-star,
	.st-item-rating .fa,
	li  .fa-star , li  .fa-star-o , li  .fa-star-half-o,
	.st-icheck-item label .fa,
	.single-st_hotel #st-content-wrapper .st-stars i,
	.service-list-wrapper .item .st-stars i,
	.services-item.item-elementor .item .content-item .st-stars .stt-icon,
	.st-hotel-result .item-service .thumb .booking-item-rating-stars li i {
		color:<?php echo esc_attr( $star_color ) ?>;
	}
<?php endif; ?>

.feature_class , .featured-image .featured{
background: <?php echo esc_attr( $bg_featured ) ?> !important;
}
.search-result-page.st-rental .item-service .featured-image .featured:after{
	border-bottom: 29px solid <?php echo esc_attr( $bg_featured ); ?>;
}
.room-item .content .btn-show-price, .room-item .content .show-detail , .btn, .wp-block-search__button ,
#gotop , .form-submit .submit{
	background: <?php echo esc_attr( $main_color ) ?>;
	color:#FFF;
}
.room-item .content .btn-show-price:hover, .room-item .content .show-detail:hover ,  .btn:hover, .wp-block-search__button:hover ,
#gotop:hover , .form-submit .submit:hover{
	background: <?php echo esc_attr( $link_color_hover ) ?>;
	color:#FFF;
}
.feature_class::before {
	border-color: <?php echo esc_attr( $bg_featured ) ?> <?php echo esc_attr( $bg_featured ) ?> transparent transparent;
}
.feature_class::after {
	border-color: <?php echo esc_attr( $bg_featured ) ?> transparent <?php echo esc_attr( $bg_featured ) ?> <?php echo esc_attr( $bg_featured ) ?>;
}
.featured_single .feature_class::before {
	border-color: transparent <?php echo esc_attr( $bg_featured ) ?> transparent transparent;
}
.item-nearby .st_featured::before {
	border-color: transparent transparent <?php echo esc_attr( $bg_featured ) ?> <?php echo esc_attr( $bg_featured ) ?>;
}
.item-nearby .st_featured::after {
	border-color: <?php echo esc_attr( $bg_featured ) ?> <?php echo esc_attr( $bg_featured ) ?> <?php echo esc_attr( $bg_featured ) ?> transparent  ;
}

.st_sale_class {
	background-color: <?php echo esc_attr( $bg_sale ) ?>;
}
.st_sale_class.st_sale_paper * {color: <?php echo esc_attr( $bg_sale ); ?> }
.st_sale_class .st_star_label_sale_div::after,.st_sale_label_1::before{
	border-color: <?php echo esc_attr( $bg_sale ); ?> transparent transparent <?php echo esc_attr( $bg_sale ); ?> ;
}

.btn.active.focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn:active:focus, .btn:focus {
	outline: none;
}

.st_sale_class .st_star_label_sale_div::after {
	border-color: <?php echo esc_attr( $bg_sale ); ?>
}



<?php if ( st()->get_option( 'right_to_left' ) == 'on' ) { ?>
	.st_featured {
		padding: 0 13px 0 3px;
	}
	.featured_single .st_featured::before {
		border-color: <?php echo esc_attr( $bg_featured ) ?> transparent transparent transparent  ;
		right: -26px;
	}
	.item-nearby  .st_featured::before {
		border-color: <?php echo esc_attr( $bg_featured ) ?> transparent transparent <?php echo esc_attr( $bg_featured ) ?>;
	}

	.item-nearby .st_featured {
		bottom: 10px;
		left: -10px;
		right: auto;
		top: auto;
		padding-left:13px!important;
	}
	.item-nearby  .st_featured::before {
		left: 0;
		right: auto;
		bottom: -10px;
		top: auto;
	}
	.item-nearby .st_featured::before {
		border-color: transparent <?php echo esc_attr( $bg_featured ) ?> <?php echo esc_attr( $bg_featured ) ?>  transparent;
	}
	.item-nearby .st_featured::after {
		border-color:   transparent <?php echo esc_attr( $bg_featured ) ?> transparent transparent;
		border-width: 14px;
		right: -26px;
	}
	.featured_single {
		padding-left: 70px;
		padding-right: 0px;
	}
<?php } ?>

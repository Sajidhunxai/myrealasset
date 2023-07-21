<?php
extract(
  shortcode_atts(
    array(
        "style" => 'style1',
        'title' => '',
        'link_url' => '',
        'description' => '',
        'background_image' => ''
    ),
    $attr
  )
);

$background_image_url_obj = wp_get_attachment_image_src( $background_image, array('', '700') );
$background_image_url = !empty( $background_image_url_obj[0] ) ? $background_image_url_obj[0] : "";
if ( empty( $background_image_url ) ) $background_image_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
if(!empty($style)){
    if($style == 'style1'){?>
        <div class="row">
            <div class="banner-apartment">
                <div class="banner-apartment-content">
                    <img class="banner-background" src="<?php echo ( $background_image_url ) ?>" alt="<?php esc_attr_e( $title ) ?>" />
                    <div class="banner-text">
                        <div class="container">
                            <h1 class="banner-title"><?php esc_html_e( $title , 'traveler' ); ?></h1>
                            <p class="banner-description"><?php esc_html_e( $description ) ?></p>
                            <?php
                            if ( ! empty( $link_url ) ) {
                            $link_obj = vc_build_link($link_url); ?>
                            <a href="<?php echo esc_url( $link_obj['url'] ) ?>" title="<?php echo esc_attr( $link_obj['title'] ) ?>" class="btn banner-btn"><?php _e( 'SEE APARTMENTS', 'traveler' ) ?>
                                <?php
                                } else { ?>
                                <a href="#" class="btn banner-btn"><?php _e( 'SEE APARTMENTS', 'traveler' ) ?>
                                    <?php
                                    }
                                    ?>
                                    <img src="<?php echo esc_url( get_template_directory_uri() . '/v2/images/svg/ico_next.svg' ) ?>"
                                         alt="<?php esc_attr_e( 'ico_next', 'traveler' ) ?>">
                                </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php }elseif ($style =='style2'){ ?>
        <div class="row">
            <div class="banner-apartment <?php echo esc_attr($style) ?>">
                <div class="banner-apartment-content">
                    <img class="banner-background" src="<?php echo ( $background_image_url ) ?>" alt="<?php esc_attr_e( $title ) ?>" />
                    <div class="banner-text">
                        <div class="container">
                            <h1 class="banner-title"><?php esc_html_e( $title , 'traveler' ); ?></h1>
                            <p class="banner-description"><?php esc_html_e( $description ) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   <?php }
}
?>


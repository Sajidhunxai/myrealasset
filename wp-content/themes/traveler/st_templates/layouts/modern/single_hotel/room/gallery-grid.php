<?php
/**
 * Created by PhpStorm.
 * User: HanhDo
 * Date: 3/7/2019
 * Time: 4:32 PM
 */
$gallery_array = get_post_meta(get_the_ID(), 'gallery', true);
$image_arr = array();
if(!empty($gallery_array)){
    $img_arr = explode(',', $gallery_array);
    if(!empty($img_arr)){
        foreach ($img_arr as $k => $v){
            array_push($image_arr, wp_get_attachment_image_url($v, 'full'));
        }
    }
}

?>
<div class="sts-room-gallery-grid mt30">
    <h2><?php esc_html_e( 'Interior Decor', 'traveler' ) ?></h2>
    <?php if ( !empty( $image_arr ) ) { ?>
    <div class="gallery-grid-content">
                <?php
                foreach ( $image_arr as $value ) {
                    ?>
                    <div class="gallery-grid-item">
                        <img class="gallery-grid-item-image" src="<?php echo esc_url( $value ) ?>" alt="<?php echo get_the_title();?>"/>
                    </div>
                    <?php
                }
                ?>
        </div>
    <?php } ?>
</div>

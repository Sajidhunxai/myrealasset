<?php
$gallery_array = array();
if(!empty($attr['images'])){
    $img_arr = explode(',', $attr['images']);
    if(!empty($img_arr)){
        foreach ($img_arr as $k => $v){
            array_push($gallery_array, wp_get_attachment_image_url($v, 'full'));
        }
    }
}
?>
<div class="st-aboutus-gallery">
    <?php if ( !empty( $gallery_array ) ) { ?>
        <div class="st-flickity st-gallery">
            <div class="carousel"
                 data-flickity='{ "wrapAround": true, "pageDots": true , "autoPlay" : true}'>
                <?php
                foreach ( $gallery_array as $value ) {
                    ?>
                    <div class="item" style="background-image: url('<?php echo esc_attr($value); ?>')"></div>
                    <?php
                }
                ?>
            </div>
            <div class="slogan">
                <h4><?php echo esc_html($attr['title']); ?></h4>
                <?php
                $link  = vc_build_link($attr['link']);
                if(!empty($link)){
                    ?>
                        <a href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($link['target']); ?>" class="btn btn-primary"><?php echo esc_html($link['title']); ?></a>
                    <?php
                }
                ?>
            </div>
        </div>
    <?php } ?>
</div>

<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 13-11-2018
     * Time: 3:15 PM
     * Since: 1.0.0
     * Updated: 1.0.0
     */
    $class_pos = 'image-left';
    if($style == 'icon_top_1'){
        $class_pos = 'image-top';
    }elseif($style == 'icon_top_2'){
        $class_pos = 'image-top-2';
    }elseif($style == 'icon_top_3'){
        $class_pos = 'image-top-3';
    }
?>
<div class="st-featured-item <?php echo esc_attr($class_pos); ?>">
    <div class="image">
        <?php
            if ( !empty( $icon ) ) {
                echo '<img src="' . wp_get_attachment_image_url( $icon, 'full', true ) . '" class="img-responsive" alt="'.esc_html( $title ).'">';
            }
        ?>
    </div>
    <div class="content">
        <h3 class="title"><?php echo esc_html( $title ); ?></h3>
        <div class="desc"><?php echo balanceTags( $desc ); ?></div>
    </div>
</div>

<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 14-11-2018
     * Time: 8:28 AM
     * Since: 1.0.0
     * Updated: 1.0.0
     */
    $star  = !isset( $star ) ? 5 : round($star, 0);
    $style = ( !isset( $style ) ) ? '' : 'style-2';
    $element = ( !isset( $element ) ) ? 'div' : $element;
    $icon_star = !empty($icon_star) ? $icon_star : 'fa fa-star';
?>
<<?php echo esc_html($element); ?> class="st-stars <?php echo esc_attr( $style ); ?>">
    <?php
        if($style == '') {
            for ( $i = 1; $i <= $star; $i++ ) {
                ?>
                <i class="<?php echo esc_html($icon_star);?>"></i>
                <?php
            }
        }else{
            for($i = 1; $i<= 5; $i++){
                if($i <= $star){
                    echo '<i class="'.esc_html($icon_star).'"></i>';
                }else{
                    echo '<i class="'.esc_html($icon_star).' grey"></i>';
                }
            }
        }
    ?>
</<?php echo esc_attr($element); ?>>


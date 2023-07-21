<?php
$star  = !isset( $star ) ? 5 : round($star, 0);
$style = ( !isset( $style ) ) ? '' : 'style-2';
$element = ( !isset( $element ) ) ? 'div' : $element;
?>
<<?php echo esc_html($element); ?> class="st-stars <?php echo esc_attr( $style ); ?>">
<?php
if($style == '') {
    for ( $i = 1; $i <= $star; $i++ ) {
        ?>
        <span class="stt-icon stt-icon-star1"></span>
        <?php
    }
}else{
    for($i = 1; $i<= 5; $i++){
        if($i <= $star){
            echo '<span class="stt-icon stt-icon-star1"></span>';
        }else{
            echo '<span class="stt-icon stt-icon-star1 gray"></span>';
        }
    }
}
?>
</<?php echo esc_attr($element); ?>>


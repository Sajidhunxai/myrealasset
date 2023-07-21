 <!--Activity highlight-->
 <?php
    $tours_highlight = get_post_meta( get_the_ID(), 'activity_highlight', true );
    if ( !empty( $tours_highlight ) ) {
        $arr_highlight = explode( "\n", trim( $tours_highlight ) );
        ?>
        <div class="st-highlight">
            <h2 class="st-heading-section"><?php echo __( 'Highlights', 'traveler' ); ?></h2>
            <ul>
                <?php
                    if ( !empty( $arr_highlight ) ) {
                        foreach ( $arr_highlight as $k => $v ) {
                            echo '<li class="list-unstyled d-flex align-items-center"><i class="stt-icon-check"></i>' . esc_html($v) . '</li>';
                        }
                    }
                ?>
            </ul>
        </div>
<?php } ?>
<!--End Activity highlight-->
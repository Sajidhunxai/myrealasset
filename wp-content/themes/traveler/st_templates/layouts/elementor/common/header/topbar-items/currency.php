<?php
    $currency         = TravelHelper::get_currency();
    $current_currency = TravelHelper::get_current_currency();
    $classes = !isset($show) ? 'd-none d-sm-inline-block' : '';
?>
<li class="dropdown dropdown-currency <?php echo esc_attr($classes) ?>">
    <a href="#" class="dropdown-toggle"  role="button" id="dropdown-currency" data-bs-toggle="dropdown" aria-expanded="false">
        <?php
            if ( isset( $current_currency[ 'name' ] ) ) {
                echo esc_html( $current_currency[ 'name' ] );
            } ?>
        <?php if ( !empty( $currency ) and count( $currency ) >= 2 ): ?>
            <i class="fa fa-angle-down"></i>
        <?php endif; ?>
    </a>
    <?php if ( !empty( $currency ) and count( $currency ) >= 2 ): ?>
    <ul class="dropdown-menu" aria-labelledby="dropdown-currency">
        <?php
            if ( !empty( $currency ) ) {
                foreach ( $currency as $key => $value ) {
                    if ( $current_currency[ 'name' ] != $value[ 'name' ] ){
                        echo '<li><a href="' . esc_url( add_query_arg( 'currency', $value[ 'name' ] ) ) . '">' . esc_html($value[ 'name' ]) . '</a>
                        </li>'; 
                        
                    }
                        
                }
            }
        ?>
    </ul>
    <?php endif; ?>
</li>
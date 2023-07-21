<?php
    /**
     * Created by PhpStorm.
     * User: Administrator
     * Date: 13-11-2018
     * Time: 8:27 AM
     * Since: 1.0.0
     * Updated: 1.0.0
     */
    if ( function_exists( 'icl_get_languages' ) ) {
        $langs = icl_get_languages( 'skip_missing=0' );
    } else {
        $langs = [];
    }
    if(!isset($show_code))
        $show_code = false;

    if ( !empty( $langs ) ) {
        ?>
        <li class="dropdown dropdown-language">
            <?php
                foreach ( $langs as $key => $value ) {
                    $lang_name = $value['native_name'];
                    if($show_code)
                        $lang_name = strtoupper($value['language_code']);
                    if ( $value[ 'active' ] == 1 ) {
                        ?>
                        <a href="" data-bs-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false"><?php echo esc_html($lang_name); ?> <i
                                    class="fa fa-angle-down"></i></a>
                        <?php
                        break;
                    }
                }
            ?>

            <ul class="dropdown-menu">
                <?php
                    foreach ( $langs as $key => $value ) {
                        if ( $value[ 'active' ] == 1 ) continue;
                        $lang_name = $value['native_name'];
                        if($show_code){
                            $lang_name = strtoupper($value['language_code']);
                        }
                        $mapping_detect = st()->get_option('booking_currency_mapping_detect', 'off');
                        if($mapping_detect === 'on'){
                            $url_lang = add_query_arg( 'currency', TravelHelper::get_currency_by_language($value['code']), $value[ 'url' ] );
                        } else {
                            $url_lang =  $value[ 'url' ];
                        }
                        ?>
                        <li><a href="<?php echo esc_url($url_lang) ?>"><?php echo esc_html($lang_name); ?></a>
                        </li>
                    <?php 
                    }
                ?>
            </ul>
        </li>
        <?php
    }
?>

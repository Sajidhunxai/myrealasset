<?php
global $post;
$info_price = STTour::get_info_price();
if ( isset( $_REQUEST['start'] ) && strlen( $_REQUEST['start'] ) > 0 ) {
    $_REQUEST['check_in'] = $_REQUEST['check_out'] = $_REQUEST['end'] = $_REQUEST['start'];
}
$url=st_get_link_with_search(get_permalink(),array('start','end','date','duration','people'),$_REQUEST);

$class = 'col-lg-4 col-md-6 col-sm-6 col-xs-12 item-service grid-item has-matchHeight';
if(isset($top_search) and $top_search)
    $class = 'col-lg-3 col-md-4 col-sm-6 col-xs-12 item-service grid-item has-matchHeight';
if(isset($slider) and $slider)
    $class = 'item-service grid-item has-matchHeight';
?>
<div class="<?php echo esc_attr($class); ?>">
    <div class="service-border">
        <div class="thumb">
            <a href="<?php echo esc_url($url); ?>">
                <?php
                if(has_post_thumbnail()){
                    //the_post_thumbnail(array(680, 630), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive'));
                    the_post_thumbnail(array(540, 720), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive'));
                }else{
                    echo '<img src="'. get_template_directory_uri() . '/img/no-image.png' .'" alt="Default Thumbnail" class="img-responsive" />';
                }
                ?>
            </a>

            <div class="service-price">
                <span class="price">
                        <?php
                        $post_id = get_the_ID();

                        $price_type = STTour::get_price_type($post_id);
                        if($price_type == 'person' or $price_type == 'fixed_depart'){
                            $prices = STTour::get_price_person( $post_id );
                        }
                        else{
                            $prices = STTour::get_price_fixed( $post_id );

                        }
                        $price_old = $price_new = 0;
                        if($price_type == 'person' or $price_type == 'fixed_depart') {
                            if ( ! empty( $prices['adult'] ) ) {
                                $price_old = $prices['adult'];
                                $price_new = $prices['adult_new'];
                            } elseif ( ! empty( $prices['child'] ) ) {
                                $price_old = $prices['child'];
                                $price_new = $prices['child_new'];
                            } elseif ( ! empty( $prices['infant'] ) ) {
                                $price_old = $prices['infant'];
                                $price_new = $prices['infant_new'];
                            }
                        }else{
                            $price_old = $prices['base'];
                            $price_new = $prices['base_new'];
                        }
                        if ( $price_new != $price_old ) {
                            echo '<p class="text-small lh1em item onsale "><span class="st-ico">'. TravelHelper::getNewIcon('thunder', '#ffab53', '10px', '16px') .'</span>' . TravelHelper::format_money( $price_old ) . '</p>';
                        }
                        $price_new = TravelHelper::format_money( $price_new ) ;
                        echo '<p class="text-lg lh1em item "> ' . esc_html($price_new) . '<span class="st-text"> ' . esc_html__('/person','traveler') . ' </span></p>';

                        ?>
                    </span>
            </div>
        </div>
    </div>
</div>

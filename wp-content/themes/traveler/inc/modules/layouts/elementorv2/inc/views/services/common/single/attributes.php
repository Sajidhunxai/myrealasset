<?php
$all_attribute = TravelHelper::st_get_attribute_advance($post_type);
if(is_array($all_attribute) && !empty($all_attribute)){?>
    <div class="st-hr"></div>
    <?php foreach ($all_attribute as $key_attr => $attr) {
        if(!empty($attr["value"]) && $attr["value"] !== 'hotel_theme' && $attr["value"] !=='hotel-theme' && $attr["value"] !=='room_type' && $attr["value"] !=='st_tour_type'
        && $attr["value"] != 'st_category_cars'
        ){
            $get_label_tax = get_taxonomy($attr["value"]);
            $facilities = get_the_terms( get_the_ID(), $attr["value"]);
            ?>
            <div class="st-attributes st-section-single  stt-attr-<?php echo esc_attr($attr["value"]);?>">
                <?php
                    if(!empty($get_label_tax) && !empty($facilities)  ){ ?>
                        <h2 class="st-heading-section">
                            <?php echo esc_html($get_label_tax->label); ?>
                        </h2>
                    <?php }
                ?>
                 <?php
                    if ( $facilities ) {
                        $count = count( $facilities );
                        ?>
                        <div class="item-attribute">
                            <div class="row">
                                <?php
    
                                    foreach ( $facilities as $term ) {
                                        $icon     = TravelHelper::handle_icon( get_tax_meta( $term->term_id, 'st_icon') );
                                        $icon_new = TravelHelper::handle_icon( get_tax_meta( $term->term_id, 'st_icon_new') );
                                        if ( empty($icon) ){
                                            $icon = "stt-icon-tag";
                                        };
                                        ?>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div class="item d-flex align-items-center has-matchHeight">
                                                <?php
                                                    if ( !$icon_new ) {
                                                        echo '<i class="' . esc_attr($icon) . '"></i>' . esc_html($term->name);
                                                    } else {
                                                        echo TravelHelper::getNewIcon( $icon_new, '#5E6D77', '24px', '24px' ) . esc_html($term->name);
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    <?php }
                                ?>
                            </div>
                        </div>
                    <?php } ?>
            </div>
        <?php }
    
    }
}

?>
<?php
$all_attribute = TravelHelper::st_get_attribute_advance($post_type);
if(is_array($all_attribute) && !empty($all_attribute)){
    foreach ($all_attribute as $key_attr => $attr) {
        if(!empty($attr["value"])){
            if(!empty($attr["value"]) && $attr["value"] !== 'hotel_theme' && $attr["value"] !=='hotel-theme' && $attr["value"] !=='room_type' && $attr["value"] !=='st_tour_type'
            && $attr["value"] != 'st_category_cars'
            ){
                $get_label_tax = get_taxonomy($attr["value"]);
                $facilities = get_the_terms( get_the_ID(), $attr["value"]);
                ?>
         
                <div class="st-attributes accordion-item  stt-attr-<?php echo esc_attr($attr["value"]);?>">
                    <?php
                        if(!empty($get_label_tax) && !empty($facilities)  ){ ?>
                            <h2 class="st-heading-section" id="heading<?php echo esc_attr($attr["value"]);?>">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo esc_attr($attr["value"]);?>" aria-expanded="true" aria-controls="collapse<?php echo esc_attr($attr["value"]);?>">
                                    <?php echo esc_html($get_label_tax->label); ?>
                                </button>
                            </h2>
                        <?php }
                    ?>
                    <div id="collapse<?php echo esc_attr($attr["value"]);?>" class="accordion-collapse collapse show" aria-labelledby="heading<?php echo esc_attr($attr["value"]);?>" data-bs-parent="#heading<?php echo esc_attr($attr["value"]);?>">
                        <?php
                        if ( $facilities ) {
                            $count = count( $facilities );
                            ?>
                            <div class="item-attribute" data-toggle-section="st-<?php echo esc_attr($attr["value"]);?>"
                                <?php if ( $count > 9 ) echo 'data-show-all="st-'. esc_attr($attr["value"]) .'"
                                data-height="150"'; ?>
                                >
                                <div class="row">
                                    <?php
        
                                        foreach ( $facilities as $term ) {
                                            $icon     = TravelHelper::handle_icon( get_tax_meta( $term->term_id, 'st_icon') );
                                            $icon_new = TravelHelper::handle_icon( get_tax_meta( $term->term_id, 'st_icon_new') );
                                            if ( !$icon ) $icon = "fa fa-cogs";
                                            ?>
                                            <div class="col-xs-6 col-sm-4">
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
                            <?php if ( $count > 9 ) { ?>
                                <a href="#" class="st-link block" data-show-target="st-<?php echo esc_attr($attr["value"]);?>"
                                data-text-less="<?php echo esc_html__( 'Show Less', 'traveler' ) ?>"
                                data-text-more="<?php echo esc_html__( 'Show All', 'traveler' ) ?>"><span
                                            class="text"><?php echo esc_html__( 'Show All', 'traveler' ) ?></span>
                                    <i
                                            class="fa fa-caret-down ml3"></i></a>
                                <?php
                            }
                        } ?>
                    </div>
                    <?php if ( $facilities ) {
                    ?>
                        
                    <?php } ?>
                </div>
        <?php }
        }
    
    }
}

?>
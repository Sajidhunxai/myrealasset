<div class="st-description" id="st-description">
    
    <?php
    if(isset($title)){
        echo '<h2 class="st-heading-section">'. esc_html($title) .'</h2>';
    } else { ?>
        <h2 class="st-heading-section">
        <?php 
            $get_posttype = get_post_type(get_the_ID());
            switch ($get_posttype) {
                case 'st_hotel':
                    echo __('About this hotel','traveler');
                    break;
                case 'st_tours':
                    echo __('About this tour','traveler');
                    break;
                case 'st_cars':
                    echo __('About this car','traveler');
                    break;
                case 'st_rental':
                    echo __('About this rental','traveler');
                    break;
                case 'st_activity':
                    echo __('About this activity','traveler');
                    break;
                case 'hotel_room':
                    echo __('About this room','traveler');
                    break;
                default:
                    echo __('About this hotel','traveler');
                    break;
            }
        ?>
    </h2>
    <?php }
    the_content();
    ?>
</div>
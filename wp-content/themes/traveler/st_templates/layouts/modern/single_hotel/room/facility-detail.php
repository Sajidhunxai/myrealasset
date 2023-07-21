<?php
/**
 * Created by PhpStorm.
 * User: HanhDo
 * Date: 3/7/2019
 * Time: 11:41 AM
 */
$number_bed = get_post_meta(get_the_ID(), 'bed_number', true);
$number_bath = get_post_meta(get_the_ID(), 'bath_number', true);
$room_footage = get_post_meta(get_the_ID(), 'room_footage', true);
$post_thumbnail = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
$new_facility = get_post_meta( get_the_ID(), 'add_new_facility', true );
$room_facility_preview_url = get_post_meta( get_the_ID(), 'room_facility_preview', true );
?>
<div class="facility-detail">
    <div class="facility-detail-left">
        <h2><?php esc_html_e( '3D Floor Plans', 'traveler' ) ?></h2>
        <ul>
            <?php
            if ( !empty( $new_facility ) ) :
                foreach ($new_facility as $item_facility) :?>
                    <li>
                        <?php
                        if ( !empty( $item_facility['title'] ) )
                            echo esc_html($item_facility['title']);
                        ?>
                    </li>
                <?php
                endforeach;
            endif;?>
        </ul>
    </div>
    <div class="facility-detail-right">
        <img src="<?php echo esc_url( $room_facility_preview_url ) ?>" alt="facility-detail-image">
    </div>
</div>

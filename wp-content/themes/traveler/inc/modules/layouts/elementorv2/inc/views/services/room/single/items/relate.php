<?php
$hotel = new STHotel();
$query = $hotel->get_relate_rooms($hotel_id, $room_id);
if($query->have_posts()) {
    wp_enqueue_script('owlcarousel');
    wp_enqueue_style('owlcarousel');
    $responsive = [
        '992' => [
            'items' => 3,
        ],
        '768' => [
            'items' => 2,
        ],
        '0' => [
            'items' => 1,
        ]
    ];
?>
<div class="relate-rooms">
    <div class="st-hr"></div>
    <h2 class="st-heading-section"><?php echo esc_html__('Explore other options', 'traveler'); ?></h2>
    <div class="inner">
        <?php
        echo '<div class="owl-carousel st-owl-slider" data-items="3" data-margin="24" data-responsive="'. esc_attr(json_encode($responsive)) .'">';
            while ($query->have_posts()) {
                $query->the_post();
                echo '<div class="item-slide">';
                    echo stt_elementorv2()->loadView('services/room/loop/grid');
                echo '</div>';
            }
            wp_reset_postdata();
        echo '</div>';
        ?>
    </div>
</div>
<?php
}
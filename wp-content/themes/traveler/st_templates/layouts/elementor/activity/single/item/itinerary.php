<?php
$tour_program_style = get_post_meta( get_the_ID(), 'activity_program_style', true );
if ( empty( $tour_program_style ) )
    $tour_program_style = 'style1';
if ( $tour_program_style == 'style1' or $tour_program_style == 'style3' ){
    $tour_programs = get_post_meta( get_the_ID(), 'activity_program', true );
} else {
    $tour_programs = get_post_meta( get_the_ID(), 'activity_program_bgr', true );
}
    

   
if ( !empty( $tour_programs ) ) {
    ?>
    <div class="accordion-item">
        <h2 class="st-heading-section" id="headingItinerary">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseItinerary" aria-expanded="true" aria-controls="collapseItinerary">
                <?php echo __('Itinerary', 'traveler'); ?>
            </button>
        </h2>
        <div id="collapseItinerary" class="accordion-collapse collapse show" aria-labelledby="headingItinerary" data-bs-parent="#headingItinerary">
            <div class="accordion-body">
                <div class="st-program-list <?php echo esc_attr($tour_program_style); ?>">
                    <?php
                    if (empty($tour_program_style)){
                        $tour_program_style = 'style1';
                    }
                        
                    echo st()->load_template('layouts/elementor/activity/single/items/itenirary/' . esc_attr($tour_program_style));
                    ?>
                </div>
            </div>
        </div>
    </div>

    
<?php } ?>
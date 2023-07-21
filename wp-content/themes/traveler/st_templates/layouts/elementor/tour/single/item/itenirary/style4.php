<?php
    $tour_programs = get_post_meta( get_the_ID(), 'tours_program_style4', true );
    if ( !empty( $tour_programs ) ) {
        ?>
        <div class="owl-carousel-wrapper">
            <div class="owl-carousel owl-tour-program-7">
                <?php
                    foreach ( $tour_programs as $k => $v ) {

                        ?>
                        <div class="item--bg">
                            <div class="box-shadow">
                             <img src="<?php echo esc_url( $v[ 'image' ] ) ?>" >
                            </div>
                           <div class="st-itinerary--info">
                             
                                <div class="body st-itinerary--info__content">
                                    <h2 class="content__time"><?php echo esc_html( $v[ 'title' ] ); ?></h2>
                                    <h5 class="content__title"><?php echo esc_html( $v[ 'time' ] ); ?></h5>
                                    <div class="desc content__desc">
                                        <?php 
                                        if(!empty($v['desc'])){
                                           
                                             $description= explode("\n", $v['desc']);
                                             foreach ($description as $key => $value) {
                                                    if(!empty($value)){
                                                                   ?>
                                                <p><?php echo TravelHelper::getNewIcon( 'arrow-right', '#222222', '14px', '14px', false ).balanceTags($value); ?></p>
                                                 
                                                   <?php
                                                   }
                                                }                   
                                            }
                                         ?>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php
                    }
                ?>
            </div>
                    
                       
        </div>
        <?php
    }
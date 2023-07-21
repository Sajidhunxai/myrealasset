<?php 
$icon_duration_single_tour = st()->get_option('icon_duration_single_activity', '<i class="stt-icon-clock"></i>');
$icon_close_single_tour = st()->get_option('icon_cancel_single_activity', '<i class="stt-icon-close"></i>');
$icon_groupsize_single_tour = st()->get_option('icon_groupsize_single_activity', '<i class="stt-icon-user2"></i>');
$icon_language_single_tour = st()->get_option('icon_language_single_activity', '<i class="stt-icon-language"></i>');
?>
<!--Tour Info-->
<div class="st-service-feature">
    <div class="row">
        <div class="col-6 col-sm-6 col-md-3">
            <div class="item d-flex align-items-lg-center">
                <div class="icon">
                    <?php echo htmlspecialchars_decode($icon_duration_single_tour);?>
                </div>
                <div class="info">
                    <div class="name"><?php echo __('Duration', 'traveler'); ?></div>
                    <p class="value">
                        <?php
                        $duration = get_post_meta(get_the_ID(), 'duration', true);
                        echo esc_html($duration);
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-3">
            <div class="item d-flex align-items-lg-center">
                <div class="icon">
                    <?php echo htmlspecialchars_decode($icon_close_single_tour);?>
                </div>
                <div class="info">
                    <div class="name"><?php echo __('Cancellation', 'traveler'); ?></div>
                    <p class="value">
                        <?php
                            $cancellation= get_post_meta( get_the_ID(), 'st_allow_cancel', true );
                            $cancellation_day= (int)get_post_meta( get_the_ID(), 'st_cancel_number_days', true );
                            if ( $cancellation== 'on' ) {
                                echo sprintf(_n( 'Up to %s day','Up to %s days', $cancellation_day,'traveler' ), $cancellation_day);
                            } else {
                                echo __( 'No Cancel', 'traveler' );
                            }
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-3">
            <div class="item d-flex align-items-lg-center">
                <div class="icon">
                    <?php echo htmlspecialchars_decode($icon_groupsize_single_tour);?>
                </div>
                <div class="info">
                    <div class="name"><?php echo __('Group Size', 'traveler'); ?></div>
                    <p class="value">
                        <?php
                        $max_people = get_post_meta(get_the_ID(), 'max_people', true);
                        if (empty($max_people) or $max_people == 0 or $max_people < 0) {
                            echo __('Unlimited', 'traveler');
                        } else {
                            if ($max_people == 1)
                                echo sprintf(__('%s person', 'traveler'), $max_people);
                            else
                                echo sprintf(__('%s people', 'traveler'), $max_people);
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-6 col-md-3">
            <div class="item d-flex align-items-lg-center">
                <div class="icon">
                    <?php echo htmlspecialchars_decode($icon_language_single_tour);?>
                </div>
                <div class="info">
                    <div class="name"><?php echo __('Languages', 'traveler'); ?></div>
                    <p class="value">
                        <?php
                        $term_list = wp_get_post_terms(get_the_ID(), 'languages');
                        if(empty($term_list)){
                            $term_list = wp_get_post_terms(get_the_ID(), 'language');
                        }
                        
                        $str_term_arr = [];
                        if (!is_wp_error($term_list) && !empty($term_list)) {
                            foreach ($term_list as $k => $v) {
                                array_push($str_term_arr, $v->name);
                            }

                            echo implode(', ', $str_term_arr);
                        } else {
                            echo '___';
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End Tour info-->
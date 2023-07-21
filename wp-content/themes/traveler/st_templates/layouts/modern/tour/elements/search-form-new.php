<?php
$result_page = st()->get_option('tours_search_result_page');
if(isset($container)){
    $class = $container;
}else{
    $class = '';
}
$list_field = st()->get_option('tour_form_fields');
?>
<div class="search-form-wrapper auto-height-form-search  st-search-form-tour">

        <div class="<?php echo esc_attr($class) ?> tour-search-form-home style2">
            <div class="search-form">
                <form action="<?php echo esc_url(get_the_permalink($result_page)); ?>" class="form" method="get">

                    <?php
                    if($list_field){
                        foreach ($list_field as $key => $value){
                            if($value['value'] == 'st_location'){
                                echo st()->load_template('layouts/modern/tour/elements/search-new/location', '', ['has_icon' => true]);
                            }

                            if($value['value'] == 'st_date'){
                                echo st()->load_template('layouts/modern/tour/elements/search-new/date', '', ['has_icon' => true]);
                            }

                            if($value['value'] == 'st_guests'){
                                echo st()->load_template('layouts/modern/tour/elements/search-new/guest', '', ['has_icon' => true]);
                            }

                            if($value['value'] == 'st_tour_type'){
                                echo st()->load_template('layouts/modern/tour/elements/search-new/tour_type', '', ['has_icon' => true]);
                            }

                            if($value['value'] == 'st_duration'){
                                $facilities = get_terms(
                                    [
                                        'taxonomy'   => 'durations',
                                        'hide_empty' => false
                                    ]
                                );
                                if(!is_wp_error($facilities)){
                                    echo st()->load_template('layouts/modern/tour/elements/search-new/duration', '', ['has_icon' => true]);
                                }

                            }

                            if($value['value'] == 'st_price'){
                                echo st()->load_template('layouts/modern/tour/elements/search-new/price', '', ['has_icon' => true]);
                            }

                        }

                    }else{
                        echo st()->load_template('layouts/modern/tour/elements/search-new/location', '', ['has_icon' => true]);
                        echo st()->load_template('layouts/modern/tour/elements/search-new/date', '', ['has_icon' => true]);
                        echo st()->load_template('layouts/modern/tour/elements/search-new/guest', '', ['has_icon' => true]);
                    }
                    ?>
                    <div class="form-button-new ">

                        <button class="btn btn-primary btn-search"
                                type="submit"><?php echo esc_html__('Search', 'traveler'); ?></button>
                    </div>
                </form>
            </div>
        </div>

</div>
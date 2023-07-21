<?php
global $post;
$info_price = STTour::get_info_price();
$location_name = STInput::request('location_name');
$location_id = STInput::request('location_id');
if (isset($_REQUEST['start']) && strlen($_REQUEST['start']) > 0) {
    $_REQUEST['check_in'] = $_REQUEST['check_out'] = $_REQUEST['end'] = $_REQUEST['start'];
}
if(!empty($column) && ($column == 3)){
    $class = 'col-lg-4 col-md-4 col-sm-4 col-xs-12  grid-item has-matchHeight';
} else {
    $class = 'col-lg-6 col-md-6 col-sm-6 col-xs-12  grid-item has-matchHeight';
}
?>
<div class="<?php echo esc_attr($class); ?>">
        <div class="st-list-service--bg st-list-service--transparent st-list-service--margin">

                <div class="st-list-tour-related mt50">
                    <div class="">
                        <div class="item related__item has-matchHeight">
                            <div class="featured">
                                <div class="thumb">
                                <a href="<?php the_permalink(); ?>">
                                         <?php
                                            if(has_post_thumbnail()){
                                                the_post_thumbnail(array(800, 600), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive'));
                                            }else{
                                                echo '<img src="'. get_template_directory_uri() . '/img/no-image.png' .'" alt="Default Thumbnail" class="img-responsive" />';
                                            }
                                            ?>
                                        </a>
                                </div>
                                <?php
                                $list_country = get_post_meta(get_the_ID(),'multi_location',true);
                                $list_country = preg_replace( "/(\_)/", "", $list_country );
                                $list_country = explode( ",", $list_country );
                                $solo_location_name = '';
                                if(!empty($list_country)){
                                    if(!empty($location_name && !empty($location_id))){
                                        if(in_array($location_id,$list_country)){
                                           $solo_location_name = $location_name;
                                           $color_location = get_post_meta($location_id, 'color', true);
                                           ?>
                                                 <span class="ml5 f14 address st-location--style4"  style="background:<?php echo esc_attr($color_location) ?>"><?php echo esc_html(get_the_title($location_id)); ?></span>
                                           <?php

                                        }else{
                                            $color_location = get_post_meta($list_country[0], 'color', true);
                                            ?>
                                                <span class="ml5 f14 address st-location--style4"  style="background:<?php echo esc_attr($color_location) ?>"><?php echo esc_html(get_the_title($list_country[0])); ?></span>
                                            <?php
                                        }
                                    }else{
                                        $color_location = get_post_meta($list_country[0], 'color', true);
                                        ?>
                                            <span class="ml5 f14 address st-location--style4"  style="background:<?php echo esc_attr($color_location) ?>"><?php echo esc_html(get_the_title($list_country[0])); ?></span>
                                        <?php
                                    }

                                }
                                ?>
                                <?php echo st_get_avatar_in_list_service(get_the_ID(), 70); ?>
                            </div>
                            <h4 class="title title--color"><a href="<?php the_permalink() ?>"
                                                              class="st-link c-main"><?php the_title(); ?></a></h4>
                            <?php
                            $description_tour = get_post(get_the_ID());
                            if (!empty($description_tour)) {
                                ?>
                                <div class="st-tour--description"><?php the_excerpt() ?></div>
                                <?php
                            }
                            ?>
                            <div class="section-footer" >
                                <div class="st-flex space-between st-price__wrapper">

                                    <div class="right">

                                                    <span class=" price--tour">
                                                        <?php echo sprintf(esc_html__('%s', 'traveler'), STTour::get_price_html(get_the_ID())); ?>
                                                    </span>
                                    </div>
                                    <div class="st-btn--book">
                                        <a href="<?php echo esc_attr(get_permalink(get_the_ID())); ?>"><?php echo esc_html__('BOOK NOW', 'traveler'); ?></a>
                                    </div>
                                </div>
                            </div>
                            <div class="fixed-bottom">
                                <div class="st-tour--feature st-tour--tablet">
                                    <div class="st-tour__item">
                                        <div class="item__icon">
                                            <?php echo TravelHelper::getNewIcon('icon-calendar-tour-solo', '#ec927e', '24px', '24px'); ?>
                                        </div>
                                        <div class="item__info">
                                            <h4 class="info__name"><?php echo esc_html__('Duration', 'traveler'); ?></h4>
                                            <p class="info__value">
                                                <?php
                                                $duration = get_post_meta(get_the_ID(), 'duration_day', true);
                                                echo esc_html($duration);
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="st-tour__item">
                                        <div class="item__icon">
                                            <?php echo TravelHelper::getNewIcon('icon-service-tour-solo', '#ec927e', '24px', '24px'); ?>
                                        </div>
                                        <div class="item__info">
                                            <h4 class="info__name"><?php echo esc_html__('Group Size', 'traveler'); ?></h4>
                                            <p class="info__value">
                                                <?php
                                                $max_people = get_post_meta(get_the_ID(), 'max_people', true);
                                                if (empty($max_people) or $max_people == 0 or $max_people < 0) {
                                                    echo esc_html__('Unlimited', 'traveler');
                                                } else {
                                                    if ($max_people == 1)
                                                        echo sprintf(esc_html__('%s person', 'traveler'), $max_people);
                                                    else
                                                        echo sprintf(esc_html__('%s people', 'traveler'), $max_people);
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

        </div>
</div>

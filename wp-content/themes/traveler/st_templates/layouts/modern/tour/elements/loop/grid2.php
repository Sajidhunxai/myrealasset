<?php
global $post;
$info_price = STTour::get_info_price();
if ( isset( $_REQUEST['start'] ) && strlen( $_REQUEST['start'] ) > 0 ) {
    $_REQUEST['check_in'] = $_REQUEST['check_out'] = $_REQUEST['end'] = $_REQUEST['start'];
}
$url=st_get_link_with_search(get_permalink(),array('check_in','check_out','duration','people'),$_REQUEST);

$class = 'col-lg-4 col-md-6 col-sm-6 col-xs-12 item-service grid-item has-matchHeight';
if(isset($top_search) and $top_search)
    $class = 'col-lg-3 col-md-4 col-sm-6 col-xs-12 item-service grid-item has-matchHeight';
if(isset($slider) and $slider)
    $class = 'item-service grid-item has-matchHeight';
?>
<div class="<?php echo esc_attr($class); ?>">
    <div class="service-border">
        <div class="thumb">
            <?php if(!empty( $info_price['discount'] ) and $info_price['discount']>0 and $info_price['price_new'] >0) { ?>
                <?php echo STFeatured::get_sale($info_price['discount']); ?>
            <?php } ?>
            <?php if(is_user_logged_in()){ ?>
                <?php $data = STUser_f::get_icon_wishlist();?>
                <div class="service-add-wishlist login <?php echo ($data['status']) ? 'added' : ''; ?>" data-id="<?php echo get_the_ID(); ?>" data-type="<?php echo get_post_type(get_the_ID()); ?>" title="<?php echo $data['status'] ? __('Remove from wishlist', 'traveler') : __('Add to wishlist', 'traveler'); ?>">
                    <i class="fa fa-heart"></i>
                    <div class="lds-dual-ring"></div>
                </div>
            <?php }else{ ?>
                <a href="#" class="login" data-toggle="modal" data-target="#st-login-form">
                    <div class="service-add-wishlist" title="<?php echo __('Add to wishlist', 'traveler'); ?>">
                        <i class="fa fa-heart"></i>
                        <div class="lds-dual-ring"></div>
                    </div>
                </a>
            <?php } ?>
            <div class="service-price">
                <span class="price">
                        <?php
                            $post_id = get_the_ID();

                        $price_type = STTour::get_price_type($post_id);
                        if($price_type == 'person' or $price_type == 'fixed_depart'){
                            $prices = STTour::get_price_person( $post_id );
                        }
                        else{
                            $prices = STTour::get_price_fixed( $post_id );

                        }
                        $price_old = $price_new = 0;
                        if($price_type == 'person' or $price_type == 'fixed_depart') {
                            if ( ! empty( $prices['adult'] ) ) {
                                $price_old = $prices['adult'];
                                $price_new = $prices['adult_new'];
                            } elseif ( ! empty( $prices['child'] ) ) {
                                $price_old = $prices['child'];
                                $price_new = $prices['child_new'];
                            } elseif ( ! empty( $prices['infant'] ) ) {
                                $price_old = $prices['infant'];
                                $price_new = $prices['infant_new'];
                            }
                        }else{
                            $price_old = $prices['base'];
                            $price_new = $prices['base_new'];
                        }
                        if ( $price_new != $price_old ) {
                            echo '<p class="text-small lh1em item onsale "><span class="st-ico">'. TravelHelper::getNewIcon('thunder', '#ffab53', '10px', '16px') .'</span>' . TravelHelper::format_money( $price_old ) . '</p>';
                        }
                        $price_new = TravelHelper::format_money( $price_new ) ;
                        echo '<p class="text-lg lh1em item "> ' . esc_html($price_new) . '<span class="st-text"> ' . esc_html__('/person','traveler') . ' </span></p>';

                        ?>
                    </span>
            </div>
            <div class="service-tag bestseller">
                <?php echo STFeatured::get_featured(); ?>
            </div>
            <a href="<?php echo esc_url($url); ?>">
                <?php
                if(has_post_thumbnail()){
                    //the_post_thumbnail(array(680, 630), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive'));
                    the_post_thumbnail(array(740, 680), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive'));
                }else{
                    echo '<img src="'. get_template_directory_uri() . '/img/no-image.png' .'" alt="Default Thumbnail" class="img-responsive" />';
                }
                ?>
            </a>
            <?php echo st_get_avatar_in_list_service(get_the_ID(),70)?>
        </div>
        <?php if ($address = get_post_meta(get_the_ID(), 'address', TRUE)): ?>
            <p class="service-location "><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?></p>
        <?php endif;?>
        <h4 class="service-title "><a href="<?php echo esc_url($url); ?>"><?php echo get_the_title(); ?></a></h4>

        <div class="service-review ">
            <ul class="icon-group text-color booking-item-rating-stars">
                <?php
                $avg = STReview::get_avg_rate();
                echo TravelHelper::rate_to_string($avg);
                ?>
            </ul>
            <?php
            $count_review = get_comment_count(get_the_ID())['approved'];
            ?>
            <span class="review">
                <?php //echo esc_html($count_review) . ' ' . _n(esc_html__('Review', 'traveler'),esc_html__('Reviews', 'traveler'),$count_review); ?>
                <?php comments_number(__('0 reviews', 'traveler'), __('1 Review', 'traveler'), __('% Reviews', 'traveler')); ?>
            </span>
        </div>

        <div class="section-footer">
            <div class="footer-inner ">
                <div class="service-peple">
                    <?php
                    echo TravelHelper::getNewIcon('ico_people_2', '#5E6D77', '16px', '16px');
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
                </div>
                <?php
                $duration = get_post_meta( get_the_ID(), 'duration_day', true );
                if(!empty($duration)) {
                    ?>
                    <div class="service-duration">
                        <?php echo TravelHelper::getNewIcon('time-clock-circle-3', '#5E6D77', '16px', '16px'); ?>
                        <?php echo esc_html($duration); ?>
                    </div>
                    <?php
                }
                ?>


            </div>
        </div>
    </div>
</div>

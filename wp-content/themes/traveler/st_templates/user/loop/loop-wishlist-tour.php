
<li class="st-item-list post-<?php the_ID() ?>">
	<a data-id="<?php the_ID() ?>" data-type="<?php echo get_post_type( get_the_ID() ) ?>" data-placement="top"
       rel="tooltip" class="btn_remove_wishlist cursor fa fa-times booking-item-wishlist-remove"
       data-original-title="<?php st_the_language( 'remove' ) ?>"></a>
    <div class="spinner user_img_loading ">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
    <div class="item-service st-ccv-tour">
        <div class="row item-service-wrapper has-matchHeight">
            <div class="col-lg-3 col-md-3 col-sm-12 thumb-wrapper col-xs-12">
                <div class="thumb">
                    <?php if(!empty( $info_price['discount'] ) and $info_price['discount']>0 and $info_price['price_new'] >0) { ?>
                        <?php echo STFeatured::get_sale($info_price['discount']); ?>
                    <?php } ?>
                    <div class="service-tag bestseller">
                        <?php echo STFeatured::get_featured(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>">
                        <?php
                        if(has_post_thumbnail()){
                            the_post_thumbnail(array(450, 417), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive'));
                        }else{
                            echo '<img src="'. get_template_directory_uri() . '/img/no-image.png' .'" alt="Default Thumbnail" class="img-responsive" />';
                        }
                        ?>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 item-content col-xs-12">
                <div class="item-content-w">
                    <?php if ($address = get_post_meta(get_the_ID(), 'address', TRUE)): ?>
                        <p class="service-location"><?php echo TravelHelper::getNewIcon('Ico_maps', '#666666', '15px', '15px', true); ?><?php echo esc_html($address); ?></p>
                    <?php endif;?>
                    <h4 class="service-title"><a href="<?php the_permalink();; ?>"><?php echo get_the_title(); ?></a></h4>
                    <div class="service-review">
                        <ul class="icon-group text-color booking-item-rating-stars">
                            <?php
                            $avg = STReview::get_avg_rate();
                            echo TravelHelper::rate_to_string($avg);
                            ?>
                        </ul>
                        <?php
                        $count_review = STReview::count_comment(get_the_ID());
                        ?>
                        <span class="review"><?php echo esc_html($count_review) . ' ' . _n(esc_html__('Review', 'traveler'),esc_html__('Reviews', 'traveler'),$count_review); ?></span>
                    </div>
                    <div class="service-excerpt">
                        <?php echo mb_strimwidth(strip_shortcodes(New_Layout_Helper::cutStringByNumWord(get_the_excerpt(), 12)), 0, 220, '...'); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 section-footer col-xs-12">
                <?php
                $duration = get_post_meta( get_the_ID(), 'duration_day', true );
                ?>
                <?php
                if(!empty($duration)) {
                    ?>
                    <div class="service-duration hidden-lg hidden-md hidden-sm">
                        <?php echo TravelHelper::getNewIcon('time-clock-circle-1', '#5E6D77', '17px', '17px'); ?>
                        <?php echo esc_html($duration); ?>
                    </div>
                    <?php
                }
                ?>

                <div class="service-price">
                        <span class="price-text">
                            <?php echo TravelHelper::getNewIcon('thunder', '#ffab53', '16px', '16px'); ?>
                            <span class="fr_text"><?php _e("from", 'traveler') ?></span>
                        </span>
                    <span class="price">
                            <?php
                            echo STTour::get_price_html(get_the_ID());
                            ?>
                        </span>
                </div>

                <?php
                if(!empty($duration)) {
                    ?>
                    <div class="service-duration hidden-xs">
                        <?php echo TravelHelper::getNewIcon('time-clock-circle-1', '#5E6D77', '17px', '17px'); ?>
                        <?php echo esc_html($duration); ?>
                    </div>
                    <?php
                }
                ?>

                <div class="service-type">
                    <?php
                        $tour_type = get_the_terms(get_the_ID(), 'st_tour_type');
                        if(!empty($tour_type)){
                            $tour_type_str = $tour_type[0]->name;
                            echo TravelHelper::getNewIcon('ico_tour_type', '#000000', '17px', '17px', true);
                            echo esc_html($tour_type_str);
                        }
                    ?>
                </div>

                <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-view-more"><?php echo __('VIEW TOUR', 'traveler'); ?></a>

                <?php if(!empty( $info_price['discount'] ) and $info_price['discount']>0 and $info_price['price_new'] >0) { ?>
                    <?php echo STFeatured::get_sale($info_price['discount']); ?>
                <?php } ?>
            </div>
        </div>
    </div>
</li>

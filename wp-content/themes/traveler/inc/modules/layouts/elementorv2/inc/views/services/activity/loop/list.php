<?php
global $post;
$post_id = get_the_ID();
$post_translated = TravelHelper::post_translated($post_id);
$thumbnail_id = get_post_thumbnail_id($post_translated);
$duration = get_post_meta( get_the_ID(), 'duration', true );
$info_price = STActivity::inst()->get_info_price();
$address = get_post_meta($post_translated, 'address', true);



$review_rate = STReview::get_avg_rate();
$count_review = get_comment_count($post_translated)['approved'];
$class_image = 'image-feature';
$url=st_get_link_with_search(get_permalink($post_translated),array('start','end','date','adult_number','child_number'),$_GET);
?>
<div class="services-item list item-elementor" itemscope itemtype="https://schema.org/Trip" data-id="<?php echo esc_attr($post_id); ?>">
    <div class="item service-border st-border-radius">
        <div class="featured-image">
               
            <?php if(is_user_logged_in()){ ?>
                <?php $data = STUser_f::get_icon_wishlist();?>
                <div class="service-add-wishlist login <?php echo ($data['status']) ? 'added' : ''; ?>" data-id="<?php echo get_the_ID(); ?>" data-type="<?php echo get_post_type(get_the_ID()); ?>" title="<?php echo ($data['status']) ? __('Remove from wishlist', 'traveler') : __('Add to wishlist', 'traveler'); ?>">
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
            <div class="service-tag bestseller">
                <?php echo STFeatured::get_featured(); ?>
            </div>
            <a href="<?php echo esc_url($url); ?>">
                <?php
                if(has_post_thumbnail()){
                    the_post_thumbnail(array(450, 300), array('alt' => TravelHelper::get_alt_image(), 'class' => 'img-responsive', 'itemprop'=>"image"));
                }else{
                    echo '<img src="'. get_template_directory_uri() . '/img/no-image.png' .'" alt="Default Thumbnail" class="img-responsive" />';
                }
                ?>
            </a>
            <?php do_action('st_list_compare_button',get_the_ID(),get_post_type(get_the_ID())); ?>
            <?php echo st_get_avatar_in_list_service(get_the_ID(),70)?>
        </div>
        <div class="content-item">
            <div class="content-item-left">
                <?php if ($address) { ?>
                    <div class="sub-title st-address d-flex align-items-center" itemprop="itinerary" itemscope itemtype="https://schema.org/ItemList">
                        <span itemprop="address" itemscope itemtype="https://schema.org/PostalAddress"> 
                            <span itemprop="streetAddress"> <i class="stt-icon-location1"></i> <?php echo esc_html($address); ?></span>
                        </span>
                    </div>
                <?php } ?>
                <div class="event-date d-none" itemprop="startDate" content="<?php echo date("Y-m-d H:i:s");?>"><?php echo date("Y-m-d H:i:s");?></div>
                <h3 class="title" itemprop="name"><a href="<?php echo esc_url($url); ?>"><?php echo get_the_title(); ?></a></h3>
                <div class="reviews">
                    <i class="stt-icon-star1"></i>
                    <span class="rate" itemprop="ratingValue">
                        <?php echo esc_html($review_rate); ?>
                    </span>
                    <span class="summary">
                        (<?php comments_number(esc_html__('No Review', 'traveler'), esc_html__('1 Review', 'traveler'), get_comments_number() . ' ' . esc_html__('Reviews', 'traveler')); ?>)
                    </span>
                </div>
                <div class="service-excerpt">
                    <?php echo mb_strimwidth(strip_shortcodes(New_Layout_Helper::cutStringByNumWord(get_the_excerpt(), 17)), 0, 220, '...'); ?>
                </div>
            </div>
            <div class="content-item-right">
            
                <div class="content-item-right-wrap h-100 w-100 text-center d-flex align-content-between flex-wrap">
                    <div class="st-list-top w-100">
                        <?php
                        if(!empty($duration)) {
                            ?>
                            <div class="service-duration d-block d-sm-none d-md-none d-lg-none">
                                <?php echo TravelHelper::getNewIcon('time-clock-circle-1', '#5E6D77', '17px', '17px'); ?>
                                <?php echo esc_html($duration); ?>
                            </div>
                            <?php
                        }
                        ?>
                        <?php
                        if(!empty($duration)) {
                            ?>
                            <div class="price-wrapper d-none d-sm-block d-md-block d-lg-block service-duration ">
                                <?php echo TravelHelper::getNewIcon('time-clock-circle-1', '#5E6D77', '17px', '17px'); ?>
                                <?php echo esc_html($duration); ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    
                    <div class="st-list-footer w-100">
                        <div class="price-wrapper w-100 service-type d-sm-block d-md-block d-lg-block">
                            <span class="price-tour">
                                <span class="price d-inline-block"><?php echo STActivity::get_price_html(get_the_ID(),false, '',  'sale-top', false); ?></span>
                            </span>
                        </div>
                        <div class="service-type type-btn-view-more">
                            <a href="<?php echo esc_url($url); ?>" class="view-detail w-100"><?php echo esc_html__('View details', 'traveler'); ?></a>
                        </div>
                        
                        <?php if(!empty( $info_price['discount'] ) and $info_price['discount']>0 and $info_price['price_new'] >0) { ?>
                            <?php echo STFeatured::get_sale($info_price['discount']); ?>
                        <?php } ?>
                    </div>
                    
                </div>
                
            </div>
        </div>
        
    </div>
</div>

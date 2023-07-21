<?php if(comments_open() and st()->get_option( 'car_review' ) == 'on') {?>
    <div class="st-hr large st-height2 st-hr-comment"></div>
    <h2 class="st-heading-section"><?php echo esc_html__('Reviews', 'traveler') ?></h2>
    <div id="reviews" data-toggle-section="st-reviews">
        <div class="review-box">
            <div class="row">
                <div class="col-lg-5">
                    <div class="review-box-score">
                        <?php
                        $avg = STReview::get_avg_rate();
                        ?>
                        <div class="review-score">
                            <?php echo esc_attr($avg); ?><span class="per-total">/5</span>
                        </div>
                        <div class="review-score-text"><?php echo TravelHelper::get_rate_review_text($avg, $count_review); ?></div>
                        <div class="review-score-base">
                            <?php echo __('Based on', 'traveler') ?>
                            <span><?php comments_number(__('0 review', 'traveler'), __('1 review', 'traveler'), __('% reviews', 'traveler')); ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="review-sumary">
                        <?php $total = get_comments_number(); ?>
                        <?php $rate_exe = STReview::count_review_by_rate(null, 5); ?>
                        <div class="item">
                            <div class="label">
                                <?php echo esc_html__('Excellent', 'traveler') ?>
                            </div>
                            <div class="progress">
                                <div class="percent green"
                                        style="width: <?php echo TravelHelper::cal_rate($rate_exe, $total) ?>%;"></div>
                            </div>
                            <div class="number"><?php echo esc_html($rate_exe); ?></div>
                        </div>
                        <?php $rate_good = STReview::count_review_by_rate(null, 4); ?>
                        <div class="item">
                            <div class="label">
                                <?php echo __('Very Good', 'traveler') ?>
                            </div>
                            <div class="progress">
                                <div class="percent darkgreen"
                                        style="width: <?php echo TravelHelper::cal_rate($rate_good, $total) ?>%;"></div>
                            </div>
                            <div class="number"><?php echo esc_html($rate_good); ?></div>
                        </div>
                        <?php $rate_avg = STReview::count_review_by_rate(null, 3); ?>
                        <div class="item">
                            <div class="label">
                                <?php echo __('Average', 'traveler') ?>
                            </div>
                            <div class="progress">
                                <div class="percent yellow"
                                        style="width: <?php echo TravelHelper::cal_rate($rate_avg, $total) ?>%;"></div>
                            </div>
                            <div class="number"><?php echo esc_html($rate_avg); ?></div>
                        </div>
                        <?php $rate_poor = STReview::count_review_by_rate(null, 2); ?>
                        <div class="item">
                            <div class="label">
                                <?php echo __('Poor', 'traveler') ?>
                            </div>
                            <div class="progress">
                                <div class="percent orange"
                                        style="width: <?php echo TravelHelper::cal_rate($rate_poor, $total) ?>%;"></div>
                            </div>
                            <div class="number"><?php echo esc_html($rate_poor); ?></div>
                        </div>
                        <?php $rate_terible = STReview::count_review_by_rate(null, 1); ?>
                        <div class="item">
                            <div class="label">
                                <?php echo __('Terrible', 'traveler') ?>
                            </div>
                            <div class="progress">
                                <div class="percent red"
                                        style="width: <?php echo TravelHelper::cal_rate($rate_terible, $total) ?>%;"></div>
                            </div>
                            <div class="number"><?php echo esc_html($rate_terible); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="review-pagination">
            <div class="summary">
                <?php
                $comments_count = wp_count_comments(get_the_ID());
                $total = (int)$comments_count->approved;
                $comment_per_page = (int)get_option('comments_per_page', 10);
                $paged = (int)STInput::get('comment_page', 1);
                $from = $comment_per_page * ($paged - 1) + 1;
                $to = ($paged * $comment_per_page < $total) ? ($paged * $comment_per_page) : $total;
                ?>
            </div>
            <div id="reviews" class="review-list">
                <?php
                $offset = ($paged - 1) * $comment_per_page;
                $args = [
                    'number' => $comment_per_page,
                    'offset' => $offset,
                    'post_id' => get_the_ID(),
                    'status' => ['approve']
                ];
                $comments_query = new WP_Comment_Query;
                $comments = $comments_query->query($args);

                if ($comments):
                    foreach ($comments as $key => $comment):
                        echo st()->load_template('layouts/elementor/common/reviews/review', 'list', ['comment' => (object)$comment, 'post_type' => 'st_cars']);
                    endforeach;
                endif;
                ?>
            </div>
        </div>
        <div class="review-pag-wrapper">
            <div class="review-pag-text">
                <?php echo sprintf(__('Showing %s - %s of %s in total', 'traveler'), $from, $to, get_comments_number_text('0', '1', '%')) ?>
            </div>
            <?php TravelHelper::pagination_comment(['total' => $total]) ?>
        </div>
        <?php
        if (comments_open($post_id)) {
            ?>
            <div id="write-review">
                <h4 class="heading">
                    <a href="" class="toggle-section c-main f16"
                        data-target="st-review-form"><?php echo __('Write a review', 'traveler') ?>
                        <i class="fa fa-angle-down ml5"></i></a>
                </h4>
                <?php
                TravelHelper::comment_form();
                ?>
            </div>
            <?php
        }
        ?>
    </div>
    <?php }?>
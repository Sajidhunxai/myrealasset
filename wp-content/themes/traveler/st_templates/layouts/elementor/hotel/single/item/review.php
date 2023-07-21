<?php if (comments_open() and st()->get_option('hotel_review') == 'on') {
    $count_review = get_comment_count($post_id)['approved'];
    ?>
    <div class="st-hr large"></div>
    <div class="accordion-item">
        <h2 class="st-heading-section" id="headingReviews">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseReviews" aria-expanded="true" aria-controls="collapseReviews">
                <?php echo esc_html__('Reviews', 'traveler') ?>
            </button>
        </h2>
        <div id="collapseReviews" class="accordion-collapse collapse show" aria-labelledby="headingReviews" data-bs-parent="#headingReviews">
            <div class="accordion-body">
                <div id="reviews" data-toggle-section="st-reviews">
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <div class="review-box st-border-radius has-matchHeight">
                                <h2 class="heading"><?php echo __('Review score', 'traveler') ?></h2>
                                <div class="review-box-score">
                                    <?php
                                    $avg = STReview::get_avg_rate();
                                    ?>
                                    <div class="review-score text-center">
                                        <?php echo esc_attr($avg); ?><span class="per-total">/5</span>
                                    </div>
                                    <div class="review-score-text text-center"><?php echo TravelHelper::get_rate_review_text($avg, $count_review); ?></div>
                                    <div class="review-score-base text-center">
                                        <?php echo __('Based on', 'traveler') ?>
                                        <span><?php comments_number(__('0 review', 'traveler'), __('1 review', 'traveler'), __('% reviews', 'traveler')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="review-box st-border-radius has-matchHeight">
                                <h2 class="heading"><?php echo __('Traveler rating', 'traveler') ?></h2>
                                <?php $total = get_comments_number(); ?>
                                <?php $rate_exe = STReview::count_review_by_rate(null, 5); ?>
                                <div class="item">
                                    <div class="progress">
                                        <div class="percent green"
                                            style="width: <?php echo TravelHelper::cal_rate($rate_exe, $total) ?>%;"></div>
                                    </div>
                                    <div class="label">
                                        <?php echo esc_html__('Excellent', 'traveler') ?>
                                        <div class="number"><?php echo esc_html($rate_exe); ?></div>
                                    </div>
                                </div>
                                <?php $rate_good = STReview::count_review_by_rate(null, 4); ?>
                                <div class="item">
                                    <div class="progress">
                                        <div class="percent darkgreen"
                                            style="width: <?php echo TravelHelper::cal_rate($rate_good, $total) ?>%;"></div>
                                    </div>
                                    <div class="label">
                                        <?php echo __('Very Good', 'traveler') ?>
                                        <div class="number"><?php echo esc_html($rate_good); ?></div>
                                    </div>
                                </div>
                                <?php $rate_avg = STReview::count_review_by_rate(null, 3); ?>
                                <div class="item">
                                    <div class="progress">
                                        <div class="percent yellow"
                                            style="width: <?php echo TravelHelper::cal_rate($rate_avg, $total) ?>%;"></div>
                                    </div>
                                    <div class="label">
                                        <?php echo __('Average', 'traveler') ?>
                                        <div class="number"><?php echo esc_html($rate_avg); ?></div>
                                    </div>
                                </div>
                                <?php $rate_poor = STReview::count_review_by_rate(null, 2); ?>
                                <div class="item">
                                    <div class="progress">
                                        <div class="percent orange"
                                            style="width: <?php echo TravelHelper::cal_rate($rate_poor, $total) ?>%;"></div>
                                    </div>
                                    <div class="label">
                                        <?php echo __('Poor', 'traveler') ?>
                                        <div class="number"><?php echo esc_html($rate_poor); ?></div>
                                    </div>
                                </div>
                                <?php $rate_terible = STReview::count_review_by_rate(null, 1); ?>
                                <div class="item">
                                    <div class="progress">
                                        <div class="percent red"
                                            style="width: <?php echo TravelHelper::cal_rate($rate_terible, $total) ?>%;"></div>
                                    </div>
                                    <div class="label">
                                        <?php echo __('Terrible', 'traveler') ?>
                                        <div class="number"><?php echo esc_html($rate_terible); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4">
                            <div class="review-box st-border-radius has-matchHeight">
                                <h2 class="heading"><?php echo __('Summary', 'traveler') ?></h2>
                                <?php
                                $stats = STReview::get_review_summary();
                                if ($stats) {
                                    foreach ($stats as $stat) {
                                        ?>
                                        <div class="item">
                                            <div class="progress">
                                                <div class="percent"
                                                    style="width: <?php echo esc_attr($stat['percent']); ?>%;"></div>
                                            </div>
                                            <div class="label">
                                                <?php echo esc_html($stat['name']); ?>
                                                <div class="number"><?php echo esc_html($stat['summary']) ?>
                                                    /5
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="review-pagination">
                        <div class="summary text-center">
                            <?php
                            $comments_count = wp_count_comments(get_the_ID());
                            $total = (int)$comments_count->approved;
                            $comment_per_page = (int)get_option('comments_per_page', 10);
                            $paged = (int)STInput::get('comment_page', 1);
                            $from = $comment_per_page * ($paged - 1) + 1;
                            $to = ($paged * $comment_per_page < $total) ? ($paged * $comment_per_page) : $total;
                            ?>
                            <?php comments_number(__('0 review on this Hotel', 'traveler'), __('1 review on this Hotel', 'traveler'), __('% reviews on this Hotel', 'traveler')); ?>
                            - <?php echo sprintf(__('Showing %s to %s', 'traveler'), $from, $to) ?>
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
                                    echo st()->load_template('layouts/elementor/common/reviews/review', 'list', ['comment' => (object)$comment]);
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
                    <?php TravelHelper::pagination_comment(['total' => $total]) ?>
                    <?php
                    if (comments_open($post_id)) {
                        ?>
                        <div id="write-review">
                            <h4 class="heading">
                                <a href="javascript: void(0)" class="toggle-section c-main f16"
                                data-target="st-review-form"><?php echo __('Write a review', 'traveler') ?>
                                    <i class="fas fa-angle-down"></i></a>
                            </h4>
                            <?php
                            TravelHelper::comment_form();
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
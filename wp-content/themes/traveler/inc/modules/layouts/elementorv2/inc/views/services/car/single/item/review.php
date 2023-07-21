<?php if (comments_open() and st()->get_option('car_review') == 'on') {
    $count_review = get_comment_count($post_id)['approved'];
    ?>
    <div class="st-section-single" id="st-reviews">
        <h2 class="st-heading-section">
            <?php echo esc_html__('Reviews', 'traveler') ?>
        </h2>
        <div id="reviews" class="st-reviews">
            <div class="row">
                <div class="col-12">
                    <div class="review-box">
                        <div class="st-review-box-top d-flex align-items-center">
                            <i class="stt-icon-star1"></i>
                            <?php
                            $avg = STReview::get_avg_rate();
                            ?>
                            <div class="review-score">
                                <?php echo esc_attr($avg); ?><span class="per-total">/5</span>
                            </div>
                            <div class="review-score-text"><?php echo TravelHelper::get_rate_review_text($avg, $count_review); ?></div>
                            <div class="review-score-base text-center">
                                <span>(<?php comments_number(__('0 review', 'traveler'), __('1 review', 'traveler'), __('% reviews', 'traveler')); ?>)</span>
                            </div>
                        </div>
                        <div class="st-summany d-flex flex-wrap justify-content-between">
                        <?php
                            $stats = STReview::get_review_summary();
                            if ($stats) {
                                foreach ($stats as $key=>$stat) {
                                    ?>
                                    <div class="item d-flex align-items-center<?php if($key%2){echo ' justify-content-end';} else {}?>">
                                        <div class="label" style="width: 40%;">
                                            <?php echo esc_html($stat['name']); ?>
                                        </div>
                                        <div class="progress" style="width: 40%;">
                                            <div class="percent"
                                                style="width: <?php echo esc_attr($stat['percent']); ?>%;"></div>
                                        </div>
                                        <div class="label">
                                            <div class="number"><?php echo esc_html($stat['summary']) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            }
                            ?>
                        </div>
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
                    <?php comments_number(__('0 review on this Car', 'traveler'), __('1 review on this Car', 'traveler'), __('% reviews on this Car', 'traveler')); ?>
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
                            echo stt_elementorv2()->loadView('services/common/single/review-list',['comment' => (object)$comment, 'post_type' => 'st_cars']);
                        endforeach;
                    endif;
                    ?>
                </div>
            </div>
            <?php TravelHelper::pagination_comment(['total' => $total,'next_icon'=>"stt-icon-arrow-right", 'prev_icon'=>"stt-icon-arrow-left"]) ?>
            <?php
            if (comments_open($post_id)) {
                ?>
                <div id="write-review">
                    <h4 class="heading">
                        <a href="javascript: void(0)" class="toggle-section c-main f16"
                        data-target="st-review-form"><?php echo __('Write a review', 'traveler') ?>
                            <i class="stt-icon-arrow-down"></i></a>
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
<?php } ?>
<?php if(comments_open() and st()->get_option( 'rental_review' ) == 'on') {?>
<div class="st-hr"></div>
<div class="accordion-item">
    <h2 class="st-heading-section" id="headingReviews">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseReviews" aria-expanded="true" aria-controls="collapseReviews">
            <?php echo esc_html__('Reviews', 'traveler') ?>
        </button>
    </h2>
    <div id="collapseReviews" class="accordion-collapse collapse show" aria-labelledby="headingReviews" data-bs-parent="#headingReviews">
        <div class="accordion-body">
            <div id="reviews" class="hotel-room-review">
                <div class="f18 font-medium15">
                    <span class="mr15"><?php comments_number( __( '0 review', 'traveler' ), __( '1 review', 'traveler' ), __( '% reviews', 'traveler' ) ); ?></span>
                    <?php echo st()->load_template( 'layouts/elementor/common/star', '', [ 'star' => $review_rate, 'style' => 'style-2', 'element' => 'span' ] ); ?>
                </div>
                <div class="review-pagination">
                    <div id="reviews" class="review-list">
                        <?php
                            $comments_count   = wp_count_comments( get_the_ID() );
                            $total            = (int)$comments_count->approved;
                            $comment_per_page = (int)get_option( 'comments_per_page', 10 );
                            $paged            = (int)STInput::get( 'comment_page', 1 );
                            $from             = $comment_per_page * ( $paged - 1 ) + 1;
                            $to               = ( $paged * $comment_per_page < $total ) ? ( $paged * $comment_per_page ) : $total;
                        ?>
                        <?php
                            $offset         = ( $paged - 1 ) * $comment_per_page;
                            $args           = [
                                'number'  => $comment_per_page,
                                'offset'  => $offset,
                                'post_id' => get_the_ID(),
                                'status' => ['approve']
                            ];
                            $comments_query = new WP_Comment_Query;
                            $comments       = $comments_query->query( $args );

                            if ( $comments ):
                                foreach ( $comments as $key => $comment ):
                                    echo st()->load_template( 'layouts/elementor/common/reviews/review', 'list', [ 'comment' => (object)$comment ] );
                                endforeach;
                            endif;
                        ?>
                    </div>
                </div>
                <?php TravelHelper::pagination_comment( [ 'total' => $total ] ) ?>
                <?php
                    if ( comments_open( $room_id ) ) {
                        ?>
                        <div id="write-review">
                            <h4 class="heading">
                                <a href="" class="toggle-section c-main f16" data-target="st-review-form"><?php echo __( 'Write a review', 'traveler' ) ?><i class="fa fa-angle-down ml5"></i></a>
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
<?php }?>
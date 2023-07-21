<?php
    $name = $email = '';
    $userdata = get_userdata(get_current_user_id());
    if($userdata){
        $name = esc_html($userdata->first_name ).' '. esc_html($userdata->last_name);
        $email = $userdata->user_email;
    }
    ?>
<div class="form-wrapper">
    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="form-group">
                <input type="text" class="form-control"
                       name="author" value="<?php echo esc_attr($name); ?>"
                       placeholder="<?php _e('Name *', 'traveler') ?>">
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="form-group">
                <input type="email" class="form-control"
                       name="email" value="<?php echo esc_attr($email) ?>"
                       placeholder="<?php _e('Email *', 'traveler') ?>">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <input type="text" class="form-control"
                       name="comment_title"
                       placeholder="<?php _e('Title', 'traveler') ?>">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="form-group review-items d-flex align-content-start flex-wrap">
                <?php
                    $stats = STReview::get_review_stats( get_the_ID() );
                    if ( !empty( $stats ) ) {
                        foreach ( $stats as $stat ) {
                            ?>
                            <div class="item">
                                <label><?php echo esc_html($stat[ 'title' ]); ?></label>
                                <input class="st_review_stats" type="hidden"
                                       name="st_review_stats[<?php echo trim( $stat[ 'title' ] ); ?>]">
                                <div class="rates">
                                    <?php
                                        for ( $i = 1; $i <= 5; $i++ ) {
                                            echo '<i class="stt-icon-star1 grey"></i>';
                                        }
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                ?>
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <textarea name="comment"
                          class="form-control has-matchHeight"
                          placeholder="<?php _e('Content', 'traveler') ?>"></textarea>
            </div>
        </div>
    </div>
</div>
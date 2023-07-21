<div class="owner-info d-none d-sm-block widget-box st-border-radius">
    <h4 class="heading"><?php echo __('Owner', 'traveler') ?></h4>
    <div class="media d-flex align-items-center">
        <div class="media-left">
            <?php
            $author_id = get_post_field('post_author', get_the_ID());
            $userdata = get_userdata($author_id);
            ?>
            <a href="<?php echo st_get_author_posts_url(get_the_ID(),70); ?>">
                <?php
                if(!empty($size_avatar_custom)){
                    $size_avatar = $size_avatar_custom;
                } else {
                    $size_avatar = 60;
                }
                echo st_get_profile_avatar($author_id, $size_avatar);
                ?>
            </a>
        </div>
        <div class="media-body">
            <h4 class="media-heading">
                <a
                href="<?php echo st_get_author_posts_url(get_the_ID(),70); ?>"
                class="author-link"><?php echo TravelHelper::get_username($author_id); ?></a>
            </h4>
            <p><?php echo sprintf(__('Member Since %s', 'traveler'), !empty($userdata->user_registered) ? date('Y', strtotime($userdata->user_registered)) : '') ?></p>
        </div>
    </div>
    <div class="question-author">
        <?php
            $enable_inbox = st()->get_option('enable_inbox');
            if($enable_inbox === 'on' && get_post_type(get_the_ID()) != 'st_hotel'){ ?>
                <div class="st_ask_question text-center">
                    <?php
                        if (!is_user_logged_in()) {?>
                        <a href="" class="login btn btn-primary" data-bs-toggle="modal" data-bs-target="#st-login-form"><?php echo __('Ask a Question', 'traveler');?></a>
                    <?php } else{?>
                        <a href="" id="btn-send-message-owner" class="btn-send-message-owner btn btn-primary" data-id="<?php echo get_the_ID();?>"><?php echo __('Ask a Question', 'traveler');?></a>
                    <?php }?>
                </div>
        <?php }?>
    </div>
</div>
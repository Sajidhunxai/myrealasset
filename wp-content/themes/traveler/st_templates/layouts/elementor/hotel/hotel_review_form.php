<?php
$style_hotel = get_post_meta( get_the_ID(), 'hotel_layout_style', true );
$flex_nowrap_item = '';
$flex_nowrap ='';
if($style_hotel === '4' || $style_hotel === '5'){
    
    $col_stats = 'col-12 col-sm-12';
    $col_note = 'col-md-12';
    $flex_nowrap_item = ' d-flex align-content-start flex-wrap';
} else {
    $flex_nowrap = ' flex-nowrap';
    $col_stats = 'col-12 col-md-4 order-2 col-md-push-8';
    $col_note = 'col-md-8 order-1 col-md-pull-4';
    
}
?>
<div class="form-wrapper">
    <div class="row">
        <div class="col-12 col-sm-6">
            <div class="form-group">
                <input type="text" class="form-control st-border-radius"
                       name="author"
                       placeholder="<?php _e('Name *', 'traveler') ?>">
            </div>
        </div>
        <div class="col-12 col-sm-6">
            <div class="form-group">
                <input type="email" class="form-control st-border-radius"
                       name="email"
                       placeholder="<?php _e('Email *', 'traveler') ?>">
            </div>
        </div>
        <div class="col-12 col-sm-12">
            <div class="form-group">
                <input type="text" class="form-control st-border-radius"
                       name="comment_title"
                       placeholder="<?php _e('Title', 'traveler') ?>">
            </div>
        </div>
    </div>

    <div class="row<?php echo esc_attr($flex_nowrap);?> align-self-stretch">
        <div class="<?php echo esc_attr($col_stats);?>">
            <div class="form-group review-items<?php echo esc_attr($flex_nowrap_item);?>">
                <?php
                    $stats = STReview::get_review_stats( get_the_ID() );
                    if ( !empty( $stats ) ) {
                        
                        if($style_hotel === '4' || $style_hotel === '5'){
                            $icon_review = '<i class="stt-icon-star1 grey"></i>';
                        } else {
                            $icon_review = '<i class="far fa-smile grey"></i>';
                        }
                        foreach ( $stats as $stat ) {
                            ?>
                            <div class="item">
                                <label><?php echo esc_html($stat[ 'title' ]); ?></label>
                                <input class="st_review_stats" type="hidden"
                                       name="st_review_stats[<?php echo trim( $stat[ 'title' ] ); ?>]">
                                <div class="rates">
                                    <?php
                                        for ( $i = 1; $i <= 5; $i++ ) {
                                            echo ($icon_review);
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
        <div class= "<?php echo esc_attr($col_note);?>">
            <div class="form-group">
                <textarea name="comment"
                          class="form-control st-border-radius"
                          placeholder="<?php _e('Content', 'traveler') ?>"></textarea>
            </div>
        </div>
    </div>
</div>

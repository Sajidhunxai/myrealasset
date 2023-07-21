<?php
if (!$st_blog_style) {
    $st_blog_style = 4;
}
$st_blog_style = ((int)$st_blog_style <= 0) ? 1 : (int)$st_blog_style;
$col = 12 / $st_blog_style;
?>
<div class="col-md-<?php echo esc_attr($col) ?> col-sm-6 col-xs-12">
    <div class="thumb text-center">
        <a class="hover-img curved" href="<?php the_permalink() ?>">
            <?php
            $img = get_the_post_thumbnail(get_the_ID(), array(740, 740), array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id())));
            if (!empty($img)) {
                echo balanceTags($img);
            } else {
                echo '<img width="800" height="600" alt="no-image" class="wp-post-image" src="' . ST_TRAVELER_URI . '/img/no-image.png">';
            }
            ?>
        </a>
    </div>
    <div class="thumb-caption ">
        <p class="title f18"><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo esc_html(get_the_title()); ?></a></p>
        <p class="date"><?php the_time('d M Y')?></p>
    </div>
</div>
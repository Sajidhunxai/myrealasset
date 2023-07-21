<?php 
global $st_search_args;
$st_search_args['location_id'] = get_the_ID();
while (have_posts()): the_post(); ?>
<div id="st-content-wrapper" class="st-style-elementor st-page-default st-location style-2">
    <?php 
        echo stt_elementorv2()->loadView('components/banner');
    ?>
    <div class="st-blog">
        <?php
        the_content();
        wp_reset_postdata();
        ?>
    </div>
</div>
<?php endwhile;
?>

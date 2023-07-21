<?php
/**
 * Template Name: Hotel Activity
 */
?>
<?php get_header('hotel-activity');?>
  <div id="main-content">
        <div class="container">
            <?php
                while ( have_posts() ) {
                    the_post();
                    the_content();
                }
                wp_reset_query();
                ?>
        </div>

    </div>

<?php get_footer('hotel-activity');?>
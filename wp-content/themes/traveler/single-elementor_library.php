<?php
echo st()->load_template('layouts/elementor/common/header');
?>
    <div id="st-content-wrapper" class="st-style-elementor">
        
   
            <?php
            if ( have_posts() ) {
                the_post();
                the_content();
            }
            wp_reset_postdata();
            ?>
    
    </div>
<?php
echo st()->load_template('layouts/elementor/common/footer');
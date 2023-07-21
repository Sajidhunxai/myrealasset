<?php
/*
  Template Name: Blank template
 */

get_header();
?>
<div id="st-content-wrapper" class="st-style-elementor">
    <?php
    $menu_transparent = st()->get_option('menu_transparent', '');
    if($menu_transparent === 'on'){
        $thumb_id = get_post_thumbnail_id(get_the_ID());
        
        if($thumb_id){
            $img_url = wp_get_attachment_image_url($thumb_id, 'full');
            echo stt_elementorv2()->loadView('components/banner', ['img_url' => $img_url]);
        }
        
    }
    if(have_posts()){
        while (have_posts()) {
            the_post();
            the_content();
        }
    }
    ?>
</div>
<?php
get_footer();

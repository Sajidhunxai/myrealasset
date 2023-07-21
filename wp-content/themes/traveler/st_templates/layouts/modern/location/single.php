<div id="st-content-wrapper" class="st-single-hotel-modern-page search-result-page">
    <?php
        $inner_style = '';
        if(is_single() or is_page()){
            $thumb_id = get_post_thumbnail_id(get_the_ID());
            if(!empty($thumb_id)){
                $img = wp_get_attachment_image_url($thumb_id, 'custom-size-banner');
                $inner_style = Assets::build_css("background-image: url(". esc_url($img) .") !important;");
            } else {
                $inner_style = Assets::build_css("background-color: var(--grey-color, #EAEEF3)");
            }
        }

        if(is_category() or is_tag() or is_search()){
            $img = st()->get_option('header_blog_image', '');
            if(!empty($img))
                $inner_style = Assets::build_css("background-image: url(". esc_url($img) .") !important;");
        }
    ?>
    <div class="sts-banner <?php echo esc_attr($inner_style); ?>">
        <div class="container">
            <h1>
            <?php
                if(is_archive()){
                    the_archive_title('', '');
                }elseif (is_search()){
                    echo sprintf(__('Search results : "%s"', 'traveler'), STInput::get('s', ''));
                }else{
                    echo get_the_title();
                }
            ?>
        </h1>
        </div>
    </div>
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

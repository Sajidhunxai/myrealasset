<?php

$inner_style = '';
if (is_single() || is_page()) {
    $thumb_id = get_post_thumbnail_id(get_the_ID());
    $img = wp_get_attachment_image_url($thumb_id, 'full');
    $inner_style = Assets::build_css("background-image: url(" . esc_url($img) . ") !important;");
}
if (is_archive() || is_tag() || is_search()) {
    $img = st()->get_option('header_blog_image', '');
    if (!empty($img)){
        $inner_style = Assets::build_css("background-image: url(" . esc_url($img) . ") !important;");
    } else {
        $thumb_id = get_post_thumbnail_id(get_the_ID());
        $img = wp_get_attachment_image_url($thumb_id, 'full');
        $inner_style = Assets::build_css("background-image: url(" . esc_url($img) . ") !important;");
    }
        
}

if (is_page_template('template-hotel-search.php') or is_page_template('template-tour-search.php') or is_page_template('template-activity-search.php') or is_page_template('template-cars-search.php')) {
    $enable_tree = st()->get_option('bc_show_location_tree', 'off');
    $location_id = STInput::get('location_id', '');
    $location_name = STInput::get('location_name', '');
    $post_type = 'st_hotel';
    if (is_page_template('template-tour-search.php')) {
        $post_type = 'st_tours';
    }
    if (is_page_template('template-activity-search.php')) {
        $post_type = 'st_activity';
    }
    if (is_page_template('template-cars-search.php')) {
        $post_type = 'st_cars';
    }
    if ($enable_tree == 'on') {
        $lists = TravelHelper::getListFullNameLocation($post_type);
        
        $locations = TravelHelper::buildTreeHasSort($lists);
    } else {
        $locations = TravelHelper::getListFullNameLocation($post_type);
    }
}
$class = '';
$menu_style = st()->get_option('menu_style_modern', '');
if($menu_style == 8){
    $class = 'banner--solo';
}
?>
<div class="banner <?php echo esc_attr($inner_style) . ' ' . esc_attr($class); ?>">
    <div class="container">
        <?php if($menu_style == 8){  ?>
                <div class="banner-headding">
                    <?php if (is_page() || is_home() || is_author() || is_tax()) { ?>
                        <p class="banner-title-solo">
                            <?php echo (is_home()) ? get_the_title(get_option('page_for_posts', true)) : get_the_title(); ?>
                        </p>
                        <?php $content = (is_home()) ? get_post_meta(get_option('page_for_posts', true), 'page_header_text', true) : get_post_meta(get_the_ID(), 'page_header_text', true); ?>
                        <?php 
                            if(is_tax()){ ?>
                                <h3 class="banner-content-solo">
                                    <?php the_archive_title('', ''); ?>
                                </h3>
                            <?php } else { ?>
                                <?php if ($content) { ?>
                                    <h3 class="banner-content-solo">
                                        <?php echo esc_html($content); ?>
                                    </h3>
                                <?php } ?>
                            <?php }
                        ?>
                        
                    <?php } ?>
                </div>
        <?php }else{ ?>
            <div class="banner-content">
                <h1>
                    <?php
                    if (is_archive()) {
                        the_archive_title('', '');
                    } elseif (is_search()) {
                        echo sprintf(__('Search results : "%s"', 'traveler'), esc_html(STInput::get('s', '')));
                    } else {
                        echo get_the_title();
                    }
                    ?>
                    <?php ?>
                </h1>
            </div>
        
        <?php } ?>
        <?php if (is_page_template('template-hotel-search.php') or is_page_template('template-tour-search.php') or is_page_template('template-activity-search.php') or is_page_template('template-cars-search.php')) { ?>
            <form action="<?php echo get_the_permalink(); ?>" name="get" class="hidden-lg hidden-md d-sm-none">
                <div class="search-form-mobile">
                    <div class="form-group">
                        <div class="form-extra-field dropdown">
                            <div class="icon-field">
                                <?php echo TravelHelper::getNewIcon('ico_maps_search_box', 'gray', '20px', '20px', true); ?>
                            </div>
                            <input type="hidden" name="location_id" class="form-control" value="<?php echo esc_attr($location_id); ?>"/>
                            
                            <?php
                                if(empty($location_name)) {
                                    $placeholder = __('Where are you going?', 'traveler');
                                }else{
                                    $placeholder = esc_html($location_name);
                                }
                            ?>
                            <input type="text" class="form-control" autocomplete = "off" onkeyup="stKeyupsmartSearch(this)" id="dropdown-mobile-destination" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  name="location_name" value="<?php echo esc_attr($location_name); ?>" placeholder = "<?php echo esc_attr($placeholder);?>" />
                            <ul class="dropdown-menu" aria-labelledby="dropdown-mobile-destination">
                                <?php
                                if ($enable_tree == 'on') {
                                    New_Layout_Helper::buildTreeOptionLocation($locations, $location_id);
                                } else {
                                    if (is_array($locations) && count($locations)):
                                        foreach ($locations as $key => $value):
                                            ?>
                                            <li class="item" data-value="<?php echo esc_attr($value->ID); ?>">
                                                <?php echo TravelHelper::getNewIcon('ico_maps_search_box', 'gray', '16px', '16px', true); ?>
                                                <span><?php echo esc_html($value->fullname); ?></span></li>
                                            <?php
                                        endforeach;
                                    endif;
                                }
                                ?>
                            </ul>
                        </div>
                        <button type="submit" class="btn btn-primary"><?php echo TravelHelper::getNewIcon('ico_search_header', '#ffffff', '25px', '25px', true); ?></button>
                    </div>
                </div>
            </form>
        <?php } ?>
    </div>
    <div id="overlay"></div>
</div>

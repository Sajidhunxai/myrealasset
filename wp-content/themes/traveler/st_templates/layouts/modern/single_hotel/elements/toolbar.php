<?php
/**
 * Created by PhpStorm.
 * User: HanhDo
 * Date: 3/1/2019
 * Time: 3:14 PM
 */

if($type_of_page == 'list_page'){
$taxonomy_filtered = st()->get_option('st_hotel_alone_tax_in_room_page');

$terms = get_terms(array(
    'taxonomy' => $taxonomy_filtered,
    'hide_empty' => false,
));

$get_data = $get_data_layout = $_GET;
$get_data_all = $get_data;

if (isset($get_data_all['term_name']))
    unset($get_data_all['term_name']);
$link_all = add_query_arg($get_data_all, get_the_permalink());

?>
<div class="sts-toolbar">
    <ul class="list-category hidden-sm hidden-xs">
        <li><a href="<?php echo esc_url($link_all); ?>"
               class="<?php echo (!isset($_GET['term_name']) || (isset($_GET['term_name']) && $_GET['term_name'] == 'all')) ? 'active' : ''; ?>" data-value="all"><?php echo __('All', 'traveler'); ?></a>
        </li>
        <?php
        if (!is_wp_error($terms) && !empty($terms)) {
            foreach ($terms as $k => $v) {
                $get_data['term_name'] = $v->slug;
                $link = add_query_arg($get_data, get_the_permalink());
                $class_active = '';
                if (isset($_GET['term_name'])) {
                    if ($_GET['term_name'] == $v->slug)
                        $class_active = 'active';
                }
                echo '<li><a href="' . esc_url($link) . '" class="' . esc_attr($class_active) . '" data-value="'. esc_attr($v->term_id) .'">' . esc_html($v->name) . '</a></li>';
            }
        }
        ?>
    </ul>

    <div class="dropdown-category hidden-lg hidden-md">
        <form method="get">
            <?php
            $form_layout = isset($_GET['layout']) ? $_GET['layout'] : $layout;
            ?>
            <input type="hidden" name="layout"  value="<?php echo esc_attr($form_layout); ?>"/>
            <?php
            if (!empty($terms)) {
                $get_term_id = STInput::get('term_id');
                //echo '<select name="term_id" onchange="this.form.submit()" class="form-control">';
                echo '<select name="term_id" class="form-control">';
                echo '<option value="all">'. __('All', 'traveler') .'</option>';
                foreach ($terms as $k => $v) {
                    $selected = '';
                    if(!empty($get_term_id))
                        if($get_term_id == $v->term_id)
                            $selected = 'selected';
                    echo '<option value="'. esc_attr($v->term_id) .'" '. ($selected) .'>'. esc_html($v->name) .'</option>';
                }
                echo '</select>';
            }
            ?>
        </form>
    </div>

    <ul class="layout">
        <?php
        $arr_layout = array('list', 'grid');
        $layout_val = isset($_GET['layout']) ? $_GET['layout'] : $layout;

        if ($layout_val == 'list') {
            $get_data_layout['layout'] = 'grid';
            $link_layout = add_query_arg($get_data_layout, get_the_permalink());
            echo ' <li data-value="grid"><a href="' . esc_url($link_layout) . '">' . TravelHelper::getNewIcon('ico_grid_2', '#333', '', '', true) . '</a></li>';
            $get_data_layout['layout'] = 'list';
            $link_layout = add_query_arg($get_data_layout, get_the_permalink());
            echo ' <li class="active" data-value="list"><a href="' . esc_url($link_layout) . '">' . TravelHelper::getNewIcon('ico_list_2', '#5191FA', '', '', true) . '</a></li>';
        } else {
            $get_data_layout['layout'] = 'grid';
            $link_layout = add_query_arg($get_data_layout, get_the_permalink());
            echo ' <li class="active" data-value="grid"><a href="' . esc_url($link_layout) . '">' . TravelHelper::getNewIcon('ico_grid_2', '#5191FA', '', '', true) . '</a></li>';
            $get_data_layout['layout'] = 'list';
            $link_layout = add_query_arg($get_data_layout, get_the_permalink());
            echo ' <li data-value="list"><a href="' . esc_url($link_layout) . '">' . TravelHelper::getNewIcon('ico_list_2', '#333', '', '', true) . '</a></li>';
        }
        ?>
    </ul>
</div>
<?php
}else{
    $check_in = STInput::get('check_in', date( TravelHelper::getDateFormat() ));
    $check_out = STInput::get('check_out', date( TravelHelper::getDateFormat(), strtotime( "+ 1 day" ) ));
    $adult = STInput::get('adult_num_search');
    $child = STInput::get('children_num_search', 0);
    ?>
    <div class="sts-toolbar <?php echo esc_attr($type_of_page); ?>">

        <p class="result-text"><?php echo __('Result', 'traveler'); ?></p>

        <?php
        if(!empty($check_in) && !empty($check_out)){ ?>
            <div class="item-param date">
                <span class="label"><?php echo __('Date', 'traveler'); ?>:</span>
                <span class="value">
                    <?php echo esc_html($check_in . ' - ' . $check_out); ?>
                </span>
            </div>
        <?php } ?>

        <?php if(!empty($adult)){ ?>
            <div class="item-param">
                <span class="label"><?php echo __('Adult', 'traveler'); ?>:</span>
                <span class="value"><?php echo esc_html($adult); ?></span>
            </div>
        <?php } ?>

        <?php
        if(isset($_GET['children_num_search'])){
        ?>
        <div class="item-param">
            <span class="label"><?php echo __('Children', 'traveler'); ?>:</span>
            <span class="value"><?php echo esc_html($child); ?></span>
        </div>
        <?php } ?>
        <a class="btn btn-default st-modify-room-search sts-popup sts-btn" href="#sts-search-popup" data-effect="mfp-zoom-in"><span><?php echo __('Modify', 'traveler'); ?></span></a>
    </div>
    <?php
}

<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * User my activity
 *
 * Created by ShineTheme
 *
 */
?>
<div class="st-create clearfix">
    <h2  class="pull-left clearfix"><?php st_the_language('my_activities') ?></h2>
    <a class="btn btn-default pull-right" href="<?php echo esc_url( add_query_arg( 'sc' , 'create-activity' , get_permalink() ) ) ?>">
        <?php _e("Add New Activity",'traveler') ?>
    </a>
</div>
<?php
    $paged  = get_query_var( 'paged', 1);
    $search = get_query_var( '_s', STInput::get( '_s' ), '' );
?>
<div class="row">
    <div class="col-xs-12">
        <form action="<?php echo esc_url( add_query_arg( 'sc' , 'my-activity' , get_permalink() ) ) ?>" method="get" class="form form-inline partner-search-form">
            <input type="hidden" name="sc" value="my-activity">
            <input class="search-box form form-control" type="text" name="_s" value="<?php echo esc_attr($search) ?>">
            <button class="btn btn-default" type="submit">
                <?php esc_html_e( 'Search Activity', 'traveler' ) ?>
            </button>
        </form>
    </div>
</div>
<div class="msg">
    <?php echo STUser_f::get_msg(); ?>
</div>
<div class="style-list">
<?php
    $paged  = (get_query_var('paged' ) ? get_query_var('paged' ) : 1) ;
    $paged = max( 1, $paged );
    $author = $data->ID;
    $cls_package = STAdminPackages::get_inst();

    if($cls_package->get_user_role() == 'administrator'){
        $author = '';
    }

    $args = array(
        'post_type' => 'st_activity',
        'post_status'=>'publish , draft , trash',
        'author'=>$author,
        'posts_per_page'=>10,
        'paged'=>$paged,
        'orderby'        => 'title',
        'order'          => 'asc',
        's' => $search,
    );
    $query=new WP_Query($args);
    if ( $query->have_posts() ) {
        while ($query->have_posts()) {
            $query->the_post();
            echo st()->load_template('user/loop/loop', 'activity' ,get_object_vars($data));
        }
    }else{
        echo '<h5>'.st_get_language('no_activity').'</h5>';
    };
    wp_reset_postdata();
?>
</div>
<div class="st-footer-wrap">
    <div class="pull-left">
        <?php st_paging_nav(null,$query) ?>
    </div>
    <div class="pull-right">
        <a class="btn btn-default pull-right" href="<?php echo esc_url( add_query_arg( 'sc' , 'create-activity' , get_permalink() ) ) ?>">
            <?php _e("Add New Activity",'traveler') ?>
        </a>
    </div>
</div>
<?php  wp_reset_query(); ?>

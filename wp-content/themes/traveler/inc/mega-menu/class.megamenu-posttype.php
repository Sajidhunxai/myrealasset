<?php
class ST_Mega_Menu_Post_Type{

    protected $post_type = 'st_mega_menu';

    public function __construct()
    {
        add_action('init', [$this, 'init_post_type']);
    }

    function init_post_type()
    {
        if ( !st_check_service_available( $this->post_type ) ) {
            return;
        }

        if ( !function_exists( 'st_reg_post_type' ) ) return;

        $labels = [
            'name'                  => __( 'Mega Menus', 'traveler' ),
            'singular_name'         => __( 'Mega Menu', 'traveler' ),
            'menu_name'             => __( 'Mega Menu', 'traveler' ),
            'name_admin_bar'        => __( 'Mega Menu', 'traveler' ),
            'add_new'               => __( 'Add New', 'traveler' ),
            'add_new_item'          => __( 'Add New Mega Menu', 'traveler' ),
            'new_item'              => __( 'New Mega Menu', 'traveler' ),
            'edit_item'             => __( 'Edit Mega Menu', 'traveler' ),
            'view_item'             => __( 'View Mega Menu', 'traveler' ),
            'all_items'             => __( 'All Mega Menu', 'traveler' ),
            'search_items'          => __( 'Search Mega Menu', 'traveler' ),
            'parent_item_colon'     => __( 'Parent Mega Menu:', 'traveler' ),
            'not_found'             => __( 'No Mega Menu found.', 'traveler' ),
            'not_found_in_trash'    => __( 'No Mega Menu found in Trash.', 'traveler' ),
            'insert_into_item'      => __( 'Insert into Mega Menu', 'traveler' ),
            'uploaded_to_this_item' => __( "Uploaded to this Mega Menu", 'traveler' ),
            'featured_image'        => __( "Feature Image", 'traveler' ),
            'set_featured_image'    => __( "Set featured image", 'traveler' )
        ];

        $args = [
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'query_var'          => false,
            'rewrite'            => false,
            'capability_type'    => 'post',
            'hierarchical'       => false,
            'supports'           => ['title', 'editor' ],
            'menu_icon'          => 'dashicons-editor-kitchensink'
        ];
        st_reg_post_type( $this->post_type, $args );
    }
}

new ST_Mega_Menu_Post_Type();
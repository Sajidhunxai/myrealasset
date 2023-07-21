<?php
    /**
     * @package    WordPress
     * @subpackage Traveler
     * @since      1.0
     *
     * Class STAdminEmail
     *
     * Created by ShineTheme
     *
     */
    if ( !class_exists( 'STAdminEmail' ) ) {
        class STAdminEmail extends STAdmin
        {
            protected static $_inst;
            function __construct()
            {
                add_action( 'init', [ $this, 'init_post_type' ], 8 );
                add_action( 'add_meta_boxes', function() {
                    add_meta_box( 'st-description_guide', __('Guide build template','traveler'), array($this,'st_description_guider'), 'st_template_email', 'side' );
                } );
            }
            
             
            //Meta callback function
            function st_description_guider( $post ) { ?>
                <div style="padding-top:30px;padding-bottom:30px">
                    <a href="https://travelerwp.com/email-template-shortcode/" target><?php echo __('Click to Guide build template email','traveler');?></a>
                </div>  
            <?php }
            function init_post_type()
            {
                if ( !function_exists( 'st_reg_post_type' ) ) return;
            // Template Email ==============================================================

            $labels = [
                'name'                  => __( 'Template Email', 'traveler' ),
                'singular_name'         => __( 'Template Email', 'traveler' ),
                'menu_name'             => __( 'Template Email', 'traveler' ),
                'name_admin_bar'        => __( 'Template Email', 'traveler' ),
                'add_new'               => __( 'Add New', 'traveler' ),
                'add_new_item'          => __( 'Add New Template Email', 'traveler' ),
                'new_item'              => __( 'New Template Email', 'traveler' ),
                'edit_item'             => __( 'Edit Template Email', 'traveler' ),
                'view_item'             => __( 'View Template Email', 'traveler' ),
                'all_items'             => __( 'All Template Email', 'traveler' ),
                'search_items'          => __( 'Search Template Email', 'traveler' ),
                'parent_item_colon'     => __( 'Parent Template Email:', 'traveler' ),
                'not_found'             => __( 'No Template Email found.', 'traveler' ),
                'not_found_in_trash'    => __( 'No Template Email found in Trash.', 'traveler' ),
                'insert_into_item'      => __( 'Insert into Template Email', 'traveler' ),
                'uploaded_to_this_item' => __( "Uploaded to this Template Email", 'traveler' ),
                'featured_image'        => __( "Feature Image", 'traveler' ),
                'set_featured_image'    => __( "Set featured image", 'traveler' )
            ];

            $args = [
                'labels'             => $labels,
                'public'             => true,
                'publicly_queryable' => false,
                'show_ui'            => true,
                'query_var'          => true,
                'rewrite'            => [ 'slug' => get_option( 'template_email_permalink', 'st_template_email' ) ],
                'capability_type'    => 'post',
                'hierarchical'       => false,
                'supports'           => [ 'author', 'title', 'excerpt', 'editor'],
                'menu_icon'          => 'dashicons-email'
            ];
            st_reg_post_type( 'st_template_email', $args );
            }
	        static function inst()
	        {
		        if ( !self::$_inst ) {
			        self::$_inst = new self();
		        }

		        return self::$_inst;
	        }
        }

        STAdminEmail::inst();
    }

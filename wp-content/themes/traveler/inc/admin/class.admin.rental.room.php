<?php
    /**
     * @since 1.1.3
     **/
    if ( !class_exists( 'STReltalRoom' ) ) {

        class STReltalRoom extends STAdmin
        {

            function __construct()
            {

                if ( !st_check_service_available( 'st_rental' ) ) return;

                //parent::__construct();
                //add colum for rooms
                add_filter( 'manage_rental_room_posts_columns', [ $this, 'add_col_header' ], 10 );
                add_action( 'manage_rental_room_posts_custom_column', [ $this, 'add_col_content' ], 10, 2 );

                add_action( 'current_screen', [ $this, 'init_metabox' ] );

                add_filter( 'st_rental_room_layout', [ $this, 'custom_rental_room_layout' ] );

                add_action( 'init', [ $this, 'add_room_attribute' ], 20 );

            }

            function add_room_attribute()
            {

                if ( !function_exists( 'st_reg_post_type' ) ) return;

                $name   = __( 'Room Type', 'traveler' );
                $labels = [
                    'name'              => $name,
                    'singular_name'     => $name,
                    'search_items'      => sprintf( __( 'Search %s', 'traveler' ), $name ),
                    'all_items'         => sprintf( __( 'All %s', 'traveler' ), $name ),
                    'parent_item'       => sprintf( __( 'Parent %s', 'traveler' ), $name ),
                    'parent_item_colon' => sprintf( __( 'Parent %s', 'traveler' ), $name ),
                    'edit_item'         => sprintf( __( 'Edit %s', 'traveler' ), $name ),
                    'update_item'       => sprintf( __( 'Update %s', 'traveler' ), $name ),
                    'add_new_item'      => sprintf( __( 'New %s', 'traveler' ), $name ),
                    'new_item_name'     => sprintf( __( 'New %s', 'traveler' ), $name ),
                    'menu_name'         => $name,
                ];

                $args = [
                    'hierarchical' => true,
                    'labels'       => $labels,
                    'show_ui'      => true,
                    'show_ui'      => 'edit.php?post_type=st_rental',
                    'query_var'    => true,
                    'public' => apply_filters('stt_show_term_frontend',false),
                ];

                st_reg_taxonomy( 'room_rental_type', 'rental_room', $args );
            }

            function add_col_header( $defaults )
            {

                $this->array_splice_assoc( $defaults, 2, 0, [ 'rental_parent' => __( 'Rental Name', 'traveler' ) ] );

                return $defaults;
            }

            function add_col_content( $column_name, $post_ID )
            {

                if ( $column_name == 'rental_parent' ) {
                    // show content of 'directors_name' column
                    $parent = get_post_meta( $post_ID, 'room_parent', TRUE );

                    if ( $parent ) {
                        echo "<a href='" . get_edit_post_link( $parent ) . "'>" . get_the_title( $parent ) . "</a>";
                    }

                }
                if ( $column_name == 'room_number' ) {
                    echo get_post_meta( $post_ID, 'number_room', TRUE );
                }
            }

            /**
             * @since 1.1.3
             **/
            public function init_metabox()
            {
                $screen = get_current_screen();
                if ( $screen->id != 'rental_room' ) {
                    return false;
                }

                $this->metabox[] = [
                    'id'       => 'rental_room_metabox',
                    'title'    => __( 'Room Setting', 'traveler' ),
                    'desc'     => '',
                    'pages'    => [ 'rental_room' ],
                    'context'  => 'normal',
                    'priority' => 'high',
                    'fields'   => [
                        [
                            'label' => __( 'General', 'traveler' ),
                            'id'    => 'room_reneral_tab',
                            'type'  => 'tab'
                        ],

                        [
                            'label'       => __( 'Select the rental own this room', 'traveler' ),
                            'id'          => 'room_parent',
                            'type'        => 'post_select_ajax',
                            'desc'        => __( 'This room will in selected rental', 'traveler' ),
                            'post_type'   => 'st_rental',
                            'placeholder' => __( 'Search for a Rental', 'traveler' )
                        ],
                        [
                            'label' => __( 'Room gallery', 'traveler' ),
                            'id'    => 'gallery',
                            'type'  => 'gallery',
                            'desc'  => __( 'Upload room images to show to customers', 'traveler' )
                        ],
                        [
                            'label'     => __( 'Rental room layout', 'traveler' ),
                            'id'        => 'st_custom_layout',
                            'post_type' => 'st_layouts',
                            'desc'      => __( 'Select the layout for display one single room', 'traveler' ),
                            'type'      => 'select',
                            'choices'   => st_get_layout( 'rental_room' )
                        ],
                        [
                            'label' => __( 'Room facility', 'traveler' ),
                            'id'    => 'rental_facility',
                            'type'  => 'tab'
                        ],
                        [
                            'label' => __( 'Number of adults', 'traveler' ),
                            'id'    => 'adult_number',
                            'type'  => 'text',
                            'desc'  => __( 'Number of adults in room', 'traveler' ),
                            'std'   => '1'
                        ],
                        [
                            'label' => __( 'Number of children', 'traveler' ),
                            'id'    => 'children_number',
                            'type'  => 'text',
                            'desc'  => __( 'Number of children in room', 'traveler' ),
                            'std'   => '0'
                        ],
                        [
                            'label' => __( 'Number of beds', 'traveler' ),
                            'id'    => 'bed_number',
                            'type'  => 'text',
                            'desc'  => __( 'Number of beds in room', 'traveler' ),
                            'std'   => '0'
                        ],
                        [
                            'label' => __( 'Room footage ( square meters )', 'traveler' ),
                            'desc'  => __( 'Room footage ( square meters )', 'traveler' ),
                            'id'    => 'room_footage',
                            'type'  => 'text',
                        ],

                        [
                            'label'    => __( 'Add new facility', 'traveler' ),
                            'id'       => 'add_new_facility',
                            'desc'     => __( 'You can add unlimited facility ', 'traveler' ),
                            'type'     => 'list-item',
                            'settings' => [
                                [
                                    'id'    => 'value',
                                    'type'  => 'text',
                                    'std'   => '',
                                    'label' => __( 'Value', 'traveler' )
                                ],
                                [
                                    'id'    => 'facility_icon',
                                    'type'  => 'text',
                                    'std'   => '',
                                    'label' => __( 'Icon', 'traveler' ),
                                    'desc'  => __( 'Support: fonticon <code>(eg: fa-facebook)</code>', 'traveler' )
                                ],
                            ]
                        ],

                        [
                            'label' => __( 'More description', 'traveler' ),
                            'id'    => 'room_description',
                            'type'  => 'textarea',
                            'std'   => ''
                        ],
                    ]
                ];

                parent::register_metabox( $this->metabox );
            }

            /**
             * @since 1.1.3
             **/
            public function custom_rental_room_layout( $old_layout_id = false )
            {

                if ( is_singular( 'rental_room' ) ) {

                    $meta = get_post_meta( get_the_ID(), 'st_custom_layout', true );
                    if ( $meta ) {
                        return $meta;
                    }
                }

                return $old_layout_id;
            }
        }

        new STReltalRoom();
    }
?>
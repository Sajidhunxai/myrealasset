<?php

/**

 * Created by Shinecommerce.

 * User: Administrator

 * Date: 12/04/2022
 * 
 */

if (!class_exists('st_list_post_new')){

    class st_list_post_new extends WP_Widget {

        public function __construct() {

            $widget_ops = array('classname' => 'st_list_post_new', 'description' => __( "Display a list of your posts..") );

            parent::__construct( 'st_list_post_new',__("ST List Post New" , 'traveler'), $widget_ops );

        }

        public function widget( $args, $instance ) {
            $instance=wp_parse_args($instance,array(

				'title' => '',
                    
                'orderby' => '',
                    
                'order' => '',

                'count'=>5,
			) );
        
        $title                 = apply_filters( 'widget_title', $instance['title'] );

		$title = apply_filters( 'widget_title', empty( $title ) ? '' : $title, $instance, $this->id_base );

		$instance['title']     = $title;

		extract($instance);
        echo ($args['before_widget']);
        if ( $title ) {

            echo balanceTags($args['before_title'] . $title . $args['after_title']);

        }
        $number = ( ! empty( $instance['count'] ) ) ? absint( $instance['count'] ) : 5;
        $order = ( ! empty( $instance['order'] ) ) ? absint( $instance['order'] ) : 'DESC';
        $orderby = ( ! empty( $instance['orderby'] ) ) ? absint( $instance['orderby'] ) : 'ID';
     
        $arg= array(

            'posts_per_page'      => $number,

            'no_found_rows'       => true,

            'post_status'         => 'publish',

            'order'               => $order,
            
            'orderby'             => $orderby,

        );
        $r = new WP_Query($arg);
        if ($r->have_posts()) : ?>
            <ul class="st-list-post">

                <?php while ( $r->have_posts() ) : $r->the_post(); ?>

                    <li>
                      
                        <a href="<?php the_permalink(); ?>">

                            <?php the_post_thumbnail('thumbnail', array('alt' => TravelHelper::get_alt_image(get_post_thumbnail_id( get_the_ID() ))))?>

                        </a>
                      
                        <div class="thumb-list-item-caption">

                            <h3 class="thumb-list-item-title"><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h3>

                            <p class="thumb-list-item-meta"><?php echo  get_the_date()?></p>

                        </div>

                    </li>

                <?php endwhile; ?>

            </ul>
        
        <?php  endif;
        echo ($args['after_widget']);
           
        }



        public function form( $instance )

        {

            $instance = wp_parse_args((array)$instance, array(

                    'title' => '',
                    
                    'orderby' => '',
                    
                    'order' => '',

                    'count'=>5,

                )

            );
            extract($instance);
            ?>

            <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

            <p><label for="<?php echo esc_attr($this->get_field_id('orderby')) ; ?>"><?php echo __("Order By" , 'traveler') ; ?></label>

            <select name='<?php echo esc_attr($this->get_field_name('orderby')); ?>'>

                <option value=''> -- Select -- </option>

                <option <?php if ($orderby =="ID") echo esc_attr("selected") ;?> value='ID'><?php echo __("ID" , 'traveler') ; ?></option>

                <option <?php if ($orderby =="date") echo esc_attr("selected") ;?> value='date'><?php echo __("Date" , 'traveler') ; ?></option>

                <option <?php if ($orderby =="modified") echo esc_attr("selected") ;?> value='modified'><?php echo __("Modified Date" , 'traveler') ; ?></option>

                <option <?php if ($orderby =="rand") echo esc_attr("selected") ;?> value='rand'><?php echo __("Random" , 'traveler') ; ?></option>

                <option <?php if ($orderby =="comment_count") echo esc_attr("selected") ;?> value='comment_count'><?php echo __("Number of comments" , 'traveler') ; ?></option>

            </select>

			</p>

            <p><label for="<?php echo esc_attr($this->get_field_id('order')) ; ?>"><?php echo __("Order" , 'traveler') ; ?></label>

            <select name='<?php echo esc_attr($this->get_field_name('order')); ?>'>

                <option value=''> -- Select -- </option>

                <option <?php if ($order =="ASC") echo esc_attr("selected") ;?> value='ASC'><?php echo __("ASC" , 'traveler') ; ?></option>

                <option <?php if ($order =="DESC") echo esc_attr("selected") ;?> value='DESC'><?php echo __("DESC" , 'traveler') ; ?></option>

            </select>    

            </p>

            <p>

				<label><?php echo __("Count num",'traveler');?> </label>

				<input type='number' 

				name='<?php echo esc_attr($this->get_field_name('count'))  ; ?>' 

				value='<?php echo esc_attr($count);?>' />

			</p>

            <?php

        }

        public function update( $new_instance, $old_instance ) {

            $instance              = $old_instance;
    
            $instance['title']     = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';		
        
            $instance['orderby']     = ( ! empty( $new_instance['orderby'] ) ) ? strip_tags( $new_instance['orderby'] ) : '';
            
            $instance['order']     = ( ! empty( $new_instance['order'] ) ) ? strip_tags( $new_instance['order'] ) : '';	
            
            $instance['count']     = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';		

            return $instance;
    
        }

    }



    function st_list_post_wd_new() {

        register_widget( 'st_list_post_new' );

    }


    $layout = st()->get_option('blog_list_style_modern');
    if($layout == 3) {
        add_action( 'widgets_init', 'st_list_post_wd_new' );
    }
}


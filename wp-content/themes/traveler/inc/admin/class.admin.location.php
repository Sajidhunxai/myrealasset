<?php
/**
 * @package WordPress
 * @subpackage Traveler
 * @since 1.0
 *
 * Class STAdminLocation
 *
 * Created by ShineTheme
 *
 */
if (!class_exists('STAdminLocation')) {

    class STAdminLocation
    {

        function __construct()
        {
            //add location type custom fields
            $this->add_location_type_meta();

            add_action('icl_make_duplicate', [$this, 'duplicate_location'], 10, 4);

        }

        function duplicate_location($master_post_id, $lang, $post_array, $id)
        {
            $service_id = $id;
            $service_object = (object)$post_array;
            if (in_array($service_object->post_type, ['st_hotel', 'hotel_room', 'st_rental', 'st_cars', 'st_tours', 'st_activity'])) {
                $multiLocation = get_post_meta($master_post_id, 'multi_location', true);
                if (!empty($multiLocation)) {
                    $multiLocation_ = explode(',', $multiLocation);
                    if (!empty($multiLocation_) && is_array($multiLocation_)) {
                        $newLocation = [];
                        $string_location = '';
                        global $wpdb, $sitepress;
                        $table = $wpdb->prefix . 'st_location_relationships';
                        foreach ($multiLocation_ as $location) {
                            $location = str_replace('_', '', $location);
                            $location = TravelHelper::post_translated($location, 'location', $lang);
                            $string_location .= "'" . $location . "',";

                            STLocationRelationships::get_inst()->insert_location_relationships($service_id, $location);
                            $newLocation[] = '_' . $location . '_';
                        }

                        if (!empty($newLocation)) {
                            update_post_meta($service_id, 'multi_location', implode(',', $newLocation));
                        }
                        if (!empty($string_location)) {
                            $string_location = substr($string_location, 0, -1);

                            $sql = "DELETE FROM {$table} WHERE post_id = {$service_id} AND location_from NOT IN ({$string_location}) AND location_type = 'multi_location'";

                            $wpdb->query($sql);
                        }
                        foreach (['st_hotel', 'hotel_room', 'st_rental', 'st_cars', 'st_tours', 'st_activity'] as $service) {
                            $table = $wpdb->prefix . $service;
                            $wpdb->update($table, ['multi_location' => implode(',', $newLocation)], ['post_id' => $service_id]);
                        }
                    }
                }
            }
        }

        function add_location_type_meta()
        {
            /*
                 * prefix of meta keys, optional
                 */
            $prefix = 'st_';
            /*
             * configure your meta box
             */
            $config = array(
                'id' => 'st_extra_infomation',          // meta box id, unique per meta box
                'title' => __('Extra Information', 'traveler'),          // meta box title
                'pages' => array('st_location_type'),        // taxonomy name, accept categories, post_tag and custom taxonomies
                'context' => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
                'fields' => array(),            // list of meta fields (can be added by field arrays)
                'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
                'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
            );

            if (!class_exists('Tax_Meta_Class')) {
                STFramework::write_log('Tax_Meta_Class not found in class.attribute.php line 121');
                return;
            }

            /*
             * Initiate your meta box
             */
            $my_meta = new Tax_Meta_Class($config);

            /*
             * Add fields to your meta box
             */

            //text field
            $my_meta->addSelect($prefix . 'label',
                array(
                    'default' => __('Default', 'traveler'),
                    'primary' => __('Primary', 'traveler'),
                    'success' => __('Success', 'traveler'),
                    'info' => __('Info', 'traveler'),
                    'warning' => __('Warning', 'traveler'),
                    'danger' => __('Danger', 'traveler'),
                )
                ,
                array('name' => __('Label Type', 'traveler')));
            $my_meta->Finish();
        }


    }

    new STAdminLocation();
}
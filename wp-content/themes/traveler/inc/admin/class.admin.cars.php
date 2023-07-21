<?php

/**
 * @package    WordPress
 * @subpackage Traveler
 * @since      1.0
 *
 * Class STAdminCars
 *
 * Created by ShineTheme
 *
 */
$order_id = 0;
if (!class_exists('STAdminCars')) {

    class STAdminCars extends STAdmin {

        static $booking_page;
        static $data_term;
        static $_table_version = "1.3.5";
        protected $post_type = "st_cars";

        /**
         *
         *
         * @update 1.1.3
         * */
        function __construct() {

            add_action('init', [$this, '_init_post_type'], 8);

            if (!st_check_service_available($this->post_type))
                return;

            add_action('init', [$this, 'get_list_value_taxonomy'], 98);

            add_action('current_screen', [$this, 'init_metabox'], 99);

            add_action('admin_enqueue_scripts', [$this, 'init_data_location_from_to'], 99);

            //add_action( 'save_post', array($this,'cars_update_location') );
            //===============================================================
            add_filter('manage_st_cars_posts_columns', [$this, 'add_col_header'], 10);
            add_action('manage_st_cars_posts_custom_column', [$this, 'add_col_content'], 10, 2);

            //===============================================================
            self::$booking_page = admin_url('edit.php?post_type=st_cars&page=st_car_booking');
            add_action('admin_menu', [$this, 'add_menu_page']);

            if (self::is_booking_page()) {
                add_action('admin_enqueue_scripts', [__CLASS__, 'add_edit_scripts']);

                add_action('admin_init', [$this, '_do_save_booking']);
            }

            if (isset($_GET['send_mail']) and $_GET['send_mail'] == 'success') {
                self::set_message(__('Email sent', 'traveler'), 'updated');
            }
            add_action('wp_ajax_st_room_select_ajax', [__CLASS__, 'st_room_select_ajax']);

            add_action('save_post', [$this, 'meta_update_sale_price'], 10, 4);
            //parent::__construct();

            add_action('save_post', [$this, '_update_list_location'], 999999, 2);
            add_action('save_post', [$this, '_update_duplicate_data'], 50, 2);
            add_action('save_post', [$this, '_update_duplicate_data'], 50, 2);
            add_action('save_post', [$this, '_save_journey_car'], 50, 2);

            add_action('wp_ajax_st_getInfoCar', [__CLASS__, 'getInfoCar'], 9999);
            add_action('wp_ajax_st_getInfoCarPartner', [__CLASS__, 'getInfoCarPartner'], 9999);

            add_action('wp_ajax_st_get_location_childs', [__CLASS__, 'st_get_location_childs'], 9999);

            add_action('save_post', [$this, 'st_save_location_from_to'], 9999);

            /**
             *   since 1.2.4
             *   auto create & update table st_cars
             * */
            add_action('after_setup_theme', [__CLASS__, '_check_table_car']);
            add_action('after_setup_theme', [__CLASS__, '_journey_table']);

            add_action('admin_init', [$this, '_upgradeCarTable133']);
        }

        public function _upgradeCarTable133() {
            $updated = get_option('_upgradeCarTable133', false);
            if (!$updated) {
                global $wpdb;
                $table = $wpdb->prefix . $this->post_type;
                $sql = "Update {$table} as t inner join {$wpdb->postmeta} as m on (t.post_id = m.post_id and m.meta_key = 'is_featured') set t.is_featured = m.meta_value";
                $wpdb->query($sql);
                update_option('_upgradeCarTable133', 'updated');
            }
        }

        static function inst() {
            static $instance;
            if (is_null($instance)) {
                $instance = new self();
            }
            return $instance;
        }

        static function _journey_table() {
            $dbhelper = new DatabaseHelper('1.0.1');
            $dbhelper->setTableName('st_journey_car');
            $column = [
                'id' => [
                    'type' => 'INT',
                    'length' => 11,
                    'AUTO_INCREMENT' => true
                ],
                'post_id' => [
                    'type' => 'INT',
                    'length' => 11,
                ],
                'title' => [
                    'type' => 'varchar',
                    'length' => 500
                ],
                'transfer_from' => [
                    'type' => 'INT',
                    'length' => 11
                ],
                'transfer_to' => [
                    'type' => 'INT',
                    'length' => 11
                ],
                'price' => [
                    'type' => 'varchar',
                    'length' => 50
                ],
                'has_return' => [
                    'type' => 'varchar',
                    'length' => 50
                ],
                'price_return' => [
                    'type' => 'varchar',
                    'length' => 50
                ],
                'passenger' => [
                    'type' => 'INT',
                    'length' => 5
                ],
                'price_type' => [
                    'type' => 'varchar',
                    'length' => 50
                ],
                'is_featured'        => [
                    'type'   => 'varchar',
                    'length' => 5
                ]
            ];

            $column = apply_filters('st_change_column_st_journey_car', $column);

            $dbhelper->setDefaultColums($column);
            $dbhelper->check_meta_table_is_working('st_journey_car_table_version');
        }

        static function _save_journey_car($car_id, $car_object) {
            if ($car_object->post_type == 'st_cars') {
                if (STInput::request('sc') == 'edit-cars' and isset($_POST['st_update_post_cars'])) {
                    $transfers = [];
                    $journey_title = STInput::request('journey_title');
                    $journey_transfer_from = STInput::request('journey_transfer_from');
                    $journey_transfer_to = STInput::request('journey_transfer_to');
                    $journey_price = STInput::request('journey_price');
                    $journey_return = STInput::request('journey_return');

                    if (!empty($journey_transfer_from)) {
                        foreach ($journey_transfer_from as $k => $v) {
                            $return_data = array();
                            if (isset($journey_return[$k]))
                                array_push($return_data, 'yes');
                            else
                                array_push($return_data, 'no');

                            $transfers[] = [
                                'title' => $journey_title[$k],
                                'transfer_from' => $journey_transfer_from[$k],
                                'transfer_to' => $journey_transfer_to[$k],
                                'price' => $journey_price[$k],
                                'return' => $return_data,
                            ];
                        }
                    }
                }else {
                    $transfers = STInput::post('journey', '');
                }
                self::delete_transfers($car_id);
                if (!empty($transfers)) {
                    foreach ($transfers as $transfer) {
                        if (!empty($transfer['title']) && !empty($transfer['transfer_from']) && !empty($transfer['transfer_to'])) {
                            $return_dt = '';
                            if (isset($transfer['return'])) {
                                $return_dt = $transfer['return'][0];
                            }
                            $transfer_from_name = STCarTransfer::inst()->get_transfer_name($transfer['transfer_from']);
                            $transfer_to_name = STCarTransfer::inst()->get_transfer_name($transfer['transfer_to']);
                            self::insert_transfer($car_id, $transfer_from_name . ' - ' . $transfer_to_name, $transfer['transfer_from'], $transfer['transfer_to'], $return_dt, $transfer['price'], STInput::post('price_type'), STInput::post('num_passenger', 1));
                        }
                    }
                }
                self::save_min_max_price_transfer($car_id);
            }
        }

        static function get_min_max_price_transfer($car_id = '') {
            $return = [
                'min_price' => 0,
                'max_price' => 0
            ];

            global $wpdb;
            if (!empty($car_id)) {
                $sql = "SELECT
                        min(
                            CAST(
                                journey.price AS DECIMAL (15, 6)
                            )
                        ) AS min_price,
                        max(
                            CAST(
                                journey.price AS DECIMAL (15, 6)
                            )
                        ) AS max_price
                    FROM
                        {$wpdb->prefix}st_journey_car AS journey
                    WHERE
                        journey.post_id = {$car_id}
                    GROUP BY
                        journey.post_id";

                $transfer_from = (int) STInput::request('transfer_from', '');
                $transfer_to = (int) STInput::request('transfer_to', '');
                if ($transfer_from && $transfer_to) {
                    $sql = "SELECT
                            min(
                                CAST(
                                    journey.price AS DECIMAL (15, 6)
                                )
                            ) AS min_price,
                            max(
                                CAST(
                                    journey.price AS DECIMAL (15, 6)
                                )
                            ) AS max_price
                        FROM
                            {$wpdb->prefix}st_journey_car AS journey
                        WHERE 1=1 AND journey.post_id = {$car_id} AND ((transfer_from = {$transfer_from} AND transfer_to = {$transfer_to}) OR (transfer_from = {$transfer_to} AND (transfer_to = {$transfer_from})))";
                }
            } else {
                $sql = "SELECT
                        min(
                            CAST(
                                journey.price AS DECIMAL (15, 6)
                            )
                        ) AS min_price,
                        max(
                            CAST(
                                journey.price AS DECIMAL (15, 6)
                            )
                        ) AS max_price
                    FROM
                        {$wpdb->prefix}st_journey_car AS journey
                    WHERE 1=1";
            }
            $result = $wpdb->get_row($sql);

            if ($result) {
                $return = [
                    'min_price' => (float) $result->min_price,
                    'max_price' => (float) $result->max_price
                ];
            }
            return $return;
        }

        static function save_min_max_price_transfer($car_id) {
            global $wpdb;

            $table = $wpdb->prefix . 'st_cars';

            $minmax = self::get_min_max_price_transfer($car_id);

            $data = [
                'min_price' => $minmax['min_price'],
                'max_price' => $minmax['max_price']
            ];

            $wpdb->update($table, $data, ['post_id' => $car_id]);

            return $car_id;
        }

        static function insert_transfer($car_id='', $title = '', $from='', $to='', $return = '', $price = 0, $type = '', $passenger = 1) {
            global $wpdb;
            $table = $wpdb->prefix . 'st_journey_car';
            $data = [
                'post_id' => $car_id,
                'title' => $title,
                'transfer_from' => $from,
                'transfer_to' => $to,
                'has_return' => $return,
                'price' => $price,
                'price_type' => $type,
                'passenger' => $passenger
            ];

            $wpdb->insert($table, $data);
        }

        static function delete_transfers($car_id, $from = '', $to = '') {
            global $wpdb;
            $table = $wpdb->prefix . 'st_journey_car';
            $where = [
                'post_id' => $car_id
            ];
            if (!empty($from)) {
                $where['transfer_from'] = $from;
            }
            if (!empty($to)) {
                $where['transfer_to'] = $to;
            }

            $wpdb->delete($table, $where);
        }

        static function list_transfers_by_id($car_id) {
            global $wpdb;
            $table = $wpdb->prefix . 'st_journey_car';
            $sql = "SELECT * FROM {$table} WHERE post_id={$car_id}";
            return $wpdb->get_results($sql);
        }

        static function check_ver_working() {
            $dbhelper = new DatabaseHelper(self::$_table_version);

            return $dbhelper->check_ver_working('st_cars_table_version');
        }

        static function _check_table_car() {
            $dbhelper = new DatabaseHelper(self::$_table_version);
            $dbhelper->setTableName('st_cars');
            $column = [
                'post_id' => [
                    'type' => 'INT',
                    'length' => 11,
                ],
                'multi_location' => [
                    'type' => 'text',
                ],
                'id_location' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'cars_address' => [
                    'type' => 'text',
                ],
                'cars_price' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'sale_price' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'number_car' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'cars_booking_period' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'is_sale_schedule' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'discount' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'sale_price_from' => [
                    'type' => 'date',
                    'length' => 255
                ],
                'sale_price_to' => [
                    'type' => 'date',
                    'length' => 255
                ],
                'min_price' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'max_price' => [
                    'type' => 'varchar',
                    'length' => 255
                ],
                'is_featured' => [
                    'type' => 'varchar',
                    'length' => 5
                ]
            ];

            $column = apply_filters('st_change_column_st_cars', $column);

            $dbhelper->setDefaultColums($column);
            $dbhelper->check_meta_table_is_working('st_cars_table_version');

            return array_keys($column);
        }

        public function init_data_location_from_to() {

            $post_id = (int) STInput::request('post', '');
            $lists = [];

            $results = $this->get_data_location_from_to($post_id);
            if (!empty($results)) {
                foreach ($results as $item) {
                    $lists[] = [
                        'pickup' => (int) $item['location_from'],
                        'pickup_text' => get_the_title((int) $item['location_from']),
                        'dropoff' => (int) $item['location_to'],
                        'dropoff_text' => get_the_title((int) $item['location_to'])
                    ];
                }
            }
            wp_localize_script('jquery', 'st_location_from_to', [
                'lists' => $lists
            ]);
        }

        public function get_data_location_from_to($post_id) {
            return st_get_data_location_from_to($post_id);
        }

        public function st_save_location_from_to($post_id) {
            if (get_post_type($post_id) == 'st_cars') {
                $lists = STInput::request('locations_from_to', '');
                $locations = [];

                global $wpdb;
                $table = $wpdb->prefix . 'st_location_relationships';

                if (!empty($lists)) {
                    if (!empty($lists['pickup']) && is_array($lists['pickup'])) {
                        foreach ($lists['pickup'] as $key => $list) {
                            $locations[] = [
                                'pickup' => (int) $list,
                                'dropoff' => ( isset($lists['dropoff'][$key]) ) ? (int) $lists['dropoff'][$key] : 0,
                            ];
                        }
                    }
                    $string_location = "";
                    if (!empty($locations) && is_array($locations)) {
                        foreach ($locations as $location) {
                            $pickup = (int) $location['pickup'];
                            $dropoff = (int) $location['dropoff'];
                            $string_location .= "(location_from = " . $pickup . " AND location_to = " . $dropoff . ") OR ";
                            $this->insert_location_car($post_id, $pickup, $dropoff);
                        }
                    }


                    if (!empty($string_location)) {

                        $string_location = substr($string_location, 0, -3);

                        $sql = "DELETE
                            FROM
                                {$table}
                            WHERE
                                post_id = {$post_id}
                            AND location_type = 'location_from_to'
                            AND id NOT IN (
                                SELECT
                                    id
                                FROM
                                    (
                                        SELECT
                                            id
                                        FROM
                                            {$table}
                                    ) AS mytable
                                WHERE
                                    {$string_location}
                            )";
                        $wpdb->query($sql);
                    }
                } else {
                    $sql = "DELETE
                        FROM
                            {$table}
                        WHERE
                            post_id = {$post_id}
                        AND location_type = 'location_from_to'";

                    $wpdb->query($sql);
                }
            }
        }

        public function insert_location_car($post_id = '', $pickup = '', $dropoff = '') {
            global $wpdb;
            $table = $wpdb->prefix . 'st_location_relationships';

            $sql = "SELECT ID FROM {$table} WHERE post_id = {$post_id} AND location_from = {$pickup} AND location_to = {$dropoff} AND location_type = 'location_from_to'";

            $row = $wpdb->get_var($sql);

            if (empty($row)) {
                $data = [
                    'post_id' => $post_id,
                    'location_from' => $pickup,
                    'location_to' => $dropoff,
                    'post_type' => 'st_cars',
                    'location_type' => 'location_from_to'
                ];

                $wpdb->insert($table, $data);
            }
        }

        static function st_get_location_childs() {
            $location = (int) STInput::request('location_id', '');

            $country = get_post_meta($location, 'location_country', true);

            global $wpdb;
            $table = $wpdb->prefix . 'st_location_nested';
            $result = [
                'total_count' => 0,
                'items' => [],
            ];

            $ns = new Nested_set();
            $ns->setControlParams($table);

            $nodes = $ns->getNodesWhere("location_country = '" . $country . "'");

            if (!empty($nodes)) {
                $result['total_count'] = count($nodes);
                foreach ($nodes as $node) {
                    $result['items'][] = [
                        'id' => (int) $node['location_id'],
                        'name' => get_the_title((int) $node['location_id']),
                        'description' => "ID: " . (int) $node['location_id']
                    ];
                }
            } else {
                $result['total_count'] = 1;
                $result['items'][] = [
                    'id' => $location,
                    'name' => get_the_title($location),
                    'description' => "ID: " . $location
                ];
            }

            echo json_encode($result);
            die();
        }

        static function get_price_unit($need = 'value') {
            $unit = st()->get_option('cars_price_unit', 'day');
            $return = false;

            if ($need == 'label') {
                $all = STCars::get_option_price_unit();

                if (!empty($all)) {
                    foreach ($all as $key => $value) {
                        if ($value['value'] == $unit) {
                            if ($unit == "distance") {
                                $return = st()->get_option('cars_price_by_distance', 'kilometer');
                            } else {
                                $return = $value['label'];
                            }
                        }
                    }
                } else
                    $return = $unit;
            } elseif ($need == 'plural') {
                switch ($unit) {
                    case "hour":
                        $return = __("hours", 'traveler');
                        break;
                    case "day":
                        $return = __("days", 'traveler');
                        break;
                        break;
                    case "distance":
                        if (st()->get_option('cars_price_by_distance', 'kilometer') == "kilometer") {
                            $return = __("kilometers", 'traveler');
                        } else {
                            $return = __("miles", 'traveler');
                        }
                        break;
                }
            } else {
                if ($unit == "distance") {
                    $return = st()->get_option('cars_price_by_distance', 'kilometer');
                } else {
                    $return = $unit;
                }
            }

            return apply_filters('st_get_price_unit', $return, $need);
        }

        static function getInfoCar() {
            $car_id = intval(STInput::request('car_id', ''));
            $data = [
                'price' => 'not infomation',
                'item_equipment' => 'not infomation'
            ];
            if ($car_id <= 0 || get_post_type($car_id) != 'st_cars') {
                echo json_encode($data);
                die();
            } else {
                $price = floatval(get_post_meta($car_id, 'cars_price', true));
                $data['price'] = TravelHelper::format_money($price) . ' / ' . self::get_price_unit();
                $item_equipment = get_post_meta($car_id, 'cars_equipment_list', true);

                if (is_array($item_equipment) && count($item_equipment)) {
                    $html = '';
                    $i = 0;
                    foreach ($item_equipment as $key => $val) {
                        $cars_equipment_list_price = TravelHelper::convert_money($val['cars_equipment_list_price']);
                        $cars_equipment_list_price_html = TravelHelper::format_money($cars_equipment_list_price, false);
                        $html .= '<div class="form-group" style="margin-bottom: 10px">
                        <label for="item_equipment-' . $i . '"><input id="item_equipment-' . $i . '" type="checkbox" name="item_equipment[]" value="' . $val['title'] . '--' . $cars_equipment_list_price . '">' . $val['title'] . '(' . $cars_equipment_list_price_html . ')</label>
                        </div>';
                        $i++;
                    }
                    $data['item_equipment'] = $html;
                }
                echo json_encode($data);
                die();
            }
        }

        static function getInfoCarPartner() {
            $car_id = intval(STInput::request('car_id', ''));
            $data = [
                'price' => 'not infomation',
                'item_equipment' => 'not infomation'
            ];
            if ($car_id <= 0 || get_post_type($car_id) != 'st_cars') {
                echo json_encode($data);
                die();
            } else {
                $price = floatval(get_post_meta($car_id, 'cars_price', true));
                $data['price'] = TravelHelper::format_money($price) . ' / ' . self::get_price_unit();
                $item_equipment = get_post_meta($car_id, 'cars_equipment_list', true);

                if (is_array($item_equipment) && count($item_equipment)) {
                    $html = '<table class="table">';
                    $i = 0;
                    foreach ($item_equipment as $key => $val) {
                        $price_unit = isset($v['price_unit']) ? $v['price_unit'] : '';
                        $price_max = isset($v['cars_equipment_list_price_max']) ? $v['cars_equipment_list_price_max'] : '';
                        $cars_equipment_list_price = TravelHelper::convert_money($val['cars_equipment_list_price']);
                        $html .= '
                            <tr>
                                <td>
                                    <label for="item_equipment-' . $i . '" class="ml20"><input data-price="' . $cars_equipment_list_price . '" data-title="' . $val['title'] . '" data-price-max="' . $price_max . '" data-price-unit="' . $price_unit . '" class="i-check list_equipment" id="item_equipment-' . $i . '" type="checkbox" value="' . $val['title'] . '--' . $cars_equipment_list_price . '">' . $val['title'] . ' (' . TravelHelper::format_money($val['cars_equipment_list_price']) . ')</label>
                                </td>
                            </tr>
                        ';
                        $i++;
                    }
                    $html .= "</table>";
                    $data['item_equipment'] = $html;
                }
                echo json_encode($data);
                die();
            }
        }

        function _do_save_booking() {
            $section = isset($_GET['section']) ? $_GET['section'] : FALSE;
            switch ($section) {
                case "edit_order_item":
                    $item_id = isset($_GET['order_item_id']) ? $_GET['order_item_id'] : FALSE;
                    if (!$item_id or get_post_type($item_id) != 'st_order') {
                        return FALSE;
                    }
                    if (isset($_POST['submit']) and $_POST['submit'])
                        $this->_save_booking($item_id);

                    break;
                case 'resend_email_cars':
                    $this->_resend_mail();
                    break;
            }
        }

        function _update_duplicate_data($id, $data) {
            if (!TravelHelper::checkTableDuplicate('st_cars'))
                return;
            if (get_post_type($id) == 'st_cars') {
                $num_rows = TravelHelper::checkIssetPost($id, 'st_cars');

                $location_str = get_post_meta($id, 'multi_location', true);

                $location_id = ''; // location_id

                $cars_address = get_post_meta($id, 'cars_address', true); // address
                $cars_price = get_post_meta($id, 'cars_price', true); // price
                $number_car = get_post_meta($id, 'number_car', true); // number_car
                $cars_booking_period = get_post_meta($id, 'cars_booking_period', true); // cars_booking_period

                $sale_price = get_post_meta($id, 'cars_price', true); // sale_price

                $discount = get_post_meta($id, 'discount', true);
                $is_sale_schedule = get_post_meta($id, 'is_sale_schedule', true);
                $sale_from = get_post_meta($id, 'sale_price_from', true);
                $sale_to = get_post_meta($id, 'sale_price_to', true);
                if ($is_sale_schedule == 'on') {
                    if ($sale_from and $sale_from) {

                        $today = date('Y-m-d');
                        $sale_from = date('Y-m-d', strtotime($sale_from));
                        $sale_to = date('Y-m-d', strtotime($sale_to));
                        if (( $today >= $sale_from ) && ( $today <= $sale_to )) {
                            
                        } else {

                            $discount = 0;
                        }
                    } else {
                        $discount = 0;
                    }
                }
                if ($discount) {
                    $sale_price = $sale_price - ( $sale_price / 100 ) * $discount;
                }

                if ($num_rows == 1) {
                    $data = [
                        'multi_location' => $location_str,
                        'id_location' => $location_id,
                        'cars_address' => $cars_address,
                        'cars_price' => $cars_price,
                        'sale_price' => $sale_price,
                        'number_car' => $number_car,
                        'discount' => $discount,
                        'cars_booking_period' => $cars_booking_period,
                        'sale_price_from' => $sale_from,
                        'sale_price_to' => $sale_to,
                        'is_sale_schedule' => $is_sale_schedule,
                    ];
                    $where = [
                        'post_id' => $id
                    ];
                    TravelHelper::updateDuplicate('st_cars', $data, $where);
                } elseif ($num_rows == 0) {
                    $data = [
                        'post_id' => $id,
                        'multi_location' => $location_str,
                        'id_location' => $location_id,
                        'cars_address' => $cars_address,
                        'cars_price' => $cars_price,
                        'sale_price' => $sale_price,
                        'discount' => $discount,
                        'sale_price_from' => $sale_from,
                        'sale_price_to' => $sale_to,
                        'is_sale_schedule' => $is_sale_schedule,
                        'number_car' => $number_car,
                        'cars_booking_period' => $cars_booking_period
                    ];
                    TravelHelper::insertDuplicate('st_cars', $data);
                }

                // Update Availability
                $model = ST_Availability_Model::inst();
                $model->where('post_id', $id)->update(array(
                    'number' => $number_car,
                ));
            }
        }

        public function _delete_data($post_id) {
            if (get_post_type($post_id) == 'st_cars') {
                global $wpdb;
                $table = $wpdb->prefix . 'st_cars';
                $rs = TravelHelper::deleteDuplicateData($post_id, $table);
                if (!$rs)
                    return false;

                return true;
            }
        }

        /**
         * @since 1.1.7
         * */
        function _update_list_location($id, $data) {
            $location = STInput::request('multi_location', '');
            if (isset($_REQUEST['multi_location'])) {
                if (is_array($location) && count($location)) {
                    $location_str = '';
                    foreach ($location as $item) {
                        if (empty($location_str)) {
                            $location_str .= $item;
                        } else {
                            $location_str .= ',' . $item;
                        }
                    }
                } else {
                    $location_str = '';
                }
                update_post_meta($id, 'multi_location', $location_str);
                update_post_meta($id, 'id_location', '');
            }
        }

        /**
         *
         *
         * @since 1.1.3
         * */
        function _init_post_type() {
            if (!st_check_service_available($this->post_type)) {
                return;
            }

            if (!function_exists('st_reg_post_type'))
                return;
            // Cars ==============================================================
            $labels = [
                'name' => __('Cars', 'traveler'),
                'singular_name' => __('Car', 'traveler'),
                'menu_name' => __('Cars', 'traveler'),
                'name_admin_bar' => __('Car', 'traveler'),
                'add_new' => __('Add New', 'traveler'),
                'add_new_item' => __('Add New Car', 'traveler'),
                'new_item' => __('New Car', 'traveler'),
                'edit_item' => __('Edit Car', 'traveler'),
                'view_item' => __('View Car', 'traveler'),
                'all_items' => __('All Cars', 'traveler'),
                'search_items' => __('Search Cars', 'traveler'),
                'parent_item_colon' => __('Parent Cars:', 'traveler'),
                'not_found' => __('No Cars found.', 'traveler'),
                'not_found_in_trash' => __('No Cars found in Trash.', 'traveler'),
                'insert_into_item' => __('Insert into Car', 'traveler'),
                'uploaded_to_this_item' => __("Uploaded to this Car", 'traveler'),
                'featured_image' => __("Feature Image", 'traveler'),
                'set_featured_image' => __("Set featured image", 'traveler')
            ];

            $args = [
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'query_var' => true,
                'rewrite' => ['slug' => get_option('car_permalink', 'st_car')],
                'capability_type' => 'post',
                'has_archive' => false,
                'hierarchical' => false,
                'supports' => ['author', 'title', 'editor', 'excerpt', 'thumbnail', 'comments'],
                'menu_icon' => 'dashicons-dashboard-st'
            ];
            st_reg_post_type('st_cars', $args);

            // category cars
            $labels = [
                'name' => __('Car Category', 'traveler'),
                'singular_name' => __('Car Category', 'traveler'),
                'search_items' => __('Search Car Category', 'traveler'),
                'popular_items' => __('Popular Car Category', 'traveler'),
                'all_items' => __('All Car Category', 'traveler'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => __('Edit Car Category', 'traveler'),
                'update_item' => __('Update Car Category', 'traveler'),
                'add_new_item' => __('Add New Car Category', 'traveler'),
                'new_item_name' => __('New Pickup Car Category', 'traveler'),
                'separate_items_with_commas' => __('Separate Car Category  with commas', 'traveler'),
                'add_or_remove_items' => __('Add or remove Car Category', 'traveler'),
                'choose_from_most_used' => __('Choose from the most used Car Category', 'traveler'),
                'not_found' => __('No Car Category found.', 'traveler'),
                'menu_name' => __('Car Category', 'traveler'),
            ];

            $args = [
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'public' => apply_filters('stt_show_term_frontend',false),
                'rewrite' => ['slug' => 'st_category_cars'],
            ];

            st_reg_taxonomy('st_category_cars', 'st_cars', $args);

            $labels = [
                'name' => __("Pickup Features", 'traveler'),
                'singular_name' => __("Pickup Features", 'traveler'),
                'search_items' => __("Search Pickup Features", 'traveler'),
                'popular_items' => __('Popular Pickup Features', 'traveler'),
                'all_items' => __('All Pickup Features', 'traveler'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => __('Edit Pickup Feature', 'traveler'),
                'update_item' => __('Update Pickup Feature', 'traveler'),
                'add_new_item' => __('Add New Pickup Feature', 'traveler'),
                'new_item_name' => __('New Pickup Feature Name', 'traveler'),
                'separate_items_with_commas' => __('Separate Pickup Features with commas', 'traveler'),
                'add_or_remove_items' => __('Add or remove Pickup Features', 'traveler'),
                'choose_from_most_used' => __('Choose from the most used Pickup Features', 'traveler'),
                'not_found' => __('No Pickup Features found.', 'traveler'),
                'menu_name' => __('Pickup Features', 'traveler'),
            ];

            $args = [
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_admin_column' => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var' => true,
                'public' => apply_filters('stt_show_term_frontend',false),
                'rewrite' => ['slug' => 'st_cars_pickup_features'],
            ];

            st_reg_taxonomy('st_cars_pickup_features', 'st_cars', $args);
        }

        /**
         *
         *
         *
         * @since 1.1.1
         * */
        static function get_list_value_taxonomy() {
            $data_value = [];
            $taxonomy = get_object_taxonomies('st_cars', 'object');

            foreach ($taxonomy as $key => $value) {
                if ($key != 'st_category_cars') {
                    if ($key != 'st_cars_pickup_features') {
                        if (is_admin() and ! empty($_REQUEST['post'])) {
                            $data_term = get_the_terms($_REQUEST['post'], $key);

                            if (!empty($data_term)) {
                                foreach ($data_term as $k => $v) {
                                    array_push(
                                            $data_value, [
                                        'value' => $v->term_id,
                                        'label' => $v->name,
                                        'taxonomy' => $v->taxonomy
                                            ]
                                    );
                                }
                            }
                        }
                    }
                }
            }
            self::$data_term = $data_value;
        }

        /**
         *
         *
         * @since 1.1.1
         * */
        function init_metabox() {
            $screen = get_current_screen();
            if ($screen->id != 'st_cars') {
                return false;
            }
            $this->metabox[] = [
                'id' => 'cars_metabox',
                'title' => __('Cars Setting', 'traveler'),
                'desc' => '',
                'pages' => ['st_cars'],
                'context' => 'normal',
                'priority' => 'high',
                'fields' => [
                    [
                        'label' => __('Location', 'traveler'),
                        'id' => 'location_tab',
                        'type' => 'tab'
                    ],
                    [
                        'label' => __('Cars location', 'traveler'),
                        'id' => 'multi_location', // id_location
                        'type' => 'list_item_post_type',
                        'desc' => __('Select one or more location for your cars', 'traveler'),
                        'post_type' => 'location',
                    ],
                    [
                        'label' => __('Address', 'traveler'),
                        'id' => 'cars_address',
                        'type' => 'address_autocomplete',
                        'desc' => __('Address', 'traveler'),
                    ],
                    [
                        'label' => __('Location on map', 'traveler'),
                        'id' => 'st_google_map',
                        'type' => 'bt_gmap',
                        'std' => 'off',
                        'desc'  => __( 'Kindly input Map API in Theme Settings > Other Options . Select one location on map to see latiture and longiture', 'traveler' )
                    ],
                    [
                        'label' => __('Properties near by', 'traveler'),
                        'id' => 'properties_near_by',
                        'type' => 'list-item',
                        'desc' => __('Properties near by this car', 'traveler'),
                        'settings' => [
                            [
                                'id' => 'featured_image',
                                'label' => __('Featured Image', 'traveler'),
                                'type' => 'upload',
                            ],
                            [
                                'id' => 'description',
                                'label' => __('Description', 'traveler'),
                                'type' => 'textarea',
                                'row' => 5
                            ],
                            [
                                'id' => 'icon',
                                'label' => __('Map icon', 'traveler'),
                                'type' => 'upload'
                            ],
                            [
                                'id' => 'map_lat',
                                'label' => __('Map lat', 'traveler'),
                                'type' => 'text'
                            ],
                            [
                                'id' => 'map_lng',
                                'label' => __('Map long', 'traveler'),
                                'type' => 'text'
                            ]
                        ]
                    ],
                    [
                        'label' => __('Street view mode', 'traveler'),
                        'id' => 'enable_street_views_google_map',
                        'type' => 'on-off',
                        'desc' => __('Turn on/off streetview mode for this location', 'traveler'),
                        'std' => 'on'
                    ],
                    [
                        'label' => __('Car details', 'traveler'),
                        'id' => 'room_car_tab',
                        'type' => 'tab'
                    ],
                    [
                        'label' => __('Set car as feature', 'traveler'),
                        'id' => 'is_featured',
                        'type' => 'on-off',
                        'desc' => __('Will show this car with feature label or not', 'traveler'),
                        'std' => 'off'
                    ],
                    /**
                     * version 2.7.4
                     */
                    [
                        'label' => __('Booking Options', 'traveler'),
                        'id' => 'st_booking_option_type',
                        'type' => 'select',
                        'choices' => [
                            [
                                'label' => __('Instant Booking', 'traveler'),
                                'value' => 'instant'
                            ],
                            [
                                'label' => __('Enquire Booking', 'traveler'),
                                'value' => 'enquire'
                            ],
                            [
                                'label' => __('Instant & Enquire Booking', 'traveler'),
                                'value' => 'instant_enquire'
                            ],
                        ],
                        'std' => 'instant',
                    ],
                    [
                        'label' => __('Car single layout', 'traveler'),
                        'id' => 'st_custom_layout',
                        'post_type' => 'st_layouts',
                        'desc' => __('Select one car single layout', 'traveler'),
                        'type' => 'select',
                        'choices' => st_get_layout('st_cars')
                    ],
                    [
                        'label' => __('Car gallery', 'traveler'),
                        'id' => 'gallery',
                        'type' => 'gallery',
                        'desc' => __('Upload car images to show to customers', 'traveler')
                    ],
                    [
                        'label' => __('Equipment price list', 'traveler'),
                        'desc' => __('Equipment price list', 'traveler'),
                        'id' => 'cars_equipment_list',
                        'type' => 'list-item',
                        'settings' => [
                            [
                                'id' => 'cars_equipment_list_price',
                                'label' => __('Price', 'traveler'),
                                'type' => 'text',
                            ],
                            [
                                'id' => 'cars_equipment_list_number',
                                'label' => __('Number of item', 'traveler'),
                                'type' => 'text',
                                'std' => 1
                            ],
                            [
                                'id' => 'price_unit',
                                'label' => __('Price unit', 'traveler'),
                                'desc' => __('You can choose <code>Fixed Price</code>, <code>Price per Hour</code>, <code>Price per Day</code>', 'traveler'),
                                'type' => 'select',
                                'choices' => [
                                    [
                                        'value' => '',
                                        'label' => __('Fixed price', 'traveler')
                                    ],
                                    [
                                        'value' => 'per_hour',
                                        'label' => __('Price per hour', 'traveler')
                                    ],
                                    [
                                        'value' => 'per_day',
                                        'label' => __('Price per day', 'traveler')
                                    ],
                                ]
                            ],
                            [
                                'id' => 'cars_equipment_list_price_max',
                                'label' => __('Price max', 'traveler'),
                                'type' => 'text',
                                'condition' => 'price_unit:not()'
                            ],
                        ]
                    ],
                    [
                        'label' => __('Features', 'traveler'),
                        'desc' => __('Features', 'traveler'),
                        'id' => 'cars_equipment_info',
                        'type' => 'list-item',
                        'settings' => [
                            [
                                'id' => 'cars_equipment_taxonomy_id',
                                'label' => __('Taxonomy', 'traveler'),
                                'type' => 'select',
                                'operator' => 'and',
                                'choices' => self::$data_term
                            ],
                            [
                                'id' => 'cars_equipment_taxonomy_info',
                                'label' => __('Taxonomy Info', 'traveler'),
                                'type' => 'text',
                            ]
                        ]
                    ],
                    [
                        'label' => __('Car video', 'traveler'),
                        'id' => 'video',
                        'type' => 'text',
                        'desc' => __('Input youtube/vimeo url here', 'traveler')
                    ],
                    [
                        'label' => __('Car logo', 'traveler'),
                        'id' => 'cars_logo',
                        'type' => 'upload',
                        'desc' => __('Car logo', 'traveler'),
                    ],
                    [
                        'label' => __('Car manufacturer name', 'traveler'),
                        'id' => 'cars_name',
                        'type' => 'text',
                        'desc' => __('Car manufacturer name', 'traveler'),
                    ],
                    [
                        'label' => __('About', 'traveler'),
                        'desc' => __('About', 'traveler'),
                        'id' => 'cars_about',
                        'type' => 'textarea',
                    ],
                    [
                        'label' => __('Contact information', 'traveler'),
                        'id' => 'agent_tab',
                        'type' => 'tab'
                    ],
                    [
                        'label' => __('Select contact info will show', 'traveler'),
                        'id' => 'show_agent_contact_info',
                        'type' => 'select',
                        'choices' => [
                            [
                                'label' => __("----Select----", 'traveler'),
                                'value' => ''
                            ],
                            [
                                'label' => __("Use agent contact info", 'traveler'),
                                'value' => 'user_agent_info'
                            ],
                            [
                                'label' => __("Use item info", 'traveler'),
                                'value' => 'user_item_info'
                            ],
                        ],
                        'desc' => __('Use info configuration in theme option || Use contact info of people who upload hotel || Use contact info in hotel detail', 'traveler'),
                    ],
                    [
                        'label' => __('Email', 'traveler'),
                        'id' => 'cars_email',
                        'type' => 'text',
                        'desc' => __('E-mail car agent, this address will received email when have new booking', 'traveler'),
                    ],
                    [
                        'label' => __('Website', 'traveler'),
                        'id' => 'cars_website',
                        'type' => 'text',
                        'desc' => __('Website car agent', 'traveler'),
                    ],
                    [
                        'label' => __('Phone', 'traveler'),
                        'id' => 'cars_phone',
                        'type' => 'text',
                        'desc' => __('Phone', 'traveler'),
                    ],
                    [
                        'label' => __('Fax number', 'traveler'),
                        'id' => 'cars_fax',
                        'type' => 'text',
                        'desc' => __('Fax number', 'traveler'),
                    ],
                    [
                        'label' => __('Price setting', 'traveler'),
                        'id' => '_price_car_tab',
                        'type' => 'tab'
                    ],
                    [
                        'label' => __('Car Type', 'traveler'),
                        'id' => 'car_type',
                        'type' => 'select',
                        'choices' => [
                            [
                                'label' => __('Normal', 'traveler'),
                                'value' => 'normal'
                            ],
                            [
                                'label' => __('Car Transfer', 'traveler'),
                                'value' => 'car_transfer'
                            ]
                        ]
                    ],
                    [
                        'label' => __('Price Type', 'traveler'),
                        'type' => 'select',
                        'id' => 'price_type',
                        'choices' => [
                            [
                                'label' => __('By Distance', 'traveler'),
                                'value' => 'distance'
                            ],
                            [
                                'label' => __('By Fixed', 'traveler'),
                                'value' => 'fixed'
                            ],
                            [
                                'label' => __('By Passenger', 'traveler'),
                                'value' => 'passenger'
                            ]
                        ],
                        'condition' => 'car_type:is(car_transfer)'
                    ],
                    [
                        'id' => 'num_passenger',
                        'label' => __('No. Passengers (For cartransfer)', 'traveler'),
                        'type' => 'text',
                        'std' => '0',
                        'condition' => 'car_type:is(car_transfer)',
                        'desc' => __('No. Passengers', 'traveler'),
                    ],
                    [
                        'label' => sprintf(__('Pricing (%s)', 'traveler'), TravelHelper::get_default_currency('symbol')),
                        'id' => 'cars_price',
                        'type' => 'text',
                        'desc' => __('Price', 'traveler'),
                        'condition' => 'car_type:is(normal)'
                    ],
                    [
                        'label' => __('Journey', 'traveler'),
                        'type' => 'list-item',
                        'id' => 'journey',
                        'desc' => __('Add the journey of the car transfer', 'traveler'),
                        'settings' => [
                            [
                                'label' => __('Transfer from', 'traveler'),
                                'id' => 'transfer_from',
                                'type' => 'select',
                                'choices' => TravelHelper::transferDestinationOption()
                            ],
                            [
                                'label' => __('Transfer to', 'traveler'),
                                'id' => 'transfer_to',
                                'type' => 'select',
                                'choices' => TravelHelper::transferDestinationOption()
                            ],
                            [
                                'label' => __('Price', 'traveler'),
                                'id' => 'price',
                                'type' => 'text'
                            ],
                            [
                                'label' => __('Return', 'traveler'),
                                'id' => 'return',
                                'type' => 'checkbox',
                                'choices' => [
                                    [
                                        'label' => __('Yes', 'traveler'),
                                        'value' => 'yes'
                                    ]
                                ]
                            ]
                        ],
                        'condition' => 'car_type:is(car_transfer)'
                    ],
                    [
                        'label' => __('Extra pricing', 'traveler'),
                        'id' => 'extra_price',
                        'type' => 'list-item',
                        'settings' => [
                            [
                                'id' => 'extra_name',
                                'type' => 'text',
                                'std' => 'extra_',
                                'label' => __('Name of Item', 'traveler'),
                            ],
                            [
                                'id' => 'extra_max_number',
                                'type' => 'text',
                                'std' => '',
                                'label' => __('Max of Number', 'traveler'),
                            ],
                            [
                                'id' => 'extra_price',
                                'type' => 'text',
                                'std' => '',
                                'label' => __('Price', 'traveler'),
                                'desc' => __('per 1 Item', 'traveler'),
                            ],
                        ],
                        'desc' => __('You can define any extra service and price for with name, quantity, and price', 'traveler'),
                        'condition' => 'car_type:is(car_transfer)'
                    ],
                    [
                        'label' => __('Custom price', 'traveler'),
                        'id' => 'is_custom_price',
                        'std' => 'off',
                        'type' => 'select',
                        'choices' => [
                            [
                                'value' => 'price_by_number',
                                'label' => __('Price by number of day|hour', 'traveler')
                            ],
                            [
                                'value' => 'price_by_date',
                                'label' => __('Price by date', 'traveler')
                            ]
                        ],
                        'condition' => 'car_type:is(normal)'
                    ],
                    [
                        'label' => __("Price by date", 'traveler'),
                        'id' => 'st_custom_price_by_date',
                        'type' => 'st_custom_price',
                        'desc' => __('Price by date', 'traveler'),
                        'condition' => 'is_custom_price:is(price_by_date)'
                    ],
                    [
                        'label' => __("Price by number of day/hour", 'traveler'),
                        'id' => 'price_by_number_of_day_hour',
                        'desc' => __('Price by number of day/hour', 'traveler'),
                        'type' => 'list-item',
                        'settings' => [
                            [
                                'id' => 'number_start',
                                'label' => __('From ( day/hour)', 'traveler'),
                                'type' => 'text',
                                'operator' => 'and',
                            ],
                            [
                                'id' => 'number_end',
                                'label' => __('To ( day/hour)', 'traveler'),
                                'type' => 'text',
                            ],
                            [
                                'id' => 'price',
                                'label' => sprintf(__('Price (%s)', 'traveler'), TravelHelper::get_default_currency('symbol')),
                                'type' => 'text',
                            ]
                        ],
                        'condition' => 'car_type:is(normal),is_custom_price:is(price_by_number)',
                        'operator' => 'and',
                    ],
                    [
                        'label' => __('Discount', 'traveler'),
                        'id' => 'discount',
                        'type' => 'text',
                        'desc' => __('%', 'traveler'),
                        'std' => 0
                    ],
                    [
                        'label' => __('Sale schedule', 'traveler'),
                        'id' => 'is_sale_schedule',
                        'type' => 'on-off',
                        'std' => 'off',
                    ],
                    [
                        'label' => __('Sale price date from', 'traveler'),
                        'desc' => __('Sale price date from', 'traveler'),
                        'id' => 'sale_price_from',
                        'type' => 'date-picker',
                        'condition' => 'is_sale_schedule:is(on)'
                    ],
                    [
                        'label' => __('Sale price date to', 'traveler'),
                        'desc' => __('Sale price date to', 'traveler'),
                        'id' => 'sale_price_to',
                        'type' => 'date-picker',
                        'condition' => 'is_sale_schedule:is(on)'
                    ],
                    [
                        'label' => __('Number of car for rent', 'traveler'),
                        'desc' => __('Number of car for rent', 'traveler'),
                        'id' => 'number_car',
                        'type' => 'text',
                        'std' => 1
                    ],
                    [
                        'id' => 'deposit_payment_status',
                        'label' => __("Deposit payment options", 'traveler'),
                        'desc' => __('You can select <code>Disallow deposit</code>, <code>Deposit by percent</code>'),
                        'type' => 'select',
                        'choices' => [
                            [
                                'value' => '',
                                'label' => __('Disallow deposit', 'traveler')
                            ],
                            [
                                'value' => 'percent',
                                'label' => __('Deposit by percent', 'traveler')
                            ],
                        ]
                    ],
                    [
                        'label' => __('Deposit payment amount', 'traveler'),
                        'desc' => __('Leave empty for disallow deposit payment', 'traveler'),
                        'id' => 'deposit_payment_amount',
                        'type' => 'text',
                        'condition' => 'deposit_payment_status:not()'
                    ],
                    [
                        'label' => __('Car Options', 'traveler'),
                        'id' => 'cars_options',
                        'type' => 'tab'
                    ],
                    [
                        'label' => __('Minimum stay', 'traveler'),
                        'id' => 'cars_booking_period',
                        'type' => 'numeric-slider',
                        'min_max_step' => '0,30,1',
                        'std' => 0,
                        'desc' => __('Minimum stay in this car', 'traveler'),
                    ],
                    ( st()->get_option('cars_price_unit', 'day') == 'day' ) ?
                    [
                'label' => __('Minimum days to book', 'traveler'),
                'id' => 'cars_booking_min_day',
                'type' => 'numeric-slider',
                'min_max_step' => '0,7,1',
                'std' => 0,
                'desc' => __('Minimum days to book', 'traveler'),
                    ] : [
                'label' => __('Minimum hours to book', 'traveler'),
                'id' => 'cars_booking_min_hour',
                'type' => 'numeric-slider',
                'min_max_step' => '0,168,1',
                'std' => 0,
                'desc' => __('Minimum hours to book', 'traveler'),
                    ],
                    [
                        'label' => __('Allow external booking', 'traveler'),
                        'id' => 'st_car_external_booking',
                        'type' => 'on-off',
                        'std' => "off",
                        'desc' => __('You can set booking by an external link', 'traveler')
                    ],
                    [
                        'label' => __('Car external booking link', 'traveler'),
                        'id' => 'st_car_external_booking_link',
                        'type' => 'text',
                        'std' => "",
                        'condition' => 'st_car_external_booking:is(on)',
                        'desc' => "<i>" . __("Must be http://") . "</i>"
                    ],
                    [
                        'label' => __('Cancel booking', 'traveler'),
                        'id' => 'st_cancel_booking_tab',
                        'type' => 'tab'
                    ],
                    [
                        'label' => __('Allow cancellation', 'traveler'),
                        'id' => 'st_allow_cancel',
                        'type' => 'on-off',
                        'std' => 'off'
                    ],
                    [
                        'label' => __('Number of days before the arrival', 'traveler'),
                        'desc' => __('Number of days before the arrival', 'traveler'),
                        'id' => 'st_cancel_number_days',
                        'type' => 'text',
                        'condition' => 'st_allow_cancel:is(on)'
                    ],
                    [
                        'label' => __('Cancellation Fee', 'traveler'),
                        'desc' => __('A percentage of money customers will be deducted if they cancel a reservation', 'traveler'),
                        'id' => 'st_cancel_percent',
                        'type' => 'numeric-slider',
                        'min_max_step' => '0,100,1',
                        'condition' => 'st_allow_cancel:is(on)'
                    ]
                ]
            ];
            $data_paypment = STPaymentGateways::get_payment_gateways();
            if (!empty($data_paypment) and is_array($data_paypment)) {
                $this->metabox[0]['fields'][] = [
                    'label' => __('Payment', 'traveler'),
                    'id' => 'payment_detail_tab',
                    'type' => 'tab'
                ];
                foreach ($data_paypment as $k => $v) {
                    $this->metabox[0]['fields'][] = [
                        'label' => $v->get_name(),
                        'id' => 'is_meta_payment_gateway_' . $k,
                        'type' => 'on-off',
                        'desc' => $v->get_name(),
                        'std' => 'on'
                    ];
                }
            }
            $custom_field = st()->get_option('st_cars_unlimited_custom_field');
            if (!empty($custom_field) and is_array($custom_field)) {
                $this->metabox[0]['fields'][] = [
                    'label' => __('Custom fields', 'traveler'),
                    'id' => 'custom_field_tab',
                    'type' => 'tab'
                ];
                foreach ($custom_field as $k => $v) {
                    $key = str_ireplace('-', '_', 'st_custom_' . sanitize_title($v['title']));
                    $this->metabox[0]['fields'][] = [
                        'label' => $v['title'],
                        'id' => $key,
                        'type' => $v['type_field'],
                        'desc' => '<input value=\'[st_custom_meta key="' . $key . '"]\' type=text readonly />',
                        'std' => $v['default_field']
                    ];
                }
            }

            parent::register_metabox($this->metabox);
        }

        function meta_update_sale_price($post_id) {
            if (wp_is_post_revision($post_id))
                return;
            $post_type = get_post_type($post_id);
            if ($post_type == 'st_cars') {
                $sale_price = get_post_meta($post_id, 'cars_price', TRUE);
                $discount = get_post_meta($post_id, 'discount', TRUE);
                $is_sale_schedule = get_post_meta($post_id, 'is_sale_schedule', TRUE);
                if ($is_sale_schedule == 'on') {
                    $sale_from = get_post_meta($post_id, 'sale_price_from', TRUE);
                    $sale_to = get_post_meta($post_id, 'sale_price_to', TRUE);
                    if ($sale_from and $sale_from) {

                        $today = date('Y-m-d');
                        $sale_from = date('Y-m-d', strtotime($sale_from));
                        $sale_to = date('Y-m-d', strtotime($sale_to));
                        if (( $today >= $sale_from ) && ( $today <= $sale_to )) {
                            
                        } else {

                            $discount = 0;
                        }
                    } else {
                        $discount = 0;
                    }
                }
                if ($discount) {
                    $sale_price = $sale_price - ( $sale_price / 100 ) * $discount;
                }
                update_post_meta($post_id, 'sale_price', $sale_price);
            }
        }

        function _resend_mail() {
            $order_item = isset($_GET['order_item_id']) ? $_GET['order_item_id'] : FALSE;
            $test = isset($_GET['test']) ? $_GET['test'] : FALSE;
            if ($order_item) {
                $order = $order_item;
                if ($test) {
                    global $order_id;
                    $order_id = $order_item;
                    $id_page_email_for_admin = st()->get_option('email_for_admin', '');
                        $content = !empty(get_post($id_page_email_for_admin)) ? wp_kses_post(get_post($id_page_email_for_admin)->post_content) : "";
                        $email          = "";
	                    $email .= TravelHelper::_get_template_email($email, $content);
                        
                    echo( $email );
                    die;
                }
                if ($order) {
                    STCart::send_mail_after_booking($order);
                }
            }
            wp_safe_redirect(self::$booking_page . '&send_mail=success');
        }

        static function st_room_select_ajax() {
            extract(wp_parse_args($_GET, [
                'room_parent' => '',
                'post_type' => '',
                'q' => ''
            ]));
            query_posts(['post_type' => $post_type, 'posts_per_page' => 10, 's' => $q, 'meta_key' => 'room_parent', 'meta_value' => $room_parent]);
            $r = [
                'items' => []
            ];
            while (have_posts()) {
                the_post();
                $r['items'][] = [
                    'id' => get_the_ID(),
                    'name' => get_the_title(),
                    'description' => ''
                ];
            }
            wp_reset_query();
            echo json_encode($r);
            die;
        }

        static function add_edit_scripts() {

            wp_enqueue_script('car-booking', get_template_directory_uri() . '/js/admin/car-booking.js', ['jquery', 'jquery-ui-datepicker'], NULL, TRUE);
            wp_enqueue_style('jquery-ui.theme.min.css', get_template_directory_uri() . '/css/admin/jquery-ui.min.css');
        }

        static function is_booking_page() {
            if (is_admin()
                    and isset($_GET['post_type'])
                    and $_GET['post_type'] == 'st_cars'
                    and isset($_GET['page'])
                    and $_GET['page'] = 'st_car_booking'
            )
                return TRUE;

            return FALSE;
        }

        function add_menu_page() {
            //Add booking page
            add_submenu_page('edit.php?post_type=st_cars', __('Car Booking', 'traveler'), __('Car Booking', 'traveler'), 'manage_options', 'st_car_booking', [$this, '__car_booking_page']);
        }

        function __car_booking_page() {
            $section = isset($_GET['section']) ? $_GET['section'] : FALSE;
            if ($section) {
                switch ($section) {
                    case "edit_order_item":
                        $this->edit_order_item();
                        break;
                }
            } else {
                $action = isset($_POST['st_action']) ? $_POST['st_action'] : FALSE;
                switch ($action) {
                    case "delete":
                        $this->_delete_items();
                        break;
                }
                echo balanceTags($this->load_view('car/booking_index', FALSE));
            }
        }

        function add_booking() {
            echo balanceTags($this->load_view('car/booking_edit', FALSE, ['page_title' => __('Add new Car Booking', 'traveler')]));
        }

        function _delete_items() {
            if (empty($_POST) or ! check_admin_referer('shb_action', 'shb_field')) {
                //// process form data, e.g. update fields
                return;
            }
            $ids = isset($_POST['post']) ? $_POST['post'] : [];
            if (!empty($ids)) {
                foreach ($ids as $id) {
                    wp_delete_post($id, TRUE);
                    do_action('st_admin_delete_booking', $id);
                }
            }
            STAdmin::set_message(__("Delete item(s) success", 'traveler'), 'updated');
        }

        function edit_order_item() {
            $item_id = isset($_GET['order_item_id']) ? $_GET['order_item_id'] : FALSE;
            if (!$item_id or get_post_type($item_id) != 'st_order') {
                return FALSE;
            }

            if (isset($_POST['submit']) and $_POST['submit'])
                $this->_save_booking($item_id);
            echo balanceTags($this->load_view('car/booking_edit'));
        }

        function _save_booking($order_id) {
            if (!check_admin_referer('shb_action', 'shb_field'))
                die;
            if ($this->check_validate()) {
                $check_out_field = STCart::get_checkout_fields();
                if (!empty($check_out_field)) {
                    foreach ($check_out_field as $field_name => $field_desc) {
                        if ($field_name != 'st_note') {
                            update_post_meta($order_id, $field_name, STInput::post($field_name));
                        }
                    }
                }

                $item_data = [
                    'status' => $_POST['status']
                ];

                foreach ($item_data as $val => $value) {
                    update_post_meta($order_id, $val, $value);
                }

                if (TravelHelper::checkTableDuplicate('st_cars')) {
                    global $wpdb;

                    $table = $wpdb->prefix . 'st_order_item_meta';
                    $data = [
                        'status' => $_POST['status'],
                        'cancel_refund_status' => 'complete'
                    ];
                    $where = [
                        'order_item_id' => $order_id
                    ];
                    $wpdb->update($table, $data, $where);
                }

                STCart::send_mail_after_booking($order_id, true);

                do_action('st_admin_edit_booking_status', $item_data['status'], $order_id);
                wp_safe_redirect(self::$booking_page);
            }
        }

        function check_validate() {

            $st_first_name = STInput::request('st_first_name', '');
            if (empty($st_first_name)) {
                STAdmin::set_message(__('The firstname field is not empty.', 'traveler'), 'danger');

                return false;
            }

            $st_last_name = STInput::request('st_last_name', '');
            if (empty($st_last_name)) {
                STAdmin::set_message(__('The lastname field is not empty.', 'traveler'), 'danger');

                return false;
            }

            $st_email = STInput::request('st_email', '');
            if (empty($st_email)) {
                STAdmin::set_message(__('The email field is not empty.', 'traveler'), 'danger');

                return false;
            }

            $st_phone = STInput::request('st_phone', '');
            if (empty($st_phone)) {
                STAdmin::set_message(__('The phone field is not empty.', 'traveler'), 'danger');

                return false;
            }

            return true;
        }

        function is_able_edit() {
            $item_id = isset($_GET['order_item_id']) ? $_GET['order_item_id'] : FALSE;
            if (!$item_id or get_post_type($item_id) != 'st_order') {
                wp_safe_redirect(self::$booking_page);
                die;
            }

            return TRUE;
        }

        // =================================================================
        function init() {
            $this->add_meta_field();
        }

        function add_meta_field() {
            if (is_admin()) {
                $pages = ['st_cars_pickup_features'];
                /*
                 * prefix of meta keys, optional
                 */
                $prefix = 'st_';
                /*
                 * configure your meta box
                 */
                $config = [
                    'id' => 'st_extra_infomation_cars', // meta box id, unique per meta box
                    'title' => __('Extra Information', 'traveler'), // meta box title
                    'pages' => $pages, // taxonomy name, accept categories, post_tag and custom taxonomies
                    'context' => 'normal', // where the meta box appear: normal (default), advanced, side; optional
                    'fields' => [], // list of meta fields (can be added by field arrays)
                    'local_images' => FALSE, // Use local or hosted images (meta box images for add/remove)
                    'use_with_theme' => FALSE          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
                ];

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
                $my_meta->addText($prefix . 'icon', ['name' => __('Icon', 'traveler'),
                    'desc' => __('Example: <br>Input "fa-desktop" for <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank" >Fontawesome</a>,<br>Input "im-pool" for <a href="https://icomoon.io/" target="_blank">Icomoon</a>  ', 'traveler')]);

                /*
                 * Don't Forget to Close up the meta box decleration
                 */
                //Finish Meta Box Decleration
                $my_meta->Finish();
            }
        }

        function cars_update_location($post_id) {
            if (wp_is_post_revision($post_id))
                return;
            $post_type = get_post_type($post_id);
            if ($post_type == 'st_cars') {
                $location_id = get_post_meta($post_id, 'id_location', TRUE);
                $ids_in = [];
                $parents = get_posts(['numberposts' => -1, 'post_status' => 'publish', 'post_type' => 'location', 'post_parent' => $location_id]);

                $ids_in[] = $location_id;

                foreach ($parents as $child) {
                    $ids_in[] = $child->ID;
                }
                $arg = [
                    'post_type' => 'st_cars',
                    'posts_per_page' => '-1',
                    'meta_query' => [
                        [
                            'key' => 'id_location',
                            'value' => $ids_in,
                            'compare' => 'IN',
                        ],
                    ],
                ];
                $query = new WP_Query($arg);
                $offer_tours = $query->post_count;

                // get total review
                $arg = [
                    'post_type' => 'st_cars',
                    'posts_per_page' => '-1',
                    'meta_query' => [
                        [
                            'key' => 'id_location',
                            'value' => $ids_in,
                            'compare' => 'IN',
                        ],
                    ],
                ];
                $query = new WP_Query($arg);
                $total = 0;
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $total += get_comments_number();
                    }
                }
                // get car min price
                $arg = [
                    'post_type' => 'st_cars',
                    'posts_per_page' => '1',
                    'order' => 'ASC',
                    'meta_key' => 'sale_price',
                    'orderby' => 'meta_value_num',
                    'meta_query' => [
                        [
                            'key' => 'id_location',
                            'value' => $ids_in,
                            'compare' => 'IN',
                        ],
                    ],
                ];
                $query = new WP_Query($arg);
                if ($query->have_posts()) {
                    $query->the_post();
                    $price_min = get_post_meta(get_the_ID(), 'cars_price', TRUE);
                    update_post_meta($location_id, 'review_st_cars', $total);
                    update_post_meta($location_id, 'min_price_st_cars', $price_min);
                    update_post_meta($location_id, 'offer_st_cars', $offer_tours);
                }
                wp_reset_postdata();
            }
        }

        function add_col_header($defaults) {

            $this->array_splice_assoc($defaults, 2, 0, [
                'price' => __('Price', 'traveler'),
                'cars_layout' => __('Layout', 'traveler'),
            ]);

            return $defaults;
        }

        function array_splice_assoc(&$input, $offset, $length = 0, $replacement = []) {
            $tail = array_splice($input, $offset);
            $extracted = array_splice($tail, 0, $length);
            $input += $replacement + $tail;

            return $extracted;
        }

        function add_col_content($column_name, $post_ID) {
            if ($column_name == 'cars_layout') {
                // show content of 'directors_name' column
                $parent = get_post_meta($post_ID, 'st_custom_layout', TRUE);

                if ($parent) {
                    echo "<a href='" . get_edit_post_link($parent) . "'>" . get_the_title($parent) . "</a>";
                } else {
                    echo __('Default', 'traveler');
                }
            }
            if ($column_name == 'price') {
                $type = get_post_meta($post_ID, 'car_type', true);
                if ($type == 'car_transfer') {
                    $price = self::get_min_max_price_transfer($post_ID);
                    $price = (float) $price['min_price'];
                } else {
                    $price = get_post_meta($post_ID, 'cars_price', true);
                }

                $discount = get_post_meta($post_ID, 'discount', true);
                if (!empty($discount)) {
                    $x = $discount;
                    $discount = $price - $price * ( $discount / 100 );
                    $is_sale_schedule = get_post_meta($post_ID, 'is_sale_schedule', true);
                    if ($is_sale_schedule == "on") {
                        $sale_from = get_post_meta($post_ID, 'sale_price_from', true);
                        $sale_from = mysql2date('d/m/Y', $sale_from);
                        $sale_to = get_post_meta($post_ID, 'sale_price_to', true);
                        $sale_to = mysql2date('d/m/Y', $sale_to);
                        echo '<span class="sale">' . TravelHelper::format_money($price) . '</span>  <i class="fa fa-arrow-right"></i>  <strong>' . esc_html(TravelHelper::format_money($discount)) . '</strong> <br>';
                        echo '<span>' . __('Discount rate', 'traveler') . ' : ' . $x . '%</span><br>';
                        echo '<span> ' . $sale_from . ' <i class="fa fa-arrow-right"></i> ' . $sale_to . '</span> <br>';
                    } else {
                        echo '<span class="sale">' . TravelHelper::format_money($price) . '</span>  <i class="fa fa-arrow-right"></i>  <strong>' . esc_html(TravelHelper::format_money($discount)) . '</strong><br>';
                        echo '<span>' . __('Discount rate', 'traveler') . ' : ' . $x . '%</span><br>';
                    }
                } else if ($price) {
                    echo '<span>' . TravelHelper::format_money($price) . '</span>';
                }
            }
        }

    }

    $a = new STAdminCars();
    $a->init();
}

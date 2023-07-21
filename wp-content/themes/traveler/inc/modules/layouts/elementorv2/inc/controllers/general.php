<?php
if (!class_exists('STT_Hotelv2_General')) {
    class STT_Hotelv2_General
    {
        private static $_inst;

        public function __construct()
        {
            add_action('wp_enqueue_scripts', [$this, '_enqueueScripts']);
            add_filter('st_header_component', [$this, '_changeHeaderComponent'], 9, 2);
            add_filter('st_get_popup_login_form', [$this, '_changePopupLoginForm'], 99, 2);
            add_action('st_before_login_template', [$this, '_changeLoginTemplate']);
            add_action('st_before_register_template', [$this, '_changeRegisterTemplate']);
            add_action('st_before_reset_password_template', [$this, '_changeResetPasswordTemplate']);
            add_filter('st_get_hotel_search_page', [$this, '_changeHotelSearchPage'], 10, 2);
            add_filter('st_get_tour_search_page', [$this, '_changeTourSearchPage'], 10, 2);
            add_filter('st_get_activity_search_page', [$this, '_changeActivitySearchPage'], 10, 2);
            add_filter('st_get_car_search_page', [$this, '_changeCarSearchPage'], 10, 2);
            add_filter('st_get_rental_search_page', [$this, '_changeRentalSearchPage'], 10, 2);
            add_action('st_get_car_transfer_search_page', [$this, '_changeCarTransferSearchPage'], 10, 2);
            add_filter('st_get_member_package_checkout_page', [$this, '_changeMemberPackageCheckoutPage'], 10, 2);
            add_filter('st_get_member_package_checkout_page_success', [$this, '_changeMemberPackageCheckoutPageSuccess'], 10, 2);
            add_filter('st_get_detail_hotel_page', [$this, '_changeDetailHotelPage'], 10, 2);
            add_filter('st_layout_single_room', [$this, '_addRoomStyleOption'], 10);
            add_filter('st_get_detail_room_page', [$this, '_changeDetailRoomPage'], 10, 2);
            add_filter('st_get_detail_tour_page', [$this, '_changeDetailTourPage'], 10, 2);
            add_filter('st_get_detail_activity_page', [$this, '_changeDetailActivityPage'], 10, 2);
            add_filter('st_get_detail_rental_page', [$this, '_changeDetailRentalPage'], 10, 2);
            add_filter('st_get_detail_car_page', [$this, '_changeDetailCarPage'], 10, 2);
            add_action('wp_ajax_getpayhtml', [$this, '_getGateWayHtml']);
            add_action('wp_ajax_nopriv_getpayhtml', [$this, '_getGateWayHtml']);
            add_filter('st_blog_list_style', [$this,'_addNewBlogStyle']);
            add_filter('st_archive_blog_template',[$this,'_changeArchiveBlogTemplate'], 10, 2);
            add_filter('st_widget_categoy_new',[$this,'_changeWidgetCategoryNewTemplate'], 10, 2);
            add_filter('st_single_blog_template',[$this,'_changeSingleBlogTemplate'], 10, 2);
            add_filter('st_checkout_page', [$this, '_changeCheckoutComponent']);

            // add_action('wp_ajax_st_get_list_location', [$this, '_getListLocations']);
            // add_action('wp_ajax_nopriv_st_get_list_location', [$this, '_getListLocations']);
        }

        public function _getListLocations() {
            $_s = STInput::post('_s');
            $_s = trim($_s);
            $post_type = STInput::post('post_type');
            $where_like = '';
            if(!empty($_s)){
                $where_like = " AND node.fullname LIKE '%{$_s}%' ";
            }
            global $wpdb;

            $language = "'" . 'en' . "'";
            if (defined('ICL_LANGUAGE_CODE')) {
                $language = "'" . ICL_LANGUAGE_CODE . "'";
            }
            $where = '';
            if (!empty($post_type)) {
                $where = " AND (
                node.location_id IN (
                    SELECT
                        nested.location_id
                    FROM
                        {$wpdb->prefix}st_location_nested AS nested
                    LEFT JOIN (
                        SELECT
                            __nested.*
                        FROM
                            {$wpdb->prefix}st_location_relationships AS lr
                        INNER JOIN {$wpdb->prefix}st_location_nested AS __nested ON (
                            __nested.location_id = lr.location_from
                        )
                        WHERE lr.post_type = '{$post_type}'
                        GROUP BY
                            lr.location_from
                    ) AS _nested ON (
                        nested.left_key <= _nested.left_key
                        AND nested.right_key >= _nested.right_key
                    )
                    WHERE
                        nested.location_id = _nested.location_id
                    OR nested.id = _nested.parent_id

                    GROUP BY
                        nested.location_id
                )
                OR node.location_id IN (
                    SELECT
                        nested.location_id
                    FROM
                        {$wpdb->prefix}st_location_nested AS nested
                    LEFT JOIN (
                        SELECT
                            __nested.*
                        FROM
                            {$wpdb->prefix}st_location_relationships AS lr
                        INNER JOIN {$wpdb->prefix}st_location_nested AS __nested ON (
                            __nested.location_id = lr.location_to
                        )
                        WHERE lr.post_type = '{$post_type}'
                        GROUP BY
                            lr.location_to
                    ) AS _nested ON (
                        nested.left_key <= _nested.left_key
                        AND nested.right_key >= _nested.right_key
                    )
                    WHERE
                        nested.location_id = _nested.location_id
                    OR nested.id = _nested.parent_id

                    GROUP BY
                        nested.location_id
                )
            )";
            }
            $sql = "SELECT
            node.id as post_id,
            node.location_id AS ID,
            node.`name` AS post_title,
            node.location_country AS Country,
            node.fullname,
            node.left_key,
            node.right_key,
            node.parent_id,
            (COUNT(parent.fullname) - 1) AS lv
        FROM
            {$wpdb->prefix}st_location_nested AS node,
            {$wpdb->prefix}st_location_nested AS parent
        WHERE
            node.id <> 1 and node.`language` = {$language} AND
            node.left_key BETWEEN parent.left_key
        AND parent.right_key
        {$where}
        AND node.`status` IN ('publish', 'private')
        {$where_like}
        GROUP BY
            node.fullname
        ORDER BY
            node.left_key
        LIMIT 10";
        $results = $wpdb->get_results($sql);

            $enable_tree = st()->get_option( 'bc_show_location_tree', 'off' );
            if ( $enable_tree == 'on' && empty($_s) ) {
                $locations = TravelHelper::buildTreeHasSort( $results , true );
            }else{
                $locations = $results;
            }

            $options = "";
            ob_start();
            if ( $enable_tree == 'on' && empty($_s) ) {
                echo New_Layout_Helper::buildTreeOptionLocation( $locations, '', '<span class="stt-icon stt-icon-location1"></span>', true);
            } else {
                if ( is_array( $locations ) && count( $locations ) ):
                    foreach ( $locations as $key => $value ):
                        ?>
                        <li class="item dropdown-item" data-value="<?php echo esc_attr($value->ID); ?>">
                            <span class="stt-icon stt-icon-location1"></span>
                            <span><?php echo esc_attr($value->fullname); ?></span></li>
                    <?php
                    endforeach;
                endif;
            }
            $options = ob_get_contents();
            ob_clean();
            ob_end_flush();

            echo json_encode([
                'options' => $options
            ]);die();
        }

        public function _changeCheckoutComponent($component) {
            $component = stt_elementorv2()->loadView('templates/checkout');
            return $component;
        }

        static function comment_form_post($args = [], $post_id = null) {
            $class_form_comment = "";
            if (null === $post_id)
                $post_id = get_the_ID();

            if (!comments_open($post_id)) {
                do_action('comment_form_comments_closed');

                return;
            }

            $commenter = wp_get_current_commenter();
            $consent   = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
            $user = wp_get_current_user();
            $user_identity = $user->exists() ? $user->display_name : '';

            $args = wp_parse_args($args);
            if (!isset($args['format']))
                $args['format'] = current_theme_supports('html5', 'comment-form') ? 'html5' : 'xhtml';

            $req = get_option('require_name_email');
            $html_req = ($req ? " required='required'" : '');
            $html5 = 'html5' === $args['format'];
            $fields =array();
            $required_text = sprintf(' ' . __('Required fields are marked %s'), '<span class="required">*</span>');

            /**
             * Filters the default comment form fields.
             *
             * @since 3.0.0
             *
             * @param array $fields The default comment fields.
             */
            $fields = apply_filters('comment_form_default_fields', $fields);
            $defaults = [
                'fields' => $fields,
                'comment_field' => '',
                /** This filter is documented in wp-includes/link-template.php */
                'must_log_in' => '<p class="must-log-in">' . sprintf(
                        /* translators: %s: login URL */
                        __('You must be <a href="%s">logged in</a> to post a comment.'), wp_login_url(apply_filters('the_permalink', get_permalink($post_id), $post_id))
                ) . '</p>',
                /** This filter is documented in wp-includes/link-template.php */
                'logged_in_as' => '<p class="logged-in-as">' . sprintf(
                        /* translators: 1: edit user link, 2: accessibility text, 3: user name, 4: logout URL */
                        __('<a href="%1$s" aria-label="%2$s">Logged in as %3$s</a>. <a href="%4$s">Log out?</a>'), get_edit_user_link(),
                        /* translators: %s: user name */ esc_attr(sprintf(__('Logged in as %s. Edit your profile.'), $user_identity)), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink($post_id), $post_id))
                ) . '</p>',
                'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">' . __('Your email address will not be published.') . '</span>' . ($req ? $required_text : '') . '</p>',
                'comment_notes_after' => '',
                'action' => site_url('/wp-comments-post.php'),
                'id_form' => 'commentform',
                'id_submit' => 'submit',
                'class_form' => 'comment-form',
                'class_submit' => 'submit',
                'name_submit' => 'submit',
                'title_reply' => __('Leave a comment'),
                'title_reply_to' => __('Leave a Reply to %s'),
                'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
                'title_reply_after' => '</h3>',
                'cancel_reply_before' => ' <small>',
                'cancel_reply_after' => '</small>',
                'cancel_reply_link' => __('Cancel reply'),
                'label_submit' => __('Post Comment'),
                'submit_button' => '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
                'submit_field' => '<p class="form-submit">%1$s %2$s</p>',
                'format' => 'xhtml',
            ];

            $args = wp_parse_args($args, apply_filters('comment_form_defaults', $defaults));

            $args = array_merge($defaults, $args);

            do_action('comment_form_before');

            ?>
            <div id="respond" class="comment-respond <?php echo esc_attr($class_form_comment);?>">
                <?php
                echo($args['title_reply_before']);

                comment_form_title($args['title_reply'], $args['title_reply_to']);

                echo($args['cancel_reply_before']);

                cancel_comment_reply_link($args['cancel_reply_link']);

                echo($args['cancel_reply_after']);

                echo($args['title_reply_after']);

                if (get_option('comment_registration') && !is_user_logged_in()) :
                    echo balanceTags($args['must_log_in']);
                    do_action('comment_form_must_log_in_after');
                else :
                    printf(
                    '<form action="%s" method="post" id="%s" class="%s review-form"%s>',
                        esc_url( $args['action'] ),
                        esc_attr( $args['id_form'] ),
                        esc_attr( $args['class_form'] ),
                        ( $html5 ? ' novalidate' : '' )
                        );
                        ?>

                        <?php
                        do_action( 'comment_form_top' );
                        do_action( 'comment_form_logged_in_after', $commenter, $user_identity );
                        // Prepare an array of all fields, including the textarea.
                        $comment_fields = array( 'comment' => $args['comment_field'] ) + (array) $args['fields'];
                        /**
                         * Filters the comment form fields, including the textarea.
                        *
                        * @since 4.4.0
                        *
                        * @param array $comment_fields The comment fields.
                        */
                        $comment_fields = apply_filters( 'comment_form_fields', $comment_fields );

                        // Get an array of field names, excluding the textarea.
                        $comment_field_keys = array_diff( array_keys( $comment_fields ), array( 'comment' ) );

                         // Get the first and the last field name, excluding the textarea.
                        $first_field = reset( $comment_field_keys );
                        $last_field  = end( $comment_field_keys );
                        foreach ( $comment_fields as $name => $field ) {
                            if ( $first_field === $name ) {
                                /**
                                 * Fires before the comment fields in the comment form, excluding the textarea.
                                 *
                                 * @since 3.0.0
                                 */
                                do_action( 'comment_form_before_fields' );
                            }

                            /**
                             * Filters a comment form field for display.
                             *
                             * The dynamic portion of the filter hook, `$name`, refers to the name
                             * of the comment form field. Such as 'author', 'email', or 'url'.
                             *
                             * @since 3.0.0
                             *
                             * @param string $field The HTML-formatted output of the comment form field.
                             */
                            echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";

                            if ( $last_field === $name ) {
                                /**
                                 * Fires after the comment fields in the comment form, excluding the textarea.
                                 *
                                 * @since 3.0.0
                                 */
                                do_action( 'comment_form_after_fields' );
                            }
                        }

                        ?>
                        <div class="row">
                            <div class="col-12">
                                <label><?php echo __('Your comment', 'traveler') ?></label>
                                <textarea name="comment" class="form-control has-matchHeight"></textarea>
                            </div>
                            <div class="col-12 col-sm-6">
                                <label><?php echo __('Your name', 'traveler') ?><span>*</span></label>
                                <input type="text" class="form-control" name="author">
                            </div>
                            <div class="col-12 col-sm-6">
                                <label><?php echo __('Email', 'traveler') ?><span>*</span></label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="col-12">
                                <p class="comment-form-cookies-consent">
                                    <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" <?php echo $consent ?> />
                                    <label for="wp-comment-cookies-consent"><?php echo __('Save my name, email, and website in this browser for the next time I comment.', 'traveler') ?></label>
                                </p>
                            </div>
                        </div>
                        <?php
                        $submit_button = sprintf(
                                $args['submit_button'], esc_attr($args['name_submit']), esc_attr($args['id_submit']), esc_attr($args['class_submit']), esc_attr($args['label_submit'])
                        );
                        $submit_button = apply_filters('comment_form_submit_button', $submit_button, $args);

                        $submit_field = sprintf(
                                $args['submit_field'], $submit_button, get_comment_id_fields($post_id)
                        );
                        echo apply_filters('comment_form_submit_field', $submit_field, $args);
                        do_action('comment_form', $post_id);
                        ?>
                    </form>
                <?php endif; ?>
            </div><!-- #respond -->
            <?php
            do_action('comment_form_after');
        }
        public function _changeSingleBlogTemplate($component)
        {
            $layout = st()->get_option('blog_list_style_modern', '1');
            if ($layout == 3) {
                $component = stt_elementorv2()->loadView('blog/single');
            }
            return $component;
        }
        public function _changeWidgetCategoryNewTemplate($component, $array_merge)
        {
            $layout = st()->get_option('blog_list_style_modern', '1');
            if($layout == 3) {
              $component = stt_elementorv2()->loadView('widgets/st-categories-new',['array_merge'=>$array_merge]);
            }
            return $component;
        }
        public function _changeArchiveBlogTemplate($component='', $style='')
        {
            if ($style == 3) {
                $component = stt_elementorv2()->loadView('blog/archive');
            }
            return $component;
        }
        public function _addNewBlogStyle($lists)
        {
            if (check_using_elementor()) {
                $lists[] = [
                    'id' => '3',
                    'alt' => __('Blog Style 3', 'traveler'),
                    'src' => get_template_directory_uri() . '/img/blog_style_3.png',
                ];
            }
            return $lists;
        }

        public function _changeDetailRoomPage($component='', $style='')
        {
            if (in_array($style, [3, 4])) {
                $component = stt_elementorv2()->loadView('services/room/single/single-' . ($style - 2), ['style_single' => $style]);
            }
            return $component;
        }

        public function _changeDetailCarPage($component='', $style=''){
            if (in_array($style, [2, 3])) {
                $component = stt_elementorv2()->loadView('services/car/single/single-' . ($style - 1), ['style_single' => $style]);
            }
            return $component;
        }

        public function _changeDetailActivityPage($component='', $style=''){
            if (in_array($style, [4, 5])) {
                $component = stt_elementorv2()->loadView('services/activity/single/single-' . ($style - 3), ['style_single' => $style]);
            }
            return $component;
        }

        public function _changeDetailRentalPage($component='', $style=''){
            if (in_array($style, [3, 4])) {
                $component = stt_elementorv2()->loadView('services/rental/single/single-' . ($style - 2), ['style_single' => $style]);
            }
            return $component;
        }

        public function _changeDetailTourPage($component='', $style=''){
            if (in_array($style, [8, 9])) {
                $component = stt_elementorv2()->loadView('services/tour/single/single-' . ($style - 7), ['style_single' => $style]);
            }
            return $component;
        }

        public function _addRoomStyleOption($styles)
        {
            if (check_using_elementor()) {
                $styles[] = [
                    'value' => '3',
                    'label' => esc_html__('Layout 3', 'traveler'),
                    'src' => stt_elementorv2()->layoutURI . stt_elementorv2()->layoutName . '/assets/images/layouts/room_detail_3_preview.PNG',
                ];
                $styles[] = [
                    'value' => '4',
                    'label' => esc_html__('Layout 4', 'traveler'),
                    'src' => stt_elementorv2()->layoutURI . stt_elementorv2()->layoutName . '/assets/images/layouts/room_detail_4_preview.png',
                ];
            }
            return $styles;
        }

        public function _getGateWayHtml()
        {

            $gateways = STPaymentGateways::get_payment_gateways();
            ob_start();
            $value = (isset($_POST['value'])) ? ($_POST['value']) : '';
            $gateways[$value]->html();
            $result = ob_get_clean();
             wp_send_json_success($result);
            die();
        }

        public function _changeDetailHotelPage($component='', $style='')
        {
            if ($style == 4) {
                $component = stt_elementorv2()->loadView('services/hotel/single/single-1', ['style_single' => $style]);
            }elseif ($style == 5) {
                $component = stt_elementorv2()->loadView('services/hotel/single/single-2', ['style_single' => $style]);
            }
            return $component;
        }

        public function _changeMemberPackageCheckoutPageSuccess($component, $layout)
        {

            if ($layout == 2) {
                $component = stt_elementorv2()->loadView('pages/member-package-checkout-success');
            }
            return $component;
        }

        public function _changeMemberPackageCheckoutPage($component, $layout)
        {
            if ($layout == 2) {
                $component = stt_elementorv2()->loadView('pages/member-package-checkout');
            }
            return $component;
        }

        public function _changeHotelSearchPage($component, $layout)
        {
            switch ($layout) {
                case 5:
                    $component = stt_elementorv2()->loadView('services/hotel/search-page/halfmap');
                    break;
                case 6:
                    $component = stt_elementorv2()->loadView('services/hotel/search-page/popupmap');
                    break;
                default:
            }
            return $component;
        }

        public function _changeTourSearchPage($component, $layout){
            switch ($layout) {
                case 6:

                    $component = stt_elementorv2()->loadView('services/tour/search-page/sidebar');
                    break;
                case 7:
                    $component = stt_elementorv2()->loadView('services/tour/search-page/topbar');
                    break;
                default:
            }
            return $component;
        }

        public function _changeCarSearchPage($component, $layout){
            switch ($layout) {
                case 3:

                    $component = stt_elementorv2()->loadView('services/car/search-page/sidebar');
                    break;
                case 4:
                    $component = stt_elementorv2()->loadView('services/car/search-page/topbar');
                    break;
                default:
            }
            return $component;
        }

        public function _changeCarTransferSearchPage(){

            $menu_style = st()->get_option('menu_style_modern', 1);
            if ($menu_style == 9) {
                echo  $component = stt_elementorv2()->loadView('services/car_transfer/search-page/sidebar');
                exit();
            }
        }

        public function _changeRentalSearchPage($component, $layout){
            switch ($layout) {
                case 4:
                    $component = stt_elementorv2()->loadView('services/rental/search-page/halfmap');
                    break;
                case 5:
                    $component = stt_elementorv2()->loadView('services/rental/search-page/popupmap');
                    break;
                default:
            }
            return $component;
        }

        public function _changeActivitySearchPage($component, $layout){
            switch ($layout) {
                case 3:

                    $component = stt_elementorv2()->loadView('services/activity/search-page/sidebar');
                    break;
                case 4:
                    $component = stt_elementorv2()->loadView('services/activity/search-page/topbar');
                    break;
                default:
            }
            return $component;
        }

        public function _changeResetPasswordTemplate()
        {
            if (check_using_elementor()) {
                $menu_style = st()->get_option('menu_style_modern', 1);
                if ($menu_style == 9) {
                    echo stt_elementorv2()->loadView('templates/reset-password');
                    exit();
                }
            }
        }

        public function _changeRegisterTemplate()
        {
            if (check_using_elementor()) {
                $menu_style = st()->get_option('menu_style_modern', 1);
                if ($menu_style == 9) {
                    echo stt_elementorv2()->loadView('templates/register');
                    exit();
                }
            }
        }

        public function _changeLoginTemplate()
        {
            if (check_using_elementor()) {
                $menu_style = st()->get_option('menu_style_modern', 1);
                if ($menu_style == 9) {
                    echo stt_elementorv2()->loadView('templates/login');
                    exit();
                }
            }
        }

        public function _changePopupLoginForm($component, $args)
        {
            if ($args['style'] == 9) {
                $component = stt_elementorv2()->loadView('components/popup/account');
            }
            return $component;
        }

        public function _changeHeaderComponent($component, $args)
        {
            if ($args['style'] == 9) {
                $component = stt_elementorv2()->loadView('components/header');
            }
            return $component;
        }

        public function _enqueueScripts()
        {
            if (!is_page_template('template-user.php')) {
                if (check_using_elementor()) {
                    wp_enqueue_style('layout-hotelv2-main', stt_elementorv2()->layoutURI . stt_elementorv2()->layoutName . '/assets/css/main.css');
                    $google_map_enabled = st()->get_option('st_googlemap_enabled');
                    if($google_map_enabled == 'on') {
                        wp_enqueue_script('layout-hotelv2-marker', stt_elementorv2()->layoutURI . stt_elementorv2()->layoutName . '/assets/vendors/markerwithlabel.js', ['jquery'], false, true);
                    }
                    wp_enqueue_script('layout-hotelv2-main', stt_elementorv2()->layoutURI . stt_elementorv2()->layoutName . '/assets/js/main.js', ['jquery'], false, true);
                }
            }

        }

        public static function inst()
        {
            if (empty(self::$_inst)) {
                self::$_inst = new self();
            }
            return self::$_inst;
        }
    }

    STT_Hotelv2_General::inst();
}

<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Main class install
 */
class STRegExtension {


	public $plugins_folder_baseurl;
	public function __construct() {
		add_filter( 'st_vina_list_extendsion', [ $this, 'list_extension' ], 10, 1 );
		add_action( 'st_vina_list_addons', [ $this, 'list_addons' ], 9 );
		add_action( 'admin_menu', [ $this, 'st_vina_create_menu_in_admin' ], 10, 9 );
		$this->plugins_folder_baseurl = WP_PLUGIN_DIR;
	}
	public function st_vina_create_menu_in_admin() {
		add_submenu_page(
			'st_traveler_option',
			__( 'Extensions' ),
			__( 'Extensions' ),
			'manage_options',
			'st-vina-extensions',
			[ $this, 'st_vina_action_create_menu' ]
		);
	}
	public function st_vina_action_create_menu() {
		$list_page = apply_filters( 'st_vina_custom_page_extension_valid', [] );
		$tab       = isset( $_REQUEST['extension-tab'] ) ? $_REQUEST['extension-tab'] : 'list';
		$task      = isset( $_REQUEST['extension-task'] ) ? $_REQUEST['extension-task'] : false;
		if ( $tab == 'list' ) {
			$argsl = [];
			st_vina_get_template( 'html-extentions.php', $argsl, __DIR__, __DIR__ . '/views/' );
		} elseif ( $tab == 'extendsion' ) {
			$args2 = [];
			st_vina_get_template( 'html-list-extenstions.php', $args2, __DIR__, __DIR__ . '/views/' );
		}
	}
	public function list_addons( $list_addons ) {
		$list_addons = [
			'traveler-viator'    => [
				'name'          => __( 'Traveler Viator', 'traveler' ),
				'url-download'  => 'https://codecanyon.net/item/traveler-viator-addon/25883249?irgwc=1&clickid=Vci3vTxyLxyOU6nwUx0Mo3Q3Ukix8cwEDwF5wo0&iradid=275988&irpid=2084894&iradtype=ONLINE_TRACKING_LINK&irmptype=mediapartner&mp_value1=&utm_campaign=af_impact_radius_2084894&utm_medium=affiliate&utm_source=impact_radius',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'last_updated'  => '5/5/2020',
				'price'         => '39',
				'preview_image' => 'https://codecanyon.img.customer.envatousercontent.com/files/282575832/traveler_viator_preview.png?auto=compress%2Cformat&q=80&fit=crop&crop=top&max-h=8000&max-w=590&s=10a07f07739cc02dde1345c4bf3205d4',
			],
			'traveler-bokun'     => [
				'name'          => __( 'Traveler Bokun', 'traveler' ),
				'url-download'  => 'https://codecanyon.net/item/traveler-bokun-addon/26024431?s_rank=1',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'last_updated'  => '5/5/2020',
				'price'         => '39',
				'preview_image' => 'https://codecanyon.img.customer.envatousercontent.com/files/284460677/traveler_bokun_preview11.png?auto=compress%2Cformat&q=80&fit=crop&crop=top&max-h=8000&max-w=590&s=1a0efb8e9839904b60676de3cdcb0ee4',
			],
			'traveler-optimize'  => [
				'name'          => __( 'Traveler Optimize', 'traveler' ),
				'url-download'  => 'https://codecanyon.net/item/traveler-optimize-addon/26117905?s_rank=1',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'last_updated'  => '5/5/2020',
				'price'         => '39',
				'preview_image' => 'https://codecanyon.img.customer.envatousercontent.com/files/284943027/traveler_op_preview11.png?auto=compress%2Cformat&q=80&fit=crop&crop=top&max-h=8000&max-w=590&s=74cfae2fb9c43f0fea2f67f688af3c35',
			],
			'traveler-sms'       => [
				'name'          => __( 'Traveler SMS', 'traveler' ),
				'url-download'  => 'https://codecanyon.net/item/traveler-sms-addon/25726255?s_rank=6',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'Traveler SMS help to send SMS notification for Admin, Partner, and Customer when make a booking on the site by Traveler theme.', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'last_updated'  => '5/5/2020',
				'price'         => '39',
				'preview_image' => 'https://codecanyon.img.customer.envatousercontent.com/files/281114737/travelersms_preview.png?auto=compress%2Cformat&q=80&fit=crop&crop=top&max-h=8000&max-w=590&s=6219ee7f2b7f423ff91b8d639b092ab7',
			],
			'traveler-duplicate' => [
				'name'          => __( 'Traveler Duplicate', 'traveler' ),
				'url-download'  => 'https://codecanyon.net/item/traveler-duplicate-addon/26270682?s_rank=2',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'Traveler Duplicate Add-on will make it easier for you. Content such as price, availability of each service (hotel, tour, car, flight) will be fully copied.', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'last_updated'  => '5/5/2020',
				'price'         => '39',
				'preview_image' => 'https://codecanyon.img.customer.envatousercontent.com/files/285464240/traveler_duplicate_preview.png?auto=compress%2Cformat&q=80&fit=crop&crop=top&max-h=8000&max-w=590&s=5c41c57f27cf2dc0290e486c720b6894',
			],
			'traveler-compare'   => [
				'name'          => __( 'Traveler Compare', 'traveler' ),
				'url-download'  => 'https://codecanyon.net/item/traveler-compare-addon/26481293',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'The new add-on that can be used for Traveler. It helps bookers can compare any services like Hotel, Tour, Car, Rental, Activity.', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'last_updated'  => '5/5/2020',
				'price'         => '39',
				'preview_image' => 'https://codecanyon.img.customer.envatousercontent.com/files/287845460/travelercompare_preview.png?auto=compress%2Cformat&q=80&fit=crop&crop=top&max-h=8000&max-w=590&s=53f87930affd70c3b9307f986f5f572f',
			],
		];
		return $list_addons;
	}

	public function list_extension( $list_extendsion ) {
		$list_extendsion = [
			'traveler-layout-essential-for-elementor' => [
				'name'          => __( 'Traveler Library Layout Elementor', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-layout-essential-for-elementor.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'Traveler Library is a collection of blocks and sections for Elementor editor that is best for the Travel industry.', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.9 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-layout-essential-for-elementor.png',
				'last_updated'  => '5/8/2022',
				'homepage'      => 'https://travelerwp.com',
			],
			'traveler-rest-api'                       => [
				'name'          => __( 'Traveler Rest API', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-rest-api.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme . Export API Booking . Required install Simple JWT Login plugin', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.9 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-rest-api.png',
				'last_updated'  => '1/6/2022',
				'homepage'      => 'https://travelerwp.com',
			],
			'traveler-social-login'                   => [
				'name'          => __( 'Traveler Social Login', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-social-login.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme . Using for login Facebook, Google, Twitter', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.9 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-social-login.png',
				'last_updated'  => '1/6/2022',
				'homepage'      => 'https://travelerwp.com',
			],
			'traveler-smart-search'                   => [
				'name'          => __( 'Traveler Search Hotel VueWP', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-smart-search.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-smart-search.png',
				'last_updated'  => '15/12/2021',
				'homepage'      => 'https://travelerwp.com',
			],
			'traveler-razor-pay'                      => [
				'name'          => __( 'Traveler Razor Pay', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-razor-pay.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-razor-pay.png',
				'last_updated'  => '18/11/2020',
				'homepage'      => 'https://travelerwp.com',
			],
			'traveler-export'                         => [
				'name'          => __( 'Traveler Export Booking PDF', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-export.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.2',
				'requires'      => '5.6 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-export.png',
				'last_updated'  => '4/8/2020',
				'homepage'      => 'https://travelerwp.com',
			],
			'traveler-paypal-v2'                      => [
				'name'          => __( 'Traveler PayPal V2', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-paypal-v2.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-paypal-v2.png',
				'last_updated'  => '5/5/2020',
				'homepage'      => 'https://travelerwp.com',
			],
			'vina-stripe'                             => [
				'name'          => __( 'Traveler Stripe', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/vina-stripe.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/vina-stripe.png',
				'last_updated'  => '5/5/2020',
				'homepage'      => 'https://travelerwp.com',
			],
			'traveler-twocheckout'                    => [
				'name'          => __( '2Checkout', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-twocheckout.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-twocheckout.png',
				'last_updated'  => '5/5/2020',
				'homepage'      => 'https://travelerwp.com',
			],
			'traveler-authorize'                      => [
				'name'          => __( 'Authorize.net', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-authorize.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-authorize.png',
				'last_updated'  => '5/5/2020',
				'homepage'      => 'https://travelerwp.com',
			],
			'traveler-payu'                           => [
				'name'          => __( 'PayUbiz', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-payu.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-payu.png',
				'last_updated'  => '5/5/2020',
				'homepage'      => 'https://travelerwp.com',
			],
			'traveler-dpo'                            => [
				'name'          => __( 'DPO', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-dpo.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-dpo.png',
				'last_updated'  => '5/5/2020',
				'homepage'      => 'https://travelerwp.com',
			],
			'traveler-ipay88'                         => [
				'name'          => __( 'IPay88', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-ipay88.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-ipay88.png',
				'last_updated'  => '5/5/2020',
				'homepage'      => 'https://travelerwp.com',
			],
			'traveler-onepay'                         => [
				'name'          => __( 'Onepay', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-onepay.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-onepay-new.svg',
				'last_updated'  => '5/5/2020',
				'homepage'      => 'https://travelerwp.com',
			],
			'traveler-onepay-atm'                     => [
				'name'          => __( 'Onepay ATM', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-onepay-atm.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-onepay-atm.png',
				'last_updated'  => '5/5/2020',
				'homepage'      => 'https://travelerwp.com',
			],
			'traveler-payumoney'                      => [
				'name'          => __( 'PayUMoney', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-payumoney.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-payumoney.png',
				'last_updated'  => '5/5/2020',
				'homepage'      => 'https://travelerwp.com',
			],
			'traveler-payulatam'                      => [
				'name'          => __( 'PayUlatam', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-payulatam.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-payulatam.png',
				'last_updated'  => '5/5/2020',
				'homepage'      => 'https://travelerwp.com',
			],
			'traveler-mercadopago'                    => [
				'name'          => __( 'Mercado Pago', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-mercadopago.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-mercadopago.png',
				'last_updated'  => '5/5/2020',
				'homepage'      => 'https://travelerwp.com',
			],

			'traveler-billplz'                        => [
				'name'          => __( 'Billplz', 'traveler' ),
				'url-download'  => 'http://shinetheme.com/demosd/plugins/traveler/traveler-billplz.zip',
				'author'        => __( 'ShineTheme', 'traveler' ),
				'url-author'    => 'https://travelerwp.com/',
				'description'   => __( 'This plugin is used for Traveler Theme', 'traveler' ),
				'version'       => '1.0.0',
				'requires'      => '5.6 or higher',
				'preview_image' => 'http://shinetheme.com/demosd/plugins/traveler/previews/traveler-billplz.png',
				'last_updated'  => '5/5/2020',
				'homepage'      => 'https://travelerwp.com',

			],

		];
		return $list_extendsion;
	}
}
$STRegExtension = new STRegExtension();

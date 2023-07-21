<?php 
namespace Inc;
final class Init
{
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public static function get_services() 
	{
		return [
			API\Settings::class,
			API\STApiCore::class,
			API\Hotel\STApiHotel::class,
			API\Tour\STApiTour::class,
			API\Activity\STApiActivity::class,
			API\Rental\STApiRental::class,
			API\Car\STApiCar::class,
			ST_Api_Activate::class,
		];
	}

	public static function register_services() 
	{
		foreach ( self::get_services() as $class ) {
			$service = self::instantiate( $class );
			if ( method_exists( $service, 'get_settings' ) ) {
				$service->get_settings();
			}
		}
	}
    private static function instantiate( $class )
	{
		$service = new $class();
		return $service;
	}
}
?>
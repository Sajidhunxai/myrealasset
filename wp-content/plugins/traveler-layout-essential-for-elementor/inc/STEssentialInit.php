<?php 
namespace Inc;
final class STEssentialInit
{
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public static function getServices()
	{
		return [
			Base\ST_Enqueue::class,
			Base\ST_Elementor_Hook::class,
			Base\ST_Elementor_Widget::class,
			Base\Controller\Room\STRoomHotelAcency::class,
			Admin\AdminPages::class,
			STEssentialActivate::class,
			STEssentialDeactivate::class,
			//API\Importer::class,
		];
	}

	public static function registerServices()
	{
		foreach ( self::getServices() as $class ) {
			$service = self::instantiate( $class );
			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
		}
	}
    private static function instantiate($class)
	{
		$service = new $class();
		return $service;
	}
}
?>

<?php
/**
 * Plugin general Info
 *
 * @package GP\GP_Login_Customizer
 */

namespace GP\GP_Login_Customizer;

/**
 * The class containing information about the plugin.
 * Class Info
 */
class Info {

	/**
	 * The plugin slug.
	 *
	 * @var string
	 */
	const PLUGIN_SLUG = 'gp-login-customizer';

	/**
	 * Role Capacity
	 *
	 * @var string
	 */
	const CAPACITY = 'manage_options';

	/**
	 * Section name
	 *
	 * @var string
	 */
	const SECTION_CUSTOMIZER = 'custom_login_section';

	/**
	 * Plugin name in extensions
	 *
	 * @return string The plugin title
	 */
	public static function get_plugin_title() {
		return self::get_plugin_data( 'Name' );
	}

	/**
	 * Retrieves the plugin data from the main plugin file.
	 *
	 * @param string $value Header param.
	 *
	 * @return mixed
	 */
	private static function get_plugin_data( $value = 'Version' ) {
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . '/wp-admin/includes/plugin.php';
		}

		$plugin_data = get_plugin_data( self::get_path() );

		return $plugin_data[ $value ];
	}

	/**
	 * Path to the main plugin entry file
	 *
	 * @return string
	 */
	public static function get_path() {
		return GP_LOGIN_CUSTOMIZER_DIR . self::get_plugin_slug() . '.php';
	}

	/**
	 * Returns plugin slug gp-login-customizer
	 *
	 * @return string
	 */
	public static function get_plugin_slug() {
		return self::PLUGIN_SLUG;
	}
}

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
	 * Table namespace in database
	 *
	 * @var string
	 */
	const DB_NAMESPACE = 'gp_lc';

	/**
	 * Role Capacity
	 *
	 * @var string
	 */
	const CAPACITY = 'edit_pages';

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
		return GP_LOGIN_CUSTOMIZER_NR_DIR . 'plugin.php';
	}

	/**
	 * Plugin version
	 *
	 * @return mixed
	 */
	public static function get_plugin_version() {
		return self::get_plugin_data();
	}

	/**
	 * Returns plugin slug gp-login-customizer
	 *
	 * @return string
	 */
	public static function get_plugin_slug() {
		return self::PLUGIN_SLUG;
	}

	/**
	 * DB prefix name
	 *
	 * @return string
	 */
	public static function get_option_namespace() {
		return self::DB_NAMESPACE;
	}
}

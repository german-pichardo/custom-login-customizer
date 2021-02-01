<?php
/**
 * Define the internationalization functionality
 *
 * @package GP\GP_Login_Customizer
 */

namespace GP\GP_Login_Customizer;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class I18n
 */
class I18n {
	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain(
			'gp',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}

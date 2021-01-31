<?php
/**
 * Plugin init to include dependencies and register classes
 *
 * @package GP\GP_Login_Customizer
 */

namespace GP\GP_Login_Customizer;

/**
 * Class Init
 */
class Init {
	/**
	 * Define the core functionality of the plugin.
	 */
	public function __construct() {
		$this->load_dependencies();
		$this->register();
	}

	/**
	 * Load all dependencies
	 */
	private function load_dependencies() {
		$plugin_dir = GP_LOGIN_CUSTOMIZER_NR_DIR;

		include_once $plugin_dir . 'includes/class-i18n.php';
		include_once $plugin_dir . 'includes/class-admin.php';
		include_once $plugin_dir . 'includes/class-customizer.php';
		include_once $plugin_dir . 'includes/class-login.php';
		include_once $plugin_dir . 'includes/class-utils.php';
	}

	/**
	 * Register all necessary hooks.
	 */
	private function register() {
		$translator = new I18n();
		add_action( 'plugins_loaded', array( $translator, 'load_plugin_textdomain' ) );

		$admin = new Admin();
		add_action( 'init', array( $admin, 'init' ) );

		$customizer = new Customizer();
		add_action( 'init', array( $customizer, 'init' ) );

		$login = new Login();
		add_action( 'init', array( $login, 'init' ) );
	}
}

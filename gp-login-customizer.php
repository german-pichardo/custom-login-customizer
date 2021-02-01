<?php
/**
 * Plugin Name:       Gp Login Customizer
 * Description:       Change default login page, Title, Styles, Logo, etc.
 * Version:           2.0.0
 * Author:            German Pichardo
 * Text Domain:       gp
 * Domain Path:       /languages
 *
 * @package   GP\GP_Login_Customizer
 * @link      https://github.com/german-pichardo/gp-login-customizer
 */

namespace GP\GP_Login_Customizer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'GP_LOGIN_CUSTOMIZER_DIR', plugin_dir_path( __FILE__ ) );
define( 'GP_LOGIN_CUSTOMIZER_URL', plugin_dir_URL( __FILE__ ) );

// Plugin Global information.
require_once GP_LOGIN_CUSTOMIZER_DIR . 'includes/class-info.php';

/**
 * Begins execution of the plugin.
 */
function run_init() {
	include_once GP_LOGIN_CUSTOMIZER_DIR . 'includes/class-init.php';
	new Init();
}

run_init();

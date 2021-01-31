<?php
/**
 * Admin
 *
 * @package GP\GP_Login_Customizer
 */

namespace GP\GP_Login_Customizer;

/**
 * Class Admin
 */
class Admin {

	const SECTION = 'custom_login_section';

	/**
	 * Initialize admin-related functionality.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'admin_menu', [ $this, 'add_menu_item' ] );
	}

	/**
	 * Add page to theme.php menu
	 */
	public function add_menu_item() {
		if ( is_multisite() && is_network_admin() ) {
			return; // Do not use in main_network.
		}

		$menu_slug_url = 'customize.php?autofocus[section]=' . self::SECTION . '';
		// We add simple autoFocus in multiSite.
		// todo: Url redirection do not play well.
		if ( ! is_multisite() ) {
			$menu_slug_url .= '&url=' . rawurlencode( wp_login_url() ) . '&return=' . rawurlencode( wp_login_url() ) . '';
		}

		add_theme_page(
			__( 'Login Customizer', 'gp' ),
			__( 'Login Customizer', 'gp' ),
			'manage_options',
			'' . $menu_slug_url . ''
		);
	}
}

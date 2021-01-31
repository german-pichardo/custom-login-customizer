<?php
/**
 * Login
 *
 * @package GP\GP_Login_Customizer
 */

namespace GP\GP_Login_Customizer;

/**
 * Class Login
 */
class Login {

	/**
	 * Initialize login-related functionality.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'login_errors', array( $this, 'error_message' ) );
		add_filter( 'login_body_class', array( $this, 'login_body_class' ) );
		add_action( 'login_head', array( $this, 'login_head' ) );
		add_action( 'login_headertext', array( $this, 'logo_title' ) );
		add_action( 'login_headerurl', array( $this, 'logo_url' ) );
	}

	/**
	 * Change default logo url wordpress.org
	 *
	 * @return string|void
	 */
	public function logo_url() {
		/**
		 * Filters the logo url.
		 *
		 * @param string $logo_url The logo url.
		 */
		return apply_filters( 'gp_login_customizer_logo_url', home_url() );
	}

	/**
	 * Change default logo title attribute "Powered by WordPress"
	 *
	 * @return mixed|void
	 */
	public function logo_title() {
		/**
		 * Filters the logo title.
		 *
		 * @param string $logo_title The logo title.
		 */
		return apply_filters( 'gp_login_customizer_logo_title', get_option( 'blogname' ) );
	}

	/**
	 * Render the error messages displayed above the login form.
	 *
	 * @return mixed
	 */
	public function error_message() {
		$fallback_error_message = apply_filters( 'gp_login_customizer_fallback_error_message', __( 'ERROR: Incorrect login details.', 'gp' ) );

		return get_theme_mod( 'setting_error_message', $fallback_error_message );
	}

	/**
	 * Prints the HTML head on the login page
	 */
	public function login_head() {
		self::style_form();
		self::style_logo_image();
		self::style_login_type();
		self::style_misc();
		self::style_custom();
	}

	/**
	 * Filters the login page body classes.
	 *
	 * @param array $classes An array of body classes.
	 */
	public function login_body_class( $classes ) {
		$classes[] =  get_theme_mod( 'setting_login_type', '' );

		return $classes;
	}

	/**
	 * Handles login type style.
	 */
	public static function style_login_type() {
		$login_type = get_theme_mod( 'setting_login_type', '' );

		if ( $login_type && ! empty( $login_type ) ) : ?>

			<style type="text/css">
				<?php Utils::generate_css( 'body.login #login', 'background-color', 'setting_form_background_color', '#ffffff' ); ?>

				body.login {
					/*background-position: 320px center;*/
					width:      100%;
					height:     100%;
					min-height: 100%;
				}

				body.login:not(.interim-login) #login {
					width: 360px;
				}

				body.login #login form {
					-webkit-box-shadow: none;
					-moz-box-shadow:    none;
					box-shadow:         none;
					background:         none;
				}

				body.login,
				body.login #login::after {
					content: "";
					clear:   both;
					display: table;
				}

				body.login h1 a {
					margin-bottom: 0;
				}

				body.login .message,
				body.login #login_error {
					margin-left:  auto !important;
					margin-right: auto !important;
					max-width:    80%;
				}

				@media screen and (min-width: 768px) {
					body.login:not(.interim-login) #login {
						min-height: 100%;
					}

					body.login[class*="form-align-"]:not(.interim-login) form {
						border: 0;
					}

					body.login.form-align-left:not(.interim-login) #login {
						margin-left: 0;
					}

					body.login.form-align-right:not(.interim-login) #login {
						margin-right: 0;
					}
				}

				@media screen and (max-width: 767px) {
					<?php Utils::generate_css( 'body.login #login', 'border-radius', 'setting_form_border_radius', '0px' ); ?>

					body.login #login {
						margin: 30px;
					}
				}
			</style>
			<?php
		endif;
	}

	/**
	 * Change default WP logo image
	 *
	 * @return void
	 */
	public static function style_logo_image() {
		$logo_image = get_theme_mod( 'setting_logo_image' );

		if ( $logo_image && ! empty( $logo_image ) ) {
			$logo_image_size      = getimagesize( Utils::get_local_path( $logo_image ) );
			$logo_image_width     = $logo_image_size[0];
			$logo_image_height    = $logo_image_size[1];
			$is_ratio_69          = $logo_image_width > $logo_image_height;
			$logo_background_size = $is_ratio_69 ? '50%% auto' : ( is_array( $logo_image_size ) ? ( $logo_image_width < 160 ? 'auto' : ' auto 80%%' ) : 'contain' );
			$logo_padding_top     = $is_ratio_69 ? '56.25%%' : '75%%';
			$logo_container_width = is_array( $logo_image_size ) ? '100%%' : '60%%';
			?>

			<style type="text/css">
				<?php
				Utils::generate_css( 'body.login h1 a', 'background', '', 'url("' . $logo_image . '") center center no-repeat' );
				Utils::generate_css( 'body.login h1 a', 'background-size', '', $logo_background_size );
				Utils::generate_css( 'body.login h1 a', 'background-position', '', 'center 80%%' );
				Utils::generate_css( 'body.login h1 a', 'width', '', $logo_container_width );
				Utils::generate_css( 'body.login h1 a', 'height', '', '100%%' );
				Utils::generate_css( 'body.login h1 a', 'white-space', '', 'nowrap' );
				Utils::generate_css( 'body.login h1 a', 'font-size', '', '0px' );
				Utils::generate_css( 'body.login h1 a', 'line-height', '', '0px' );
				Utils::generate_css( 'body.login h1 a:before', 'padding-top', '', $logo_padding_top );
				Utils::generate_css( 'body.login h1 a:before', 'content', '', '""' );
				Utils::generate_css( 'body.login h1 a:before', 'display', '', 'block' );
				?>
			</style>

			<?php
		}
	}

	/**
	 * Outputs custom css style for form
	 */
	public static function style_form() {
		?>
		<style type="text/css">

			<?php
				$login_background_image = get_theme_mod( 'setting_login_body_background_image' );

			if ( $login_background_image && ! empty( $login_background_image ) ) {
				Utils::generate_css( 'body.login', 'background', '', 'url("' . $login_background_image . '") center center no-repeat' );
				Utils::generate_css( 'body.login', 'background-size', '', 'cover' );
			}

			Utils::generate_css( 'body.login', 'background-color', 'setting_login_body_background', '#e8e8e7' );
			Utils::generate_css( 'body.login', 'color', 'setting_form_text_color', '#514f4c' );
			Utils::generate_css( 'body.login form', 'border-radius', 'setting_form_border_radius', '0px' );
			Utils::generate_css( 'body.login form', 'background-color', 'setting_form_background_color', '#ffffff' );
			Utils::generate_css( 'body.login label', 'color', 'setting_form_text_color', '#514f4c' );
			Utils::generate_css( 'body.login form .input', 'border-color', 'setting_form_input_border_color', '#e3e5e8' );
			Utils::generate_css( 'body.login form .input', 'color', 'setting_form_text_color', '#514f4c' );
			Utils::generate_css( 'body.login form .input', 'border-width', 'setting_form_input_border_width', '2px' );
			Utils::generate_css( 'body.login form .input,body.login input[type="text"]', 'border-radius', 'setting_form_input_border_radius', '0px' );
			Utils::generate_css( 'body.login .message, body.login #login_error, body.login input[type=checkbox]:checked, input[type="checkbox"]:focus', 'border-color', 'setting_form_secondary_color', '#ffcc4d' );
			Utils::generate_css( 'body.login input[type=checkbox]:checked:before', 'color', 'setting_form_secondary_color', '#ffcc4d' );
			Utils::generate_css( 'body.login #nav a, body.login #backtoblog a', 'color', 'setting_form_link_color', '#72777c' );
			Utils::generate_css( '.wp-core-ui .button-primary', 'background-color', 'setting_form_button_bg_color', '#9bbca9', '', ' !important' );
			Utils::generate_css( '.wp-core-ui .button-primary', 'border-color', 'setting_form_button_bg_color', '#9bbca9', '', ' !important' );
			Utils::generate_css( '.wp-core-ui .button-primary', 'border-radius', 'setting_button_border_radius', '', '', ' !important' );
			Utils::generate_css( '.wp-core-ui .button-primary', 'color', 'setting_form_button_text_color', '#ffffff' );
			?>
		</style>
		<?php
	}

	/**
	 * Outputs custom css style
	 */
	public static function style_custom() {
		$styles = get_theme_mod( 'setting_additional_css', '' );

		if ( $styles && ! empty( $styles ) ) :
			$type_attr = current_theme_supports( 'html5', 'style' ) ? '' : ' type="text/css"';
			?>
			<style<?php echo $type_attr; // phpcs:ignore ?> id="gp-customizer-custom-css">
				<?php echo strip_tags( $styles ); // phpcs:ignore ?>
			</style>
			<?php
		endif;
	}

	/**
	 * Outputs miscellaneous style
	 */
	public static function style_misc() {
		?>
		<style type="text/css">
			body.login form {
				padding: 40px 30px;
			}

			body.login label {
				font-weight: 700;
				font-size:   0.9em;
			}

			body.login form .input,
			body.login .login input[type=text] {
				padding:            6px 15px;
				font-size:          14px;
				-webkit-box-shadow: none;
				-moz-box-shadow:    none;
				box-shadow:         none;
				font-weight:        normal;
			}

			.wp-core-ui .button-primary,
			.wp-core-ui .button-primary:hover,
			.wp-core-ui .button-primary:focus,
			.wp-core-ui .button-primary:active {
				text-shadow:        none;
				-webkit-box-shadow: none;
				-moz-box-shadow:    none;
				box-shadow:         none;
			}

			.wp-core-ui .button.button-large,
			.wp-core-ui .button-group.button-large .button {
				float:      none;
				width:      100%;
				display:    block;
				margin-top: 20px;
				height:     40px;
			}

			input[type="text"]:focus,
			input[type="email"]:focus,
			input[type="search"]:focus,
			input[type="checkbox"]:focus {
				-webkit-box-shadow: none;
				-moz-box-shadow:    none;
				box-shadow:         none;
			}

			#login form p.submit {
				display: block;
				clear:   both;
			}

			#login form p ~ p {
				clear: both;
				float: none;
			}

		</style>
		<?php
	}
}

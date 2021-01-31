<?php
/**
 * Utils
 *
 * @package GP\GP_Login_Customizer
 */

namespace GP\GP_Login_Customizer;

/**
 * Class Utils
 */
class Utils {
	/**
	 * Generates CSS.
	 *
	 * @param string $selector       The CSS selector.
	 * @param string $style          The CSS style.
	 * @param string $mod_name       Theme modification name.
	 * @param string $fallback_value Theme modification default value.
	 * @param string $prefix         The CSS prefix.
	 * @param string $postfix        The CSS suffix.
	 * @param bool   $echo           Echo the styles.
	 *
	 * @return string
	 */
	public static function generate_css( $selector, $style, $mod_name, $fallback_value, $prefix = '', $postfix = '', $echo = true ) {
		$return = '';
		$mod    = get_theme_mod( $mod_name, $fallback_value );

		if ( ! empty( $mod ) ) {
			$return = sprintf(
				'%s { %s:%s; }',
				$selector,
				$style,
				$prefix . $mod . $postfix
			);

			if ( $echo ) {
				echo $return; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		return $return;
	}

	/**
	 * Absolute path
	 *
	 * @param string $url The image url.
	 *
	 * @return false|string
	 */
	public static function get_local_path( $url ) {
		return realpath( $_SERVER['DOCUMENT_ROOT'] . wp_parse_url( $url, PHP_URL_PATH ) );
	}
}

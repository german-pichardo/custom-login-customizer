<?php
/**
 * Plugin Name: Gp Login Customizer
 * Description: Change default login URL, Title, Styles, Logo, etc. Go to : Appearance -> Themes -> Customize -> Login page
 * Version: 1.2.1
 * Author: German Pichardo
 * Author URI: http://www.german-pichardo.com
 * Text Domain: custom-login-settings
 */
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die;
}

require_once plugin_dir_path(__FILE__) . 'admin/class-gp-login-customizer-admin.php'; // Admin
require_once plugin_dir_path(__FILE__) . 'front/class-gp-login-customizer-front.php'; // Front

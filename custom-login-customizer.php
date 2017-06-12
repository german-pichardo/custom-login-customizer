<?php
/**
 * Plugin Name: Custom Login Customizer
 * Description: Change default login URL, Title, Styles, Logo, etc. Go to : Appearance -> Themes -> Customize -> Login page
 * Version: 1.0
 * Author: German Pichardo
 * Author URI: http://www.german-pichardo.com
 * Text Domain: custom-login-settings
 */
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die;
}
if (!class_exists(' CustomLoginCustomizer')) {
    class  CustomLoginCustomizer
    {
        public function __construct()
        {
            add_action('admin_menu', array($this, 'custom_login_theme_menu_item'));
            // ADMIN : Register customize options
            add_action('customize_register', array($this, 'custom_login_settings_customize_register'));
            add_action('login_head', array($this, 'custom_login_logo'));
            add_action('login_headerurl', array($this, 'custom_login_url'));
            add_action('login_headertitle', array($this, 'custom_login_title'));
            add_action('login_errors', array($this, 'custom_login_generic_error_message'));
            add_action('login_head', array($this, 'custom_login_css'));

        }

        /*
         * Add page to theme.php menu
         * @todo We need to find a way to force the customizer view to Page login. Autoload and URL do not play well.
         */
        public static function custom_login_theme_menu_item()
        {
            if (is_multisite() && is_main_site()) return; // Do not use in main_network

            $menu_slug_url = 'customize.php?autofocus[section]=custom_login_section';
            // We add simple autoFocus in multiSite - Url redirection do not play well
            if (!is_multisite()) {
                $menu_slug_url .= '&url=' . urlencode(wp_login_url()) . '&return=' . urlencode(wp_login_url()) . '';
            }
            add_theme_page(__('Page Login', 'custom-login-settings'), __('Page Login', 'custom-login-settings'), 'manage_options', '' . $menu_slug_url . '');
        }
        //  =====================================================
        //  = ADMIN: Customize options                          =
        //  =====================================================
        public static function custom_login_settings_customize_register($wp_customize)
        {
            $wp_customize->add_section('custom_login_section', array(
                'title' => __('Login page', 'custom-login-settings'),
                'priority' => 35,
            ));

            //  =====================================================
            //  = Image Upload    setting_login_logo_image          =
            //  =====================================================
            $wp_customize->add_setting('setting_login_logo_image', array(
                'default' => has_site_icon() ? get_site_icon_url(150) : esc_url(get_site_icon_url(64, admin_url('images/w-logo-blue.png'))),
            ));

            $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'setting_login_logo_image', array(
                'label' => __('Login logo', 'custom-login-settings'),
                'description' => __('Ideal size: 110x110px, maximum size 150px  )', 'custom-login-settings'),
                'section' => 'custom_login_section',
                'settings' => 'setting_login_logo_image',
            )));

            //  =====================================================
            //  = Color Picker : setting_login_body_background      =
            //  =====================================================
            $wp_customize->add_setting('setting_login_body_background', array(
                'default' => '#e8e8e7',
                'sanitize_callback' => 'sanitize_hex_color',
            ));

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'setting_login_body_background', array(
                'label' => __('Body background color', 'custom-login-settings'),
                'section' => 'custom_login_section',
                'settings' => 'setting_login_body_background',
            )));

            //  =====================================================
            //  = Color Picker : setting_form_label_color           =
            //  =====================================================
            $wp_customize->add_setting('setting_form_label_color', array(
                'default' => '#72777c',
                'sanitize_callback' => 'sanitize_hex_color',
            ));

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'setting_form_label_color', array(
                'label' => __('Body Default Font Colo', 'custom-login-settings'),
                'section' => 'custom_login_section',
                'settings' => 'setting_form_label_color',
            )));

            //  =====================================================
            //  = Text Input setting_login_generic_error_message    =
            //  =====================================================
            $wp_customize->add_setting('setting_login_generic_error_message', array(
                'default' => 'ERROR: Incorrect login details.',
            ));

            $wp_customize->add_control('setting_login_generic_error_message', array(
                'label' => __('Error message', 'custom-login-settings'),
                'description' => __('For security reasons it\'s better to insert a generic message instead of precising "Invalid username" or "Invalid password".', 'custom-login-settings'),
                'section' => 'custom_login_section',
                'settings' => 'setting_login_generic_error_message',
                'type' => 'text',

            ));

            //  =====================================================
            //  = Color Picker : setting_form_button_text_color     =
            //  =====================================================
            $wp_customize->add_setting('setting_form_button_text_color', array(
                'default' => '#ffffff',
                'sanitize_callback' => 'sanitize_hex_color',
            ));

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'setting_form_button_text_color', array(
                'label' => __('Button text color', 'custom-login-settings'),
                'section' => 'custom_login_section',
                'settings' => 'setting_form_button_text_color',
            )));

            //  =====================================================
            //  = Color Picker : setting_form_primary_color         =
            //  =====================================================
            $wp_customize->add_setting('setting_form_primary_color', array(
                'default' => '#293550',
                'sanitize_callback' => 'sanitize_hex_color',
            ));

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'setting_form_primary_color', array(
                'label' => __('Button background color', 'custom-login-settings'),
                'section' => 'custom_login_section',
                'settings' => 'setting_form_primary_color',
            )));

            //  =====================================================
            //  = Color Picker : setting_form_input_border_color    =
            //  =====================================================
            $wp_customize->add_setting('setting_form_input_border_color', array(
                'default' => '#e3e5e8',
                'sanitize_callback' => 'sanitize_hex_color',
            ));

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'setting_form_input_border_color', array(
                'label' => __('Input field color', 'custom-login-settings'),
                'section' => 'custom_login_section',
                'settings' => 'setting_form_input_border_color',
            )));

            //  =====================================================
            //  = Color Picker : setting_form_input_border_width    =
            //  =====================================================
            $wp_customize->add_setting('setting_form_input_border_width', array('default' => '1px'));
            $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'setting_form_input_border_width', array(
                    'label' => __('Input field border width', 'custom-login-settings'),
                    'section' => 'custom_login_section',
                    'settings' => 'setting_form_input_border_width',
                    'type' => 'select',
                    'choices' => array(
                        '0px' => '0px',
                        '1px' => '1px',
                        '2px' => '2px',
                    )
                )
            ));

            //  =====================================================
            //  = Color Picker : setting_form_secondary_color       =
            //  =====================================================
            $wp_customize->add_setting('setting_form_secondary_color', array(
                'default' => '#ffcc4d',
                'sanitize_callback' => 'sanitize_hex_color',
            ));

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'setting_form_secondary_color', array(
                'label' => __('Secondary color', 'custom-login-settings'),
                'description' => __('Messages border and Checkbox', 'custom-login-settings'),
                'section' => 'custom_login_section',
                'settings' => 'setting_form_secondary_color',

            )));

            //  =====================================================
            //  = Text Input setting_login_additional_css    =
            //  =====================================================
            $wp_customize->add_setting('setting_login_additional_css', array(
                'default' => '/*You can add your own CSS here.*/',
            ));

            $wp_customize->add_control('setting_login_additional_css', array(
                'label' => __('Additional CSS', 'custom-login-settings'),
                'description' => __('', 'custom-login-settings'),
                'section' => 'custom_login_section',
                'settings' => 'setting_login_additional_css',
                'type' => 'textarea',
                'input_attrs' => array(
                    'class' => 'code',
                )

            ));

        }

        //  =====================================================
        //  = LOGIN PAGE:                                       =
        //  =====================================================
        // Change default WP logo image (Site icon or fallback image)
        public static function custom_login_logo()
        {

            $custom_logo_image = get_theme_mod('setting_login_logo_image', has_site_icon() ? get_site_icon_url(150) : esc_url(get_site_icon_url(64, admin_url('images/w-logo-blue.png'))));
            if (!empty($custom_logo_image)) {
                $custom_logo_image_size = getimagesize($custom_logo_image);
                $custom_logo_image_width = $custom_logo_image_size[0] . 'px';
                $custom_logo_image_height = $custom_logo_image_size[1] . 'px';

                echo '<style type="text/css">
                    body.login h1 a {
                        background: url("' . $custom_logo_image . '") center center no-repeat !important;
                        -webkit-background-size: ' . $custom_logo_image_width . ' ' . $custom_logo_image_height . ' !important;
                        background-size: ' . $custom_logo_image_width . ' ' . $custom_logo_image_height . ' !important;
                        width: ' . $custom_logo_image_width . ';
                        height:' . $custom_logo_image_height . ';
                    }
                    </style>
                ';
            }

        }

        // Change default url link wordpress.org from logo
        public static function custom_login_url()
        {
            return home_url();
        }

        // Change default logo title attribute "Powered by Wordpress"
        public static function custom_login_title()
        {
            return get_option('blogname');
        }

        // For security reasons it's better to insert a generic message instead of precising "Invalid username" or "Invalid password".
        public static function custom_login_generic_error_message()
        {
            return get_theme_mod('setting_login_generic_error_message', __('ERROR: Incorrect login details.', 'custom-login-settings'));
        }

        // Add custom css styles : external css or inline css to overwrite default form styles
        public static function custom_login_css()
        { ?>
            <style id="custom_login_css" type="text/css">

                <?php self::generate_css('body.login', 'background-color', 'setting_login_body_background', '#e8e8e7'); ?>
                <?php self::generate_css('body.login', 'color', 'setting_form_label_color', '#514f4c'); ?>

                <?php self::generate_css('body.login label', 'color', 'setting_form_label_color', '#514f4c'); ?>

                <?php self::generate_css('body.login form .input', 'border-color', 'setting_form_input_border_color', '#e3e5e8'); ?>
                <?php self::generate_css('body.login form .input', 'color', 'setting_form_label_color', '#514f4c'); ?>
                <?php self::generate_css('body.login form .input', 'border-width', 'setting_form_input_border_width', '2px'); ?>

                <?php self::generate_css('.wp-core-ui .button-primary', 'background-color', 'setting_form_primary_color', '#293550','',' !important'); ?>
                <?php self::generate_css('.wp-core-ui .button-primary', 'border-color', 'setting_form_primary_color', '#293550','',' !important'); ?>
                <?php self::generate_css('.wp-core-ui .button-primary', 'color', 'setting_form_button_text_color', '#ffffff'); ?>

                <?php self::generate_css('body.login .message, body.login #login_error, body.login input[type=checkbox]:checked, input[type="checkbox"]:focus', 'border-color', 'setting_form_secondary_color', '#ffcc4d'); ?>
                <?php self::generate_css('body.login input[type=checkbox]:checked:before', 'color', 'setting_form_secondary_color', '#ffcc4d'); ?>
                body.login form {
                    padding: 40px 30px;
                }

                body.login label {
                    font-weight: 700;
                    font-size: 0.9em;
                }

                body.login input[type="text"] {
                    -webkit-border-radius: 0;
                }

                body.login form .input,
                body.login .login input[type=text] {
                    height: 46px;
                    padding: 6px 15px;
                    margin-top: 10px;
                    font-size: 14px;
                    line-height: 1.5;
                    -webkit-box-shadow: none;
                    -moz-box-shadow: none;
                    box-shadow: none;
                    font-weight: normal;
                }

                .wp-core-ui .button-primary,
                .wp-core-ui .button-primary:hover,
                .wp-core-ui .button-primary:focus,
                .wp-core-ui .button-primary:active {
                    text-shadow: none;
                    -webkit-box-shadow: none;
                    -moz-box-shadow: none;
                    box-shadow: none;
                }

                input[type="text"]:focus,
                input[type="email"]:focus,
                input[type="search"]:focus,
                input[type="checkbox"]:focus {
                    -webkit-box-shadow: none;
                    -moz-box-shadow: none;
                    box-shadow: none;
                }

                /*Start Additional CSS*/
                <?php if(!empty(get_theme_mod( 'setting_login_additional_css'))) {
                    print get_theme_mod( 'setting_login_additional_css','' );
                } ?>
                /*End Additional CSS*/
            </style>
            <?php
        }

        public static function generate_css($selector, $style, $mod_name, $fallback_value, $prefix = '', $postfix = '', $echo = true)
        {
            $return = '';
            $mod = get_theme_mod($mod_name, $fallback_value);
            if (!empty($mod)) {
                $return = sprintf('%s { %s:%s; }',
                    $selector,
                    $style,
                    $prefix . $mod . $postfix
                );
                if ($echo) {
                    echo $return;
                }
            }
            return $return;
        }

    }

}

$custom_login_customizer = new CustomLoginCustomizer();

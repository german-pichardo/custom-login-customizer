<?php
/**
 * Plugin Name: Gp Login Customizer
 * Description: Change default login URL, Title, Styles, Logo, etc. Go to : Appearance -> Themes -> Customize -> Login page
 * Version: 1.0.1
 * Author: German Pichardo
 * Author URI: http://www.german-pichardo.com
 * Text Domain: custom-login-settings
 */
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die;
}
if (!class_exists(' GpLoginCustomizer')) {
    class GpLoginCustomizer
    {
        private $section_handle = 'custom_login_section';

        public static $text_domain = 'gp-login-customizer';

        public function __construct()
        {
            add_action('admin_menu', [$this, 'add_menu_item']);
            // ADMIN : Register customize options
            add_action('customize_register', [$this, 'register_settings']);
            add_action('login_headerurl', [$this, 'logo_url']);
            add_action('login_headertitle', [$this, 'logo_title']);
            add_action('login_errors', [$this, 'error_message']);
            add_action('login_head', [$this, 'login_head']);
        }

        public function login_head()
        {
            $this->logo_mod_style();
            $this->login_mod_style();
            $this->login_overwrite_style();
            $this->login_additional_css();
        }

        /*
         * Add page to theme.php menu
         * @TODO We need to find a way to force the customizer view to Login Customizer page. Autoload and URL do not play well.
         */
        public function add_menu_item()
        {
            if (is_multisite() && is_network_admin()) return; // Do not use in main_network

            $menu_slug_url = 'customize.php?autofocus[section]=' . $this->section_handle . '';
            // We add simple autoFocus in multiSite - Url redirection do not play well
            if (!is_multisite()) {
                $menu_slug_url .= '&url=' . urlencode(wp_login_url()) . '&return=' . urlencode(wp_login_url()) . '';
            }
            add_theme_page(__('Login Customizer', self::$text_domain), __('Login Customizer', self::$text_domain), 'manage_options', '' . $menu_slug_url . '');
        }
        //  =====================================================
        //  = ADMIN: Customize options                          =
        //  =====================================================
        public function register_settings($wp_customize)
        {
            $wp_customize->add_section($this->section_handle, [
                'title' => __('Login Customizer', self::$text_domain),
                'priority' => 35,
            ]);

            //  =====================================================
            //  = Image Upload    setting_logo_image          =
            //  =====================================================
            $wp_customize->add_setting('setting_logo_image', [
                'default' => has_site_icon() ? get_site_icon_url(150) : '',
            ]);

            $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'setting_logo_image', [
                'label' => __('Login logo', self::$text_domain),
                'description' => __('Ideal size: squared transparent png 110x110px, maximum size 150px  )', self::$text_domain),
                'section' => $this->section_handle,
                'settings' => 'setting_logo_image',
            ]));

            //  =====================================================
            //  = Color Picker : setting_login_body_background      =
            //  =====================================================
            $wp_customize->add_setting('setting_login_body_background', [
                'default' => '#e8e8e7',
                'sanitize_callback' => 'sanitize_hex_color',
            ]);

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'setting_login_body_background', [
                'label' => __('Body background color', self::$text_domain),
                'section' => $this->section_handle,
                'settings' => 'setting_login_body_background',
            ]));

            //  =====================================================
            //  = Color Picker : setting_form_label_color           =
            //  =====================================================
            $wp_customize->add_setting('setting_form_label_color', [
                'default' => '#72777c',
                'sanitize_callback' => 'sanitize_hex_color',
            ]);

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'setting_form_label_color', [
                'label' => __('Body Default Font Colo', self::$text_domain),
                'section' => $this->section_handle,
                'settings' => 'setting_form_label_color',
            ]));

            //  =====================================================
            //  = Text Input setting_error_message    =
            //  =====================================================
            $wp_customize->add_setting('setting_error_message', [
                'default' => 'ERROR: Incorrect login details.',
            ]);

            $wp_customize->add_control('setting_error_message', [
                'label' => __('Error message', self::$text_domain),
                'description' => __('For security reasons it\'s better to insert a generic message instead of precising "Invalid username" or "Invalid password".', self::$text_domain),
                'section' => $this->section_handle,
                'settings' => 'setting_error_message',
                'type' => 'text',

            ]);

            //  =====================================================
            //  = Color Picker : setting_form_button_text_color     =
            //  =====================================================
            $wp_customize->add_setting('setting_form_button_text_color', [
                'default' => '#ffffff',
                'sanitize_callback' => 'sanitize_hex_color',
            ]);

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'setting_form_button_text_color', [
                'label' => __('Button text color', self::$text_domain),
                'section' => $this->section_handle,
                'settings' => 'setting_form_button_text_color',
            ]));

            //  =====================================================
            //  = Color Picker : setting_form_primary_color         =
            //  =====================================================
            $wp_customize->add_setting('setting_form_primary_color', [
                'default' => '#293550',
                'sanitize_callback' => 'sanitize_hex_color',
            ]);

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'setting_form_primary_color', [
                'label' => __('Button background color', self::$text_domain),
                'section' => $this->section_handle,
                'settings' => 'setting_form_primary_color',
            ]));

            //  =====================================================
            //  = Color Picker : setting_form_input_border_color    =
            //  =====================================================
            $wp_customize->add_setting('setting_form_input_border_color', [
                'default' => '#e3e5e8',
                'sanitize_callback' => 'sanitize_hex_color',
            ]);

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'setting_form_input_border_color', [
                'label' => __('Input field color', self::$text_domain),
                'section' => $this->section_handle,
                'settings' => 'setting_form_input_border_color',
            ]));

            //  =====================================================
            //  = Color Picker : setting_form_input_border_width    =
            //  =====================================================
            $wp_customize->add_setting('setting_form_input_border_width', ['default' => '1px']);
            $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'setting_form_input_border_width', [
                    'label' => __('Input field border width', self::$text_domain),
                    'section' => $this->section_handle,
                    'settings' => 'setting_form_input_border_width',
                    'type' => 'select',
                    'choices' => [
                        '0px' => '0px',
                        '1px' => '1px',
                        '2px' => '2px',
                    ]
                ]
            ));

            //  =====================================================
            //  = Color Picker : setting_form_secondary_color       =
            //  =====================================================
            $wp_customize->add_setting('setting_form_secondary_color', [
                'default' => '#ffcc4d',
                'sanitize_callback' => 'sanitize_hex_color',
            ]);

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'setting_form_secondary_color', [
                'label' => __('Secondary color', self::$text_domain),
                'description' => __('Messages border and Checkbox', self::$text_domain),
                'section' => $this->section_handle,
                'settings' => 'setting_form_secondary_color',

            ]));

            //  =====================================================
            //  = Text Input setting_additional_css    =
            //  =====================================================
            $wp_customize->add_setting('setting_additional_css', [
                'default' => '/*You can add your own CSS here.*/',
            ]);

            $wp_customize->add_control('setting_additional_css', [
                'label' => __('Additional CSS', self::$text_domain),
                'description' => __('', self::$text_domain),
                'section' => $this->section_handle,
                'settings' => 'setting_additional_css',
                'type' => 'textarea',
                'input_attrs' => [
                    'class' => 'code',
                ]

            ]);

        }


        // Change default url link wordpress.org from logo
        public static function logo_url()
        {
            return home_url();
        }

        // Change default logo title attribute "Powered by Wordpress"
        public static function logo_title()
        {
            return get_option('blogname');
        }

        // For security reasons it's better to insert a generic message instead of precising "Invalid username" or "Invalid password".
        public static function error_message()
        {
            return get_theme_mod('setting_error_message', __('ERROR: Incorrect login details.', self::$text_domain));
        }

        // Change default WP logo image
        public static function logo_mod_style()
        {
            $logo_image = get_theme_mod('setting_logo_image');

            if ($logo_image && !empty($logo_image)) {
                $logo_image_size = getimagesize($logo_image);
                $logo_image_width = $logo_image_size[0];
                $logo_image_height = $logo_image_size[1];

                $is_ratio_69 = $logo_image_width > $logo_image_height;

                $logo_background_size = $is_ratio_69 ? '60% auto' : (is_array($logo_image_size) ? ' auto 80%' : 'contain');
                $logo_padding_top = $is_ratio_69 ? '56.25%' : '75%';
                $logo_container_width = is_array($logo_image_size) ? '100%' : '60%'; ?>

                <style type="text/css">
                    <?php self::generate_css('body.login h1 a', 'background', '', 'url("' . $logo_image . '") center center no-repeat'); ?>
                    <?php self::generate_css('body.login h1 a', 'background-size', '', $logo_background_size.'%%'); ?>
                    <?php self::generate_css('body.login h1 a', 'background-position', '', 'center 80%%%'); ?>
                    <?php self::generate_css('body.login h1 a', 'width', '', $logo_container_width.'%%'); ?>
                    <?php self::generate_css('body.login h1 a', 'height', '', '100%%%'); ?>
                    <?php self::generate_css('body.login h1 a', 'white-space', '', 'nowrap'); ?>
                    <?php self::generate_css('body.login h1 a', 'font-size', '', '0px'); ?>
                    <?php self::generate_css('body.login h1 a', 'line-height', '', '0px'); ?>
                    /**/
                    <?php self::generate_css('body.login h1 a:before', 'padding-top', '', $logo_padding_top.'%%'); ?>
                    <?php self::generate_css('body.login h1 a:before', 'content', '', '""'); ?>
                    <?php self::generate_css('body.login h1 a:before', 'display', '', 'block'); ?>
                </style>

            <?php }
        }

        // Add custom css styles : external css or inline css to overwrite default form styles
        public static function login_mod_style()
        { ?>
            <style id="login_mod_style" type="text/css">

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

            </style>
        <?php }

        // Add custom css styles : external css or inline css to overwrite default form styles
        public static function login_overwrite_style()
        { ?>
            <style id="login_overwrite_style" type="text/css">
                <!--/*Overwrite style*/-->
                body.login form {
                    padding: 40px 30px;
                }

                body.login label {
                    font-weight: 700;
                    font-size:   0.9em;
                }

                body.login input[type="text"] {
                    -webkit-border-radius: 0;
                }

                body.login form .input,
                body.login .login input[type=text] {
                    height:             46px;
                    padding:            6px 15px;
                    margin-top:         10px;
                    font-size:          14px;
                    line-height:        1.5;
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

                input[type="text"]:focus,
                input[type="email"]:focus,
                input[type="search"]:focus,
                input[type="checkbox"]:focus {
                    -webkit-box-shadow: none;
                    -moz-box-shadow:    none;
                    box-shadow:         none;
                }

            </style>
        <?php }

        // Add custom css styles : external css or inline css to overwrite default form styles
        public static function login_additional_css()
        {
            if (!empty(get_theme_mod('setting_additional_css'))) { ?>

                <style id="login_additional_css" type="text/css">
                    /*Start Additional CSS*/
                    <?php print get_theme_mod( 'setting_additional_css','' ); ?>
                    /*End Additional CSS*/
                </style>

            <?php }
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

$gp_login_customizer = new GpLoginCustomizer();

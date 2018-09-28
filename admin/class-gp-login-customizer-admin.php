<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die;
}
if (!class_exists(' GpLoginCustomizerAdmin')) {
    class GpLoginCustomizerAdmin
    {
        private $section_handle = 'custom_login_section';

        public static $text_domain = 'gp-login-customizer';

        public function __construct()
        {
            add_action('admin_menu', [$this, 'add_menu_item']);
            // ADMIN : Register customize options
            add_action('customize_register', [$this, 'register_settings']);
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
            //  = Select : setting_login_type    =
            //  =====================================================
            $wp_customize->add_setting('setting_login_type', ['default' => '']);
            $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'setting_login_type', [
                    'label' => __('Form style', self::$text_domain),
                    'section' => $this->section_handle,
                    'settings' => 'setting_login_type',
                    'type' => 'select',
                    'choices' => [
                        '' => 'Default wordpress style',
                        'form-align-center' => '    Form align center',
                        'form-align-left' => 'Form align left',
                        'form-align-right' => 'Form align right',
                    ]
                ]
            ));

            //  =====================================================
            //  = Image Upload    setting_logo_image          =
            //  =====================================================
            $wp_customize->add_setting('setting_logo_image', [
                'default' => has_site_icon() ? get_site_icon_url(150) : '',
            ]);

            $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'setting_logo_image', [
                'label' => __('Login logo', self::$text_domain),
                'description' => __('Transparent png minimum 150px', self::$text_domain),
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
            //  = Image Upload    setting_login_body_background_image          =
            //  =====================================================
            $wp_customize->add_setting('setting_login_body_background_image', [
                'default' => '',
            ]);

            $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'setting_login_body_background_image', [
                'label' => __('Body background image', self::$text_domain),
                'description' => __('', self::$text_domain),
                'section' => $this->section_handle,
                'settings' => 'setting_login_body_background_image',
            ]));

            //  =====================================================
            //  = Color Picker : setting_form_background_color           =
            //  =====================================================
            $wp_customize->add_setting('setting_form_background_color', [
                'default' => '#ffffff',
                'sanitize_callback' => 'sanitize_hex_color',
            ]);

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'setting_form_background_color', [
                'label' => __('Form background Color', self::$text_domain),
                'section' => $this->section_handle,
                'settings' => 'setting_form_background_color',
            ]));

            //  =====================================================
            //  = Color Picker : setting_form_text_color           =
            //  =====================================================
            $wp_customize->add_setting('setting_form_text_color', [
                'default' => '#72777c',
                'sanitize_callback' => 'sanitize_hex_color',
            ]);

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'setting_form_text_color', [
                'label' => __('Form text Color', self::$text_domain),
                'section' => $this->section_handle,
                'settings' => 'setting_form_text_color',
            ]));

            //  =====================================================
            //  = Select : setting_form_border_radius    =
            //  =====================================================
            $wp_customize->add_setting('setting_form_border_radius', ['default' => '']);
            $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'setting_form_border_radius', [
                    'label' => __('Form border radius', self::$text_domain),
                    'section' => $this->section_handle,
                    'settings' => 'setting_form_border_radius',
                    'type' => 'select',
                    'choices' => [
                        '0px' => 'none',
                        '5px' => 'Small',
                        '10px' => 'Medium',
                        '20px' => 'Large',
                    ]
                ]
            ));

            //  =====================================================
            //  = Color Picker : setting_form_button_bg_color         =
            //  =====================================================
            $wp_customize->add_setting('setting_form_button_bg_color', [
                'default' => '#9bbca9',
                'sanitize_callback' => 'sanitize_hex_color',
            ]);

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'setting_form_button_bg_color', [
                'label' => __('Button background color', self::$text_domain),
                'section' => $this->section_handle,
                'settings' => 'setting_form_button_bg_color',
            ]));

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
            //  = Select : setting_button_border_radius    =
            //  =====================================================
            $wp_customize->add_setting('setting_button_border_radius', ['default' => '']);
            $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'setting_button_border_radius', [
                    'label' => __('Button border radius', self::$text_domain),
                    'section' => $this->section_handle,
                    'settings' => 'setting_button_border_radius',
                    'type' => 'select',
                    'choices' => [
                        '0px' => 'none',
                        '5px' => 'Small',
                        '10px' => 'Medium',
                        '20px' => 'Large',
                    ]
                ]
            ));

            //  =====================================================
            //  = Color Picker : setting_form_input_border_color    =
            //  =====================================================
            $wp_customize->add_setting('setting_form_input_border_color', [
                'default' => '#e3e5e8',
                'sanitize_callback' => 'sanitize_hex_color',
            ]);

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'setting_form_input_border_color', [
                'label' => __('Input border color', self::$text_domain),
                'section' => $this->section_handle,
                'settings' => 'setting_form_input_border_color',
            ]));

            //  =====================================================
            //  = Select : setting_form_input_border_width    =
            //  =====================================================
            $wp_customize->add_setting('setting_form_input_border_width', ['default' => '1px']);
            $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'setting_form_input_border_width', [
                    'label' => __('Input border width', self::$text_domain),
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
            //  = Select : setting_form_input_border_radius    =
            //  =====================================================
            $wp_customize->add_setting('setting_form_input_border_radius', ['default' => '1px']);
            $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'setting_form_input_border_radius', [
                    'label' => __('Input border radius', self::$text_domain),
                    'section' => $this->section_handle,
                    'settings' => 'setting_form_input_border_radius',
                    'type' => 'select',
                    'choices' => [
                        '0px' => 'none',
                        '5px' => 'Small',
                        '10px' => 'Medium',
                        '20px' => 'Large',
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
            //  = Color Picker : setting_form_link_color     =
            //  =====================================================
            $wp_customize->add_setting('setting_form_link_color', [
                'default' => '#72777c',
                'sanitize_callback' => 'sanitize_hex_color',
            ]);

            $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'setting_form_link_color', [
                'label' => __('Link color', self::$text_domain),
                'description' => __('"Lost your password?" and "← Back to Site" links', self::$text_domain),
                'section' => $this->section_handle,
                'settings' => 'setting_form_link_color',
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


    }

}

$gp_login_customizer_admin = new GpLoginCustomizerAdmin();

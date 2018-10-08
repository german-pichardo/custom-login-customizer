<?php
// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    die;
}
if (!class_exists(' GpLoginCustomizerFront')) {
    class GpLoginCustomizerFront
    {
        public static $text_domain = 'gp-login-customizer';

        public function __construct()
        {
            add_action('login_headerurl', [$this, 'logo_url']);
            add_action('login_headertitle', [$this, 'logo_title']);
            add_action('login_errors', [$this, 'error_message']);
            add_action('login_head', [$this, 'login_head']);
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

        public function login_head()
        {
            $this->logo_mod_style();
            $this->login_mod_style();
            $this->login_overwrite_style();
            $this->login_mod_additional_style();
            $this->login_type();
        }

        public function login_type()
        {
            $form_type = get_theme_mod('setting_login_type', '');

            if ($form_type && !empty($form_type)) { ?>
                <script type="text/javascript">
                    window.onload = function () {
                        document.body.classList.add('<?php echo $form_type; ?>')
                    };
                </script>

                <style type="text/css">

                    body.login {
                        /*background-position: 320px center;*/
                        width:      100%;
                        height:     100%;
                        min-height: 100%;
                    }

                    body.login #login {
                        background-color: #fff;
                    }

                    body.login:not(.interim-login) #login {
                        width: 360px;
                    }

                    <?php self::generate_css('body.login #login', 'background-color', 'setting_form_background_color', '#ffffff'); ?>

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

                        .login.form-align-left:not(.interim-login) #login {
                            margin-left: 0;
                        }

                        .login.form-align-right:not(.interim-login) #login {
                            margin-right: 0;
                        }
                    }

                    @media screen and (max-width: 767px) {
                    <?php self::generate_css('body.login #login', 'border-radius', 'setting_form_border_radius', '0px'); ?>
                        body.login #login {
                            margin: 30px;
                        }
                    }
                </style>
            <?php }
        }

        // Change default WP logo image
        public static function logo_mod_style()
        {
            $logo_image = get_theme_mod('setting_logo_image');

            if ($logo_image && !empty($logo_image)) {
                $logo_image_size = getimagesize(self::get_local_path($logo_image));
                $logo_image_width = $logo_image_size[0];
                $logo_image_height = $logo_image_size[1];

                $is_ratio_69 = $logo_image_width > $logo_image_height;
                
                $logo_background_size = $is_ratio_69 ? '50%% auto' : (is_array($logo_image_size) ? $logo_image_width < 160 ? 'auto': ' auto 80%%' : 'contain');
                $logo_padding_top = $is_ratio_69 ? '56.25%%' : '75%%';
                $logo_container_width = is_array($logo_image_size) ? '100%%' : '60%%'; ?>

                <style type="text/css">
                    <?php self::generate_css('body.login h1 a', 'background', '', 'url("' . $logo_image . '") center center no-repeat'); ?>
                    <?php self::generate_css('body.login h1 a', 'background-size', '', $logo_background_size); ?>
                    <?php self::generate_css('body.login h1 a', 'background-position', '', 'center 80%%'); ?>
                    <?php self::generate_css('body.login h1 a', 'width', '', $logo_container_width); ?>
                    <?php self::generate_css('body.login h1 a', 'height', '', '100%%'); ?>
                    <?php self::generate_css('body.login h1 a', 'white-space', '', 'nowrap'); ?>
                    <?php self::generate_css('body.login h1 a', 'font-size', '', '0px'); ?>
                    <?php self::generate_css('body.login h1 a', 'line-height', '', '0px'); ?>
                    /**/
                    <?php self::generate_css('body.login h1 a:before', 'padding-top', '', $logo_padding_top); ?>
                    <?php self::generate_css('body.login h1 a:before', 'content', '', '""'); ?>
                    <?php self::generate_css('body.login h1 a:before', 'display', '', 'block'); ?>
                </style>

            <?php }
        }

        public static function login_mod_style()
        { ?>
            <style id="login_mod_style" type="text/css">

                <?php
                    $login_background_image = get_theme_mod('setting_login_body_background_image');
                    if ($login_background_image && !empty($login_background_image)) {
                        self::generate_css('body.login', 'background', '', 'url("' . $login_background_image . '") center center no-repeat');
                        self::generate_css('body.login', 'background-size', '', 'cover');
                    }
                ?>

                <?php self::generate_css('body.login', 'background-color', 'setting_login_body_background', '#e8e8e7'); ?>
                <?php self::generate_css('body.login', 'color', 'setting_form_text_color', '#514f4c'); ?>

                <?php self::generate_css('body.login form', 'border-radius', 'setting_form_border_radius', '0px'); ?>
                <?php self::generate_css('body.login form', 'background-color', 'setting_form_background_color', '#ffffff'); ?>

                <?php self::generate_css('body.login label', 'color', 'setting_form_text_color', '#514f4c'); ?>

                <?php self::generate_css('body.login form .input', 'border-color', 'setting_form_input_border_color', '#e3e5e8'); ?>
                <?php self::generate_css('body.login form .input', 'color', 'setting_form_text_color', '#514f4c'); ?>
                <?php self::generate_css('body.login form .input', 'border-width', 'setting_form_input_border_width', '2px'); ?>
                <?php self::generate_css('body.login form .input,body.login input[type="text"]', 'border-radius', 'setting_form_input_border_radius', '0px'); ?>

                <?php self::generate_css('.wp-core-ui .button-primary', 'background-color', 'setting_form_button_bg_color', '#9bbca9','',' !important'); ?>
                <?php self::generate_css('.wp-core-ui .button-primary', 'border-color', 'setting_form_button_bg_color', '#9bbca9','',' !important'); ?>
                <?php self::generate_css('.wp-core-ui .button-primary', 'border-radius', 'setting_button_border_radius', '','',' !important'); ?>
                <?php self::generate_css('.wp-core-ui .button-primary', 'color', 'setting_form_button_text_color', '#ffffff'); ?>

                <?php self::generate_css('body.login .message, body.login #login_error, body.login input[type=checkbox]:checked, input[type="checkbox"]:focus', 'border-color', 'setting_form_secondary_color', '#ffcc4d'); ?>
                <?php self::generate_css('body.login input[type=checkbox]:checked:before', 'color', 'setting_form_secondary_color', '#ffcc4d'); ?>
                <?php self::generate_css('.login #nav a, .login #backtoblog a', 'color', 'setting_form_link_color', '#72777c'); ?>

            </style>
        <?php }

        // Add custom css styles : external css or inline css to overwrite default form styles
        public static function login_mod_additional_style()
        {
            if (!empty(get_theme_mod('setting_additional_css'))) { ?>

                <style id="login_additional_css" type="text/css">
                    /*Start Additional CSS*/
                    <?php print get_theme_mod( 'setting_additional_css','' ); ?>
                    /*End Additional CSS*/
                </style>

            <?php }
        }

        public static function login_overwrite_style()
        { ?>
            <style id="login_overwrite_style" type="text/css">
                /*Overwrite style*/
                body.login form {
                    padding: 40px 30px;
                }

                body.login label {
                    font-weight: 700;
                    font-size:   0.9em;
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
        <?php }

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

        public static function get_local_path($url)
        {
            return realpath($_SERVER['DOCUMENT_ROOT'] . wp_parse_url( $url, PHP_URL_PATH ));
        }
    }

}

$gp_login_customizer_front = new GpLoginCustomizerFront();

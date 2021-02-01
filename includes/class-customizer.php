<?php
/**
 * Customizer
 *
 * @package GP\GP_Login_Customizer
 */

namespace GP\GP_Login_Customizer;

/**
 * Class Customizer
 */
class Customizer {
	/**
	 * Initialize customizer-related functionality.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'customize_register', array( $this, 'register_settings' ) );
	}

	/**
	 * Theme Customizer settings.
	 *
	 * @param \WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function register_settings( $wp_customize ) {
		$section         = Info::SECTION_CUSTOMIZER;
		$spacing_choices = array(
			'0px'  => esc_html__( 'none', 'gp' ),
			'5px'  => esc_html__( 'Small', 'gp' ),
			'10px' => esc_html__( 'Medium', 'gp' ),
			'20px' => esc_html__( 'Large', 'gp' ),
		);

		$wp_customize->add_section(
			$section,
			array(
				'title'    => Info::get_plugin_title(),
				'priority' => 35,
			)
		);

		$wp_customize->add_setting( 'setting_login_type', array( 'default' => '' ) );
		$wp_customize->add_control(
			new \WP_Customize_Control(
				$wp_customize,
				'setting_login_type',
				array(
					'label'    => esc_html__( 'Form style', 'gp' ),
					'section'  => $section,
					'settings' => 'setting_login_type',
					'type'     => 'select',
					'choices'  => array(
						''                  => esc_html__( 'Default wordpress style', 'gp' ),
						'form-align-center' => esc_html__( 'Form align center', 'gp' ),
						'form-align-left'   => esc_html__( 'Form align left', 'gp' ),
						'form-align-right'  => esc_html__( 'Form align right', 'gp' ),
					),
				)
			)
		);

		$wp_customize->add_setting(
			'setting_logo_image',
			array(
				'default' => has_site_icon() ? get_site_icon_url( 150 ) : '',
			)
		);

		$wp_customize->add_control(
			new \WP_Customize_Image_Control(
				$wp_customize,
				'setting_logo_image',
				array(
					'label'       => esc_html__( 'Login logo', 'gp' ),
					'description' => esc_html__( 'Transparent png minimum 150px', 'gp' ),
					'section'     => $section,
					'settings'    => 'setting_logo_image',
				)
			)
		);

		$wp_customize->add_setting(
			'setting_login_body_background',
			array(
				'default'           => '#e8e8e7',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'setting_login_body_background',
				array(
					'label'    => esc_html__( 'Body background color', 'gp' ),
					'section'  => $section,
					'settings' => 'setting_login_body_background',
				)
			)
		);

		$wp_customize->add_setting(
			'setting_login_body_background_image',
			array(
				'default' => '',
			)
		);

		$wp_customize->add_control(
			new \WP_Customize_Image_Control(
				$wp_customize,
				'setting_login_body_background_image',
				array(
					'label'       => esc_html__( 'Body background image', 'gp' ),
					'description' => '',
					'section'     => $section,
					'settings'    => 'setting_login_body_background_image',
				)
			)
		);

		$wp_customize->add_setting(
			'setting_form_background_color',
			array(
				'default'           => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'setting_form_background_color',
				array(
					'label'    => esc_html__( 'Form background Color', 'gp' ),
					'section'  => $section,
					'settings' => 'setting_form_background_color',
				)
			)
		);

		$wp_customize->add_setting(
			'setting_form_text_color',
			array(
				'default'           => '#72777c',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'setting_form_text_color',
				array(
					'label'    => esc_html__( 'Form text Color', 'gp' ),
					'section'  => $section,
					'settings' => 'setting_form_text_color',
				)
			)
		);

		$wp_customize->add_setting( 'setting_form_border_radius', array( 'default' => '' ) );
		$wp_customize->add_control(
			new \WP_Customize_Control(
				$wp_customize,
				'setting_form_border_radius',
				array(
					'label'    => esc_html__( 'Form border radius', 'gp' ),
					'section'  => $section,
					'settings' => 'setting_form_border_radius',
					'type'     => 'select',
					'choices'  => $spacing_choices,
				)
			)
		);

		$wp_customize->add_setting(
			'setting_form_button_bg_color',
			array(
				'default'           => '#9bbca9',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'setting_form_button_bg_color',
				array(
					'label'    => esc_html__( 'Button background color', 'gp' ),
					'section'  => $section,
					'settings' => 'setting_form_button_bg_color',
				)
			)
		);

		$wp_customize->add_setting(
			'setting_form_button_text_color',
			array(
				'default'           => '#ffffff',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'setting_form_button_text_color',
				array(
					'label'    => esc_html__( 'Button text color', 'gp' ),
					'section'  => $section,
					'settings' => 'setting_form_button_text_color',
				)
			)
		);

		$wp_customize->add_setting( 'setting_button_border_radius', array( 'default' => '' ) );
		$wp_customize->add_control(
			new \WP_Customize_Control(
				$wp_customize,
				'setting_button_border_radius',
				array(
					'label'    => esc_html__( 'Button border radius', 'gp' ),
					'section'  => $section,
					'settings' => 'setting_button_border_radius',
					'type'     => 'select',
					'choices'  => $spacing_choices,
				)
			)
		);

		$wp_customize->add_setting(
			'setting_form_input_border_color',
			array(
				'default'           => '#e3e5e8',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'setting_form_input_border_color',
				array(
					'label'    => esc_html__( 'Input border color', 'gp' ),
					'section'  => $section,
					'settings' => 'setting_form_input_border_color',
				)
			)
		);

		$wp_customize->add_setting( 'setting_form_input_border_width', array( 'default' => '1px' ) );
		$wp_customize->add_control(
			new \WP_Customize_Control(
				$wp_customize,
				'setting_form_input_border_width',
				array(
					'label'    => esc_html__( 'Input border width', 'gp' ),
					'section'  => $section,
					'settings' => 'setting_form_input_border_width',
					'type'     => 'select',
					'choices'  => array(
						'0px' => '0px',
						'1px' => '1px',
						'2px' => '2px',
					),
				)
			)
		);

		$wp_customize->add_setting( 'setting_form_input_border_radius', array( 'default' => '1px' ) );
		$wp_customize->add_control(
			new \WP_Customize_Control(
				$wp_customize,
				'setting_form_input_border_radius',
				array(
					'label'    => esc_html__( 'Input border radius', 'gp' ),
					'section'  => $section,
					'settings' => 'setting_form_input_border_radius',
					'type'     => 'select',
					'choices'  => $spacing_choices,
				)
			)
		);

		$wp_customize->add_setting(
			'setting_form_secondary_color',
			array(
				'default'           => '#ffcc4d',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'setting_form_secondary_color',
				array(
					'label'       => esc_html__( 'Secondary color', 'gp' ),
					'description' => esc_html__( 'Messages border and Checkbox', 'gp' ),
					'section'     => $section,
					'settings'    => 'setting_form_secondary_color',

				)
			)
		);

		$wp_customize->add_setting(
			'setting_form_link_color',
			array(
				'default'           => '#72777c',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
			new \WP_Customize_Color_Control(
				$wp_customize,
				'setting_form_link_color',
				array(
					'label'       => esc_html__( 'Link color', 'gp' ),
					'description' => esc_html__( '"Lost your password?" and "← Back to Site" links', 'gp' ),
					'section'     => $section,
					'settings'    => 'setting_form_link_color',
				)
			)
		);

		$wp_customize->add_setting(
			'setting_error_message',
			array(
				'default' => esc_html__( 'ERROR: Incorrect login details.', 'gp' ),
			)
		);

		$wp_customize->add_control(
			'setting_error_message',
			array(
				'label'       => esc_html__( 'Error message', 'gp' ),
				'description' => esc_html__( 'For security reasons it\'s better to insert a generic message instead of precising "Invalid username" or "Invalid password".', 'gp' ),
				'section'     => $section,
				'settings'    => 'setting_error_message',
				'type'        => 'text',

			)
		);

		$wp_customize->add_setting(
			'setting_additional_css',
			array(
				'default' => esc_html__( '/*You can add your own CSS here.*/', 'gp' ),
			)
		);

		$wp_customize->add_control(
			'setting_additional_css',
			array(
				'label'       => esc_html__( 'Additional CSS', 'gp' ),
				'section'     => $section,
				'settings'    => 'setting_additional_css',
				'type'        => 'textarea',
				'input_attrs' => array(
					'class' => 'code',
				),
			)
		);
	}
}

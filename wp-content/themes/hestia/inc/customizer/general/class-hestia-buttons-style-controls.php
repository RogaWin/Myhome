<?php
/**
 * Customizer buttons controls.
 *
 * @package Hestia
 */

/**
 * Class Hestia_Buttons_Style_Controls
 */
class Hestia_Buttons_Style_Controls extends Hestia_Register_Customizer_Controls {

	/**
	 * Initialize the scripts and anything needed.
	 */
	public function init() {
		parent::init();
		add_action( 'customize_preview_init', array( $this, 'enqueue_customizer_script' ) );
	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @since 1.1.38
	 */
	public function enqueue_customizer_script() {
		wp_enqueue_script( 'hestia_customizer_buttons', get_template_directory_uri() . '/assets/js/admin/buttons-customizer-preview.js', array(), HESTIA_VERSION, true );
	}

	/**
	 * Add controls
	 */
	public function add_controls() {
		$this->add_buttons_style_section();
		$this->add_buttons_style_controls();
	}

	/**
	 * Add the customizer section.
	 */
	private function add_buttons_style_section() {
		$this->add_section(
			new Hestia_Customizer_Section(
				'hestia_buttons_style',
				array(
					'title'    => esc_html__( 'Button', 'hestia' ),
					'panel'    => 'hestia_appearance_settings',
					'priority' => 150,
				)
			)
		);
	}

	/**
	 * Add buttons style controls
	 */
	private function add_buttons_style_controls() {

		/**
		 * Buttons Padding
		 */
		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_button_padding_dimensions',
				array(
					'transport'         => 'postMessage',
					'sanitize_callback' => 'hestia_sanitize_dimension',
					'default'           => apply_filters(
						'hestia_button_padding_dimensions_default',
						json_encode(
							array(
								'desktop' => json_encode(
									array(
										'desktop_vertical' => 15,
										'desktop_horizontal' => 33,
									)
								),
							)
						)
					),
				),
				array(
					'label'       => esc_html__( 'Padding (px)', 'hestia' ),
					'section'     => 'hestia_buttons_style',
					'priority'    => 10,
					'input_attrs' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'Hestia_Customizer_Dimensions'
			)
		);

		/**
		 * Border Radius
		 */
		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_buttons_border_radius',
				array(
					'sanitize_callback' => 'hestia_sanitize_range_value',
					'default'           => apply_filters( 'hestia_buttons_border_radius_default', 3 ),
					'transport'         => 'postMessage',
				),
				array(
					'label'      => esc_html__( 'Border radius', 'hestia' ),
					'section'    => 'hestia_buttons_style',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
					'priority'   => 20,
				),
				'Hestia_Customizer_Range_Value_Control'
			)
		);

		if ( ! class_exists( 'Hestia_Addon_Manager' ) ) {
			$this->add_buttons_additional_controls_upsell();
		}
	}

	/**
	 * Add upsell for buttons style additional controls.
	 */
	private function add_buttons_additional_controls_upsell() {
		/**
		 * Hover effect
		 */
		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_buttons_hover_effect_upsell',
				array(
					'default'           => 'shadow',
					'sanitize_callback' => 'sanitize_text_field',
				),
				array(
					'type'     => 'select',
					'label'    => esc_html__( 'Hover effect', 'hestia' ),
					'section'  => 'hestia_buttons_style',
					'priority' => 25,
					'choices'  => array(
						'shadow' => esc_html__( 'Shadow', 'hestia' ),
						'color'  => esc_html__( 'Color', 'hestia' ),
					),
				)
			)
		);

		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_buttons_text_upgrade',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				),
				array(
					'container_class' => 'upgrade-links',
					'text_before'     => sprintf(
						/* translators: %1$s is the Learn more link, %2$s is the section title */
						__( 'More Options Available for %1$s in the Pro version.', 'hestia' ),
						esc_html__( 'Button', 'hestia' )
					),
					'link'            => tsdk_utmify( 'https://themeisle.com/themes/hestia-pro/upgrade/', 'buttons' ),
					'button_text'     => __( 'Upgrade Now', 'hestia' ),
					'new_tab'         => true,
					'is_button'       => false,
					'shortcut'        => false,
					'section'         => 'hestia_top_bar',
					'focus_type'      => '',
					'priority'        => 30,
					'section'         => 'hestia_buttons_style',
					'button_class'    => 'button button-primary',
				),
				'Hestia_Button'
			)
		);
	}
}

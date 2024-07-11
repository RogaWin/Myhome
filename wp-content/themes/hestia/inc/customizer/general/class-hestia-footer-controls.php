<?php
/**
 * Footer customizer controls manager.
 *
 * @package Hestia
 */

/**
 * Class Hestia_Footer_Controls_Addon
 */
class Hestia_Footer_Controls extends Hestia_Register_Customizer_Controls {
	/**
	 * Add controls.
	 */
	public function add_controls() {
		$this->add_footer_options_section();

		if ( ! class_exists( 'Hestia_Addon_Manager' ) ) {
			$this->add_controls_upsell();
		}
	}

	/**
	 * Add the footer options section.
	 */
	private function add_footer_options_section() {
		$this->add_section(
			new Hestia_Customizer_Section(
				'hestia_footer_content',
				array(
					'title'    => esc_html__( 'Footer Options', 'hestia' ),
					'priority' => 36,
				)
			)
		);
	}

	/**
	 * Add blocked controls as upsell.
	 */
	public function add_controls_upsell() {
		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_nr_footer_widgets_upsell',
				array(
					'default'           => '3',
					'sanitize_callback' => 'sanitize_text_field',
				),
				array(
					'label'    => esc_html__( 'Number of widgets areas', 'hestia' ),
					'section'  => 'hestia_footer_content',
					'priority' => 20,
					'type'     => 'select',
					'choices'  => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
					),
				)
			)
		);

		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_general_credits_upsell',
				array(
					'default'           =>
						sprintf(
						/* translators: %1$s is Theme name wrapped in <a> tag, %2$s is WordPress link */
							esc_html__( '%1$s | Powered by %2$s', 'hestia' ),
							/* translators: %s is Theme name */
							sprintf(
								'<a href="https://themeisle.com/themes/hestia/" target="_blank" rel="nofollow">%s</a>',
								esc_html__( 'Hestia', 'hestia' )
							),
							/* translators: %s is WordPress */
							sprintf( '<a href="http://wordpress.org/" rel="nofollow">%s</a>', esc_html__( 'WordPress', 'hestia' ) )
						),
					'sanitize_callback' => 'wp_kses_post',
					'transport'         => $this->selective_refresh,
				),
				array(
					'label'    => esc_html__( 'Footer Credits', 'hestia' ),
					'section'  => 'hestia_footer_content',
					'priority' => 25,
					'type'     => 'textarea',
				),
				null,
				array(
					'selector'        => 'footer .hestia-bottom-footer-content .copyright',
					'settings'        => 'hestia_general_credits',
					'render_callback' => array( $this, 'copyright_callback' ),
				)
			)
		);

		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_copyright_alignment_upsell',
				array(
					'default'           => 'right',
					'sanitize_callback' => 'hestia_sanitize_alignment_options',
					'transport'         => $this->selective_refresh,
				),
				array(
					'label'    => esc_html__( 'Layout', 'hestia' ),
					'priority' => 30,
					'section'  => 'hestia_footer_content',
					'choices'  => array(
						'left'   => array(
							'url'   => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqCAMAAABpj1iyAAAAM1BMVEX///8Ahbojjr7f6/PU5O+GuNWjyN71+fs9l8NToMi81ufq8vewz+LI3etmqMx3sNGVwNonU6TvAAAA3UlEQVR4Ae3VOU5EQRRDUd9XQ9Wf//5XS9OiBRECkTwhn8zZzSwzMzMzMzMzMzMzMzP7n9YrYLaqTMrCh3MojRIw+7HeE6IoiS1g11ODZSiH9qyqvR9DDbpS2KBpLDzMootQCjsMLXDeEUUFqn6Kr369v9c4tcEulSop6CmyTm7tUF4zSdbFpQqrpCFpJsnqTCmIfizL0AZHiqwCq2rw7lCHkSJLkygqbZmtaIWmHFn183JWiE1J7BB31TgaUJXGyktUJbK14GH2oWRKrZvMzMzMzMzMzMzMzMzM/uANmJYFb3EkojwAAAAASUVORK5CYII=',
							'label' => esc_html__( 'Left Sidebar', 'hestia' ),
						),
						'center' => array(
							'url'   => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqCAMAAABpj1iyAAAAM1BMVEX///8Ahbojjr7f6/PU5O+GuNWjyN71+fs9l8NToMi81ufq8vewz+LI3etmqMx3sNGVwNonU6TvAAAA3UlEQVR4Ae3OO07GMBQF4TPXDztxHtn/ahG/AFFCgy7S+brpRvZDZmZmZmZmZmZmZnz3B51/y1ve8paZmZmZ2e/sd8BsVZmUjQ/XUBolYPZzfyZEURIr4NBLg20ohwaHVHs/hxp0pbCgaWwAs+gmlMIBQxtcT0RRgaoMGpcWHFKpkoKuDC4eHVC+siuDm1sVdklD0kyy1ZlSEP3ctqEFpzIosKsG7051GEphEkWlbbMV7dCUQ4UoetkhlpI4IJ6qcTagKo2dT1GVyGoBMPtQMqXWpf/EzMzMzMzMzOwNtQ4GgLlj5sIAAAAASUVORK5CYII=',
							'label' => esc_html__( 'Full Width', 'hestia' ),
						),
						'right'  => array(
							'url'   => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqCAMAAABpj1iyAAAAM1BMVEX///8Ahbojjr7f6/PU5O+GuNWjyN71+fs9l8NToMi81ufq8vewz+LI3etmqMx3sNGVwNonU6TvAAAA3ElEQVR4Ae3Vu05DQRRDUe8zj5n7vv//tYSICDpQqiPk1bnbnWVmZmZmZmZmZmZmZmb2vvUKmK0qk7Lw5RxKowTMfqz3hChKYgvY9dRgGcqhPatq78dQg64UNmgaCw+z6CL0C356Y//NDkMLnHdEUYGaIqtxaoNdKlVS0FNkndzaobxmkqyLSxVWSUPSTJLVmVIQ/ViWoQ2OFFkFVtXg06EOI0WWJlFU2jJb0QpNOdTvy1khNiWxQ9xV42hAVRorL1GVyNaCh9mHkim1bvqnzMzMzMzMzMzMzMzM7ANTnwVvFI+orAAAAABJRU5ErkJggg==',
							'label' => esc_html__( 'Right Sidebar', 'hestia' ),
						),
					),
				),
				'Hestia_Customize_Control_Radio_Image',
				array(
					'selector'        => 'footer .hestia-bottom-footer-content',
					'settings'        => 'hestia_copyright_alignment',
					'render_callback' => array( $this, 'footer_alignment_callback' ),
				)
			)
		);

		$this->add_control(
			new Hestia_Customizer_Control(
				'hestia_alternative_footer_style_upsell',
				array(
					'default'           => 'black_footer',
					'sanitize_callback' => 'hestia_sanitize_footer_layout_control',
					'transport'         => $this->selective_refresh,
				),
				array(
					'label'    => esc_html__( 'Color', 'hestia' ),
					'section'  => 'hestia_footer_content',
					'priority' => 40,
					'choices'  => array(
						'white_footer' => array(
							'url' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqAQMAAABknzrDAAAABlBMVEX///8zMzM4VIyRAAAAJElEQVRIx2NgGAV0Auz/kcGBARUbBaNxNBpHo3E0GkejgCoAAEQ9gGhRALtTAAAAAElFTkSuQmCC',
						),
						'black_footer' => array(
							'url' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqAQMAAABknzrDAAAABlBMVEUzMzP///8jKH/HAAAAJElEQVRIx2NgGAV0Auz/kcGBARUbBaNxNBpHo3E0GkejgCoAAEQ9gGhRALtTAAAAAElFTkSuQmCC',
						),
					),
				),
				'Hestia_Customize_Control_Radio_Image'
			)
		);
	}
}

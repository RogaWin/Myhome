<?php
/**
 * The class for handle setup wizard stuff.
 *
 * @package hestia
 *
 * @since 3.1
 */

/**
 * Setup wizard main class.
 */
class Hestia_Setup_Wizard {

	/**
	 * Parent menu slug.
	 */
	const PARENT_SLUG = 'themes.php';

	/**
	 * Option name.
	 */
	const OPTION_NAME = 'hestia_wizard_dismissed';

	/**
	 * Fresh site
	 *
	 * @var $is_wizard_dismissed bool
	 */
	private $is_wizard_dismissed = false;

	/**
	 * Post wizard data.
	 *
	 * @var $wizard_data array
	 */
	private $wizard_data = array();

	/**
	 * Constructor.
	 *
	 * @since 3.1
	 *
	 * @access public
	 */
	public function init() {
		add_filter( 'admin_body_class', array( $this, 'add_wizard_classes' ) );
		add_action( 'after_setup_theme', array( $this, 'hestia_after_setup_theme' ) );
		add_action( 'admin_action_hestia_dismiss_wizard', array( $this, 'dismiss_wizard' ) );
		add_action( 'admin_menu', array( $this, 'register_admin_menu' ), PHP_INT_MAX );
		add_action( 'wp_ajax_hestia_wizard_step_process', array( $this, 'hestia_wizard_step_process' ) );
		add_action( 'wp_ajax_nopriv_hestia_wizard_step_process', array( $this, 'hestia_wizard_step_process' ) );
		add_action( 'wp_ajax_hestia_set_logo_and_icon', array( $this, 'hestia_set_logo_and_icon' ) );
		add_action( 'wp_ajax_nopriv_hestia_set_logo_and_icon', array( $this, 'hestia_set_logo_and_icon' ) );
		add_action( 'wp_ajax_hestia_add_new_page', array( $this, 'hestia_add_new_page' ) );
		add_action( 'wp_ajax_nopriv_hestia_add_new_page', array( $this, 'hestia_add_new_page' ) );
		add_action( 'admin_footer', array( $this, 'add_inline_style' ) );
		add_action( 'switch_theme', array( $this, 'hestia_handle_switch_theme' ) );
		$this->is_wizard_dismissed = get_option( self::OPTION_NAME, 0 );
	}

	/**
	 * Delete the wizard dismissed flag when the user switch the theme.
	 */
	public function hestia_handle_switch_theme() {
		delete_option( 'hestia_wizard_dismissed' );
	}

	/**
	 * Set wizard dismissed flag.
	 */
	public function hestia_after_setup_theme() {
		global $pagenow;
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( 'themes.php' === $pagenow && isset( $_GET['activated'] ) ) {
			if ( ! $this->is_wizard_dismissed ) {
				$this->is_wizard_dismissed = update_option( self::OPTION_NAME, false );
				wp_redirect( add_query_arg( 'page', 'hestia-setup-wizard', admin_url( 'admin.php' ) ) );
				exit;
			}
		}
	}

	/**
	 * Registers admin menu.
	 *
	 * @since 3.1
	 *
	 * @access public
	 */
	public function register_admin_menu() {
		if ( ! $this->is_wizard_dismissed ) {
			$hook = add_submenu_page(
				self::PARENT_SLUG,
				__( 'Setup Wizard', 'hestia' ),
				__( 'Setup Wizard', 'hestia' ),
				'manage_options',
				'hestia-setup-wizard',
				array(
					$this,
					'hestia_setup_wizard_page',
				)
			);
			add_action( "load-$hook", array( $this, 'hestia_load_setup_wizard_page' ) );
		}
	}

	/**
	 * Method to register the setup wizard page.
	 *
	 * @access public
	 */
	public function hestia_setup_wizard_page() {
		include __DIR__ . '/template-setup-wizard.php';
	}

	/**
	 * Add classes to make the wizard full screen.
	 *
	 * @param string $classes Body classes.
	 * @return string
	 */
	public function add_wizard_classes( $classes ) {
		if ( ! $this->is_wizard_dismissed ) {
			$classes .= ' hestia-wizard-fullscreen';
		}
		return trim( $classes );
	}

	/**
	 * Load setup wizard page.
	 *
	 * @access public
	 */
	public function hestia_load_setup_wizard_page() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['page'] ) && 'hestia-setup-wizard' === $_GET['page'] ) {
			remove_all_actions( 'admin_notices' );
		}
		add_action( 'admin_enqueue_scripts', array( $this, 'hestia_enqueue_setup_wizard_scripts' ) );
	}

	/**
	 * Enqueue setup wizard required scripts.
	 *
	 * @access public
	 */
	public function hestia_enqueue_setup_wizard_scripts() {
		wp_enqueue_media();
		wp_enqueue_style( 'jquery-smart-wizard', get_template_directory_uri() . '/assets/jquery-smartwizard/css/smart_wizard_all' . ( ( HESTIA_DEBUG ) ? '' : '.min' ) . '.css', array(), HESTIA_VERSION );
		wp_enqueue_style( 'hestia-setup-wizard', get_template_directory_uri() . '/assets/css/setup-wizard' . ( ( HESTIA_DEBUG ) ? '' : '.min' ) . '.css', array( 'wp-color-picker' ), HESTIA_VERSION, 'all' );

		wp_enqueue_script( 'jquery-smart-wizard', get_template_directory_uri() . '/assets/jquery-smartwizard/js/jquery.smartWizard' . ( ( HESTIA_DEBUG ) ? '' : '.min' ) . '.js', array( 'jquery', 'clipboard' ), HESTIA_VERSION, true );
		wp_enqueue_script( 'hestia-setup-wizard', get_template_directory_uri() . '/assets/js/setup-wizard.min.js', array( 'jquery', 'plupload-handlers', 'wp-color-picker' ), HESTIA_VERSION, true );
		wp_localize_script(
			'hestia-setup-wizard',
			'hestiaSetupWizardData',
			array(
				'adminPage'     => add_query_arg( 'page', self::PARENT_SLUG, admin_url( 'admin.php' ) ),
				'ajax'          => array(
					'url'      => admin_url( 'admin-ajax.php' ),
					'security' => wp_create_nonce( 'hestia-setup-wizard' ),
				),
				'errorMessages' => array(
					'requiredEmail' => __( 'This field is required.', 'hestia' ),
					'invalidEmail'  => __( 'Please enter a valid email address.', 'hestia' ),
				),
				'pluploadData'  => apply_filters(
					'plupload_init',
					array(
						'runtimes'            => 'html5,silverlight,flash,html4',
						'container'           => array( 'icon-hestia-upload-ui', 'hestia-upload-ui' ),
						'drop_element'        => array( 'drag-drop-area', 'icon-drag-drop-area' ),
						'file_data_name'      => 'hestia_image',
						'multiple_queues'     => true,
						'max_file_size'       => wp_max_upload_size() . 'b',
						'url'                 => admin_url( 'admin-ajax.php' ),
						'flash_swf_url'       => includes_url( 'js/plupload/plupload.flash.swf' ),
						'silverlight_xap_url' => includes_url( 'js/plupload/plupload.silverlight.xap' ),
						'filters'             => array(
							array(
								'title'      => __( 'Allowed Files', 'hestia' ),
								'extensions' => 'png,jpg,jpge,ico',
							),
						),
						'multipart'           => true,
						'urlstream_upload'    => true,
						'multipart_params'    => array(
							'_ajax_nonce' => wp_create_nonce( 'hestia-media-upload' ),
							'action'      => 'hestia_set_logo_and_icon',
						),
					)
				),
			)
		);
	}

	/**
	 * Dismiss setup wizard.
	 *
	 * @param bool $redirect_to_dashboard Redirect to dashboard.
	 * @return bool|void
	 */
	public function dismiss_wizard( $redirect_to_dashboard = true ) {
		// Prevent non-admins from accessing this action. Protect against CSRF.
		if ( ! current_user_can( 'manage_options' ) ) {
			if ( false !== $redirect_to_dashboard ) {
				wp_safe_redirect( admin_url( 'index.php' ) );
				exit;
			}
			return false;
		}

		// Prevent requests without a valid nonce.
		if ( ! isset( $_GET['nonce'] ) || false === wp_verify_nonce( $_GET['nonce'], 'hestia_dismiss_wizard' ) ) {
			if ( false !== $redirect_to_dashboard ) {
				wp_safe_redirect( admin_url( 'index.php' ) );
				exit;
			}
			return false;
		}

		update_option( self::OPTION_NAME, 1 );
		if ( false !== $redirect_to_dashboard ) {
			wp_safe_redirect( admin_url( 'index.php' ) );
			exit;
		}
		return true;
	}

	/**
	 * Setup wizard process.
	 */
	public function hestia_wizard_step_process() {
		check_ajax_referer( 'hestia-setup-wizard', 'security' );
		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		$this->wizard_data = ! empty( $_POST['wizard'] ) ? $this->sanitize_wizard_data( $_POST['wizard'] ) : array();
		$action            = ! empty( $_POST['_action'] ) ? filter_input( INPUT_POST, '_action', FILTER_SANITIZE_STRING ) : '';
		switch ( $action ) {
			case 'site_title_tagline':
				$this->save_site_title_tagline();
				break;
			case 'site_logo':
				$this->set_site_logo();
				break;
			case 'site_icon':
				$this->set_site_icon();
				break;
			case 'brand_color':
				$this->set_brand_color();
				break;
			case 'hestia_typography':
				$this->set_hestia_typography();
				break;
			case 'hestia_homepage_setting':
				$this->set_homepage_setting();
				break;
			case 'hestia_install_plugins':
				$this->hestia_install_plugins();
				break;
			case 'hestia_newsletter_subscribe':
				$this->hestia_newsletter_subscribe();
				break;
			default:
				wp_send_json(
					array(
						'status'  => 0,
						'message' => __( 'Something went wrong while saving the wizard data.', 'hestia' ),
					)
				);
				break;
		}
	}

	/**
	 * Save site title and tagline.
	 *
	 * @return void
	 */
	private function save_site_title_tagline() {
		if ( isset( $this->wizard_data['site_title'] ) ) {
			update_option( 'blogname', $this->wizard_data['site_title'] );
		}
		if ( isset( $this->wizard_data['site_tagline'] ) ) {
			update_option( 'blogdescription', $this->wizard_data['site_tagline'] );
		}
		wp_send_json( array( 'status' => 1 ) );
	}

	/**
	 * Set site logo.
	 *
	 * @return void
	 */
	private function set_site_logo() {
		if ( empty( $this->wizard_data['logo_id'] ) ) {
			wp_send_json(
				array(
					'status'  => 0,
					'message' => __( 'Something went wrong, please try again', 'hestia' ),
				)
			);
		}
		$logo = $this->wizard_data['logo_id'];
		set_theme_mod( 'custom_logo', $logo );
		wp_send_json( array( 'status' => 1 ) );
	}

	/**
	 * Set site icon.
	 *
	 * @return void
	 */
	private function set_site_icon() {
		if ( empty( $this->wizard_data['site_icon_id'] ) ) {
			wp_send_json(
				array(
					'status'  => 0,
					'message' => __( 'Something went wrong, please try again', 'hestia' ),
				)
			);
		}
		$site_icon_id = $this->wizard_data['site_icon_id'];
		update_option( 'site_icon', $site_icon_id );
		wp_send_json( array( 'status' => 1 ) );
	}

	/**
	 * Set brand color.
	 *
	 * @return void
	 */
	private function set_brand_color() {
		if ( isset( $this->wizard_data['background_color'] ) ) {
			set_theme_mod( 'background_color', $this->wizard_data['background_color'] );
		}
		if ( isset( $this->wizard_data['accent_color'] ) ) {
			set_theme_mod( 'accent_color', $this->wizard_data['accent_color'] );
		}
		wp_send_json( array( 'status' => 1 ) );
	}

	/**
	 * Set typography.
	 *
	 * @return void
	 */
	private function set_hestia_typography() {
		if ( isset( $this->wizard_data['hestia_headings_font'] ) ) {
			set_theme_mod( 'hestia_headings_font', $this->wizard_data['hestia_headings_font'] );
		}
		if ( isset( $this->wizard_data['hestia_body_font'] ) ) {
			set_theme_mod( 'hestia_body_font', $this->wizard_data['hestia_body_font'] );
		}
		wp_send_json( array( 'status' => 1 ) );
	}

	/**
	 * Set homepage settings..
	 *
	 * @return void
	 */
	private function set_homepage_setting() {
		if ( isset( $this->wizard_data['show_on_front'] ) ) {
			update_option( 'show_on_front', $this->wizard_data['show_on_front'] );
		}
		if ( isset( $this->wizard_data['page_on_front'] ) ) {
			update_option( 'page_on_front', $this->wizard_data['page_on_front'] );
		}
		wp_send_json( array( 'status' => 1 ) );
	}

	/**
	 * Install recommendations plugins.
	 *
	 * @return void
	 */
	private function hestia_install_plugins() {
		if ( ! empty( $this->wizard_data['install_plugin'] ) ) {
			if ( ! current_user_can( 'install_plugins' ) ) {
				wp_send_json(
					array(
						'status'  => 0,
						'message' => __( 'Sorry, you are not allowed to install plugins on this site.', 'hestia' ),
					)
				);
			}
			require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
			include_once ABSPATH . 'wp-admin/includes/plugin-install.php';

			foreach ( $this->wizard_data['install_plugin'] as $slug ) {
				$api = plugins_api(
					'plugin_information',
					array(
						'slug'   => sanitize_key( wp_unslash( $slug ) ),
						'fields' => array(
							'sections' => false,
						),
					)
				);

				if ( is_wp_error( $api ) ) {
					wp_send_json(
						array(
							'status'  => 0,
							'message' => $api->get_error_message(),
						)
					);
				}

				$skin     = new WP_Ajax_Upgrader_Skin();
				$upgrader = new Plugin_Upgrader( $skin );
				$result   = $upgrader->install( $api->download_link );

				if ( is_wp_error( $result ) ) {
					wp_send_json(
						array(
							'status'  => 0,
							'message' => $api->get_error_message(),
						)
					);
				} elseif ( is_wp_error( $skin->result ) ) {
					if ( 'folder_exists' !== $skin->result->get_error_code() ) {
						wp_send_json(
							array(
								'status'  => 0,
								'message' => $skin->result->get_error_message(),
							)
						);
					}
				} elseif ( $skin->get_errors()->has_errors() ) {
					if ( 'folder_exists' !== $skin->get_error_code() ) {
						wp_send_json(
							array(
								'status'  => 0,
								'message' => $skin->get_error_message(),
							)
						);
					}
				} elseif ( is_null( $result ) ) {
					global $wp_filesystem;
					$status            = array();
					$status['message'] = __( 'Unable to connect to the filesystem. Please confirm your credentials.', 'hestia' );

					// Pass through the error from WP_Filesystem if one was raised.
					if ( $wp_filesystem instanceof WP_Filesystem_Base && is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->has_errors() ) {
						$status['message'] = esc_html( $wp_filesystem->errors->get_error_message() );
					}

					wp_send_json( $status );
				}

				activate_plugin( "$slug/$slug.php" );
				if ( 'optimole-wp' === $slug ) {
					delete_transient( 'optml_fresh_install' );
				}
			}
		}
		wp_send_json( array( 'status' => 1 ) );
	}

	/**
	 * Subscribe to newsletter.
	 *
	 * @return void
	 */
	private function hestia_newsletter_subscribe() {
		$email = $this->wizard_data['email'];
		if ( is_email( $email ) ) {
			$request_res = wp_remote_post(
				'https://api.themeisle.com/tracking/subscribe',
				array(
					'timeout' => 100,
					'headers' => array(
						'Content-Type'  => 'application/json',
						'Cache-Control' => 'no-cache',
						'Accept'        => 'application/json, */*;q=0.1',
					),
					'body'    => wp_json_encode(
						array(
							'slug'  => 'hestia',
							'site'  => home_url(),
							'email' => $email,
							'data'  => array(
								'segment' => array(),
							),
						)
					),
				)
			);
			if ( ! is_wp_error( $request_res ) ) {
				$body = json_decode( wp_remote_retrieve_body( $request_res ) );
				if ( 'success' === $body->code ) {
					wp_send_json(
						array(
							'status' => 1,
						)
					);
				}
			}
			wp_send_json(
				array(
					'status'  => 0,
					'message' => __( 'Something went wrong please try again.', 'hestia' ),
				)
			);
		} else {
			wp_send_json(
				array(
					'status'  => 0,
					'message' => __( 'Please enter a valid email address.', 'hestia' ),
				)
			);
		}
	}

	/**
	 * Add inline style.
	 */
	public function add_inline_style() {
		if ( ! $this->is_wizard_dismissed ) { ?>
			<style type="text/css">
				#adminmenu a[href$="?page=hestia-setup-wizard"] {
					display: none;
				}
			</style>
			<?php
		}
	}

	/**
	 * Filter postdata.
	 *
	 * @param array $postdata Post data.
	 * @return array
	 */
	private function sanitize_wizard_data( $postdata ) {
		$postdata = array_map(
			function( $data ) {
				if ( is_array( $data ) ) {
					return $this->sanitize_wizard_data( $data );
				}
				$data = wp_unslash( $data );
				if ( is_numeric( $data ) ) {
					return (int) $data;
				}
				return sanitize_text_field( $data );
			},
			$postdata
		);
		return array_filter( $postdata );
	}

	/**
	 * Set logo and favicon.
	 */
	public function hestia_set_logo_and_icon() {
		check_ajax_referer( 'hestia-media-upload', '_ajax_nonce' );

		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		if ( ! empty( $_POST['default_img'] ) ) {
			$url        = esc_url_raw( wp_unslash( $_POST['default_img'] ) );
			$name       = wp_basename( $url );
			$title      = preg_replace( '/\.[^.]+$/', '', $name );
			$attachment = post_exists( $title, '', '', 'attachment' );
			if ( ! $attachment ) {
				$tmp        = download_url( $url );
				$file_array = array(
					'name'     => $name,
					'tmp_name' => $tmp,
				);
				$attachment = media_handle_sideload( $file_array, 0 );
			}
		} else {
			$title      = ! empty( $_FILES['hestia_image']['name'] ) ? sanitize_file_name( wp_unslash( $_FILES['hestia_image']['name'] ) ) : '';
			$title      = preg_replace( '/\.[^.]+$/', '', $title );
			$attachment = post_exists( $title, '', '', 'attachment' );
			if ( ! $attachment ) {
				$attachment = media_handle_upload( 'hestia_image', 0 );
			}
		}

		if ( is_wp_error( $attachment ) ) {
			wp_send_json(
				array(
					'status'  => 0,
					'message' => $attachment->get_error_message(),
				)
			);
		} else {
			wp_send_json(
				array(
					'status'         => 1,
					'attachment_id'  => $attachment,
					'attachment_url' => wp_get_attachment_url( $attachment ),
				)
			);
		}
		exit;
	}

	/**
	 * List of standard fonts.
	 */
	public function get_standard_fonts() {
		return apply_filters(
			'hestia_standard_fonts_array',
			array(
				'Arial, Helvetica, sans-serif',
				'Arial Black, Gadget, sans-serif',
				'Bookman Old Style, serif',
				'Comic Sans MS, cursive',
				'Courier, monospace',
				'Georgia, serif',
				'Garamond, serif',
				'Impact, Charcoal, sans-serif',
				'Lucida Console, Monaco, monospace',
				'Lucida Sans Unicode, Lucida Grande, sans-serif',
				'MS Sans Serif, Geneva, sans-serif',
				'MS Serif, New York, sans-serif',
				'Palatino Linotype, Book Antiqua, Palatino, serif',
				'Tahoma, Geneva, sans-serif',
				'Times New Roman, Times, serif',
				'Trebuchet MS, Helvetica, sans-serif',
				'Verdana, Geneva, sans-serif',
				'Paratina Linotype',
				'Trebuchet MS',
			)
		);
	}

	/**
	 * Add new page.
	 */
	public function hestia_add_new_page() {
		check_ajax_referer( 'hestia-setup-wizard', 'nonce' );

		$page_title = ! empty( $_POST['page_title'] ) ? filter_input( INPUT_POST, 'page_title', FILTER_SANITIZE_STRING ) : '';
		$page_id    = post_exists( $page_title, '', '', 'page' );

		if ( $page_id ) {
			wp_send_json(
				array(
					'status'  => 2,
					'page_id' => $page_id,
				)
			);
		}

		$page_id = wp_insert_post(
			array(
				'post_title'  => $page_title,
				'post_type'   => 'page',
				'post_status' => 'publish',
			)
		);

		if ( is_wp_error( $page_id ) ) {
			wp_send_json(
				array(
					'status'  => 0,
					'message' => $attachment->get_error_message(),
				)
			);
		} else {
			wp_send_json(
				array(
					'status' => 1,
					'option' => '<option value="' . $page_id . '">' . $page_title . '</option>',
				)
			);
		}
		exit;
	}

	/**
	 * Disallow object clone
	 *
	 * @access public
	 * @since  3.1
	 * @return void
	 */
	public function __clone() {
	}

	/**
	 * Disable un-serializing
	 *
	 * @access public
	 * @since  3.1
	 * @return void
	 */
	public function __wakeup() {
	}
}

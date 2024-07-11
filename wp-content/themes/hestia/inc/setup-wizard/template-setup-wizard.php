<?php
/**
 * Setup wizard template.
 *
 * @package hestia
 */

$skip_wizard         = add_query_arg(
	array(
		'action' => 'hestia_dismiss_wizard',
		'nonce'  => wp_create_nonce( 'hestia_dismiss_wizard' ),
	),
	admin_url( 'admin.php' )
);
$wp_optimole_active  = is_plugin_active( 'optimole-wp/optimole-wp.php' );
$wp_orbit_fox_active = is_plugin_active( 'themeisle-companion/themeisle-companion.php' );
?>
<div class="hestia-wizard-wrap">
	<div class="hestia-header">
		<div class="hestia-logo">
			<div class="hestia-logo-icon">
				<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/hestia-logo.svg">
			</div>
		</div>
		<div class="hestia-dashboard-link hidden">
			<a href="<?php echo esc_url( $skip_wizard ); ?>">
				<span class="dashicons dashicons-external"></span>
			</a>
		</div>
	</div>
	<div class="hestia-wizard">
		<div id="hestiawizard" class="sw">
			<ul class="nav" style="display: none;">
				<li class="nav-item">
					<a class="nav-link" href="#step-1">
						1
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#step-2">
						2
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#step-3">
						3
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#step-4">
						4
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#step-5">
						5
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#step-6">
						6
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#step-7">
						6
					</a>
				</li>
			</ul>
			<div class="tab-content">
				<div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
					<div class="hestia-wizard__content">
						<div class="hestia-wizard__body welcome-step">
							<div class="hestia-card-box">
								<div class="welcom-card">
									<div class="logo">
										<a href="javascript:;">
											<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/hestia-logo.svg">
											<span><?php echo esc_html( 'Hestia' ); ?></span>
										</a>
									</div>
									<h1 class="h1"><?php esc_html_e( 'Welcome to Hestia Theme', 'hestia' ); ?></h1>
									<p><?php esc_html_e( 'If you are new to the Hestia theme, don\'t worry! The Hestia Setup wizard can help you get all of the essential settings set up in just 4 minutes.', 'hestia' ); ?></p>
									<div class="cta">
										<button class="hestia-btn btn-primary next-wizard">
											<?php esc_html_e( 'Start Setup Now', 'hestia' ); ?> <span class="dashicons dashicons-arrow-right-alt icon-right"></span>
										</button>
										<div>
											<a href="<?php echo esc_url( $skip_wizard ); ?>" class="hestia-btn btn-link"><?php esc_html_e( 'Skip Setup', 'hestia' ); ?></a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="hestia-wizard__footer"></div>
					</div>
				</div>
				<div id="step-2" class="tab-pane hestia-hide-skip-btn" role="tabpanel" aria-labelledby="step-2">
					<div class="hestia-wizard__content">
						<div class="hestia-wizard__body process-step">
							<div class="step-progress-bar">
								<ul>
									<li class="active" data-sub_tab="title-tagline">
										<div class="circle"></div>
										<div class="step-name"><?php esc_html_e( 'Site Title & Tagline', 'hestia' ); ?></div>
									</li>
									<li data-sub_tab="site-logo">
										<div class="circle"></div>
										<div class="step-name"><?php esc_html_e( 'Logo', 'hestia' ); ?></div>
									</li>
									<li data-sub_tab="site-icon">
										<div class="circle"></div>
										<div class="step-name"><?php esc_html_e( 'Site Icon', 'hestia' ); ?></div>
									</li>
								</ul>
							</div>
							<div class="hestia-card-box hestia-title-tagline">
								<div class="title-wrap">
									<h2 class="h2"><?php esc_html_e( 'Let’s Start Giving Your Site an Identity', 'hestia' ); ?></h2>
									<p class="p"><?php esc_html_e( 'You can always change it later from Customizer > Site Identity', 'hestia' ); ?></p>
								</div>
								<div class="hestia-error-notice notice notice-error p-8 mb-20 hidden"></div>
								<div class="hestia-form-wrap site-title-form">
									<div class="form-group">
										<label class="h4 form-label pb-16"><?php esc_html_e( 'Site Title', 'hestia' ); ?></label>
										<input type="text" name="wizard[site_title]" class="form-control" value="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>">
									</div>
									<div class="form-group">
										<label class="h4 form-label pb-16"><?php esc_html_e( 'Site Tagline', 'hestia' ); ?></label>
										<input type="text" name="wizard[site_tagline]" class="form-control" value="<?php echo esc_html( get_bloginfo( 'description' ) ); ?>">
									</div>
									<div class="form-footer">
										<button class="hestia-btn btn-primary" data-action="site_title_tagline">
											<?php esc_html_e( 'Save And Continue', 'hestia' ); ?> <span class="dashicons dashicons-arrow-right-alt icon-right"></span>
										</button>
										<span class="spinner"></span>
									</div>
								</div>
							</div>
							<div class="hestia-card-box hestia-site-logo hidden">
								<div class="title-wrap">
									<h2 class="h2"><?php esc_html_e( 'Have a Logo? Add it here', 'hestia' ); ?></h2>
									<p class="p"><?php esc_html_e( 'You can always change it later from Customizer > Site Identity', 'hestia' ); ?></p>
								</div>
								<div class="hestia-error-notice notice notice-error p-8 mb-20 hidden"></div>
								<?php $custom_logo = get_theme_mod( 'custom_logo', false ); ?>
								<div class="hestia-form-wrap">
									<div class="form-group">
										<div id="hestia-upload-ui" class="hide-if-no-js hestia-upload-ui">
											<div class="attachment-media-view attachment-media-view-image landscape pb-16<?php echo empty( $custom_logo ) ? ' hidden' : ''; ?>">
												<div class="thumbnail thumbnail-image pb-16">
													<?php if ( ! empty( $custom_logo ) ) : ?>
														<img class="attachment-thumb" src="<?php echo esc_url( wp_get_attachment_url( $custom_logo ) ); ?>" draggable="false" alt="">
													<?php else : ?>
														<img class="attachment-thumb" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/hestia-demo-logo.png" draggable="false" alt="">
													<?php endif; ?>
												</div>
												<div class="actions">
													<a href="javascript:;" class="button remove-button hestia-reset-media"><?php esc_html_e( 'Remove', 'hestia' ); ?></a>
												</div>
											</div>
											<div id="drag-drop-area" class="hestia-drag-drop-area<?php echo ! empty( $custom_logo ) ? ' hidden' : ''; ?>">
												<div class="drag-drop-inside">
													<span class="drag-drop-info"><?php esc_html_e( 'Drop logo here or', 'hestia' ); ?></span>
													<span class="drag-drop-buttons">
														<a href="javascript:;" class="hestia-choose-media"><?php esc_html_e( 'Choose From Media Library', 'hestia' ); ?></a>
														<input type="hidden" name="wizard[logo_id]" value="<?php echo esc_attr( $custom_logo ); ?>">
													</span>
												</div>
											</div>
											<p class="p<?php echo ! empty( $custom_logo ) ? ' hidden' : ''; ?>"><?php esc_html_e( 'No logo?', 'hestia' ); ?> <a href="javascript:;" class="hestia-use-demo-logo" data-default_img="<?php echo esc_url( get_template_directory_uri() . '/assets/img/hestia-demo-logo.png' ); ?>" data-ajax_nonce="<?php echo esc_attr( wp_create_nonce( 'hestia-media-upload' ) ); ?>"><?php esc_html_e( 'Click here', 'hestia' ); ?></a> <?php esc_html_e( 'to use demo logo', 'hestia' ); ?></p>
										</div>
									</div>
									<div class="form-footer">
										<button class="hestia-btn btn-primary<?php echo empty( $custom_logo ) ? ' disabled' : ''; ?>" data-action="site_logo">
											<?php esc_html_e( 'Upload Logo', 'hestia' ); ?> <span class="dashicons dashicons-arrow-right-alt icon-right"></span>
										</button>
										<span class="spinner"></span>
									</div>
								</div>
							</div>
							<div class="hestia-card-box hestia-site-icon hidden">
								<?php
								$site_icon_id  = get_option( 'site_icon', false );
								$site_icon_url = get_template_directory_uri() . '/assets/img/siteicon-placeholder.svg';
								if ( $site_icon_id ) {
									$site_icon_url = wp_get_attachment_url( $site_icon_id );
								}
								?>
								<div class="title-wrap">
									<h2 class="h2"><?php esc_html_e( 'Have a Site Icon? Add it here', 'hestia' ); ?></h2>
									<div class="title-content-img">
										<p class="p"><?php esc_html_e( 'Site Icons are what you see in browser tabs, bookmark bars, and within the WordPress mobile apps. Upload one here! Site Icons should be square and at least 512 × 512 pixels.', 'hestia' ); ?></p>
										<div class="img">
											<div class="attachment-media-view hestia-preview-icon">
												<div class="site-icon-preview wp-clearfix">
													<div class="favicon-preview">
														<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/browser-preview.png' ); ?>" class="browser-preview" width="182">
														<div class="favicon">
															<img src="<?php echo esc_url( $site_icon_url ); ?>" alt="<?php esc_attr_e( 'Preview as a browser icon', 'hestia' ); ?>">
														</div>
														<span class="browser-title" aria-hidden="true"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
													</div>
													<img class="app-icon-preview" src="<?php echo esc_url( $site_icon_url ); ?>" alt="<?php esc_attr_e( 'Preview as an app icon', 'hestia' ); ?>">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="hestia-error-notice notice notice-error p-8 mb-20 hidden"></div>
								<div class="hestia-form-wrap">
									<div class="form-group">
										<div id="icon-hestia-upload-ui" class="hide-if-no-js hestia-upload-ui">
											<div id="icon-drag-drop-area" class="hestia-drag-drop-area">
												<div class="drag-drop-inside">
													<span class="drag-drop-info"><?php esc_html_e( 'Drop icon here or', 'hestia' ); ?></span>
													<span class="drag-drop-buttons">
														<a href="javascript:;" class="hestia-choose-media"><?php esc_html_e( 'Choose From Media Library', 'hestia' ); ?></a>
														<input type="hidden" name="wizard[site_icon_id]" value="<?php echo esc_attr( $site_icon_id ); ?>">
													</span>
												</div>
											</div>
											<p class="p"><?php esc_html_e( 'No Icon?', 'hestia' ); ?> <a href="javascript:;" class="hestia-use-demo-logo" data-default_img="<?php echo esc_url( get_template_directory_uri() . '/assets/img/hestia-siteicon.png' ); ?>" data-ajax_nonce="<?php echo esc_attr( wp_create_nonce( 'hestia-media-upload' ) ); ?>"><?php esc_html_e( 'Click here', 'hestia' ); ?></a> <?php esc_html_e( 'to use demo icon', 'hestia' ); ?></p>
										</div>
									</div>
									<div class="form-footer">
										<button class="hestia-btn btn-primary<?php echo ! $site_icon_id ? ' disabled' : ''; ?>" data-action="site_icon">
											<?php esc_html_e( 'Upload Icon', 'hestia' ); ?> <span class="dashicons dashicons-arrow-right-alt icon-right"></span>
										</button>
										<span class="spinner"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="hestia-wizard__footer">
							<div class="left">
								<button class="hestia-btn btn-flate prev-wizard">
									<span class="dashicons dashicons-arrow-left-alt icon-left"></span> <?php esc_html_e( 'Back', 'hestia' ); ?>
								</button>
							</div>
							<div class="right hidden">
								<button class="hestia-btn btn-flate next-wizard">
									<?php esc_html_e( 'Skip', 'hestia' ); ?> <span class="dashicons dashicons-arrow-right-alt icon-right"></span>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div id="step-3" class="tab-pane hestia-hide-skip-btn" role="tabpanel" aria-labelledby="step-3">
					<div class="hestia-wizard__content">
						<div class="hestia-wizard__body process-step">
							<div class="step-progress-bar">
								<ul>
									<li class="active" data-sub_tab="color">
										<div class="circle"></div>
										<div class="step-name"><?php esc_html_e( 'Color', 'hestia' ); ?></div>
									</li>
									<li data-sub_tab="typography">
										<div class="circle"></div>
										<div class="step-name"><?php esc_html_e( 'Typography', 'hestia' ); ?></div>
									</li>
								</ul>
							</div>
							<div class="hestia-card-box hestia-color">
								<div class="title-wrap">
									<h2 class="h2"><?php esc_html_e( 'Add Your Brand Color', 'hestia' ); ?></h2>
									<p class="p"><?php esc_html_e( 'You can always change it later from Customizer > Appearance Settings > Colors', 'hestia' ); ?></p>
								</div>
								<div class="hestia-error-notice notice notice-error p-8 mb-20 hidden"></div>
								<div class="hestia-form-wrap site-title-form">
									<div class="form-group">
										<label class="h4 form-label pb-16"><?php esc_html_e( 'Background Color', 'hestia' ); ?></label>
										<input type="text" name="wizard[background_color]" value="<?php echo esc_attr( get_theme_mod( 'background_color', '#E5E5E5' ) ); ?>" data-default-color="#E5E5E5" class="hestia-color-picker"></input>
									</div>
									<div class="form-group">
										<label class="h4 form-label pb-16"><?php esc_html_e( 'Accent Color', 'hestia' ); ?></label>
										<input type="text" name="wizard[accent_color]" value="<?php echo esc_attr( get_theme_mod( 'accent_color', '#e91e63' ) ); ?>" data-default-color="#e91e63" class="hestia-color-picker"></input>
									</div>
									<div class="form-footer">
										<button class="hestia-btn btn-primary" data-action="brand_color">
											<?php esc_html_e( 'Save And Continue', 'hestia' ); ?> <span class="dashicons dashicons-arrow-right-alt icon-right"></span>
										</button>
										<span class="spinner"></span>
									</div>
								</div>
							</div>
							<div class="hestia-card-box hestia-typography hidden">
								<?php
								$std_fonts     = $this->get_standard_fonts();
								$google_fonts  = hestia_get_google_fonts();
								$headings_font = get_theme_mod( 'hestia_headings_font' );
								$body_font     = get_theme_mod( 'hestia_body_font' );
								?>
								<div class="title-wrap">
									<h2 class="h2"><?php esc_html_e( 'Choose your Favourite font styles', 'hestia' ); ?></h2>
									<p class="p"><?php esc_html_e( 'You can always change it later from Customizer > Appearance Settings > Typography', 'hestia' ); ?></p>
								</div>
								<div class="hestia-error-notice notice notice-error p-8 mb-20 hidden"></div>
								<div class="hestia-form-wrap site-title-form">
									<div class="form-group">
										<label class="h4 form-label pb-16"><?php esc_html_e( 'Heading Font Family', 'hestia' ); ?></label>
										<select class="form-control" name="wizard[hestia_headings_font]">
											<option value=""><?php esc_html_e( 'Default', 'hestia' ); ?></option>
											<optgroup label="<?php esc_attr_e( 'Standard Fonts', 'hestia' ); ?>">
												<?php
												foreach ( $std_fonts as $stdfont ) {
													?>
													<option value="<?php echo esc_attr( $stdfont ); ?>"<?php selected( $headings_font, $stdfont ); ?>><?php echo esc_html( $stdfont ); ?></option>
													<?php
												}
												?>
											</optgroup>
											<optgroup label="<?php esc_attr_e( 'Google Fonts', 'hestia' ); ?>">
												<?php
												foreach ( $google_fonts as $font ) {
													?>
													<option value="<?php echo esc_attr( $font ); ?>"<?php selected( $headings_font, $font ); ?>><?php echo esc_html( $font ); ?></option>
													<?php
												}
												?>
											</optroup>
										</select>
									</div>
									<div class="form-group">
										<label class="h4 form-label pb-16"><?php esc_html_e( 'Body Font Family', 'hestia' ); ?></label>
										<select class="form-control" name="wizard[hestia_body_font]">
											<option value=""><?php esc_html_e( 'Default', 'hestia' ); ?></option>
											<optgroup label="<?php esc_attr_e( 'Standard Fonts', 'hestia' ); ?>">
												<?php
												foreach ( $std_fonts as $stdfont ) {
													?>
													<option value="<?php echo esc_attr( $stdfont ); ?>"<?php selected( $body_font, $stdfont ); ?>><?php echo esc_html( $stdfont ); ?></option>
													<?php
												}
												?>
											</optgroup>
											<optgroup label="<?php esc_attr_e( 'Google Fonts', 'hestia' ); ?>">
												<?php
												foreach ( $google_fonts as $font ) {
													?>
													<option value="<?php echo esc_attr( $font ); ?>"<?php selected( $body_font, $font ); ?>><?php echo esc_html( $font ); ?></option>
													<?php
												}
												?>
											</optroup>
										</select>
									</div>
									<div class="form-footer">
										<button class="hestia-btn btn-primary" data-action="hestia_typography">
											<?php esc_html_e( 'Save And Continue', 'hestia' ); ?> <span class="dashicons dashicons-arrow-right-alt icon-right"></span>
										</button>
										<span class="spinner"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="hestia-wizard__footer">
							<div class="left">
								<button class="hestia-btn btn-flate prev-wizard">
									<span class="dashicons dashicons-arrow-left-alt icon-left"></span> <?php esc_html_e( 'Back', 'hestia' ); ?>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div id="step-4" class="tab-pane hestia-hide-skip-btn" role="tabpanel" aria-labelledby="step-4">
					<div class="hestia-wizard__content">
						<div class="hestia-wizard__body process-step">
							<div class="hestia-card-box">
								<div class="title-wrap">
									<h2 class="h2"><?php esc_html_e( 'Homepage Settings', 'hestia' ); ?></h2>
									<p class="p"><?php esc_html_e( 'You can choose what’s displayed on the homepage of your site. It can be posts in reverse chronological order (classic blog), or a fixed/static page.', 'hestia' ); ?></p>
								</div>
								<?php
									$show_on_front = get_option( 'show_on_front', 'posts' );
									$page_on_front = get_option( 'page_on_front', 0 );
								?>
								<div class="hestia-error-notice notice notice-error p-8 mb-20 hidden"></div>
								<div class="hestia-form-wrap site-title-form">
									<div class="form-group">
										<label class="h4 form-label pb-16"><?php esc_html_e( 'Display Settings', 'hestia' ); ?></label>
										<div class="pl-16">
											<div class="hestia-radio pb-16">
												<input type="radio" name="wizard[show_on_front]" value="posts" id="option-1" class="hestia-radio-btn"<?php checked( $show_on_front, 'posts' ); ?>>
												<label for="option-1"><?php esc_html_e( 'Your latest posts', 'hestia' ); ?></label>
											</div>
											<div class="hestia-radio pb-32">
												<input type="radio" name="wizard[show_on_front]" value="page" id="option-2" class="hestia-radio-btn"<?php checked( $show_on_front, 'page' ); ?>>
												<label for="option-2"><?php esc_html_e( 'A static page (select below)', 'hestia' ); ?></label>
											</div>
											<div class="select-page-option<?php echo 'page' !== $show_on_front ? ' hidden' : ''; ?>">
												<div class="label p"><?php esc_html_e( 'Select Homepage:', 'hestia' ); ?></div>
												<div class="select-option-box">
													<?php
														wp_dropdown_pages(
															array(
																'name'              => 'wizard[page_on_front]',
																'show_option_none'  => esc_html__( '&mdash; Select &mdash;', 'hestia' ),
																'option_none_value' => '0',
																'selected'          => esc_attr( $page_on_front ),
																'class'             => esc_attr( 'form-control form-control-sm' ),
																'id'                => 'page_on_front',
															)
														)
														?>
													<div class="add-new-option-box hidden">
														<div>
															<input type="text" name="hestia_page_title" class="form-control form-control-sm" autofocus>
														</div>
														<button class="add-btn"><?php esc_html_e( 'Add', 'hestia' ); ?></button>
													</div>
													<div class="add-new-page">
														<button class="add-new">+ <?php esc_html_e( 'Add new page', 'hestia' ); ?></button>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-footer">
										<button class="hestia-btn btn-primary" data-action="hestia_homepage_setting">
											<?php esc_html_e( 'Save And Continue', 'hestia' ); ?> <span class="dashicons dashicons-arrow-right-alt icon-right"></span>
										</button>
										<span class="spinner"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="hestia-wizard__footer">
							<div class="left">
								<button class="hestia-btn btn-flate prev-wizard">
									<span class="dashicons dashicons-arrow-left-alt icon-left"></span> <?php esc_html_e( 'Back', 'hestia' ); ?>
								</button>
							</div>
						</div>
					</div>
				</div>
				<?php if ( ! $wp_optimole_active || ! $wp_orbit_fox_active ) : ?>
				<div id="step-5" class="tab-pane" role="tabpanel" aria-labelledby="step-5">
					<div class="hestia-wizard__content">
						<div class="hestia-wizard__body process-step">
							<div class="hestia-card-box">
								<div class="title-wrap">
									<h2 class="h2"><?php esc_html_e( 'Install Our Trusted Recommendations', 'hestia' ); ?></h2>
									<p class="p"><?php esc_html_e( 'Don\'t worry, you can remove it anytime, we\'re confident that you\'ll never do', 'hestia' ); ?></p>
								</div>
								<div class="hestia-error-notice notice notice-error p-8 mb-20 hidden"></div>
								<div class="hestia-form-wrap recommendations-wrap">
									<div class="hestia-accordion pb-32">
										<?php if ( ! $wp_optimole_active ) : ?>
											<div class="hestia-accordion-item hestia-features-accordion mb-0">
												<div class="hestia-accordion-item__title hestia-accordion-checkbox__title">
													<div class="hestia-checkbox">
														<input type="checkbox" name="wizard[install_plugin][]" value="optimole-wp" class="hestia-checkbox-btn" checked>
													</div>
													<button type="button" class="hestia-accordion-item__button">
														<div class="hestia-accordion__step-title h4 pb-4"><?php esc_html_e( 'Enable performance features for your website', 'hestia' ); ?></div>
														<p class="help-text"><?php esc_html_e( 'Optimise and speed up your site with our trusted add on - It’s Free', 'hestia' ); ?></p>
														<div class="hestia-accordion__icon"><span class="dashicons dashicons-arrow-down-alt2"></span>
														</div>
													</button>
												</div>
												<div class="hestia-accordion-item__content">
													<div class="hestia-features-list">
														<ul>
															<li>
																<div class="icon">
																	<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/optimole-logo.svg" alt="">
																</div>
																<div class="txt">
																	<div class="h4 pb-4"><?php esc_html_e( 'Boost your website speed', 'hestia' ); ?></div>
																	<p class="help-text"><?php esc_html_e( 'Improve your website speed and images by 80% with', 'hestia' ); ?> <a href="https://wordpress.org/plugins/optimole-wp/" target="_blank">Optimole</a></p>
																</div>
															</li>
														</ul>
													</div>
												</div>
											</div>
										<?php endif; ?>
										<?php if ( ! $wp_orbit_fox_active ) : ?>
											<div class="hestia-accordion-item hestia-features-accordion mb-0">
												<div class="hestia-accordion-item__title hestia-accordion-checkbox__title">
													<div class="hestia-checkbox">
														<input type="checkbox" class="hestia-checkbox-btn" name="wizard[install_plugin][]" value="themeisle-companion" checked>
													</div>
													<button type="button" class="hestia-accordion-item__button">
														<div class="hestia-accordion__step-title h4 pb-4"><?php esc_html_e( 'Add more options available for Hestia Theme', 'hestia' ); ?></div>
														<p class="help-text"><?php esc_html_e( 'Take full advantage of the options this theme has to offer - It’s Free', 'hestia' ); ?></p>
														<div class="hestia-accordion__icon"><span class="dashicons dashicons-arrow-down-alt2"></span>
														</div>
													</button>
												</div>
												<div class="hestia-accordion-item__content">
													<div class="hestia-features-list">
														<ul>
															<li>
																<div class="icon">
																	<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/orbit-fox-logo.svg" alt="">
																</div>
																<div class="txt">
																	<div class="h4 pb-4"><?php esc_html_e( 'Extend Hestia Theme functionality', 'hestia' ); ?></div>
																	<p class="help-text"><?php esc_html_e( 'Social Media Buttons & Icons, Custom Menu Icons, Scripts and more with', 'hestia' ); ?> <a href="https://wordpress.org/plugins/themeisle-companion/" target="_blank">Orbit fox</a></p>
																</div>
															</li>
														</ul>
													</div>
												</div>
											</div>
										<?php endif; ?>
									</div>
									<div class="form-footer">
										<button class="hestia-btn btn-primary" data-action="hestia_install_plugins">
											<?php esc_html_e( 'Install Now', 'hestia' ); ?> <span class="dashicons dashicons-arrow-right-alt icon-right"></span>
										</button>
										<span class="spinner"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="hestia-wizard__footer">
							<div class="left">
								<button class="hestia-btn btn-flate prev-wizard">
									<span class="dashicons dashicons-arrow-left-alt icon-left"></span> <?php esc_html_e( 'Back', 'hestia' ); ?>
								</button>
							</div>
							<div class="right">
								<button class="hestia-btn btn-flate next-wizard">
									<?php esc_html_e( 'Skip', 'hestia' ); ?> <span class="dashicons dashicons-arrow-right-alt icon-right"></span>
								</button>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
				<div id="step-6" class="tab-pane" role="tabpanel" aria-labelledby="step-6">
					<div class="hestia-wizard__content">
						<div class="hestia-wizard__body process-step">
							<div class="hestia-card-box">
								<div class="title-wrap">
									<h2 class="h2"><?php echo wp_kses( __( 'Updates, Tutorials, Special Offers<br> and more', 'hestia' ), array( 'br' => true ) ); ?></h2>
									<p class="p"><?php echo wp_kses( __( 'Let us know your email so that we can send you product updates, helpful<br> tutorials, exclusive offers and more useful stuff.', 'hestia' ), array( 'br' => true ) ); ?></p>
								</div>
								<div class="hestia-error-notice notice notice-error p-8 mb-20 hidden"></div>
								<div class="hestia-form-wrap site-title-form">
									<div class="form-group">
										<?php $admin_email = get_bloginfo( 'admin_email' ); ?>
										<input type="text" class="form-control" name="wizard[email]" placeholder="<?php echo esc_attr( $admin_email ); ?>" value="<?php echo esc_attr( $admin_email ); ?>">
									</div>
									<div class="form-footer">
										<button class="hestia-btn btn-primary" data-action="hestia_newsletter_subscribe">
											<?php esc_html_e( 'Send Me Access', 'hestia' ); ?> <span class="dashicons dashicons-arrow-right-alt icon-right"></span>
										</button>
										<span class="spinner"></span>
									</div>
								</div>
							</div>
						</div>
						<div class="hestia-wizard__footer">
							<div class="left">
								<button class="hestia-btn btn-flate prev-wizard">
									<span class="dashicons dashicons-arrow-left-alt icon-left"></span> <?php esc_html_e( 'Back', 'hestia' ); ?>
								</button>
							</div>
							<div class="right">
								<button class="hestia-btn btn-flate next-wizard">
									<?php esc_html_e( 'Skip', 'hestia' ); ?> <span class="dashicons dashicons-arrow-right-alt icon-right"></span>
								</button>
							</div>
						</div>
					</div>
				</div>
				<div id="step-7" class="tab-pane" role="tabpanel" aria-labelledby="step-7">
					<div class="hestia-wizard__content">
						<div class="hestia-wizard__body process-step">
							<div class="hestia-card-box">
								<div class="finish-box">
									<div class="title-wrap">
										<h2 class="h2"><?php esc_html_e( 'Awesome! You\'ve made it to the finish line.', 'hestia' ); ?></h2>
										<p class="p"><?php esc_html_e( 'Go Go Go! Start Building your Awesome Websites With Hestia!', 'hestia' ); ?></p>
									</div>
									<div class="video-box">
										<?php
										$youtube_video = 'https://www.youtube-nocookie.com/embed/bpom4SSyo-8';
										if ( defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Widget_Base', false ) ) {
											$youtube_video = 'https://www.youtube.com/embed/JOKgkykzvlg';
										}
										?>
										<iframe src="<?php echo esc_url( $youtube_video ); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
										<p class="p">
											<?php
											echo wp_kses(
												// translators: %s to document URL.
												sprintf( __( 'Need more help? Read our <a href="%s" target="_blank">documentation</a>', '', 'hestia' ), esc_url( 'https://docs.themeisle.com/article/753-hestia-doc' ) ),
												array(
													'a' => array(
														'href'   => true,
														'target' => true,
														'class'  => true,
													),
												)
											);
											?>
										</p>
									</div>
									<div class="cta">
										<a href="<?php echo esc_url( $skip_wizard ); ?>" class="hestia-btn btn-primary hestia-finish-btn">
											<?php esc_html_e( 'Finish Setup', 'hestia' ); ?> <span class="dashicons dashicons-arrow-right-alt icon-right"></span>
										</a>
									</div>
								</div>
							</div>
						</div>
						<div class="hestia-wizard__footer">
							<div class="left">
								<button class="hestia-btn btn-flate prev-wizard">
									<span class="dashicons dashicons-arrow-left-alt icon-left"></span> <?php esc_html_e( 'Back', 'hestia' ); ?>
								</button>
							</div>
						</div>
						<div class="gif-animation">
							<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/finish-animation.gif" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

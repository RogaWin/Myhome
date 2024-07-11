jQuery( document ).ready( function( $ ) {
	var wizardId = '#hestiawizard';
	$(wizardId).smartWizard({
		autoAdjustHeight: false,
		transition: {
			animation: 'fade',
			speed: '400',
		},
		keyboard: {
			keyNavigation: false,
		},
		anchor: {
			enableNavigation: false,
			enableNavigationAlways: false,
		},
	});

	var handleSubStep = function( ref ) {
		var targetElement = $( '.step-progress-bar:visible' );
		if ( ref.is( ':first-child' ) ) {
			ref.addClass( 'active' ).removeClass( 'done' );
			targetElement.find( 'li' ).not(ref).removeClass( 'done' ).removeClass( 'active' );
			return;
		}
		if ( ref.hasClass( 'trigger-next' ) ) {
			ref.prev( 'li' ).addClass( 'done' ).removeClass( 'active' );
			ref.addClass( 'active' );
		} else {
			ref.next( 'li.active' ).removeClass( 'done' ).removeClass( 'active' );
			ref.removeClass( 'done' ).addClass( 'active' );
		}
		ref.removeClass( 'trigger-next trigger-prev' );
	};

	/**
	 * Reset step
	 */
	var resetSubStep = function() {
		$( '.step-progress-bar:visible li:first-child' ).trigger( 'click' );
	};

	/**
	 * Next step.
	 */
	var nextStep = function() {
		var nextStepElement = $( '.step-progress-bar:visible li.active' ).next( 'li' );
		if ( nextStepElement.length === 0 ) {
			$(wizardId).smartWizard( 'next' );
			return;
		}
		nextStepElement.addClass( 'trigger-next' ).click();
	};

	/**
	 * Prev step.
	 */
	var prevStep = function() {
		var prevStepElement = $( '.step-progress-bar:visible li.active' ).prev( 'li' );
		if ( prevStepElement.length === 0 ) {
			$(wizardId).smartWizard( 'prev' );
			return;
		}
		prevStepElement.addClass( 'trigger-prev' ).click();
	};

	/**
	 * Preview image.
	 */
	var previewImage = function( imgSource, image_id ) {
		var parentElement = $( '.tab-pane:visible .hestia-card-box:visible' );
		if ( imgSource !== '' ) {
			var attachmentMediaView = parentElement.find( '.attachment-media-view' );
			if ( attachmentMediaView.hasClass( 'hestia-preview-icon' ) ) {
				attachmentMediaView.find( '.favicon img, .app-icon-preview' ).attr( 'src', imgSource );
			} else {
				attachmentMediaView.find( '.attachment-thumb' ).attr( 'src', imgSource );
				attachmentMediaView.removeClass( 'hidden' );
				attachmentMediaView.next( '.hestia-drag-drop-area' ).addClass( 'hidden' );
				parentElement.find( '.hestia-drag-drop-area.hidden' ).next( 'p' ).addClass( 'hidden' );
			}
		}
		parentElement.find( '.hestia-btn.disabled' ).removeClass( 'disabled' );
		if ( image_id > 0 ) {
			parentElement.find( 'input:hidden' ).val( image_id );
		}
	};

	/**
	 * Hide footer action.
	 */
	var hideFooterAction = function( hide ) {
		if ( hide ) {
			$( '.hestia-wizard__footer .left, .hestia-wizard__footer .right' ).addClass( 'disabled' );
		} else {
			$( '.hestia-wizard__footer .left, .hestia-wizard__footer .right' ).removeClass( 'disabled' );
		}
	};

	/**
	 * Leave step and show step.
	 */
	$(wizardId).on( 'leaveStep showStep', function( e, anchorObject, stepIndex, stepDirection, stepPosition ) {
		$( '.hestia-hide-skip-btn .hestia-wizard__footer .right' ).addClass( 'hidden' );
		$( '.step-progress-bar li' ).removeClass( 'trigger-next trigger-prev' );
		if ( window.location.hash && ( '#step-1' === window.location.hash || '#step-7' === window.location.hash ) ) {
			$( '.hestia-dashboard-link' ).removeClass( 'hidden' );
			if ( '#step-7' === window.location.hash ) {
				$( '.gif-animation' ).addClass( 'show' );
				setTimeout( function() {
					$( '.gif-animation' ).removeClass( 'show' );
				}, 6000 );
			}
		} else {
			$( '.hestia-dashboard-link' ).addClass( 'hidden' );
			resetSubStep();
		}
	} );

	$('.prev-wizard').on('click', function () {
		// Navigate previous
		prevStep();
		return true;
	});
	
	$('.next-wizard').on('click', function () {
		// Navigate next.
		nextStep();
		return true;
	});

	$('.hestia-accordion .hestia-accordion-item .hestia-accordion-item__button').on('click', function () {
			var current_item = $(this).parents();
			$('.hestia-accordion .hestia-accordion-item .hestia-accordion-item__content').each(
				function (i, el) {
					if ($(el).parent().is(current_item)) {
						$(el).prev().toggleClass('is-active');
						$(el).slideToggle();
						$(this).toggleClass('is-active');
					} else {
						$(el).prev().removeClass('is-active');
						$(el).slideUp();
						$(this).removeClass('is-active');
					}
				}
			);
		}
	);

	// Click on sub tab.
	$( document ).on( 'click', '[data-sub_tab]', function() {
		var subNextTab = $( this ).data( 'sub_tab' );
		$( this ).parents( '.tab-pane' ).find( '.hestia-card-box:not(.hidden)' ).addClass( 'hidden' );
		$( '.hestia-' +  subNextTab ).removeClass( 'hidden' );
		if ( ! $( this ).is( ':first-child' ) ) {
			$( '.hestia-wizard__footer .right' ).removeClass( 'hidden' );
		}
		handleSubStep( $(this) );
	} );

	// Click to next step.
	$( document ).on( 'click', '.hestia-card-box button:not(.hestia-btn,.add-new,.add-btn,.hestia-accordion-item__button)', function() {
		nextStep();
	} );

	// Remove disabled class from send me access button.
	$( document ).on( 'input', 'input[name="wizard[email]"]', function() {
		if ( $( this ).val() !== '' ) {
			$( this ).parents( '.hestia-card-box' ).find( '.hestia-btn' ).removeClass( 'disabled' );
		} else {
			$( this ).parents( '.hestia-card-box' ).find( '.hestia-btn' ).addClass( 'disabled' );
		}
	} );

	// Save and Continue.
	$( document ).on( 'click', '.hestia-card-box .form-footer button', function() {
		var _currentButton = $(this);
		var currentStep = _currentButton.parents( 'div.tab-pane' );
		var actionId    = _currentButton.data( 'action' );

		// Validation for email field.
		if ( 'hestia_newsletter_subscribe' === actionId ) {
			var emailElement = $( 'input[name="wizard[email]"]' );
			emailElement.next(".hestia-field-error").remove();

			var subscribeEmail = emailElement.val();
			var EmailTest = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
			var errorMessage = "";
			if ( '' === subscribeEmail ) {
				errorMessage = hestiaSetupWizardData.errorMessages.requiredEmail;
			} else if ( ! EmailTest.test( subscribeEmail ) ) {
				errorMessage = hestiaSetupWizardData.errorMessages.invalidEmail;
			}
			if ("" !== errorMessage) {
				$('<span class="hestia-field-error">' + errorMessage + "</span>").insertAfter(emailElement);
				return;
			}
		}

		var data        = 'action=hestia_wizard_step_process&security=' + hestiaSetupWizardData.ajax.security + '&_action=' + actionId + '&' + jQuery( 'input, select' ).serialize();
		currentStep.find( '.spinner' ).addClass( 'is-active' );
		currentStep.find( '.hestia-card-box .hestia-error-notice' ).addClass( 'hidden' );
		_currentButton.addClass( 'disabled' );
		hideFooterAction( true );

		$.post(
			hestiaSetupWizardData.ajax.url,
			data,
			function( res ) {
				hideFooterAction( false );
				currentStep.find( '.spinner' ).removeClass( 'is-active' );
				_currentButton.removeClass( 'disabled' );
				if ( res.status === 1 ) {
					nextStep();
				} else if( res.status === 0 && res.message !== '' ) {
					currentStep.find( '.hestia-card-box .hestia-error-notice' ).html( '<p>' + res.message + '</p>' ).removeClass( 'hidden' );
				}
			},
			'json'
		)
		.fail( function( response ) {
			hideFooterAction( false );
			currentStep.find( '.spinner' ).removeClass( 'is-active' );
			currentStep.find( 'button.hestia-btn' ).removeClass( 'disabled' );
		} );
	} );

	/**
	 * Reset media upload.
	 */
	$( document ).on( 'click', '.hestia-reset-media', function() {
		var parentElement = $( '.tab-pane:visible .hestia-card-box:visible' );
		parentElement.find( '.attachment-media-view' ).addClass( 'hidden' );
		parentElement.find( '.hestia-drag-drop-area.hidden' ).next( 'p' ).removeClass( 'hidden' );
		parentElement.find( '.attachment-media-view' ).next( '.hestia-drag-drop-area' ).removeClass( 'hidden' );
		parentElement.find( '.form-footer .hestia-btn' ).addClass( 'disabled' );
		parentElement.find( 'input:hidden' ).val(0);
	} );

	// Init plupload.
	if ( 'object' === typeof hestiaSetupWizardData.pluploadData ) {
		var uploader = new plupload.Uploader( hestiaSetupWizardData.pluploadData );

		// checks if browser supports drag and drop upload, makes some css adjustments if necessary
		uploader.bind('Init', function(up) {
			var uploaddiv = $( '.hestia-upload-ui' );

			if( up.features.dragdrop ) {
				uploaddiv.addClass('drag-drop');
				$('#drag-drop-area, #icon-drag-drop-area')
				.bind('dragover.wp-uploader', function() {
					uploaddiv.addClass('drag-over');
				})
				.bind('dragleave.wp-uploader, drop.wp-uploader', function() {
					uploaddiv.removeClass('drag-over');
				});

			} else {
				uploaddiv.removeClass('drag-drop');
				$('#drag-drop-area, #icon-drag-drop-area').unbind('.wp-uploader');
			}
		});

		uploader.init();

		// a file was added in the queue
		uploader.bind('FilesAdded', function(up, files) {
			if ( 'undefined' === typeof files.url ) {
				up.refresh();
				up.start();
			}
		});

		// a file was uploaded 
		uploader.bind('FileUploaded', function(up, file, response) {
			if ( 'undefined' === typeof file.url ) {
				var mediaResponse = $.parseJSON( response.response );
				if ( mediaResponse.status === 1 ) {
					previewImage( mediaResponse.attachment_url, mediaResponse.attachment_id );
				} else {
					$( '.tab-pane:visible' )
					.find( '.hestia-card-box:visible' )
					.find( '.hestia-error-notice' )
					.html( '<p>' + mediaResponse.message + '</p>' )
					.removeClass( 'hidden' );
				}
			} else {
				previewImage( file.url, file.id );
			}
			hideFooterAction( false );

			$( '.tab-pane:visible' )
			.find( '.hestia-card-box:visible' )
			.find( 'span.spinner' )
			.removeClass( 'is-active' );
		});

		// Error handler.
		uploader.bind('Error', function(up, args) {
			hideFooterAction( false );

			$( '.tab-pane:visible' )
			.find( '.hestia-card-box:visible' )
			.find( '.hestia-error-notice' )
			.html( '<p>' + args.message + '</p>' )
			.removeClass( 'hidden' );

			$( '.tab-pane:visible' )
			.find( '.hestia-card-box:visible' )
			.find( 'span.spinner' )
			.removeClass( 'is-active' );
		});

		// Progress status.
		uploader.bind('UploadProgress', function(up, file) {
			hideFooterAction( true );

			$( '.tab-pane:visible' )
			.find( '.hestia-card-box:visible' )
			.find( '.hestia-error-notice' )
			.addClass( 'hidden' );

			$( '.tab-pane:visible' )
			.find( '.hestia-card-box:visible' )
			.find( 'span.spinner' )
			.addClass( 'is-active' );
		});

	/**
	 * Open media iframe
	 */
		var openWPMedia = function() {
	    // Create state
			var hestiaMediaState = wp.media.controller.Library.extend({
				defaults :  _.defaults({
					id: 'hestia-media-state',
					allowLocalEdits: true,
					displaySettings: true,
					displayUserSettings: true,
					multiple : false,
					library: wp.media.query({ type: 'image' })
				}, wp.media.controller.Library.prototype.defaults )
			});

			var frame;
			// Click to open wp.media.iframe
			$( document ).on( 'click', '.hestia-choose-media', function( event ) {
				var _ = $( this );

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( frame ) {
					frame.open();
					return;
				}

				// Create a new media frame
				frame = wp.media({
					multiple: false,
					state: 'hestia-media-state', // set the custom state as default state
					states: [ new hestiaMediaState() ]
					} );
				// When an image is selected in the media frame...
				frame.on( 'select', function() {
					var attachment = frame.state().get('selection').first().toJSON();
					// Create the mock file:
					window.EditImageData = {
						url: attachment.url,
						id: attachment.id
					};
					uploader.trigger("FileUploaded", window.EditImageData);
				});
				frame.open();
			});
		};
		openWPMedia();

		/**
	   * Set default
	   */
		$( document ).on( 'click', '[data-default_img]', function() {
			var defaultURL = $( this ).data( 'default_img' );
			var ajaxNonce  = $( this ).data( 'ajax_nonce' );
			if ( defaultURL === '' ) {
				return;
			}

			// show ajax loader.
			uploader.trigger( 'UploadProgress', {} );

			$.post(
				hestiaSetupWizardData.ajax.url,
				{
					action: 'hestia_set_logo_and_icon',
					_ajax_nonce: ajaxNonce,
					default_img: defaultURL,
				},
				function( res ) {
					if ( res.status === 1 ) {
						uploader.trigger( 'FileUploaded', { url: res.attachment_url, id: res.attachment_id } );
					} else {
						uploader.trigger( 'Error', { message: res.message } );
					}
				},
				'json'
			)
			.fail( function( res ) {
				uploader.trigger( 'Error', { message: res.statusText } );
			} );
		} );
	}

	// HomePage setting.
	$( document ).on( 'change', 'input[name="wizard[show_on_front]"]', function() {
		if ( $( this ).val() === 'page' ) {
			$( '.select-page-option' ).removeClass( 'hidden' );
			$( '#page_on_front' ).trigger( 'change' );
		} else {
			$( '.select-page-option' ).addClass( 'hidden' );
			$( this ).parents( '.hestia-card-box' ).find( '.hestia-btn' ).removeClass( 'disabled' );
		}
	} );

	// Add new page.
	$( document ).on( 'click', '.add-new', function() {
		if ( $( this ).hasClass( 'disabled' ) ) {
			$( this ).parent( '.add-new-page' ).prev( '.add-new-option-box' ).addClass( 'hidden' );
			$( this ).removeClass( 'disabled' );
		} else {
			$( this ).parent( '.add-new-page' ).prev( '.add-new-option-box' ).removeClass( 'hidden' );
			$( this ).addClass( 'disabled' );
			$( this ).parents( '.hestia-card-box' ).find( '.hestia-btn' ).addClass( 'disabled' );
			$( 'input[name="hestia_page_title"]' ).val('');
		}
		return false;
	} );

	// Select HomePage.
	$( document ).on( 'change', '#page_on_front', function() {
		var saveButton = $( this ).parents( '.hestia-card-box' ).find( '.hestia-btn' );
		if ( $( this ).val() === '0' ) {
			saveButton.addClass( 'disabled' );
		} else {
			saveButton.removeClass( 'disabled' );
		}
		$( '.add-new.disabled' ).trigger( 'click' );
	} );

	// Hide save button.
	$( document ).on( 'change', 'input[name="wizard[install_plugin][]"]', function() {
		var checkedOption = $( 'input[name="wizard[install_plugin][]"]' ).filter( ':checked' );
		var saveButton = $( this ).parents( '.hestia-card-box' ).find( '.hestia-btn' );
		if ( checkedOption.length > 0 ) {
			saveButton.removeClass( 'disabled' );
		} else {
			saveButton.addClass( 'disabled' );
		}
	} );

	// Create new page.
	$( document ).on( 'click', '.hestia-card-box .add-btn', function() {
			var addButtonElement = $( this );
			var pageTitle = $( 'input[name="hestia_page_title"]' ).val();
			var currentStep = addButtonElement.parents( 'div.tab-pane' );

			if ( pageTitle === '' || addButtonElement.hasClass( 'disabled' ) ) {
				return;
			}

			currentStep.find( '.spinner' ).addClass( 'is-active' );
			addButtonElement.addClass( 'disabled' );
			hideFooterAction( true );

			$.post(
				hestiaSetupWizardData.ajax.url,
				{
					action: 'hestia_add_new_page',
					nonce: hestiaSetupWizardData.ajax.security,
					page_title: pageTitle
				},
				function( res ) {
					hideFooterAction( false );
					if ( res.status === 1 ) {
						$( '#page_on_front' ).append( res.option ).trigger( 'change' );
					} else if( res.status === 2 && res.page_id > 0 ) {
						$( '#page_on_front' ).val( res.page_id ).trigger( 'change' );
					} else if( res.message !== '' ) {
						currentStep.find( '.hestia-card-box .hestia-error-notice' ).html( '<p>' + res.message + '</p>' ).removeClass( 'hidden' );
					}
					currentStep.find( '.spinner' ).removeClass( 'is-active' );
					addButtonElement.removeClass( 'disabled' );
					$( 'input[name="hestia_page_title"]' ).val('');
				},
				'json'
			).fail( function() {
				hideFooterAction( false );
				currentStep.find( '.spinner' ).removeClass( 'is-active' );
				addButtonElement.removeClass( 'disabled' );
			} );
	} );

	// Update browser title.
	$( document ).on( 'input', 'input[name="wizard[site_title]"]', function() {
		$( 'span.browser-title' ).text( $( this ).val() );
	} );

	// WP init color picker.
	$( '.hestia-color-picker' ).wpColorPicker();
});
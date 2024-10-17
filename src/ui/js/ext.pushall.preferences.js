/**
 * JavaScript for the PushAll extension.
 *
 * @see https://www.mediawiki.org/wiki/Extension:PushAll
 *
 * @author Karima Rafes < karima dot rafes@gmail.com >
 */
/* globals mediaWiki jQuery */
( function ( mw, $ ) {
	$( () => {
		// button submit of the section
		const buttonSubmitTab = OO.ui.infuse( $( '#prefcontrol' ) );

		// Section targets in the preferences
		const $section = $( '#mw-prefsection-pushall-pushall-preference-targets' );

		// Field of option pushall-targets in the preferences
		// textarea where we save the array of targets in JSON
		const $targets = $section.find( "textarea[name='wppushall-targets']" );
		$targets.hide();

		// Create a fieldset layout in the page for the list.
		const fieldset = new OO.ui.FieldsetLayout( {
			label: null,
			classes: [ 'container' ]
		} );

		function refreshTargetsList() {
			const valueJson = $targets.val();
			const targets = valueJson === '' ? [] : JSON.parse( valueJson );
			const list = [];
			for ( const key in targets ) {
				list.push( createItemOfTargetActionField( key ) );
			}
			fieldset.clearItems();
			fieldset.addItems( [
				addTargetActionField
			].concat( list ) );
		}
		function parseTargets() {
			const targetsJson = $targets.val();
			let targets = [];
			if ( targetsJson !== '' ) {
				try {
					targets = JSON.parse( targetsJson );
					if ( !Array.isArray( targets ) ) {
						targets = [];
					}
				} catch ( e ) {
					targets = [];
				}
			}
			return targets;
		}
		function addTarget( data ) {
			const targets = parseTargets();
			delete data.action;
			targets.push( data );
			$targets.val( JSON.stringify( targets ) );
			refreshTargetsList();
			buttonSubmitTab.setDisabled( false );
		}
		function removeTarget( keyTarget ) {
			const targets = parseTargets();
			targets.splice( keyTarget, 1 );
			$targets.val( JSON.stringify( targets ) );
			refreshTargetsList();
			buttonSubmitTab.setDisabled( false );
		}
		function modifyTarget( keyTarget, data ) {
			const targets = parseTargets();
			delete data.action;
			targets[ keyTarget ] = data;
			$targets.val( JSON.stringify( targets ) );
			refreshTargetsList();
			buttonSubmitTab.setDisabled( false );
		}

		const description = '<p>' + mw.message( 'prefs-pushall-preference-targets-description' ).parse() + '</p>';
		$section.append( description, fieldset.$element );

		// Creating a process dialog window for saving data about targeted wiki
		function ProcessDialog( config ) {
			ProcessDialog.super.call( this, config );
		}
		OO.inheritClass( ProcessDialog, OO.ui.ProcessDialog );

		// Specify a name for .addWindows()
		ProcessDialog.static.name = 'dialogTarget';
		// Specify a static title and actions.
		ProcessDialog.static.title = 'Targeted wiki';
		ProcessDialog.static.actions = [
			{
				action: 'save',
				label: 'Save',
				flags: [ 'primary', 'progressive' ]
			},
			{
				label: 'Cancel',
				flags: 'safe'
			}
		];
		ProcessDialog.prototype.action = ''; // add, delete, modify
		ProcessDialog.prototype.itemKey = 0; // key of targets in the array

		ProcessDialog.prototype.messageError = new OO.ui.MessageWidget( {
			type: 'error',
			label: 'MessageWidget with comprehensive error message for the user.'
		} );
		ProcessDialog.prototype.messageError.$element.hide();

		ProcessDialog.prototype.wikiNameField =
			new OO.ui.FieldLayout(
				new OO.ui.TextInputWidget( {
					value: '',
					required: true,
					validate: 'non-empty'
				} ), {
					label: mw.msg( 'pushall-preference-dialog-field-wikiname-label' ),
					align: 'top',
					help: mw.msg( 'pushall-preference-dialog-field-help' ) + ' Wikipedia',
					helpInline: true
				} );
		ProcessDialog.prototype.articlePathField =
			new OO.ui.FieldLayout(
				new OO.ui.TextInputWidget( {
					// value: 'Text input',
					required: true,
					validate: /^http.*\/$/
				} ), {
					label: mw.msg( 'pushall-preference-dialog-field-articlepath-label' ),
					align: 'top',
					help: mw.msg( 'pushall-preference-dialog-field-help' ) + ' http://example.org/wiki/',
					helpInline: true
				} );
		ProcessDialog.prototype.endpointField =
			new OO.ui.FieldLayout(
				new OO.ui.TextInputWidget( {
				// value: 'Text input',
					required: true,
					validate: /^http.*\/api\.php$/
				} ), {
					label: mw.msg( 'pushall-preference-dialog-field-endpoint-label' ),
					align: 'top',
					help: mw.msg( 'pushall-preference-dialog-field-help' ) + ' http://example.org//w/api.php',
					helpInline: true
				} );
		ProcessDialog.prototype.loginField =
			new OO.ui.FieldLayout(
				new OO.ui.TextInputWidget( {
					// value: 'Text input',
					required: true,
					validate: /^[^@]*@[^@]*$/
				} ), {
					label: mw.msg( 'pushall-preference-dialog-field-login-label' ),
					align: 'top',
					help: mw.msg( 'pushall-preference-dialog-field-help' ) + ' UsernameInTheWiki@Botname',
					helpInline: true
				} );
		ProcessDialog.prototype.keyField =
			new OO.ui.FieldLayout( new OO.ui.TextInputWidget( {
				type: 'password',
				// value: 'Text input',
				required: true,
				validate: /^[^\s]{32}$/
			} ), {
				label: mw.msg( 'pushall-preference-dialog-field-key-label' ),
				align: 'top',
				help: mw.msg( 'pushall-preference-dialog-field-help' ) + ' ff0000u4feh000002s6t88dh00000fgv',
				helpInline: true
			} );

		// Create the fieldsets of layout in the ProcessDialog.
		ProcessDialog.prototype.fieldsetWiki = new OO.ui.FieldsetLayout( {
			label: null,
			classes: [ 'container' ]
		} );
		ProcessDialog.prototype.fieldsetBot = new OO.ui.FieldsetLayout( {
			label: null,
			classes: [ 'container' ]
		} );

		ProcessDialog.prototype.fieldsetWiki.addItems( [
			ProcessDialog.prototype.messageError,
			ProcessDialog.prototype.wikiNameField,
			ProcessDialog.prototype.articlePathField,
			ProcessDialog.prototype.endpointField
		] );
		ProcessDialog.prototype.fieldsetBot.addItems( [
			new OO.ui.LabelWidget( {
				label: mw.msg( 'pushall-preference-dialog-help-new-bot' )
			} ),
			ProcessDialog.prototype.loginField,
			ProcessDialog.prototype.keyField
		] );

		// Use the initialize() method to add content to the dialog's $body,
		// to initialize widgets, and to set up event handlers.
		ProcessDialog.prototype.initialize = function () {
			ProcessDialog.super.prototype.initialize.apply( this, arguments );
			this.content = new OO.ui.PanelLayout( {
				padded: true,
				expanded: false
			} );

			this.content.$element.append(
				this.fieldsetWiki.$element,
				this.fieldsetBot.$element
			);

			this.$body.append( this.content.$element );
		};

		ProcessDialog.prototype.fieldsInput = [
			'wikiNameField',
			'articlePathField',
			'endpointField',
			'loginField',
			'keyField'
		];

		function clearErrors( dialog ) {
			const fields = ProcessDialog.prototype.fieldsInput;
			for ( const fieldKey in fields ) {
				dialog[ fields[ fieldKey ] ].errors = [];
				dialog[ fields[ fieldKey ] ].updateMessages();
			}
			dialog.messageError.setLabel( '' );
			dialog.messageError.$element.hide();
		}
		function clearFields( dialog ) {
			const fields = ProcessDialog.prototype.fieldsInput;
			for ( const fieldKey in fields ) {
				dialog[ fields[ fieldKey ] ].fieldWidget.setValue( '' );
			}
		}

		function connectEvent() {
			const dialog = ProcessDialog.prototype;
			const fields = ProcessDialog.prototype.fieldsInput;
			for ( const fieldKey in fields ) {
				dialog[ fields[ fieldKey ] ].fieldWidget.on( 'change', () => {
					clearErrors( dialog );
				} );
			}
		}
		// Use getSetupProcess() to set up the window with data passed to it at the time
		// of opening
		ProcessDialog.prototype.getSetupProcess = function ( data ) {
			data = data || { action: 'add' };

			return ProcessDialog.super.prototype.getSetupProcess.call( this, data )
				.next( function () {
					const dialog = this;
					clearFields( dialog );
					clearErrors( dialog );
					dialog.action = 'modify';
					dialog.itemKey = data.itemKey;
					if ( data.action === 'modify' ) {
						const target = JSON.parse( $targets.val() )[ data.itemKey ];
						dialog.wikiNameField.fieldWidget.setValue( target.name );
						dialog.articlePathField.fieldWidget.setValue( target.articlePath );
						dialog.endpointField.fieldWidget.setValue( target.endpoint );
						dialog.loginField.fieldWidget.setValue( target.login );
						dialog.keyField.fieldWidget.setValue( target.key );
					}
				}, this );
		};

		// Use the getActionProcess() method to specify a process to handle the
		// actions
		ProcessDialog.prototype.getActionProcess = function ( action ) {
			const dialog = this;
			clearErrors( dialog );
			if ( action ) {
				const errors = [];
				let message = '';
				if ( dialog.wikiNameField.fieldWidget.value.length === 0 ) {
					message = 'Name cannot be empty.';
					dialog.wikiNameField.errors = [ message ];
					dialog.wikiNameField.updateMessages();
					errors.push( message );
				}

				if ( dialog.action === 'modify' || dialog.action === 'add' ) {
					const targets = parseTargets();
					for ( const targetsKey in targets ) {
						if ( targetsKey !== dialog.itemKey &&
						dialog.wikiNameField.fieldWidget.value === targets[ targetsKey ].name ) {
							message = 'This name already exists.';
							dialog.wikiNameField.errors = [ message ];
							dialog.wikiNameField.updateMessages();
							errors.push( message );
							break;
						}
					}
				}

				if (
					!dialog.articlePathField.fieldWidget.validate
						.test( dialog.articlePathField.fieldWidget.value )
				) {
					message = 'The path has to finish by /';
					dialog.articlePathField.errors = [ message ];
					dialog.articlePathField.updateMessages();
					errors.push( message );
				}
				if (
					!dialog.endpointField.fieldWidget.validate
						.test( dialog.endpointField.fieldWidget.value )
				) {
					message = 'The endpoint has to finish by api.php';
					dialog.endpointField.errors = [ message ];
					dialog.endpointField.updateMessages();
					errors.push( message );
				}
				if (
					!dialog.loginField.fieldWidget.validate
						.test( dialog.loginField.fieldWidget.value )
				) {
					message = 'The login for a bot has to the form UsernameInTheWiki@Botname';
					dialog.loginField.errors = [ message ];
					dialog.loginField.updateMessages();
					errors.push( message );
				}
				if (
					!dialog.keyField.fieldWidget.validate
						.test( dialog.keyField.fieldWidget.value )
				) {
					message = 'The key of your bot has only 32 characters.';
					dialog.keyField.errors = [ message ];
					dialog.keyField.updateMessages();
					errors.push( message );
				}
				if ( errors.length > 0 ) {
					dialog.messageError.setLabel( $( '<ul><li>' + errors.join( '<li>' ) + '</ul>' ) );
					dialog.messageError.$element.show();
				} else {
					return new OO.ui.Process( () => {
						dialog.close( {
							action: action,
							name: dialog.wikiNameField.fieldWidget.value,
							articlePath: dialog.articlePathField.fieldWidget.value,
							endpoint: dialog.endpointField.fieldWidget.value,
							login: dialog.loginField.fieldWidget.value,
							key: dialog.keyField.fieldWidget.value
						} );
					} );
					// return new OO.ui.Process(
					//   function () { return new OO.ui.Error( message , { recoverable: true }) }
					// );
				}
			}
			// Fallback to parent handler.
			return ProcessDialog.super.prototype.getActionProcess.call( this, action );
		};

		// Get dialog height.
		ProcessDialog.prototype.getBodyHeight = function () {
			return this.content.$element.outerHeight( true );
		};

		// Create and append the window manager.
		const windowManager = new OO.ui.WindowManager();
		$( document.body ).append( windowManager.$element );

		// Create a new dialog window.
		const processDialog = new ProcessDialog( {
			size: 'medium'
		} );
		const confirmDeleteDialog = new OO.ui.MessageDialog();
		// Add windows to window manager using the addWindows() method.
		windowManager.addWindows( [ processDialog, confirmDeleteDialog ] );

		// Create form elements (text input, checkbox, submit button, etc.).
		const buttonAddTarget = new OO.ui.ButtonInputWidget( {
			label: mw.msg( 'pushall-preference-targets-button-add' ),
			type: 'button',
			flags: [ 'progressive' ]
		} );
		const addTargetActionField = new OO.ui.ActionFieldLayout(
			new OO.ui.LabelWidget( { label: mw.msg( 'pushall-preference-targets-header' ) } ),
			buttonAddTarget,
			{
				label: null,
				align: 'top'
			}
		);
		buttonAddTarget.on( 'click', () => {
			windowManager.openWindow( processDialog, { action: 'add', itemKey: -1 } ).closed.then( ( data ) => {
				// Code here runs after the window is closed.
				// console.log( data );
				if ( data ) {
					addTarget( data );
				}
			} );
		} );

		function createItemOfTargetActionField( keyTarget ) {
			const buttonModify = new OO.ui.ButtonInputWidget( {
				label: mw.msg( 'pushall-preference-targets-action-field-button-change' ), // $this->msg( 'math-wikibase-special-form-button' ),
				type: 'button',
				flags: [ 'progressive' ]
			} );
			buttonModify.on( 'click', () => {
				windowManager.openWindow( processDialog, { action: 'modify', itemKey: keyTarget } ).closed.then( ( data ) => {
					// Code here runs after the window is closed.
					// console.log( data );
					if ( data ) {
						modifyTarget( keyTarget, data );
					}
				} );
			} );
			const buttonDelete = new OO.ui.ButtonInputWidget( {
				label: mw.msg( 'pushall-preference-targets-action-field-button-delete' ), // $this->msg( 'math-wikibase-special-form-button' ),
				type: 'button',
				flags: [ 'progressive' ]
			} );
			buttonDelete.on( 'click', () => {
				windowManager.openWindow( confirmDeleteDialog, {
					message: mw.msg( 'pushall-preference-dialog-message-remove' )
				} ).closed.then( ( data ) => {
					// Code here runs after the window is closed.
					// console.log( data );
					if ( data && data.action === 'accept' ) {
						removeTarget( keyTarget );
					}
				} );
			} );
			const target = JSON.parse( $targets.val() )[ keyTarget ];
			return new OO.ui.ActionFieldLayout(
				new OO.ui.TextInputWidget( {
					value: target.name,
					readOnly: true
				} )
				,
				new OO.ui.ButtonGroupWidget( {
					items: [ buttonModify, buttonDelete ]
				},
				{
					label: mw.msg( 'pushall-special-category-action-field-top-label' ),
					align: 'top'
				}
				),
				{
					label: null,
					align: 'top'
				}
			);
		}

		connectEvent();
		refreshTargetsList();
	} );
}( mediaWiki, jQuery ) );

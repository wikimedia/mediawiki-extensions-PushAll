/**
 * JavaScript for the PushAll extension.
 *
 * @see https://www.mediawiki.org/wiki/Extension:PushAll
 *
 * @author Karima Rafes < karima dot rafes@gmail.com >
 */
/* globals wgPushAllContents wgPushAllTargets */
( function ( global ) {

	/**
	 * @class
	 * @constructor
	 */
	function PushAll() {
	}

	// properties
	PushAll.status = {
		REMOTE_NOT_EXIST: 'pushall-remote-content-status-not-exist',
		REMOTE_PROTECTED: 'pushall-remote-content-status-protected',
		EQUAL: 'pushall-remote-content-status-equal',
		REMOTE_OBSOLETE: 'pushall-remote-content-status-obsolete',
		REMOTE_DIVERGE: 'pushall-remote-content-status-diverge',
		REMOTE_OBSOLETE_DIVERGE: 'pushall-remote-content-status-obsolete-and-diverge'
	};
	PushAll.api = null;
	PushAll.wgPushAllListContentToPushByTarget = [];
	PushAll.wgPushAllRemotePagesArray = [];

	// functions
	PushAll.getStatusCode = function ( targetName, content, remotePagesArray ) {
		if ( !( content.titlePrefixed in remotePagesArray ) || 'missing' in remotePagesArray[ content.titlePrefixed ] ) {
			return PushAll.status.REMOTE_NOT_EXIST;
		} else {
			const remotePage = remotePagesArray[ content.titlePrefixed ];
			if ( remotePage.protection.length > 0 ) {
				// remote page is protected
				return PushAll.status.REMOTE_PROTECTED;
			} else {
				// remote page is not protected
				if ( content.revisions.length === 0 ) {
					// content never push
					return PushAll.status.REMOTE_OBSOLETE_DIVERGE;
				} else {
					// content already push
					let localCurrentRevId = -1;
					const remoteCurrentRevId = remotePage.lastrevid;
					let localRevIdPushed = -1;
					let remoteRevIdPushed = -1;
					for ( const revisionId in content.revisions ) {
						const revision = content.revisions[ revisionId ];
						if ( revisionId === '0' ) {
							localCurrentRevId = revision.revid;
						}
						if ( targetName in revision.push ) {
							localRevIdPushed = revision.revid;
							remoteRevIdPushed = revision.push[ targetName ].revid;
							break;
						}
					}
					if ( localRevIdPushed === -1 || remoteRevIdPushed === -1 ) {
						return PushAll.status.REMOTE_OBSOLETE_DIVERGE;
					} else {
						if ( localCurrentRevId === localRevIdPushed ) {
							// no evolution in local since the last push
							if ( remoteRevIdPushed === remoteCurrentRevId ) {
								// no evolution in the target since the last push
								return PushAll.status.EQUAL;
							} else {
								// there is an evolution in the target since the last push
								return PushAll.status.REMOTE_DIVERGE;
							}
						} else {
							// there is an evolution in local since the last push
							if ( remoteRevIdPushed === remoteCurrentRevId ) {
								// no evolution in the target since the last push
								return PushAll.status.REMOTE_OBSOLETE;
							} else {
								// there is an evolution in the target since the last push
								return PushAll.status.REMOTE_OBSOLETE_DIVERGE;
							}
						}
					}
				}
			}
		}
	};
	PushAll.getColor = function ( status ) {
		let result = '';
		switch ( status ) {
			case PushAll.status.REMOTE_NOT_EXIST:
				result = 'green';
				break;
			case PushAll.status.REMOTE_PROTECTED:
				result = 'purple';
				break;
			case PushAll.status.EQUAL:
				result = 'chartreuse';
				break;
			case PushAll.status.REMOTE_OBSOLETE:
				result = 'green';
				break;
			case PushAll.status.REMOTE_DIVERGE:
				result = 'red';
				break;
			case PushAll.status.REMOTE_OBSOLETE_DIVERGE:
				result = 'darkorange';
				break;
		}
		return result;
	};
	PushAll.getCheckboxPropChecked = function ( status, alreadyChecked, force = false ) {
		if ( force ) {
			return alreadyChecked;
		}
		let result = null;
		switch ( status ) {
			case PushAll.status.REMOTE_PROTECTED:
			case PushAll.status.EQUAL:
			case PushAll.status.REMOTE_DIVERGE:
			case PushAll.status.REMOTE_OBSOLETE_DIVERGE:
				result = false;
				break;
			case PushAll.status.REMOTE_NOT_EXIST:
			case PushAll.status.REMOTE_OBSOLETE:
				result = alreadyChecked;
				break;
		}
		return result;
	};
	PushAll.getCheckboxAttrDisabled = function ( status, force = false ) {
		if ( force ) {
			return false;
		}
		let result = null;
		switch ( status ) {
			case PushAll.status.REMOTE_PROTECTED:
			case PushAll.status.EQUAL:
			case PushAll.status.REMOTE_DIVERGE:
			case PushAll.status.REMOTE_OBSOLETE_DIVERGE:
				result = true;
				break;
			case PushAll.status.REMOTE_NOT_EXIST:
			case PushAll.status.REMOTE_OBSOLETE:
				result = false;
				break;
		}
		return result;
	};
	PushAll.setLinkClass = function ( status, $link ) {
		switch ( status ) {
			case PushAll.status.REMOTE_PROTECTED:
			case PushAll.status.EQUAL:
			case PushAll.status.REMOTE_OBSOLETE:
			case PushAll.status.REMOTE_DIVERGE:
			case PushAll.status.REMOTE_OBSOLETE_DIVERGE:
				$link.toggleClass( 'new', false );
				break;
			case PushAll.status.REMOTE_NOT_EXIST:
				$link.toggleClass( 'new', true );
				break;
		}
	};
	PushAll.getMsgTooltipCheckbox = function ( status, isChecked, force = false ) {
		let result = null;
		if ( force ) {
			if ( isChecked ) {
				result = 'pushall-checkbox-tooltip-will-push';
			} else {
				result = 'pushall-checkbox-tooltip-wont-push';
			}
		} else {
			switch ( status ) {
				case PushAll.status.REMOTE_PROTECTED:
					result = 'pushall-checkbox-tooltip-push-not-allowed-remote-protected';
					break;
				case PushAll.status.EQUAL:
					result = 'pushall-checkbox-tooltip-push-useless';
					break;
				case PushAll.status.REMOTE_DIVERGE:
				case PushAll.status.REMOTE_OBSOLETE_DIVERGE:
					result = 'pushall-checkbox-tooltip-push-not-allowed-remote-diverge-need-option-force';
					break;
				case PushAll.status.REMOTE_NOT_EXIST:
				case PushAll.status.REMOTE_OBSOLETE:
					result = 'pushall-checkbox-tooltip-will-push';
					break;
			}
		}
		return result;
	};
	PushAll.refreshContentsToPush = function () {
		PushAll.wgPushAllListContentToPushByTarget.splice(
			0,
			PushAll.wgPushAllListContentToPushByTarget.length
		);
		for ( const targetName in wgPushAllTargets ) {
			PushAll.wgPushAllListContentToPushByTarget[ targetName ] = { files: [], pages: [] };
			PushAll.collectContentsToPush( wgPushAllTargets[ targetName ], wgPushAllContents );
		}
		// console.log( PushAll.wgPushAllListContentToPushByTarget );
	};
	PushAll.collectContentsToPush = function ( target, contents ) {
		for ( const titlePrefixed in contents ) {
			const content = contents[ titlePrefixed ];
			const $checkbox = $( '#target' + target.id + 'content' + content.id );
			if ( $checkbox.is( ':checked' ) && !$checkbox.is( ':disabled' ) ) {
				PushAll.wgPushAllListContentToPushByTarget[ target.name ]
					.pages.push( titlePrefixed );
				if ( content.isFile ) {
					PushAll.wgPushAllListContentToPushByTarget[ target.name ]
						.files.push( titlePrefixed );
				}
			}
			PushAll.collectContentsToPush( target, content.contents );
		}
	};

	// functions for tools
	PushAll.expandItem = function ( idTarget, idContent ) {
		$( '#toggletarget' + idTarget + 'content' + idContent + '.mw-collapsible-toggle-collapsed' ).trigger( 'click' );
	};
	PushAll.expandItemId = function ( id ) {
		$( '#toggle' + id + '.mw-collapsible-toggle-collapsed' ).trigger( 'click' );
	};
	PushAll.collapseItem = function ( idTarget, idContent ) {
		$( '#toggletarget' + idTarget + 'content' + idContent + '.mw-collapsible-toggle-expanded' ).trigger( 'click' );
	};
	PushAll.expand = function ( target, contents ) {
		for ( const titlePrefixed in contents ) {
			const content = contents[ titlePrefixed ];
			PushAll.expandItem( target.id, content.id );
			PushAll.expand( target, content.contents );
		}
	};
	PushAll.checkall = function ( target, contents ) {
		for ( const titlePrefixed in contents ) {
			const content = contents[ titlePrefixed ];
			PushAll.check( target, content );
			PushAll.checkall( target, content.contents );
		}
	};
	PushAll.uncheckall = function ( target, contents ) {
		for ( const titlePrefixed in contents ) {
			const content = contents[ titlePrefixed ];
			PushAll.uncheck( target, content );
			PushAll.uncheckall( target, content.contents );
		}
	};
	PushAll.isChecked = function ( target, content ) {
		return $( '#target' + target.id + 'content' + content.id ).is( ':checked' );
	};
	PushAll.check = function ( target, content ) {
		if ( !PushAll.isChecked( target, content ) ) {
			$( '#target' + target.id + 'content' + content.id ).trigger( 'click' );
		}
	};
	PushAll.uncheck = function ( target, content ) {
		if ( PushAll.isChecked( target, content ) ) {
			$( '#target' + target.id + 'content' + content.id ).trigger( 'click' );
		}
	};
	PushAll.collapse = function ( target, contents ) {
		if ( Object.keys( contents ).length === 0 ) {
			return false; // expanded
		} else {
			let result = false;
			for ( const titlePrefixed in contents ) {
				const content = contents[ titlePrefixed ];
				if ( PushAll.isChecked( target, content ) ) {
					PushAll.expandItem( target.id, content.id );
					PushAll.collapse( target, content.contents );
					result = true;
				} else {
					const subTreeResult = PushAll.collapse( target, content.contents );
					if ( subTreeResult ) {
						PushAll.expandItem( target.id, content.id );
					} else {
						PushAll.collapseItem( target.id, content.id );
					}
					result = result || subTreeResult;
				}
			}
			return result;
		}
	};
	PushAll.includeAll = function ( property ) {
		for ( const targetName in wgPushAllTargets ) {
			PushAll.include( property, wgPushAllTargets[ targetName ], wgPushAllContents );
		}
	};
	PushAll.include = function ( property, target, contents ) {
		for ( const titlePrefixed in contents ) {
			const content = contents[ titlePrefixed ];
			if ( content[ property ] ) {
				PushAll.check( target, content );
			}
			PushAll.include( property, target, content.contents );
		}
	};
	PushAll.excludeAll = function ( property ) {
		for ( const targetName in wgPushAllTargets ) {
			PushAll.exclude( property, wgPushAllTargets[ targetName ], wgPushAllContents );
		}
	};
	PushAll.exclude = function ( property, target, contents ) {
		for ( const titlePrefixed in contents ) {
			const content = contents[ titlePrefixed ];
			if ( content[ property ] ) {
				PushAll.uncheck( target, content );
			}
			PushAll.exclude( property, target, content.contents );
		}
	};
	// function for requests
	PushAll.concatTitlesOfPages = function ( targetName ) {
		const result = [];
		const pagesToPush = PushAll.wgPushAllListContentToPushByTarget[ targetName ].pages;
		for ( const key in pagesToPush ) {
			result.push( pagesToPush[ key ] );
		}
		return result.join( '|' );
	};
	PushAll.concatTitlesOfFiles = function ( targetName ) {
		const result = [];
		const filesToPush = PushAll.wgPushAllListContentToPushByTarget[ targetName ].files;
		for ( const key in filesToPush ) {
			result.push( filesToPush[ key ] );
		}
		return result.join( '|' );
	};
	PushAll.concatTitlesOfContents = function () {
		const result = [];
		for ( const contentName in wgPushAllContents ) {
			result.push( contentName );
		}
		return result.join( '|' );
	};
	PushAll.concatNamesOfTargets = function () {
		const result = [];
		for ( const targetName in wgPushAllTargets ) {
			result.push( targetName );
		}
		return result.join( '|' );
	};
	PushAll.cleanErrors = function () {
		const $errorPushAll = $( '#errorpushall' );
		$errorPushAll.hide();
		$errorPushAll.text( '' );
		for ( const targetName in wgPushAllTargets ) {
			const $errorTarget = $( '#errorpushalltarget' + wgPushAllTargets[ targetName ].id );
			$errorTarget.hide();
			$errorTarget.text( '' );
		}
	};
	PushAll.handleError = function ( errorCode, details ) {
		const $errorDiv = $( '#errorpushall' );
		if ( errorCode === 'pushall-error-api-known' ) {
			if ( 'target' in details.error && 'msg' in details.error ) {
				const $errorTargetDiv = $( '#errorpushalltarget' + wgPushAllTargets[ details.error.target ].id );
				// Messages that can be used here:
				// * todo doc
				// eslint-disable-next-line mediawiki/msg-doc
				$errorTargetDiv.append( mw.msg( details.error.msg ) );
				$errorTargetDiv.show();
				PushAll.displayStatusUnknownForTarget(
					wgPushAllTargets[ details.error.target ],
					wgPushAllContents
				);
			} else if ( 'title' in details.error && 'msg' in details.error ) {
				// Messages that can be used here:
				// * todo doc
				// eslint-disable-next-line mediawiki/msg-doc
				$errorDiv.append( mw.msg( details.error.msg, details.error.title ) );
				$errorDiv.show();
			}
		} else {
			if ( 'target' in details.error && details.error.target !== '' && 'text' in details.error ) {
				const $errorTargetDiv = $( '#errorpushalltarget' + wgPushAllTargets[ details.error.target ].id );
				$errorTargetDiv.append( details.error.text );
				$errorTargetDiv.show();
				PushAll.displayStatusUnknownForTarget(
					wgPushAllTargets[ details.error.target ],
					wgPushAllContents
				);
			} else if ( 'text' in details.error ) {
				$errorDiv.append( details.error.text );
				$errorDiv.show();
				PushAll.displayStatusUnknownForAllContents( wgPushAllContents );
			} else if ( 'info' in details.error ) {
				$errorDiv.append( details.error.info );
				$errorDiv.show();
				PushAll.displayStatusUnknownForAllContents( wgPushAllContents );
			}
		}
	};
	PushAll.displayStatusUnknownForTarget = function ( target, contents ) {
		for ( const contentName in contents ) {
			const content = contents[ contentName ];
			const $statusicon = $( '#statusicontarget' + target.id + 'content' + content.id );
			$statusicon.css( 'background-color', 'black' );
			const $statusMessage = $( '#statusmessagetarget' + target.id + 'content' + content.id );
			//  TODO Remote status unknown.
			$statusMessage.text( mw.msg( 'pushall-remote-content-status-unknown' ) );
			PushAll.displayStatusUnknownForAllContents( content.contents );
		}
	};
	PushAll.displayStatusUnknownForAllContents = function ( contents ) {
		for ( const targetName in wgPushAllTargets ) {
			const target = wgPushAllTargets[ targetName ];
			PushAll.displayStatusUnknownForTarget( target, contents );
		}
	};
	PushAll.setRevisions = function ( contents, revisionsData ) {
		for ( const contentName in contents ) {
			if ( contentName in revisionsData ) {
				contents[ contentName ].revisions = revisionsData[ contentName ].revisions;
			}
			PushAll.setRevisions( contents[ contentName ].contents, revisionsData );
		}
	};
	PushAll.displayInfoContent = function ( target, contents, remotePagesArray, force = false ) {
		for ( const contentName in contents ) {
			const content = contents[ contentName ];

			// refresh revisions
			const $revisions = $( '#revisionstarget' + target.id + 'content' + content.id );
			const revisionsContent = contents[ contentName ].revisions;
			let htmlRevisions = '';
			let findPush = false;
			for ( const key in revisionsContent ) {
				const revision = revisionsContent[ key ];

				htmlRevisions += "<div style='font-size: 0.9em;font-family: sans-serif;'>" +
					revision.timestamp + '-' + revision.user;
				if ( revision.comment !== null && revision.comment !== '' ) {
					htmlRevisions += '-' + revision.comment;
				}
				htmlRevisions += '&nbsp;(' + revision.len + ')';

				if ( target.name in revision.push ) {
					htmlRevisions += '&nbsp;<b>Pushed ' + revision.push[ target.name ].timestamp + '</b>';
					findPush = true;
					break;
				}
				htmlRevisions += '</div>';
			}
			if ( !findPush ) {
				htmlRevisions = '';
			}
			$revisions.html( htmlRevisions );

			// refresh icon and resume
			// make a red link if the page doesn't exist
			const $link = $( '#linktarget' + target.id + 'content' + content.id );
			const $statusMessage = $( '#statusmessagetarget' + target.id + 'content' + content.id );
			const $statusicon = $( '#statusicontarget' + target.id + 'content' + content.id );
			const $checkbox = $( '#target' + target.id + 'content' + content.id );

			const remoteStatus = PushAll.getStatusCode( target.name, content, remotePagesArray );
			$checkbox.prop( 'checked', PushAll.getCheckboxPropChecked( remoteStatus, $checkbox.is( ':checked' ), force ) );
			$checkbox.attr( 'disabled', PushAll.getCheckboxAttrDisabled( remoteStatus, force ) );

			// todo doc
			// Messages that can be used here:
			// *
			// eslint-disable-next-line mediawiki/msg-doc
			$statusMessage.text( mw.msg( remoteStatus ) );
			$statusicon.css( 'background-color', PushAll.getColor( remoteStatus ) );
			PushAll.setLinkClass( remoteStatus, $link );
			PushAll.displayInfoContent( target, content.contents, remotePagesArray, force );
			$checkbox.attr(
				'title',
				// todo doc
				// Messages that can be used here:
				// *
				// eslint-disable-next-line mediawiki/msg-doc
				mw.msg( PushAll.getMsgTooltipCheckbox( remoteStatus, $checkbox.is( ':checked' ), force ) )
			);
		}
	};
	PushAll.doPushAll = function ( buttonPushAll ) {
		PushAll.cleanErrors();
		buttonPushAll.disabled = true;
		const targetName = $( buttonPushAll ).attr( 'targetname' );
		buttonPushAll.innerHTML = mw.msg( 'pushall-button-pushing' );
		const titles = PushAll.concatTitlesOfPages( targetName );
		const files = PushAll.concatTitlesOfFiles( targetName );

		if ( titles === '' && files === '' ) {
			buttonPushAll.innerHTML = mw.msg( 'pushall-button-nothing-to-push' );
			buttonPushAll.disabled = false;
			return;
		}

		const params = {
			action: 'pushall',
			target: targetName,
			titles: titles,
			files: files
		};

		PushAll.api.get( params )
			.done( ( data ) => {
				buttonPushAll.innerHTML = mw.msg( 'pushall-button-completed' );
				PushAll.setRevisions( wgPushAllContents, data );
				PushAll.refreshInfo();
				buttonPushAll.disabled = false;
			} )
			.fail( ( errorCode, details ) => {
				buttonPushAll.innerHTML = mw.msg( 'pushall-button-failed' );
				PushAll.handleError( errorCode, details );
				buttonPushAll.disabled = false;
			} );
	};
	PushAll.refreshInfo = function () {
		const params = {
			action: 'pushallinfo',
			targets: PushAll.concatNamesOfTargets(),
			titles: PushAll.concatTitlesOfContents()
		};
		PushAll.api.get( params )
			.done( ( data ) => {
				// console.log( data );
				for ( const targetName in wgPushAllTargets ) {
					const target = wgPushAllTargets[ targetName ];
					// clean
					PushAll.wgPushAllRemotePagesArray.splice(
						0,
						PushAll.wgPushAllRemotePagesArray.length
					);
					if (
						data[ targetName ].query &&
						data[ targetName ].query.pages
					) {
						const remotePages = data[ targetName ].query.pages;
						for ( const keyPage in remotePages ) {
							PushAll.wgPushAllRemotePagesArray[ remotePages[ keyPage ].title ] =
								remotePages[ keyPage ];
						}
					}
					PushAll.displayInfoContent( target, wgPushAllContents, PushAll.wgPushAllRemotePagesArray, $( '#forcePush' ).is( ':checked' ) );
					PushAll.refreshContentsToPush();
				}
			} )
			.fail( ( errorCode, details ) => {
				PushAll.handleError( errorCode, details );
			} );
	};
	/**
	 * initialize all events and analyze all contents in each targets
	 */
	PushAll.initialize = function () {
		// check if the targets table exists
		if ( typeof wgPushAllContents === 'undefined' || typeof wgPushAllTargets === 'undefined' ) {
			return;
		}
		// debug
		// console.log( wgPushAllContents );
		// console.log( wgPushAllTargets );

		PushAll.api = new mw.Api();

		$( '#buttonExpandAll' ).on( 'click', () => {
			for ( const targetName in wgPushAllTargets ) {
				PushAll.expand( wgPushAllTargets[ targetName ], wgPushAllContents );
			}
		} );
		$( '#buttonCollapseAll' ).on( 'click', () => {
			for ( const targetName in wgPushAllTargets ) {
				PushAll.collapse( wgPushAllTargets[ targetName ], wgPushAllContents );
			}
			$( window ).scrollTop( 0 );
		} );

		$( '#buttonCheckAll' ).on( 'click', () => {
			for ( const targetName in wgPushAllTargets ) {
				PushAll.checkall( wgPushAllTargets[ targetName ], wgPushAllContents );
			}
		} );
		$( '#buttonUncheckAll' ).on( 'click', () => {
			for ( const targetName in wgPushAllTargets ) {
				PushAll.uncheckall( wgPushAllTargets[ targetName ], wgPushAllContents );
			}
		} );
		$( '#buttonIncludeSubpages' ).on( 'click', () => {
			PushAll.includeAll( 'isSubpage' );
		} );
		$( '#buttonExcludeSubpages' ).on( 'click', () => {
			PushAll.excludeAll( 'isSubpage' );
		} );
		$( '#buttonIncludeFiles' ).on( 'click', () => {
			PushAll.includeAll( 'isFile' );
		} );
		$( '#buttonExcludeFiles' ).on( 'click', () => {
			PushAll.excludeAll( 'isFile' );
		} );
		$( '#buttonIncludeTemplates' ).on( 'click', () => {
			PushAll.includeAll( 'isTemplate' );
		} );
		$( '#buttonExcludeTemplates' ).on( 'click', () => {
			PushAll.excludeAll( 'isTemplate' );
		} );
		$( '#buttonIncludeAttachedNamespaces' ).on( 'click', () => {
			PushAll.includeAll( 'isAttachedPageByNamespace' );
		} );
		$( '#buttonExcludeAttachedNamespaces' ).on( 'click', () => {
			PushAll.excludeAll( 'isAttachedPageByNamespace' );
		} );

		const $table = $( '#pushall-table' );
		$table.find( '.pushallCheckContent' ).on( 'click', function () {
			PushAll.refreshContentsToPush();
			PushAll.expandItemId( $( this ).attr( 'id' ) );
		} );

		const $allButton = $table.find( '.pushallButton' );
		$allButton.on( 'click', function () {
			PushAll.doPushAll( this );
		} );
		$( '#pushall-all-button' ).on( 'click', () => {
			$allButton.trigger( 'click' );
		} );

		$( '#forcePush' ).on( 'click', () => {
			for ( const targetName in wgPushAllTargets ) {
				const target = wgPushAllTargets[ targetName ];
				PushAll.displayInfoContent( target, wgPushAllContents, PushAll.wgPushAllRemotePagesArray, $( '#forcePush' ).is( ':checked' ) );
			}
			PushAll.refreshContentsToPush();
		} );
		PushAll.refreshInfo();
		PushAll.refreshContentsToPush();
	};

	if ( typeof module !== 'undefined' && module.exports ) {
		module.exports = PushAll;
	} else {
		global.PushAll = PushAll;
	}
}( this ) );

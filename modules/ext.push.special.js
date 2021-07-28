// noinspection JSUnresolvedVariable

/**
 * JavaScript for Special:Push in the Push extension.
 *
 * @see https://www.mediawiki.org/wiki/Extension:Push
 *
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 * @author Karima Rafes <karima.rafes at gmail dot com>
 */
/* globals mediaWiki:true wgScriptPath:false jQuery */
( function ( $ ) {
	$( function () {

		// Compatibility with pre-RL code.
		// Messages will have been loaded into wgPushMessages.
		if ( typeof mediaWiki === 'undefined' ) {
			const mediaWiki = {};

			mediaWiki.msg = function () {
				let message = window.wgPushMessages[ arguments[ 0 ] ];

				for ( let i = arguments.length - 1; i > 0; i-- ) {
					message = message.replace( '$' + i, arguments[ i ] );
				}

				return message;
			};
		}

		const $resultList = $( '#pushresultList' );

		const targets = [];
		for ( const targetName in Object.keys( window.wgPushTargets ) ) {
			targets.push( window.wgPushTargets[ targetName ] );
		}

		const pages = window.wgPushPages;

		let requestAmount = Math.min( pages.length, window.wgPushWorkerCount );
		const batchSize = Math.min( targets.length, window.wgPushBatchSize );

		const pushedFiles = [];

		for ( let i = requestAmount; i > 0; i-- ) {
			initiateNextPush();
		}

		function initiateNextPush() {
			const page = pages.pop();

			if ( page ) {
				startPush( page, 0, null );
			} else if ( !--requestAmount ) {
				showCompletion();
			}
		}

		function appendAndScroll( item ) {
			const $box = $( '#pushResultDiv' );
			// eslint-disable-next-line no-jquery/no-global-selector
			const $innerBox = $( '#pushResultDiv > .innerResultBox' );
			const atBottom =
				( Math.abs( $innerBox.offset().top ) + $box.height() + $box.offset().top ) >=
				$innerBox.outerHeight();

			$resultList.append( item );

			if ( atBottom ) {
				$box.attr( { scrollTop: $box.attr( 'scrollHeight' ) } );
			}
		}

		function startPush( pageName, targetOffset, listItem ) {
			if ( targetOffset === 0 ) {
				const $listItem = $( '<li>' );
				$listItem.text( mediaWiki.msg( 'push-special-item-pushing', pageName ) );
				appendAndScroll( $listItem );
			}

			const currentBatchLimit = Math.min( targetOffset + batchSize, targets.length );
			const currentBatchStart = targetOffset;

			if ( targetOffset < targets.length ) {
				listItem.text( listItem.text() + '...' );

				targetOffset = currentBatchLimit;

				$.getJSON(
					wgScriptPath + '/api.php',
					{
						action: 'push',
						format: 'json',
						page: pageName,
						targets: targets.slice( currentBatchStart, currentBatchLimit ).join( '|' )
					},
					function ( data ) {
						if ( data.error ) {
							handleError( listItem, pageName, data.error );
						} else if ( data.length > 0 && data[ 0 ].edit && data[ 0 ].edit.captcha ) {
							handleError( listItem, pageName, { info: mediaWiki.msg( 'push-err-captcha-page', pageName ) } );
						} else {
							startPush( pageName, targetOffset, listItem );
						}
					}
				);
			} else {
				if ( window.wgPushIncFiles ) {
					getIncludedImagesAndInitPush( pageName, listItem );
				} else {
					completeItem( pageName, listItem );
				}
			}
		}

		function getIncludedImagesAndInitPush( pageName, listItem ) {
			listItem.text( mediaWiki.msg( 'push-special-obtaining-fileinfo', pageName ) );

			$.getJSON(
				wgScriptPath + '/api.php',
				{
					action: 'query',
					prop: 'images',
					format: 'json',
					titles: pageName,
					imlimit: 500
				},
				function ( data ) {
					if ( data.query ) {
						const images = [];

						for ( const page in Object.keys( data.query.pages ) ) {
							const d = data.query.pages;
							if ( d[ page ].images ) {
								for ( let i = d[ page ].images.length - 1; i >= 0; i-- ) {
									const title = d[ page ].images[ i ].title;
									if ( pushedFiles.indexOf( title ) === -1 ) {
										pushedFiles.push( title );
										images.push( title );
									}
								}
							}
						}

						if ( images.length > 0 ) {
							const currentFile = images.pop();
							startFilePush( pageName, images, 0, listItem, currentFile );
						} else {
							completeItem( pageName, listItem );
						}
					} else {
						handleError( pageName, { info: mediaWiki.msg( 'push-special-err-imginfo-failed' ) } );
					}
				}
			);
		}

		function startFilePush( pageName, images, targetOffset, listItem, fileName ) {
			if ( targetOffset === 0 ) {
				listItem.text( mediaWiki.msg( 'push-special-pushing-file', pageName, fileName ) );
			} else {
				listItem.text( listItem.text() + '...' );
			}

			const currentBatchLimit = Math.min( targetOffset + batchSize, targets.length );
			const currentBatchStart = targetOffset;

			if ( targetOffset < targets.length ) {
				listItem.text( listItem.text() + '...' );

				targetOffset = currentBatchLimit;

				$.getJSON(
					wgScriptPath + '/api.php',
					{
						action: 'pushimages',
						format: 'json',
						images: fileName,
						targets: targets.slice( currentBatchStart, currentBatchLimit ).join( '|' )
					},
					function ( data ) {
						let fail = false;

						if ( data.error ) {
							handleError( listItem, pageName, { info: mediaWiki.msg( 'push-tab-err-filepush', data.error.info ) } );
							fail = true;
						} else {
							for ( const i in Object.keys( data ) ) {
								if ( data[ i ].error ) {
									handleError( listItem, pageName, { info: mediaWiki.msg( 'push-tab-err-filepush', data[ i ].error.info ) } );
									fail = true;
									break;
								} else if ( !data[ i ].upload ) {
									handleError( listItem, pageName, { info: mediaWiki.msg( 'push-tab-err-filepush-unknown' ) } );
									fail = true;
									break;
								}
							}
						}

						if ( !fail ) {
							startFilePush( pageName, images, targetOffset, listItem, fileName );
						}
					}
				);
			} else {
				if ( images.length > 0 ) {
					const currentFile = images.pop();
					startFilePush( pageName, images, 0, listItem, currentFile );
				} else {
					completeItem( pageName, listItem );
				}
			}
		}

		function completeItem( pageName, listItem ) {
			listItem.text( mediaWiki.msg( 'push-special-item-completed', pageName ) );
			listItem.css( 'color', 'darkgray' );
			initiateNextPush();
		}

		function handleError( listItem, pageName, error ) {
			listItem.text( mediaWiki.msg( 'push-special-item-failed', pageName, error.info ) );
			listItem.css( 'color', 'darkred' );
			initiateNextPush();
		}

		function showCompletion() {
			appendAndScroll( $( '<li>' ).append( $( '<b>' ).text( mediaWiki.msg( 'push-special-push-done' ) ) ) );
		}

	} );
}( jQuery ) );

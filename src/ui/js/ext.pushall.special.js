/**
 * JavaScript for the PushAll extension.
 *
 * @see https://www.mediawiki.org/wiki/Extension:PushAll
 *
 * @author Karima Rafes < karima dot rafes@gmail.com >
 */
/* globals mediaWiki jQuery */
const PushAll = require( 'ext.pushall' );
( function ( mw, $ ) {
	$( () => {

		const api = new mw.Api();
		const $titles = $( '#pushallTitles' ).find( 'textarea[name="pushallTitles"]' );

		function handleError( errorCode ) {
			const $errorDiv = $( '#errorpushallspecial' );
			// todo doc
			// Messages that can be used here:
			// *
			// eslint-disable-next-line mediawiki/msg-doc
			$errorDiv.append( mw.msg( errorCode ) );
			$errorDiv.show();
		}

		$( '#pushallCategoryAddButton' ).on( 'click', () => {
			// console.log($('#pushallCategorySelector input[type="search"]').val());
			const categorySelected = $( '#pushallCategorySelector' ).find( 'input[type="search"]' ).val();
			if ( categorySelected && categorySelected !== '' ) {
				const params = {
					action: 'query',
					list: 'categorymembers',
					cmtitle: categorySelected
				};
				api.get( params )
					.done( ( data ) => {
						const titles = $titles.val() !== '' ? $titles.val().split( '\n' ).filter( ( n ) => n ) : [];
						for ( const key in data.query.categorymembers ) {
							titles.push( data.query.categorymembers[ key ].title );
						}
						$titles.val( [ ...new Set( titles ) ].join( '\n' ) );
					} )
					.fail( ( errorCode ) => {
						handleError( errorCode );
					} );
			}
		} );

		$( '#pushallNamespaceAddButton' ).on( 'click', () => {
			const namespaceSelected = $( '#pushallNamespaceSelector' )
				.find( 'select[name="pushallNamespaceSelector"]' ).on( 'option:selected' ).val();
			if ( namespaceSelected >= 0 ) {
				const params = {
					action: 'query',
					list: 'allpages',
					aplimit: 500,
					apnamespace: namespaceSelected
				};
				api.get( params )
					.done( ( data ) => {
						const titles = $titles.val() !== '' ? $titles.val().split( '\n' ).filter( ( n ) => n ) : [];
						for ( const key in data.query.allpages ) {
							titles.push( data.query.allpages[ key ].title );
						}
						$titles.val( [ ...new Set( titles ) ].join( '\n' ) );
					} )
					.fail( ( errorCode ) => {
						handleError( errorCode );
					} );
			}
		} );

		$( '#pushallPageAddButton' ).on( 'click', () => {
			const pageSelected = $( '#pushallPageSelector' ).find( 'input[type="search"]' ).val();
			if ( pageSelected && pageSelected !== '' ) {
				const titles = $titles.val() !== '' ? $titles.val().split( '\n' ).filter( ( n ) => n ) : [];
				titles.push( pageSelected );
				$titles.val( [ ...new Set( titles ) ].join( '\n' ) );
			}
		} );

		PushAll.initialize();
	} );
}( mediaWiki, jQuery ) );

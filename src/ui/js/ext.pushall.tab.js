/**
 * JavaScript for the PushAll extension.
 *
 * @see https://www.mediawiki.org/wiki/Extension:PushAll
 *
 * @author Karima Rafes < karima dot rafes@gmail.com >
 */
const PushAll = require( 'ext.pushall' );
/* globals jQuery */
( function ( $ ) {
	$( function () {
		PushAll.initialize();
	} );
}( jQuery ) );

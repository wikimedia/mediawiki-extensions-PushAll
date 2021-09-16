/* eslint-env node */
global.PushAll = require( '../../src/ui/js/ext.pushall.js' );
const jsdom = require( 'jsdom' );
global.$ = require( 'jquery' )( new jsdom.JSDOM().window );

/**
 * JavaScript for the PushAll extension.
 *
 * @see https://www.mediawiki.org/wiki/Extension:PushAll
 *
 * @author Karima Rafes < karima dot rafes@gmail.com >
 */
( function () {
	'use strict';

	/**
	 * @class
	 * @extends OO.ui.TextInputWidget
	 * @mixin OO.ui.mixin.LookupElement
	 *
	 * @constructor
	 * @param {Object} [config] Configuration options
	 * @cfg {mw.Api} [api] API object to use, creates a mw.ForeignApi instance if not specified
	 */
	mw.widgets.PushallPageSelector = function ( config ) {
		config = config || {};
		this.api = new mw.Api();
		OO.ui.TextInputWidget.call( this, config );
		OO.ui.mixin.LookupElement.call( this, config );
		this.$element.addClass( 'mw-widget-PushallPageSelector' );
	};
	OO.inheritClass( mw.widgets.PushallPageSelector, OO.ui.TextInputWidget );
	OO.mixinClass( mw.widgets.PushallPageSelector, OO.ui.mixin.LookupElement );
	/**
	 * Get the API object for mediawiki requests
	 *
	 * @return {mw.Api} MediaWiki API
	 */
	mw.widgets.PushallPageSelector.prototype.getApi = function () {
		return this.api;
	};
	/**
	 * Get the current value of the search query
	 *
	 * @abstract
	 * @return {string} Search query
	 */
	mw.widgets.PushallPageSelector.prototype.getQueryValue = function () {
		return this.getValue();
	};
	/**
	 * @inheritdoc OO.ui.mixin.LookupElement
	 */
	mw.widgets.PushallPageSelector.prototype.getLookupCacheDataFromResponse =
		function ( response ) {
			if ( response.query && response.query.prefixsearch ) {
				const obj = response.query.prefixsearch;
				return Object.keys( obj ).map( ( e ) => obj[ e ] );
			} else {
				return [];
			}
		};
	/**
	 * @inheritdoc OO.ui.mixin.LookupElement
	 */
	mw.widgets.PushallPageSelector.prototype.getLookupMenuOptionsFromData = function ( response ) {
		return response.map( ( res ) => new OO.ui.MenuOptionWidget( { data: res.title, label: res.title
			// , title: res.description
		} ) );
	};
	/**
	 * Get API params for a given query
	 *
	 * @param {string} query User query
	 * @return {Object} API params
	 */
	mw.widgets.PushallPageSelector.prototype.getApiParams = function ( query ) {
		return {
			pssearch: query,
			action: 'query',
			list: 'prefixsearch',
			psnamespace: '*',
			format: 'json'
			// action=query&list=prefixsearch&pssearch=Star%20Wars [try in ApiSandbox]
		};
	};
	/**
	 * @inheritdoc
	 */
	mw.widgets.PushallPageSelector.prototype.getLookupRequest = function () {
		const
			api = this.getApi(),
			query = this.getQueryValue(),
			widget = this,
			promiseAbortObject = {
				abort: function () {
					// Do nothing. This is just so OOUI doesn't break due to abort being undefined.
					// see also mw.widgets.TitleWidget.prototype.getSuggestionsPromise
				}
			},
			req = api.get( widget.getApiParams( query ) );
		promiseAbortObject.abort = req.abort.bind( req );
		return req.promise( promiseAbortObject );
	};

	const $pushallPageSelector = $( '#pushallPageSelector' );
	if ( $pushallPageSelector.length ) {
		OO.ui.infuse( $pushallPageSelector );
	}
}() );

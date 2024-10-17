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
	mw.widgets.PushallCategorySelector = function ( config ) {
		config = config || {};
		this.api = new mw.Api();
		OO.ui.TextInputWidget.call( this, config );
		OO.ui.mixin.LookupElement.call( this, config );
		this.$element.addClass( 'mw-widget-PushallCategorySelector' );
	};
	OO.inheritClass( mw.widgets.PushallCategorySelector, OO.ui.TextInputWidget );
	OO.mixinClass( mw.widgets.PushallCategorySelector, OO.ui.mixin.LookupElement );
	/**
	 * Get the API object for mediawiki requests
	 *
	 * @return {mw.Api} MediaWiki API
	 */
	mw.widgets.PushallCategorySelector.prototype.getApi = function () {
		return this.api;
	};
	/**
	 * Get the current value of the search query
	 *
	 * @abstract
	 * @return {string} Search query
	 */
	mw.widgets.PushallCategorySelector.prototype.getQueryValue = function () {
		return this.getValue();
	};
	/**
	 * @inheritdoc OO.ui.mixin.LookupElement
	 */
	mw.widgets.PushallCategorySelector.prototype.getLookupCacheDataFromResponse =
		function ( response ) {
			if ( response.query && response.query.pages ) {
				const obj = response.query.pages;
				return Object.keys( obj ).map( ( e ) => obj[ e ] );
			} else {
				return [];
			}
		};
	/**
	 * @inheritdoc OO.ui.mixin.LookupElement
	 */
	mw.widgets.PushallCategorySelector.prototype.getLookupMenuOptionsFromData =
		function ( response ) {
			return response.map( ( res ) => new OO.ui.MenuOptionWidget( { data: res.title, label: res.title } ) );
		};
	/**
	 * Get API params for a given query
	 *
	 * @param {string} query User query
	 * @return {Object} API params
	 */
	mw.widgets.PushallCategorySelector.prototype.getApiParams = function ( query ) {
		return {
			gacprefix: query,
			action: 'query',
			generator: 'allcategories',
			format: 'json'
		};
	};
	/**
	 * @inheritdoc
	 */
	mw.widgets.PushallCategorySelector.prototype.getLookupRequest = function () {
		const api = this.getApi(),
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
	const $pushallCategorySelector = $( '#pushallCategorySelector' );
	if ( $pushallCategorySelector.length ) {
		OO.ui.infuse( $pushallCategorySelector );
	}
}() );

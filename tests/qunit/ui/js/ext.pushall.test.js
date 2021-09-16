/* globals QUnit PushAll */
QUnit.module( 'PushAll' );

const LOCAL_PAGE =
	{
		titlePrefixed: 'Page1',
		revisions: [
			{
				revid: 53,
				push: {
					target1: {
						revid: 68
					}
				}
			}
		]
	};

const LOCAL_PAGE_WITH_REMOTE_OBSOLETE =
	{
		titlePrefixed: 'Page1',
		revisions: [
			{
				revid: 54,
				push: { }
			},
			{
				revid: 53,
				push: {
					target1: {
						revid: 68
					}
				}
			}
		]
	};

const LOCAL_PAGE_WITH_REMOTE_DIVERGE =
	{
		titlePrefixed: 'Page1',
		revisions: [
			{
				revid: 53,
				push: {
					target1: {
						revid: 67
					}
				}
			}
		]
	};

const LOCAL_PAGE_WITH_REMOTE_OBSOLETE_AND_DIVERGE =
	{
		titlePrefixed: 'Page1',
		revisions: [
			{
				revid: 54,
				push: { }
			},
			{
				revid: 53,
				push: {
					target1: {
						revid: 67
					}
				}
			}
		]
	};

const REMOTE_PAGE_DOES_NOT_EXIT1 = {};
const REMOTE_PAGE_DOES_NOT_EXIT2 = {
	Page1: {
		missing: ''
	}
};
const REMOTE_PAGE_PROTECTED = {
	Page1: {
		protection: [
			'sysop'
		]
	}
};
const REMOTE_PAGE = {
	Page1: {
		lastrevid: 68,
		protection: []
	}
};

/* eslint-disable */
// const REMOTE_PAGE_DOES_NOT_EXIT =
// {
//	"Test push": {
//		"pageid": 2,
//		"ns": 0,
//		"title": "Test push",
//		"revisions": [
//			{
//				"revid": 68,
//				"parentid": 67,
//				"user": "UserData",
//				"timestamp": "2021-09-07T10:11:05Z",
//				"comment": "Pushed from Wiki.",
//				"tags": []
//			}
//		],
//		"contentmodel": "wikitext",
//		"pagelanguage": "en",
//		"pagelanguagehtmlcode": "en",
//		"pagelanguagedir": "ltr",
//		"touched": "2021-09-07T10:11:05Z",
//		"lastrevid": 68,
//		"length": 163,
//		"protection": [],
//		"restrictiontypes": [
//			"edit",
//			"move"
//		]
//	},
//	"Data:Test push": {
//		"pageid": 28,
//		"ns": 10000,
//		"title": "Data:Test push",
//		"revisions": [
//			{
//				"revid": 70,
//				"parentid": 0,
//				"user": "UserData",
//				"timestamp": "2021-09-07T12:21:12Z",
//				"comment": "Pushed from Wiki.",
//				"tags": []
//			}
//		],
//		"contentmodel": "wikitext",
//		"pagelanguage": "en",
//		"pagelanguagehtmlcode": "en",
//		"pagelanguagedir": "ltr",
//		"touched": "2021-09-07T12:21:12Z",
//		"lastrevid": 70,
//		"length": 4,
//		"new": "",
//		"protection": [],
//		"restrictiontypes": [
//			"edit",
//			"move"
//		]
//	}
// };
/* eslint-enable */

QUnit.test( 'get status pushall-remote-content-status-not-exist', ( assert ) => {
	assert.equal( PushAll.getStatusCode( 'target1', LOCAL_PAGE, REMOTE_PAGE_DOES_NOT_EXIT1 ), 'pushall-remote-content-status-not-exist' );
	assert.equal( PushAll.getStatusCode( 'target1', LOCAL_PAGE, REMOTE_PAGE_DOES_NOT_EXIT2 ), 'pushall-remote-content-status-not-exist' );
} );

QUnit.test( 'get status pushall-remote-content-exists-status-protected', ( assert ) => {
	assert.equal( PushAll.getStatusCode( 'target1', LOCAL_PAGE, REMOTE_PAGE_PROTECTED ), 'pushall-remote-content-status-protected' );
} );

QUnit.test( 'get status pushall-remote-exists-content-status-equal', ( assert ) => {
	assert.equal( PushAll.getStatusCode( 'target1', LOCAL_PAGE, REMOTE_PAGE ), 'pushall-remote-content-status-equal' );
} );

QUnit.test( 'get status pushall-remote-content-status-obsolete', ( assert ) => {
	assert.equal( PushAll.getStatusCode( 'target1', LOCAL_PAGE_WITH_REMOTE_OBSOLETE, REMOTE_PAGE ), 'pushall-remote-content-status-obsolete' );
} );

QUnit.test( 'get status pushall-remote-content-status-diverge', ( assert ) => {
	assert.equal( PushAll.getStatusCode( 'target1', LOCAL_PAGE_WITH_REMOTE_DIVERGE, REMOTE_PAGE ), 'pushall-remote-content-status-diverge' );
} );

QUnit.test( 'get status pushall-remote-content-status-obsolete-and-diverge', ( assert ) => {
	assert.equal( PushAll.getStatusCode( 'target1', LOCAL_PAGE_WITH_REMOTE_OBSOLETE_AND_DIVERGE, REMOTE_PAGE ), 'pushall-remote-content-status-obsolete-and-diverge' );
} );

QUnit.test( 'get always a color', ( assert ) => {
	for ( const code in PushAll.status ) {
		assert.notEqual( PushAll.getColor( PushAll.status[ code ] ), '' );
	}
} );
QUnit.test( 'get getCheckboxAttrDisabled', ( assert ) => {
	for ( const code in PushAll.status ) {
		assert.notEqual( PushAll.getCheckboxAttrDisabled( PushAll.status[ code ] ), null );
	}
} );
QUnit.test( 'get CheckboxPropChecked', ( assert ) => {
	for ( const code in PushAll.status ) {
		assert.notEqual( PushAll.getCheckboxPropChecked( PushAll.status[ code ], true ), null );
	}
} );
QUnit.test( 'get MsgTooltipCheckbox', ( assert ) => {
	for ( const code in PushAll.status ) {
		assert.notEqual( PushAll.getMsgTooltipCheckbox( PushAll.status[ code ], true ), null );
	}
} );

QUnit.test( 'get  LinkClass', ( assert ) => {
	/* eslint-disable */
	const $link = $( '<a>' );
	$link.addClass( 'mw-title' );
	assert.equal( $link.hasClass( 'mw-title' ), true );
	for ( const code in PushAll.status ) {
		PushAll.setLinkClass( PushAll.status[ code ], $link );
		assert.equal( $link.hasClass( 'mw-title' ), true );
	}
	PushAll.setLinkClass( PushAll.status.REMOTE_NOT_EXIST, $link );
	assert.equal( $link.hasClass( 'new' ), true );
	/* eslint-enable */
} );

<?php
/**
 * Initialization file for the Push extension.
 *
 * Documentation:	 		http://www.mediawiki.org/wiki/Extension:Push
 * Support					http://www.mediawiki.org/wiki/Extension_talk:Push
 * Source code:             http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/Push
 *
 * @file Push.php
 * @ingroup Push
 *
 * @license GPL-3.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documentation group collects source code files belonging to Push.
 *
 * @defgroup Push Push
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

define( 'Push_VERSION', '1.2.0 alpha' );

$wgExtensionCredits['other'][] = [
	'path' => __FILE__,
	'name' => 'Push',
	'version' => Push_VERSION,
	'author' => [
		'[http://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw] for [http://www.wikiworks.com WikiWorks]',
	],
	'url' => 'https://www.mediawiki.org/wiki/Extension:Push',
	'descriptionmsg' => 'push-desc'
];

$useExtensionPath = version_compare( $wgVersion, '1.16', '>=' ) && isset( $wgExtensionAssetsPath ) && $wgExtensionAssetsPath;
$egPushScriptPath = ( $useExtensionPath ? $wgExtensionAssetsPath : $wgScriptPath . '/extensions' ) . '/Push';
$egPushIP = __DIR__;
unset( $useExtensionPath );

$wgMessagesDirs['Push'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['PushAlias'] 			= $egPushIP . '/Push.alias.php';

$wgAutoloadClasses['PushHooks'] 			= $egPushIP . '/Push.hooks.php';
$wgAutoloadClasses['ApiPushBase'] 			= $egPushIP . '/api/ApiPushBase.php';
$wgAutoloadClasses['ApiPush'] 				= $egPushIP . '/api/ApiPush.php';
$wgAutoloadClasses['ApiPushImages'] 		= $egPushIP . '/api/ApiPushImages.php';
$wgAutoloadClasses['PushTab'] 				= $egPushIP . '/includes/Push_Tab.php';
$wgAutoloadClasses['PushFunctions'] 		= $egPushIP . '/includes/Push_Functions.php';
$wgAutoloadClasses['SpecialPush'] 			= $egPushIP . '/specials/Push_Body.php';

$wgSpecialPages['Push'] = 'SpecialPush';

$wgAPIModules['push'] = 'ApiPush';
$wgAPIModules['pushimages'] = 'ApiPushImages';

$wgHooks['UnknownAction'][] = 'PushTab::onUnknownAction';
$wgHooks['SkinTemplateTabs'][] = 'PushTab::displayTab';
$wgHooks['SkinTemplateNavigation'][] = 'PushTab::displayTab2';

$wgHooks['AdminLinks'][] = 'PushHooks::addToAdminLinks';

$wgAvailableRights[] = 'push';
$wgAvailableRights[] = 'pushadmin';
$wgAvailableRights[] = 'filepush';
$wgAvailableRights[] = 'bulkpush';

$egPushJSMessages = [
	'push-button-pushing',
	'push-button-completed',
	'push-button-failed',
	'push-import-revision-message',
	'push-button-text',
	'push-button-all',
	'push-special-item-pushing',
	'push-special-item-completed',
	'push-special-item-failed',
	'push-special-push-done',
	'push-err-captacha',
	'push-tab-last-edit',
	'push-tab-not-created',
	'push-err-captcha-page',
	'push-button-pushing-files',
	'push-special-err-imginfo-failed',
	'push-special-obtaining-fileinfo',
	'push-special-pushing-file',
	'push-tab-err-fileinfo',
	'push-tab-err-filepush',
	'push-tab-err-filepush-unknown',
	'push-tab-embedded-files',
	'push-tab-no-embedded-files',
	'push-tab-files-override',
	'push-tab-template-override',
	'push-tab-err-uploaddisabled'
];

// For backward compatibility with MW < 1.17.
if ( defined( 'MW_SUPPORTS_RESOURCE_MODULES' ) ) {
	$moduleTemplate = [
		'localBasePath' => __DIR__,
		'remoteBasePath' => $egPushScriptPath,
		'group' => 'ext.push'
	];

	$wgResourceModules['ext.push.tab'] = $moduleTemplate + [
		'scripts' => 'includes/ext.push.tab.js',
		'dependencies' => [ 'mediawiki.jqueryMsg' ],
		'messages' => $egPushJSMessages
	];

	$wgResourceModules['ext.push.special'] = $moduleTemplate + [
		'scripts' => 'specials/ext.push.special.js',
		'dependencies' => [],
		'messages' => $egPushJSMessages
	];
}

require_once 'Push_Settings.php';

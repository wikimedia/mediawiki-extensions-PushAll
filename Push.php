<?php
/**
 * Initialization file for the Push extension.
 *
 * Documentation: https://www.mediawiki.org/wiki/Extension:Push
 * Support: https://www.mediawiki.org/wiki/Extension_talk:Push
 * Source code: https://phabricator.wikimedia.org/diffusion/EPUS
 *
 * @file Push.php
 * @ingroup Push
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

/**
 * This documentation group collects source code files belonging to Push.
 *
 * @defgroup Push Push
 */

if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'Push' );
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['Push'] = __DIR__ . '/i18n';
	wfWarn(
		'Deprecated PHP entry point used for the Push extension. ' .
		'Please use wfLoadExtension instead, ' .
		'see https://www.mediawiki.org/wiki/Extension_registration for more details.'
	);
	return;
} else {
	die( 'This version of the Push extension requires MediaWiki 1.29+' );
}
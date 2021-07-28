<?php
/**
 * Documentation:	 		https://www.mediawiki.org/wiki/Extension:PushAll
 * Support					https://www.mediawiki.org/wiki/Extension_talk:Push
 * Source code:             http://svn.wikimedia.org/viewvc/mediawiki/trunk/extensions/Push
 *
 * @file Push.php
 * @ingroup Push
 *
 * @license GPL-3.0-or-later
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Karima Rafes < karima.rafes@gmail.com >
 */

class Push {
	public static function makeConfig() {
		return new GlobalVarConfig( 'egPushAll' );
	}
}

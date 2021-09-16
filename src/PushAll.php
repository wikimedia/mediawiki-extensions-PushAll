<?php
/**
 * Documentation:	 		https://www.mediawiki.org/wiki/Extension:PushAll
 * Support					https://www.mediawiki.org/wiki/Extension_talk:PushAll
 * Source code:             https://github.com/BorderCloud/PushAll
 * Inspired of the extension push (author :[https://www.mediawiki.org/wiki/User:Jeroen_De_Dauw Jeroen De Dauw])
 *
 * @file PushAll.php
 * @ingroup PushAll
 *
 * @license GPL-3.0-or-later
 * @author Karima Rafes < karima.rafes@gmail.com >
 */

use MediaWiki\MediaWikiServices;

/**
 * Class PushAll
 */
class PushAll {

	/**
	 * This option saves a array of remote wikis with credentials of user's bots for these wikis.
	 */
	public const OPTION_TARGETS = 'pushall-targets';

	/**
	 * This option saves a bool to show the push action as a tab or else in a dropdown .
	 * This only works for skins with an actions dropdown. For others push will always appear as a tab.
	 */
	public const OPTION_SHOW_TAB = 'pushall-showtab';

	/**
	 * This option saves to include by default templates when pushing a page.
	 */
	public const OPTION_DEFAULT_INC_TEMPLATES = 'pushall-defaultIncTemplates';

	/**
	 * This option saves to include attached pages by their namespaces (such as discussion pages) when pushing a page.
	 */
	public const OPTION_DEFAULT_INC_ATTACHED_NAMESPACES = 'pushall-defaultIncAttachedNamespaces';

	/**
	 * This option saves to include by default subpages when pushing a page.
	 */
	public const OPTION_DEFAULT_INC_SUBPAGES = 'pushall-defaultIncSubpages';

	/**
	 * You can choose to include by default files when pushing a page.
	 */
	public const OPTION_DEFAULT_INC_FILES = 'pushall-defaultIncFiles';

	/**
	 * Configuration of the extension in the local wiki
	 * @var Config
	 */
	private static $config;

	/**
	 * Array of attached namespaces in the wiki
	 *
	 * Example for attaching the namespace Data and Discussion to put in the localsettings.php :
	 * $egPushAllAttachedNamespaces[] = "Data";
	 * $egPushAllAttachedNamespaces[] = "Discussion";
	 *
	 * @var array
	 */
	private static $attachedNamespaces;

	/**
	 * Options manager
	 * @var User\UserOptionsManager
	 */
	private static $userOptionsManager;

	/**
	 * Remote wikis of user
	 * @var PushAllTargets
	 */
	private static $userTargets;

	/**
	 * Make the configuration of the extension.
	 *
	 * @return GlobalVarConfig
	 */
	public static function makeConfig() {
		return new GlobalVarConfig( 'egPushAll' );
	}

	/**
	 * Initialize the variables in the class
	 */
	private static function init() {
		self::$config = MediaWikiServices::getInstance()->getConfigFactory()->makeConfig( 'egPushAll' );
		self::$userOptionsManager = MediaWikiServices::getInstance()->getUserOptionsManager();
		self::$attachedNamespaces = self::$config->get( "AttachedNamespaces" );
	}

	/**
	 * Check if the user has the right to see the tab page or the special page.
	 * Todo: may be create a new user right to use this extension ?
	 *
	 * @param User $user
	 * @return bool
	 */
	public static function isAllowedToPush( User $user ) {
		return self::getTargets( $user )->count() > 0;
	}

	/**
	 * Get the configuration
	 *
	 * @return Config
	 */
	public static function getConfig() {
		if ( !self::$config ) {
			self::init();
		}
		return self::$config;
	}

	/**
	 * Get the remote wikis inserted by the user in his preferences
	 *
	 * @param User $user
	 * @return PushAllTargets
	 */
	public static function getTargets( User $user ): PushAllTargets {
		if ( !self::$config ) {
			self::init();
		}
		if ( !self::$userTargets ) {
			$targetsJson = self::$userOptionsManager->getOption( $user, self::OPTION_TARGETS );
			$targets = new PushAllTargets();
			if ( !empty( $targetsJson ) ) {
				$targetsArray = json_decode( $targetsJson, true );
				foreach ( $targetsArray as $infoTarget ) {
					$targets->addTarget( $infoTarget['name'],
						new PushAllTarget(
							$infoTarget['name'],
							$infoTarget['endpoint'],
							$infoTarget['articlePath'],
							$infoTarget['login'],
							$infoTarget['key']
						) );
				}
			}
			self::$userTargets = $targets;
		}
		return self::$userTargets;
	}

	/**
	 * Get option if the user want see the tab in the menu
	 *
	 * @param User $user
	 * @return bool
	 */
	public static function isPrefUserShowTab( User $user ): bool {
		if ( !self::$config ) {
			self::init();
		}
		return self::$userOptionsManager->getOption( $user, self::OPTION_SHOW_TAB );
	}

	/**
	 * Get option if the user want include by default the templates
	 *
	 * @param User $user
	 * @return bool
	 */
	public static function isPrefUserIncTemplates( User $user ): bool {
		if ( !self::$config ) {
			self::init();
		}
		return self::$userOptionsManager->getOption( $user, self::OPTION_DEFAULT_INC_TEMPLATES );
	}

	/**
	 * Get option if the user want include by default the templates
	 *
	 * @param User $user
	 * @return bool
	 */
	public static function isPrefUserIncAttachedNamespaces( User $user ): bool {
		if ( !self::$config ) {
			self::init();
		}
		return self::$userOptionsManager->getOption( $user, self::OPTION_DEFAULT_INC_ATTACHED_NAMESPACES );
	}

	/**
	 * Get option if the user want include by default the subpages
	 *
	 * @param User $user
	 * @return bool
	 */
	public static function isPrefUserIncSubpages( User $user ): bool {
		if ( !self::$config ) {
			self::init();
		}
		return self::$userOptionsManager->getOption( $user, self::OPTION_DEFAULT_INC_SUBPAGES );
	}

	/**
	 * Get option if the user want include by default the files
	 *
	 * @param User $user
	 * @return bool
	 */
	public static function isPrefUserIncFiles( User $user ): bool {
		if ( !self::$config ) {
			self::init();
		}
		return self::$userOptionsManager->getOption( $user, self::OPTION_DEFAULT_INC_FILES );
	}

	/**
	 * Get attached namespaces in the local wiki
	 *
	 * @return array
	 */
	public static function getAttachedNamespaces() {
		if ( !self::$config ) {
			self::init();
		}
		return self::$attachedNamespaces;
	}

	/**
	 * Reset the configuration for tests
	 */
	public static function clean() {
		self::$config = null;
	}
}

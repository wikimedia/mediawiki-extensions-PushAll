<?php
/**
 * Static class with methods to create and handle the pushall tab.
 *
 * @file TabPushAll.php
 * @ingroup PushAll
 *
 * @author Karima Rafes < karima.rafes@gmail.com >
 */

use MediaWiki\Title\Title;

/**
 * Class TabPushAll
 */
final class TabPushAll {
	/**
	 * The function called if we're in index.php with the action push
	 *
	 * @param OutputPage $output
	 * @param Article $article
	 * @param Title $title
	 * @param User $user
	 * @return false
	 * @throws MWException
	 */
	public static function display( OutputPage $output, Article $article, Title $title, User $user ) {
		$output->setPageTitle( wfMessage( 'pushall-tab-title', $title->getText() )->parse() );

		// todo ?
		// if (! PushAll::isAllowedToPush($this->getUser())) {
		//	throw new PermissionsError( 'pushall' );
		//}

		$output->addHTML( '<p>' . wfMessage( 'pushall-tab-desc' )->escaped() . '</p>' );
		$output->addModules( 'ext.pushall.tab' );
		PushAllComponents::formPushAll( $output, $user, [ $title->getPrefixedText() ] );
		return false;
	}
}

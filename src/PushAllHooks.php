<?php
/**
 * PushAllHooks manages all hooks of the extension
 *
 * @file PushAllHooks.php
 * @ingroup PushAll
 *
 * @author Karima Rafes < karima.rafes@gmail.com >
 */

/**
 * Class PushAllHooks
 */
final class PushAllHooks {

	/**
	 * Adds an "action" (i.e., a tab) to allow pushing the current page.
	 *
	 * @param SkinTemplate $sktemplate
	 * @param array &$links
	 */
	public static function onSkinTemplateNavigationUniversal( SkinTemplate $sktemplate, array &$links ) {
		// Make sure that this is not a special page, the page has contents, and the user can push.
		$title = $sktemplate->getTitle();
		$user = $sktemplate->getUser();
		if (
			$title
			&& $title->getNamespace() !== NS_SPECIAL
			&& $title->exists()
			&& PushAll::isAllowedToPush( $user )
		) {
			$location = PushAll::isPrefUserShowTab( $user ) ? 'views' : 'actions';
			$links[$location]['pushall'] = [
				'text' => wfMessage( 'pushall-tab-text' )->text(),
				'class' => $sktemplate->getRequest()->getVal( 'action' ) == 'pushall' ? 'selected' : '',
				'href' => $title->getLocalURL( 'action=pushall' )
			];
		}
	}

	/**
	 * Function for opening the pushall page
	 *
	 * @param OutputPage $output
	 * @param Article $article
	 * @param Title $title
	 * @param User $user
	 * @param Request $request
	 * @param Mediawiki $mediaWiki
	 * @return bool
	 */
	public static function onMediaWikiPerformAction(
		$output, $article, $title, $user, $request, $mediaWiki ) {
		if ( $mediaWiki->getAction() === 'nosuchaction' ) {
			if ( $request->getText( 'action' ) === 'pushall' ) {
				return TabPushAll::display( $output, $article, $title, $user );
			}
		}
		return true;
	}

	/**
	 * Register the tags
	 *
	 * @param array &$tags
	 * @return bool
	 */
	public static function onRegisterTags( array &$tags ) {
		$tags[] = 'pushall-push';
		return true;
	}

	/**
	 * Register the preferences
	 *
	 * @param User $user
	 * @param array &$preferences
	 * @return bool
	 */
	public static function onGetPreferences( $user, &$preferences ) {
		$preferences[PushAll::OPTION_TARGETS] = [
			'type'  => 'textarea',
			'section' => 'pushall/pushall-preference-targets'
		];

		$preferences[PushAll::OPTION_SHOW_TAB] = [
			'type'  => 'toggle',
			'label-message' => 'pushall-preference-showtab-label',
			'defaultValue' => false,
			'section' => 'pushall/pushall-preference-parameters'
		];
		$preferences[PushAll::OPTION_DEFAULT_INC_TEMPLATES] = [
			'type'  => 'toggle',
			'label-message' => 'pushall-preference-defaultinctemplates-label',
			'defaultValue' => false,
			'section' => 'pushall/pushall-preference-parameters'
		];
		$preferences[PushAll::OPTION_DEFAULT_INC_ATTACHED_NAMESPACES] = [
			'type'  => 'toggle',
			'label-message' => 'pushall-preference-defaultincattachednamespaces-label',
			'defaultValue' => false,
			'section' => 'pushall/pushall-preference-parameters'
		];
		$preferences[PushAll::OPTION_DEFAULT_INC_SUBPAGES] = [
			'type'  => 'toggle',
			'label-message' => 'pushall-preference-defaultincsubpages-label',
			'defaultValue' => false,
			'section' => 'pushall/pushall-preference-parameters'
		];
		$preferences[PushAll::OPTION_DEFAULT_INC_FILES] = [
			'type'  => 'toggle',
			'label-message' => 'pushall-preference-defaultincfiles-label',
			'defaultValue' => false,
			'section' => 'pushall/pushall-preference-parameters'
		];
		// defaultValue
		return true;
	}

	/**
	 * Load a module when the special page preferences is loaded by the user.
	 * @param OutputPage $out
	 * @param Skin $skin
	 */
	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		if ( $out->getTitle()->isSpecial( 'Preferences' ) ) {
			$out->addModules( 'ext.pushall.preferences' );
		}
	}
}

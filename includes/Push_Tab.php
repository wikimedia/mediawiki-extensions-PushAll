<?php

/**
 * Static class with methods to create and handle the push tab.
 *
 * @since 0.1
 *
 * @file Push_Tab.php
 * @ingroup Push
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
final class PushTab {

	/**
	 * Adds an "action" (i.e., a tab) to allow pushing the current article.
	 */
	public static function displayTab( $obj, &$content_actions ) {
		global $wgUser, $egPushTargets;

		/**
		 * Make sure that this is not a special page, the page has contents, and the user can push.
		 *
		 * @var Title $title
		 */
		$title = $obj->getTitle();
		if (
			$title->getNamespace() !== NS_SPECIAL
			&& $title->exists()
			&& $wgUser->isAllowed( 'push' )
			&& count( $egPushTargets ) > 0 ) {

			global $wgRequest;

			$content_actions['push'] = [
				'text' => wfMessage( 'push-tab-text' )->text(),
				'class' => $wgRequest->getVal( 'action' ) == 'push' ? 'selected' : '',
				'href' => $title->getLocalURL( 'action=push' )
			];
		}

		return true;
	}

	/**
	 * Function currently called only for the 'Vector' skin, added in
	 * MW 1.16 - will possibly be called for additional skins later
	 */
	public static function displayTab2( $obj, &$links ) {
		global $egPushShowTab;

		// The old '$content_actions' array is thankfully just a sub-array of this one
		$views_links = $links[$egPushShowTab ? 'views' : 'actions'];
		self::displayTab( $obj, $views_links );
		$links[$egPushShowTab ? 'views' : 'actions'] = $views_links;

		return true;
	}

	/**
	 * Handle actions not known to MediaWiki. If the action is push,
	 * display the push page by calling the displayPushPage method.
	 *
	 * @param string $action
	 * @param Article $article
	 *
	 * @return true
	 */
	public static function onUnknownAction( $action, Article $article ) {
		if ( $action !== 'push' ) {
			return true;
		}

		return self::displayPushPage( $article );
	}

	/**
	 * The function called if we're in index.php (as opposed to one of the
	 * special pages)
	 *
	 * @since 0.1
	 */
	public static function displayPushPage( Article $article ) {
		global $wgOut, $wgUser, $wgTitle, $wgSitename, $egPushTargets;

		$wgOut->setPageTitle( wfMessage( 'push-tab-title', $article->getTitle()->getText() )->parse() );

		if ( !$wgUser->isAllowed( 'push' ) ) {
			throw new PermissionsError( 'push' );
		}

		$wgOut->addHTML( '<p>' . wfMessage( 'push-tab-desc' )->escaped() . '</p>' );

		if ( count( $egPushTargets ) == 0 ) {
			$wgOut->addHTML( '<p>' . wfMessage( 'push-tab-no-targets' )->escaped() . '</p>' );
			return false;
		}

		$wgOut->addModules( 'ext.push.tab' );

		$wgOut->addHTML(
			Html::hidden( 'pageName', $wgTitle->getFullText(), [ 'id' => 'pageName' ] ) .
			Html::hidden( 'siteName', $wgSitename, [ 'id' => 'siteName' ] )
		);

		self::displayPushList();

		self::displayPushOptions();

		return false;
	}

	/**
	 * Displays a list with all targets to which can be pushed.
	 *
	 * @since 0.1
	 */
	protected static function displayPushList() {
		global $wgOut, $egPushTargets;

		$items = [
			Html::rawElement(
				'tr',
				[],
				Html::element(
					'th',
					[ 'width' => '200px' ],
					wfMessage( 'push-targets' )->text()
				) .
				Html::element(
					'th',
					[ 'style' => 'min-width:400px;' ],
					wfMessage( 'push-remote-pages' )->text()
				) .
				Html::element(
					'th',
					[ 'width' => '125px' ],
					''
				)
			)
		];

		foreach ( $egPushTargets as $name => $url ) {
			$items[] = self::getPushItem( $name, $url );
		}

		// If there is more then one item, display the 'push all' row.
		if ( count( $egPushTargets ) > 1 ) {
			$items[] = Html::rawElement(
				'tr',
				[],
				Html::element(
					'th',
					[ 'colspan' => 2, 'style' => 'text-align: left' ],
					wfMessage( 'push-targets-total' )->numParams( count( $egPushTargets ) )->parse()
				) .
				Html::rawElement(
					'th',
					[ 'width' => '125px' ],
					Html::element(
						'button',
						[
							'id' => 'push-all-button',
							'style' => 'width: 125px; height: 30px',
						],
						wfMessage( 'push-button-all' )->text()
					)
				)
			);
		}

		$wgOut->addHTML(
			Html::rawElement(
				'table',
				[ 'class' => 'wikitable', 'width' => '50%' ],
				implode( "\n", $items )
			)
		);
	}

	/**
	 * Returns the HTML for a single push target.
	 *
	 * @since 0.1
	 *
	 * @param string $name
	 * @param string $url
	 *
	 * @return string
	 */
	protected static function getPushItem( $name, $url ) {
		global $wgTitle;

		static $targetId = 0;
		$targetId++;

		return Html::rawElement(
			'tr',
			[],
			Html::element(
				'td',
				[],
				$name
			) .
			Html::rawElement(
				'td',
				[ 'height' => '45px' ],
				Html::element(
					'a',
					[
						'href' => $url . '/index.php?title=' . $wgTitle->getFullText(),
						'rel' => 'nofollow',
						'id' => 'targetlink' . $targetId
					],
					wfMessage( 'push-remote-page-link', $wgTitle->getFullText(), $name )->parse()
				) .
				Html::element(
					'div',
					[
						'id' => 'targetinfo' . $targetId,
						'style' => 'display:none; color:darkgray'
					]
				) .
				Html::element(
					'div',
					[
						'id' => 'targettemplateconflicts' . $targetId,
						'style' => 'display:none; color:darkgray'
					]
				) .
				Html::element(
					'div',
					[
						'id' => 'targetfileconflicts' . $targetId,
						'style' => 'display:none; color:darkgray'
					]
				) .
				Html::element(
					'div',
					[
						'id' => 'targeterrors' . $targetId,
						'style' => 'display:none; color:darkred'
					]
				)
			) .
			Html::rawElement(
				'td',
				[],
				Html::element(
					'button',
					[
						'class' => 'push-button',
						'pushtarget' => $url,
						'style' => 'width: 125px; height: 30px',
						'targetid' => $targetId,
						'targetname' => $name
					],
					wfMessage( 'push-button-text' )->text()
				)
			)
		);
	}

	/**
	 * Outputs the HTML for the push options.
	 *
	 * @since 0.4
	 */
	protected static function displayPushOptions() {
		global $wgOut, $wgUser, $wgTitle;

		$wgOut->addHTML( '<h3>' . wfMessage( 'push-tab-push-options' )->escaped() . '</h3>' );

		$usedTemplates = array_keys(
			PushFunctions::getTemplates(
				[ $wgTitle->getFullText() ],
				[ $wgTitle->getFullText() => true ]
			)
		);

		// Get rid of the page itself.
		array_shift( $usedTemplates );

		self::displayIncTemplatesOption( $usedTemplates );

		if ( $wgUser->isAllowed( 'filepush' ) ) {
			self::displayIncFilesOption( $usedTemplates );
		}
	}

	/**
	 * Outputs the HTML for the "include templates" option.
	 *
	 * @since 0.4
	 *
	 * @param array $templates
	 */
	protected static function displayIncTemplatesOption( array $templates ) {
		global $wgOut, $wgLang, $egPushIncTemplates;

		$wgOut->addInlineScript(
			'var wgPushTemplates = ' . FormatJson::encode( $templates ) . ';'
		);

		foreach ( $templates as &$template ) {
			$template = "[[$template]]";
		}

		$wgOut->addHTML(
			Html::rawElement(
				'div',
				[ 'id' => 'divIncTemplates', 'style' => 'display: table-row' ],
				Xml::check( 'checkIncTemplates', $egPushIncTemplates, [ 'id' => 'checkIncTemplates' ] ) .
				Html::element(
					'label',
					[ 'id' => 'lblIncTemplates', 'for' => 'checkIncTemplates' ],
					wfMessage( 'push-tab-inc-templates' )->text()
				) .
				'&#160;' .
				Html::rawElement(
					'div',
					[ 'style' => 'display:none; opacity:0', 'id' => 'txtTemplateList' ],
					count( $templates ) > 0 ?
						wfMessage( 'push-tab-used-templates',
							$wgLang->listToText( $templates ), count( $templates ) )->parse() :
							wfMessage( 'push-tab-no-used-templates' )->escaped()
				)
			)
		);
	}

	/**
	 * Outputs the HTML for the "include files" option.
	 *
	 * @since 0.4
	 *
	 * @param array $templates
	 */
	protected static function displayIncFilesOption( array $templates ) {
		global $wgOut, $wgTitle, $egPushIncFiles, $wgScript;

		$allFiles = self::getImagesForPages( [ $wgTitle->getFullText() ] );
		$templateFiles = self::getImagesForPages( $templates );
		$pageFiles = [];

		foreach ( $allFiles as $file ) {
			if ( !in_array( $file, $templateFiles ) ) {
				$pageFiles[] = $file;
			}
		}

		$wgOut->addInlineScript(
			'var wgPushPageFiles = ' . FormatJson::encode( $pageFiles ) . ';' .
			'var wgPushTemplateFiles = ' . FormatJson::encode( $templateFiles ) . ';' .
			'var wgPushIndexPath = ' . FormatJson::encode( $wgScript )
		);

		$wgOut->addHTML(
			Html::rawElement(
				'div',
				[ 'id' => 'divIncFiles', 'style' => 'display: table-row' ],
				Xml::check( 'checkIncFiles', $egPushIncFiles, [ 'id' => 'checkIncFiles' ] ) .
				Html::element(
					'label',
					[ 'id' => 'lblIncFiles', 'for' => 'checkIncFiles' ],
					wfMessage( 'push-tab-inc-files' )->text()
				) .
				'&#160;' .
				Html::rawElement(
					'div',
					[ 'style' => 'display:none; opacity:0', 'id' => 'txtFileList' ],
					''
				)
			)
		);
	}

	/**
	 * Returns the names of the images embedded in a set of pages.
	 *
	 * @param array $pages
	 *
	 * @return array
	 */
	protected static function getImagesForPages( array $pages ) {
		$images = [];

		$requestData = [
			'action' => 'query',
			'format' => 'json',
			'prop' => 'images',
			'titles' => implode( '|', $pages ),
			'imlimit' => 500
		];

		$api = new ApiMain( new FauxRequest( $requestData, true ), true );
		$api->execute();
		if ( defined( 'ApiResult::META_CONTENT' ) ) {
			$response = $api->getResult()->getResultData( null, [ 'Strip' => 'all' ] );
		} else {
			$response = $api->getResultData();
		}

		if ( is_array( $response ) && array_key_exists( 'query', $response ) && array_key_exists( 'pages', $response['query'] ) ) {
			foreach ( $response['query']['pages'] as $page ) {
				if ( array_key_exists( 'images', $page ) ) {
					foreach ( $page['images'] as $image ) {
						$title = Title::newFromText( $image['title'], NS_FILE );

						if ( !is_null( $title ) && $title->getNamespace() == NS_FILE && $title->exists() ) {
							$images[] = $image['title'];
						}
					}
				}
			}
		}

		return array_unique( $images );
	}

}

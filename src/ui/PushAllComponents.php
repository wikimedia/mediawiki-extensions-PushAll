<?php
/**
 * Components used to build the HTML table of targets with the contents to push
 *
 * @file PushAllComponents.php
 * @ingroup PushAll
 *
 * @author Karima Rafes < karima.rafes@gmail.com >
 */

use MediaWiki\Html\Html;
use MediaWiki\MediaWikiServices;
use MediaWiki\Revision\RevisionRecord;
use MediaWiki\Title\Title;

/**
 * Class PushAllComponents
 */
final class PushAllComponents {

	/**
	 * Build the targets' table
	 *
	 * @param OutputPage $output
	 * @param User $user
	 * @param array $titlesParam
	 * @throws MWException
	 */
	public static function formPushAll( OutputPage $output, User $user, array $titlesParam ) {
		$titles = [];
		$errors = [];
		foreach ( $titlesParam as $titleStr ) {
			$title = Title::newFromText( $titleStr );
			if ( !$title->exists() ) {
				$titlesNotExist[] = $title;
				$errors[] = wfMessage( 'pushall-error-title-not-exist', $title )->parse();
			} else {
				$wikipage = MediaWikiServices::getInstance()->getWikiPageFactory()->newFromTitle( $title );
				$content = $wikipage->getContent( RevisionRecord::FOR_THIS_USER, $user );
				if ( empty( $content ) ) {
					$errors[] = wfMessage( 'pushall-error-title-not-allow', $title )->parse();
				} else {
					$titles[] = $title;
				}
			}
		}
		$targets = PushAll::getTargets( $user );

		$contents = new PushAllContents( $targets );
		$contents->addTitlesToPush( $titles );
		$output->addHtml( self::htmlListTargets(
			$user, $contents, MediaWikiServices::getInstance()->getContentLanguage(),
			$errors )
		);
		$output->addHtml( self::htmlTools() );
		$output->addHtml( self::htmlOptions() );
		$output->addHtml( self::htmlLegend() );

		$output->addInlineScript(
			'const wgPushAllContents = '
			. $contents->serializeToJson( MediaWikiServices::getInstance()->getContentLanguage() ) . ';' .
			'const wgPushAllTargets = ' . $targets->serializeToJson() . ';'
		);
		// For debug:
		// $output->addHTML(
		//			Html::rawElement(
		//				'pre',
		//				[],
		//				print_r($contents, true)
		//			));
	}

	private static function htmlTools() {
		return Html::rawElement(
			'fieldset', [ 'style' => 'max-width: 900px;' ],
			Html::element(
				'legend', [],
				wfMessage( 'pushall-tools-header' )->text()
			)
			.
			Html::rawElement(
				'div', [ 'style' => 'display:inline-flex;justify-content: space-between;width: 100%;' ],
				self::htmlToolsButtons(
					wfMessage( 'pushall-tools-header-contents' )->text(),
					"buttonExpandAll",
					wfMessage( 'pushall-tools-button-expand' )->text(),
					"buttonCollapseAll",
					wfMessage( 'pushall-tools-button-collapse' )->text()
				)
				. self::htmlToolsButtons(
					wfMessage( 'pushall-tools-header-check' )->text(),
					"buttonCheckAll",
					wfMessage( 'pushall-tools-button-checkall' )->text(),
					"buttonUncheckAll",
					wfMessage( 'pushall-tools-button-uncheckall' )->text()
				)
				. self::htmlToolsButtons(
					wfMessage( 'pushall-tools-header-subpages' )->text(),
					"buttonIncludeSubpages",
					wfMessage( 'pushall-tools-button-include' )->text(),
					"buttonExcludeSubpages",
					wfMessage( 'pushall-tools-button-exclude' )->text()
				)
				. self::htmlToolsButtons(
					wfMessage( 'pushall-tools-header-files' )->text(),
					"buttonIncludeFiles",
					wfMessage( 'pushall-tools-button-include' )->text(),
					"buttonExcludeFiles",
					wfMessage( 'pushall-tools-button-exclude' )->text()
				)
				. self::htmlToolsButtons(
					wfMessage( 'pushall-tools-header-templates' )->text(),
					"buttonIncludeTemplates",
					wfMessage( 'pushall-tools-button-include' )->text(),
					"buttonExcludeTemplates",
					wfMessage( 'pushall-tools-button-exclude' )->text()
				)
				. self::htmlToolsButtons(
					wfMessage( 'pushall-tools-header-attachednamespaces' )->text(),
					"buttonIncludeAttachedNamespaces",
					wfMessage( 'pushall-tools-button-include' )->text(),
					"buttonExcludeAttachedNamespaces",
					wfMessage( 'pushall-tools-button-exclude' )->text()
				)
			)
		);
	}

	/**
	 * Build buttons
	 *
	 * @param string $headerLabel
	 * @param string $buttonTopId
	 * @param string $buttonTopLabel
	 * @param string $buttonBottomId
	 * @param string $buttonButtomLabel
	 * @return string
	 */
	private static function htmlToolsButtons( string $headerLabel,
											 string $buttonTopId,
											 string $buttonTopLabel,
											 string $buttonBottomId,
											 string $buttonButtomLabel ) {
		return Html::rawElement( 'div', [ 'style' => 'display:grid;width: 100%;' ],

			Html::element(
				'div',
				[ 'style' => 'text-align:center;' ],
				$headerLabel
			)
			. Html::element(
				'button',
				[
					'id' => $buttonTopId,
					'style' => ' height: 30px; margin: 0 2px 0 2px;',
				],
				$buttonTopLabel
			)
			. Html::element(
				'button',
				[
					'id' => $buttonBottomId,
					'style' => ' height: 30px; margin: 0 2px 0 2px;',
				],
				$buttonButtomLabel
			)
		);
	}

	/**
	 * Outputs the HTML for the options.
	 * @return string
	 */
	private static function htmlOptions() {
		$idforcepush = 'forcePush';
		return Html::rawElement(
			'fieldset', [ 'style' => 'max-width: 900px;' ],
			Html::element(
				'legend', [],
				wfMessage( 'pushall-tab-options' )->text()
			)
			.
			Html::rawElement(
				'div', [ 'class' => 'mw-htmlform-nolabel' ],
				Html::check( $idforcepush, false, [ 'id' => $idforcepush ] )
				. '&nbsp;' .
				Html::element(
					'label',
					[ 'id' => 'lbl' . $idforcepush, 'for' => $idforcepush ],
					wfMessage( 'pushall-option-force-push' )->text()
				)
			)
		);
	}

	/**
	 * Build the rows in the table
	 *
	 * @param User $user
	 * @param PushAllContents $contents
	 * @param Language $langContext
	 * @param array $errors
	 * @return string
	 */
	private static function htmlListTargets( User $user,
											PushAllContents $contents,
											Language $langContext,
											array $errors = [] ) {
		$targets = PushAll::getTargets( $user );
		$rows = [
			Html::rawElement(
				'tr',
				[],
				Html::element(
					'th',
					[ 'width' => '200px' ],
					wfMessage( 'pushall-targets' )->text()
				) .
				Html::element(
					'th',
					[ 'style' => 'width:575px;' ],
					wfMessage( 'pushall-remote-pages' )->text()
				) .
				Html::element(
					'th',
					[ 'width' => '125px' ],
					''
				)
			)
		];

		foreach ( $targets->getArray() as $target ) {
			$rows[] = self::targetedWikiRow( $target, $user, $contents, $langContext );
		}

		if ( $targets->count() > 1 ) {
			$rows[] = Html::rawElement(
				'tr',
				[],
				Html::element(
					'th',
					[ 'colspan' => 2, 'style' => 'text-align: left' ],
					wfMessage( 'pushall-targets-total' )->numParams( $targets->count() )->parse()
				) .
				Html::rawElement(
					'th',
					[ 'width' => '125px' ],
					Html::element(
						'button',
						[
							'id' => 'pushall-all-button',
							'style' => 'width: 125px; height: 30px',
						],
						wfMessage( 'pushall-button-all' )->text()
					)
				)
			);
		}

		return Html::rawElement(
				'div',
				[
					'class' => 'mw-message-box mw-message-box-error mw-content-ltr',
					'style' => ( count( $errors ) > 0 ? '' : 'display:none;' ) . 'max-width: 900px;',
					'id' => 'errorpushall'
				],
				( count( $errors ) > 0 ? implode( "<br/>", $errors ) : '' )
			)
			. Html::rawElement(
				'table',
				[
					'class' => 'wikitable',
					'id' => 'pushall-table'
				],
				implode( "\n", $rows )
			);
	}

	/**
	 * Build a row in the table
	 *
	 * @param PushAllTarget $target
	 * @param User $user
	 * @param PushAllContents $contents
	 * @param Language $langContext
	 * @return string
	 */
	private static function targetedWikiRow( PushAllTarget $target,
											User $user,
											PushAllContents $contents,
											Language $langContext ) {
		$html = "";
		foreach ( $contents->contentsGraph as $content ) {
			$html .= self::pageDiv( $target, $user, $content, $langContext, true );
		}

		return Html::rawElement(
			'tr',
			[],
			Html::element(
				'td',
				[ 'style' => 'text-align: center;' ],
				$target->name
			) .
			Html::rawElement(
				'td',
				[ 'height' => '45px' ],
				Html::element(
					'div',
					[
						'id' => 'errorpushalltarget' . $target->id,
						'class' => 'mw-message-box mw-message-box-error mw-content-ltr',
						'style' => 'display:none'
					]
				)
				. $html
			) .
			Html::rawElement(
				'td',
				[],
				Html::element(
					'button',
					[
						'class' => 'pushallButton',
						'style' => 'width: 125px; height: 30px',
						'targetname' => $target->name
					],
					wfMessage( 'pushall-button-text' )->text()
				)
			)
		);
	}

	/**
	 * Build a cell about a content in the table
	 *
	 * @param PushAllTarget $target
	 * @param User $user
	 * @param PushAllContent $contentRoot
	 * @param Language $langContext
	 * @param bool $checked
	 * @return string
	 */
	private static function pageDiv( PushAllTarget $target,
									User $user,
									PushAllContent $contentRoot,
									Language $langContext,
									bool $checked = false ) {
		// $config = PushAll::getConfig();
		$htmlSubContent = "";

		$isCollapsed = !$checked;

		foreach ( $contentRoot->subpages as $content ) {
			$isPrefUserIncSubpages = PushAll::isPrefUserIncSubpages( $user );
			$htmlSubContent .= self::pageDiv( $target, $user, $content, $langContext, $isPrefUserIncSubpages );
			$isCollapsed = !( !$isCollapsed || $isPrefUserIncSubpages );
		}
		foreach ( $contentRoot->templates as $content ) {
			$isPrefUserIncTemplates = PushAll::isPrefUserIncTemplates( $user );
			$htmlSubContent .= self::pageDiv( $target, $user, $content, $langContext, $isPrefUserIncTemplates );
			$isCollapsed = !( !$isCollapsed || $isPrefUserIncTemplates );
		}
		foreach ( PushAll::getAttachedNamespaces() as $Namespace ) {
			foreach ( $contentRoot->attachedPages[$Namespace] as $content ) {
				$isPrefUserIncAttachedNamespaces = PushAll::isPrefUserIncAttachedNamespaces( $user );
				$htmlSubContent .= self::pageDiv(
					$target, $user, $content, $langContext, $isPrefUserIncAttachedNamespaces
				);
				$isCollapsed = !( !$isCollapsed || $isPrefUserIncAttachedNamespaces );
			}
		}
		foreach ( $contentRoot->files as $content ) {
			$isPrefUserIncFiles = PushAll::isPrefUserIncFiles( $user );
			$htmlSubContent .= self::pageDiv( $target, $user, $content, $langContext, $isPrefUserIncFiles );
			$isCollapsed = !( !$isCollapsed || $isPrefUserIncFiles );
		}

		return Html::rawElement(
			'div',
			[
				'class' => 'mw-collapsible mw-made-collapsible toccolours'
					. ( $isCollapsed ? ' mw-collapsed' : '' ),
				'style' => 'position: relative;'
			],
			Html::rawElement(
				'div',
				[
					'style' => 'float: left;'
				],
				Html::check( 'target' . $target->id . 'content' . $contentRoot->id, $checked,
					[
						'id' => 'target' . $target->id . 'content' . $contentRoot->id,
						'class' => 'pushallCheckContent',
						'title' => 'Yo'
					]
				)
			)
			. Html::rawElement(
				'div',
				[
					'class' => 'mw-collapsible-toggle'
						. ( $isCollapsed ? ' mw-collapsible-toggle-collapsed' : ' mw-collapsible-toggle-expanded' ),
					'id' => 'toggletarget' . $target->id . 'content' . $contentRoot->id,
					'style' => 'float: none;',
					'aria-expanded' => ( $isCollapsed ? 'false' : 'true' ),
					'tabindex' => '0'
				],
				self::htmlStatusColor( 'gray', $target, $contentRoot )
				. Html::element(
					'a',
					[
						'href' => $target->articlePath . $contentRoot->titlePrefixed,
						'rel' => 'nofollow',
						'id' => 'linktarget' . $target->id . 'content' . $contentRoot->id,
						'class' => "mw-title",
						'target' => "blank"
					],
					$contentRoot->titlePrefixed
				)
				. ' ('
				. Html::element(
					'a',
					[
						'href' => Title::newFromText( $contentRoot->titlePrefixed )->getFullURL(),
						'rel' => 'nofollow',
						'class' => "mw-title",
						'target' => "blank"
					],
					'local'
				)
				. ')'
			)
			. Html::rawElement(
				'div',
				[
					'class' => 'mw-collapsible-content',
					'style' => 'margin-left: 2.5em; float: none;'
						. ( $isCollapsed ? 'display: none;' : '' ),
				],
				self::statusResumeDiv( $target, $contentRoot, $langContext )
				. $htmlSubContent
			)
		);
	}

	/**
	 * Build the first resume about a content
	 *
	 * @param PushAllTarget $target
	 * @param PushAllContent $content
	 * @param Language $langContext
	 * @return string
	 */
	private static function statusResumeDiv( PushAllTarget $target, PushAllContent $content, Language $langContext ) {
		return Html::rawElement(
			'div',
			[
				'class' => 'mw-collapsible mw-made-collapsible mw-collapsed'
			],
			Html::rawElement(
				'div',
				[
					'class' => 'mw-collapsible-toggle  mw-collapsible-toggle-collapsed',
					'style' => 'float: none;',
					'aria-expanded' => 'false',
					'tabindex' => '0',
					'id' => 'statusmessagetarget' . $target->id . 'content' . $content->id
				],
				wfMessage( 'pushall-status-search-in-progress' )->text()
			)
			. Html::rawElement(
				'div',
				[
					'class' => 'mw-collapsible-content',
					'style' => 'float: none;display: none;',
					'id' => 'revisionstarget' . $target->id . 'content' . $content->id
				],
				self::revisionsListSpan( $target, $content, $langContext )
			)
		);
	}

	/**
	 * Insert the revisions in a cell
	 *
	 * @param PushAllTarget $target
	 * @param PushAllContent $content
	 * @param Language $langContext
	 * @return string
	 */
	private static function revisionsListSpan( PushAllTarget $target, PushAllContent $content, Language $langContext ) {
		$html = "";
		$findPush = false;
		foreach ( $content->revisions as $revision ) {
			$text = $langContext->timeanddate( $revision['timestamp'] ) . '-' . $revision['user'];
			if ( !empty( $revision['comment'] ) ) {
				$text .= '-' . $revision['comment'];
			}
			$text .= '&nbsp;' .
				'(' . $revision['len'] . ')';

			if ( !empty( $revision['push'] ) && !empty( $revision['push'][$target->name] ) ) {
				$text .= '&nbsp;<b>Pushed '
					. $langContext->timeanddate( $revision['push'][$target->name]['timestamp'] )
					. '</b>';
				$findPush = true;
			}
			$html .= Html::rawElement(
				'div',
				[
					'style' => 'font-size: 0.9em;font-family: sans-serif;'
				],
				$text
			);
		}

		if ( !$findPush ) {
			$html = "";
		}
		return $html;
	}

	/**
	 * Build the legend
	 *
	 * @return string
	 */
	private static function htmlLegend() {
		return Html::rawElement(
			'fieldset', [ 'style' => 'max-width: 900px;' ],
			Html::element(
				'legend', [],
				wfMessage( 'pushall-legend-title' )->text()
			)
			. Html::rawElement(
				'table',
				[],
				self::htmlLegendRow(
					self::htmlStatusColorLegend( 'gray' ),
					'pushall-legend-gray'
				)
				. self::htmlLegendRow(
					self::htmlStatusColorLegend( 'chartreuse' ),
					'pushall-legend-chartreuse'
				)
				. self::htmlLegendRow(
					self::htmlStatusColorLegend( 'green' ),
					'pushall-legend-green'
				)
				. self::htmlLegendRow(
					self::htmlStatusColorLegend( 'darkorange' ),
					'pushall-legend-darkorange'
				)
				. self::htmlLegendRow(
					self::htmlStatusColorLegend( 'red' ),
					'pushall-legend-red'
				)
				. self::htmlLegendRow(
					self::htmlStatusColorLegend( 'purple' ),
					'pushall-legend-purple'
				)
				. self::htmlLegendRow(
					self::htmlStatusColorLegend( 'black' ),
					'pushall-legend-black'
				)
			)
		);
	}

	/**
	 * Build a row in the legend
	 * @param string $html
	 * @param string $messageLabel
	 * @return string
	 */
	private static function htmlLegendRow( string $html, string $messageLabel ): string {
		return Html::rawElement(
			'tr',
			[],
			Html::rawElement(
				'td',
				[ 'style' => 'vertical-align: baseline;text-align:center;' ],
				$html
			)
			. Html::rawElement(
				'td',
				[],
				wfMessage( $messageLabel )->text()
			)
		);
	}

	/**
	 * Build the icon of status in the legend
	 *
	 * @param string $color
	 * @return string
	 */
	private static function htmlStatusColorLegend( string $color ): string {
		return Html::element(
			'div',
			[
				'style' => 'width: 0.8em; height: 0.8em; background: ' . $color
					. '; border-radius: 0.4em;'
					. 'display: inline-block; margin-right:0.3em;'
			]
		);
	}

	/**
	 * Build the icon of status in the table
	 *
	 * @param string $color
	 * @param PushAllTarget $target
	 * @param PushAllContent $content
	 * @return string
	 */
	private static function htmlStatusColor( string $color, PushAllTarget $target, PushAllContent $content ): string {
		return Html::element(
			'div',
			[
				'style' => 'width: 0.8em; height: 0.8em; background: ' . $color
					. '; border-radius: 0.4em;'
					. 'display: inline-block; margin-right:0.3em;',
				'id' => 'statusicontarget' . $target->id
					. 'content' . $content->id
			]
		);
	}
}

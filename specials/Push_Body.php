<?php

/**
 * A special page that allows pushing one or more pages to one or more targets.
 * Partly based on MediaWiki's Special:Export.
 *
 * @since 0.1
 *
 * @file Push_Body.php
 * @ingroup Push
 *
 * @author Jeroen De Dauw  < jeroendedauw@gmail.com >
 */
class SpecialPush extends SpecialPage {

	/**
	 * Constructor.
	 *
	 * @since 0.1
	 */
	public function __construct() {
		parent::__construct( 'Push', 'bulkpush' );
	}

	/**
	 * @see SpecialPage::getDescription
	 */
	public function getDescription() {
		return wfMsg( 'special-' . strtolower( $this->getName() ) );
	}

	/**
	 * Sets headers - this should be called from the execute() method of all derived classes!
	 */
	public function setHeaders() {
		$out = $this->getOutput();
		$out->setArticleRelated( false );
		$out->setRobotPolicy( "noindex,nofollow" );
		$out->setPageTitle( $this->getDescription() );
	}

	/**
	 * Main method.
	 *
	 * @since 0.1
	 *
	 * @param string $arg
	 */
	public function execute( $arg ) {
		global $egPushTargets;

		$req = $this->getRequest();

		$this->setHeaders();
		$this->outputHeader();

		// If the user is authorized, display the page, if not, show an error.
		if ( !$this->userCanExecute( $this->getUser() ) ) {
			$this->displayRestrictionError();
			return;
		}

		if ( count( $egPushTargets ) == 0 ) {
			$this->getOutput()->addHTML( '<p>' . htmlspecialchars( wfMsg( 'push-tab-no-targets'  ) ) . '</p>' );
			return;
		}

		$doPush = false;

		if ( $req->getCheck( 'addcat' ) ) {
			$pages = $req->getText( 'pages' );
			$catname = $req->getText( 'catname' );

			if ( $catname !== '' && $catname !== null && $catname !== false ) {
				$t = Title::makeTitleSafe( NS_MAIN, $catname );
				if ( $t ) {
					/**
					 * @todo Fixme: this can lead to hitting memory limit for very large
					 * categories. Ideally we would do the lookup synchronously
					 * during the export in a single query.
					 */
					$catpages = $this->getPagesFromCategory( $t );
					if ( $catpages ) $pages .= "\n" . implode( "\n", $catpages );
				}
			}
		}
		elseif( $req->getCheck( 'addns' ) ) {
			$pages = $req->getText( 'pages' );
			$nsindex = $req->getText( 'nsindex', '' );

			if ( strval( $nsindex ) !== ''  ) {
				/**
				 * Same implementation as above, so same @todo
				 */
				$nspages = $this->getPagesFromNamespace( $nsindex );
				if ( $nspages ) $pages .= "\n" . implode( "\n", $nspages );
			}
		}
		elseif( $req->wasPosted() ) {
			$pages = $req->getText( 'pages' );
			if( $pages != '' ) $doPush= true;
		}
		else {
			$pages = '';
		}

		if ( $doPush ) {
			$this->doPush( $pages );
		}
		else {
			$this->displayPushInterface( $arg, $pages );
		}
	}

	/**
	 * Outputs the HTML to indicate a push is occurring and
	 * the JavaScript to needed by the push.
	 *
	 * @since 0.2
	 *
	 * @param string $pages
	 */
	protected function doPush( $pages ) {
		global $wgSitename, $egPushTargets, $egPushBulkWorkers, $egPushBatchSize;

		$pageSet = array(); // Inverted index of all pages to look up

		// Split up and normalize input
		foreach( explode( "\n", $pages ) as $pageName ) {
			$pageName = trim( $pageName );
			$title = Title::newFromText( $pageName );
			if( $title && $title->getInterwiki() == '' && $title->getText() !== '' ) {
				// Only record each page once!
				$pageSet[$title->getPrefixedText()] = true;
			}
		}

		// Look up any linked pages if asked...
		if( $this->getRequest()->getCheck( 'templates' ) ) {
			$pageSet = PushFunctions::getTemplates( array_keys( $pageSet ), $pageSet );
		}

		$pages = array_keys( $pageSet );

		$targets = array();
		$links = array();

		if ( count( $egPushTargets ) > 1 ) {
			foreach ( $egPushTargets as $targetName => $targetUrl ) {
				if ( $this->getRequest()->getCheck( str_replace( ' ', '_', $targetName ) ) ) {
					$targets[$targetName] = $targetUrl;
					$links[] = "[$targetUrl $targetName]";
				}
			}
		}
		else {
			$targets = $egPushTargets;
		}

		$out = $this->getOutput();

		$out->addWikiMsg(
			'push-special-pushing-desc',
			$this->getLanguage()->listToText( $links ),
			$this->getLanguage()->formatNum( count( $pages ) )
		);

		$out->addHTML(
			Html::hidden( 'siteName', $wgSitename, array( 'id' => 'siteName' ) ) .
			Html::rawElement(
				'div',
				array(
					'id' => 'pushResultDiv',
					'style' => 'width: 100%; height: 300px; overflow: auto'
				),
				Html::rawElement(
					'div',
					array( 'class' => 'innerResultBox' ),
					Html::element( 'ul', array( 'id' => 'pushResultList' ) )
				)
			) . '<br />' .
			Html::element( 'a', array( 'href' => $this->getPageTitle()->getInternalURL() ), wfMsg( 'push-special-return' ) )
		);

		$out->addInlineScript(
			'var wgPushPages = ' . FormatJson::encode( $pages ) . ';' .
			'var wgPushTargets = ' . FormatJson::encode( $targets ) . ';' .
			'var wgPushWorkerCount = ' . $egPushBulkWorkers . ';' .
			'var wgPushBatchSize = ' . $egPushBatchSize . ';' .
			'var wgPushIncFiles = ' . ( $this->getRequest()->getCheck( 'files' ) ? 'true' : 'false' ) . ';'
		);

		$this->loadJs();
	}

	/**
	 * @since 0.2
	 */
	protected function displayPushInterface( $arg, $pages ) {
		global $egPushTargets, $egPushIncTemplates, $egPushIncFiles;

		$req = $this->getRequest();
		
		$this->getOutput()->addWikiMsg( 'push-special-description' );

		$form = Xml::openElement( 'form', array( 'method' => 'post',
			'action' => $this->getPageTitle()->getLocalUrl( 'action=submit' ) ) );
		$form .= Xml::inputLabel( wfMsg( 'export-addcattext' )    , 'catname', 'catname', 40 ) . '&#160;';
		$form .= Xml::submitButton( wfMsg( 'export-addcat' ), array( 'name' => 'addcat' ) ) . '<br />';

		$form .= Html::namespaceSelector( array(
			'selected' => $req->getText( 'nsindex', '' ),
			'all' => null,
			'label' => wfMsg( 'export-addnstext' ),
		), array(
			'name' => 'nsindex',
			'id' => 'namespace',
			'class' => 'namespaceselector',
		) ) . '&#160;';
		$form .= Xml::submitButton( wfMsg( 'export-addns' ), array( 'name' => 'addns' ) ) . '<br />';

		$form .= Xml::element( 'textarea', array( 'name' => 'pages', 'cols' => 40, 'rows' => 10 ), $pages, false );
		$form .= '<br />';

		$form .= Xml::checkLabel(
			wfMsg( 'export-templates' ),
			'templates',
			'wpPushTemplates',
			$req->wasPosted() ? $req->getCheck( 'templates' ) : $egPushIncTemplates
		) . '<br />';

		if ( $this->getUser()->isAllowed( 'filepush' ) ) {
			$form .= Xml::checkLabel(
				wfMsg( 'push-special-inc-files' ),
				'files',
				'wpPushFiles',
				$req->wasPosted() ? $req->getCheck( 'files' ) : $egPushIncFiles
			) . '<br />';
		}

		if ( count( $egPushTargets ) == 1 ) {
			$names = array_keys( $egPushTargets );
			$form .= '<b>' . htmlspecialchars( wfMsgExt( 'push-special-target-is', 'parsemag', $names[0] ) ) . '</b><br />';
		}
		else {
			$form .= '<b>' . htmlspecialchars( wfMsg( 'push-special-select-targets' ) ) . '</b><br />';

			foreach ( $egPushTargets as $targetName => $targetUrl ) {
				$checkName = str_replace( ' ', '_', $targetName );
				$checked = $req->wasPosted() ? $req->getCheck( $checkName ) : true;
				$form .= Xml::checkLabel( $targetName, $checkName, $targetName, $checked ) . '<br />';
			}
		}

		$form .= Xml::submitButton( wfMsg( 'push-special-button-text' ), array( 'style' => 'width: 125px; height: 30px' ) );
		$form .= Xml::closeElement( 'form' );

		$this->getOutput()->addHTML( $form );
	}

	/**
	 * Returns all pages for a category (up to 5000).
	 *
	 * @since 0.2
	 *
	 * @param Title $title
	 *
	 * @return array
	 */
	protected function getPagesFromCategory( Title $title ) {
		global $wgContLang;

		$name = $title->getDBkey();

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array( 'page', 'categorylinks' ),
			array( 'page_namespace', 'page_title' ),
			array( 'cl_from=page_id', 'cl_to' => $name ),
			__METHOD__,
			array( 'LIMIT' => '5000' )
		);

		$pages = array();

		foreach ( $res as $row ) {
			$n = $row->page_title;
			if ($row->page_namespace) {
				$ns = $wgContLang->getNsText( $row->page_namespace );
				$n = $ns . ':' . $n;
			}

			$pages[] = $n;
		}
		return $pages;
	}

	/**
	 * Returns all pages for a namespace (up to 5000).
	 *
	 * @since 0.2
	 *
	 * @param integer $nsindex
	 *
	 * @return array
	 */
	protected function getPagesFromNamespace( $nsindex ) {
		global $wgContLang;

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'page',
			array( 'page_namespace', 'page_title' ),
			array( 'page_namespace' => $nsindex ),
			__METHOD__,
			array( 'LIMIT' => '5000' )
		);

		$pages = array();

		foreach ( $res as $row ) {
			$n = $row->page_title;

			if ( $row->page_namespace ) {
				$ns = $wgContLang->getNsText( $row->page_namespace );
				$n = $ns . ':' . $n;
			}

			$pages[] = $n;
		}
		return $pages;
	}

	/**
	 * Loads the needed JavaScript.
	 * Takes care of non-RL compatibility.
	 *
	 * @since 0.2
	 */
	protected function loadJs() {
		$out = $this->getOutput();

		// For backward compatibility with MW < 1.17.
		if ( is_callable( array( $out, 'addModules' ) ) ) {
			$out->addModules( 'ext.push.special' );
		}
		else {
			global $egPushScriptPath;

			PushFunctions::addJSLocalisation();

			$out->includeJQuery();

			$out->addHeadItem(
				'ext.push.special',
				Html::linkedScript( $egPushScriptPath . '/specials/ext.push.special.js' )
			);
		}
	}

	/**
	 * Get the OutputPage being used for this instance.
	 * SpecialPage extends ContextSource as of 1.18.
	 *
	 * @since 0.1
	 *
	 * @return OutputPage
	 */
	public function getOutput() {
		return version_compare( $GLOBALS['wgVersion'], '1.18', '>' ) ? parent::getOutput() : $GLOBALS['wgOut'];
	}

	/**
	 * Get the Language being used for this instance.
	 * SpecialPage extends ContextSource as of 1.18.
	 *
	 * @since 0.1
	 *
	 * @return Language
	 */
	public function getLanguage() {
		return method_exists( 'SpecialPage', 'getLanguage' ) ? parent::getLanguage() : $GLOBALS['wgLang'];
	}

	/**
	 * Get the User being used for this instance.
	 * SpecialPage extends ContextSource as of 1.18.
	 *
	 * @since 0.1
	 *
	 * @return User
	 */
	public function getUser() {
		return version_compare( $GLOBALS['wgVersion'], '1.18', '>' ) ? parent::getUser() : $GLOBALS['wgUser'];
	}

	/**
	 * Get the WebRequest being used for this instance.
	 * SpecialPage extends ContextSource as of 1.18.
	 *
	 * @since 0.1
	 *
	 * @return WebRequest
	 */
	public function getRequest() {
		return version_compare( $GLOBALS['wgVersion'], '1.18', '>' ) ? parent::getRequest() : $GLOBALS['wgRequest'];
	}

	/**
	 * Get the Skin being used for this instance.
	 * SpecialPage extends ContextSource as of 1.18.
	 *
	 * @since 0.1
	 *
	 * @return Skin
	 */
	public function getSkin() {
		return version_compare( $GLOBALS['wgVersion'], '1.18', '>' ) ? parent::getSkin() : $GLOBALS['wgSkin'];
	}

	/**
	 * Get the Title being used for this instance.
	 * SpecialPage extends ContextSource as of 1.18.
	 *
	 * @since 0.1
	 *
	 * @param boolean $subPage
	 *
	 * @return Title
	 */
	public function getPageTitle( $subPage = false ) {
		return version_compare( $GLOBALS['wgVersion'], '1.18', '>' ) ? parent::getPageTitle() : $GLOBALS['wgTitle'];
	}

}

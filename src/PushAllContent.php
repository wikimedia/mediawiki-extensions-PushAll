<?php
/**
 * PushAllContent describes all relations with other pages in the wiki.
 *
 * @file PushAllContent.php
 * @ingroup PushAll
 *
 * @author Karima Rafes < karima.rafes@gmail.com >
 */

/**
 * Class PushAllContent
 */
class PushAllContent {

	/**
	 * id HTML
	 * @var string
	 */
	public $id;

	/**
	 * title prefixed by the namespace (if necessary)
	 * @var string
	 */
	public $titlePrefixed;

	/**
	 * Subpages' titles  of the page
	 * @var array
	 */
	public $subpages = [];

	/**
	 * Templates' titles  uses by the page
	 * @var array
	 */
	public $templates = [];

	/**
	 * Titles attached to this page
	 * @var array
	 */
	public $attachedPages = [];

	/**
	 * Files attached to this page
	 * @var array
	 */
	public $files = [];

	/**
	 * Revisions to this page since the last push else empty
	 * @var array
	 */
	public $revisions = [];

	/**
	 * True if the page is a subpage
	 * @var bool
	 */
	public $isSubpage = false;

	/**
	 * True if the page is a template
	 * @var bool
	 */
	public $isTemplate = false;

	/**
	 * True if the page is also a file
	 * @var bool
	 */
	public $isFile = false;

	/**
	 * True if the page is a attached page of another page
	 * @var bool
	 */
	public $isAttachedPageByNamespace = false;

	/**
	 * PushAllContent constructor.
	 *
	 * @param string $titlePrefixed
	 */
	public function __construct( string $titlePrefixed ) {
		$this->titlePrefixed = $titlePrefixed;
	}

	/**
	 * Get all information of a page
	 *
	 * @param Language $lang
	 * @return array
	 */
	public function serializeToArray( Language $lang ) {
		$result = [];
		$result["id"] = $this->id;
		$result["titlePrefixed"] = $this->titlePrefixed;
		$result["isSubpage"] = $this->isSubpage;
		$result["isTemplate"] = $this->isTemplate;
		$result["isFile"] = $this->isFile;
		$result["isAttachedPageByNamespace"] = $this->isAttachedPageByNamespace;
		$result["contents"] = [];
		$result["revisions"] = [];
		foreach ( $this->subpages as $titlePrefixed => $content ) {
			$result["contents"][$titlePrefixed] = $content->serializeToArray( $lang );
		}
		foreach ( $this->templates as $titlePrefixed => $content ) {
			$result["contents"][$titlePrefixed] = $content->serializeToArray( $lang );
		}
		foreach ( $this->attachedPages as $namespace => $attachedPages ) {
			foreach ( $attachedPages as $titlePrefixed => $content ) {
				$result["contents"][$titlePrefixed] = $content->serializeToArray( $lang );
			}
		}
		foreach ( $this->files as $titlePrefixed => $content ) {
			$result["contents"][$titlePrefixed] = $content->serializeToArray( $lang );
		}
		$result["revisions"] = $this->revisions;

		$result["revisions"] = $this->revisions;
		foreach ( $this->revisions as $key => $revision ) {
			$result["revisions"][$key]['timestamp'] = $lang->timeanddate( $revision['timestamp'] );
			foreach ( $revision['push'] as $targetName => $push ) {
				if ( array_key_exists( 'timestamp', $result["revisions"][$key]['push'][$targetName] )
					&& array_key_exists( 'timestamp', $push ) ) {
					$result["revisions"][$key]['push'][$targetName]['timestamp'] =
						$lang->timeanddate( $push['timestamp'] );
				}
			}
		}
		return $result;
	}

	/**
	 * Create a new instance of PushAllContent
	 *
	 * @param string $titlePrefixed
	 * @param PushAllContents $contents
	 * @param PushAllTargets $targets
	 * @return PushAllContent
	 */
	public static function factory( $titlePrefixed, PushAllContents $contents, PushAllTargets $targets ) {
		$contentObj = new PushAllContent( $titlePrefixed );
		$contentObj->revisions = self::getRevisions( $contentObj->titlePrefixed, $targets );
		$contentObj->id = uniqid();

		$subpages = self::getSubpages( $contentObj->titlePrefixed );
		foreach ( $subpages as $subpage ) {
			if ( $contents->isKnownPage( $subpage ) ) {
				$contentObj->subpages[$subpage] = clone $contents->getPage( $subpage );
				$contentObj->subpages[$subpage]->id = uniqid();
			} else {
				$content = self::factory( $subpage, $contents, $targets );
				$content->isSubpage = true;
				$contentObj->subpages[$subpage] = $content;
				$contents->addPage( $content );
			}
		}

		$templates = self::getTemplates( $contentObj->titlePrefixed );
		foreach ( $templates as $template ) {
			if ( !array_key_exists( $template, $contentObj->subpages ) ) {
				if ( $contents->isKnownPage( $template ) ) {
					$contentObj->templates[$template] = clone $contents->getPage( $template );
					$contentObj->templates[$template]->id = uniqid();
				} else {
					$content = self::factory( $template, $contents, $targets );
					$content->isTemplate = true;
					$contentObj->templates[$template] = $content;
					$contents->addPage( $content );
				}
			}
		}

		$files = self::getLocalFiles( $contentObj->titlePrefixed );
		foreach ( $files as $file ) {
			if ( $contents->isKnownPage( $file ) ) {
				$contentObj->files[$file] = clone $contents->getPage( $file );
				$contentObj->files[$file]->id = uniqid();
			} else {
				$content = self::factory( $file, $contents, $targets );
				$content->isFile = true;
				$contentObj->files[$file] = $content;
				$contents->addPage( $content );
				$contents->addFile( $content );
			}
		}

		$attachedPagesNamespaces = self::getAttachedPagesByNamespaces( $contentObj->titlePrefixed );
		foreach ( $attachedPagesNamespaces as $Namespace => $attachedPagesNamespace ) {
			$contentObj->attachedPages[$Namespace] = [];
			foreach ( $attachedPagesNamespace as $attachedPage ) {
				if ( $contents->isKnownPage( $attachedPage ) ) {
					$contentObj->attachedPages[$Namespace][$attachedPage] = clone $contents->getPage( $attachedPage );
					$contentObj->attachedPages[$Namespace][$attachedPage]->id = uniqid();
				} else {
					$content = self::factory( $attachedPage, $contents, $targets );
					$content->isAttachedPageByNamespace = true;
					$contentObj->attachedPages[$Namespace][$attachedPage] = $content;
					$contents->addPage( $content );
				}
			}
		}
		return $contentObj;
	}

	/**
	 * Templates used in a page
	 *
	 * @param string $pageName to look up
	 * @return array associative array index by titles
	 */
	private static function getTemplates( $pageName ) {
		$result = [];
		$dbr = wfGetDB( DB_REPLICA );
		$title = Title::newFromText( $pageName );
		if ( $title ) {
			$pageSet[$title->getPrefixedText()] = true;
			$resultDb = $dbr->select(
				[ 'page', 'templatelinks', 'linktarget' ],
				[ 'lt_namespace AS namespace', 'lt_title AS title' ],
				[
					'page_namespace' => $title->getNamespace(),
					'page_title' => $title->getDBkey()
				],

				__METHOD__,
				[],
				[
					'templatelinks' => [ 'INNER JOIN', [ 'page_id = tl_from' ] ],
					'linktarget' => [ 'INNER JOIN', [ 'tl_target_id = lt_id' ] ]
				]
			);
			foreach ( $resultDb as $row ) {
				$rowTitle = Title::makeTitle( $row->namespace, $row->title );
				$result[] = $rowTitle->getPrefixedText();
			}
		}
		// error_log( "TEMPLATES" . print_r($result,true) );
		return $result;
	}

	/**
	 * Subpages linked to a page
	 *
	 * @param string $pageName to look up
	 * @return array associative array index by titles
	 */
	private static function getSubpages( string $pageName ) {
		$result = [];
		$title = Title::newFromText( $pageName );
		if ( $title ) {
			$dbr = wfGetDB( DB_REPLICA );
			$resultDb = new TitleArrayFromResult(
				$dbr->select( 'page',
					// [ 'tl_namespace AS namespace', 'tl_title AS title' ],
					[ 'page_id', 'page_namespace', 'page_title', 'page_is_redirect' ],
					[
						'page_namespace' => $title->getNamespace(),
						'page_title' . $dbr->buildLike( $title->getDBkey() . '/', $dbr->anyString() )
					],
					__METHOD__
				)
			);

			$deepWait = substr_count( $pageName, '/' ) + 1;
			foreach ( $resultDb as $row ) {
				$prefixedName = $row->getPrefixedText();
				if ( $deepWait === substr_count( $prefixedName, '/' ) ) {
					$result[] = $prefixedName;
				}
			}
		}
		return $result;
	}

	/**
	 * Files linked to a page
	 *
	 * @param string $pageName to look up
	 * @return array associative array index by titles
	 */
	private static function getLocalFiles( $pageName ) {
		$result = [];
		$dbr = wfGetDB( DB_REPLICA );
		// foreach ( $pageNames as $pageName ) {
		$title = Title::newFromText( $pageName );
		if ( $title ) {
			$resultDb = null;
			$pageSet[$title->getPrefixedText()] = true;
				$resultDb = $dbr->select(
				[ 'page', 'imagelinks' ],
					[ NS_FILE . ' AS namespace', 'il_to AS title' ],
					[
					'page_namespace' => $title->getNamespace(),
					'page_title' => $title->getDBkey()
					],
				__METHOD__,
				[],
					[
					'imagelinks' => [ 'INNER JOIN', [ 'page_id=il_from', 'page_namespace=il_from_namespace' ] ]
				]
				);
			if ( $resultDb ) {
				foreach ( $resultDb as $row ) {
					$rowTitle = Title::makeTitle( $row->namespace, $row->title );
					$result[] = $rowTitle->getPrefixedText();
				}
			}
		}
		// error_log( "FILES" . print_r($result,true) );
		return $result;
	}

	/**
	 * Attached pages by namespaces to a page
	 *
	 * @param string $pageName to look up
	 * @return array associative array index by titles
	 */
	private static function getAttachedPagesByNamespaces( $pageName ) {
		$title = Title::newFromText( $pageName );
		$result = [];
		$attachedNamespacesToSearch = PushAll::getAttachedNamespaces();
		foreach ( $attachedNamespacesToSearch as $attachedNamespace ) {
			$result[$attachedNamespace] = [];
		}
		if ( $title->getNamespace() === 0 ) {
			foreach ( $attachedNamespacesToSearch as $attachedNamespace ) {
				$attachedTitle = Title::newFromText( $attachedNamespace . ":" . $title->getDBKey() );
				if ( $attachedTitle && $attachedTitle->exists() ) {
					$result[$attachedNamespace][] = $attachedTitle->getPrefixedText();
				}
			}
		}
		return $result;
	}

	/**
	 * Revisions of a page since its last push
	 *
	 * @param string $pageName
	 * @param PushAllTargets $targets
	 * @return array
	 */
	public static function getRevisions( string $pageName, PushAllTargets $targets ) {
		$result = [];
		$dbr = wfGetDB( DB_REPLICA );
		$title = Title::newFromText( $pageName );
		if ( $title ) {
			$pageSet[$title->getPrefixedText()] = true;
			$resultDb = $dbr->select(
				[
					'page',
					'revision',
					'comment',
					'actor',
					// phpcs:ignore
					'(SELECT ct_rev_id,ct_params FROM `change_tag_def`, `change_tag` WHERE ctd_id = ct_tag_id AND  ctd_name = "pushall-push") as pushtags'
				],
				[ 'rev_id', 'actor_name', 'rev_len', 'comment_text', 'rev_timestamp', 'ct_params' ],
				[
					'page_namespace' => $title->getNamespace(),
					'page_title' => $title->getDBkey(),
				],
				__METHOD__,
				[ 'LIMIT' => 100, "ORDER BY" => 'rev_timestamp DESC' ],
				[
					'revision' => [
						'INNER JOIN',
						[ 'page_id=rev_page' ]
					],
					'comment' => [
						'LEFT JOIN',
						[ 'rev_comment_id=comment_id' ]
					],
					'actor' => [
						'LEFT JOIN',
						[ 'rev_actor=actor_id' ]
					],
					// phpcs:ignore
					'(SELECT ct_rev_id,ct_params FROM `change_tag_def`, `change_tag` WHERE ctd_id = ct_tag_id AND  ctd_name = "'
					. PushAllTags::TAG_PUSH
					. '") as pushtags' => [
						'LEFT JOIN',
						[ 'ct_rev_id = rev_id' ]
					]
				]
			);

			$findPrecedentPushInTarget = [];
			foreach ( $targets->getArray() as  $targetName => $target ) {
				$findPrecedentPushInTarget[$targetName] = false;
			}

			foreach ( $resultDb as $row ) {
				$revision = [];
				$revision['revid'] = (int)$row->rev_id;
				$revision['user'] = $row->actor_name;
				$revision['len'] = (int)$row->rev_len;
				$revision['comment'] = $row->comment_text;
				$revision['timestamp'] = (int)$row->rev_timestamp;
				$revision['push'] = [];

				if ( $row->ct_params ) {
					$revision['push'] = FormatJson::decode( $row->ct_params, true );
					foreach ( $revision['push'] as $targetName => $info ) {
						if ( array_key_exists( $targetName, $findPrecedentPushInTarget ) ) {
							$findPrecedentPushInTarget[$targetName] = true;
						}
					}
				}
				$result[] = $revision;
				$continue = false;
				foreach ( $targets->getArray() as  $targetName => $target ) {
					$continue = $continue || !$findPrecedentPushInTarget[$targetName];
				}
				if ( !$continue ) {
					break;
				}
			}
		}
		return $result;
	}
}

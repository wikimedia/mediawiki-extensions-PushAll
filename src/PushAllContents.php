<?php
/**
 * PushAllContent describes all relations with other pages in the wiki.
 *
 * @file PushAllContents.php
 * @ingroup PushAll
 *
 * @author Karima Rafes < karima.rafes@gmail.com >
 */

/**
 * Class PushAllContents
 */
class PushAllContents {
	/**
	 * Array of graphs of pages
	 * @var array
	 */
	public $contentsGraph;

	/**
	 * Set of known pages
	 * @var array
	 */
	public $pagesSet;

	/**
	 * Set of known files
	 * @var array
	 */
	public $filesSet;

	/**
	 * Information about remote wikis
	 * @var PushAllTargets
	 */
	public $targets;

	/**
	 * PushAllContents constructor.
	 *
	 * @param PushAllTargets $targets
	 */
	public function __construct( PushAllTargets $targets ) {
		$this->targets = $targets;
		$this->contentsGraph = [];
		$this->pagesSet = [];
		$this->filesSet = [];
	}

	/**
	 * Add a new page to push
	 *
	 * @param Title $title
	 */
	public function addTitleToPush( Title $title ) {
		$titlePrefixed = $title->getPrefixedText();
		$this->addContentToRoot( $titlePrefixed );
	}

	/**
	 * Add new pages to push
	 *
	 * @param array $titles
	 */
	public function addTitlesToPush( array $titles ) {
		foreach ( $titles as $title ) {
			$titlePrefixed = $title->getPrefixedText();
			$this->addContentToRoot( $titlePrefixed );
		}
	}

	/**
	 * Add a new page to push
	 *
	 * @param string $titlePrefixed
	 */
	public function addContentToRoot( string $titlePrefixed ) {
		$content = PushAllContent::factory( $titlePrefixed, $this, $this->targets );

		$title = Title::newFromText( $titlePrefixed );
		$namespace = $title->getNamespace();

		if ( $namespace == NS_FILE ) {
			$content->isFile = true;
			$this->addFile( $content );
		} elseif ( $namespace == NS_TEMPLATE ) {
			$content->isTemplate = true;
		}

		$this->contentsGraph[$titlePrefixed] = $content;
		$this->addPage( $content );
	}

	/**
	 * Save a page
	 *
	 * @param PushAllContent $content
	 */
	public function addPage( PushAllContent $content ) {
		$this->pagesSet[$content->titlePrefixed] = $content;
	}

	/**
	 * Save a file
	 *
	 * @param PushAllContent $content
	 */
	public function addFile( PushAllContent $content ) {
		$this->filesSet[$content->titlePrefixed] = $content;
	}

	/**
	 * Lookup a page in memory
	 *
	 * @param string $titlePrefixed
	 * @return bool
	 */
	public function isKnownPage( string $titlePrefixed ) {
		return array_key_exists( $titlePrefixed, $this->pagesSet );
	}

	/**
	 * Get a content
	 *
	 * @param string $titlePrefixed
	 * @return PushAllContent
	 */
	public function getPage( string $titlePrefixed ) {
		return $this->pagesSet[$titlePrefixed];
	}

	/**
	 * Get all contents
	 *
	 * @return array of PushAllContent
	 */
	public function getPagesList() {
		$result = [];
		foreach ( $this->pagesSet as $titlePrefixed => $content ) {
			$result[] = $titlePrefixed;
		}
		return $result;
	}

	/**
	 * Serialize all graphs of contents to push for the module ext.pushall.js
	 *
	 * @param Language $lang for formatting the timespan in the JSON
	 * @return string
	 */
	public function serializeToJson( Language $lang ) {
		$contentsGraphLight = [];
		foreach ( $this->contentsGraph as $titlePrefixed => $content ) {
			$contentsGraphLight[$titlePrefixed] = $content->serializeToArray( $lang );
		}
		return json_encode( $contentsGraphLight );
	}
}

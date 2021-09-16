<?php
/**
 * Input widget with a text field to select a category in the wiki
 *
 * @file PushallCategorySelector.php
 * @ingroup PushAll
 *
 * @author Karima Rafes < karima.rafes@gmail.com >
 */

use OOUI\SearchInputWidget;

/**
 * Class PushallCategorySelector
 */
class PushallCategorySelector extends SearchInputWidget {

	/**
	 * Constructor.
	 *
	 * @param array $config
	 */
	public function __construct( array $config = [] ) {
		parent::__construct( $config );
		$this->addClasses( [ 'mw-pushall-widget-category-selector' ] );
	}

	/**
	 * Script of widget
	 *
	 * @return string
	 */
	protected function getJavaScriptClassName() {
		return 'mw.widgets.PushallCategorySelector';
	}
}

<?php
/**
 * Input widget with a text field to select a page in the wiki
 *
 * @file PushallPageSelector.php
 * @ingroup PushAll
 *
 * @author Karima Rafes < karima.rafes@gmail.com >
 */

use OOUI\SearchInputWidget;

/**
 * Class PushallPageSelector
 */
class PushallPageSelector extends SearchInputWidget {

	/**
	 * Constructor.
	 *
	 * @param array $config
	 */
	public function __construct( array $config = [] ) {
		parent::__construct( $config );
		$this->addClasses( [ 'mw-pushall-widget-page-selector' ] );
	}

	/**
	 * Script of widget
	 *
	 * @return string
	 */
	protected function getJavaScriptClassName() {
		return 'mw.widgets.PushallPageSelector';
	}
}

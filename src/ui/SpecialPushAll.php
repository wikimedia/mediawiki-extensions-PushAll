<?php
/**
 * A special page that allows pushing one or more pages to one or more targets.
 *
 * @file SpecialPushAll.php
 * @ingroup PushAll
 *
 * @author Karima Rafes < karima.rafes@gmail.com >
 */

/**
 * Class SpecialPushAll
 */
class SpecialPushAll extends SpecialPage {

	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct( 'PushAll' );
	}

	/**
	 * Get GroupName : pagetools
	 *
	 * @return string
	 */
	protected function getGroupName() {
		return 'pagetools';
	}

	/**
	 * Main method.
	 *
	 * @param string $arg
	 */
	public function execute( $arg ) {
		$request = $this->getRequest();
		$output = $this->getOutput();
		$this->setHeaders();
		$output->addModules( 'ext.pushall.special' );
		$output->enableOOUI();

		// Todo ?
		// if (! PushAll::isAllowedToPush($this->getUser())) {
		//	throw new PermissionsError( 'pushall' );
		//}

		# Get request data from, e.g.
		$paramAction = $request->getText( 'action' );
		$paramTitles = $request->getText( 'pushallTitles' );

		if ( empty( $paramAction ) || empty( $paramTitles ) || $paramAction == 'select' ) {
			$this->showFormSelectTitles();
		} elseif ( $paramAction == 'analyze' ) {
			$this->showFormSelectTitles( $paramTitles );
			if ( !empty( $paramTitles ) ) {
				PushAllComponents::formPushAll( $this->getOutput(), $this->getUser(), explode( "\n", $paramTitles ) );
			}
		}
	}

	/**
	 * Form to select titles
	 *
	 * @param string $paramTitles
	 * @throws \OOUI\Exception
	 */
	private function showFormSelectTitles( $paramTitles = "" ) {
		$pageSearchField = new OOUI\ActionFieldLayout(
			new PushallPageSelector( [
				'name' => 'pushallPageSelector',
				'placeholder' => $this->msg( 'pushall-special-page-action-field-placeholder' )->text(),
				'infusable' => true,
				'id' => 'pushallPageSelector'
			] ),
			new OOUI\ButtonInputWidget( [
				'label' => $this->msg( 'pushall-special-page-action-field-button' )->text(),
				'type' => 'button',
				'flags' => [ 'progressive' ],
				'id' => 'pushallPageAddButton'
			] ),
			[
				'label' => $this->msg( 'pushall-special-page-action-field-top-label' )->text(),
				'align' => 'top'
			]
		);

		$categoryField = new OOUI\ActionFieldLayout(
			new PushallCategorySelector( [
				'name' => 'pushallCategorySelector',
				'placeholder' => $this->msg( 'pushall-special-category-action-field-placeholder' )->text(),
				'infusable' => true,
				'id' => 'pushallCategorySelector'
			] ),
			new OOUI\ButtonInputWidget( [
				'label' => $this->msg( 'pushall-special-category-action-field-button' )->text(),
				'type' => 'button',
				'flags' => [ 'progressive' ],
				'id' => 'pushallCategoryAddButton'
			] ),
			[
				'label' => $this->msg( 'pushall-special-category-action-field-top-label' )->text(),
				'align' => 'top'
			]
		);

		$namespaceField = new OOUI\ActionFieldLayout(
			new MediaWiki\Widget\NamespaceInputWidget( [
				// 'placeholder' => $this->msg( 'pushall-special-namespace-action-field-placeholder' )->text(),
				'value' => '',
				'name' => 'pushallNamespaceSelector',
				'id' => 'pushallNamespaceSelector',
			] ),

			new OOUI\ButtonInputWidget( [
				'label' => $this->msg( 'pushall-special-namespace-action-field-button' )->text(),
				'type' => 'button',
				'flags' => [ 'progressive' ],
				'id' => 'pushallNamespaceAddButton'
			] ),
			[
				'label' => $this->msg( 'pushall-special-namespace-action-field-top-label' )->text(),
				'align' => 'top'
			]
		);

		$this->getOutput()->addHTML(
			Html::rawElement(
				'div',
				[
					'class' => 'mw-message-box mw-message-box-error mw-content-ltr',
					'style' => 'display:none;max-width: 50em;',
					'id' => 'errorpushallspecial'
				]
			)
			. '<p>'
			. nl2br( $this->msg( 'pushall-special-description' )->text(), true )
			. '</p>'
		);

		$this->getOutput()->addHTML(
			 new OOUI\FormLayout( [
			'method' => 'POST',
			'action' => $this->getPageTitle()->getLocalURL( 'action=analyze' ),
			'items' => [
				new OOUI\FieldsetLayout( [
					'label' => 'Push several pages',
					'items' => [
						$pageSearchField,
						$categoryField,
						$namespaceField,
						new OOUI\FieldLayout(
							new OOUI\MultilineTextInputWidget( [
								'autosize' => true,
								'rows' => 10,
								'name' => 'pushallTitles',
								'id' => 'pushallTitles',
								'value' => $paramTitles
							] ),
							[
								'label' => $this->msg( 'pushall-special-pages-selectarea-top-label' )->text(),
								'align' => 'top',
							]
						),
						new OOUI\FieldLayout(
							new OOUI\ButtonInputWidget( [
								'name' => 'analyzeTitle',
								'label' => $this->msg( 'pushall-special-button-submit-analyze' )->text(),
								'type' => 'submit',
								// 'flags' => [ 'primary', 'progressive' ],
								'icon' => 'articlesSearch',
							] ),
							[
								'label' => null,
								'align' => 'top',
							]
						)
					]
				] )
			]
			 ] ) );
	}

	/**
	 * @see SpecialPage::getDescription
	 *
	 * @return string
	 */
	public function getDescription() {
		return $this->msg( 'pushall-special' )->text();
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
}

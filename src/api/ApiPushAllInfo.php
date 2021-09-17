<?php
/**
 * API module to push wiki pages to other MediaWiki wikis.
 *
 * @file ApiPushAll.php
 * @ingroup PushAll
 *
 * @author Karima Rafes < karima.rafes@gmail.com >
 */

use MediaWiki\MediaWikiServices;

/**
 * Class ApiPushAllInfo
 */
class ApiPushAllInfo extends ApiPushAllBase {

	/**
	 * ApiPushAll constructor.
	 *
	 * @param ApiMain $main main parameter
	 * @param string $action action parameter
	 */
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	protected function doModuleExecute() {
		$params = $this->extractRequestParams();
		$targets = PushAll::getTargets( $this->getUser() );
		$contents = new PushAllContents( $targets );
		foreach ( $params['targets'] as $targetName ) {
			if ( !$targets->exist( $targetName ) ) {
				$this->dieWithErrorCodeRemoteWiki( 'pushall-error-not-credentials-for-this-target', $targetName );
			}
		}
		foreach ( $params['targets'] as $targetName ) {
			$target = $targets->get( $targetName );
			$this->doRequestLoginToken( $target );
			$this->doRequestLogin( $target );
			foreach ( $params['titles'] as $pageTitle ) {
				$title = Title::newFromText( $pageTitle );
				if ( $title->exists() ) {
					$contents->addTitleToPush( $title );
				}
			}
			$this->doRequestPageRevision( $target, $contents->getPagesList() );
		}
	}

	/**
	 * Read the pages' information in the specified wiki.
	 *
	 * @param PushAllTarget $target
	 * @param array $titles
	 * @throws ApiUsageException
	 * @throws MWException
	 */
	private function doRequestPageRevision( PushAllTarget $target, array $titles ) {
		$requestData = [
			'action' => 'query',
			'format' => 'json',
			'prop' => 'revisions|info',
			'rvprop' => 'timestamp|user|comment|tags|ids',
			'inprop' => 'protection',
			'titles' => implode( "|", $titles ),
			'rvslots' => '*'
			];

		$options = [
			'method' => 'POST',
			'postData' => $requestData,
		];

		$req = MediaWikiServices::getInstance()->getHttpRequestFactory()
			->create( $target->endpoint, $options, __METHOD__ );

		if ( !empty( $target->cookie ) ) {
			$req->setCookieJar( $target->cookie );
		}

		$status = $req->execute();
		$response = $status->isOK() ? FormatJson::decode( $req->getContent() ) : null;
		if ( $response === null ) {
			$this->dieWithErrorUnknown( print_r( $status->getErrors(), true ), $target->name );
		} elseif ( property_exists( $response, 'error' ) ) {
			$this->dieWithErrorCodeRemoteWiki( $response->error->info, $target->name );
		}

		$this->getResult()->addValue(
			null,
			$target->name,
			$response
		);
	}

	/**
	 * List parameters
	 *
	 * @return array
	 */
	public function getAllowedParams() {
		return [
			'titles' => [
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_REQUIRED => true,
			],
			'targets' => [
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_REQUIRED => true,
			],
		];
	}

	/**
	 * @see ApiBase::getExamplesMessages()
	 *
	 * @return array
	 */
	protected function getExamplesMessages() {
		return [
			'action=pushallinfo&titles=page1|page2&targets=target1|target2'
				=> 'apihelp-pushall-example',
		];
	}
}

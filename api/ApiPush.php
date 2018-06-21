<?php

/**
 * API module to push wiki pages to other MediaWiki wikis.
 *
 * @since 0.3
 *
 * @file ApiPush.php
 * @ingroup Push
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiPush extends ApiPushBase {

	protected $editResponses = [];

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function execute() {
		global $wgUser;

		if ( !$wgUser->isAllowed( 'push' ) || $wgUser->isBlocked() ) {
			$this->dieUsageMsg( [ 'badaccess-groups' ] );
		}

		global $egPushLoginUser, $egPushLoginPass, $egPushLoginUsers, $egPushLoginPasswords, $egPushLoginDomain, $egPushLoginDomains;

		$params = $this->extractRequestParams();

		PushFunctions::flipKeys( $egPushLoginUsers, 'users' );
		PushFunctions::flipKeys( $egPushLoginPasswords, 'passwds' );
		PushFunctions::flipKeys( $egPushLoginDomains, 'domains' );

		foreach ( $params['targets'] as &$target ) {
			$user = false;
			$pass = false;
			$domain = false;

			if ( array_key_exists( $target, $egPushLoginUsers ) && array_key_exists( $target, $egPushLoginPasswords ) ) {
				$user = $egPushLoginUsers[$target];
				$pass = $egPushLoginPasswords[$target];
			} elseif ( $egPushLoginUser != '' && $egPushLoginPass != '' ) {
				$user = $egPushLoginUser;
				$pass = $egPushLoginPass;
			}
			if ( array_key_exists( $target, $egPushLoginDomains ) ) {
				$domain = $egPushLoginDomains[$target];
			} elseif ( $egPushLoginDomain != '' ) {
				$domain = $egPushLoginDomain;
			}

			if ( substr( $target, -1 ) !== '/' ) {
				$target .= '/';
			}

			$target .= 'api.php';

			if ( $user !== false ) {
				$this->doLogin( $user, $pass, $domain, $target );
			}
		}

		foreach ( $params['page'] as $page ) {
			$title = Title::newFromText( $page );

			$revision = $this->getPageRevision( $title );

			if ( $revision !== false ) {
				$this->doPush( $title, $revision, $params['targets'] );
			}
		}

		foreach ( $this->editResponses as $response ) {
			$this->getResult()->addValue(
				null,
				null,
				FormatJson::decode( $response )
			);
		}
	}

	/**
	 * Makes an internal request to the API to get the needed revision.
	 *
	 * @since 0.3
	 *
	 * @param Title $title
	 *
	 * @return array or false
	 */
	protected function getPageRevision( Title $title ) {
		$revId = PushFunctions::getRevisionToPush( $title );

		$requestData = [
			'action' => 'query',
			'format' => 'json',
			'prop' => 'revisions',
			'rvprop' => 'timestamp|user|comment|content',
			'titles' => $title->getFullText(),
			'rvstartid' => $revId,
			'rvendid' => $revId,
		];

		$api = new ApiMain( new FauxRequest( $requestData, true ), true );
		$api->execute();
		if ( defined( 'ApiResult::META_CONTENT' ) ) {
			$response = $api->getResult()->getResultData( null, [
				'BC' => [],
				'Types' => [],
				'Strip' => 'all',
			] );
		} else {
			$response = $api->getResultData();
		}

		$revision = false;

		if ( $response !== false
			&& array_key_exists( 'query', $response )
			&& array_key_exists( 'pages', $response['query'] )
			&& count( $response['query']['pages'] ) > 0
		) {

			foreach ( $response['query']['pages'] as $key => $value ) {
				$first = $key;
				break;
			}

			if ( array_key_exists( 'revisions', $response['query']['pages'][$first] )
				&& count( $response['query']['pages'][$first]['revisions'] ) > 0 ) {
				$revision = $response['query']['pages'][$first]['revisions'][0];
			} else {
				$this->dieUsage( wfMessage( 'push-special-err-pageget-failed' )->text(), 'page-get-failed' );
			}
		} else {
			$this->dieUsage( wfMessage( 'push-special-err-pageget-failed' )->text(), 'page-get-failed' );
		}

		return $revision;
	}

	/**
	 * Pushes the page content to the target wikis.
	 *
	 * @since 0.3
	 *
	 * @param Title $title
	 * @param array $revision
	 * @param array $targets
	 */
	protected function doPush( Title $title, array $revision, array $targets ) {
		foreach ( $targets as $target ) {
			$token = $this->getEditToken( $title, $target );

			if ( $token !== false ) {
				$doPush = true;

				Hooks::run( 'PushAPIBeforePush', [ &$title, &$revision, &$target, &$token, &$doPush ] );

				if ( $doPush ) {
					$this->pushToTarget( $title, $revision, $target, $token );
				}
			}
		}
	}

	/**
	 * Pushes the page content to the specified wiki.
	 *
	 * @since 0.3
	 *
	 * @param Title $title
	 * @param array $revision
	 * @param string $target
	 * @param string $token
	 */
	protected function pushToTarget( Title $title, array $revision, $target, $token ) {
		global $wgSitename;

		$summary = wfMessage(
			'push-import-revision-message',
			$wgSitename
			// $revision['user']
		)->parse();

		$requestData = [
			'action' => 'edit',
			'title' => $title->getFullText(),
			'format' => 'json',
			'summary' => $summary,
			'text' => $revision['*'],
			'token' => $token,
		];

		$req = MWHttpRequest::factory( $target,
			[
				'method' => 'POST',
				'timeout' => 'default',
				'postData' => $requestData
			]
		);

		if ( array_key_exists( $target, $this->cookieJars ) ) {
			$req->setCookieJar( $this->cookieJars[$target] );
		}

		$status = $req->execute();

		if ( $status->isOK() ) {
			$response = $req->getContent();
			$this->editResponses[] = $response;
			Hooks::run( 'PushAPIAfterPush', [ $title, $revision, $target, $token, $response ] );
		} else {
			$this->dieUsage( wfMessage( 'push-special-err-push-failed' )->text(), 'page-push-failed' );
		}
	}

	public function getAllowedParams() {
		return [
			'page' => [
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
	 */
	protected function getExamplesMessages() {
		return [
			'action=push&page=Main page&targets=http://en.wikipedia.org/w'
				=> 'apihelp-push-example',
		];
	}
}

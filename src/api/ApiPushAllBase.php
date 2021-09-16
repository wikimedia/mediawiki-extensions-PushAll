<?php
/**
 * ApiPushBase is the abstract class for all Api modules.
 *
 * @file ApiPushAllBase.php
 * @ingroup PushAll
 *
 * @author Karima Rafes < karima.rafes@gmail.com >
 */

use MediaWiki\MediaWikiServices;

/**
 * Class ApiPushAllBase
 */
abstract class ApiPushAllBase extends ApiBase {

	public function execute() {
		if ( !PushAll::isAllowedToPush( $this->getUser() ) ) {
			$this->dieWithError(
				$this->msg( 'pushall-error-user-not-allow"' )->text(),
				$this->errorCode( 'pushall-error-user-not-allow"' )
			);
		}
		$this->doModuleExecute();
	}

	/**
	 * Generate a code to associate a error with a target
	 * @param string $msg Tag of the error message
	 * @param string $targetName Name of targeted wiki
	 * @return string
	 */
	protected static function errorCode( string $msg, string $targetName = '' ) {
		return 'pushall-errormsg-' . $msg . '-target-' . $targetName;
	}

	/**
	 * Obtains the needed login token by making an HTTP POST request
	 * to the remote wikis API.
	 *
	 * @param PushAllTarget $target
	 */
	protected function doRequestLoginToken( PushAllTarget $target ) {
		$options = [
			'method' => 'GET'
		];

		$req = MediaWikiServices::getInstance()->getHttpRequestFactory()
			->create( $target->endpoint . "?action=query&format=json&meta=tokens&type=login", $options, __METHOD__ );

		if ( !empty( $target->cookie ) ) {
			$req->setCookieJar( $target->cookie );
		}

		$status = $req->execute();
		$response = $status->isOK() ? FormatJson::decode( $req->getContent() ) : null;
		if (
			$response === null
			|| !property_exists( $response, 'query' )
			|| !property_exists( $response->query, 'tokens' )
			|| !property_exists( $response->query->tokens, 'logintoken' )
			|| empty( $response->query->tokens->logintoken )
		) {
			$this->dieWithError(
				$this->msg( 'pushall-error-login-token-failed' )->text(),
				$this->errorCode( 'pushall-error-token-request-failed', $target->name )
			);
		}
		$target->tokenLogin = $response->query->tokens->logintoken;
		$target->cookie = $req->getCookieJar();
	}

	/**
	 *  Connect to the remote wikis API.
	 *
	 * @param PushAllTarget $target
	 */
	protected function doRequestLogin( $target ) {
		$requestData = [
			'action' => 'login',
			'format' => 'json',
			'lgname' => $target->login,
			'lgpassword' => $target->key,
			'lgtoken' => $target->tokenLogin
		];

		$options = [
			'method' => 'POST',
			'postData' => $requestData
		];
		$req = MediaWikiServices::getInstance()->getHttpRequestFactory()
			->create( $target->endpoint, $options, __METHOD__ );

		if ( !empty( $target->cookie ) ) {
			$req->setCookieJar( $target->cookie );
		}

		$status = $req->execute();
		$response = $status->isOK() ? FormatJson::decode( $req->getContent() ) : null;
		if (
			$response === null
			|| !property_exists( $response, 'login' )
			|| !property_exists( $response->login, 'result' )
		) {
			$this->dieWithError(
				$this->msg( 'pushall-error-authentication', $target->name, '' )->parse(),
				$this->errorCode( 'pushall-error-authentication', $target->name )
			);
		}

		if ( $response->login->result == 'Success' ) {
			$target->cookie = $req->getCookieJar();
		} else {
			$this->dieWithError(
				$this->msg( 'pushall-error-authentication', $target->name, '' )->parse(),
				$this->errorCode( 'pushall-error-authentication', $target->id )
			);
		}
	}

	/**
	 * Obtains the needed edit token by making an HTTP GET request
	 * to the remote wikis API.
	 *
	 * @param PushAllTarget $target
	 */
	protected function doRequestEditToken( PushAllTarget $target ) {
		$options = [
			'method' => 'GET'
		];
		$req = MediaWikiServices::getInstance()->getHttpRequestFactory()
			->create(
				$target->endpoint . "?action=query&format=json&meta=tokens&type=csrf",
				$options,
				__METHOD__
			);

		if ( !empty( $target->cookie ) ) {
			$req->setCookieJar( $target->cookie );
		}

		$status = $req->execute();
		$response = $status->isOK() ? FormatJson::decode( $req->getContent() ) : null;
		if (
			$response === null
			|| !property_exists( $response, 'query' )
			|| !property_exists( $response->query, 'tokens' )
			|| !property_exists( $response->query->tokens, 'csrftoken' )
			|| empty( $response->query->tokens->csrftoken )
		) {
			$this->dieWithError(
				$this->msg( 'pushall-error-token-failed' )->text(),
				$this->errorCode( 'pushall-error-token-failed', $target->name )
			);
		}
		$target->tokenEdit = $response->query->tokens->csrftoken;
		$target->cookie = $req->getCookieJar();
	}

	/**
	 * Obtains the information about last revisions of a title in the remote wiki.
	 *
	 * @param PushAllTarget $target
	 * @param Title $title
	 * @return array|null
	 * @throws ApiUsageException
	 * @throws MWException
	 */
	protected function getInfo( PushAllTarget $target, Title $title ) {
		$requestData = [
			'action' => 'query',
			'format' => 'json',
			'prop' => 'info',
			'titles' => $title->getFullText(),
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
		$response = $status->isOK() ? FormatJson::decode( $req->getContent(), true ) : null;
		if (
			$response === null
			|| !array_key_exists( 'query', $response )
			|| !array_key_exists( 'pages', $response['query'] )
		) {
			$this->dieWithError(
				$this->msg( 'pushall-error-info-failed' )->text(),
				$this->errorCode( 'pushall-error-info-failed', $target->name )
			);
		}

		if ( count( $response['query']['pages'] ) > 0 ) {
			$info = array_pop( $response['query']['pages'] );
			return [
				'lasterevid' => $info['lastrevid'],
				'touched' => $info['touched']
			];
		} else {
			return null;
		}
	}

	abstract protected function doModuleExecute();
}

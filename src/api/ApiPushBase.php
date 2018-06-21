<?php

abstract class ApiPushBase extends ApiBase {
	/**
	 * Associative array containing CookieJar objects (values) to be passed in
	 * order to authenticate to the targets (keys).
	 *
	 * @since 0.4
	 *
	 * @var array
	 */
	protected $cookieJars = [];

	/**
	 * Logs in into a target wiki using the provided username and password.
	 *
	 * @since 0.4
	 *
	 * @param string $user
	 * @param string $password
	 * @param string $domain
	 * @param string $target
	 * @param string|null $token
	 * @param null $cookieJar
	 * @param int $attemtNr
	 * @throws ApiUsageException
	 */
	protected function doLogin(
		$user, $password, $domain, $target, $token = null, $cookieJar = null, $attemtNr = 0
	) {
		$requestData = [
			'action' => 'login',
			'format' => 'json',
			'lgname' => $user,
			'lgpassword' => $password
		];
		if ( $domain != false ) {
			$requestData['lgdomain'] = $domain;
		}

		if ( !is_null( $token ) ) {
			$requestData['lgtoken'] = $token;
		}

		$req = MWHttpRequest::factory( $target,
			[
				'postData' => $requestData,
				'method' => 'POST',
				'timeout' => 'default'
			]
		);

		if ( !is_null( $cookieJar ) ) {
			$req->setCookieJar( $cookieJar );
		}

		$status = $req->execute();

		$attemtNr++;

		if ( $status->isOK() ) {
			$response = FormatJson::decode( $req->getContent() );

			if ( property_exists( $response, 'login' )
				&& property_exists( $response->login, 'result' ) ) {

				if ( $response->login->result == 'NeedToken' && $attemtNr < 3 ) {
					$this->doLogin(
						$user,
						$password,
						$domain,
						$target,
						$response->login->token,
						$req->getCookieJar(),
						$attemtNr
					);
				} elseif ( $response->login->result == 'Success' ) {
					$this->cookieJars[$target] = $req->getCookieJar();
				} else {
					$this->dieUsage(
						wfMessage( 'push-err-authentication', $target, '' )->parse(),
						'authentication-failed'
					);
				}
			} else {
				$this->dieUsage(
					wfMessage( 'push-err-authentication', $target, '' )->parse(),
					'authentication-failed'
				);
			}
		} else {
			$this->dieUsage(
				wfMessage( 'push-err-authentication', $target, '' )->parse(),
				'authentication-failed' );
		}
	}

	/**
	 * Obtains the needed edit token by making an HTTP GET request
	 * to the remote wikis API.
	 *
	 * @since 0.3
	 *
	 * @param Title $title
	 * @param string $target
	 *
	 * @return string|false
	 */
	protected function getEditToken( Title $title, $target ) {
		$requestData = [
			'action' => 'query',
			'format' => 'json',
			'intoken' => 'edit',
			'prop' => 'info',
			'titles' => $title->getFullText(),
		];

		$parts = [];

		foreach ( $requestData as $key => $value ) {
			$parts[] = $key . '=' . urlencode( $value );
		}

		$req = MWHttpRequest::factory( $target . '?' . implode( '&', $parts ),
			[
				'method' => 'GET',
				'timeout' => 'default'
			]
		);

		if ( array_key_exists( $target, $this->cookieJars ) ) {
			$req->setCookieJar( $this->cookieJars[$target] );
		}

		$status = $req->execute();

		$response = $status->isOK() ? FormatJson::decode( $req->getContent() ) : null;

		$token = false;

		if ( !is_null( $response )
			&& property_exists( $response, 'query' )
			&& property_exists( $response->query, 'pages' )
			&& count( $response->query->pages ) > 0 ) {

			foreach ( $response->query->pages as $key => $value ) {
				$first = $key;
				break;
			}

			if ( property_exists( $response->query->pages->$first, 'edittoken' ) ) {
				$token = $response->query->pages->$first->edittoken;
			} elseif (
				!is_null( $response )
				&& property_exists( $response, 'query' )
				&& property_exists( $response->query, 'error' )
			) {
				$this->dieUsage( $response->query->error->message, 'token-request-failed' );
			} else {
				$this->dieUsage(
					wfMessage( 'push-special-err-token-failed' )->text(), 'token-request-failed'
				);
			}
		} else {
			$this->dieUsage(
				wfMessage( 'push-special-err-token-failed' )->text(),
				'token-request-failed'
			);
		}

		return $token;
	}

	public function execute() {
		global $wgUser, $egPushLoginUser, $egPushLoginPass, $egPushLoginUsers,
			$egPushLoginPasswords, $egPushLoginDomain, $egPushLoginDomains;

		if ( !$wgUser->isAllowed( 'push' ) || $wgUser->isBlocked() ) {
			$this->dieUsageMsg( [ 'badaccess-groups' ] );
		}

		$params = $this->extractRequestParams();

		PushFunctions::flipKeys( $egPushLoginUsers, 'users' );
		PushFunctions::flipKeys( $egPushLoginPasswords, 'passwds' );
		PushFunctions::flipKeys( $egPushLoginDomains, 'domains' );

		foreach ( $params['targets'] as &$target ) {
			$user = false;
			$pass = false;
			$domain = false;

			if (
				array_key_exists( $target, $egPushLoginUsers )
				&& array_key_exists( $target, $egPushLoginPasswords )
			) {
				$user = $egPushLoginUsers[$target];
				$pass = $egPushLoginPasswords[$target];
			} elseif ( $egPushLoginUser !== '' && $egPushLoginPass !== '' ) {
				$user = $egPushLoginUser;
				$pass = $egPushLoginPass;
			}
			if ( array_key_exists( $target, $egPushLoginDomains ) ) {
				$domain = $egPushLoginDomains[$target];
			} elseif ( $egPushLoginDomain !== '' ) {
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

		$this->doModuleExecute();
	}

	abstract protected function doModuleExecute();
}

<?php
/**
 * ApiPushBase is the abstract class for all Api modules.
 *
 * @file ApiPushBase.php
 * @ingroup Push
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 * @author Karima Rafes < karima.rafes@gmail.com >
 */
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
	 * Associative array containing tokens.
	 *
	 * @var array
	 */
	protected $tokens = [];

	/**
	 * Obtains the needed login token by making an HTTP POST request
	 * to the remote wikis API.
	 *
	 * @since 1.4.0
	 *
	 * @param string $target
	 *
	 * @return string|false
	 */
	protected function getLoginToken( $target ) {
		$requestData = [
			'action' => 'query',
			'format' => 'json',
			'meta' => 'tokens',
			'type' => 'login',
		];

		Http::$httpEngine = 'curl';
		$req = MWHttpRequest::factory( wfAppendQuery( $target . "/api.php", $requestData ),
			[
				'method' => 'POST',
				'timeout' => 'default'
			],
			__METHOD__
		);

		if ( array_key_exists( $target, $this->cookieJars ) ) {
			$req->setCookieJar( $this->cookieJars[$target] );
		}

		$status = $req->execute();

		$response = $status->isOK() ? FormatJson::decode( $req->getContent() ) : null;

		$token = false;

		// for debug :
		//error_log( print_r( $req->getContent(), true ) );

		if (
			$response === null
			|| !property_exists( $response, 'query' )
			|| !property_exists( $response->query, 'tokens' )
			|| empty( $response->query->tokens )
		) {
			$this->dieWithError(
				$this->msg( 'push-special-err-token-failed' )->text(),
				'token-request-failed'
			);
		}
		// error_log(print_r(property_exists( $response->query->tokens, 'logintoken' ) , TRUE));
		if ( property_exists( $response->query->tokens, 'logintoken' ) ) {
			$token = $response->query->tokens->logintoken;
		} elseif (
			$response !== null
			&& property_exists( $response, 'query' )
			&& property_exists( $response->query, 'error' )
		) {
			$this->dieWithError( $response->query->error->message, 'token-request-failed' );
		} else {
			$this->dieWithError(
				$this->msg( 'push-special-err-token-failed' )->text(),
				'token-request-failed'
			);
		}

		$this->tokens[$target] = $token;
		$this->cookieJars[$target] = $req->getCookieJar();
	}

	/**
	 * Logs in into a target wiki using the provided username and password.
	 *
	 * @since 0.4
	 *
	 * @param string $user
	 * @param string $password
	 * @param string $domain
	 * @param string $target
	 * @throws ApiUsageException
	 */
	protected function doLogin( $user, $password, $domain, $target ) {
		$requestData = [
			'action' => 'login',
			'format' => 'json',
			'lgname' => $user,
			'lgpassword' => $password
		];
		if ( $domain != false ) {
			$requestData['lgdomain'] = $domain;
		}

		if ( array_key_exists( $target, $this->tokens ) ) {
			$requestData['lgtoken'] = $this->tokens[$target];
		}

		Http::$httpEngine = 'curl';
		$req = MWHttpRequest::factory( $target . "/api.php",
			[
				'postData' => $requestData,
				'method' => 'POST',
				'timeout' => 'default'
			],
			__METHOD__
		);

		if ( array_key_exists( $target, $this->cookieJars ) ) {
			$req->setCookieJar( $this->cookieJars[$target] );
		}

		$status = $req->execute();

		if ( !$status->isOK() ) {
			$this->dieWithError(
				$this->msg( 'push-err-authentication', $target, '' )->parse(),
				'authentication-failed'
			);
		}

		$response = FormatJson::decode( $req->getContent() );
		// for debug :
		// error_log( print_r( $response, true ) );
		if ( !property_exists( $response, 'login' ) || !property_exists( $response->login, 'result' ) ) {
			$this->dieWithError(
				$this->msg( 'push-err-authentication', $target, '' )->parse(),
				'authentication-failed'
			);
		}

		if ( $response->login->result == 'Success' ) {
			$this->cookieJars[$target] = $req->getCookieJar();
		} else {
			$this->dieWithError(
				$this->msg( 'push-err-authentication', $target, '' ),
				'authentication-failed'
			);
		}
	}

	/**
	 * Obtains the needed edit token by making an HTTP GET request
	 * to the remote wikis API.
	 *
	 * @since 0.3
	 *
	 * @param string $target
	 *
	 * @return string|false
	 */
	protected function getEditToken( $target ) {
		$requestData = [
			'action' => 'query',
			'format' => 'json',
			'meta' => 'tokens',
			'type' => 'csrf',
		];

		Http::$httpEngine = 'curl';
		$req = MWHttpRequest::factory( wfAppendQuery( $target . "/api.php", $requestData ),
			[
				'method' => 'GET',
				'timeout' => 'default'
			],
			__METHOD__
		);

		if ( array_key_exists( $target, $this->cookieJars ) ) {
			$req->setCookieJar( $this->cookieJars[$target] );
		}

		$status = $req->execute();

		$response = $status->isOK() ? FormatJson::decode( $req->getContent() ) : null;

		// for debug :
		//error_log( print_r( $req->getContent(), true ) );

		$token = false;

		if (
			$response === null
			|| !property_exists( $response, 'query' )
			|| !property_exists( $response->query, 'tokens' )
			|| empty( $response->query->tokens )
		) {
			$this->dieWithError(
				$this->msg( 'push-special-err-token-failed' )->text(),
				'token-request-failed'
			);
		}

		if ( property_exists( $response->query->tokens, 'csrftoken' ) ) {
			$token = $response->query->tokens->csrftoken;
		} elseif (
			$response !== null
			&& property_exists( $response, 'query' )
			&& property_exists( $response->query, 'error' )
		) {
			$this->dieWithError( $response->query->error->message, 'token-request-failed' );
		} else {
			$this->dieWithError(
				$this->msg( 'push-special-err-token-failed' )->text(),
				'token-request-failed'
			);
		}

		return $token;
	}

	public function execute() {
		if ( !$this->getUser()->isAllowed( 'push' ) || $this->getUser()->isBlocked() ) {
			$this->dieWithErrorMsg( [ 'badaccess-groups' ] );
		}

		$params = $this->extractRequestParams();

		$config = ConfigFactory::getDefaultInstance()->makeConfig( 'egPushAll' );
		$egPushAllLoginUsers = [];
		$egPushAllLoginPasswords = [];
		$egPushAllLoginDomains = [];
		if ( !$config->has( "LoginUsers" ) ) {
			// throw new MWException( "egPushAllPushLoginUsers is not precised in the localsettings." );
		} else {
			$egPushAllLoginUsers = $config->get( "LoginUsers" );
		}
		if ( !$config->has( "LoginPasswords" ) ) {
			// throw new MWException( "egPushAllPushLoginPasswords is not precised in the localsettings." );
		} else {
			$egPushAllLoginPasswords = $config->get( "LoginPasswords" );
		}
		if ( !$config->has( "LoginDomains" ) ) {
			// throw new MWException( "egPushAllPushLoginDomains is not precised in the localsettings." );
		} else {
			$egPushAllLoginDomains = $config->get( "LoginDomains" );
		}

		PushFunctions::flipKeys( $egPushAllLoginUsers, 'users' );
		PushFunctions::flipKeys( $egPushAllLoginPasswords, 'passwds' );
		PushFunctions::flipKeys( $egPushAllLoginDomains, 'domains' );

		foreach ( $params['targets'] as &$target ) {
			$user = false;
			$pass = false;
			$domain = false;

			if (
				array_key_exists( $target, $egPushAllLoginUsers )
				&& array_key_exists( $target, $egPushAllLoginPasswords )
			) {
				$user = $egPushAllLoginUsers[$target];
				$pass = $egPushAllLoginPasswords[$target];
			}
			if ( array_key_exists( $target, $egPushAllLoginDomains ) ) {
				$domain = $egPushAllLoginDomains[$target];
			}

			if ( $user !== false ) {
				$this->getLoginToken( $target );
				$this->doLogin(
					$user,
					$pass,
					$domain,
					$target );
			}
		}

		$this->doModuleExecute();
	}

	abstract protected function doModuleExecute();
}

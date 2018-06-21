<?php

/**
 * API module to push images to other MediaWiki wikis.
 *
 * @since 0.5
 *
 * @file ApiPushImages.php
 * @ingroup Push
 *
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */
class ApiPushImages extends ApiBase {

	/**
	 * Associative array containing CookieJar objects (values) to be passed in
	 * order to authenticate to the targets (keys).
	 *
	 * @since 0.5
	 *
	 * @var array
	 */
	protected $cookieJars = [];

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

		if ( !isset( $params['images'] ) ) {
			$this->dieUsageMsg( [ 'missingparam', 'images' ] );
		}

		if ( !isset( $params['targets'] ) ) {
			$this->dieUsageMsg( [ 'missingparam', 'targets' ] );
		}

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

		foreach ( $params['images'] as $image ) {
			$title = Title::newFromText( $image, NS_FILE );
			if ( !is_null( $title ) && $title->getNamespace() == NS_FILE && $title->exists() ) {
				$this->doPush( $title, $params['targets'] );
			}
		}
	}

	/**
	 * Logs in into a target wiki using the provided username and password.
	 *
	 * @since 0.5
	 *
	 * @param string $user
	 * @param string $password
	 * @param string $target
	 * @param string $token
	 * @param CookieJar|null $cookie
	 * @param int|null $attemtNr
	 */
	protected function doLogin( $user, $password, $domain, $target, $token = null, $cookieJar = null, $attemtNr = 0 ) {
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

		$req = PushFunctions::getHttpRequest( $target,
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
					$this->doLogin( $user, $password, $domain, $target, $response->login->token, $req->getCookieJar(), $attemtNr );
				} elseif ( $response->login->result == 'Success' ) {
					$this->cookieJars[$target] = $req->getCookieJar();
				} else {
					$this->dieUsage( wfMessage( 'push-err-authentication', $target, '' )->parse(), 'authentication-failed' );
				}
			} else {
				$this->dieUsage( wfMessage( 'push-err-authentication', $target, '' )->parse(), 'authentication-failed' );
			}
		} else {
			$this->dieUsage( wfMessage( 'push-err-authentication', $target, '' )->parse(), 'authentication-failed' );
		}
	}

	/**
	 * Pushes the page content to the target wikis.
	 *
	 * @since 0.5
	 *
	 * @param Title $title
	 * @param array $targets
	 */
	protected function doPush( Title $title, array $targets ) {
		foreach ( $targets as $target ) {
			$token = $this->getEditToken( $title, $target );

			if ( $token !== false ) {
				$doPush = true;

				Hooks::run( 'PushAPIBeforeImagePush', [ &$title, &$target, &$token, &$doPush ] );

				if ( $doPush ) {
					$this->pushToTarget( $title, $target, $token );
				}
			}
		}
	}

	/**
	 * Obtains the needed edit token by making an HTTP GET request
	 * to the remote wikis API.
	 *
	 * @since 0.5
	 *
	 * @param Title $title
	 * @param string $target
	 *
	 * @return string or false
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

		$req = PushFunctions::getHttpRequest( $target . '?' . implode( '&', $parts ),
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
			} elseif ( !is_null( $response ) && property_exists( $response, 'query' ) && property_exists( $response->query, 'error' ) ) {
				$this->dieUsage( $response->query->error->message, 'token-request-failed' );
			} else {
				$this->dieUsage( wfMessage( 'push-special-err-token-failed' )->text(), 'token-request-failed' );
			}
		} else {
			$this->dieUsage( wfMessage( 'push-special-err-token-failed' )->text(), 'token-request-failed' );
		}

		return $token;
	}

	/**
	 * Pushes the image to the specified wiki.
	 *
	 * @since 0.5
	 *
	 * @param Title $title
	 * @param string $target
	 * @param string $token
	 */
	protected function pushToTarget( Title $title, $target, $token ) {
		global $egPushDirectFileUploads;

		$imagePage = new ImagePage( $title );

		$requestData = [
			'action' => 'upload',
			'format' => 'json',
			'token' => $token,
			'filename' => $title->getText(),
			'ignorewarnings' => '1'
		];

		if ( $egPushDirectFileUploads ) {
			$file = $imagePage->getFile();
			$be = $file->getRepo()->getBackend();
			$localFile = $be->getLocalReference(
				[ 'src' => $file->getPath() ]
			);
			$requestData['file'] = '@' . $localFile->getPath();
		} else {
			$requestData['url'] = $imagePage->getDisplayedFile()->getFullUrl();
		}

		$reqArgs = [
			'method' => 'POST',
			'timeout' => 'default',
			'postData' => $requestData
		];

		if ( $egPushDirectFileUploads ) {
			if ( !function_exists( 'curl_init' ) ) {
				$this->dieUsage( wfMessage( 'push-api-err-nocurl' )->text(), 'image-push-nocurl' );
			} elseif ( !defined( 'CurlHttpRequest::SUPPORTS_FILE_POSTS' ) || !CurlHttpRequest::SUPPORTS_FILE_POSTS ) {
				$this->dieUsage( wfMessage( 'push-api-err-nofilesupport' )->text(), 'image-push-nofilesupport' );
			} else {
				$httpEngine = Http::$httpEngine;
				Http::$httpEngine = 'curl';
				$req = MWHttpRequest::factory( $target, $reqArgs );
				Http::$httpEngine = $httpEngine;
			}
		} else {
			$req = PushFunctions::getHttpRequest( $target, $reqArgs );
		}

		if ( array_key_exists( $target, $this->cookieJars ) ) {
			$req->setCookieJar( $this->cookieJars[$target] );
		}

		$status = $req->execute();

		if ( $status->isOK() ) {
			$response = $req->getContent();

			$this->getResult()->addValue(
				null,
				null,
				FormatJson::decode( $response )
			);

			Hooks::run( 'PushAPIAfterImagePush', [ $title, $target, $token, $response ] );
		} else {
			$this->dieUsage( wfMessage( 'push-special-err-push-failed' )->text(), 'page-push-failed' );
		}
	}

	public function getAllowedParams() {
		return [
			'images' => [
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
				// ApiBase::PARAM_REQUIRED => true,
			],
			'targets' => [
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
				// ApiBase::PARAM_REQUIRED => true,
			],
		];
	}

	/**
	 * @deprecated since MediaWiki core 1.25
	 */
	protected function getExamples() {
		return [
			'api.php?action=pushimages&images=File:Foo.bar&targets=http://en.wikipedia.org/w',
		];
	}

	/**
	 * @see ApiBase::getExamplesMessages()
	 */
	protected function getExamplesMessages() {
		return [
			'action=pushimages&images=File:Foo.bar&targets=http://en.wikipedia.org/w'
				=> 'apihelp-pushimages-example',
		];
	}
}

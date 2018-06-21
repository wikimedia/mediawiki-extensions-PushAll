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
class ApiPushImages extends ApiPushBase {

	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	public function doModuleExecute() {
		$params = $this->extractRequestParams();

		foreach ( $params['images'] as $image ) {
			$title = Title::newFromText( $image, NS_FILE );
			if ( !is_null( $title ) && $title->getNamespace() == NS_FILE && $title->exists() ) {
				$this->doPush( $title, $params['targets'] );
			}
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
			$req = MWHttpRequest::factory( $target, $reqArgs );
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
			'action=pushimages&images=File:Foo.bar&targets=http://en.wikipedia.org/w'
				=> 'apihelp-pushimages-example',
		];
	}
}

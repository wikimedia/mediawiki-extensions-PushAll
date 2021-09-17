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
use MediaWiki\Revision\RevisionRecord;

/**
 * Class ApiPushAll
 */
class ApiPushAll extends ApiPushAllBase {

	/**
	 * @var PushAllTargets List of targets
	 */
	private $targets;

	/**
	 * ApiPushAll constructor.
	 *
	 * @param ApiMain $main main parameter
	 * @param string $action action parameter
	 *
	 */
	public function __construct( $main, $action ) {
		parent::__construct( $main, $action );
	}

	protected function doModuleExecute() {
		$params = $this->extractRequestParams();
		$this->targets = PushAll::getTargets( $this->getUser() );
		foreach ( $params['targets'] as $targetName ) {
			if ( !$this->targets->exist( $targetName ) ) {
				$this->dieWithErrorCodeRemoteWiki( 'pushall-error-not-credentials-for-this-target', $targetName );
			}
		}
		$target = $this->targets->get( $params['target'] );
		$this->doRequestLoginToken( $target );
		$this->doRequestLogin( $target );
		$this->doRequestEditToken( $target );

		foreach ( $params['files'] as $pageTitle ) {
			$title = Title::newFromText( $pageTitle );
			if ( $title->exists() ) {
				$this->doRequestUpload( $target, $title );
			} else {
				$this->dieWithErrorCodeLocalWiki( 'pushall-error-title-not-exist', $pageTitle );
			}
		}

		foreach ( $params['titles'] as $pageTitle ) {
			$title = Title::newFromText( $pageTitle );
			if ( $title->exists() ) {
				$this->doRequestEdit( $target, $title );
			} else {
				$this->dieWithErrorCodeLocalWiki( 'pushall-error-title-not-exist', $pageTitle );
			}
		}

		$this->doRequestPurge( $target, implode( "|", $params['titles'] ) );
	}

	/**
	 * Pushes the page content to the specified wiki.
	 *
	 * @param PushAllTarget $target
	 * @param Title $title
	 */
	private function doRequestEdit( PushAllTarget $target, Title $title ) {
		global $wgSitename;
		$wikipage = WikiPage::factory( $title );
		$content = $wikipage->getContent( RevisionRecord::FOR_THIS_USER, $this->getUser() );
		if ( empty( $content ) ) {
			$this->dieWithErrorCodeLocalWiki( 'pushall-error-title-not-allow', $title->getPrefixedText() );
		}
		$summary = $this->msg(
			'pushall-import-revision-message',
			$wgSitename
		)->parse();
		$requestData = [
			'action' => 'edit',
			'title' => $title->getFullText(),
			'text' => $content->getText()  ,
			'format' => 'json',
			'summary' => $summary,
			'token' => $target->tokenEdit,
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
		} elseif ( property_exists( $response, 'error' ) && $response->error->code != 'protectedpage' ) {
			$this->dieWithErrorCodeRemoteWiki( $response->error->info, $target->name );
		}

		if ( property_exists( $response, 'edit' )
			&& property_exists( $response->edit, 'result' )
			&& $response->edit->result == 'Success'
		) {
			if ( property_exists( $response->edit, 'newrevid' )
				&& property_exists( $response->edit, 'newtimestamp' )
			) {
				PushAllTags::addTags(
					$wikipage->getLatest(),
					$target->name,
					$response->edit->newrevid,
					$response->edit->newtimestamp
				);
			} elseif ( property_exists( $response->edit, 'nochange' ) ) {
				$info = $this->getInfo( $target, $title );
				if ( !empty( $info ) ) {
					PushAllTags::addTags(
						$wikipage->getLatest(),
						$target->name,
						$info['lasterevid'],
						$info['touched']
					);
				}
			}
		}

		$pageName = $title->getPrefixedText();
		$revisions = PushAllContent::getRevisions( $pageName, $this->targets );
		$result = [];
		$result["revisions"] = $revisions;
		foreach ( $revisions as $key => $revision ) {
			$result["revisions"][$key]['timestamp'] = $this->getLanguage()->timeanddate( $revision['timestamp'] );
			foreach ( $revision['push'] as $targetName => $push ) {
				$result["revisions"][$key]['push'][$targetName]['timestamp'] =
					$this->getLanguage()->timeanddate( $push['timestamp'] );
			}
		}
		$this->getResult()->addValue(
			null,
			$pageName,
			$result
		);
	}

	/**
	 * Purge the page in the targeted wiki.
	 *
	 * @param PushAllTarget $target
	 * @param string $titles
	 */
	private function doRequestPurge( PushAllTarget $target, string $titles ) {
		$requestData = [
			'action' => 'purge',
			'titles' => $titles,
			'format' => 'json'
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
		} elseif ( property_exists( $response, 'error' ) && $response->error->code != 'protectedpage' ) {
			$this->dieWithErrorUnknown( $response->error->info, $target->name );
		}
	}

	/**
	 * Upload the file with this title in the remote wiki
	 *
	 * @param PushAllTarget $target
	 * @param Title $title
	 * @throws ApiUsageException
	 * @throws MWException
	 */
	private function doRequestUpload( PushAllTarget $target, Title $title ) {
		global $wgSitename;
		if ( !function_exists( 'curl_init' ) ) {
			$this->dieWithErrorCodeLocalWiki( 'pushall-error-api-nocurl' );
		} elseif (
			!defined( 'CurlHttpRequest::SUPPORTS_FILE_POSTS' )
			|| !CurlHttpRequest::SUPPORTS_FILE_POSTS
		) {
			$this->dieWithErrorCodeLocalWiki( 'pushall-error-api-nofilesupport' );
		}
		// TODO remove Http::$httpEngine = 'curl';
		// Http::$httpEngine is deprecated but it does not work without Curl
		// => Bug report : https://phabricator.wikimedia.org/T289237
		Http::$httpEngine = 'curl';

		$wikipage = WikiPage::factory( $title );
		$content = $wikipage->getContent( RevisionRecord::FOR_THIS_USER, $this->getUser() );
		if ( empty( $content ) ) {
			$this->dieWithErrorCodeLocalWiki( 'pushall-error-title-not-allow', $title->getPrefixedText() );
		}
		$summary = $this->msg(
			'pushall-import-revision-message',
			$wgSitename
		)->parse();

		$imagePage = new ImagePage( $title );
		$file = $imagePage->getFile();
		$be = $file->getRepo()->getBackend();
		$localFile = $be->getLocalReference(
			[ 'src' => $file->getPath() ]
		);

		$requestData = [
			'action' => 'upload',
			'format' => 'json',
			'token' => $target->tokenEdit,
			'filename' => $title->getFullText(),
			'comment' => $summary,
			'ignorewarnings' => '1',
			// $requestData['file'] = '@' . $localFile->getPath();
			'file' => new CurlFile( $localFile->getPath() )
		];

		$options = [
			'method' => 'POST',
			'timeout' => 'default',
			'postData' => $requestData
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
		} elseif (
			property_exists( $response, 'error' )
			&& isset( $response->code ) && $response->code != "fileexists-no-change"
		) {
			$this->dieWithErrorCodeRemoteWiki( $response->error->info, $target->name );
		}
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
				ApiBase::PARAM_REQUIRED => false,
			],
			'files' => [
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_REQUIRED => false,
			],
			'target' => [
				ApiBase::PARAM_TYPE => 'string',
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
			'action=pushall&titles=page1|page2&files=page1|page2&target=target1'
				=> 'apihelp-pushall-example',
		];
	}
}

<?php
/**
 * PushAllTarget describes a remote wiki and the credentials of current user.
 *
 * @file PushAllTarget.php
 * @ingroup PushAll
 *
 * @author Karima Rafes < karima.rafes@gmail.com >
 */

/**
 * Class PushAllTarget
 */
class PushAllTarget {

	/**
	 * Name of remote wiki
	 * @var string
	 */
	public $name;

	/**
	 * Id HTML of wiki in the targets list
	 * @var string
	 */
	public $id;

	/**
	 * Api endpoint of remote wiki
	 * @var string
	 */
	public $endpoint;

	/**
	 * Article path  of remote wiki
	 * @var string
	 */
	public $articlePath;

	/**
	 * Login of user's bot in the remote wiki
	 * @var string
	 */
	public $login;

	/**
	 * Key of user's bot in the remote wiki
	 * @var string
	 */
	public $key;

	/**
	 * Cookie of remote wiki
	 * @var string
	 */
	public $cookie = null;

	/**
	 * Login token of remote wiki
	 * @var string
	 */
	public $tokenLogin = null;

	/**
	 * Edit token of remote wiki
	 * @var string
	 */
	public $tokenEdit = null;

	/**
	 * Endpoint path
	 * @var string
	 */
	private $endpointPath;

	/**
	 * Endpoint domain
	 * @var string
	 */
	private $endpointDomain;

	/**
	 * Constructor.
	 *
	 * @param string $name
	 * @param string $endpoint
	 * @param string $articlePath
	 * @param string $login
	 * @param string $key
	 */
	public function __construct( string $name, string $endpoint, string $articlePath, string $login, string $key ) {
		$this->name = $name;
		$this->id = uniqid();
		$this->endpoint = $endpoint;

		$parts = parse_url( $endpoint );
		if ( $parts !== false ) {
			$this->endpointPath = $parts['path'];
			$this->endpointDomain = $parts['host'];
		}

		// todo: with PHP8
		// $this->articlePath = $articlePath . ( str_ends_with( $articlePath, '/' ) ? '' : '/' );
		$this->articlePath = $articlePath . ( self::endsWith( $articlePath, '/' ) ? '' : '/' );
		$this->login = $login;
		$this->key = $key;
	}

	/**
	 * This function replace temporary the future function str_ends_with in PHP8
	 *
	 * @param string $haystack
	 * @param string $needle
	 * @return bool
	 */
	private static function endsWith( $haystack, $needle ) {
		$length = strlen( $needle );
		if ( !$length ) {
			return true;
		}
		return substr( $haystack, -$length ) === $needle;
	}

	/**
	 * Read the host of the target
	 *
	 * @return string
	 */
	public function getEndpointHost() {
		return $this->endpointDomain;
	}

	/**
	 * Read the path of the target
	 *
	 * @return string
	 */
	public function getEndpointPath() {
		return $this->endpointPath;
	}
}

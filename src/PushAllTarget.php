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
		$this->articlePath = $articlePath . ( str_ends_with( $articlePath, '/' ) ? '' : '/' );
		$this->login = $login;
		$this->key = $key;
	}
}

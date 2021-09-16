<?php
/**
 * PushAllTargets describes the remote wikis in the preferences of current user
 *
 * @file PushAllTarget.php
 * @ingroup PushAll
 *
 * @author Karima Rafes < karima.rafes@gmail.com >
 */

/**
 * Class PushAllTargets
 */
class PushAllTargets {
	/**
	 * Array of PushAllTarget
	 * @var array
	 */
	private $targets;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->targets = [];
	}

	/**
	 * Serialize information of remote wikis for the module ext.pushall.js without the credentials of bot
	 *
	 * @return string
	 */
	public function serializeToJson() {
		$targets = [];
		foreach ( $this->targets as  $targetName => $target ) {
			$targets[$targetName] = [];
			$targets[$targetName]['name'] = $target->name;
			$targets[$targetName]['id'] = $target->id;
			$targets[$targetName]['articlePath'] = $target->articlePath;
		}
		return json_encode( $targets );
	}

	/**
	 * Number of remote wikis in the preferences
	 *
	 * @return int|void
	 */
	public function count() {
		return count( $this->targets );
	}

	/**
	 * Check if the name of wiki exists in the preferences.
	 *
	 * @param string $targetName
	 * @return bool
	 */
	public function exist( string $targetName ) {
		return array_key_exists( $targetName, $this->targets );
	}

	/**
	 * Get the remote wikis
	 *
	 * @return array
	 */
	public function getArray() {
		return $this->targets;
	}

	/**
	 * Get a remote wiki
	 *
	 * @param string $targetName
	 * @return mixed
	 */
	public function get( string $targetName ) {
		return $this->targets[$targetName];
	}

	/**
	 * Add a remote wiki
	 *
	 * @param string $targetName
	 * @param PushAllTarget $targetObj
	 */
	public function addTarget( string $targetName, PushAllTarget $targetObj ): void {
		$this->targets[$targetName] = $targetObj;
	}
}

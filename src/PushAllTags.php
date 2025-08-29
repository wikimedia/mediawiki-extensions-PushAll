<?php
/**
 * Each push in the local wiki let a tag in the revision of the pushed page.
 *
 * @file PushAllTags.php
 * @ingroup PushAll
 *
 * @author Karima Rafes < karima.rafes@gmail.com >
 */

use MediaWiki\MediaWikiServices;

/**
 * Class PushAllTags
 */
class PushAllTags {
	/**
	 * Tag for a push action
	 */
	public const TAG_PUSH = 'pushall-push';

	/**
	 * Save a push action in a revision of the pushed page.
	 *
	 * @param int $rev_id
	 * @param string $targetName
	 * @param int $targetNewrevid
	 * @param string $targetNewtimestamp
	 * @throws MWException
	 */
	public static function addTags( int $rev_id, string $targetName, int $targetNewrevid, string $targetNewtimestamp ) {
		// read old tag
		$precTag = self::getData( $rev_id, self::TAG_PUSH );
		// clean tag
		$changeTagStore = \MediaWiki\MediaWikiServices::getInstance()->getChangeTagsStore();
		$changeTagStore->updateTags( [], [ self::TAG_PUSH ], $rc_id, $rev_id );

		// clean prec data
		unset( $precTag[$targetName] );
		// create new data
		$newdata = $precTag + [
			$targetName => [
				'timestamp' => $targetNewtimestamp,
				'revid' => $targetNewrevid
			]
		];
		// Save
		$changeTagStore->addTags(
			self::TAG_PUSH,
			null,
			$rev_id,
			null,
			FormatJson::encode( $newdata )
		);

		// $postTag = self::getData( $rev_id, self::TAG_PUSH );
	}

	/**
	 * Read the data for a tag in a revision
	 *
	 * @param int $rev_id
	 * @param string $tag
	 * @return array|mixed
	 */
	private static function getData( int $rev_id, string $tag ) {
		$result = [];
		$db = MediaWikiServices::getInstance()->getDBLoadBalancer()->getConnection( DB_REPLICA );
		$resultDb = $db->select(
			[ 'change_tag', 'change_tag_def' ],
			[ 'ct_tag_id', 'ct_params' ],
			[
				'ct_rev_id' => $rev_id,
				'ctd_name' => $tag
			],
			__METHOD__,
			[ 'LIMIT' => 1 ],
			[
				'change_tag_def' => [
					'INNER JOIN',
					[ 'ctd_id = ct_tag_id' ]
				]
			]
		);

		$row = $resultDb->fetchObject();
		if ( $row ) {
			$result = FormatJson::decode( $row->ct_params, true );
		}
		return $result;
	}
}

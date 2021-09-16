<?php

use MediaWiki\Config\ServiceOptions;
use MediaWiki\MediaWikiServices;
use MediaWiki\User\UserIdentityValue;
use MediaWiki\User\UserOptionsManager;
use PHPUnit\Framework\Assert;
use Wikimedia\TestingAccessWrapper;

/**
 * @group PushAll
 * @covers PushAllComponents
 *
 * https://www.mediawiki.org/wiki/Manual:PHP_unit_testing/Writing_unit_tests_for_extensions
 */
class PushAllTest extends MediaWikiUnitTestCase {

	public static function sampleAttachedNamespaces()
	{
		return
			[
				0 => "Data",
				1 => "Discussion"
			];
	}

	public static function provideExportExtractedDataGlobals() {
		return
			[
				[
					'AttachedNamespaces',
					[
						'egPushAllAttachedNamespaces' => self::sampleAttachedNamespaces()
					],
					[
						'egPushAllAttachedNamespaces' => self::sampleAttachedNamespaces()
					]
				]
			];
	}

	private static function extractData($globals)
	{
		PushAll::clean();
		$registry = new ExtensionRegistry();
		$registry->queue( __DIR__ . "/../../../extension.json" );
		$registry->loadFromQueue();
		$info = [
			'globals' => $globals,
			'callbacks' => [],
			'defines' => [],
			'credits' => [],
			'attributes' => [],
			'autoloaderPaths' => []
		];
		TestingAccessWrapper::newFromObject( $registry )->exportExtractedData( $info );

	}

	/**
	 * @dataProvider provideExportExtractedDataGlobals
	 */
	public function testExportExtractedDataGlobals( $desc, $globals, $expected ) {
		self::extractData($globals);
		foreach ( $expected as $name => $value ) {
			$this->assertArrayHasKey( $name, $GLOBALS, $desc );
			$this->assertEquals( $value, $GLOBALS[$name], $desc );
		}
	}
}

/* eslint-env node */
module.exports = function ( grunt ) {
	// const conf = grunt.file.readJSON( 'extension.json' );

	grunt.loadNpmTasks( 'grunt-banana-checker' );
	grunt.loadNpmTasks( 'grunt-eslint' );
	grunt.loadNpmTasks( 'grunt-stylelint' );
	grunt.loadNpmTasks( 'grunt-jsonlint' );

	grunt.initConfig( {
		eslint: {
			options: {
				cache: true
			},
			all: '.'
		},
		stylelint: {
			all: [
				'**/*.{css,less}',
				'!**/coverage/**',
				'!node_modules/**',
				'!vendor/**'
			]
		},
		banana: {
			all: {
				files: {
					src: 'i18n'
				},
				options: {
					requireCompleteTranslationLanguages: [
						'en',
						'fr'
					]
				}
			}
		},
		jsonlint: {
			all: [
				'**/*.json',
				'!node_modules/**',
				'!vendor/**'
			]
		}
	} );

	grunt.registerTask( 'test', [ 'eslint', 'stylelint', 'banana', 'jsonlint' ] );
	grunt.registerTask( 'default', 'test' );
};

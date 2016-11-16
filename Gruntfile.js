module.exports = function ( grunt ) {
	// Auto-load the needed grunt tasks
	// require('load-grunt-tasks')(grunt);
	require( 'load-grunt-tasks' )( grunt, { pattern: ['grunt-*'] } );

	// configuration
	grunt.initConfig( {
		pgk: grunt.file.readJSON( 'package.json' ),

		// https://www.npmjs.com/package/grunt-wp-i18n
		addtextdomain: {
			options: {
				updateDomains: true
			},
			target: {
				files: {
					src: [
						'*.php',
						'inc/**/*.php',
						'vendor/freemius/wordpress-sdk/**/*.php',
						'template-parts/*.php',
					]
				}
			}
		},

	} );

	grunt.registerTask( 'default', [
		'addtextdomain',
	] );
};
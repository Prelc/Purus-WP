// config
require.config( {
	paths: {
		jquery:     'assets/js/fix.jquery',
		util:       'bower_components/bootstrap/dist/js/umd/util',
		alert:      'bower_components/bootstrap/dist/js/umd/alert',
		button:     'bower_components/bootstrap/dist/js/umd/button',
		carousel:   'bower_components/bootstrap/dist/js/umd/carousel',
		collapse:   'bower_components/bootstrap/dist/js/umd/collapse',
		dropdown:   'bower_components/bootstrap/dist/js/umd/dropdown',
		modal:      'bower_components/bootstrap/dist/js/umd/modal',
		scrollspy:  'bower_components/bootstrap/dist/js/umd/scrollspy',
		tab:        'bower_components/bootstrap/dist/js/umd/tab',
		tooltip:    'bower_components/bootstrap/dist/js/umd/tooltip',
		popover:    'bower_components/bootstrap/dist/js/umd/popover',
	},
} );

require.config( {
	baseUrl: PurusVars.pathToTheme
} );

require( [
	'jquery',
	'collapse',
	'dropdown',
], function ( $, _ ) {
	'use strict';

} );

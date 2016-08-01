/* global require */
//|**
//|
//| gulp require
//|
//| This file is the main application file
//|
//| .--------------------------------------------------------------.
//| | NAMING CONVENTIONS:                                          |
//| |--------------------------------------------------------------|
//| | Singleton-literals and prototype objects | PascalCase        |
//| |--------------------------------------------------------------|
//| | Functions and public variables           | camelCase         |
//| |--------------------------------------------------------------|
//| | Global variables and constants           | UPPERCASE         |
//| |--------------------------------------------------------------|
//| | Private variables                        | _underscorePrefix |
//| '--------------------------------------------------------------'
//|
//| Comment syntax for the entire project follows JSDoc:
//| - http://code.google.com/p/jsdoc-toolkit/wiki/TagReference
//|
//'*/
//require.config({
var require = {
	//deps: ['application'],
	waitSeconds: 45,
	paths: {
		requirejs: '../../vendor/requirejs/require',
		sizzle: '../../vendor/sizzle/dist/sizzle',
		handlebars: '../../vendor/handlebars/handlebars',
		Templates: '../../application/templates/templates',
	//	zepto: 'vendor/zepto/zepto',
		swipe: '../../vendor/Swipe/swipe',
		mockjs: '../../vendor/mockjs/dist/mock',
	},
	shim: {
		Templates: {
			exports: 'Templates'
		},
	/*	zepto: {
			exports: '$'
		},*/
		swipe:{
			exports: 'Swipe'
		}
	}
};
//});

'use strict';

var path = require('path');
var gulp = require('gulp');
var conf = require('./conf');

var $ = require('gulp-load-plugins')();

var _ = conf.paths;

//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//| ✓ html
//'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
gulp.task('html', /*["styles-build", "scripts-build"], */function() {

    var useref = require('gulp-useref');
    var assets = useref.assets();

    var js = $.filter('**/*.js', {restore:true}), css = $.filter('**/*.css',{restore:true});
    gulp.src(_.app + '/*.txt').pipe(gulp.dest(_.dist));
    return gulp.src([_.dist + '/*.html',
            _.dist + '/scripts/*.json',
        '!' + _.app + '/demo.html'])
        .pipe($.plumber())
        /*.pipe(assets)
        .pipe(js)
        .pipe($.uglify())
        .pipe(js.restore)
        .pipe(css)
        .pipe($.cssnano())
        .pipe(css.restore)
        .pipe(assets.restore())
        .pipe(useref())
        .pipe(gulp.dest(_.dist))
        .pipe($.size())
        .pipe($.notify({
            message: '<%= options.date %> ✓ html: <%= file.relative %>',
            templateOptions: {
                date: new Date()
            }
        }));*/
        .pipe($.htmlReplace({
            css: {
                src: './styles',
                tpl: '<link rel="stylesheet" type="text/css" href="%s/theme.css">'
            },
            js: {
                src: './scripts',
                tpl: '<script src="./scripts/vendor/require.js"></script>'+ '\n' +
                '<script src="%s/%f.js"></script>'
            }
        }))
        .pipe($.revCollector({
            replaceReved: true,
            dirReplacements: {
                // 'css': '/dist/css',
                '/scripts/': '/scripts/',
                'cdn/': function(manifest_value) {
                    return '//cdn' + (Math.floor(Math.random() * 9) + 1) + '.' + 'exsample.dot' + '/img/' + manifest_value;
                }
            }
        }) )
        .pipe(gulp.dest(_.dist+"/test"))
        .pipe($.size())
        /*.pipe($.notify({
            message: '<%= options.date %> ✓ html: <%= file.relative %>',
            templateOptions: {
                date: new Date()
            }
        }))*/;
});


//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//| ✓ alias
//'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
gulp.task('test', ['jsonlint', 'coffeelint', 'jshint', 'mocha']);
gulp.task('build', [ 'html', 'images', 'svg']);


//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//| ✓ default
//'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
gulp.task('default', ['clean'], function() {
    gulp.start('build');
});
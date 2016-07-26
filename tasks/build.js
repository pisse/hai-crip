'use strict';

var path = require('path');
var gulp = require('gulp');
var conf = require('./conf');

var _ = conf.paths;

//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//| ✓ html
//'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
gulp.task('html', ['styles', 'scripts'], function() {
    var js = $.filter('**/*.js'), css = $.filter('**/*.css');
    gulp.src(_.app + '/*.txt').pipe(gulp.dest(_.dist));
    return gulp.src([_.app + '/*.html']).pipe($.plumber())
        .pipe($.useref.assets())
        .pipe(js)
        .pipe($.uglify())
        .pipe(js.restore())
        .pipe(css)
        .pipe($.csso())
        .pipe(css.restore())
        .pipe($.useref.restore())
        .pipe($.useref())
        .pipe(gulp.dest(_.dist))
        .pipe($.size())
        .pipe($.notify({
            message: '<%= options.date %> ✓ html: <%= file.relative %>',
            templateOptions: {
                date: new Date()
            }
        }));
});


//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//| ✓ alias
//'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
gulp.task('test', ['jsonlint', 'coffeelint', 'jshint', 'mocha']);
gulp.task('build', ['test', 'html', 'images', 'svg']);


//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//| ✓ default
//'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
gulp.task('default', ['clean'], function() {
    gulp.start('build');
});
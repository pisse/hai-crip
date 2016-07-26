'use strict';

var path = require('path');
var gulp = require('gulp');
var conf = require('./conf');

var browserSync = require('browser-sync');

var $ = require('gulp-load-plugins')();

var wiredep = require('wiredep').stream;
var _ = conf.paths;


//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//| ✓ jsonlint
//'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
gulp.task('jsonlint', function() {
    return gulp.src([
            'package.json',
            'bower.json',
            '.bowerrc',
            '.jshintrc',
            '.jscs.json'
        ])
        .pipe($.plumber())
        .pipe($.jsonlint()).pipe($.jsonlint.reporter())
        .pipe($.notify({
            message: '<%= options.date %> ✓ jsonlint: <%= file.relative %>',
            templateOptions: {
                date: new Date()
            }
        }));
});

//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//| ✓ coffeelint
//'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
gulp.task('coffeelint', function() {
    return gulp.src([
            _.app + '/scripts/**/*.coffee',
            '!' + _.app + '/scripts/vendor/**/*.coffee'
        ])
        .pipe($.plumber())
        .pipe($.coffeelint())
        .pipe($.coffeelint.reporter())
        .pipe($.notify({
            message: '<%= options.date %> ✓ coffeelint: <%= file.relative %>',
            templateOptions: {
                date: new Date()
            }
        }));
});

//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//| ✓ jshint
//'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
gulp.task('jshint', function() {
    return gulp.src([
            'gulpfile.js',
            _.app + '/scripts/**/*.js',
            '!' + _.app + '/scripts/vendor/**/*.js',
            'test/spec/{,*/}*.js'
        ])
        .pipe($.plumber())
        .pipe($.jshint('.jshintrc')).pipe($.jshint.reporter('default'))
        .pipe($.jscs())
        .pipe($.notify({
            message: '<%= options.date %> ✓ jshint: <%= file.relative %>',
            templateOptions: {
                date: new Date()
            }
        }));
});


//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//| ✓ coffee
//'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
gulp.task('coffees', ['coffeelint'], function() {
    return gulp.src([
            _.app + '/scripts/**/*.coffee',
            '!' + _.app + '/scripts/vendor/**/*.coffee'
        ])
        .pipe($.plumber())
        .pipe($.coffee({ bare: true }).on('error', $.util.log))
        .pipe(gulp.dest(_.app + '/scripts'))
        .pipe($.size()).pipe($.notify({
            message: '<%= options.date %> ✓ scripts: <%= file.relative %>',
            templateOptions: {
                date: new Date()
            }
        }));
});

//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//| ✓ requirejs
//'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
gulp.task('requirejs', /*['coffees', 'jshint'],*/ function() {
  $.requirejs({
        baseUrl: _.app + '/scripts',
        optimize: 'none',
        include: ['requirejs', 'config'],
        mainConfigFile: _.app + '/scripts/config.js',
        //out: 'body.js',
        preserveLicenseComments: true,
        useStrict: true,
        wrap: true
      })
      .pipe($.plumber()).pipe(gulp.dest(_.dist + '/scripts')).pipe($.size())
      .pipe($.notify({
        message: '<%= options.date %> ✓ requirejs: <%= file.relative %>',
        templateOptions: {
          date: new Date()
        }
      }));
});

//|**~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
//| ✓ scripts
//'~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
gulp.task('scripts', ['requirejs'], function() {
  return gulp.src([
    _.app + '/scripts/**/*.js',
    '!' + _.app + '/scripts/vendor/**/*.js'
  ]).pipe($.plumber()).pipe($.size()).pipe($.notify({
    message: '<%= options.date %> ✓ scripts: <%= file.relative %>',
    templateOptions: {
      date: new Date()
    }
  }));
});
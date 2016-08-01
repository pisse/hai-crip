'use strict';

var path = require('path');
var gulp = require('gulp');
var conf = require('./conf');

var browserSync = require('browser-sync');

var $ = require('gulp-load-plugins')();

var wiredep = require('wiredep').stream;
var _ = require('lodash');

gulp.task('styles-reload', ['styles'], function() {
  return buildStyles()
    .pipe(browserSync.stream());
});

gulp.task('styles', ['inject-pages'], function() {
  return buildStyles();
});

gulp.task('styles-build', ['inject-pages'], function() {
    return buildStyles(1);
});

gulp.task('inject-pages', function(){

  var injectFiles = gulp.src([
    path.join(conf.paths.src, '/styles/pages/*.scss')
  ], { read: false });

  var injectOptions = {
    transform: function(filePath) {
      filePath = filePath.replace(conf.paths.src + '/styles/', './');
      return '@import "' + filePath + '";';
    },
    starttag: '// injector',
    endtag: '// endinjector',
    addRootSlash: false
  };

  return gulp.src([
        path.join(conf.paths.src, '/styles/pages.scss')
      ])
      .pipe($.inject(injectFiles, injectOptions))
      .pipe(gulp.dest(path.join(conf.paths.src, '/styles/')));
});

var buildStyles = function(isBuild) {
  var sassOptions = {
    outputStyle: 'expanded',
    precision: 10
  };

/*  return gulp.src([
    path.join(conf.paths.src, '/app/index.scss')
  ])
    .pipe($.inject(injectFiles, injectOptions))
    .pipe(wiredep(_.extend({}, conf.wiredep)))
    .pipe($.sourcemaps.init())
    .pipe($.sass(sassOptions)).on('error', conf.errorHandler('Sass'))
    .pipe($.autoprefixer()).on('error', conf.errorHandler('Autoprefixer'))
    .pipe($.sourcemaps.write())
    .pipe(gulp.dest(path.join(conf.paths.tmp, '/serve/app/')));*/

    if(!isBuild){

      return gulp.src(conf.paths.src + '/styles/theme.scss')
          .pipe(wiredep(_.extend({}, conf.wiredep)))

          .pipe($.sourcemaps.init())
          .pipe($.sass(sassOptions).on('error', $.util.log))
          .pipe($.plumber())
          //.pipe($.autoprefixer())
          //.pipe($.cssnano())
          .pipe($.sourcemaps.write())
          .pipe(gulp.dest(conf.paths.app + '/styles'))
          .pipe($.size())
          .pipe($.notify({
            message: '<%= options.date %> ✓ styles: <%= file.relative %>',
            templateOptions: {
              date: new Date()
            }
          }));
    } else {
        return gulp.src(conf.paths.src + '/styles/theme.scss')
            .pipe(wiredep(_.extend({}, conf.wiredep)))

            .pipe($.sass(sassOptions).on('error', $.util.log))
            .pipe($.plumber())
            //.pipe($.autoprefixer())
            .pipe($.cssnano())
            .pipe(gulp.dest(conf.paths.dist + '/styles'))
            .pipe($.size())
            .pipe($.notify({
                message: '<%= options.date %> ✓ styles: <%= file.relative %>',
                templateOptions: {
                    date: new Date()
                }
            }));

    }

};

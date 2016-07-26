'use strict';

var path = require('path');
var gulp = require('gulp');
var conf = require('./conf');


var $ = require('gulp-load-plugins')();

var _ = conf.paths;

var browserSync = require('browser-sync');

gulp.task('watch', ["serve"], function() {
  // Watch for changes in `app` dir
  $.watch( [
    _.app + '/*.{html,txt}',
    _.app + '/styles/**/*.{sass,scss,css}',
    _.app + '/scripts/**/*.js',
    _.app + '/images/**/*.{png,jpg,jpeg,gif,ico}',
    '!' + _.app + '/scripts/vendor/**/*.js'
  ] , function(files,event) {
    //return files.pipe($.plumber()).pipe($.connect.reload());
    browserSync.reload();
  });

  // Watch style files
  $.watch([_.app + '/styles/**/*.{sass,scss}', '!' + _.app +  '/styles/pages.scss'], function() {
    gulp.start('styles');
  });

  // Watch script files
  $.watch( [_.app + '/scripts/**/*.js', '!' + _.app + '/scripts/vendor/**/*.js'] , function() {
    gulp.start('scripts');
  });

  // Watch image files
  $.watch([_.app + '/images/**/*.{png,jpg,jpeg,gif,ico}'] , function() {
    gulp.start('images');
  });

  // Watch bower files
  $.watch('bower.json', function() {
    gulp.start('wiredep');
  });

  //Wathch hbs files
  $.watch(_.app + '/scripts/**/*.hbs', function(){
    gulp.start('templates');
  });


});

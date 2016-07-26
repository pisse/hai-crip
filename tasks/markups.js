'use strict';

var path = require('path');
var gulp = require('gulp');
var conf = require('./conf');

var browserSync = require('browser-sync');
var $ = require('gulp-load-plugins')();

gulp.task('markups', function() {
  /*function renameToHtml(path) {
    path.extname = '.html';
  }*/

  return gulp.src(path.join(conf.paths.src, '/scripts/**/*.hbs'))
    .pipe($.consolidate('handlebars')).on('error', conf.errorHandler('Handlebars'))
    .pipe($.rename(renameToHtml))
    .pipe(gulp.dest(path.join(conf.paths.src, '/scripts/application/views/')))
    .pipe(browserSync.stream());

});

gulp.task('templates', function(){
  gulp.src( path.join(conf.paths.src, '/scripts/**/*.hbs') )
      .pipe($.handlebars())
      .pipe($.wrap('Handlebars.template(<%= contents %>)'))
      .pipe($.declare({
        namespace: 'Templates',
        noRedeclare: true, // Avoid duplicate declarations
      }))
      .pipe($.concat('templates.js'))
      //.pipe($.emberEmblem())
      //.pipe($.defineModule('amd'))
      .pipe($.wrap('define(["handlebars"],function(Handlebars){<%= contents %> return this.Templates;})'))
      .pipe(gulp.dest( path.join(conf.paths.src, 'scripts/application/templates/') ));
});

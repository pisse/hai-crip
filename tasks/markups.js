'use strict';

var path = require('path');
var gulp = require('gulp');
var conf = require('./conf');
var fs = require('fs');

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

    var tplpath = conf.paths.src + '/scripts/application/templates';
    var tplList = fs.readdirSync(tplpath);

    var Prefix = "Tpl_";

    tplList.forEach(function (page){

        var curpagePath = tplpath + "/" + page;
        var states = fs.statSync(curpagePath);

        if (states.isDirectory() === true) {
            //console.log(curpagePath)

            var fileName = Prefix + page;
            gulp.src( path.join( curpagePath + '/**/*.hbs') )
                .pipe($.handlebars())
                .pipe($.wrap('Handlebars.template(<%= contents %>)'))
                .pipe($.declare({
                    namespace: fileName,
                    noRedeclare: true, // Avoid duplicate declarations
                }))
                .pipe($.concat( fileName + '.js'))
                //.pipe($.emberEmblem())
                //.pipe($.defineModule('amd'))
                .pipe($.wrap('define(["handlebars"],function(Handlebars){<%= contents %> return this.'+ fileName + ';})'))
                .pipe(gulp.dest( path.join(conf.paths.src, 'scripts/application/templates/') ));
        }
    });

});

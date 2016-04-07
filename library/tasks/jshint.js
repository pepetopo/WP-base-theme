var gulp = require('gulp');
var notify = require("gulp-notify");
var plumber = require('gulp-plumber');
var jshint = require('gulp-jshint');
var config = require('./config');

gulp.task('jshint', function () {
  return gulp.src(config.paths.source + '/js/main/**/*.js')
    .pipe(plumber({errorHandler: notify.onError(config.errorMsg)}))
    .pipe(jshint())
    .pipe(jshint.reporter('jshint-stylish'))
    .pipe(jshint.reporter('fail'));
});

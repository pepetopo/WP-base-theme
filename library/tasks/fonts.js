var gulp = require('gulp');
var notify = require("gulp-notify");
var plumber = require('gulp-plumber');
var config = require('./config');

gulp.task('fonts', function () {
  gulp.src([
    config.paths.source + '/bower_components/font-awesome/fonts/**.*'
  ])
    .pipe(plumber({errorHandler: notify.onError(config.errorMsg)}))
    .pipe(gulp.dest(config.paths.build + '/fonts'));
});
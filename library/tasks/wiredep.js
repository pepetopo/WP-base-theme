var gulp = require('gulp');
var gutil = require('gulp-util');
var changed = require('gulp-changed');
var config = require('./config');
var wiredep = require('wiredep').stream;

gulp.task('wiredep', function () {
  return gulp.src(config.paths.source + '/styles/main.scss')
    .pipe(wiredep())
    .pipe(changed(config.paths.source + '/styles', {
      hasChanged: changed.compareSha1Digest
    }))
    .pipe(gulp.dest(config.paths.source + '/styles'));
});
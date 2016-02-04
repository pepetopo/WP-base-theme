var gulp = require('gulp');
var gulpif = require('gulp-if');
var notify = require("gulp-notify");
var argv = require('minimist')(process.argv.slice(2));
var plumber = require('gulp-plumber');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var jshint = require('gulp-jshint');
var sourcemaps = require('gulp-sourcemaps');
var config = require('./config');

gulp.task('scripts', ['jshint'], function () {
  return gulp.src(config.paths.source + '/scripts/main/**/*.js')
    .pipe(plumber({errorHandler: notify.onError(config.errorMsg)}))
    .pipe(gulpif(!argv.production, sourcemaps.init()))
    .pipe(concat('main.min.js'))
    .pipe(uglify())
    .pipe(gulpif(!argv.production, sourcemaps.write('.')))
    .pipe(gulp.dest(config.paths.build + '/scripts'));
});

var gulp = require('gulp');
var gulpif = require('gulp-if');
var notify = require("gulp-notify");
var rename = require('gulp-rename');
var argv = require('minimist')(process.argv.slice(2));
var cssnano = require('gulp-cssnano');
var autoprefixer = require('gulp-autoprefixer');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var plumber = require('gulp-plumber');
var pixrem = require('gulp-pixrem');
var config = require('./config');

gulp.task('styles', function () {
  return gulp.src(config.paths.source + '/styles/main.scss')
    .pipe(plumber({errorHandler: notify.onError(config.errorMsg)}))
    .pipe(rename('main.min.css'))
    .pipe(gulpif(!argv.production, sourcemaps.init()))
    .pipe(sass({
      outputStyle: 'expanded',
      precision: 5,
      includePaths: ['.'],
      errLogToConsole: true
    }).on('error', sass.logError))
    .pipe(cssnano({
      advanced: false,
      rebase: false,
      keepSpecialComments: false
    }))
    .pipe(autoprefixer({
      browsers: [
        'last 2 versions',
        'ie 8',
        'ie 9',
        'android 2.3',
        'android 4',
        'opera 12'
      ]
    }))
    .pipe(pixrem())
    .pipe(gulpif(!argv.production, sourcemaps.write('.')))
    .pipe(gulp.dest(config.paths.build + '/styles'));
});

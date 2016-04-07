var gulp = require('gulp');
var gulpif = require('gulp-if');
var notify = require("gulp-notify");
var glob = require('glob');
var cssnano = require('gulp-cssnano');
var sourcemaps = require('gulp-sourcemaps');
var argv = require('minimist')(process.argv.slice(2));
var sass = require('gulp-sass');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var mainBowerFiles = require('main-bower-files');
var fs = require('fs');
var plumber = require('gulp-plumber');
var config = require('./config');

gulp.task('startup', ['clean', 'wiredep', 'imagemin'], function () {

  /**
   * Editor-style
   */
  gulp.src(config.paths.source + '/styles/editor-style.scss')
    .pipe(plumber({errorHandler: notify.onError(config.errorMsg)}))
    .pipe(sass().on('error', sass.logError))
    .pipe(cssnano(), {
      advanced: false,
      rebase: false
    })
    .pipe(gulp.dest('./'));

  /**
   * Backend styles
   */
  gulp.src(config.paths.source + '/admin/backend.scss')
    .pipe(plumber({errorHandler: notify.onError(config.errorMsg)}))
    .pipe(sass().on('error', sass.logError))
    .pipe(cssnano(), {
      advanced: false,
      rebase: false
    })
    .pipe(gulp.dest(config.paths.build + '/styles'));

  /**
   * Backend scripts
   */
  gulp.src(config.paths.source + '/admin/backend.js')
    .pipe(plumber({errorHandler: notify.onError(config.errorMsg)}))
    .pipe(plumber())
    .pipe(concat('backend.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest(config.paths.build + '/js'));

  /**
   * Inject banner to style.css
   */
  fs.writeFile('./style.css', config.themeHeader.join('\n'));

  /**
   * Vendor-scripts
   */
  var vendorFiles = mainBowerFiles({filter: /.*\.js/});

  gulp.src(vendorFiles.concat(glob.sync(config.paths.source + '/js/vendor/**/*.js')))
    .pipe(plumber({errorHandler: notify.onError(config.errorMsg)}))
    .pipe(gulpif(!argv.production, sourcemaps.init()))
    .pipe(concat('vendor.min.js'))
    .pipe(uglify())
    .pipe(gulpif(!argv.production, sourcemaps.write('.')))
    .pipe(gulp.dest(config.paths.build + '/js'));
});

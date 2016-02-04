var gulp = require('gulp');
var browserSync = require('browser-sync');
var imagemin = require('gulp-imagemin');
var config = require('./config');

gulp.task('imagemin', function () {
  return gulp.src(config.paths.source + '/images/**/*.{jpg,jpeg,png,gif,svg,ico}')
    .pipe(imagemin({
      progressive: true,
      interlaced: true,
      svgoPlugins: [{removeUnknownsAndDefaults: false}, {cleanupIDs: false}]
    }))
    .pipe(gulp.dest(config.paths.build + '/images'))
    .pipe(browserSync.stream());
});

var gulp = require('gulp');

gulp.task('build', [
  'startup',
  'fonts',
  'styles',
  'scripts'
]);

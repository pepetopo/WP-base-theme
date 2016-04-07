var gulp = require('gulp');
var browserSync = require('browser-sync');
var config = require('./config');

gulp.task('server', function () {
  browserSync.init({
    files: ['{library,partials,templates}/**/*.php', '*.php'],
    online: true,
    open: false,
    proxy: config.devUrl,
    snippetOptions: {
      whitelist: ['/wp-admin/admin-ajax.php'],
      blacklist: ['/wp-admin/**']
    },
    reloadDelay: 500
  });

  gulp.watch(config.paths.source + '/styles/**/*', ['styles']).on('change', browserSync.reload);
  gulp.watch(config.paths.source + '/js/**/*', ['jshint', 'scripts']).on('change', browserSync.reload);
  gulp.watch(config.paths.source + '/images/**/*', ['imagemin']).on('change', browserSync.reload);

});

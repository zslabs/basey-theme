module.exports = function(gulp, $, browserSync, reload, merge, paths, files) {
  return function() {
    gulp.src(paths.svg.src)
    .pipe($.imagemin())
    .pipe(gulp.dest(paths.svg.build));
  };
};
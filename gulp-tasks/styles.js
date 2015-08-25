module.exports = function(gulp, $, browserSync, reload, merge, paths, files) {
  return function() {
    gulp.src('assets/css/src/app.less')
    .pipe($.changed(paths.styles.build))
    .pipe($.plumber({
      handleError: function(err) {
        console.log(err);
        this.emit('end');
      }
    }))
    .pipe($.sourcemaps.init())
    .pipe($.less())
    .pipe($.autoprefixer({
      browsers: ['last 2 versions', 'ie 9']
    }))
    .pipe($.minifyCss({
      'advanced': false
    }))
    .pipe($.sourcemaps.write('../sourcemaps'))
    .pipe($.plumber.stop())
    .pipe($.size({
      showFiles: true,
      title: 'Styles:'
    }))
    .pipe(gulp.dest(paths.styles.build))
    .pipe(reload({
      stream: true
    }))
    .pipe($.duration('building styles'));
  };
};
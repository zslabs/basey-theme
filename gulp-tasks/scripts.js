module.exports = function(gulp, $, browserSync, reload, merge, paths, files) {
  return function() {
    // Deps
    var deps = gulp.src(files.deps)
    .pipe($.changed(paths.scripts.build))
    .pipe($.sourcemaps.init())
    .pipe($.concat('deps.js'))
    .pipe($.uglify())
    .pipe($.sourcemaps.write('../sourcemaps'))
    .pipe($.size({
      showFiles: true,
      title: 'Dependencies:'
    }))
    .pipe(gulp.dest(paths.scripts.build));

    // App
    var app = gulp.src(files.app)
    .pipe($.changed(paths.scripts.build))
    .pipe($.sourcemaps.init())
    .pipe($.jshint({
      "esnext": true
    }))
    .pipe($.jshint.reporter('jshint-stylish'))
    .pipe($.concat('app.js'))
    .pipe($.babel())
    .pipe($.uglify())
    .pipe($.sourcemaps.write('../sourcemaps'))
    .pipe($.size({
      showFiles: true,
      title: 'App:'
    }))
    .pipe(gulp.dest(paths.scripts.build));

    return merge(deps, app);
  };
};
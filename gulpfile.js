// Load plugins
var gulp = require('gulp'),
    Combine = require('stream-combiner'),
    path = require('path'),
    jshint = require('gulp-jshint'),
    imagemin = require('gulp-imagemin'),
    csso = require('gulp-csso'),
    less = require('gulp-less'),
    autoprefixer = require('gulp-autoprefixer'),
    uglify = require('gulp-uglify'),
    notify = require('gulp-notify'),
    newer = require('gulp-newer'),
    size = require('gulp-size'),
    concat = require('gulp-concat'),
    rename = require('gulp-rename'),
    filesize = require('gulp-size'),
    livereload = require('gulp-livereload'),
    duration = require('gulp-duration'),
    pixrem = require('gulp-pixrem');

// JS Hint
gulp.task('jshint', function() {
  gulp.src('assets/js/src/*.js')
    .pipe(jshint({
      'boss': true,
      'sub': true,
      'evil': true,
      'browser': true,
      'globals': {
        'module': false,
        'require': true
      }
    }))
    .pipe(jshint.reporter('jshint-stylish'))
    .pipe(duration('hinting files'))
    .pipe(notify({ message: 'JS Hint task complete' }));
});

// Copy
gulp.task('copy', function() {
  // UIkit fonts
  gulp.src('bower_components/uikit/dist/fonts/*')
    .pipe(gulp.dest('assets/fonts/'));
});

// Scripts
gulp.task('scripts', function() {
  var jsBuildDir = 'assets/js/build/';

  // IE
  gulp.src([
      'bower_components/selectivizr/selectivizr.js',
      'bower_components/respond/dest/respond.min.js',
      'assets/js/src/vendor/ecmascript-polyfill.js',
      'assets/js/src/vendor/forEach-polyfill.js',
    ])
    .pipe(concat('ie.min.js'))
    .pipe(uglify())
    .pipe(filesize({
      title: 'IE Scripts:'
    }))
    .pipe(gulp.dest(jsBuildDir))
    .pipe(notify({ message: 'IE scripts task complete' }));

  // Main
  gulp.src([
      // UI Kit
      "bower_components/uikit/src/js/core.js",
      "bower_components/uikit/src/js/component.js",
      "bower_components/uikit/src/js/utility.js",
      "bower_components/uikit/src/js/touch.js",
      "bower_components/uikit/src/js/alert.js",
      "bower_components/uikit/src/js/button.js",
      "bower_components/uikit/src/js/dropdown.js",
      "bower_components/uikit/src/js/grid.js",
      "bower_components/uikit/src/js/modal.js",
      "bower_components/uikit/src/js/offcanvas.js",
      "bower_components/uikit/src/js/nav.js",
      "bower_components/uikit/src/js/tooltip.js",
      "bower_components/uikit/src/js/switcher.js",
      "bower_components/uikit/src/js/tab.js",
      "bower_components/uikit/src/js/scrollspy.js",
      "bower_components/uikit/src/js/smooth-scroll.js",
      "bower_components/uikit/src/js/toggle.js",

      // UI Kit Add-ons
      "bower_components/uikit/src/js/addons/autocomplete.js",
      "bower_components/uikit/src/js/addons/cover.js",
      "bower_components/uikit/src/js/addons/datepicker.js",
      "bower_components/uikit/src/js/addons/form-password.js",
      "bower_components/uikit/src/js/addons/form-select.js",
      "bower_components/uikit/src/js/addons/htmleditor.js",
      "bower_components/uikit/src/js/addons/nestable.js",
      "bower_components/uikit/src/js/addons/notify.js",
      "bower_components/uikit/src/js/addons/pagination.js",
      "bower_components/uikit/src/js/addons/search.js",
      "bower_components/uikit/src/js/addons/sortable.js",
      "bower_components/uikit/src/js/addons/sticky.js",
      "bower_components/uikit/src/js/addons/timepicker.js",
      "bower_components/uikit/src/js/addons/upload.js",

      // Vendor
      "bower_components/fastclick/lib/fastclick.js",
      "bower_components/jquery-placeholder/jquery.placeholder.js",
      "bower_components/parsleyjs/dist/parsley.js",

      // Project
      'assets/js/src/_init.js'
    ])
    .pipe(concat('scripts.min.js'))
    .pipe(uglify())
    .pipe(filesize({
      title: 'Main Scripts:'
    }))
    .pipe(gulp.dest(jsBuildDir))
    .pipe(duration('building main JS files'))
    .pipe(notify({ message: 'Main scripts task complete' }));
});

// Styles
gulp.task('styles', function() {
  var combined = Combine(
      gulp.src('assets/css/src/app.less'),
      less(),
      autoprefixer('last 2 version', 'ie 9'),
      csso(),
      pixrem('14px', {
        replace: true
      }),
      filesize({
        title: 'Styles:'
      }),
      gulp.dest('assets/css/build/'),
      duration('building styles'),
      notify({ message: 'Styles task complete' })
    );

    combined.on('error', function(err) {
      console.warn(err.message);
    });

    return combined;
});

// Media
gulp.task('media', function() {
	var mediaDir = 'assets/media/';

  gulp.src(mediaDir + '**/*')
    .pipe(newer(mediaDir))
    .pipe(imagemin())
    .pipe(filesize({
      title: 'Media File:'
    }))
    .pipe(gulp.dest(mediaDir))
    .pipe(duration('compressing media'))
    .pipe(notify({ message: 'Media task complete' }));
});

// Default task
gulp.task('default', ['copy', 'styles', 'jshint', 'scripts', 'media']);

// Watch
gulp.task('watch', function() {

  // Sass
  gulp.watch('assets/css/src/**/*.less', ['styles']);

  // JS
  gulp.watch('assets/js/src/**/*.js', ['jshint', 'scripts']);

  // Media
  gulp.watch('assets/media/**/*', ['media']);

  // Create LiveReload server
  var server = livereload();

  // Watch files in patterns below, reload on change
  gulp.watch(['assets/css/build/*', 'assets/js/build/*', '*.php']).on('change', function(file) {
    server.changed(file.path);
  });

});
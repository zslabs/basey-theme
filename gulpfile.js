// Load plugins
var gulp         = require("gulp"),
    imagemin     = require("gulp-imagemin"),
    csso         = require("gulp-csso"),
    less         = require("gulp-less"),
    autoprefixer = require("gulp-autoprefixer"),
    uglify       = require("gulp-uglify"),
    notify       = require("gulp-notify"),
    jshint       = require("gulp-jshint"),
    changed      = require("gulp-changed"),
    concat       = require("gulp-concat"),
    filesize     = require("gulp-size"),
    duration     = require("gulp-duration"),
    pixrem       = require("gulp-pixrem"),
    sourcemaps   = require("gulp-sourcemaps"),
    browserSync  = require("browser-sync"),
    plumber      = require("gulp-plumber"),
    merge        = require("merge-stream"),
    filter       = require("gulp-filter");

var reload = browserSync.reload,
    paths =  {
      "scripts": {
        "src": "assets/js/src/**/*.js",
        "build": "assets/js/build/",
        "vendor": "!assets/js/src/vendor/**/*.js"
      },
      "styles": {
        "src": "assets/css/src/**/*.less",
        "build": "assets/css/build/"
      },
      "media": {
        "src": "assets/media/src/*",
        "build": "assets/media/build/"
      },
      "fonts": {
        "build": "assets/fonts/"
      }
    };

// BrowserSync
gulp.task("reload", function() {
  browserSync({
    proxy: "wordpress.dev",
    xip: true
  });
});

// JS Hint
gulp.task("jshint", function() {
  gulp.src([paths.scripts.src, paths.scripts.vendor])
    .pipe(jshint({
      "boss": true,
      "sub": true,
      "evil": true,
      "browser": true,
      "multistr": true,
      "globals": {
        "module": false,
        "require": true
      }
    }))
    .pipe(jshint.reporter("jshint-stylish"))
    .pipe(duration("hinting files"))
    .pipe(notify({ message: "JS Hint task complete" }));
});

// Copy
gulp.task("copy", function() {
  // UIkit fonts
  return gulp.src("bower_components/uikit/dist/fonts/*")
    .pipe(changed(paths.fonts.build))
    .pipe(gulp.dest(paths.fonts.build));
});

// Scripts
gulp.task("scripts", function() {

  // IE
  var ie = gulp.src([
      "bower_components/selectivizr/selectivizr.js",
      "bower_components/respond/dest/respond.min.js",
      "assets/js/src/vendor/ecmascript-polyfill.js",
      "assets/js/src/vendor/forEach-polyfill.js",
    ])
    .pipe(changed(paths.scripts.build))
    .pipe(concat("ie.min.js"))
    .pipe(uglify())
    .pipe(filesize({
      title: "IE Scripts:"
    }))
    .pipe(gulp.dest(paths.scripts.build))
    .pipe(notify({ message: "IE scripts task complete" }));

  // Main
  var main = gulp.src([
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
      "assets/js/src/_init.js"
    ])
    .pipe(changed(paths.scripts.build))
    .pipe(sourcemaps.init())
      .pipe(concat("scripts.min.js"))
      .pipe(uglify())
    .pipe(sourcemaps.write("../sourcemaps"))
    .pipe(filter('**/*.js')) // Filter only JS files for filesize/dest
    .pipe(filesize({
      title: "Main Scripts:"
    }))
    .pipe(gulp.dest(paths.scripts.build))
    .pipe(duration("building main JS files"))
    .pipe(notify({ message: "Main scripts task complete" }));

    return merge(ie, main);
});

// Styles
gulp.task("styles", function() {
  return gulp.src("assets/css/src/app.less")
    .pipe(changed(paths.styles.build))
    .pipe(plumber())
      .pipe(less())
      .pipe(autoprefixer({
        browsers: ["last 2 versions", "ie 9"]
      }))
      .pipe(csso())
      .pipe(pixrem("14px", {
        replace: true
      }))
    .pipe(plumber.stop())
    .pipe(filesize({
      title: "Styles:"
    }))
    .pipe(gulp.dest(paths.styles.build))
    .pipe(duration("building styles"))
    .pipe(notify({ message: "Styles task complete" }))
    .pipe(reload({
      stream:true
    }));
});

// Media
gulp.task("media", function() {

  return gulp.src(paths.media.src)
    .pipe(changed(paths.media.build))
    .pipe(imagemin())
    .pipe(filesize({
      title: "Media File:"
    }))
    .pipe(gulp.dest(paths.media.build))
    .pipe(duration("compressing media"))
    .pipe(notify({ message: "Media task complete" }));
});

// Default task
gulp.task("default", ["copy", "styles", "jshint", "scripts", "media", "watch"]);

// Watch
gulp.task("watch", ["reload"], function () {
  gulp.watch(paths.scripts.src, ["jshint", "scripts", browserSync.reload]);
  gulp.watch(paths.styles.src, ["styles"]);
  gulp.watch(paths.media.src, ["media"]);
  gulp.watch("*.php", ["", browserSync.reload]);
});
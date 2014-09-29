// Load plugins
var gulp         = require("gulp"),
    Combine      = require("stream-combiner"),
    jshint       = require("gulp-jshint"),
    csso         = require("gulp-csso"),
    less         = require("gulp-less"),
    autoprefixer = require("gulp-autoprefixer"),
    uglify       = require("gulp-uglify"),
    notify       = require("gulp-notify"),
    newer        = require("gulp-newer"),
    size         = require("gulp-size"),
    concat       = require("gulp-concat"),
    rename       = require("gulp-rename"),
    filesize     = require("gulp-size"),
    livereload   = require("gulp-livereload"),
    duration     = require("gulp-duration"),
    pixrem       = require("gulp-pixrem");

var paths =  {
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
    "src": "assets/media/"
  },
  "fonts": {
    "build": "assets/fonts/"
  }
};

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
  gulp.src("bower_components/uikit/dist/fonts/*")
    .pipe(gulp.dest(paths.fonts.build));
});

// Scripts
gulp.task("scripts", function() {

  // IE
  gulp.src([
      "bower_components/selectivizr/selectivizr.js",
      "bower_components/respond/dest/respond.min.js",
      "assets/js/src/vendor/ecmascript-polyfill.js",
      "assets/js/src/vendor/forEach-polyfill.js",
    ])
    .pipe(concat("ie.min.js"))
    .pipe(uglify())
    .pipe(filesize({
      title: "IE Scripts:"
    }))
    .pipe(gulp.dest(paths.scripts.build))
    .pipe(notify({ message: "IE scripts task complete" }));

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
      "assets/js/src/_init.js"
    ])
    .pipe(concat("scripts.min.js"))
    .pipe(uglify())
    .pipe(filesize({
      title: "Main Scripts:"
    }))
    .pipe(gulp.dest(paths.scripts.build))
    .pipe(duration("building main JS files"))
    .pipe(notify({ message: "Main scripts task complete" }));
});

// Styles
gulp.task("styles", function() {
  var combined = Combine(
      gulp.src("assets/css/src/app.less"),
      less(),
      autoprefixer("last 2 version", "ie 9"),
      csso(),
      pixrem("14px", {
        replace: true
      }),
      filesize({
        title: "Styles:"
      }),
      gulp.dest(paths.styles.build),
      duration("building styles"),
      notify({ message: "Styles task complete" })
    );

    combined.on("error", function(err) {
      console.warn(err.message);
    });

    return combined;
});

// Default task
gulp.task("default", ["copy", "styles", "jshint", "scripts"]);

// Watch
gulp.task("watch", function() {

  gulp.watch(paths.styles.src, ["styles"]);
  gulp.watch(paths.scripts.src, ["jshint", "scripts"]);

  // Create LiveReload server
  var server = livereload();

  // Watch files in patterns below, reload on change
  gulp.watch([paths.styles.build, paths.scripts.build, "*.php"]).on("change", function(file) {
    server.changed(file.path);
  });

});
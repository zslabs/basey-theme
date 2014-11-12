// Load plugins
var gulp         = require("gulp"),
    svgSprite    = require("gulp-svg-sprites"),
    replace      = require("gulp-replace"),
    imagemin     = require("gulp-imagemin"),
    pngcrush     = require('imagemin-pngcrush'),
    csso         = require("gulp-csso"),
    less         = require("gulp-less"),
    coffee       = require("gulp-coffee"),
    coffeelint   = require("gulp-coffeelint"),
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
    plumber      = require("gulp-plumber"),
    merge        = require("merge-stream"),
    filter       = require("gulp-filter"),
    livereload   = require("gulp-livereload");

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
        "src": "assets/media/src/*",
        "build": "assets/media/build/"
      },
      "svg": {
        "src": "assets/svg/src/*.svg",
        "build": "assets/svg/build/"
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
    .pipe(sourcemaps.init())
      .pipe(concat("ie.min.js"))
      .pipe(uglify())
    .pipe(sourcemaps.write("../sourcemaps"))
    .pipe(filesize({
      title: "IE Scripts:"
    }))
    .pipe(gulp.dest(paths.scripts.build))
    .pipe(notify({ message: "IE scripts task complete" }));

  // Main
  var main = gulp.src([
      // UI Kit
      "bower_components/uikit/src/js/core/core.js",
      "bower_components/uikit/src/js/core/component.js",
      "bower_components/uikit/src/js/core/utility.js",
      "bower_components/uikit/src/js/core/touch.js",
      "bower_components/uikit/src/js/core/alert.js",
      "bower_components/uikit/src/js/core/button.js",
      "bower_components/uikit/src/js/core/dropdown.js",
      "bower_components/uikit/src/js/core/grid.js",
      "bower_components/uikit/src/js/core/modal.js",
      "bower_components/uikit/src/js/core/offcanvas.js",
      "bower_components/uikit/src/js/core/nav.js",
      "bower_components/uikit/src/js/core/tooltip.js",
      "bower_components/uikit/src/js/core/switcher.js",
      "bower_components/uikit/src/js/core/tab.js",
      "bower_components/uikit/src/js/core/scrollspy.js",
      "bower_components/uikit/src/js/core/smooth-scroll.js",
      "bower_components/uikit/src/js/core/toggle.js",

      // UI Kit Add-ons
      "bower_components/uikit/src/js/components/autocomplete.js",
      "bower_components/uikit/src/js/components/cover.js",
      "bower_components/uikit/src/js/components/datepicker.js",
      "bower_components/uikit/src/js/components/form-password.js",
      "bower_components/uikit/src/js/components/form-select.js",
      "bower_components/uikit/src/js/components/htmleditor.js",
      "bower_components/uikit/src/js/components/nestable.js",
      "bower_components/uikit/src/js/components/notify.js",
      "bower_components/uikit/src/js/components/pagination.js",
      "bower_components/uikit/src/js/components/search.js",
      "bower_components/uikit/src/js/components/slideshow.js",
      "bower_components/uikit/src/js/components/slideshow-fx.js",
      "bower_components/uikit/src/js/components/sortable.js",
      "bower_components/uikit/src/js/components/sticky.js",
      "bower_components/uikit/src/js/components/timepicker.js",
      "bower_components/uikit/src/js/components/upload.js",

      // Vendor
      "bower_components/fastclick/lib/fastclick.js",
      "bower_components/jquery-placeholder/jquery.placeholder.js",
      "bower_components/parsleyjs/dist/parsley.js",
      "bower_components/svg4everybody/svg4everybody.js"
    ])
    .pipe(changed(paths.scripts.build))
    .pipe(sourcemaps.init())
      .pipe(concat("dep.min.js"))
      .pipe(uglify())
    .pipe(sourcemaps.write("../sourcemaps"))
    .pipe(filesize({
      title: "Main Scripts:"
    }))
    .pipe(gulp.dest(paths.scripts.build))
    .pipe(duration("building main JS files"))
    .pipe(notify({ message: "Main scripts task complete" }));

    return merge(ie, main);
});

// Coffee
gulp.task("coffee", function() {
  return gulp.src([
    "assets/js/src/_init.coffee",
    ])
    .pipe(changed(paths.scripts.build))
    .pipe(plumber())
      .pipe(coffeelint())
      .pipe(coffeelint.reporter())
      .pipe(sourcemaps.init())
        .pipe(concat("app.min.coffee"))
        .pipe(coffee())
        .pipe(uglify())
      .pipe(sourcemaps.write("../sourcemaps"))
    .pipe(plumber.stop())
    .pipe(gulp.dest(paths.scripts.build));
});

// Styles
gulp.task("styles", function() {
  gulp.src("assets/css/src/app.less")
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
    .pipe(notify({ message: "Styles task complete" }));
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

// SVG
gulp.task("svg", function () {
  return gulp.src(paths.svg.src)
    .pipe(replace("#000000", "#000001")) // This is to fix https://github.com/svg/svgo/issues/115
    .pipe(imagemin())
    .pipe(gulp.dest(paths.svg.build));
});

gulp.task("svg-sprite", function () {
  return gulp.src(paths.svg.src)
    .pipe(replace("#000000", "#000001")) // This is to fix https://github.com/svg/svgo/issues/115
    .pipe(svgSprite({
      mode: "symbols",
      svgPath: "%f",
      preview: false,
      svg: {
      symbols: "sprite.svg"
      }
    }))
    .pipe(gulp.dest(paths.svg.build));
});

// Default task
gulp.task("default", ["copy", "styles", "jshint", "scripts", "coffee", "media", "svg", "svg-sprite"]);

// Watch
gulp.task("watch", function () {
  gulp.watch(paths.scripts.src, ["jshint", "scripts"]);
  gulp.watch("assets/js/src/**/*.coffee", ["coffee"]);
  gulp.watch(paths.styles.src, ["styles"]);
  gulp.watch(paths.media.src, ["media"]);
  gulp.watch(paths.svg.src, ["svg", "svg-sprite"]);

  // Create LiveReload server
  var server = livereload();
  livereload.listen();

  // Watch files in patterns below, reload on change
  gulp.watch(["assets/css/build/*", "assets/js/build/*", "**/*.php", "assets/svg/build/*"]).on("change", function(file) {
    server.changed(file.path);
  });
});
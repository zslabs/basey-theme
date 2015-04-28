# Dependencies
gulp        = require "gulp"
$           = require("gulp-load-plugins")()
merge       = require "merge-stream"
browserSync = require "browser-sync"
reload      = browserSync.reload

paths =
  "scripts":
    "src": "assets/js/src/**/*.coffee"
    "build": "assets/js/build/"
  "styles":
    "src": "assets/css/src/**/*.less"
    "build": "assets/css/build/"
  "media":
    "src": "assets/media/src/**/*"
    "build": "assets/media/build/"
  "svg":
    "src": "assets/svg/src/*.svg"
    "build": "assets/svg/build/"
  "fonts":
    "build": "assets/fonts/"

# BrowserSync
gulp.task "browser-sync", ->
  browserSync
    proxy: "wordpress.dev"
  return

# Copy
gulp.task "copy", ->
  # UIkit fonts
  fonts = gulp.src "bower_components/uikit/src/fonts/*"
    .pipe(gulp.dest(paths.fonts.build))

  return fonts

# Dependencies
gulp.task "dep", ->

  gulp.src([
    # UIkit
    "bower_components/uikit/src/js/core/core.js",
    "bower_components/uikit/src/js/core/component.js"
    "bower_components/uikit/src/js/core/utility.js"
    "bower_components/uikit/src/js/core/touch.js"
    "bower_components/uikit/src/js/core/alert.js"
    "bower_components/uikit/src/js/core/button.js"
    "bower_components/uikit/src/js/core/dropdown.js"
    "bower_components/uikit/src/js/core/grid.js"
    "bower_components/uikit/src/js/core/modal.js"
    "bower_components/uikit/src/js/core/offcanvas.js"
    "bower_components/uikit/src/js/core/nav.js"
    "bower_components/uikit/src/js/core/tooltip.js"
    "bower_components/uikit/src/js/core/switcher.js"
    "bower_components/uikit/src/js/core/tab.js"
    "bower_components/uikit/src/js/core/scrollspy.js"
    "bower_components/uikit/src/js/core/smooth-scroll.js"
    "bower_components/uikit/src/js/core/toggle.js"

    # UI Kit Add-ons
    "bower_components/uikit/src/js/components/accordion.js"
    "bower_components/uikit/src/js/components/autocomplete.js"
    "bower_components/uikit/src/js/components/datepicker.js"
    "bower_components/uikit/src/js/components/form-password.js"
    "bower_components/uikit/src/js/components/form-select.js"
    "bower_components/uikit/src/js/components/grid.js"
    "bower_components/uikit/src/js/components/htmleditor.js"
    "bower_components/uikit/src/js/components/lightbox.js"
    "bower_components/uikit/src/js/components/nestable.js"
    "bower_components/uikit/src/js/components/notify.js"
    "bower_components/uikit/src/js/components/pagination.js"
    "bower_components/uikit/src/js/components/parallax.js"
    "bower_components/uikit/src/js/components/search.js"
    "bower_components/uikit/src/js/components/slider.js"
    "bower_components/uikit/src/js/components/slideset.js"
    "bower_components/uikit/src/js/components/slideshow.js"
    "bower_components/uikit/src/js/components/slideshow-fx.js"
    "bower_components/uikit/src/js/components/sortable.js"
    "bower_components/uikit/src/js/components/sticky.js"
    "bower_components/uikit/src/js/components/timepicker.js"
    "bower_components/uikit/src/js/components/tooltip.js"
    "bower_components/uikit/src/js/components/upload.js"

    # Vendor
    "bower_components/svg4everybody/svg4everybody.js"
    "bower_components/parsleyjs/dist/parsley.min.js"
    "bower_components/jquery-placeholder/jquery.placeholder.min.js"
  ])
  .pipe($.changed(paths.scripts.build))
  .pipe($.sourcemaps.init())
    .pipe($.concat("dep.min.js"))
    .pipe($.uglify())
  .pipe($.sourcemaps.write("../sourcemaps"))
  .pipe($.filesize(title: "Dependencies:"))
  .pipe($.duration("building dependency files"))
  .pipe(gulp.dest(paths.scripts.build))
  .pipe($.notify
    message: "dep task complete"
  )


# Coffee
gulp.task "app", ->
  gulp.src([ "assets/js/src/init.coffee" ])
  .pipe($.changed(paths.scripts.build))
  .pipe($.plumber())
    .pipe($.coffeelint(
      "max_line_length":
        "level": "ignore"
    ))
    .pipe($.coffeelint.reporter())
    .pipe($.sourcemaps.init())
      .pipe($.concat("app.min.coffee"))
      .pipe($.coffee())
      .pipe($.uglify())
    .pipe($.sourcemaps.write("../sourcemaps"))
  .pipe($.filesize(title: "App:"))
  .pipe($.plumber.stop())
  .pipe($.duration("building coffee files"))
  .pipe(gulp.dest(paths.scripts.build))
  .pipe($.notify
    message: "coffee task complete"
  )

# Styles
gulp.task "styles", ->
  gulp.src("assets/css/src/app.less")
  .pipe($.changed(paths.styles.build))
  .pipe($.plumber())
    .pipe($.less())
    .pipe($.autoprefixer(browsers: [ "last 2 versions" ]))
    .pipe($.csso())
  .pipe($.plumber.stop())
  .pipe($.duration("building style files"))
  .pipe($.filesize(title: "Styles:"))
  .pipe(gulp.dest(paths.styles.build))
  .pipe(reload(stream: true))
  .pipe $.notify(
    message: "styles task complete"
  )

# Media
gulp.task "media", ->
  gulp.src(paths.media.src)
  .pipe($.changed(paths.media.build))
  .pipe($.imagemin())
  .pipe($.filesize(title: "Media:"))
  .pipe(gulp.dest(paths.media.build))
  .pipe($.duration("compressing media"))
  .pipe $.notify(
    message: "meda task complete"
  )

# SVG
gulp.task "svg", ->
  gulp.src(paths.svg.src)
  .pipe($.replace("#000000", "#000001"))
  .pipe($.imagemin())
  .pipe gulp.dest(paths.svg.build)

# SVG Sprite
gulp.task "svg-sprite", ->
  gulp.src(paths.svg.src)
  .pipe($.replace("#000000", "#000001"))
  .pipe($.svgSprite(
    "svg":
      "xmlDeclaration": false
      "doctypeDeclaration": false
      "dimensionAttributes": false
    "mode": "symbol":
      "dest": ""
      "sprite": "sprite.svg"))
  .pipe gulp.dest(paths.svg.build)

# Watch
gulp.task "watch", [ "browser-sync" ], ->
  gulp.watch paths.scripts.src, [
    "app"
    reload
  ]
  gulp.watch paths.styles.src, ["styles" ]
  gulp.watch paths.media.src, [
    "media"
    reload
  ]
  gulp.watch paths.svg.src, [
    "svg"
    "svg-sprite"
    reload
  ]
  return

# Default task
gulp.task "default", [
  "copy"
  "dep"
  "app"
  "styles"
  "media"
  "svg"
  "svg-sprite"
]
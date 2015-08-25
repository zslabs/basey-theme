module.exports = function(gulp, $, browserSync, reload, merge, paths, files) {
  return function() {
    gulp.src(paths.svg.src)
    .pipe($.svgSprite({
      'svg': {
        'xmlDeclaration': false,
        'doctypeDeclaration': false,
        'dimensionAttributes': false
      },
      'mode': {
        'symbol': {
          'dest': '',
          'sprite': 'sprite.svg'
        }
      }
    }))
    .pipe($.size({
      showFiles: true,
      title: 'SVG Sprite:'
    }))
    .pipe(gulp.dest(paths.svg.build));
  };
};
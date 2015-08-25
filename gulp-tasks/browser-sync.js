module.exports = function(gulp, $, browserSync, reload, merge, paths, files) {
  return function() {
    browserSync({
      proxy: "wordpress.dev"
    });
  };
};
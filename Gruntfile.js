module.exports = function(grunt) {

	"use strict";

	var pkginfo = grunt.file.readJSON("package.json");

	grunt.initConfig({

		pkg: pkginfo,

		jshint: {
			src: {
				options: {
					jshintrc: ".jshintrc",
					ignores: ["assets/js/build/*.js", "assets/js/vendor/*.js"]
				},
				src: ["assets/js/src/*.js"]
			}
		},

		compass: {
			dist: {
				options: {
					config: 'config.rb'
				}
			}
		},

		copy: {
			main: {
				files: [
					{expand: true, flatten: true, src: ['bower_components/modernizr/modernizr.js'], dest: 'assets/js/vendor/', filter: 'isFile'}
				]
			}
		},

		concat: {
			ie: {
				options: {
					separator: "\n\n"
				},
				src: [
					"bower_components/selectivizr/selectivizr.js",
					"bower_components/respond/dest/respond.min.js",
					"bower_components/REM-unit-polyfill/js/rem.js"
				],
				dest: "assets/js/build/ie.js"
			},
			dist: {
				options: {
					separator: "\n\n"
				},
				src: [
					// Foundation Vendor
					"bower_components/foundation/js/vendor/fastclick.js",
					"bower_components/foundation/js/vendor/jquery.autocomplete.js",
					"bower_components/foundation/js/vendor/placeholder.js",
					"bower_components/foundation/js/vendor/jquery.cookie.js",
					// Foundation Core
					"bower_components/foundation/js/foundation/foundation.js",
					"bower_components/foundation/js/foundation/foundation.abide.js",
					"bower_components/foundation/js/foundation/foundation.accordion.js",
					"bower_components/foundation/js/foundation/foundation.alert.js",
					"bower_components/foundation/js/foundation/foundation.clearing.js",
					"bower_components/foundation/js/foundation/foundation.dropdown.js",
					"bower_components/foundation/js/foundation/foundation.interchange.js",
					"bower_components/foundation/js/foundation/foundation.joyride.js",
					"bower_components/foundation/js/foundation/foundation.magellan.js",
					"bower_components/foundation/js/foundation/foundation.offcanvas.js",
					"bower_components/foundation/js/foundation/foundation.orbit.js",
					"bower_components/foundation/js/foundation/foundation.reveal.js",
					"bower_components/foundation/js/foundation/foundation.tab.js",
					"bower_components/foundation/js/foundation/foundation.tooltip.js",
					"bower_components/foundation/js/foundation/foundation.topbar.js",
					// Custom Vendor
					"bower_components/parsleyjs/dist/parsley.min.js",
					// Project
					"assets/js/src/_init.js"

					],
				dest: "assets/js/build/scripts.js"
			}
		},

		uglify: {
			min: {
				files: {
					"assets/js/build/scripts.min.js": ["assets/js/build/scripts.js"],
					"assets/js/build/ie.min.js": ["assets/js/build/ie.js"]
				}
			}
		},

		watch: {
			markup: {
				files: ['*.php'],
				options: {
					livereload: true,
				}
			},
			scss: {
				files: ["assets/css/src/*.scss"],
				tasks: ["compass"],
				options: {
					livereload: true,
					files: ['**/*']
				}
			},
			js: {
				files: ["assets/js/src/*.js"],
				tasks: ["copy", "jshint", "concat", "uglify"],
				options: {
					livereload: true,
					files: ['**/*']
				}
			}
		}

	});

	// Load grunt tasks from NPM packages
	grunt.loadNpmTasks("grunt-contrib-compass");
	grunt.loadNpmTasks("grunt-contrib-copy");
	grunt.loadNpmTasks("grunt-contrib-concat");
	grunt.loadNpmTasks("grunt-contrib-jshint");
	grunt.loadNpmTasks("grunt-contrib-uglify");
	grunt.loadNpmTasks("grunt-contrib-watch");

	// Register grunt tasks
	grunt.registerTask("default", ["compass", "copy", "concat", "jshint", "uglify"]);

};
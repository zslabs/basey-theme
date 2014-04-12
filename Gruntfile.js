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

		sass: {
			dist: {
				options: {
					style: "compressed",
					loadPath: "bower_components/foundation/scss"
				},
				files: {
					'assets/css/build/app.css': 'assets/css/src/app.scss'
				}
			}
		},

		autoprefixer: {

			options: {
				browsers: ['last 2 version', 'ie 9']
			},
			dist: {
				src: 'assets/css/build/app.css',
				dest: 'assets/css/build/app.css'
			}
		},

		pixrem: {
			options: {
				rootvalue: '16px',
				replace: true
			},
			dist: {
				src: 'assets/css/build/app.css',
				dest: 'assets/css/build/rem-fallback.css'
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
					"bower_components/respond/dest/respond.min.js"
				],
				dest: "assets/js/build/ie.min.js"
			},
			dist: {
				options: {
					separator: "\n\n"
				},
				src: [
					// Foundation Vendor
					"bower_components/fastclick/lib/fastclick.js",
					"bower_components/jquery-placeholder/jquery.placeholder.js",
					// Foundation Core
					"bower_components/foundation/js/foundation/foundation.js",
					"bower_components/foundation/js/foundation/foundation.abide.js",
					"bower_components/foundation/js/foundation/foundation.accordion.js",
					"bower_components/foundation/js/foundation/foundation.alert.js",
					"bower_components/foundation/js/foundation/foundation.clearing.js",
					"bower_components/foundation/js/foundation/foundation.dropdown.js",
					"bower_components/foundation/js/foundation/foundation.equalizer.js",
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
					"bower_components/jquery.smooth-scroll/jquery.smooth-scroll.min.js",
					// Project
					"assets/js/src/_init.js"

					],
				dest: "assets/js/build/scripts.min.js"
			}
		},

		uglify: {
			min: {
				files: {
					"assets/js/build/scripts.min.js": ["assets/js/build/scripts.min.js"],
					"assets/js/build/ie.min.js": ["assets/js/build/ie.min.js"],
					"assets/js/vendor/modernizr.js": ["assets/js/vendor/modernizr.js"]
				}
			}
		},

		watch: {
			options: {
				livereload: true
			},
			markup: {
				files: ["*.php"],
			},
			scss: {
				options: {
					livereload: false
				},
				files: ["assets/css/src/*.scss"],
				tasks: ["sass", "autoprefixer", "pixrem"]
			},
			css : {
				files: ["assets/css/build/*.css"],
				tasks: []
			},
			js: {
				files: ["assets/js/src/*.js"],
				tasks: ["jshint", "concat", "uglify"]
			}
		}

	});

	// Load grunt tasks from NPM packages
	grunt.loadNpmTasks("grunt-autoprefixer");
	grunt.loadNpmTasks("grunt-contrib-copy");
	grunt.loadNpmTasks("grunt-contrib-concat");
	grunt.loadNpmTasks("grunt-contrib-jshint");
	grunt.loadNpmTasks('grunt-pixrem');
	grunt.loadNpmTasks("grunt-contrib-sass");
	grunt.loadNpmTasks("grunt-contrib-uglify");
	grunt.loadNpmTasks("grunt-contrib-watch");

	// Register grunt tasks
	grunt.registerTask("default", ["sass", "autoprefixer", "pixrem", "copy", "concat", "jshint", "uglify"]);

};
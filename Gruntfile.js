var timer = require("grunt-timer");

module.exports = function(grunt) {

	"use strict";

	var pkginfo = grunt.file.readJSON("package.json");
	timer.init(grunt);

	grunt.initConfig({

		pkg: pkginfo,

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
				dest: 'assets/css/build/app.css'
			}
		},

		csso: {
			compress: {
				files: {
					'assets/css/build/app.css': ['assets/css/build/app.css']
				}
			}
		},

		modernizr: {

			dist: {
				// [REQUIRED] Path to the build you're using for development.
				"devFile" : "bower_components/modernizr/modernizr.js",

				// [REQUIRED] Path to save out the built file.
				"outputFile" : "assets/js/build/vendor/modernizr.js",

				// Based on default settings on http://modernizr.com/download/
				"extra" : {
					"shiv" : true,
					"printshiv" : false,
					"load" : true,
					"mq" : false,
					"cssclasses" : true,
					"svg" : true
				},

				// Based on default settings on http://modernizr.com/download/
				"extensibility" : {
					"addtest" : false,
					"prefixed" : false,
					"teststyles" : false,
					"testprops" : false,
					"testallprops" : false,
					"hasevents" : false,
					"prefixes" : false,
					"domprefixes" : false
				},

				// By default, source is uglified before saving
				"uglify" : true,

				// Define any tests you want to implicitly include.
				"tests" : [],

				// By default, this task will crawl your project for references to Modernizr tests.
				// Set to false to disable.
				"parseFiles" : true,

				// When parseFiles = true, this task will crawl all *.js, *.css, *.scss files, except files that are in node_modules/.
				// You can override this by defining a "files" array below.
				// "files" : {
					// "src": []
				// },

				// When parseFiles = true, matchCommunityTests = true will attempt to
				// match user-contributed tests.
				"matchCommunityTests" : false,

				// Have custom Modernizr tests? Add paths to their location here.
				"customTests" : []
			}

		},

		jshint: {
			src: {
				options: {
					jshintrc: ".jshintrc",
					ignores: ["assets/js/build/**/*.js", "assets/js/src/vendor/*.js"],
					reporter: require('jshint-stylish')
				},
				src: ["assets/js/src/*.js"]
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
					"assets/js/build/ie.min.js": ["assets/js/build/ie.min.js"]
				}
			}
		},

		watch: {
			options: {
				livereload: true
			},
			grunt: {
				options: {
					reload: true,
				},
				files: ['Gruntfile.js'],
			},
			markup: {
				files: ["*.php"],
			},
			scss: {
				options: {
					livereload: false,
					spawn: false
				},
				files: ["assets/css/src/*.scss"],
				tasks: ["sass", "autoprefixer", "pixrem", "csso"]
			},
			css : {
				files: ["assets/css/build/*.css"],
				tasks: []
			},
			js: {
				options: {
					spawn: false
				},
				files: ["assets/js/src/*.js"],
				tasks: ["jshint", "concat", "uglify"]
			}
		}

	});

	// Load Grunt Tasks
	require('jit-grunt')(grunt);

	// Register Grunt Tasks
	grunt.registerTask("default", ["sass", "autoprefixer", "pixrem", "csso", "modernizr", "concat", "jshint", "uglify"]);
	grunt.registerTask("styles", ["sass", "autoprefixer", "pixrem", "csso"]);
	grunt.registerTask("js", ["modernizr", "concat", "jshint", "uglify"]);

};
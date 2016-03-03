'use strict';

module.exports = function (grunt) {

		// Load grunt tasks automatically
		require('load-grunt-tasks')(grunt);

		// Define the configuration for all the tasks
		grunt.initConfig({
			// Add vendor prefixed styles
			autoprefixer: {
				dist: {
					files: {
						'style.css': 'style.css',
						'editor-style.css': 'editor-style.css',
					}
				},
				options: {
					browsers: ['last 2 version', 'ie 9', 'ie 10']
				}
			},

			sass: {
				dist: {
					options: {
						// sourcemap: true,
						style: 'expanded',
					},
					files: {
						'style.css': 'assets/sass/style.scss',
						'editor-style.css': 'assets/sass/editor-style.scss'
					}
				}
			},

			svg2png: {
				misc: {
					files: [
						{ cwd: 'assets/img/', src: ['**/*.svg'], dest: 'assets/img/' }
					]
				}
			},

			uglify: {
				options: {
					sourceMap: true
				},
				dist: {
					files: {
						'assets/js/app.min.js': [
							'assets/js/lib/jquery.fitvids.js',
							'assets/js/lib/picturefill.min.js', // already minified, but we want to concat it
							'assets/js/src/scripts.js',
							'assets/js/src/progressive.js',
							'assets/js/src/ajax-paging.js'
						],
						// Separate Because it is on the backend
						'assets/js/customizer.min.js': ['assets/js/src/customizer.js'],
						// Separate Because it is loaded only on /experts
						'assets/js/experts-search.min.js': ['assets/js/src/experts-search.js'],
						'assets/js/lib/typeahead.min.js': ['assets/js/lib/typeahead.js'],
					}
				}
			},

			watch: {
				sass: {
					files: ['assets/sass/**/*.scss'],
					tasks: ['sass', 'autoprefixer']
				},
				uglify: {
					files: [
						'assets/js/src/*.js',
						'_lib/typeahead.js',
						'_lib/fitvids.min.js'
					],
					tasks: ['uglify']
				},
				php: {
					files: ['**/*.php']
				},
				svg: {
					files: ['img/*.svg'],
					tasks: ['svg2png']
				},
				options: {
					livereload: true,
				},
			}

		});

		// Define your default tasks
		grunt.registerTask('default', [
			'sass',
			'autoprefixer',
			'svg2png',
			'uglify:dist'
		]);

		grunt.registerTask('dev', [
			'default',
			'watch',
		]);

		grunt.registerTask('build', [
			'default',
		]);
};

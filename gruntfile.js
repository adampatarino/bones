module.exports = function(grunt) {

    // Load Grunt Plugins
    require('load-grunt-tasks')(grunt);


    // Tasks Config
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        sass: {
            dist:  {
                files:  {
                    'lib/css/theme.css': 'lib/scss/theme.scss'
                }
            }
        },

        autoprefixer: {
            theme: {
                src: 'lib/css/theme.css'
            }
        },

        watch: {
            styles: {
                files: ['lib/scss/*.scss'],
                tasks: ['process'],
                options: {
                  livereload: true,
                }
            }
        },

        // Deployment Tasks

        uglify: {
            prod: {
              files: {
                'library/public/application.min.js': ['library/js/scripts.js', 'library/js/libs/*.js']
              }
            }
        },

        cssmin: {
            prod: {
                files: {
                  'library/public/application.min.css': ['library/css/theme.css']
                }
            }
        }



    });


    // Tasks
    grunt.registerTask('process', ['sass', 'autoprefixer']);

    grunt.registerTask('build', ['uglify', 'cssmin']);








};
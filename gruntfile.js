module.exports = function(grunt) {

    // Load Grunt Plugins
    require('load-grunt-tasks')(grunt);


    // Tasks Config
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        sass: {
            dist:  {
                files:  {
                    'library/css/theme.css': 'library/scss/theme.scss'
                }
            }
        },

        autoprefixer: {
            theme: {
                src: 'library/css/theme.css'
            }
        },

        watch: {
            styles: {
                files: ['library/scss/*.scss'],
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
        },

        gitcommit: {
            deployment: {
              options: {
                message: "Grunt: Commit production assets for deployment."
              },
              files: {
                  src:['library/public/*']
              }
            }
        },

        dploy: {
            stage: {
                host: "ftp.myserver.com",
                user: "user",
                pass: "secret-password",
                path: {
                    local: "/",
                    remote: "public_html/website/wp-content/themes/themename/"
                }
            }
        }




    });


    // Tasks
    grunt.registerTask('process', ['sass', 'autoprefixer']);

    grunt.registerTask('deploy', ['uglify', 'cssmin', 'gitcommit', 'dploy']);








};
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

        dploy: {                                    // Task
            stage: {                                // Target
                host: "ftp.myserver.com"            // Your FTP host
                user: "user"                        // Your FTP user
                pass: "secret-password"             // Your FTP secret-password
                path: {
                    local: "/",               // The local folder that you want to upload
                    remote: "public_html/website/wp-content/themes/themename/"          // Where the files from the local file will be uploaded at in your remote server
                }
            }
        }




    });


    // Tasks
    grunt.registerTask('process', ['sass', 'autoprefixer']);

    grunt.registerTask('deploy', ['uglify', 'cssmin', 'gitcommit', 'dploy']);








};
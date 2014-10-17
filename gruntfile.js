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

        cmq: {
            options: {
                log: false
            },
            your_target: {
                files: {
                    'library/css/theme.css': ['library/css/theme.css']
                }
            }
        },

        watch: {
            styles: {
                files: ['library/scss/*.scss'],
                tasks: ['process'],
                options: {
                  // livereload: true,
                }
            }
        },

        browserSync: {
          dev: {
                bsFiles: {
                  src : 'library/css/theme.css'
                },
                options: {
                    watchTask: true,
                    // server: { baseDir: "./" }
                    proxy: "trb.dev"
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

        imagemin: {                          
            images: {                        
              options: {                     
                optimizationLevel: 3,
                use: [mozjpeg()]
              },
              files: {                       
                'library/images/': 'library/images/*'
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
        }




    });


    // Tasks
    
    grunt.registerTask('default', ['browserSync', 'watch']);

    grunt.registerTask('process', ['sass', 'autoprefixer', 'cmq']);

    grunt.registerTask('deploy', ['uglify', 'cssmin', 'newer:imagemin:images', 'gitcommit']);








};
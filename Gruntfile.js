module.exports = function(grunt) {

    "use strict";

    var projectname = "fenling";
    //require('jit-grunt')(grunt, {
    //    htmlbuild: 'grunt-html-build'
    //});

    var optimize = "none"; //uglify|none|test

    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        path: {
            build: {
                html: 'app/Resources/build/',
                js: 'app/Resources/build/js/',
                css: 'app/Resources/build/css/',
                img: 'app/Resources/build/img/',
                fonts: 'app/Resources/build/fonts/'
            },
            src: {
                js: 'app/Resources/src/fenglin/',
                // style: 'app/Resources/src/style/main.less',
                // img: 'app/Resources/src/img/**/*.*',
                // fonts: 'app/Resources/src/fonts/**/*.*',
                // svgfonts: 'app/Resources/src/fonts/svg/'
            },
            bower_components: {
                css: [
                    'bower_components/bootstrap/dist/css/bootstrap.css',
                    'bower_components/font-awesome/css/font-awesome.css'
                ],
                js: [
                    'bower_components/jquery/dist/jquery.js',
                    'bower_components/bootstrap/dist/js/bootstrap.js'
                ],
                fonts: ['bower_components/**/fonts/*.*']
            },
            watch: {
                html: 'src/**/*.html',
                js: 'src/js/**/*.js',
                less: 'src/style/**/*.less',
                img: 'src/img/**/*.*',
                fonts: 'src/fonts/**/*.*'
            },
            clean: './build'
        },


        requirejs: {
            compile_main: {
                options: {
                    baseUrl: '.',
                    name: 'app/Resources/src/fenglin/vendor/almond/almond.js',
                    include: ['app/Resources/src/fenglin/config'],
                    // insertRequire: ['main'],
                    out: 'app/Resources/build/main-build.js',
                    optimize: "uglify",
                    //optimize: "none",   // If you need to debug the compiled script
                    //namespace: "test",  // If using Almond then no need to namespace
                    paths: {
                        vendor: "app/Resources/src/fenglin/vendor",
                        admin: "app/Resources/src/fenglin/admin",
                        consumer: "app/Resources/src/fenglin/consumer",
                        shopper: "app/Resources/src/fenglin/shopper",

                        jquery: "app/Resources/src/fenglin/vendor/jquery/dist/jquery.min",
                        underscore: "app/Resources/src/fenglin/vendor/underscore/underscore-min",
                        backbone: "app/Resources/src/fenglin/vendor/backbone/backbone-min",
                        "backbone.radio": "app/Resources/src/fenglin/vendor/backbone.radio/build/backbone.radio.min",
                        marionette: "app/Resources/src/fenglin/vendor/backbone.marionette/lib/backbone.marionette.min",
                        zepto: "app/Resources/src/fenglin/vendor/zepto/zepto",
                        jweixin: "app/Resources/src/fenglin/vendor/jweixin-bower/jweixin-1.0.0",
                        weui: "app/Resources/src/fenglin/vendor/weui.js/dist/weui",
                        text: "app/Resources/src/fenglin/vendor/text/text",
                        main: "app/Resources/src/fenglin/main"
                    },
                    wrap: true
                }
            },
            compile_admin_main: {
                options: {
                    baseUrl: '.',
                    name: 'app/Resources/src/fenglin/vendor/almond/almond.js',
                    include: ['app/Resources/src/fenglin/config_admin'],
                    // insertRequire: ['main'],
                    out: 'app/Resources/build/main-admin-build.js',
                    optimize: "uglify",
                    //optimize: "none",   // If you need to debug the compiled script
                    //namespace: "test",  // If using Almond then no need to namespace
                    paths: {
                        vendor: "app/Resources/src/fenglin/vendor",
                        admin: "app/Resources/src/fenglin/admin",
                        consumer: "app/Resources/src/fenglin/consumer",
                        shopper: "app/Resources/src/fenglin/shopper",

                        jquery: "app/Resources/src/fenglin/vendor/jquery/dist/jquery.min",
                        underscore: "app/Resources/src/fenglin/vendor/underscore/underscore-min",
                        backbone: "app/Resources/src/fenglin/vendor/backbone/backbone-min",
                        "backbone.radio": "app/Resources/src/fenglin/vendor/backbone.radio/build/backbone.radio.min",
                        marionette: "app/Resources/src/fenglin/vendor/backbone.marionette/lib/backbone.marionette.min",
                        zepto: "app/Resources/src/fenglin/vendor/zepto/zepto",
                        jweixin: "app/Resources/src/fenglin/vendor/jweixin-bower/jweixin-1.0.0",
                        weui: "app/Resources/src/fenglin/vendor/weui.js/dist/weui",
                        text: "app/Resources/src/fenglin/vendor/text/text",
                        "main.admin": "app/Resources/src/fenglin/main_admin"

                    },
                    wrap: true
                }
            },
            compile_shopper_main: {
                options: {
                    baseUrl: '.',
                    name: 'app/Resources/src/fenglin/vendor/almond/almond.js',
                    include: ['app/Resources/src/fenglin/config_shopper'],
                    // insertRequire: ['main'],
                    out: 'app/Resources/build/main-shopper-build.js',
                    optimize: "uglify",
                    //optimize: "none",   // If you need to debug the compiled script
                    //namespace: "test",  // If using Almond then no need to namespace
                    paths: {
                        vendor: "app/Resources/src/fenglin/vendor",
                        admin: "app/Resources/src/fenglin/admin",
                        consumer: "app/Resources/src/fenglin/consumer",
                        shopper: "app/Resources/src/fenglin/shopper",

                        jquery: "app/Resources/src/fenglin/vendor/jquery/dist/jquery.min",
                        underscore: "app/Resources/src/fenglin/vendor/underscore/underscore-min",
                        backbone: "app/Resources/src/fenglin/vendor/backbone/backbone-min",
                        "backbone.radio": "app/Resources/src/fenglin/vendor/backbone.radio/build/backbone.radio.min",
                        marionette: "app/Resources/src/fenglin/vendor/backbone.marionette/lib/backbone.marionette.min",
                        zepto: "app/Resources/src/fenglin/vendor/zepto/zepto",
                        jweixin: "app/Resources/src/fenglin/vendor/jweixin-bower/jweixin-1.0.0",
                        weui: "app/Resources/src/fenglin/vendor/weui.js/dist/weui",
                        text: "app/Resources/src/fenglin/vendor/text/text",
                        "main.shopper": "app/Resources/src/fenglin/main_shopper"
                    },
                    wrap: true
                }
            }
        }
        // clean: ['<%= path.clean %>'],

        // htmlbuild: {
        //     production: {
        //         src: '<%= path.src.html %>',
        //         dest: '<%= path.build.html %>',
        //         options: {
        //             beautify: true,
        //             prefix: '',
        //             relative: true,
        //             basePath: false,
        //             scripts: {
        //                 bundle: [
        //                     '<%= path.build.js %>lib.min.js',
        //                     '<%= path.build.js %>main.min.js'
        //                 ]
        //             },
        //             styles: {
        //                 bundle: [
        //                     '<%= path.build.css %>lib.min.css',
        //                     '<%= path.build.css %>main.min.css'
        //                 ]
        //             },
        //             sections: {
        //                 templates: '<%= path.src.html %>',
        //                 layout: {
        //                     header: '<%= path.src.template %>header.html',
        //                     footer: '<%= path.src.template %>footer.html',
        //                 }
        //             },
        //             data: {
        //                 // Data to pass to templates
        //                 version: "0.1.0",
        //                 title: "test",
        //             },
        //         }
        //     },
        //     dev: {
        //         src: '<%= path.src.html %>',
        //         dest: '<%= path.build.html %>',
        //         options: {
        //             beautify: true,
        //             prefix: '',
        //             relative: true,
        //             basePath: false,
        //             scripts: {
        //                 bundle: [
        //                     '<%= path.build.js %>lib.js',
        //                     '<%= path.build.js %>main.js'
        //                 ]
        //             },
        //             styles: {
        //                 bundle: [
        //                     '<%= path.build.css %>lib.css',
        //                     '<%= path.build.css %>main.css'
        //                 ],
        //             },
        //             sections: {
        //                 templates: '<%= path.src.html %>',
        //                 layout: {
        //                     header: '<%= path.src.template %>header.html',
        //                     footer: '<%= path.src.template %>footer.html',
        //                 }
        //             },
        //             data: {
        //                 // Data to pass to templates
        //                 version: "0.1.0",
        //                 title: "test",
        //             },
        //         }
        //     },
        //     tidycss: {
        //         src: '<%= path.src.html %>',
        //         dest: '<%= path.build.html %>',
        //         options: {
        //             beautify: true,
        //             prefix: '',
        //             relative: true,
        //             basePath: false,
        //             scripts: {
        //                 bundle: [
        //                     '<%= path.build.js %>lib.js',
        //                     '<%= path.build.js %>main.js'
        //                 ]
        //             },
        //             styles: {
        //                 bundle: [
        //                     '<%= path.build.css %>tidy.min.css',
        //                 ],
        //             },
        //             sections: {
        //                 templates: '<%= path.src.html %>',
        //                 layout: {
        //                     header: '<%= path.src.template %>header.html',
        //                     footer: '<%= path.src.template %>footer.html',
        //                 }
        //             },
        //             data: {
        //                 // Data to pass to templates
        //                 version: "0.1.0",
        //                 title: "test",
        //             },
        //         }
        //     },
        // },
        // less: {
        //     production: {
        //         //options: {
        //         //},
        //         files: {
        //             '<%= path.build.css %>main.css': '<%= path.src.style %>'
        //         }
        //     }
        // },
        // postcss: {
        //     options: {
        //         map: false, // inline sourcemaps
        //
        //         processors: [
        //             require('autoprefixer')({browsers: 'last 2 versions'}) // add vendor prefixes
        //         ]
        //     },
        //     dist: {
        //         src: '<%= path.build.css %>main.css'
        //     }
        // },
        // concat: {
        //     options: {
        //
        //     },
        //     consumer_js: {
        //         src: [
        //             '<%= path.src.js %>config.js',
        //             '<%= path.src.js %>main.js',
        //             '<%= path.src.js %>consumer/collections/*.js',
        //             '<%= path.src.js %>consumer/controllers/*.js',
        //             '<%= path.src.js %>consumer/models/*.js',
        //             '<%= path.src.js %>consumer/routers/*.js',
        //             '<%= path.src.js %>consumer/views/*.js',
        //             '<%= path.src.js %>admin/collections/*.js',
        //             '<%= path.src.js %>admin/controllers/*.js',
        //             '<%= path.src.js %>admin/models/*.js',
        //             '<%= path.src.js %>admin/routers/*.js',
        //             '<%= path.src.js %>admin/views/*.js',
        //             '<%= path.src.js %>shopper/collections/*.js',
        //             '<%= path.src.js %>shopper/controllers/*.js',
        //             '<%= path.src.js %>shopper/models/*.js',
        //             '<%= path.src.js %>shopper/routers/*.js',
        //             '<%= path.src.js %>shopper/views/*.js'
        //         ],
        //         dest: '<%= path.build.js %>consumer.js'
        //     },
        //     shopper_js: {
        //         src: [
        //             '<%= path.src.js %>config.js',
        //             '<%= path.src.js %>main_shopper.js',
        //             '<%= path.src.js %>consumer/collections/*.js',
        //             '<%= path.src.js %>consumer/controllers/*.js',
        //             '<%= path.src.js %>consumer/models/*.js',
        //             '<%= path.src.js %>consumer/routers/*.js',
        //             '<%= path.src.js %>consumer/views/*.js',
        //             '<%= path.src.js %>admin/collections/*.js',
        //             '<%= path.src.js %>admin/controllers/*.js',
        //             '<%= path.src.js %>admin/models/*.js',
        //             '<%= path.src.js %>admin/routers/*.js',
        //             '<%= path.src.js %>admin/views/*.js',
        //             '<%= path.src.js %>shopper/collections/*.js',
        //             '<%= path.src.js %>shopper/controllers/*.js',
        //             '<%= path.src.js %>shopper/models/*.js',
        //             '<%= path.src.js %>shopper/routers/*.js',
        //             '<%= path.src.js %>shopper/views/*.js'
        //         ],
        //         dest: '<%= path.build.js %>shopper.js'
        //     },
        //     admin_js: {
        //         src: [
        //             '<%= path.src.js %>config.js',
        //             '<%= path.src.js %>main_admin.js',
        //             '<%= path.src.js %>consumer/collections/*.js',
        //             '<%= path.src.js %>consumer/controllers/*.js',
        //             '<%= path.src.js %>consumer/models/*.js',
        //             '<%= path.src.js %>consumer/routers/*.js',
        //             '<%= path.src.js %>consumer/views/*.js',
        //             '<%= path.src.js %>admin/collections/*.js',
        //             '<%= path.src.js %>admin/controllers/*.js',
        //             '<%= path.src.js %>admin/models/*.js',
        //             '<%= path.src.js %>admin/routers/*.js',
        //             '<%= path.src.js %>admin/views/*.js',
        //             '<%= path.src.js %>shopper/collections/*.js',
        //             '<%= path.src.js %>shopper/controllers/*.js',
        //             '<%= path.src.js %>shopper/models/*.js',
        //             '<%= path.src.js %>shopper/routers/*.js',
        //             '<%= path.src.js %>shopper/views/*.js'
        //         ],
        //         dest: '<%= path.build.js %>admin.js'
        //     },
        //     bower_css: {
        //         src: ['<%= path.bower_components.css %>'],
        //         dest: '<%= path.build.css %>lib.css'
        //     }
        // },
        // uglify: {
        //     options: {
        //         mangle: false,
        //         sourceMap: true
        //     },
        //     project: {
        //         files: [{
        //             expand: true,
        //             cwd: '<%= path.build.js %>',
        //             src: ['*.js', '!*.min.css'],
        //             dest: '<%= path.build.js %>',
        //             ext: '.min.js'
        //         }]
        //     },
        // },
        // cssmin: {
        //     options: {
        //         sourceMap: true,
        //     },
        //     project: {
        //         files: [{
        //             expand: true,
        //             cwd: '<%= path.build.css %>',
        //             src: ['*.css', '!*.min.css'],
        //             dest: '<%= path.build.css %>',
        //             ext: '.min.css'
        //         }]
        //     },
        // },
        // copy: {
        //     bower: {
        //         files: [
        //             {
        //                 expand: true,
        //                 flatten: true,
        //                 src: ['<%= path.bower_components.fonts %>'],
        //                 dest: '<%= path.build.fonts %>',
        //                 filter: 'isFile'
        //             },
        //         ],
        //     },
        //     project: {
        //         files: [
        //             {
        //                 expand: true,
        //                 flatten: true,
        //                 src: ['<%= path.src.js %>'],
        //                 dest: '<%= path.build.js %>',
        //                 filter: 'isFile'
        //             },
        //
        //         ],
        //     },
        // },
        // watch: {
        //     html: {
        //         files: '<%= path.watch.html %>',
        //         tasks: ['htmlbuild:dev'],
        //         options: {
        //             livereload: true,
        //         },
        //     },
        //     less: {
        //         files: '<%= path.watch.less %>',
        //         tasks: ['less'],
        //         options: {
        //             livereload: true,
        //         },
        //     },
        //     js: {
        //         files: '<%= path.watch.js %>',
        //         tasks: ['copy:project'],
        //         options: {
        //             livereload: true,
        //         },
        //     },
        // },
        // uncss: {
        //     dist: {
        //         files: {
        //             '<%= path.build.css %>tidy.css': [
        //                 '<%= path.build.html %>index.html'
        //             ]
        //         }
        //     }
        // },
        // svgicons2svgfont: {
        //     options: {
        //         fontName: projectname + "Font"
        //     },
        //     your_target: {
        //         src: '<%= path.src.svgfonts %>source/*.svg',
        //         dest: '<%= path.src.svgfonts %>'
        //     }
        // },

    });

    // grunt.loadNpmTasks('grunt-html-build');
    // grunt.loadNpmTasks('grunt-contrib-less');
    // grunt.loadNpmTasks('grunt-postcss');
    // grunt.loadNpmTasks('grunt-contrib-copy');
    // grunt.loadNpmTasks('grunt-contrib-concat');
    // grunt.loadNpmTasks('grunt-contrib-uglify');
    // grunt.loadNpmTasks('grunt-contrib-cssmin');
    // grunt.loadNpmTasks('grunt-contrib-watch');
    // grunt.loadNpmTasks('grunt-contrib-clean');
    // grunt.loadNpmTasks('grunt-uncss');
    // grunt.loadNpmTasks('grunt-svgicons2svgfont');

    // grunt.registerTask('default', ['concat']);
    // grunt.registerTask('bower', ['concat:bower_js','concat:bower_css']);
    // grunt.registerTask('dev', ['copy:project','less:production','postcss','htmlbuild:dev']);
    // grunt.registerTask('build', ['bower','dev','uglify','cssmin','htmlbuild:production']);
    // grunt.registerTask('tidycss', ['uncss','cssmin','htmlbuild:tidycss']);
    grunt.loadNpmTasks('grunt-contrib-requirejs');
};
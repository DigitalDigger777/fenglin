module.exports = function(grunt) {

    "use strict";

    var projectname = "fenling";

    var optimize = "none"; //uglify|none|test

    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        requirejs: {
            compile_main: {
                options: {
                    baseUrl: '.',
                    name: 'app/Resources/src/fenglin/vendor/almond/almond.js',
                    include: ['app/Resources/src/fenglin/config'],
                    // insertRequire: ['main'],
                    out: 'app/Resources/build/main-build.js',
                    optimize: optimize,
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
                    optimize: optimize,
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
                    optimize: optimize,
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
    });

    grunt.loadNpmTasks('grunt-contrib-requirejs');
};
/**
 * Created by korman on 19.04.17.
 */
({
    baseUrl: '.',
    name: 'vendor/almond/almond.js',
    include: ['config_shopper'],
    // insertRequire: ['main'],
    out: '../../build/main-shopper-build.js',
    optimize: "uglify",
    //optimize: "none",   // If you need to debug the compiled script
    //namespace: "test",  // If using Almond then no need to namespace
    paths: {
        vendor: "vendor",
        admin: "admin",
        consumer: "consumer",
        shopper: "shopper",

        jquery: "vendor/jquery/dist/jquery.min",
        underscore: "vendor/underscore/underscore-min",
        backbone: "vendor/backbone/backbone-min",
        "backbone.radio": "vendor/backbone.radio/build/backbone.radio.min",
        marionette: "vendor/backbone.marionette/lib/backbone.marionette.min",
        zepto: "vendor/zepto/zepto",
        jweixin: "vendor/jweixin-bower/jweixin-1.0.0",
        weui: "vendor/weui.js/dist/weui",
        text: "vendor/text/text",
        "main.shopper": "main_shopper"
    },
    wrap: true
})
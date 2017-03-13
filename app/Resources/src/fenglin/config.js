/**
 * Created by korman on 26.01.17.
 */

requirejs.config({
    urlRoot: 'http://dev.fenglin/app_dev.php/',
    urlArgs: "bust=" + (new Date()).getTime(),
    baseUrl: '/',
    paths: {
        vendor: "/vendor",
        admin: "/fenglin/admin",
        consumer: "/fenglin/consumer",
        shopper: "/fenglin/shopper",

        jquery: "/vendor/jquery/dist/jquery.min",
        underscore: "/vendor/underscore/underscore-min",
        backbone: "/vendor/backbone/backbone-min",
        "backbone.radio": "/vendor/backbone.radio/build/backbone.radio.min",
        marionette: "/vendor/backbone.marionette/lib/backbone.marionette.min",
        zepto: "/vendor/zepto/zepto",
        jweixin: "/vendor/jweixin-bower/jweixin-1.0.0",
        weui: "/vendor/weui.js/dist/weui",
        text: "/vendor/text/text",
        main: "/fenglin/main",
        "main.shopper": "/fenglin/main_shopper",
        "main.admin": "/fenglin/main_admin"
    },
    shim: {
        underscore: {
            exports: '_'
        },
        backbone: {
            deps: [ "underscore", "jquery"],
            exports: "backbone"
        },
        marionette: {
            deps: ["backbone", "backbone.radio"],
            exports: 'marionette'
        }
    },
    waitSeconds: 10
});

console.log(window.location.pathname);

if (/shopper/.test(window.location.pathname)) {

    requirejs(['main.shopper'], function (Fenglin) {
        var fenglin = new Fenglin();
        fenglin.start();
    });
}

if (/consumer/.test(window.location.pathname)) {
    requirejs(['main'], function (Fenglin) {
        var fenglin = new Fenglin();
        fenglin.start();
    });
}

if (/admin/.test(window.location.pathname)) {
    requirejs(['main.admin'], function (Fenglin) {
        var fenglin = new Fenglin();
        fenglin.start();
    });
}
/**
 * Created by korman on 26.01.17.
 */

define([
    'backbone',
    'marionette',
    'admin/routers/ShopperRouter'
], function(Backbone){

    var matchApiKey = /^\?apikey=([\w\W]+?)$/.exec(location.search);
    if (matchApiKey) {
        localStorage.setItem('apikey', matchApiKey[1]);
    }

    if (!localStorage.getItem('apikey')) {
        window.location = Routing.generate('fenglin_login_homepage');
    } else {

        var fenglin = Backbone.Marionette.Application.extend({

            onStart: function (options) {

                Backbone.history.start();


            }
        });

        return fenglin;
    }
});
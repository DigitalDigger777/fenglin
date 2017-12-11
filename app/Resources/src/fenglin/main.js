/**
 * Created by korman on 26.01.17.
 */

define([
    'backbone',
    'marionette',
    'consumer/routers/ConsumerRouter',
    'consumer/routers/ShopperRouter',
    'consumer/routers/RefreeRouter',
    'consumer/routers/StatementRouter'
], function(Backbone){

    var matchApiKey = /^\?apikey=([\w\W]+?)$/.exec(location.search);
    if (matchApiKey) {
        localStorage.setItem('apikey', matchApiKey[1]);
        localStorage.setItem('shopper_apikey', matchApiKey[1]);
    }

    var fenglin = Backbone.Marionette.Application.extend({

        onStart: function(options){

            var token = window.localStorage.getItem('token');
            console.log(token);
            Backbone.history.start();

        }
    });

    return fenglin;
});
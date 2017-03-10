/**
 * Created by korman on 26.01.17.
 */

define([
    'backbone',
    'marionette',
    'admin/routers/ShopperRouter',
    'admin/routers/AdminRouter'
], function(Backbone){


    var fenglin = Backbone.Marionette.Application.extend({

        onStart: function(options){

            var token = window.localStorage.getItem('token');
            console.log(token);
            Backbone.history.start();


        }
    });

    return fenglin;
});
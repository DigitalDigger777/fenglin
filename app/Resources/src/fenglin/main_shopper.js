/**
 * Created by korman on 26.01.17.
 */

define([
    'backbone',
    'marionette',
    'shopper/routers/ShopperRouter',
    'shopper/routers/ConsumerRouter'
], function(Backbone){


    var fenglin = Backbone.Marionette.Application.extend({

        onStart: function(options){

            var token = window.localStorage.getItem('token');
            console.log(token);
            Backbone.history.start();

            if (window.localStorage.getItem('token') !== null) {
                //
                //var receivedList = new ReceivedCollection();
                //
                //receivedList.fetch({
                //    success: function(collection, response){
                //        console.log(collection.toJSON());
                //        var receivedListView = new ReceivedCompositeView({
                //            collection: receivedList
                //        });
                //
                //        receivedListView.render();
                //    },
                //    error: function(collection, response){
                //        console.log('Error');
                //    }
                //});
                //
                //var header = new HeaderView();
                //header.render();
                //
                //var mobileMenu = new MobileMenuView();
                //mobileMenu.render();
            } else {
                //Backbone.history.navigate('#login', true);
                //window.location.hash = '#login'
            }


        }
    });

    return fenglin;
});
/**
 * Created by korman on 29.01.17.
 */


define([
    'backbone',
    'consumer/views/refree/RefreeView',
    'consumer/views/refree/RefreeConfirmView',
    'consumer/models/ShopperModel'
], function(Backbone, RefreeView, RefreeConfirmView, ShopperModel){

    return {
        refreePage: function(shopperId){
            var shopperModel = new ShopperModel();
            shopperModel.set('id', shopperId);
            shopperModel.fetch({
                success: function (model) {
                    var refreeView = new RefreeView({
                        model: model
                    });
                    refreeView.render();
                },
                error: function (model, response) {
                    console.log('error ', response)
                }
            });



        },
        confirmPage: function(shopperId){


            var shopperModel = new ShopperModel();
            shopperModel.set('id', shopperId);
            shopperModel.fetch({
                success: function (model) {
                    var confirmView = new RefreeConfirmView({
                        model: model
                    });
                    confirmView.render();
                },
                error: function (model, response) {
                    console.log('error ', response)
                }
            });
        }
    };
});
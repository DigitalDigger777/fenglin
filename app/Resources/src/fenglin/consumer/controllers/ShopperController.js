/**
 * Created by korman on 27.01.17.
 */

define([
    'consumer/models/ShopperModel',
    'consumer/views/shopper/ShopperDetailView'
], function(ShopperModel, ShopperDetailView){

    // var urlRoot = requirejs.s.contexts._.config.urlRoot;

    return {
        showDetailPage: function(id){
            var model = new ShopperModel();
            model.set('id', id);
            model.fetch({
                success: function(model, response){
                    var shopperDetailView = new ShopperDetailView({
                        model: model
                    });
                    shopperDetailView.render();


                },
                error: function(model, response) {

                }
            });
        },
        shoppeListPage: function(search){

        },
        cashBackStatementPage: function(){

        }
    }
});
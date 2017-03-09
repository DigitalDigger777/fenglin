/**
 * Created by korman on 29.01.17.
 */


define([
    'consumer/views/statement/StatementCompositeView',
    'consumer/collections/StatementCollections',
    'consumer/models/ShopperModel'
], function(StatementCompositeView, StatementCollections, ShopperModel){

    return {
        statementPage: function(id){

            var shopperModel = new ShopperModel();

            shopperModel.set('id', id);
            shopperModel.fetch({
                success: function(shopperModel){
                    var collection = new StatementCollections([], {
                        id: id
                    });

                    collection.fetch({
                        success: function(collection, response){

                            var statementView = new StatementCompositeView({
                                model: shopperModel,
                                collection: collection
                            });
                            statementView.render();

                            console.log('statement page');
                        },
                        error: function(model, response){

                        }
                    });
                },
                error: function(shopperModel){

                }
            });




            //var menu = new MenuView();
            //menu.render();
        }
    };
});
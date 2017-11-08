/**
 * Created by korman on 29.01.17.
 */


define([
    'consumer/views/statement/StatementCompositeView',
    'consumer/collections/StatementCollections',
    'consumer/models/ShopperModel',
    'consumer/views/statement/StatementEmptyView'
], function(StatementCompositeView, StatementCollections, ShopperModel, StatementEmptyView){

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

                            if (collection.length > 0) {
                                var statementView = new StatementCompositeView({
                                    model: shopperModel,
                                    collection: collection
                                });
                                statementView.render();
                            } else {
                                var statementEmptyView = new StatementEmptyView({
                                    model: shopperModel
                                });
                                statementEmptyView.render();
                            }
                            console.log('statement page');
                            console.log(collection.length);
                        },
                        error: function(model, response){
                            console.log('statement error');
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
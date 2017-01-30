/**
 * Created by korman on 29.01.17.
 */


define([
    'consumer/views/statement/StatementCompositeView',
    'consumer/collections/StatementCollections'
], function(StatementCompositeView, StatementCollections){

    return {
        statementPage: function(id){

            var collection = new StatementCollections([], {
                id: id
            });

            collection.fetch({
                success: function(collection, response){
                    var statementView = new StatementCompositeView({
                        collection: collection
                    });
                    statementView.render();

                    console.log('statement page');
                },
                error: function(model, response){

                }
            });


            //var menu = new MenuView();
            //menu.render();
        }
    };
});
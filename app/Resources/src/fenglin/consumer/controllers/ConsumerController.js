/**
 * Created by korman on 27.01.17.
 */

define([
    'consumer/views/shopper/ShopperCompositeView',
    'consumer/collections/ShopperCollections',
    'consumer/views/consumer/MemberIdView',
    'consumer/models/ConsumerModel'
], function(ShopperCompositeView,
            ShopperCollections,
            MemberIdView,
            ConsumerModel){

    var urlRoot = requirejs.s.contexts._.config.urlRoot;

    return {
        getToken: function(){

        },
        memberNumberPage: function(){
            console.log('render member page');
            var consumerModel = new ConsumerModel();
            consumerModel.fetch({
                success: function(model, response){
                    console.log('success response:', response);

                    var memberIdView = new MemberIdView({
                        model: model
                    });
                    memberIdView.render();
                },
                error: function(model, response){
                    console.log(response);
                }
            });

        },
        homePage: function(){
            console.log('Consumer home page');

            var shopperCollection  = new ShopperCollections();
            shopperCollection.fetch();

            var shopperList = new ShopperCompositeView({
                collection: shopperCollection
            });
            shopperList.render();



        }
    }
});
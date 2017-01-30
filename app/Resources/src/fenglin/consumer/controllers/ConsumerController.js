/**
 * Created by korman on 27.01.17.
 */

define([
    'consumer/views/shopper/ShopperCompositeView',
    'consumer/collections/ShopperCollections',
    'consumer/views/consumer/MemberIdView'
], function(ShopperCompositeView,
            ShopperCollections,
            MemberIdView){

    var urlRoot = requirejs.s.contexts._.config.urlRoot;

    return {
        getToken: function(){

        },
        memberNumberPage: function(){
            var memberIdView = new MemberIdView();
            memberIdView.render();

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
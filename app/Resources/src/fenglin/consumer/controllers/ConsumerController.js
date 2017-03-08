/**
 * Created by korman on 27.01.17.
 */

define([
    'consumer/views/shopper/ShopperCompositeView',
    'consumer/collections/ShopperCollections',
    'consumer/views/consumer/MemberIdView',
    'consumer/models/ConsumerModel',
    'consumer/views/core/LoadingToastView',
    'consumer/views/core/ErrorToastView',
    'consumer/views/core/SearchBarView'
], function(ShopperCompositeView,
            ShopperCollections,
            MemberIdView,
            ConsumerModel,
            LoadingToastView,
            ErrorToastView,
            SearchBarView){

    var loadToast  = new LoadingToastView();
    loadToast.render();

    var errorToast = new ErrorToastView();
    errorToast.render();
    console.log(ShopperCompositeView);

    $('#searchBarContainer').empty();
    var searchBarView = new SearchBarView()
    searchBarView.render();

    return {
        getToken: function(){

        },
        memberNumberPage: function(){
            console.log('render member page');
            loadToast.show();
            var consumerModel = new ConsumerModel();
            consumerModel.fetch({
                success: function(model, response){
                    console.log('success response:', response);

                    var memberIdView = new MemberIdView({
                        model: model
                    });
                    memberIdView.render();
                    loadToast.hide();
                },
                error: function(model, response){
                    errorToast.show();
                }
            });

        },
        homePage: function(){
            console.log('Consumer home page');

            loadToast.show();

            var shopperCollection  = new ShopperCollections();
            shopperCollection.fetch({
                success: function(){
                    var shopperList = new ShopperCompositeView({
                        collection: shopperCollection
                    });
                    shopperList.render();
                    loadToast.hide();
                },
                error: function(){
                    errorToast.show();
                }
            });



        }
    }
});
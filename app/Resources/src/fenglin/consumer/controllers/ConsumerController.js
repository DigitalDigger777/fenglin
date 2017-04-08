/**
 * Created by korman on 27.01.17.
 */

define([
    'consumer/views/shopper/ShopperCompositeView',
    'consumer/collections/ShopperCollections',
    'consumer/views/consumer/MemberIdView',
    'consumer/models/ConsumerModel',
    'consumer/views/consumer/JoinToShopperConfirmView',
    'consumer/views/core/LoadingToastView',
    'consumer/views/core/ErrorToastView',
    'consumer/views/core/SearchBarView'
], function(ShopperCompositeView,
            ShopperCollections,
            MemberIdView,
            ConsumerModel,
            JoinToShopperConfirmView,
            LoadingToastView,
            ErrorToastView,
            SearchBarView){

    var loadToast  = new LoadingToastView();
    var errorToast = new ErrorToastView();
    var searchBarView = new SearchBarView()

    var initHome = function(){

        loadToast.render();
        errorToast.render();
        $('#searchBarContainer').empty();
        searchBarView.render();
    };

    return {

        memberNumberPage: function(){
            console.log('render member page');
            loadToast.show();
            var consumerModel = new ConsumerModel();
            consumerModel.fetch({
                success: function(model, response){
                    console.log('success response:', response);
                    var domain = model.get('domain');
                    var memberId = model.get('memberId');

                    var qrSrc = Routing.generate('endroid_qrcode', {
                        text: 'http://' + domain + '/panda-shopper/read-qr/' + memberId,
                        extension: 'gif',
                        size: 250
                    });
                    model.set('qrSrc', qrSrc);

                    var memberIdView = new MemberIdView({
                        model: model
                    });
                    memberIdView.render();
                    loadToast.hide();
                },
                error: function(model, response){
                    loadToast.hide();
                    errorToast.show();
                }
            });

        },
        homePage: function(){
            console.log('Consumer home page');
            initHome();

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
                    loadToast.hide();
                    errorToast.show();
                }
            });
        },
        joinToShopper: function(shopperId){
            var consumerModel = new ConsumerModel();
            consumerModel.set('shopperId', shopperId);

            consumerModel.joinToShopper(function(){
                var joinToShopperConfirmView = new JoinToShopperConfirmView({
                    model: consumerModel
                });
                joinToShopperConfirmView.render();

            }, function () {
                errorToast.show();
                setTimeout(function () {
                    errorToast.hide();
                }, 3000);
            });

        }

    }
});
/**
 * Created by korman on 28.01.17.
 */

define([
    'shopper/views/shopper/ShopperHomeView',
    'shopper/views/shopper/SettingView',
    'shopper/views/cash_back/CashBackStatementCompositeView',
    'shopper/collections/CashBackConfirmCollection',
    'shopper/collections/CashBackStatementCollection',
    'shopper/views/cash_back/CashBackConfirmCompositeView',
    'consumer/models/ShopperModel',
    'consumer/views/core/ErrorToastView',
    'consumer/views/core/LoadingToastView',
    'shopper/views/shopper/ShopperChangePasswordView',
    'shopper/views/shopper/ShopperQRView'
], function(ShopperHomeView,
            SettingView,
            CashBackStatementCompositeView,
            CashBackConfirmCollection,
            CashBackStatementCollection,
            CashBackConfirmCompositeView,
            ShopperModel,
            ErrorToastView,
            LoadingToastView,
            ShopperChangePasswordView,
            ShopperQRView){

    var loadToast = new LoadingToastView();
    var errorToast = new ErrorToastView();

    loadToast.render();
    errorToast.render();

    return {
        homePage: function(){
            console.log('home page');
            var shopperHomeView = new ShopperHomeView();
            shopperHomeView.render();
        },
        cashBackStatementPage: function(){
            var cashBackStatementCollection = new CashBackStatementCollection();
            //var cashBackConfirmCollection = new CashBackConfirmCollection();
            cashBackStatementCollection.fetch({
                success: function(collection, response){
                    var statement = new CashBackStatementCompositeView({
                        collection: collection
                    });
                    statement.render();
                },
                error: function(collection, response){

                }
            });

        },
        cashBackConfirm: function(){
            var cashBackConfirmCollection = new CashBackConfirmCollection();
            cashBackConfirmCollection.fetch({
                success: function(collection, response){
                    var confirm = new CashBackConfirmCompositeView({
                        collection: collection
                    });
                    confirm.render();
                },
                error: function(collection, response){

                }
            });
        },
        settingPage: function(){
            console.log('setting page');

            var shopperModel = new ShopperModel();
            shopperModel.fetchCurrentShopper(function(model){

                var setting = new SettingView({
                    model:model
                });
                setting.render();

                loadToast.hide();

            }, function(){
                errorToast.show();
                loadToast.hide();
                setTimeout(function(){
                    errorToast.hide();
                }, 3000);
            });
        },
        changePasswordPage: function (shopperId) {
            var shopperModel = new ShopperModel();
            shopperModel.set('id', shopperId);

            shopperModel.fetch({
                success: function (model) {
                    var shopperChangePasswordView = new ShopperChangePasswordView({
                        model: model
                    });
                    shopperChangePasswordView.render();
                }
            });

        },
        qrPage: function (shopperId) {
            var shopperModel = new ShopperModel();
            shopperModel.set('id', shopperId);

            shopperModel.fetch({
                success: function (model) {

                    var shopperQRView = new ShopperQRView({
                        model: model
                    });
                    shopperQRView.render();
                }
            });

        }
    };
});

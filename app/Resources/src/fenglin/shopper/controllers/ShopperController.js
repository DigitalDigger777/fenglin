/**
 * Created by korman on 28.01.17.
 */

define([
    'backbone',
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
    'shopper/views/shopper/ShopperChangeDescriptionView',
    'shopper/views/shopper/ShopperQRView'
], function(Backbone,
            ShopperHomeView,
            SettingView,
            CashBackStatementCompositeView,
            CashBackConfirmCollection,
            CashBackStatementCollection,
            CashBackConfirmCompositeView,
            ShopperModel,
            ErrorToastView,
            LoadingToastView,
            ShopperChangePasswordView,
            ShopperChangeDescriptionView,
            ShopperQRView){

    var loadToast = new LoadingToastView();
    var errorToast = new ErrorToastView();

    loadToast.render();
    errorToast.render();

    return {
        homePage: function(){
            console.log('home page');


            $.ajax({
                url: Routing.generate('panda_shopper_statistic_rest_index'),
                dataType: 'json',
                method: 'GET',
                data: {
                    method: 'GET_TOTAL_SPENT',
                    apikey: window.localStorage.getItem('apikey')
                },
                success: function(data){

                    var model = new Backbone.Model(data);
                    var shopperHomeView = new ShopperHomeView({
                        model: model
                    });
                    shopperHomeView.render();
                },
                error: function(error){
                    console.log(error);
                }
            })

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
        changeDescriptionPage: function (shopperId) {
            var shopperModel = new ShopperModel();
            shopperModel.set('id', shopperId);

            shopperModel.fetch({
                success: function (model) {
                    var shopperChangeDescriptionView = new ShopperChangeDescriptionView({
                        model: model
                    });
                    shopperChangeDescriptionView.render();
                }
            });

        },
        qrPage: function (shopperId) {
            var shopperModel = new ShopperModel();
            shopperModel.set('id', shopperId);

            shopperModel.fetch({
                success: function (model) {
                    var domain = model.get('domain');
                    var id = model.get('id');

                    var qrSrc = Routing.generate('endroid_qrcode', {
                        text: 'http://' + domain + '/panda-consumer/read-qr/' + id,
                        extension: 'gif',
                        size: 250
                    });
                    model.set('qrSrc', qrSrc);
                    var shopperQRView = new ShopperQRView({
                        model: model
                    });
                    shopperQRView.render();
                }
            });

        }
    };
});

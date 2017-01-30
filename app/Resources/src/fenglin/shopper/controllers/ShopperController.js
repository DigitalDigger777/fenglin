/**
 * Created by korman on 28.01.17.
 */

define([
    'shopper/views/shopper/ShopperHomeView',
    'shopper/views/shopper/SettingView',
    'shopper/views/cash_back/CashBackStatementCompositeView',
    'shopper/collections/CashBackConfirmCollection',
    'shopper/collections/CashBackStatementCollection',
    'shopper/views/cash_back/CashBackConfirmCompositeView'
], function(ShopperHomeView,
            SettingView,
            CashBackStatementCompositeView,
            CashBackConfirmCollection,
            CashBackStatementCollection,
            CashBackConfirmCompositeView){
    var urlRoot = requirejs.s.contexts._.config.urlRoot;

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

            var setting = new SettingView();
            setting.render();
        }
    };
});

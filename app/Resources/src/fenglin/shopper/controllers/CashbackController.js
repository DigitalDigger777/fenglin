/**
 * Created by korman on 28.01.17.
 */

define([
    'backbone',
    'shopper/views/consumer/ConsumerSearchView',
    'consumer/models/ConsumerModel',
    'shopper/views/cash_back/CashBackConfirmCompositeView',
    'shopper/collections/CashBackConfirmCollection',
    'consumer/views/core/ErrorToastView',
    'consumer/views/core/LoadingToastView',
], function(Backbone,
            ConsumerSearchView,
            ConsumerModel,
            CashBackConfirmCompositeView,
            CashBackConfirmCollection,
            ErrorToastView,
            LoadingToastView
){


    var loadToast = new LoadingToastView();
    var errorToast = new ErrorToastView();

    loadToast.render();
    errorToast.render();

    return {
        confirm: function(transactionId){
            loadToast.show();
            var cashBackConfirmCollection = new CashBackConfirmCollection([], {transactionId:transactionId});
            cashBackConfirmCollection.fetch({
                success: function(collection, response){
                    var model = new Backbone.Model({
                        balance: window.localStorage.getItem('member_total_amount')
                    });
                    var cashBackConfirmCompositeView = new CashBackConfirmCompositeView({
                        collection: collection,
                        model: model
                    });
                    cashBackConfirmCompositeView.render();
                    loadToast.hide();
                },
                error: function(){
                    loadToast.hide();
                    errorToast.show();
                    setTimeout(function(){
                        errorToast.hide();
                    }, 3000);
                }
            });

        }
    };
});

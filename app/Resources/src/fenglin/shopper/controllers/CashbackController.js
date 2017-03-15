/**
 * Created by korman on 28.01.17.
 */

define([
    'shopper/views/consumer/ConsumerSearchView',
    'consumer/models/ConsumerModel',
    'shopper/views/cash_back/CashBackConfirmCompositeView',
    'shopper/collections/CashBackConfirmCollection',
    'consumer/views/core/ErrorToastView',
    'consumer/views/core/LoadingToastView',
], function(ConsumerSearchView,
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
        confirm: function(memberId){
            loadToast.show();
            var cashBackConfirmCollection = new CashBackConfirmCollection();
            cashBackConfirmCollection.fetch({
                success: function(collection, response){
                    var cashBackConfirmCompositeView = new CashBackConfirmCompositeView({
                        collection: collection
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

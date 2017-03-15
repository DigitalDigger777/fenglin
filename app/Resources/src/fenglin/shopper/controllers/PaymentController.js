/**
 * Created by korman on 28.01.17.
 */

define([
    'shopper/views/consumer/ConsumerSearchView',
    'consumer/models/ShopperModel',
    'shopper/views/payment/PaymentCalculateView',
    'shopper/views/payment/PaymentConfirmView',
    'consumer/views/core/ErrorToastView',
    'consumer/views/core/LoadingToastView',
], function(ConsumerSearchView,
            ShopperModel,
            PaymentCalculateView,
            PaymentConfirmView,
            ErrorToastView,
            LoadingToastView
){


    var loadToast = new LoadingToastView();
    var errorToast = new ErrorToastView();

    loadToast.render();
    errorToast.render();

    return {
        calculate: function(){
            loadToast.show();
            var shopperModel = new ShopperModel();
            shopperModel.fetchCurrentShopper(function(model){
                console.log(model.toJSON());
                var paymentView = new PaymentCalculateView({
                    model: model
                });
                paymentView.render();
                loadToast.hide();

            }, function(){
                errorToast.show();
                loadToast.hide();
                setTimeout(function(){
                    errorToast.hide();
                }, 3000);
            });

        },
        confirm: function(){


            var shopperModel = new ShopperModel();
            shopperModel.fetchCurrentShopper(function(model){
                var memberTotalAmount = window.localStorage.getItem('member_total_amount');

                model.set('member_total_amount', memberTotalAmount);

                var paymentConfirmView = new PaymentConfirmView({
                    model: model
                });
                paymentConfirmView.render();
                loadToast.hide();

            }, function(){
                errorToast.show();
                loadToast.hide();
                setTimeout(function(){
                    errorToast.hide();
                }, 3000);
            });
        }
    };
});

/**
 * Created by korman on 28.01.17.
 */

define([
    'shopper/views/consumer/ConsumerSearchView',
    'consumer/models/ConsumerModel',
    'shopper/views/payment/PaymentCalculateView',
    'shopper/views/payment/PaymentConfirmView',
    'consumer/views/core/ErrorToastView',
    'consumer/views/core/LoadingToastView',
], function(ConsumerSearchView,
            ConsumerModel,
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
            var paymentView = new PaymentCalculateView();
            paymentView.render();
        },
        confirm: function(){
            var paymentConfirmView = new PaymentConfirmView();
            paymentConfirmView.render();
        }
    };
});

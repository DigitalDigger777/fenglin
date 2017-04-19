/**
 * Created by korman on 28.01.17.
 */

define([
    'shopper/views/consumer/ConsumerSearchView',
    'consumer/models/ConsumerModel',
    'consumer/views/core/ErrorToastView',
    'consumer/views/core/LoadingToastView'
], function(ConsumerSearchView, ConsumerModel, ErrorToastView, LoadingToastView){
    // var urlRoot = requirejs.s.contexts._.config.urlRoot;

    var loadToast = new LoadingToastView();
    var errorToast = new ErrorToastView();

    loadToast.render();
    errorToast.render();

    return {
        search: function(memberId){
            console.log('consumer search page');
            //var memberId = $('#searchConsumer').val()
            //console.log(memberId);

            loadToast.show();
            var consumerModel = new ConsumerModel();
            consumerModel.set('memberId', memberId);

            console.log(consumerModel.toJSON());

            consumerModel.fetchByMemberId(function(model){
                loadToast.hide();
                //set balance
                var memberId = model.get('id');
                var amountConsumers = model.get('amountConsumers');
                var totalAmount = amountConsumers[0].totalAmount;

                if (amountConsumers.length > 0) {
                    window.localStorage.setItem('member_total_amount', parseFloat(totalAmount));
                } else {
                    window.localStorage.setItem('member_total_amount', 0);
                }
                window.localStorage.setItem('member_id', memberId);
                //end set balance

                var consumerSearchView = new ConsumerSearchView({
                    model: model
                });
                consumerSearchView.render();
            }, function(){
                loadToast.hide();
                errorToast.show();

                setTimeout(function(){
                    errorToast.hide();
                }, 3000);
            });

        }
    };
});

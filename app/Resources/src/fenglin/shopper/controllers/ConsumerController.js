/**
 * Created by korman on 28.01.17.
 */

define([
    'shopper/views/consumer/ConsumerSearchView',
    'consumer/models/ConsumerModel',
    'consumer/views/core/ErrorToastView',
    'consumer/views/core/LoadingToastView'
], function(ConsumerSearchView, ConsumerModel, ErrorToastView, LoadingToastView){
    var urlRoot = requirejs.s.contexts._.config.urlRoot;

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

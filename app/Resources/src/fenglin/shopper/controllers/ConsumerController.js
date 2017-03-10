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
        search: function(){
            console.log('consumer search page');
            var memberId = $('#searchConsumer').val()
            //var reg = /0+?([1-9]+)/;
            //var memberIdParts = reg.exec(memberId);


            //if (memberIdParts !== null && memberIdParts[1] !== undefined) {
                loadToast.show();
                var consumerModel = new ConsumerModel();
                consumerModel.set('memberId', memberId);

                consumerModel.fetchByMemberId(function(model){
                    loadToast.hide();
                    var consumerSearchView = new ConsumerSearchView({
                        model: model
                    });
                    consumerSearchView.render();
                }, function(){
                    errorToast.show();
                });


                //consumerModel.fetch({
                //    success: function (model, response) {
                //        loadToast.hide();
                //        var consumerSearchView = new ConsumerSearchView({
                //            model: model
                //        });
                //        consumerSearchView.render();
                //    },
                //    error: function (model, response) {
                //        errorToast.show();
                //    }
                //});
            //} else {
            //    window.location.hash = 'shopper/home';
            //}
        }
    };
});

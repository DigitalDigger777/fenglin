/**
 * Created by korman on 27.01.17.
 */

define(['marionette',
    'consumer/views/core/MenuView',
    'consumer/models/ConsumerModel',
    'consumer/views/core/ErrorToastView',
    'consumer/views/core/SuccessToastView',
    'consumer/views/core/LoadingToastView',
    'consumer/views/consumer/JoinToShopperConfirmView',
    'consumer/routers/RefreeRouter'
], function(
        Marionette, MenuView, ConsumerModel,
        ErrorToastView, SuccessToastView, LoadingToastView,
        JoinToShopperConfirmView, RefreeRouter){

    var errorToast = new ErrorToastView();
    var successToast = new SuccessToastView();
    var loadingToast = new LoadingToastView();

    errorToast.render();
    successToast.render();
    loadingToast.render();

    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#refreeView',
        ui: {
            inviteConsumer: '#inviteConsumer'
        },
        events: {
            'click @ui.inviteConsumer': function(e){
                e.preventDefault();
                var shopperId = $('#shopperId').val();
                var memberId = $('#memberId').val();

                var consumerModel = new ConsumerModel();

                if (memberId != '') {

                    consumerModel.set('shopperId', shopperId);
                    consumerModel.set('consumerId', memberId);

                    loadingToast.show();
                    consumerModel.joinRefree(function () {
                        loadingToast.hide();
                        window.location.hash = '#consumer/refree/join/confirm/' + shopperId;
                        // successToast.show();
                        // setTimeout(function () {
                        //     successToast.hide();
                        // }, 3000);
                    }, function () {
                        loadingToast.hide();
                        errorToast.show();
                        setTimeout(function () {
                            errorToast.hide();
                        }, 3000);
                    });
                } else {

                    consumerModel.set('shopperId', shopperId);

                    consumerModel.joinToShopper(function(){
                        // var joinToShopperConfirmView = new JoinToShopperConfirmView({
                        //     model: consumerModel
                        // });
                        // joinToShopperConfirmView.render();

                        window.location.hash = '#consumer/refree/join/confirm/' + shopperId;

                    }, function () {
                        errorToast.show();
                        setTimeout(function () {
                            errorToast.hide();
                        }, 3000);
                    });
                    //
                    // successToast.show();
                    //
                    // setTimeout(function () {
                    //     successToast.hide();
                    // }, 3000);
                }
            }
        },
        onRender: function(){
            console.log('Render refree');
            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var menu = new MenuView();
            menu.render();
        }
    });
});
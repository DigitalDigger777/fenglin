/**
 * Created by korman on 27.01.17.
 */

define(['marionette',
    'consumer/views/core/MenuView',
    'consumer/models/ConsumerModel',
    'consumer/views/core/ErrorToastView',
    'consumer/views/core/SuccessToastView',
    'consumer/views/core/LoadingToastView'], function(
        Marionette, MenuView, ConsumerModel,
        ErrorToastView, SuccessToastView, LoadingToastView){

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

                if (memberId != '') {
                    var consumerModel = new ConsumerModel();
                    consumerModel.set('shopperId', shopperId);
                    consumerModel.set('consumerId', memberId);

                    loadingToast.show();
                    consumerModel.joinRefree(function () {
                        loadingToast.hide();
                        successToast.show();
                        setTimeout(function () {
                            successToast.hide();
                        }, 3000);
                    }, function () {
                        loadingToast.hide();
                        errorToast.show();
                        setTimeout(function () {
                            errorToast.hide();
                        }, 3000);
                    });
                } else {
                    successToast.show();
                    setTimeout(function () {
                        successToast.hide();
                    }, 3000);
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
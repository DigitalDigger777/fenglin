/**
 * Created by korman on 27.01.17.
 */

define([
    'marionette',
    'consumer/models/ConsumerModel',
    'consumer/views/core/ErrorToastView'
], function(Marionette, ConsumerModel, ErrorToastView){
    var errorToast = new ErrorToastView();

    return Marionette.View.extend({
        tagName: 'div',
        className: 'weui-panel weui-panel_access',
        template: '#shopperItemView',
        ui: {
            joinToShopper: '[shopper-id]'
        },
        events: {
            'click @ui.joinToShopper': function(e){
                e.preventDefault();

                $('#contentContainer').off('click', '#inviteConsumer');

                console.log(e);
                var shopperId = $(e.currentTarget).attr('shopper-id');

                var consumerModel = new ConsumerModel();

                consumerModel.set('shopperId', shopperId);

                consumerModel.joinToShopper(function(){

                    window.location.hash = '#consumer/refree/join/confirm/' + shopperId;

                }, function () {
                    errorToast.show();
                    setTimeout(function () {
                        errorToast.hide();
                    }, 3000);
                });
            }
        },
        onRender: function(){
            console.log('Render shopper item');
        }
    });
});
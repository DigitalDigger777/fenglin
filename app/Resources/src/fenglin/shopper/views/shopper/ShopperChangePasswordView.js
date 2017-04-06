/**
 * Created by korman on 27.01.17.
 */

define([
    'backbone',
    'marionette',
    'shopper/views/core/MenuHomeView',
    'consumer/models/ShopperModel',
    'consumer/views/core/LoadingToastView',
    'consumer/views/core/ErrorToastView',
    'consumer/views/core/SuccessToastView',
    'consumer/views/core/CustomToastView'
], function(
    Backbone,
    Marionette,
    MenuHomeView,
    ShopperModel,
    LoadingToastView,
    ErrorToastView,
    SuccessToastView,
    CustomToastView
){
    var loadToast  = new LoadingToastView();
    loadToast.render();

    var errorToast = new ErrorToastView();
    errorToast.render();

    var successToast = new SuccessToastView();
    successToast.render();


    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#shopperChangePasswordView',
        ui: {
            savePasswordButton: '#savePasswordButton'
        },
        events: {
            'click @ui.savePasswordButton': function(e){
                e.preventDefault();
                console.log('click');
                loadToast.show();

                var _self           = this;
                var shopperId       = $('#shopperId').val();
                var password        = $('#password').val();
                var retryPassword   = $('#retryPassword').val();

                var shopperModel = new ShopperModel();

                if (shopperId != 0) {

                    if (password == retryPassword && password.length >= 6) {
                        shopperModel.set('id', shopperId);
                        shopperModel.fetch({
                            success: function (model) {
                                model.set('openPassword', password);
                                model.save(null, {
                                    success: function () {
                                        loadToast.hide();
                                        _self.customToast('密码修改成功。', 'weui-icon-success-no-circle');
                                    },
                                    error: function () {
                                        loadToast.hide();
                                        errorToast.show();
                                        setTimeout(function(){
                                            errorToast.hide();
                                        }, 3000);
                                    }
                                });
                            },
                            error: function (model) {
                                loadToast.hide();
                                errorToast.show();
                                setTimeout(function(){
                                    errorToast.hide();
                                }, 3000);
                            }
                        });
                    } else {
                        loadToast.hide();
                        _self.customToast('密码最少6位', 'weui-icon-warn');
                    }
                }


            }
        },
        customToast: function(message, className){
            var modelToast = new Backbone.Model({
                className: className,
                message: message
            });

            var customToastView = new CustomToastView({
                model: modelToast
            });
            customToastView.render();
            customToastView.show();
            setTimeout(function(){
                customToastView.hide();
            }, 3000);
        },
        onRender: function(){
            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var menu = new MenuHomeView();
            menu.render();

            $('#uploaderInput').change(function(){
                var fd = new FormData();
                fd.append("photo", $('input[type=file]')[0].files[0]);
                $.ajax({
                    url: Routing.generate('panda_shopper_rest_upload'),
                    type: "POST",
                    data: fd,
                    processData: false,  // tell jQuery not to process the data
                    contentType: false   // tell jQuery not to set contentType
                }).done(function( data ) {
                    console.log("PHP Output:");
                    console.log( data );
                    $('#previewImage').attr('src', '/uploads/shoppers/' + data[0]);
                    $('#previewImage').attr('data-src', data[0]);
                });
            });

        },
        initialize: function () {
            //$('#contentContainer').off('click', '#saveShopperButton');
        }
    });
});
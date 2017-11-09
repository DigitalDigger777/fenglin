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
        template: '#shopperChangeDescriptionView',
        ui: {
            saveDescriptionButton: '#saveDescriptionButton'
        },
        events: {
            'click @ui.saveDescriptionButton': function(e){
                e.preventDefault();
                console.log('click');
                loadToast.show();

                var _self           = this;
                var shopperId       = $('#shopperId').val();
                var description     = $('#description').val();

                var shopperModel = new ShopperModel();

                if (shopperId != 0) {

                    shopperModel.set('id', shopperId);
                    shopperModel.fetch({
                        success: function (model) {
                            model.set('description', description);
                            model.save(null, {
                                success: function () {
                                    loadToast.hide();
                                    _self.customToast('商户介绍修改成功！', 'weui-icon-success-no-circle');
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


        },
        initialize: function () {
            //$('#contentContainer').off('click', '#saveShopperButton');
        }
    });
});
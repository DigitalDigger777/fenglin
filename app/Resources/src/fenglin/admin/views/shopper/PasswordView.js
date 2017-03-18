/**
 * Created by korman on 27.01.17.
 */

define(['marionette',
        'admin/views/core/AdminMenuView',
        'consumer/models/ShopperModel',
        'admin/views/shopper/PasswordView',
        'consumer/views/core/LoadingToastView',
        'consumer/views/core/ErrorToastView',
        'consumer/views/core/SuccessToastView'], function(Marionette,
                                                        AdminMenuView,
                                                        ShopperModel,
                                                        PasswordView,
                                                        LoadingToastView,
                                                        ErrorToastView,
                                                        SuccessToastView){
    var loadToast  = new LoadingToastView();
    loadToast.render();

    var errorToast = new ErrorToastView();
    errorToast.render();

    var successToast = new SuccessToastView();
    successToast.render();

    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#passwordPageView',

        onRender: function(){
            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var menu = new AdminMenuView();
            menu.render();
        }
    });
});
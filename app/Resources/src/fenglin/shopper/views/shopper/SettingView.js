/**
 * Created by korman on 27.01.17.
 */

define([
    'marionette',
    'shopper/views/core/MenuHomeView',
    'consumer/models/ShopperModel',
    'consumer/views/core/LoadingToastView',
    'consumer/views/core/ErrorToastView',
    'consumer/views/core/SuccessToastView'
], function(
    Marionette,
    MenuHomeView,
    ShopperModel,
    LoadingToastView,
    ErrorToastView,
    SuccessToastView
){
    var loadToast  = new LoadingToastView();
    loadToast.render();

    var errorToast = new ErrorToastView();
    errorToast.render();

    var successToast = new SuccessToastView();
    successToast.render();

    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#settingView',
        ui: {
            saveButton: '#saveShopperButton'
        },
        events: {
            'click @ui.saveButton': function(e){
                e.preventDefault();
                console.log('click');
                loadToast.show();

                var shopperId = $('#shopperId').val();
                var name = $('#name').val();
                var address = $('#address').val();
                var tel = $('#tel').val();
                var schedule = $('#schedule').val();
                var rebate_level_1 = $('#rebate_level_1').val();
                var rebate_level_2 = $('#rebate_level_2').val();
                var rebate_level_3 = $('#rebate_level_3').val();

                var shopperModel = new ShopperModel();

                if (shopperId != 0) {
                    shopperModel.set('id', shopperId);
                }

                shopperModel.set('name', name);
                shopperModel.set('address', address);
                shopperModel.set('tel', tel);
                shopperModel.set('schedule', schedule);
                shopperModel.set('rebateLevelRate', rebate_level_1.replace('%',''));
                shopperModel.set('rebateLevel2Rate', rebate_level_2.replace('%',''));
                shopperModel.set('rebateLevel3Rate', rebate_level_3.replace('%',''));

                shopperModel.save(null, {
                    success: function(data){
                        console.log(data);
                        loadToast.hide();
                        successToast.show();
                        $('#shopperId').val(data.id);
                        setTimeout(function(){
                            successToast.hide();
                        }, 2000);

                    },
                    error: function(error){
                        console.log(error);
                        loadToast.hide();
                        errorToast.show();
                        setTimeout(function(){
                            errorToast.hide();
                        }, 3000);
                    }
                });
            }
        },
        onRender: function(){
            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var menu = new MenuHomeView();
            menu.render();
        }
    });
});
/**
 * Created by korman on 27.01.17.
 */

define(['marionette',
        'admin/views/core/AdminMenuView',
        'consumer/models/ShopperModel'], function(Marionette, AdminMenuView, ShopperModel){
    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#newShopperView',
        ui: {
            saveButton: '#saveShopperButton'
        },
        events: {
            'click @ui.saveButton': function(e){
                e.preventDefault();
                console.log('click');
                var name = $('#name').val();
                var address = $('#address').val();
                var tel = $('#tel').val();
                var schedule = $('#schedule').val();
                var rebate_level_1 = $('#rebate_level_1').val();
                var rebate_level_2 = $('#rebate_level_2').val();
                var rebate_level_3 = $('#rebate_level_3').val();

                var shopperModel = new ShopperModel();
                shopperModel.set('name', name);
                shopperModel.set('address', address);
                shopperModel.set('tel', tel);
                shopperModel.set('schedule', schedule);
                shopperModel.set('rebate_level_1', rebate_level_1);
                shopperModel.set('rebate_level_2', rebate_level_2);
                shopperModel.set('rebate_level_3', rebate_level_3);

                shopperModel.save(null, {
                    success: function(data){
                        console.log(data);
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
        },
        onRender: function(){
            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var menu = new AdminMenuView();
            menu.render();
        }
    });
});
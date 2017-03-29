/**
 * Created by korman on 27.01.17.
 */

define([
    'marionette',
    'admin/views/shopper/InactiveReactiveItemView',
    'admin/views/core/AdminMenuView',
    'consumer/models/ShopperModel'
], function(Marionette, InactiveReactiveItemView, AdminMenuView, ShopperModel){

    return Marionette.CompositeView.extend({
        el: '#contentContainer',
        childView: InactiveReactiveItemView,
        childViewContainer: '#shopperResultContainer',
        template: '#inactiveReactiveAccountView',
        ui: {
            searchInput: '#searchShopperInput',
            activeButton: '[data-active-button]'
        },
        events: {
            'change @ui.searchInput': function(e){
                var val = $(e.currentTarget).val();
                $('#searchShopperButton').attr('href', '#admin/shopper/search/' + val);
                console.log(val);
            },
            'click @ui.activeButton': function (e) {
                e.preventDefault();
                var id = $(e.currentTarget).attr('data-active-button');
                var shopperModel = new ShopperModel();
                shopperModel.set('id', id);
                shopperModel.fetch({
                    success: function (model) {
                        console.log(model.toJSON());
                        if ($(e.currentTarget).hasClass('weui-btn_warn')) {
                            $(e.currentTarget).removeClass('weui-btn_warn');
                            $(e.currentTarget).addClass('weui-btn_primary');

                            model.set('status', 0);
                        } else {
                            $(e.currentTarget).removeClass('weui-btn_primary');
                            $(e.currentTarget).addClass('weui-btn_warn');

                            model.set('status', 1);
                        }
                        model.save();

                    },
                    error: function (model) {

                    }
                });
                console.log(id);
            }
        },
        onRender: function(){
            console.log('Render shopper composite view');


            $('#paginationContainer').empty();
            $('#menuContainer').empty();



            // var paginationView = new PaginationView();
            // paginationView.render();

            var menu = new AdminMenuView();
            menu.render();

        }
    });
});
/**
 * Created by korman on 27.01.17.
 */

define(['marionette', 'admin/views/core/AdminMenuView'], function(Marionette, AdminMenuView){
    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#inactiveReactiveAccountView',
        ui: {
            searchInput: '#searchShopperInput'
        },
        events: {
            'change @ui.searchInput': function(e){
                var val = $(e.currentTarget).val();
                $('#searchShopperButton').attr('href', '#admin/shopper/search/' + val);
                console.log(val);
            }
        },
        onRender: function(){
            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();
            console.log('render inactive reactive');
            var menu = new AdminMenuView();
            menu.render();
        }
    });
});
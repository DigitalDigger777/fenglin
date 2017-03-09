/**
 * Created by korman on 27.01.17.
 */

define(['marionette', 'shopper/views/core/AdminMenuView'], function(Marionette, AdminMenuView){
    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#newShopperView',
        onRender: function(){
            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var menu = new AdminMenuView();
            menu.render();
        }
    });
});
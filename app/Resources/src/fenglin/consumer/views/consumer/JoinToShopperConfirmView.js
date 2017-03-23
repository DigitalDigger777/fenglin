/**
 * Created by korman on 28.01.17.
 */

define(['marionette',
        'consumer/views/core/MenuView'
], function(Marionette, MenuView) {
    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#joinToShopperConfirmView',
        onRender: function(){
            console.log('Join to shopper confirm');

            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            //var model = new ConsumerModel();

            var menuView = new MenuView();
            menuView.render();

        }
    });
});
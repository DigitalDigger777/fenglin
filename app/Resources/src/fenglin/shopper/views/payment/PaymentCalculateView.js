/**
 * Created by korman on 27.01.17.
 */

define(['marionette',
    'shopper/views/core/MenuHomeView'
], function(Marionette, MenuHomeView){
    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#paymentCalculateView',
        onRender: function(){
            console.log('payment calculate');
            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var menu = new MenuHomeView();
            menu.render();

        }
    });
});
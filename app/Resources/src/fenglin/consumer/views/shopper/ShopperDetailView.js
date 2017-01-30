/**
 * Created by korman on 27.01.17.
 */

define(['marionette', 'consumer/views/core/MenuView'], function(Marionette, MenuView){
    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#shopperDetailView',
        onRender: function(){
            console.log('Render shopper detail');
            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var menu = new MenuView();
            menu.render();
        }
    });
});
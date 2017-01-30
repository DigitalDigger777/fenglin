/**
 * Created by korman on 27.01.17.
 */

define([
    'marionette',
    'consumer/views/shopper/ShopperItemView',
    'consumer/views/core/SearchBarView',
    'consumer/views/core/MenuHomeView',
    'consumer/views/core/PaginationView'
], function(Marionette, ShopperItemView, SearchBarView, MenuHomeView, PaginationView){

    return Marionette.CompositeView.extend({
        el: '#contentContainer',
        childView: ShopperItemView,
        childViewContainer: '#shopperList',
        template: '#shopperListView',
        onRender: function(){
            console.log('Render shopper composite view');

            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var searchBarView = new SearchBarView()
            searchBarView.render();

            var paginationView = new PaginationView();
            paginationView.render();

            var menu = new MenuHomeView();
            menu.render();

        }
    });
});
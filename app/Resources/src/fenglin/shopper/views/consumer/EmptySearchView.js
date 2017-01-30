/**
 * Created by korman on 27.01.17.
 */

define(['marionette',
        'shopper/views/core/MenuHomeView',
        'shopper/views/core/SearchBarView'
], function(Marionette, MenuHomeView, SearchBarView){
    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#emptySearchView',
        onRender: function(){
            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var menu = new MenuHomeView();
            menu.render();

            var searchBar = new SearchBarView();
            searchBar.render();
        }
    });
});
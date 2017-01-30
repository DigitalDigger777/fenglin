/**
 * Created by korman on 27.01.17.
 */

define(['marionette'], function(Marionette){
    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#emptySearchView',
        onRender: function(){
            console.log('Render empty search');
            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();
        }
    });
});
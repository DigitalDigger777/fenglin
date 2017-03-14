/**
 * Created by korman on 27.01.17.
 */

define(['marionette'], function(Marionette){
    return Marionette.View.extend({
        el:'#shopperResultContainer',
        template: '#shopperSearchResultView',
        onRender: function(){
            console.log('Render search');
            //$('#searchBarContainer').empty();
            //$('#paginationContainer').empty();
            //$('#menuContainer').empty();
        }
    });
});
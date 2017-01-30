/**
 * Created by korman on 27.01.17.
 */

define(['marionette'], function(Marionette){
    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#refreeConfirmView',
        onRender: function(){
            console.log('Render Refree confirm view');

            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();
        }
    });
});
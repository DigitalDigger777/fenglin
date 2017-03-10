/**
 * Created by korman on 27.01.17.
 */

define(['marionette'], function(Marionette){
    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#adminLoginView',
        onRender: function(){
            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

        }
    });
});
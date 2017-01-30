/**
 * Created by korman on 28.01.17.
 */

define(['marionette',
        'consumer/views/core/MenuMemberIdView'
], function(Marionette, MenuMemberIdView) {
    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#memberIdView',
        onRender: function(){
            console.log('Render member id');

            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var menuMemberIdView = new MenuMemberIdView();
            menuMemberIdView.render();

        }
    });
});
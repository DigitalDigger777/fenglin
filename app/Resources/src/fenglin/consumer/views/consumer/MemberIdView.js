/**
 * Created by korman on 28.01.17.
 */

define(['marionette',
        'consumer/views/core/MenuMemberIdView',
        'consumer/models/ConsumerModel'
], function(Marionette, MenuMemberIdView, ConsumerModel) {
    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#memberIdView',
        onRender: function(){
            console.log('Render member id');

            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var model = new ConsumerModel();

            var menuMemberIdView = new MenuMemberIdView();
            menuMemberIdView.render();

        }
    });
});
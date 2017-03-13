/**
 * Created by korman on 29.01.17.
 */

define(['marionette', 'shopper/views/core/MenuHomeView'], function(Marionette, MenuHomeView){
    return Marionette.View.extend({
        el:'#contentContainer',
        template: '#shopperHomeView',
        ui: {
            searchInput: '#searchConsumer'
        },
        events: {
            'change @ui.searchInput': function(e){
                var memberId = $(e.currentTarget).val();
                $('#searchConsumerButton').attr('href', '#consumer/search/' + memberId);
            }
        },
        onRender: function(){
            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var menu = new MenuHomeView();
            menu.render();
        }
    });
});
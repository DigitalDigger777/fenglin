/**
 * Created by korman on 27.01.17.
 */

define([
    'marionette',
    'admin/views/shopper/InactiveReactiveItemView',
    'admin/views/core/AdminMenuView'
], function(Marionette, InactiveReactiveItemView, AdminMenuView, PaginationView){

    return Marionette.CompositeView.extend({
        el: '#contentContainer',
        childView: InactiveReactiveItemView,
        childViewContainer: '#shopperResultContainer',
        template: '#inactiveReactiveAccountView',
        ui: {
            searchInput: '#searchShopperInput'
        },
        events: {
            'change @ui.searchInput': function(e){
                var val = $(e.currentTarget).val();
                $('#searchShopperButton').attr('href', '#admin/shopper/search/' + val);
                console.log(val);
            }
        },
        onRender: function(){
            console.log('Render shopper composite view');


            $('#paginationContainer').empty();
            $('#menuContainer').empty();



            // var paginationView = new PaginationView();
            // paginationView.render();

            var menu = new AdminMenuView();
            menu.render();

        }
    });
});
/**
 * Created by korman on 27.01.17.
 */

define([
    'marionette',
    'shopper/views/staff_management/StaffManagementItemView',
    'shopper/views/core/MenuHomeView'
], function(Marionette, StaffManagementItemView, MenuHomeView){

    return Marionette.CompositeView.extend({
        el: '#staffManagementContainer',
        childView: StaffManagementItemView,
        childViewContainer: '#staffManagementList',
        template: '#staffManagementListView',
        onRender: function(){
            console.log('Render staff management composite view');


            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var menu = new MenuHomeView();
            menu.render();

        }
    });
});
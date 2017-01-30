/**
 * Created by korman on 27.01.17.
 */

define([
    'marionette',
    'shopper/views/cash_back/CashBackConfirmItemView',
    'shopper/views/core/MenuHomeView'
], function(Marionette, CashBackConfirmItemView, MenuHomeView){

    return Marionette.CompositeView.extend({
        el: '#contentContainer',
        childView: CashBackConfirmItemView,
        childViewContainer: '#cashBackConfirmList',
        template: '#cashBackConfirmView',
        onRender: function(){
            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var menu = new MenuHomeView();
            menu.render();
        }
    });
});
/**
 * Created by korman on 27.01.17.
 */

define([
    'marionette',
    'shopper/views/cash_back/CashBackStatementItemView',
    'shopper/views/core/MenuHomeView'
], function(Marionette, CashBackStatementItemView, MenuHomeView){

    return Marionette.CompositeView.extend({
        el: '#contentContainer',
        childView: CashBackStatementItemView,
        childViewContainer: '#cashBackStatementList',
        template: '#cashBackStatementView',
        onRender: function(){
            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var menu = new MenuHomeView();
            menu.render();
        }
    });
});
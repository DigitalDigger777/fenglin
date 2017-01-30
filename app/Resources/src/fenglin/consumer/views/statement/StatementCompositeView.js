/**
 * Created by korman on 27.01.17.
 */

define([
    'marionette',
    'consumer/views/statement/StatementItemView',
    'consumer/views/core/MenuView'
], function(Marionette, StatementItemView, MenuView){

    return Marionette.CompositeView.extend({
        el: '#contentContainer',
        childView: StatementItemView,
        childViewContainer: '#statementList',
        template: '#statementListView',
        onRender: function(){
            console.log('Render statement composite view');

            $('#searchBarContainer').empty();
            $('#paginationContainer').empty();
            $('#menuContainer').empty();

            var menu = new MenuView();
            menu.render();
        }
    });
});
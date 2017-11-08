/**
 * Created by korman on 27.01.17.
 */

define([
    'marionette',
    'consumer/views/core/MenuView'
], function(Marionette, MenuView){

    return Marionette.View.extend({
        el: '#contentContainer',
        className: 'weui-panel weui-panel_access"',
        template: '#statementEmptyView',
        onRender: function(){
            console.log('Render statement');
            var menu = new MenuView();
            menu.render();
        }
    });
});
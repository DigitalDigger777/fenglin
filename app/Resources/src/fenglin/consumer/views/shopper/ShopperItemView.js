/**
 * Created by korman on 27.01.17.
 */

define([
    'marionette'
], function(Marionette){

    return Marionette.View.extend({
        tagName: 'div',
        className: 'weui-panel weui-panel_access',
        template: '#shopperItemView',
        onRender: function(){
            console.log('Render shopper item');
        }
    });
});
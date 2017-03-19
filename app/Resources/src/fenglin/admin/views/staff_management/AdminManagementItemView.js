/**
 * Created by korman on 27.01.17.
 */

define([
    'marionette'
], function(Marionette){

    return Marionette.View.extend({
        tagName: 'div',
        className: 'weui-cell',
        template: '#staffManagementItemView',
        onRender: function(){
            console.log('Render staff management item');
        }
    });
});
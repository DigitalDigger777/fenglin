/**
 * Created by korman on 27.01.17.
 */

define(['marionette'], function(Marionette){
    return Marionette.View.extend({
        el: '#errorToastContainer',
        template: '#errorToastView',
        onRender: function(){

        },
        show: function(){
            $('#errorToastContainer').fadeIn();
        },
        hide: function(){
            $('#errorToastContainer').fadeOut();
        }
    });
});
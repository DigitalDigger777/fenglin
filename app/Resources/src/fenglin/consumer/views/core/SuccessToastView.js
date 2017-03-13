/**
 * Created by korman on 27.01.17.
 */

define(['marionette'], function(Marionette){
    return Marionette.View.extend({
        el: '#successToastContainer',
        template: '#successToastView',
        onRender: function(){

        },
        show: function(){
            $('#successToastContainer').fadeIn();
        },
        hide: function(){
            $('#successToastContainer').fadeOut();
        }
    });
});
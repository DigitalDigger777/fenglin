/**
 * Created by korman on 27.01.17.
 */

define(['marionette'], function(Marionette){
    return Marionette.View.extend({
        el: '#customToastContainer',
        template: '#customToastView',
        onRender: function(){

        },
        show: function(){
            $('#customToastContainer').fadeIn();
        },
        hide: function(){
            $('#customToastContainer').fadeOut();
        }
    });
});
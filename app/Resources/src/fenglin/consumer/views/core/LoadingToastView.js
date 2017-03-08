/**
 * Created by korman on 27.01.17.
 */

define(['marionette'], function(Marionette){
    return Marionette.View.extend({
        el: '#loadToastContainer',
        template: '#loadingToastView',
        onRender: function(){

        },
        show: function(){
            $('#loadToastContainer').fadeIn();
        },
        hide: function(){
            $('#loadToastContainer').fadeOut();
        }
    });
});
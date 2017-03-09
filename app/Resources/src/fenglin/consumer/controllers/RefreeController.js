/**
 * Created by korman on 29.01.17.
 */


define([
    'consumer/views/refree/RefreeView',
    'consumer/views/refree/RefreeConfirmView'
], function(RefreeView, RefreeConfirmView){

    return {
        refreePage: function(){
            var refreeView = new RefreeView();
            refreeView.render();
        },
        confirmPage: function(){
            var confirmView = new RefreeConfirmView();
            confirmView.render();
        }
    };
});
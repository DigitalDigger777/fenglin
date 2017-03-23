/**
 * Created by korman on 29.01.17.
 */


define([
    'backbone',
    'consumer/views/refree/RefreeView',
    'consumer/views/refree/RefreeConfirmView'
], function(Backbone, RefreeView, RefreeConfirmView){

    return {
        refreePage: function(shopperId){
            var model = new Backbone.Model();
            model.set('shopperId', shopperId);

            var refreeView = new RefreeView({
                model: model
            });
            refreeView.render();
        },
        confirmPage: function(){
            var confirmView = new RefreeConfirmView();
            confirmView.render();
        }
    };
});